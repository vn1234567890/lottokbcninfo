<?php
/*
 * This file is part of VBulletin5.x Latest Threads and Comments.
 * Copyright 2014 Muhammad Arfan ( http://thearfan.com)
 *
 * VB5.x Latest threads and comments is premium software.
 */

class VB_latest_threads extends WP_Widget {

    function __construct() {
        parent::__construct(
                'wpb_widget', __('vBulletin Latest Threads', 'vblt_widget_domain'), array('description' => __('Widget to get latest vBulletin Latest Thread and Comments', 'vblt_widget_domain'),)
        );
        add_action('wp_head', array($this, 'register_plugin_styles'));
    }

    function register_plugin_styles() {
        // JS    
        wp_enqueue_script('VB_latest_threads', plugins_url('js/wp-tab-widget.js', __FILE__), array('jquery'));
        // CSS     
        wp_enqueue_style('VB_latest_threads', plugins_url('css/wp-tab-widget.css', __FILE__), true);
    }

    public function widget($args, $instance) {
        global $wpdb;
        $options = get_option('mybbxp_options');
        // re-use database connection if it's the same as wordpress
        if ($options['db_user'] == $wpdb->dbuser &&
                $options['db_password'] == $wpdb->dbpassword &&
                $options['db_name'] == $wpdb->dbname &&
                $options['db_host'] == $wpdb->dbhost) {
            $myvbdb = & $wpdb;
        } else {
            $myvbdb = new wpdb($options['db_user'], $options['db_password'], $options['db_name'], $options['db_host']);
        }

        extract($args);
		
        $title = apply_filters('widget_title', $instance['title']);
        $limit = apply_filters('widget_limit', $instance['limit']);
		echo $args['before_widget'];
		if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];
			 
  
		if($options['vb_version'] == 4) {
			 $table = "post";
			  $query = "SELECT p.threadid,p.title,p.userid,customavatar.dateline FROM ". $table . " AS p LEFT JOIN  customavatar ON (customavatar.userid = p.userid) 
  WHERE  parentid = 0 ORDER BY postid DESC Limit $limit";
   $query1 = "SELECT p.threadid,thread.title,p.pagetext,customavatar.dateline,p.userid FROM ". $table . " AS p LEFT JOIN  customavatar ON (customavatar.userid = p.userid) LEFT JOIN thread ON (thread.threadid = p.threadid)
  WHERE  parentid != 0 ORDER BY postid DESC Limit $limit";
  
  $result = $myvbdb->get_results($query);
  $result1 = $myvbdb->get_results($query1);
  
   if ($myvbdb->last_error) {
            echo $this->myvbdb->last_error . '<br/>Query: ' . $this->myvbdb->last_query;
            echo $after_widget;
            return;
        } ?>
		
		 <div id="tabContainer">
            <div id="tabs">
                <ul>
                    <li id="tabHeader_1">Latest Threads</li>
                    <li id="tabHeader_2"> Replies</li>
                </ul>
            </div>

            <div id="tabscontent">
                <div class="tabpage" id="tabpage_1">
        <?php
        foreach ($result as $key => $row) {

            ?>

                        <p class="vb_avatar" style="margin-bottom:-10px !important">
                        <?php if (!empty($row->dateline)) { ?>
                                <img width="100%" height="40px" src="<?php echo $options['url']; ?>image.php?u=<?php echo $row->userid ?>&dateline=<?php echo $row->dateline ?>&type=thumb"> 
                        <?php } else { ?>
                                <img width="100%" height="40px" src="<?php echo $options['url']; ?>/images/misc/unknown.gif">
                            <?php } ?>
                        </p>
                        <a href="<?php  echo $options['url']; ?>showthread.php?<?php echo $row->threadid; ?>-<?php echo str_replace(" ","-",$row->title) ?>" target="_blank"> <p class="vb_title"> <?php echo $row->title; ?> </a> 
                        </p>
                        <p style="clear: both;"> </p>
                        <?php } ?>


                </div>
                <div class="tabpage" id="tabpage_2">
                    <?php
                    foreach ($result1 as $key => $row1) { ?>

                        <p class="vb_avatar" style="margin-bottom:-10px !important">
                        <?php if (!empty($row1->dateline)) { ?>
                                 <img width="100%" height="40px" src="<?php echo $options['url']; ?>image.php?u=<?php echo $row1->userid; ?>&dateline=<?php echo $row1->dateline; ?>&type=thumb"> 
                        <?php } else { ?>
                                <img width="100%" height="40px" src="<?php echo $options['url']; ?>/images/misc/unknown.gif"> 
                            <?php } ?>
                        </p>
                        <p class="vb_title"> <a href="<?php  echo $options['url']; ?>showthread.php?<?php echo $row1->threadid; ?>-<?php echo str_replace(" ","-",$row1->title) ?>" target="_blank">
                            <?php echo substr($row1->pagetext, 0, 100); ?></a> 
                        </p>
                        <p style=" clear: both;"> </p>
        <?php } ?>

                </div>

            </div>
        </div>
		
	<?php	
  
		} else { 
       
       
		 $table = "node";
        

        $query = "SELECT n.nodeid,n.parentid, n.description, n.urlident,n.title,customavatar.dateline,customavatar.userid 
  FROM " . $options['db_prefix'] . $table . " AS n LEFT JOIN customavatar AS " . $options['db_prefix'] . "customavatar ON (customavatar.userid = n.userid) 
  WHERE  starter != 0 AND htmltitle != '' ORDER BY nodeid DESC Limit $limit";


        $query1 = "SELECT n.nodeid,n.parentid,n.description, n.urlident,n.title,customavatar.dateline,customavatar.userid 
  FROM " . $options['db_prefix'] . $table . " AS n LEFT JOIN " . $options['db_prefix'] . "customavatar AS customavatar ON (customavatar.userid = n.userid) 
  WHERE  starter != 0 AND title='' ORDER BY nodeid DESC Limit $limit";
        $result = $myvbdb->get_results($query);
        $result1 = $myvbdb->get_results($query1);

        if ($myvbdb->last_error) {
            echo $this->myvbdb->last_error . '<br/>Query: ' . $this->myvbdb->last_query;
            echo $after_widget;
            return;
        }
        ?>

        <div id="tabContainer">
            <div id="tabs">
                <ul>
                    <li id="tabHeader_1">Latest Threads</li>
                    <li id="tabHeader_2"> Replies</li>
                </ul>
            </div>

            <div id="tabscontent">
                <div class="tabpage" id="tabpage_1">
        <?php
        foreach ($result as $key => $row) {

            $parent_id = $row->nodeid;

            $q = "SELECT n.nodeid, r.prefix, n.parentid, n.urlident FROM " . $options['db_prefix'] . $table . " AS n LEFT JOIN " . $options['db_prefix'] . "routenew AS r ON (r.routeid = n.routeid) WHERE nodeid =" . $parent_id;
            $res = $myvbdb->get_results($q);
            $prefix = $res[0]->prefix;
            $url_ident = $res[0]->urlident;
            $node_id = $res[0]->nodeid;
            $url = $options['url'] . $prefix . "/" . $node_id . "-" . $url_ident;
            ?>

                        <p class="vb_avatar" style="margin-bottom:-10px !important">
                        <?php if (!empty($row->dateline)) { ?>
                                <img width="100%" height="40px" src="<?php echo $options['url']; ?>/core/image.php?userid=<?php echo $row->userid ?>&thumb=1&dateline=<?php echo $row->dateline ?>"> 
                        <?php } else { ?>
                                <img width="100%" height="40px" src="<?php echo $options['url']; ?>/core/images/default/default_avatar_thumb.png"> 
                            <?php } ?>
                        </p>
                        <a href="<?php echo $url; ?>" target="_blank"> <p class="vb_title"> <?php echo $row->title; ?> </a> 
                        </p>
                        <p style="clear: both;"> </p>
                        <?php } ?>


                </div>
                <div class="tabpage" id="tabpage_2">
                    <?php
                    foreach ($result1 as $key => $row1) {

                        $parent_id = $row1->parentid;

                        $q1 = "SELECT n.nodeid, r.prefix, n.parentid, n.urlident FROM " . $options['db_prefix'] . $table . " AS n LEFT JOIN " . $options['db_prefix'] . "routenew AS r ON (r.routeid = n.routeid) WHERE nodeid =" . $parent_id;
                        $res = $myvbdb->get_results($q1);
                        $prefix = $res[0]->prefix;
                        $url_ident = $res[0]->urlident;
                        $node_id = $res[0]->nodeid;
                        $url2 = $options['url'] . $prefix . "/" . $node_id . "-" . $url_ident;
                        ?>

                        <p class="vb_avatar" style="margin-bottom:-10px !important">
                        <?php if (!empty($row1->dateline)) { ?>
                                <img width="100%" height="40px" src="<?php echo $options['url']; ?>/core/image.php?userid=<?php echo $row1->userid ?>&thumb=1&dateline=<?php echo $row1->dateline ?>"> 
                        <?php } else { ?>
                                <img width="100%" height="40px" src="<?php echo $options['url']; ?>/core/images/default/default_avatar_thumb.png"> 
                            <?php } ?>
                        </p>
                        <p class="vb_title"> <a href="<?php echo $url2; ?>" target="_blank">
                            <?php echo substr($row1->description, 0, 100); ?>... </a> 
                        </p>
                        <p style=" clear: both;"> </p>
        <?php } ?>

                </div>

            </div>
        </div>

	

        <?php
		}
        echo $args['after_widget'];
    }

   public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else { 
			$title = "Latest Posts";
		}
        if (isset($instance['limit'])) {
            $limit = $instance['limit'];
        } else { 
			$limit = 5;
		}

       
// Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>

            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Limit:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo esc_attr($limit); ?>" />
        </p>

        <?php
    }

    public function update($new_instance, $old_instance) {

        $instance = array();

        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['limit'] = (!empty($new_instance['limit']) ) ? strip_tags($new_instance['limit']) : '';

        return $instance;
    }

}
?>