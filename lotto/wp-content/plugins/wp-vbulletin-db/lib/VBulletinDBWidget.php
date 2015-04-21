<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Adds My_Widget widget.
 */
class VBulletinDBWidget extends WP_Widget {
	const TEXT_DOMAN = "VBDB_domain";
	const VERSION = '1.0';
	const DB_CONNECT = 'VBDB2-db';
	const OPTIONS_PAGE = 'vbdb2-settings';
	const ITEM_FILTER_BEFORE = 'vbrss2_before_item_print';

	private static $enqueue_js_done = null;
	private static $enqueue_css_done = null;

	/**
	 * @var wpdb
	 */
	private $db = null;

	/**
	 * Register widget with WordPress.
	 */
	static function reset() {
		static::$enqueue_css_done = null;
		static::$enqueue_js_done  = null;
	}

	public function minimize( $buffer ) {
//		return $buffer;
		// Remove comments
		$buffer = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer );

		// Remove space after colons
		$buffer = str_replace( ': ', ':', $buffer );

		// Remove whitespace
		$buffer = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $buffer );

		return $buffer;
	}

	public function init() {


	}

	function __construct() {

		parent::__construct(
			'VBulletinDBWidget', // Class name
			__( 'VBulletinDB postss', self::TEXT_DOMAN ), // Name
			array(
				'description' => __( 'Widget to display data from VB 5.x', self::TEXT_DOMAN ),
				'classname'   => 'vbrss2',
			) // Args
		);
		add_action( 'wp_head', array( $this, 'inline_css' ), 5 );
		$this->inline_js();
	}

	public function file_get_asset($file){
		return @file_get_contents(plugin_dir_path( __FILE__ ) . '../assets/'.$file);
	}

	public function inline_js() {
		if ( self::$enqueue_js_done ) {
			return;
		}
		$js = $this->file_get_asset( 'script.js' );
		if ( ! empty( $js ) ) {
			$this->enqueue_inline_script( 'vbrss2_js', $this->minimize( $js ), null, true );
		}
		self::$enqueue_js_done = true;
	}

	public function inline_css() {
		if ( self::$enqueue_css_done ) {
			return;
		}
		$css = $this->file_get_asset( 'style.css' );
		if ( ! empty( $css ) ) {
			echo '<style>' . $this->minimize( $css ) . '</style>';
		}
		$css = $this->file_get_asset('custom.css' );
		if ( ! empty( $css ) ) {
			echo '<style>' . $this->minimize( $css ) . '</style>';
		}
		wp_enqueue_style( 'dashicons' );
		self::$enqueue_css_done = true;
	}

	public function getForumURL( $instance ) {
		return untrailingslashit( preg_replace( '/\?.*/', '', $instance['forum_url'] ) );
	}

	public function enqueue_css() {
		if ( self::$enqueue_css_done ) {
			return;
		}
		$css_file = plugin_dir_url( __FILE__ ) . '../assets/style.css';
		wp_enqueue_style( 'vbrss2_style', $css_file, array( 'dashicons' ), self::VERSION );
		self::$enqueue_css_done = true;
	}


	public function printThreads( $rss_items, $instance ) {

		$date_format = empty( $instance['date_format'] ) ? get_option( 'date_format' ) : $instance['date_format'];

		foreach ( $rss_items as $post ) {
			$item              = new stdClass();
			$item->forum_link  = esc_url( strip_tags( $post->url ) );
			$item->forum_title = esc_html( trim( strip_tags( $post->forum_title ) ) );

			$item->link  = esc_url( strip_tags( $post->url ) );
			$item->title = esc_html( trim( strip_tags( $post->title ) ) );
			if ( empty( $item->title ) ) {
				$item->title = __( 'Untitled', self::TEXT_DOMAN );
			}
			$item->desc = @html_entity_decode( $post->description, ENT_QUOTES, get_option( 'blog_charset' ) );
			$item->desc = esc_attr( wp_trim_words( $item->desc, 10, '&nbsp;&hellip;' ) );

			$item->date = date_i18n( $date_format, $post->last_edit );

			$item->author  = esc_html( strip_tags( $post->authorname ) );
			$item->avatar  = esc_url( strip_tags( $post->avatar ) );
			$item->views   = intval( $post->views );
			$item->replies = intval( $post->replies );
			$this->print_item( $item );
		}
	}

	public function print_item( $item ) {
		$item  = apply_filters(self::ITEM_FILTER_BEFORE,$item);
		?>
		<li class="vbrss2_item">
			<div class="vbrss2_item_avatar"><img src="<?= $item->avatar ?>"></div>
			<div class="vbrss2_item_title"><a target="_blank" href="<?= $item->link ?>"><?php echo $item->title ?></a>
			</div>
			<div class="vbrss2_item_name"><span
					class="dashicons dashicons-admin-users"></span><?php echo $item->author ?>
			</div>
			<div class="vbrss2_item_desc"><span
					class="dashicons dashicons-admin-comments"></span><?php echo $item->desc ?></div>
			<div class="vbrss2_item_date"><span
					class="dashicons dashicons-calendar-alt"></span>
				<?php echo $item->date ?> | <?php echo $item->views ?> views, <?php echo $item->replies ?> replies
			</div>
			<div class="vbrss2_item_forum"><span class="dashicons dashicons-category"></span>
				<a target="_blank"
				   href="<?= $item->forum_link ?>"><?php echo $item->forum_title ?></a>
			</div>
		</li>
	<?
	}

	private function _ul_query( $instance, $order ) {
		$transient = 'vbrss2_' . $this->id . '_' . $order;

		if ( ( $instance['cache'] == 0 ) || ( false === ( $result = get_transient( $transient ) ) ) ) {
			$max_items = (int) $instance['max_items'];
			$where     = ' 1=1 ';
			$where .= empty( $instance['nodeids'] ) ? '' : " and p.nodeid in ( {$instance['nodeids']} ) ";
			$url    = $this->getForumURL( $instance );
			$sSQL   = "
					SELECT
					  p.title AS forum_title,
					  n.lastupdate AS last_edit,
					  n.lastcontent AS last_reply,
					  n.parentid,
					  n.nodeid AS thread,
					  v.count AS views,
					  n.textcount AS replies,
					  n.title,
					  n.description,
					  r.prefix AS forum_url,
					  n.authorname,
  					  CONCAT('{$url}/',r.prefix) AS forum_url,
					  CONCAT('{$url}/',r.prefix,'/',n.nodeid,'-',n.urlident) as url,
					  CONCAT('{$url}/core/image.php?userid=',n.userid,'&thumb=1&dateline',customavatar.dateline)  AS avatar

					FROM node AS n
		              JOIN node AS p ON (n.parentid = p.nodeid)
					  JOIN routenew r ON (r.routeid = n.routeid)
					  JOIN nodeview v on (n.nodeid = v.nodeid)
					  LEFT JOIN customavatar AS customavatar
					    ON (customavatar.userid = n.userid)
					WHERE n.starter != 0
					AND n.htmltitle != ''
					AND $where

					ORDER BY {$order} DESC LIMIT {$max_items} -- newest
							";
			$result = $this->db->get_results( $sSQL );
			set_transient( $transient, $result, 10 );
		}

		return $result;
	}

	public function getLatestThreads( $instance ) {
		return $this->_ul_query( $instance, 'n.lastupdate' );
	}

	public function getMostRepliedThreads( $instance ) {
		return $this->_ul_query( $instance, 'n.textcount' );
	}

	public function getMostViewedThreads( $instance ) {
		return $this->_ul_query( $instance, 'v.count' );
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		global $wpdb;
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		$dbs = get_option( self::DB_CONNECT );
		foreach ( $dbs as $db ) {
			if ( $db['conn'] === $instance['conn'] ) {
				if ( $db['user'] == $wpdb->dbuser &&
				     $db['pass'] == $wpdb->dbpassword &&
				     $db['db'] == $wpdb->dbname &&
				     $db['host'] == $wpdb->dbhost
				) {
					$this->db = &$wpdb;
				} else {
					$this->db = new wpdb( $db['user'], $db['pass'], $db['db'], $db['host'] );
				}
				$instance['cache'] = (int) $db['cache'];
				break;
			}
		}
//		var_dump($instance);
		if ( $this->db === null ) {
			echo __( "No results found", self::TEXT_DOMAN );
			echo $args['after_widget'];

			return;
		}
		?>
		<div class="vbrss2_container">
			<ul class="vbrss2_tabs ">
				<li class="vbrss2_tab vbrss2_active"><?= $instance['newest_title'] ?></li>
				<li class="vbrss2_tab"><?= $instance['viewed_title'] ?></li>
				<li class="vbrss2_tab"><?= $instance['replied_title'] ?></li>
			</ul>
			<ul class="vbrss2_items vbrss2_active">
				<?
				$this->printThreads( $this->getLatestThreads( $instance ), $instance );
				?>
			</ul>
			<ul class="vbrss2_items">
				<?
				$this->printThreads( $this->getMostViewedThreads( $instance ), $instance );
				?>
			</ul>
			<ul class="vbrss2_items">
				<?
				$this->printThreads( $this->getMostRepliedThreads( $instance ), $instance );
				?>
			</ul>
		</div>
		<?




		echo $args['after_widget'];
	}


	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$cons = get_option( self::DB_CONNECT );

		$title         = ( isset( $instance['title'] ) ) ? $instance['title'] : __( 'Latest threads and posts', self::TEXT_DOMAN );
		$newest_title  = ( isset( $instance['newest_ttitle'] ) ) ? $instance['newest_title'] : __( 'Newest', self::TEXT_DOMAN );
		$viewed_title  = ( isset( $instance['viewed_itle'] ) ) ? $instance['viewed_title'] : __( 'Most viewed', self::TEXT_DOMAN );
		$replied_title = ( isset( $instance['replied_title'] ) ) ? $instance['replied_title'] : __( 'Most replied', self::TEXT_DOMAN );
		$conn          = ( isset( $instance['conn'] ) ) ? $instance['conn'] : '';
		$max_items     = ( isset( $instance['max_items'] ) ) ? $instance['max_items'] : '5';
		$nodeids       = ( isset( $instance['nodeids'] ) ) ? $instance['nodeids'] : '';
		$date_format   = ( isset( $instance['date_format'] ) ) ? $instance['date_format'] : '';
		$inline_js_css = ( isset( $instance['inline_js_css'] ) ) ? $instance['inline_js_css'] : 1;
		$forum_url     = ( isset( $instance['forum_url'] ) ) ? $instance['forum_url'] : 'http://';

		?>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', self::TEXT_DOMAN ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'newest_title' ); ?>"><?php _e( 'Newest title:', self::TEXT_DOMAN ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'newest_title' ); ?>"
			       name="<?php echo $this->get_field_name( 'newest_title' ); ?>" type="text"
			       value="<?php echo esc_attr( $newest_title ); ?>">
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'viewed_title' ); ?>"><?php _e( 'Most viewed title:', self::TEXT_DOMAN ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'viewed_title' ); ?>"
			       name="<?php echo $this->get_field_name( 'viewed_title' ); ?>"
			       type="text"
			       value="<?php echo esc_attr( $viewed_title ); ?>">
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'replied_title' ); ?>"><?php _e( 'Most replied title:', self::TEXT_DOMAN ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'replied_title' ); ?>"
			       name="<?php echo $this->get_field_name( 'replied_title' ); ?>"
			       type="text"
			       value="<?php echo esc_attr( $replied_title ); ?>">
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'conn' ); ?>"><?php _e( 'Forum connection:', self::TEXT_DOMAN ); ?></label>
			<select required class="widefat" id="<?php echo $this->get_field_id( 'conn' ); ?>"
			        name="<?php echo $this->get_field_name( 'conn' ); ?>" type="text"
			        value="<?php echo esc_attr( $conn ); ?>">
				<option value=""><?= __( 'Select connection', self::TEXT_DOMAN ) ?></option>
				<?
				foreach ( $cons as $c ) {
					?>
					<option <?= $conn == $c['conn'] ? 'selected' : '' ?>
						value="<?= $c['conn'] ?>"><?= $c['conn'] ?></option>
				<?
				}
				?>
			</select>
			<small>setup connections in <a href="<?= admin_url( "options-general.php?page=" . self::OPTIONS_PAGE ) ?>">Settings
					page</a>
			</small>
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'forum_url' ); ?>"><?php _e( 'Forum base URL:', self::TEXT_DOMAN ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'forum_url' ); ?>"
			       name="<?php echo $this->get_field_name( 'forum_url' ); ?>"
			       type="text"
			       value="<?php echo esc_attr( $forum_url ); ?>">
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'max_items' ); ?>"><?php _e( 'Number of items to show: ', self::TEXT_DOMAN ); ?></label>
			<input name="<?php echo $this->get_field_name( 'max_items' ); ?>" type="text"
			       value="<?php echo esc_attr( $max_items ); ?>"
			       size="3">
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'nodeids' ); ?>"><?php _e( 'Forums filter:', self::TEXT_DOMAN ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'nodeids' ); ?>"
			       name="<?php echo $this->get_field_name( 'nodeids' ); ?>" type="text"
			       value="<?php echo esc_attr( $nodeids ); ?>">
			<small>list of specific forums IDs to display, comma separated. Leave empty for all</small>
		</p>
		<hr>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'date_format' ); ?>"><?php _e( 'Date format: ', self::TEXT_DOMAN ); ?></label>
			<input name="<?php echo $this->get_field_name( 'date_format' ); ?>" type="text"
			       value="<?php echo( $date_format ); ?>"
			       size="5">
			<br>
			<small>Leave blank to use blog General Settings. <a
					href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">Documentation on date and
					time formatting.</a></small>
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'inline_js_css' ); ?>"><?php _e( 'Inline JS and CSS files', self::TEXT_DOMAN ); ?></label>
			<input name="<?php echo $this->get_field_name( 'inline_js_css' ); ?>" type="checkbox"
			       value="1" <?echo( $inline_js_css ? 'checked' : '' ) ?> >
			<br>
			<small>widget has small CSS and JS resources. Its often better to inline them than load as separate files
			</small>
		</p>
		<p class="notice notice-warning">
			For using this widget you must provide direct access to VBulletin forum Database.
		</p>
	<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                  = array();
		$instance['title']         = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['conn']          = ( ! empty( $new_instance['conn'] ) ) ? strip_tags( $new_instance['conn'] ) : '';
		$instance['newest_title']  = ( ! empty( $new_instance['newest_title'] ) ) ? strip_tags( $new_instance['newest_title'] ) : '';
		$instance['viewed_title']  = ( ! empty( $new_instance['viewed_title'] ) ) ? strip_tags( $new_instance['viewed_title'] ) : '';
		$instance['replied_title'] = ( ! empty( $new_instance['replied_title'] ) ) ? strip_tags( $new_instance['replied_title'] ) : '';
		$nodeids                   = ( ! empty( $new_instance['nodeids'] ) ) ? strip_tags( $new_instance['nodeids'] ) : '';
		$instance['max_items']     = ( ! empty( $new_instance['max_items'] ) ) ? intval( $new_instance['max_items'] ) : '5';
		$instance['date_format']   = ( ! empty( $new_instance['date_format'] ) ) ? strip_tags( $new_instance['date_format'] ) : '';
		$instance['inline_js_css'] = ( ! empty( $new_instance['inline_js_css'] ) ) ? 1 : 0;
		$instance['forum_url']     = ( ! empty( $new_instance['forum_url'] ) ) ? preg_replace( '/\?.*/', '', strip_tags( $new_instance['forum_url'] ) ) : '';
		if ( ! empty( $nodeids ) ) {
			$n = array_map( function ( $val ) {
				return intval( $val );
			}, explode( ',', $nodeids ) );
			$n = array_unique( $n );
			sort( $n );
			$instance['nodeids'] = implode( ',', $n );
		} else {
			$instance['nodeids'] = '';
		}

		return $instance;
	}

	/* ------------------------------------------- */
	/**
	 * Enqueue inline Javascript. @see wp_enqueue_script().
	 *
	 * KNOWN BUG: Inline scripts cannot be enqueued before
	 *  any inline scripts it depends on, (unless they are
	 *  placed in header, and the dependant in footer).
	 *
	 * @param string $handle Identifying name for script
	 * @param string $src The JavaScript code
	 * @param array $deps (optional) Array of script names on which this script depends
	 * @param bool $in_footer (optional) Whether to enqueue the script before </head> or before </body>
	 *
	 * @return null
	 */
	function enqueue_inline_script( $handle, $js, $deps = array(), $in_footer = false ) {
		// Callback for printing inline script.
		$cb = function () use ( $handle, $js ) {
			// Ensure script is only included once.
			if ( wp_script_is( $handle, 'done' ) ) {
				return;
			}
			// Print script & mark it as included.
			echo "<script type=\"text/javascript\" id=\"js-$handle\">\n$js\n</script>\n";
			global $wp_scripts;
			$wp_scripts->done[] = $handle;
		};
		// (`wp_print_scripts` is called in header and footer, but $cb has re-inclusion protection.)
		$hook = $in_footer ? 'wp_print_footer_scripts' : 'wp_print_scripts';

		// If no dependencies, simply hook into header or footer.
		if ( empty( $deps ) ) {
			add_action( $hook, $cb );

			return;
		}

		// Delay printing script until all dependencies have been included.
		$cb_maybe = function () use ( $deps, $in_footer, $cb, &$cb_maybe ) {
			foreach ( $deps as &$dep ) {
				if ( ! wp_script_is( $dep, 'done' ) ) {
					// Dependencies not included in head, try again in footer.
					if ( ! $in_footer ) {
						add_action( 'wp_print_footer_scripts', $cb_maybe, 11 );
					} else {
						// Dependencies were not included in `wp_head` or `wp_footer`.
					}

					return;
				}
			}
			call_user_func( $cb );
		};
		add_action( $hook, $cb_maybe, 0 );
	}

} // class My_Widget