<?php

register_activation_hook((WP_PLUGIN_DIR . "/wp-link-engine/" . "main.php"), "wplink_activate");

add_action('admin_head', 'wplink_js');
add_action("admin_menu", "wplink_add_menus");
add_filter("the_content", "wplink_links", 8);


add_filter("the_content", "wplink_keywords", 11);

add_shortcode(WPLINK_SHORTCODE, "wplink_sc_link");
add_shortcode(WPLINK_SHORTCODE_URL, "wplink_sc_url");

add_action("save_post", "wplink_disable_save");

add_action("init", "wplink_logic");
?>