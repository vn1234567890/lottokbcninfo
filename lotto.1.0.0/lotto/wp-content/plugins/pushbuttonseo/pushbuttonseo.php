<?php

/**
 * Plugin Name: PushButtonSEO
 * Plugin URI: http://pushbuttonseo.com/
 * Description: PushButtonSEO content generation and optimization suite.
 * Author: Brian G. Johnson/ Daniel Ramdenee
 * Author URI: http://pushbuttonseo.com/
 * Version: 1.1.0
 * License: Copyright 2011-2012 Brian G. Johnson, Daniel Ramdenee, all rights reserved.
 */

/**
 * Credits:
 * PorterStemming Class
 * Copyright (c)2005 Richard Heyes (http://www.phpguru.org/)
 * UTF8 Library
 * 2006/02/28 harryf (no address provided)
 */

/**
 * Global performance profiler
 */
$pbseo_mem = array();

if ( ( defined( "DOING_AUTOSAVE" ) ) || ( defined( "DOING_CRON" ) ) ) {
	return;
}
require 'pbseo-const.php';
require 'pbseo-search.php';
// require 'pbseo-functions-shared.php';
if ( is_admin() ) {
	require 'pbseo-wrappers-php.php';
	require 'pbseo-wrappers-wp.php';
	require 'pbseo-functions.php';
	require 'pbseo-functions-wp.php';
	require 'pbseo-strings.php';
	require 'pbseo-utf8.php';
	require 'pbseo-settings.php';
	require 'pbseo-meta.php';
	require 'pbseo-mod-optimizer.php';
	require 'pbseo-mod-links.php';
	require 'pbseo-mod-content.php';
	if ( FALSE === ( require 'pbseo-derived-const.php' ) ) {
		return FALSE;
	};
}
require 'pbseo-service.php';

/**
 * Register activation and deactivation hooks
 */
register_activation_hook( __FILE__, 'pbseo_wp_activate' );
register_deactivation_hook( __FILE__, 'pbseo_wp_deactivate' );

/**
 * Wrappers for activation and deactivation
 */
function pbseo_wp_activate() {
	pbseo_plugin_activate();
}
function pbseo_wp_deactivate() {
	pbseo_plugin_deactivate();
}

?>