<?php define( "pb1l1j", pb1O1j() );
if ( FALSE_BOOL_DEFINE === pb1l1j ) {
	trigger_error( PushButtonSEO_DEFINE . " error - Wordpress required to run this plugin", E_USER_ERROR );

	return FALSE_BOOL_DEFINE;
}
define( "plugin_dir_path_DEFINE", plugin_dir_path_wrapper() );
if ( FALSE_BOOL_DEFINE === plugin_dir_path_DEFINE ) {
	trigger_error( PushButtonSEO_DEFINE . " error - Wordpress plugin path not detected", E_USER_ERROR );

	return FALSE_BOOL_DEFINE;
}
define( "pb1l1l", pb1O1l() );
if ( FALSE_BOOL_DEFINE === pb1l1l ) {
	trigger_error( PushButtonSEO_DEFINE . " error - Wordpress plugin URL not detected", E_USER_ERROR );

	return FALSE_BOOL_DEFINE;
}
load_plugin_textdomain( PluginTextDomain_DEFINE, FALSE_BOOL_DEFINE, dirname( plugin_basename( __FILE__ ) ) . "/languages" );
define( "pb1l1m", pb1O1m() );
if ( FALSE_BOOL_DEFINE === pb1l1m ) {
	write_log( __( "Wordpress version 3.0 or higher required", PluginTextDomain_DEFINE ) );

	return FALSE_BOOL_DEFINE;
}
if ( function_exists_wrapper( "get_bloginfo" ) ) {
	$pb1l1o = get_bloginfo( "charset" );
	if ( ( $pb1l1o != "UTF-8" ) && ( $pb1l1o != "UTF8" ) && ( $pb1l1o != "utf-8" ) && ( $pb1l1o != "utf8" ) ) {
		define( "pb1O1o", $pb1l1o );
	} else {
		define( "pb1O1o", "UTF-8" );
	}
}
$pb1l1p = array( "EN" => "EN-EN-US", "DE" => "DE-DE-DE", "FR" => "FR-FR-FR", "ES" => "ES-ES-ES" );
if ( defined( "WPLANG" ) ) {
	$pb1O1p = pb1l1q( pb1O1q( WPLANG, 0, 2 ) );
	if ( array_key_exists( $pb1O1p, $pb1l1p ) ) {
		define( "pb1l1r", $pb1O1p );
	}
}
if ( ! defined( "pb1l1r" ) ) {
	define( "pb1l1r", "EN" );
}
unset ( $pb1O1p );
$pb1O1r = get_option_wrapper( pbseo_opt_DEFINE . "content_region" );
if ( ! empty( $pb1O1r ) ) {
	$pb1O1r = trim_wrapper( $pb1O1r );
	if ( TRUE_BOOL_DEFINE !== pb1l1t( $pb1O1r ) ) {
		define( "pb1O1t", $pb1l1p[ pb1l1r ] );
	} else {
		define( "pb1O1t", $pb1O1r );
	}
} else {
	define( "pb1O1t", $pb1l1p[ pb1l1r ] );
}
define( "pb1l1u", pb1O1q( pb1O1t, 0, 2 ) );
define( "pb1O1u", pb1O1q( pb1O1t, 3, 2 ) );
define( "pb1l1v", pb1O1q( pb1O1t, 6, 2 ) );
unset ( $pb1l1p, $pb1O1r );
$pb1O1v = array();
if ( @preg_match( '/^.{1}$/u', "ñ", $pb1O1v ) != 1 ) {
	write_log( __( "PCRE is not compiled with UTF-8 support", PluginTextDomain_DEFINE ) );
	define( "pb1l1w", FALSE_BOOL_DEFINE );
} else {
	define( "pb1l1w", TRUE_BOOL_DEFINE );
}
unset ( $pb1O1v );
$pb1O1w = @ini_get( "safe_mode" );
$pb1l1x = @ini_get( "open_basedir" );
if ( ! pb1O1x( $pb1O1w ) ) {
	define( "pb1l1y", TRUE_BOOL_DEFINE );
} else {
	define( "pb1l1y", FALSE_BOOL_DEFINE );
}
if ( ! pb1O1x( $pb1l1x ) ) {
	define( "pb1O1y", TRUE_BOOL_DEFINE );
} else {
	define( "pb1O1y", FALSE_BOOL_DEFINE );
}
define( "pb1l1z", pb1O1z() );
define( "pb1l20", pb1O20() );
define( "pb1l21", pb1O21() );
define( "pb1l22", pb1O22() );
define( "pb1l23", pb1O23() );
define( "pb1l24", pb1Ob );
define( "pb1O24", pb1Ob . "-training-and-support" );
define( "pb1l25", __( "Reserved", PluginTextDomain_DEFINE ) );
define( "pb1O25", __( "Links", PluginTextDomain_DEFINE ) );
define( "pb1l26", __( "Content", PluginTextDomain_DEFINE ) );
define( "pb1O26", __( "Video", PluginTextDomain_DEFINE ) );
define( "pb1l27", __( "Optimizer", PluginTextDomain_DEFINE ) );
define( "pb1O27", __( "Social", PluginTextDomain_DEFINE ) );
define( "pb1l28", __( "LOW", PluginTextDomain_DEFINE ) );
define( "pb1O28", __( "MEDIUM", PluginTextDomain_DEFINE ) );
define( "pb1l29", __( "HIGH", PluginTextDomain_DEFINE ) );
define( "pb1O29", __( "CRITICAL", PluginTextDomain_DEFINE ) );
define( "pb1l2a", __( "Please enter your activation code in the plugin general settings screen to enable", PluginTextDomain_DEFINE ) );
define( "pb1O2a", pb1l2b() );
define( "pb1O2b", pb1l2c() );
define( "pb1O2c", __( "Thumbnail", PluginTextDomain_DEFINE ) );
define( "pb1l2d", __( "Small", PluginTextDomain_DEFINE ) );
define( "pb1O2d", __( "Medium", PluginTextDomain_DEFINE ) );
define( "pb1l2e", __( "Large", PluginTextDomain_DEFINE ) );
return TRUE_BOOL_DEFINE; ?>