<?php

/**
 * @package Akismet
 */
/*
  Plugin Name: vBulletin lateset threads comments - WordPress Plugin
  Plugin URI: http://thearfan.com/wordpress/vbulletin-latest-threads-comment-plugin-for-wordpress/
  Description: vBulletin Latest Threads and comments plugin for WordPress is a great plugin for wordpress and vBulletin5.x users. This plugin hooks into a vBulletin database and displays vBulletin threads and comments in a WordPress sidebar widget.
  Version: 0.1
  Author: Arfan
  Author URI: http://thearfan.com/
 */

// Make sure we don't expose any info if called directly
include_once('vbulletin_widget.php');
include_once('MyVBXP.php');

$myVBXPVar = new MyVBXP();
register_activation_hook('mybbxp.php', array($myVBXPVar, 'activation_hook'));

add_action('shutdown', array($myVBXPVar, 'shutdown_action'));
add_action('admin_menu', array($myVBXPVar, 'admin_menu_action'));

add_action('widgets_init', create_function('', 'register_widget("vb_latest_threads");'));
?>