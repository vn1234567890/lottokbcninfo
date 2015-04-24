<?php
/*
 * This file is part of vBulletin5.x Latest Threads and Comments.
 * Copyright 2015 Muhammad Arfan (http://thearfan.com)
 *
 * vBulletin5.x Latest Threads and Comments is premium software.
 */

require_once(dirname(__FILE__) . '/MyVBXPMessageHandler.php');

class MyVBSettings {

    private $messageHandler;
    private $options;

    function __construct($messageHandler) {
        global $wpdb;

        //delete_option('mybbxp_options'); // to revert to default options for debugging

        $this->messageHandler = $messageHandler;
        $default_options = array(
            'url' => 'http://www.example.org/forum',
            'db_user' => $wpdb->dbuser,
            'db_password' => $wpdb->dbpassword,
            'db_name' => $wpdb->dbname,
            'db_prefix' => '',
            'db_host' => $wpdb->dbhost,
        );
        add_option('mybbxp_options', $default_options);

        $this->options = get_option('mybbxp_options');
    }

    function admin_menu_action() {
        $hook = add_options_page('vBulletin Settings', 'vBulletin Setting', 'manage_options', 'mybbxp_settings_page', array($this, 'settings_page')); // $page_title, $menu_title, $capability, $menu_slug, $function
        add_action('load-' . $hook, array($this->messageHandler, 'display_buffered_admin_message'));

        // apparently I have to call this as another callback
        add_action('admin_init', array($this, 'admin_init_action'));
    }

    function admin_init_action() {

        // general settings section
        add_settings_section('mybbxp_general', 'General', array($this, 'no_description'), 'mybbxp_settings_page'); // add_settings_section($id, $title, $callback, $page)
        //add_settings_field($id, $title, $callback, $page, $section = 'default', $args = array())
        add_settings_field('url', 'vBulletin Forum URL, with trailing slash', array($this, 'url_input'), 'mybbxp_settings_page', 'mybbxp_general');

        add_settings_section('mybbxp_db', 'vBulletin Database Configuration', array($this, 'db_description'), 'mybbxp_settings_page');
        add_settings_field('db_user', 'Database Username', array($this, 'db_user_input'), 'mybbxp_settings_page', 'mybbxp_db');
        add_settings_field('db_password', 'Database Password', array($this, 'db_password_input'), 'mybbxp_settings_page', 'mybbxp_db');
        add_settings_field('db_name', 'Database Name', array($this, 'db_name_input'), 'mybbxp_settings_page', 'mybbxp_db');
        add_settings_field('db_prefix', 'Database Prefix(<small> Leave empty if not </small>)', array($this, 'db_prefix_input'), 'mybbxp_settings_page', 'mybbxp_db');
        add_settings_field('db_host', 'Database Host', array($this, 'db_host_input'), 'mybbxp_settings_page', 'mybbxp_db');
		
		add_settings_section('mybbxp_xp', 'Your vBulletin Version', array($this, 'no_description'), 'mybbxp_settings_page');
		add_settings_field('vb_version', 'vBulletin Version', array($this, 'vb_version_input'), 'mybbxp_settings_page', 'mybbxp_xp');

        // register our option so that they will be saved
        register_setting('mybbxp_options_group', 'mybbxp_options', array($this, 'sanitize_options'));
        register_setting('mybbxp_options_group', 'mybbxp_link', array($this, 'link'));
    }

    function db_description() {
        echo 'Enter your vBulletin database details here, defaults to the same as your Wordpress';
    }

    function no_description() {
        // nothing to see here (pun intended)
    }
	
	

    function db_user_input($args) {
        echo '<input type="text" id="mybbxp_options[db_user]" name="mybbxp_options[db_user]" value="' . esc_attr($this->options['db_user']) . '" />';
    }

    function db_password_input($args) {
        echo '<input type="password" id="mybbxp_options[db_password]" name="mybbxp_options[db_password]" value="' . esc_attr($this->options['db_password']) . '" />';
    }

    function db_name_input($args) {
        echo '<input type="text" id="mybbxp_options[db_name]" name="mybbxp_options[db_name]" value="' . esc_attr($this->options['db_name']) . '" />';
    }

    function db_host_input($args) {
        echo '<input type="text" id="mybbxp_options[db_host]" name="mybbxp_options[db_host]" value="' . esc_attr($this->options['db_host']) . '" />';
    }

    function db_prefix_input($args) {
        echo '<input type="text" id="mybbxp_options[db_prefix]" name="mybbxp_options[db_prefix]" value="' . esc_attr($this->options['db_prefix']) . '" />';
    }

    function url_input($args) {
        echo '<input style="width:30%;" type="text" id="mybbxp_options[url]" name="mybbxp_options[url]" value="' . esc_attr($this->options['url']) . '" />';
    }
	
	function vb_version_input($args) {
		echo '<select id="mybbxp_options[vb_version]" name="mybbxp_options[vb_version]">';
		echo '	<option value="4" ' . ($this->options['vb_version'] == '4' ? 'selected' : '') . '>vBulletin4</option>';
		echo '	<option value="5" ' . ($this->options['vb_version'] == '5' ? 'selected' : '') . '>vBulletin5</option>';
		echo '</select>'; 
	}

    function sanitize_options($insane_options) {
        // most of this is just 'trim', it's an admin configuring this after all
        $sane_options = array(
            'url' => trim($insane_options['url']),
            'vb_version' => trim($insane_options['vb_version']),
            'db_user' => trim($insane_options['db_user']),
            'db_password' => $insane_options['db_password'],
            'db_name' => trim($insane_options['db_name']),
            'db_prefix' => trim($insane_options['db_prefix']),
            'db_host' => trim($insane_options['db_host']),
        );

        return $sane_options;
    }

    function settings_page() {
        ?>
        <div class="wrap">
            <h2>vBulletin Lastest Threads and Comments Plugin Setting page</h2>

            <form method="post" action="options.php">
        <?php settings_fields('mybbxp_options_group'); ?>
        <?php do_settings_sections('mybbxp_settings_page'); ?>
                <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
            </form>
        </div>
        <?php
    }

}
?>
