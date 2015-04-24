<?
/*
Plugin Name: VBulletin ExtData
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
define( 'VBRSS2_MYPLUGIN_FILE', __FILE__ );
require_once( __DIR__ . '/lib/VBulletinExtData.php' );
add_action( 'widgets_init', function () {
	register_widget( 'VBulletinExtData' );
} );