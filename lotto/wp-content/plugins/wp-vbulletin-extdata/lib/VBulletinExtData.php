<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Adds My_Widget widget.
 */
class VBulletinExtData extends WP_Widget {
	const TEXT_DOMAN = "VBRSS2_domain";
	const VERSION = '1.0';

	private static $enqueue_js_done = null;
	private static $enqueue_css_done = null;

	/**
	 * Register widget with WordPress.
	 */
	static function reset(){
		static::$enqueue_css_done = null;
		static::$enqueue_js_done = null;
	}
	public function parent__construct($clas,$name,$args){
		parent::__construct(
			$clas, // Class name
			$name, // Name
			$args // Args
		);
	}
	public static function get_instances(){
		return parent::get_settings();
	}

	function __construct() {


		parent::__construct(
			'VBulletinExtData', // Class name
			__( 'VBulletin RSS2', self::TEXT_DOMAN ), // Name
			array(
				'description' => __( 'Widget to display RSS2 data from VB 5.x', self::TEXT_DOMAN ),
				'class'       => __CLASS__,
			) // Args
		);
		//if we have at least 1 inline_js_css,  inline them else enqueue
		$instanses = $this->get_settings();
//		emsgd($instanses);
		$inline = false;
		foreach ( $instanses as $i ) {
			if ( ! empty( $i['inline_js_css'] ) && $i['inline_js_css'] == 1 ) {
				$inline = true;
			}
		}
		if ( $inline ) {
			add_action( 'wp_head', array( $this, 'inline_css' ), 5 );
		} else {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_css' ),6);
		}
	}

	public  function inline_css() {

		if ( self::$enqueue_css_done ) {
			return;
		}
		$css_file = plugin_dir_path( VBRSS2_MYPLUGIN_FILE ) . 'assets/style.css';
		$css      = @file_get_contents( $css_file );
//		emsgd($css);
		if ( ! empty( $css ) ) {
			echo '<style>' . $css . '</style>';
		}
		self::$enqueue_css_done = true;
	}

	public  function enqueue_css() {
		if ( self::$enqueue_css_done ) {
			return;
		}
		$css_file = plugin_dir_url( VBRSS2_MYPLUGIN_FILE ) . 'assets/style.css';
		wp_register_style( 'vbrss2_style', $css_file, self::VERSION );
		wp_enqueue_style( 'vbrss2_style' );
		self::$enqueue_css_done = true;
	}

	public function getThreadsURL( $instance ) {
		$nodeid      = $instance['nodeids'];
		$count       = $instance['max_items'];
		$threads_url = untrailingslashit( preg_replace('/\?.*/', '',$instance['threads_url']) );

		return "$threads_url?type=rss2&nodeid=$nodeid&count=$count";
	}

	public function getPostsURL( $instance ) {
		return $this->getThreadsURL( $instance ) . "&lastpost=1";
	}


	private function print_threads_feed( $url, $instance,$what='treads' ) {
		/**
		 * @var $post SimplePie_Item
		 */


		$rss_items = array();
		$rss       = fetch_feed( $url );
		if ( ! is_wp_error( $rss ) ) {
			$rss_items = $rss->get_items( 0, $rss->get_item_quantity( $instance['max_items'] ) );
		}

		if ( ! count( $rss_items ) ) {
			echo __( 'No new items found', self::TEXT_DOMAN );
			$rss->__destruct();
			unset( $rss );

			return;
		}
		$date_format = empty( $instance['date_format'] ) ? get_option( 'date_format' ) : $instance['date_format'];
		foreach ( $rss_items as $post ) {
			$forum      = $post->get_category();
			$forum_link = $forum->get_scheme();
			while ( stristr( $forum_link, 'http' ) != $forum_link ) {
				$forum_link = substr( $forum_link, 1 );
			}
			$forum_link  = esc_url( strip_tags( $forum_link ) );
			$forum_title = esc_html( trim( strip_tags( $forum->get_term() ) ) );

			$link = $post->get_link();
			while ( stristr( $link, 'http' ) != $link ) {
				$link = substr( $link, 1 );
			}
			$link = esc_url( strip_tags( $link ) );


			$title = esc_html( trim( strip_tags( $post->get_title() ) ) );
			if ( empty( $title ) ) {
				$title = __( 'Untitled', self::TEXT_DOMAN );
			}
			$desc = @html_entity_decode( $post->get_description(), ENT_QUOTES, get_option( 'blog_charset' ) );
			$desc = esc_attr( wp_trim_words( $desc, 10, ' &hellip;' ) );


			$date = $post->get_date( 'U' );
			if ( $date ) {
				$date = date_i18n( $date_format, $date );
			}
			$author = $post->get_author();
			if ( is_object( $author ) ) {
				$author = esc_html( strip_tags( $author->get_name() ) );
			}
			?>
			<li class="vbrss2_item">
			    <div class="vbrss2_item_title"><a target="_blank" href="<?= $link ?>"><?php echo $title ?></a></div>
				<div class="vbrss2_item_name"><?php echo $author ?></div>
				<div class="vbrss2_item_desc"><?php echo $desc ?></div>
				<div class="vbrss2_item_date"><?php echo $date ?></div>
				<div class="vbrss2_item_forum"><a target="_blank" href="<?= $forum_link ?>"><?php echo $forum_title ?></a></div>
			</li>
		<?
		}
		$rss->__destruct();
		unset( $rss );
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
//		emsgd('here');
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		?>

		<script>
			(function () {
				var vbrss2_switchtab = function (e) {
					var cls = this.classList;
					if ((e.target.classList.contains('vbrss2_posts_tab') && cls.contains('vbrss2_active_p'))
						|| (e.target.classList.contains('vbrss2_threads_tab') && cls.contains('vbrss2_active_t'))
					) {
						return;
					}
					cls.toggle('vbrss2_active_t');
					cls.toggle('vbrss2_active_p');
				};
				var vbrss_init = function () {
					var tabcontrols = document.querySelectorAll('.vbrss2_tabs');
					var len = tabcontrols.length;
					for (var i = 0; i < len; i++) {
						tabcontrols[i].addEventListener('click', vbrss2_switchtab);
					}

				};
				window.addEventListener('load', vbrss_init);
			})();
		</script>
		<style>

		</style>
		<div class="vbrss2_container">
			<div class="vbrss2_tabs vbrss2_active_t">
				<h3 class="vbrss2_threads_tab"><?= $instance['threads_title'] ?></h3>
				<h3 class="vbrss2_posts_tab"><?= $instance['posts_title'] ?></h3>
			</div>
			<ul class="vbrss2_threads_items">
				<?
				$this->print_threads_feed( $this->getThreadsURL( $instance ), $instance );

				?>
			</ul>
			<ul class="vbrss2_posts_items">
				<?
				$this->print_threads_feed( $this->getPostsURL( $instance ), $instance );
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
		$title         = ( isset( $instance['title'] ) ) ? $instance['title'] : __( 'Latest threads and posts', self::TEXT_DOMAN );
		$threads_title = ( isset( $instance['threads_title'] ) ) ? $instance['threads_title'] : __( 'Threads', self::TEXT_DOMAN );
		$posts_title   = ( isset( $instance['posts_title'] ) ) ? $instance['posts_title'] : __( 'Posts', self::TEXT_DOMAN );
		$threads_url   = ( isset( $instance['threads_url'] ) ) ? $instance['threads_url'] : 'http://';
		$max_items     = ( isset( $instance['max_items'] ) ) ? $instance['max_items'] : '5';
		$nodeids       = ( isset( $instance['nodeids'] ) ) ? $instance['nodeids'] : '';
		$date_format   = ( isset( $instance['date_format'] ) ) ? $instance['date_format'] : '';
		$inline_js_css = ( isset( $instance['inline_js_css'] ) ) ? $instance['inline_js_css'] : 1;

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
				for="<?php echo $this->get_field_id( 'threads_title' ); ?>"><?php _e( 'Threads title:', self::TEXT_DOMAN ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'threads_title' ); ?>"
			       name="<?php echo $this->get_field_name( 'threads_title' ); ?>" type="text"
			       value="<?php echo esc_attr( $threads_title ); ?>">
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'posts_title' ); ?>"><?php _e( 'Posts title:', self::TEXT_DOMAN ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'posts_title' ); ?>"
			       name="<?php echo $this->get_field_name( 'posts_title' ); ?>"
			       type="text"
			       value="<?php echo esc_attr( $posts_title ); ?>">
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'threads_url' ); ?>"><?php _e( 'Forum RSS2 URL:', self::TEXT_DOMAN ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'threads_url' ); ?>"
			       name="<?php echo $this->get_field_name( 'threads_url' ); ?>" type="text"
			       value="<?php echo esc_attr( $threads_url ); ?>">
			<small><em>ex: http://www.example.com/forum/external</em>, Please read <a
					href="https://www.vbulletin.com/docs/html/vboptions_group_external" target="_blank">this</a> manual
				<br>for latest VB remove <em>.php</em> fom URL
			</small>
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
			<small>
				For using this widget you must enable external data provider on target VBulletin forum. Fore more info
				read <a href="https://www.vbulletin.com/docs/html/vboptions_group_external" target="_blank">VB External
					Data Provider</a> manual
			</small>
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
		$instance['threads_url']   = ( ! empty( $new_instance['threads_url'] ) ) ? preg_replace('/\?.*/', '',strip_tags( $new_instance['threads_url'] )) : '';
		$instance['threads_title'] = ( ! empty( $new_instance['threads_title'] ) ) ? strip_tags( $new_instance['threads_title'] ) : '';
		$instance['posts_title']   = ( ! empty( $new_instance['posts_title'] ) ) ? strip_tags( $new_instance['posts_title'] ) : '';
		$nodeids                   = ( ! empty( $new_instance['nodeids'] ) ) ? strip_tags( $new_instance['nodeids'] ) : '';
		$instance['max_items']     = ( ! empty( $new_instance['max_items'] ) ) ? intval( $new_instance['max_items'] ) : '5';
		$instance['date_format']   = ( ! empty( $new_instance['date_format'] ) ) ? strip_tags( $new_instance['date_format'] ) : '';
		$instance['inline_js_css'] = ( ! empty( $new_instance['inline_js_css'] ) ) ? 1 : 0;
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