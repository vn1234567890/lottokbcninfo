<?php
/*
Plugin Name: WP Link Engine
Plugin URI: http://www.wplinkengine.com/
Author Name: WP Smart Tools
Author URI: http://www.wpsmarttools.com/
Description: Professionally manage your links - a more advanced version of Link Saver by WP Smart Tools
Version: 2.0
*/

if(!defined("WPLINK_PLUGIN_NAME")) {
    define("WPLINK_PLUGIN_NAME", "WP Link Engine");
    define("WPLINK_SHORTCODE", "lel");
    define("WPLINK_SHORTCODE_URL", "leu");
    
    define("WPLINK_VERSION", "2.0");
    define("WPLINK_MODE", "2");
    define("WPLINK_QUERY_CACHE", (60*60*24*7));
    
    // pre-2.6 compatibility
    if ( ! defined( 'WP_CONTENT_URL' ) )
          define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
    if ( ! defined( 'WP_CONTENT_DIR' ) )
          define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
    if ( ! defined( 'WP_PLUGIN_URL' ) )
          define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
    if ( ! defined( 'WP_PLUGIN_DIR' ) )
          define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
      
      
    include WP_PLUGIN_DIR . "/wp-link-engine/" . "arin.php";
    include WP_PLUGIN_DIR . "/wp-link-engine/" . "bulk.php";
    include WP_PLUGIN_DIR . "/wp-link-engine/" . "geoplugin.class.php";
    include WP_PLUGIN_DIR . "/wp-link-engine/" . "globals.php";
    include WP_PLUGIN_DIR . "/wp-link-engine/" . "process.php";
    include WP_PLUGIN_DIR . "/wp-link-engine/" . "filters.php";
    include WP_PLUGIN_DIR . "/wp-link-engine/" . "menus.php";
    include WP_PLUGIN_DIR . "/wp-link-engine/" . "documentation.php";
    include WP_PLUGIN_DIR . "/wp-link-engine/" . "shortcodes.php";
    include WP_PLUGIN_DIR . "/wp-link-engine/" . "load.php";
    include WP_PLUGIN_DIR . "/wp-link-engine/" . "js.php";
    include WP_PLUGIN_DIR . "/wp-link-engine/" . "statistics.php";

    
    define("WPLINK_PRIMARY", 1);
    define("WPLINK_MULTIPLE", 2);
    define("WPLINK_BANNED", 4);
    define("WPLINK_REQUIRE_FAIL", 8);
    define("WPLINK_GEOS", 16);
    define("WPLINK_SLUG", 32);
    
    function wplink_activate() {
       global $wpdb;


       $sql = "
            CREATE TABLE `".$wpdb->prefix."wplink_links` (
                `id` INT(32) NOT NULL auto_increment,
                `name` VARCHAR(255) NOT NULL,
                `link_title` VARCHAR(255) NOT NULL,
                `title` VARCHAR(255) NOT NULL,
                `class` VARCHAR(255) NOT NULL,
                `group` VARCHAR(255) NOT NULL,
                `from` VARCHAR(255) NOT NULL,
                `post_id` INT(32) NOT NULL,
                `destinations` TEXT NOT NULL,
                `cloaked` VARCHAR(255) NOT NULL,
                `meta_timer` INT(32) NOT NULL,
                `status_bar` VARCHAR(255) NOT NULL,
                `require_blank_fail` TEXT NOT NULL,
                `nofollow` TINYINT(1) NOT NULL,
                `forwarding` TINYINT(1) NOT NULL,
                `subid` TINYINT(1) NOT NULL,
                `expired` INT(255) NOT NULL,
                `expire_url` TEXT NOT NULL,
                `replace_destinations` INT(32) NOT NULL,
                `vars` TEXT NOT NULL,
                `target` VARCHAR(255) NOT NULL,
                PRIMARY KEY  (`id`)			
                )
        ";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
     // replace_destinations: 1=primary, 2=multiple, 4=banneds, 8=require_fail, 16=geos.
        
        $wpdb->query("
            CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."wplink_clicks` (
                `id` INT(32) NOT NULL auto_increment,
                `timestamp` INT(255) NOT NULL,
                `link_id` INT(32) NOT NULL,
                `destination` TEXT NOT NULL,
                `referrer` TEXT NOT NULL,
                `agent` TEXT NOT NULL,
                `subid` TEXT NOT NULL,
                `query` TEXT NOT NULL,
                `ip_long` INT(32) NOT NULL,
                
                PRIMARY KEY  (`id`)			
                )
        ");
        $wpdb->query("
            CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."wplink_destinations` (
                `id` INT(32) NOT NULL auto_increment,
                `link_id` INT(32) NOT NULL,
                `weight` DECIMAL(14,10) NOT NULL,
                `destination` TEXT NOT NULL,
                
                PRIMARY KEY  (`id`)			
                )
        ");
        $wpdb->query("
            CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."wplink_restrictions` (
                `id` INT(32) NOT NULL auto_increment,
                `link_id` INT(32) NOT NULL,
                `ip` VARCHAR(32) NOT NULL,
                `arin` TEXT NOT NULL,
                `hostname` TEXT NOT NULL,
                `referrer` TEXT NOT NULL,
                `destination` TEXT NOT NULL,
                PRIMARY KEY  (`id`)			
                )
        ");
        
        $wpdb->query("
            CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."wplink_user_agent` (
                `id` INT(32) NOT NULL auto_increment,
                `link_id` INT(32) NOT NULL,
                `full` TEXT NOT NULL,
                `not` TEXT NOT NULL,
                `destination` TEXT NOT NULL,

                PRIMARY KEY  (`id`)			
                )
        "); // not is so you can go where useragent is "Safari" but not "Chrome".
        
   
        $wpdb->query("
            CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."wplink_geo_links` (
                `id` INT(32) NOT NULL auto_increment,
                `link_id` INT(32) NOT NULL,
                `countrycode` VARCHAR(255) NOT NULL,
                `destination` TEXT NOT NULL,
                
                PRIMARY KEY  (`id`)			
                )
        ");

	$keywords = ("
            CREATE TABLE `".$wpdb->prefix."wplink_keywords` (
                `id` INT(32) NOT NULL auto_increment,
                `keyword` TEXT NOT NULL,
                `link_id` INT(32) NOT NULL,
                `color` VARCHAR(255) NOT NULL,
                `size` VARCHAR(255) NOT NULL,
                `family` VARCHAR(255) NOT NULL,
                `extra` TEXT NOT NULL,
                `max` INT(12) NOT NULL,
		`case` INT(2) NOT NULL,
		`whole` INT(2) NOT NULL,
		`h1` INT(2) NOT NULL,
                PRIMARY KEY  (`id`)
                )
        ");
	dbDelta($keywords);
        
        $wpdb->query("
            CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."wplink_presets` (
                `id` INT(32) NOT NULL auto_increment,
                `name` VARCHAR(255) NOT NULL,
                `timestamp` INT(32) NOT NULL,
                `type` VARCHAR(255) NOT NULL,
                `data` TEXT NOT NULL,
                PRIMARY KEY  (`id`)
                )
        ");
        
        $wpdb->query("
            CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."wplink_arin_cache` (
                `id` INT(32) NOT NULL auto_increment,
                `query` VARCHAR(255) NOT NULL,
                `timestamp` INT(32) NOT NULL,
                `data` TEXT NOT NULL,
                PRIMARY KEY  (`id`)
                )
        ");
                   
    }
    
// license check.
require_once WP_PLUGIN_DIR . "/wp-link-engine/" . "license_functions.php";

function wple_license() {
    $response = WPLINKlicensing_validate_license();
    if($response === WPLINK_NO_KEY) {
        deactivate_plugins((WP_PLUGIN_DIR."/wp-link-engine/main.php"));
        wp_die("Please configure key.php to contain your license key before trying to install.");
    }
    
    if($response !== false) {
        return true;
    } else {
        deactivate_plugins((WP_PLUGIN_DIR."/wp-link-engine/main.php"));
        wp_die("The license key you provided was invalid. Please check your WP Link Engine key.php file to ensure the key you provided was correct.");
    }           
}
//register_activation_hook((WP_PLUGIN_DIR . "/wp-link-engine/" . "main.php"), "wple_license"); 

}  
?>
