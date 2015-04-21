<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class VBulletinDB {
	const TEXT_DOMAN = "VBDB_domain";
	const VERSION = '1.0';
	const OPTIONS_PAGE = 'vbdb2-settings';

	const DB_CONNECT = 'VBDB2-db';
	const DB_SETTINGS_GROUP = 'VBDB2-db-settings-group';
	const AJAX_ACTION = 'vbdb2_test_db';


	private static $initiated = false;

	public function __construct() {
//		$this->init();
	}

	public function init() {
		if ( is_admin() && ! self::$initiated ) {
			self::$initiated = true;
			$this->init_hooks();
		}
	}

	public static function tearDown() {
		if ( ! defined( 'UNIT_TESTING' ) ) {
			return;
		}
		self::$initiated = false;
	}

	public function init_hooks() {
		add_action( 'admin_menu', array( $this, 'admin_menu_action' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'wp_ajax_' . self::AJAX_ACTION, array( $this, 'ajax_db_test_callback' ) );
	}

	public function plugin_activation() {
		add_option( self::DB_CONNECT, array(), '', 'no' );
	}

	public function admin_menu_action() {
		add_options_page( 'VBulletin latest posts over DB', 'VBulletin DB settings', 'manage_options', self::OPTIONS_PAGE, array(
			$this,
			'add_options_page'
		) );
	}

	public function register_settings() {
		register_setting( self::DB_SETTINGS_GROUP, self::DB_CONNECT, array( $this, 'sanitize_db_connections' ) );
	}

	public function sanitize_db_connections( $val ) {
		$ret = array();
		foreach ( $val as $i => $v ) {
			if ( empty( $v['conn'] ) ) {
				continue;
			}
			$v['cache'] = (int) $v['cache'];
			$ret[ $i ]  = $v;
		}

		return $ret;
	}

	public function ajax_db_test_callback() {
		global $wpdb;
		/**
		 * @var $wpdb wpdb
		 * @var $myvbdb wpdb
		 */
		$db = $_REQUEST['db'];
		if ( $db['user'] == $wpdb->dbuser &&
		     $db['pass'] == $wpdb->dbpassword &&
		     $db['db'] == $wpdb->dbname &&
		     $db['host'] == $wpdb->dbhost
		) {
			$myvbdb = &$wpdb;
		} else {
			$myvbdb = new wpdb( $db['user'], $db['pass'], $db['db'], $db['host'] );
		}
		//if we cant connect, WP will die
		/**
		 * @var  $myvbdb ->error WP_Error
		 */
		if ( null !== $myvbdb->error ) {

			wp_die( '<h1>DB ' . $db['conn'] . ': connection error</h1>' );
		}
		//try selects
		$tetTablesExist = "
SELECT
  FROM_UNIXTIME(n.lastupdate) AS last_edit
,FROM_UNIXTIME(n.lastcontent) AS last_reply
  ,n.nodeid AS thread
  ,v.count AS views
  ,n.textcount AS replies
  ,n.title
  ,n.DESCRIPTION
  ,CONCAT(r.prefix,'/',n.nodeid,'-',n.urlident) AS url
  ,CONCAT ('/core/image.php?userid=',n.userid,'&thumb=1&dateline',customavatar.dateline)

FROM node AS n
  JOIN routenew r ON (r.routeid = n.routeid)
  JOIN nodeview v ON (n.nodeid = v.nodeid)
  LEFT JOIN customavatar AS customavatar
    ON (customavatar.userid = n.userid)
WHERE starter != 0
AND htmltitle != ''
ORDER BY n.textcount DESC LIMIT 1  -- most replied
		";
		//$myvbdb->show_errors();
		$res = $myvbdb->query( $tetTablesExist );
		if ( '' !== $myvbdb->last_error ) {
			wp_die( '<h1>DB  ' . $db['conn'] . ': Query error</h1>May be your db does not contain VBulletin or its version is wrong<br><code>' . $myvbdb->last_error . '</code>' );
		}
		echo "<h1>Succes</h1>";

		wp_die();
	}

	public function add_options_page() {
		global $wpdb;
		/**
		 * @var $wpdb wpdb
		 */
		$options = get_option( self::DB_CONNECT, array() );
		// re-use database connection if it's the same as wordpress
		if ( empty( $options ) ) {
			$def_db_user     = $wpdb->dbuser;
			$def_db_password = $wpdb->dbpassword;
			$def_db_name     = $wpdb->dbname;
			$def_db_host     = $wpdb->dbhost;
			$def_db_cache    = 60 * 60 * 2;
			$def_con         = "This WP database";
		} else {

			$def_db_cache = $def_con = $def_db_user = $def_db_password = $def_db_name = $def_db_host = '';

		}

		require_once( plugin_dir_path( VBDB_PLUGIN_FILE ) . '/lib/option-page.php' );
	}
}