<?php
/*
Plugin Name: VBulletin Posts-DB
Plugin URI: http://mydomain.com
Description: Widget to retrieve VB 5.x latest posts and threads via RSS@
Author: Vlad Zaitsev
Version: 1.0
Author URI: https://github.com/Zaitsev
*/
// Block direct requests
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
define( 'VBDB_PLUGIN_FILE', __FILE__ );

include_once(__DIR__ . '/lib/emsgd.php');
register_activation_hook( __FILE__, array( 'VBulletinDB', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'VBulletinDB', 'plugin_deactivation' ) );

require_once( __DIR__ . '/lib/VBulletinDBWidget.php' );
require_once( __DIR__ . '/lib/VBulletinDB.php' );
$vbdb_db = new VBulletinDB();
add_action( 'init', array( $vbdb_db, 'init' ) );

add_action( 'widgets_init', function () {
	register_widget( 'VBulletinDBWidget' );
} );