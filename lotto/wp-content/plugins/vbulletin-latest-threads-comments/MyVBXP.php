<?php

/*
 * This file is part of VBulletin5.x Latest Forum Posts.
 * Copyright 2014 Muhammad Arfan (Url Address)
 *
 * VB5.x Latest Forum Posts is premium software.
 */

include_once('MyVBXPMessageHandler.php');
include_once('MyVBSettings.php');

class MyVBXP {

    private $messageHandler;
    private $options;
    private $mybbdb;

    function __construct() {
        $this->options = get_option('mybbxp_options');
        $this->messageHandler = new MyVBXPMessageHandler();
    }

    function activation_hook() {
        // noting to do
    }

    // callback to display buffered messages on admin head post action
    function admin_head_post_php_action() {
        $this->messageHandler->display_buffered_admin_message();
    }

    function admin_menu_action() {
        $settings = new MyVBSettings($this->messageHandler);
        $settings->admin_menu_action();
    }

    // callback to flush our message buffers into options so that they can be displayed later
    function shutdown_action() {
        if ($this->messageHandler->has_messages()) {
            $this->messageHandler->flush_messages();
        }
    }

}

?>
