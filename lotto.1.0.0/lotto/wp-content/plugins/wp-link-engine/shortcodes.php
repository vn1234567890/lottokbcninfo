<?php
    function wplink_sc_url($atts, $content=null) {
    extract( shortcode_atts( array(
      'id' => '-1',
      'name' => '',
      // ...etc
      ), $atts ) );
    
        global $wpdb;
        
        $url = ((get_option('home'))?get_option('home'):get_option('siteurl'));
        $url = rtrim($url, "/") . "/";

        if($id != -1) {
            $from = $wpdb->get_var("SELECT `from` FROM `".$wpdb->prefix."wplink_links` WHERE `id`='$id'");
            return $url . $from;
        } else {
            $from = $wpdb->get_var("SELECT `from` FROM `".$wpdb->prefix."wplink_links` WHERE `name`='$name'");
            return $url . $from;        
        }
    
    }
    
    function wplink_sc_link($atts, $content=null) {
    extract( shortcode_atts( array(
      'id' => '-1',
      'name' => '',
      'text'=>'',
      'subid'=>'',
      // ...etc
      ), $atts ) );
    
        global $wpdb;
        $url = ((get_option('home'))?get_option('home'):get_option('siteurl'));
        $url = rtrim($url, "/") . "/";



        if($id != -1) {
            $from = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wplink_links` WHERE `id`='$id'");
                    
        } else {
            $from = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wplink_links` WHERE `name`='$name'");
                
        }
        

        $link_title = $from->link_title;
        if($text != "") $link_title = $text;
        if($content != null) $link_title = $content;
        
        $title = $from->link_title;
       
        $class = ""; $follow = "";
        
        $javascript = wplink_get_javascript($from->id);
        if(strlen($subid) > 0) $subid .= "/$subid";
        if(strlen($from->title) > 0) $title = $from->title;
        if(strlen($from->class) > 0) $class = " class='" . $from->class . "'";
        if(strlen($from->target) > 0) $target = " target='" . $from->target . "'";

        if($from->nofollow == 1) {
            $follow = " rel='nofollow, wpls' ";
        } else {
            $follow = " rel='wpls' ";
        }
        return "<a href='" . ($url . $from->from . $subid) . "'{$class} {$target} {$follow} {$javascript} title='" . $title . "'>$link_title</a>";
    }
?>