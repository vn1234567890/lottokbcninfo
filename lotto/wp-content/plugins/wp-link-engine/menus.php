<?php

    
    function wplink_add_menus() {
	add_menu_page("WP Link Engine", "Link Engine", 8, "wplink-manage", "wplink_manage", (WP_PLUGIN_URL . "/wp-link-engine/link_edit.png")); 
    	add_submenu_page('wplink-manage', 'Manage', 'Manage Links', 8, 'wplink-manage', 'wplink_manage');
    	add_submenu_page('wplink-manage', 'Statistics', 'Link Statistics', 8, 'wplink-statistics', 'wplink_statistics');
        add_submenu_page('wplink-manage', 'Presets', 'Presets', 8, 'wplink-presets', 'wplink_presets');
        #add_submenu_page('wplink-manage', 'Global Settings', 'Global Settings', 8, 'wplink-global', 'wplink_global');
		
        add_meta_box('wplink_addlink', 'Insert Link', 'wplink_addlink_box', 'post', 'normal' , 'high');
        add_meta_box('wplink_addlink', 'Insert Link', 'wplink_addlink_box', 'page', 'normal' , 'high');
    	
        add_meta_box('wplink_disable', 'Per-Post Link Engine Management', 'wplink_disable_box', 'post', 'side' , 'low');
	add_meta_box('wplink_disable', 'Per-Page Link Engine Management', 'wplink_disable_box', 'page', 'side' , 'low');

   	add_submenu_page("wplink-manage", "WP Link Engine Help", "Documentation", 8, "wplink", "wplink_help");
    }


    function wplink_presets() {
        global $wpdb;
        ?>

            <div class="wrap">
                <div id="icon-edit" class="icon32"><br /></div>
                <h2>Manage Presets</h2>
                <?php
                    if(isset($_GET['deleted'])) {
                          ?>                
                          <div class='updated fade'><p>Preset deleted.</p></div>
                        <?php
                    }
                ?>
                <table class="widefat poll fixed" cellspacing="0">
            <thead>	
                <tr>
                    <th scope="col"><a href="admin.php?page=wplink-manage&sort_field=name">Title</a></th>
                    <th scope="col"><a href="admin.php?page=wplink-manage&sort_field=date">Date</a></th>
                    <th colspan='2' width='33%' scope="col" id="actions" class="manage-column column-actions" style="">Actions</th>
                </tr>
            </thead>
    
            <tfoot>
            <tr>        				    
                <th scope="col"><a href="admin.php?page=wplink-manage&sort_field=name">Title</a></th>
                <th scope="col"><a href="admin.php?page=wplink-manage&sort_field=date">Date</a></th>
                <th colspan='2' scope="col" id="actions" class="manage-column column-actions" style="">Actions</th>
            </tr>
            </tfoot>
    
            <tbody id="the-list" class="list:link">
        	<?php
                $presets = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_presets`");
                foreach($presets as $p) {
                    echo "<tr>";
                        echo "<td><strong>" . $p->name . "</strong></td>";
                        echo "<td>" . date("F jS, Y H:i:s", $p->timestamp) . "</td>";
                        echo "<td colspan='2'><a href='admin.php?page=wplink-manage&action=preset&ID=" . $p->id . "'>Use Preset</a> | <a href='admin.php?page=wplink-manage&action=delete-preset&ID=" . $p->id . "'>Delete</a></td>";
                    echo "</tr>";
                }
            ?>
            </tbody>
		</table></div>
        <?php
    }
    
    function wplink_manage() {
        global $wpdb;
        switch($_REQUEST['action']) {
            case "delete-preset":
                $id = $_GET['ID'];
                
                $delete = $wpdb->query("DELETE FROM `".$wpdb->prefix."wplink_presets` WHERE `id`='".$id."'");
                wplink_meta_refresh("admin.php?page=wplink-presets&deleted=true",0);
				
            break;
            
            case "delete-mass": 
                foreach($_POST['ids'] as $id) {
                    $delete = $wpdb->query('DELETE FROM `'.$wpdb->prefix.'wplink_links` WHERE `id`="'.$id.'"');   
		            $delete = $wpdb->query('DELETE FROM `'.$wpdb->prefix.'wplink_destinations` WHERE `link_id`="'.$id.'"');   
	    	        $delete = $wpdb->query('DELETE FROM `'.$wpdb->prefix.'wplink_restrictions` WHERE `link_id`="'.$id.'"');   
    		        $delete = $wpdb->query('DELETE FROM `'.$wpdb->prefix.'wplink_geo_links` WHERE `link_id`="'.$id.'"');   
                    wplink_meta_refresh("admin.php?page=wplink-manage&action=manage&deleted=true",0);
				
                }
            break;
            
            case "do-edit":
                $id = $_POST['ID'];
                $name = trim($_POST['name']);
                $link_title = trim($_POST['link_title']);
                $title = trim($_POST['title']);
                $class = trim($_POST['class']);
                $target = trim($_POST['target']);
                $from = ($_POST['from']);
                
                $to_post = intval($_POST['to_post']);
                $to_page = intval($_POST['to_page']);
                if($to_post == 0) $to_post = $to_page;
                
                $expired = strtotime($_POST['expired']);
                $expire_url = $_POST['expire_url'];
                
                $destinations = ($_POST['destinations']);
                $cloaked = ($_POST['cloaked']);
                $meta_timer = $_POST['meta_timer'];
                $status_bar = $_POST['status_bar'];
                $require_blank_fail = $_POST['require_blank_fail'];
                $group = ($_POST['group']);
                $subid = $_POST['subid'];
                $forwarding = $_POST['forwarding'];
                $vars = $_POST['vars'];
                
                $nofollow = $_POST['nofollow'];
                
                
                $keywords = $_POST['filter'];
                $keywords = explode(",", $keywords);    // insert in to keywords table.
                
                $color = trim($_POST['txtcolor']);
                $size = $_POST['txtsize'];
                $family = $_POST['txtfamily'];
                $extra = $_POST['txtextra'];

		$case = intval($_POST['auto_insensitive']);
		$whole = intval($_POST['auto_whole']);
		$h1 = intval($_POST['auto_noth1']);

                if($color == "" || empty($color)) $color = $_POST['color'];
                if($family == "" || empty($family)) $family = $_POST['family'];
                if($size == "" || empty($size)) $size = $_POST['size'];
                if($extra == "" || empty($extra)) $extra = $_POST['extra'];
                
                $max = intval($_POST['max']);
                
                
                $replace_destinations = 0;
                $replace_destinations += $_POST['match_primary'];
                $replace_destinations += $_POST['match_slug'];
                $replace_destinations += $_POST['match_geos'];
                $replace_destinations += $_POST['match_multiple'];
                $replace_destinations += $_POST['match_banned'];
                $replace_destinations += $_POST['match_require_fail'];
                
                
                $wpdb->show_errors=true;
                $from_duplicate = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wplink_links` WHERE `from`='{$from}' AND `id`!='{$id}'");

                if(!isset($from_duplicate->id)) {            

                    $wpdb->query("INSERT INTO `".$wpdb->prefix."wplink_links`
                    (`id`,
                    `name`,
                    `link_title`,
                    `title`,
                    `class`,
                    `from`,
                    `post_id`,
                    `destinations`,
                    `cloaked`,
                    `meta_timer`,
                    `status_bar`,
                    `require_blank_fail`,
                    `nofollow`,
                    `subid`,
                    `forwarding`,
                    `group`,
                    `expired`,
                    `expire_url`,
                    `replace_destinations`,
                    `vars`,
                    `target`)
                    VALUES
                    ('$id',
                    '$name',
                    '$link_title',
                    '$title',
                    '$class',
                    '$from',
                    '$to_post',
                    '$destinations',
                    '$cloaked',   
                    '$meta_timer',
                    '$status_bar',
                    '$require_blank_fail',
                    '$nofollow',
                    '$subid',
                    '$forwarding',
                    '$group',
                    '$expired',
                    '$expire_url',
                    '$replace_destinations',
                    '$vars',
                    '$target')
                    
                    ON DUPLICATE KEY                 
						    UPDATE
						        `name`='$name',
						        `link_title`='$link_title',
						        `title`='$title',
						        `class`='$class',
						        `from`='$from',
						        `post_id`='$to_post',
						        `destinations`='$destinations',				       
						        `cloaked`='$cloaked',
						        `meta_timer`='$meta_timer',
						        `status_bar`='$status_bar',
						        `require_blank_fail`='$require_blank_fail',
							`nofollow`='$nofollow',
						        `group`='$group',
						        `subid`='$subid',
						        `forwarding`='$forwarding',
						        `expired`='$expired',
						        `expire_url`='$expire_url',
						        `replace_destinations`='$replace_destinations',
						        `vars`='$vars',
                                                        `target`='$target'");
						        
                    if($id == "") {
				    	$id = mysql_insert_id($wpdb->dbh);
				    }

      				$wpdb->query("DELETE FROM `".$wpdb->prefix."wplink_destinations` WHERE `link_id`='$id'");				    
      				$destinations = array();
                    $sum = 0;
                    for($i=0;$i<count($_POST);$i++) {
                        if(isset($_POST['dest_to_'.$i]) && !empty($_POST['dest_to_'.$i])) {
                            $weight = intval($_POST['weight_' . $i]);
                            $sum += $weight;
                            $destination = trim($_POST['dest_to_' . $i]);

                            $destinations[] = array($destination, $weight);
                        }
                    }
                    
                    if($sum != 0) {
                        $ratio = (100 / $sum);
                    }
                    
                    if($ratio != 1) {
                        $updatedProbs = true;
                    } else {
                        $updatedProbs = false;
                    }
                    
                    foreach($destinations as $d) {
                        $d[1] *= $ratio;
                        $wpdb->query("INSERT INTO `".$wpdb->prefix."wplink_destinations`
                            (`link_id`, `destination`, `weight`)
                            VALUES('$id', '{$d[0]}', '{$d[1]}')");
                    }
                    
                    $wpdb->query("DELETE FROM `".$wpdb->prefix."wplink_user_agent` WHERE `link_id`='$id'");				    
                    for($i=0;$i<count($_POST);$i++) {
                        if((isset($_POST['full_'.$i]) && !empty($_POST['full_'.$i])) || (isset($_POST['not_'.$i]) && !empty($_POST['not_'.$i]))) {
                            $full = trim($_POST['full_' . $i]);
                            $not = trim($_POST['not_' . $i]);
                            
                            $destination = trim($_POST['dest_ua_' . $i]);
                            $wpdb->query("INSERT INTO `".$wpdb->prefix."wplink_user_agent` 
                                  (`link_id`, `full`, `not`, `destination`)
                                  VALUES('$id', '$full', '$not', '$destination')");
                                  
                            
                        }
                    }
                    $wpdb->query("DELETE FROM `".$wpdb->prefix."wplink_restrictions` WHERE `link_id`='$id'");				    
                    for($i=0;$i<count($_POST);$i++) {
                        if(isset($_POST['ip_'.$i]) && !empty($_POST['ip_'.$i])) {
                            $ip = trim($_POST['ip_' . $i]);
                            $destination = trim($_POST['dest_ip_' . $i]);
                            $wpdb->query("INSERT INTO `".$wpdb->prefix."wplink_restrictions` 
                                  (`link_id`, `ip`, `destination`)
                                  VALUES('$id', '$ip', '$destination')");
                                  
                            
                        }
                    }
                    for($i=0;$i<count($_POST);$i++) {
                        if(isset($_POST['arin_'.$i]) && !empty($_POST['arin_'.$i])) {
                            $ip = trim($_POST['arin_' . $i]);
                            $destination = trim($_POST['dest_arin_' . $i]);
                            $wpdb->query("INSERT INTO `".$wpdb->prefix."wplink_restrictions` 
                                  (`link_id`, `arin`, `destination`)
                                  VALUES('$id', '$ip', '$destination')");
                                  
                            
                        }
                    }
				
				    for($i=0;$i<count($_POST);$i++) {
                        if(isset($_POST['host_'.$i]) && !empty($_POST['host_'.$i])) {
                            $host = trim($_POST['host_' . $i]);
                            $destination = trim($_POST['dest_host_' . $i]);
                            $wpdb->query("INSERT INTO `".$wpdb->prefix."wplink_restrictions` 
                                  (`link_id`, `hostname`, `destination`)
                                  VALUES('$id', '$host', '$destination')");
                                  
                            
                        }
                    }
                       
    				for($i=0;$i<count($_POST);$i++) {
                        if(isset($_POST['ref_'.$i]) && !empty($_POST['ref_'.$i])) {
                            $ref = trim($_POST['ref_' . $i]);
                            $destination = trim($_POST['dest_ref_' . $i]);
                            $wpdb->query("INSERT INTO `".$wpdb->prefix."wplink_restrictions` 
                                  (`link_id`, `referrer`, `destination`)
                                  VALUES('$id', '$ref', '$destination')");
                                  
                            
                        }
                    }
				
				
      				$wpdb->query("DELETE FROM `".$wpdb->prefix."wplink_geo_links` WHERE `link_id`='$id'");				    
                    for($i=0;$i<count($_POST);$i++) {
                        if(isset($_POST['to_'.$i]) && !empty($_POST['to_'.$i])) {
                            $countrycode = trim($_POST['ccode_' . $i]);
                            $destination = trim($_POST['to_' . $i]);
                            if(strspn($countrycode, "ABCDEFGHIJKLMNOPQRSTUVWXYZ") == strlen($countrycode)) {
                                $wpdb->query("INSERT INTO `".$wpdb->prefix."wplink_geo_links` 
                                  (`link_id`, `countrycode`, `destination`)
                                  VALUES('$id', '$countrycode', '$destination')");
                                  
                            }
                        }
                    }
				
                    $wpdb->query("DELETE FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$id'");
                        if(count($keywords) > 0) {
                            foreach($keywords as $keyword) {
                                $keyword = trim($keyword);
                                if(!empty($keyword)) {
    		    	    	    $wpdb->query("INSERT INTO `".$wpdb->prefix."wplink_keywords` 
	    		    	            (`keyword`, `link_id`, `color`,`size`,`family`,`extra`, `max`, `case`, `whole`, `h1`)
    	    		    	        VALUES
	    	    	        	    ('$keyword', '$id', '$color', '$size', '$family', '$extra','$max', '$case', '$whole', '$h1')");
	    	    	        }
                            }
	                }	
                   $bulkips = wplink_bulk_getArrayFromLineAndPipe($_POST['bulkips']);
                   if(count($bulkips) > 1)
                   {
                        $destination = $_POST['bulkipdestination'];
                        $remove = ($_POST['bulkipremove']==1 ? true : false);
                        $overwrite = ($_POST['bulkipoverwrite']==1 ? true : false);
                         
                        wplink_bulk_processIPs($id, $bulkips, $destination, $remove, $overwrite);
                   }

	           if(isset($_POST['preset']) && !empty($_POST['preset'])) { 
                        $entry = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wplink_links` WHERE `id`='$id'");
                        $entry->slug = "";
                        
                        $keywords = $wpdb->get_col("SELECT `keyword` FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$id'");
                        $keywords = trim(implode(",", $keywords));
                
                        $color = $wpdb->get_var("SELECT `color` FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$id' LIMIT 1");
                        $size = $wpdb->get_var("SELECT `size` FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$id' LIMIT 1");
                        $family = $wpdb->get_var("SELECT `family` FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$id' LIMIT 1");
                        $extra = $wpdb->get_var("SELECT `extra` FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$id' LIMIT 1");
                        $max = $wpdb->get_var("SELECT `max` FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$id' LIMIT 1");
               
                        $case = $wpdb->get_var("SELECT `case` FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$id' LIMIT 1");
                        $whole = $wpdb->get_var("SELECT `whole` FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$id' LIMIT 1");
                        $h1 = $wpdb->get_var("SELECT `h1` FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$id' LIMIT 1");
 
                        $destinations = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_destinations` WHERE `link_id`='{$id}'");
                        $countries = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_geo_links` WHERE `link_id`='{$id}'");
                        $hostnames = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_restrictions` WHERE `link_id`='{$id}' AND `hostname`!=''");
                        $ip = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_restrictions` WHERE `link_id`='{$id}' AND `ip`!=''");
                        $referrer = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_restrictions` WHERE `link_id`='{$id}' AND `referrer`!=''");
                        $arin = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_restrictions` WHERE `link_id`='{$id}' AND `arin`!=''");
                        $ua = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_user_agent` WHERE `link_id`='{$id}'");
                        
                        $data = serialize(array($entry, $keywords, $color, $size, $family, $extra, $max, $countries, $destinations, $ip, $hostnames, $referrer, $arin, $ua, $case, $whole, $h1));   
                        $wpdb->query("INSERT INTO `".$wpdb->prefix."wplink_presets` (`name`, `timestamp`, `type`, `data`) VALUES ('{$_POST['preset']}', NOW(), 'all', '$data')");
                       
                    }
                    
                    
       				$_POST = array();
    
                } else {
				    $message = "Duplicate 'slug', please try again with a unique slug, or edit the existing link.";
				}

				
    			$_GET['ID'] = $id;            
    			$saved = true;
    			
            case "edit": case "new": case "clone":
                $ID = $_GET['ID'];
                if($_REQUEST['action'] == "new" && !isset($saved)) $ID = "";
                
                $entry = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wplink_links` WHERE `id`='$ID'");
                $url = ((get_option('home'))?get_option('home'):get_option('siteurl'));
                $url = rtrim($url, "/") . "/";

                $keywords = $wpdb->get_col("SELECT `keyword` FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$ID'");
                $keywords = trim(implode(",", $keywords));
                
                $color = $wpdb->get_var("SELECT `color` FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$ID' LIMIT 1");
                $size = $wpdb->get_var("SELECT `size` FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$ID' LIMIT 1");
                $family = $wpdb->get_var("SELECT `family` FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$ID' LIMIT 1");
                $extra = $wpdb->get_var("SELECT `extra` FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$ID' LIMIT 1");
                $max = $wpdb->get_var("SELECT `max` FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$ID' LIMIT 1");
                $case = $wpdb->get_var("SELECT `case` FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$ID' LIMIT 1");
                $whole = $wpdb->get_var("SELECT `whole` FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$ID' LIMIT 1");
                $h1 = $wpdb->get_var("SELECT `h1` FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$ID' LIMIT 1");
 
                
                if($_GET['action'] == "clone") {
                    $_GET['ID'] = "new";
                    $ID = "";
                }
                
                case "preset":
                if($_GET['action'] == "preset") {
                    $presets = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_presets` WHERE `id`='{$_GET['ID']}'");
                    if($presets[0]->type == "all") {
                        $preset = unserialize($presets[0]->data);
                        
                        $entry = $preset[0];
                        $keywords = $preset[1];
                        $color = $preset[2];
                        $size = $preset[3];
                        $family = $preset[4];
                        $extra = $preset[5];
                        $max = $preset[6];
                        $geo = $preset[7];
                        $dest = $preset[8];
                        $_ip = $preset[9];
                        $_host = $preset[10];
                        $_ref = $preset[11];
                        $_arin = $preset[12];
                        $_ua = $preset[13];
                                                
                    }                
                }
                if(!($max > 0)) {
                    $max = "";
                }
            ?>
            <div class="wrap">
                <div id="icon-edit" class="icon32"><br /></div>
                <h2>Manage Link</h2>
                
   <?php 
//                echo '<script type="text/javascript" src="' . WP_PLUGIN_URL . '/wp-link-engine/comboBox.js"></script>';

                if(get_option("permalink_structure") == "") { ?>
                <div class='updated fade'><p><strong>Important</strong>: You need to activate <a href="options-permalink.php">a WordPress permalink structure other than "Default" for the rewritten permalinks</a> to successfully use
                WP Link Engine.</p></div>
                  
             
                <?php } ?>
                
                <?php if($updatedProbs === true) {  ?>
                <div class='updated fade'><p>Your weights didn't add up to 100%; they have been adjusted accordingly.</p></div>
                  
             
                <?php } ?>
                <?php if($_GET['action'] === "clone" || $_GET['action'] === "preset") {  ?>
                <div class='updated fade'><p>Please change the from/slug to something unique.</p></div>
                  
             
                <?php } ?>
                
                <script language="JavaScript">
                   <!--
                   
                
                   
                function repositiontextfield(ctrl) {
                
                    nSizes = Element.Methods.positionedOffset(ctrl);
                        
                    nTop = nSizes[1];
                    nLeft = nSizes[0];
                        
                    selectWidth = ctrl.offsetWidth;  
                    
                    textfield = document.getElementById("txt"+ctrl.name);
                    textfield.style.position = "absolute";
                    textfield.style.top = nTop + "px";
                    textfield.style.left = nLeft + "px";
                    textfield.style.border = "none";
                    
                    //Account for Browser Interface Differences Here
                    if((detect.indexOf("safari") + 1)) {
                    selectButtonWidth = 18
                    textfield.style.marginTop = "0px";
                    textfield.style.marginLeft = "0px";
                    }
                    else if((detect.indexOf("opera") + 1)) {
                        selectButtonWidth = 27;
                        textfield.style.marginTop = "4px";
                        textfield.style.marginLeft = "4px";
                    }
                    else {
                    selectButtonWidth = 27;
                    textfield.style.marginTop = "2px";
                    textfield.style.marginLeft = "4px";
                    }
                    
                    textfield.style.width = (selectWidth - selectButtonWidth) + "px";
                    textfield.style.height = "12px";
                    textfield.style.fontSize = "11px";
                }
                
                function newuarule(first, full, not,dest) {
                    var field_area = document.getElementById("uatargeting");
                     
                    if(!first) {
                        var all_inputs = field_area.getElementsByTagName("input");
                        var last_item = all_inputs.length - 1;
                        var last = all_inputs[last_item].id;
                        var count = Number(last.split("_")[1]);
                        if(count != count)
                            {
                                count = Number(last.split("_")[2]);
                            }
                        count++;
                    } else {
                        var count = 1;
                    }
                    var newspan = document.createElement('span');
                
                    if(!first) newspan.innerHTML += "<br />";
                    newspan.innerHTML += "...like <input type='text' style='background-image:url(<?php echo WP_PLUGIN_URL; ?>/wp-link-engine/accept.png);background-repeat:repeat-x;background-position:14px;width:120px;' name='full_"+count+"' id='full_"+count+"' value='"+full+"' />, but not like <input type='text'  style='background-image:url(<?php echo WP_PLUGIN_URL; ?>/wp-link-engine/cancel.png);background-repeat:repeat-x;background-position:14px;width:120px;' name='not_"+count+"' id='not_"+count+"' value='"+not+"' />";

                    newspan.innerHTML += "<img src=\"<?php echo WP_PLUGIN_URL; ?>/wp-link-engine/rightarrow.png\" /> <input type='text' value='"+dest+"' name='dest_ua_"+count+"' id='dest_ua_"+count+"' style='width:40%;' />";
                    
                    field_area.appendChild(newspan);
                    fixtextfields();
                }
                function newiprule(first, ip, dest) {
                    var field_area = document.getElementById("ipotargetting");
                     
                    if(!first) {
                        var all_inputs = field_area.getElementsByTagName("input");
                        var last_item = all_inputs.length - 1;
                        var last = all_inputs[last_item].id;
                        var count = Number(last.split("_")[1]);
                     
                     if(count != count)
                            {
                                count = Number(last.split("_")[2]);
                           
                            }
                        count++;
                    } else {
                        var count = 1;
                    }
                    var newspan = document.createElement('span');
                
                    if(!first) newspan.innerHTML += "<br />";
                    newspan.innerHTML += "<input type='text' name='ip_"+count+"' id='ip_"+count+"' value='"+ip+"' /> <img src=\"<?php echo WP_PLUGIN_URL; ?>/wp-link-engine/rightarrow.png\" /> <input type='text' value='"+dest+"' name='dest_ip_"+count+"' id='dest_ip_"+count+"' style='width:60%;'/>";
                
                    
                    field_area.appendChild(newspan);
                    fixtextfields();
                }
                
                
                function newhostrule(first, host, dest) {
                    var field_area = document.getElementById("resolveotargetting");
                     
                    if(!first) {
                        var all_inputs = field_area.getElementsByTagName("input");
                        var last_item = all_inputs.length - 1;
                        var last = all_inputs[last_item].id;
                        var count = Number(last.split("_")[1]);
                        if(count != count)
                            {
                                count = Number(last.split("_")[2]);
                            }
                        count++;
                    } else {
                        var count = 1;
                    }
                    var newspan = document.createElement('span');
                
                    if(!first) newspan.innerHTML += "<br />";
                    newspan.innerHTML += "<input type='text' name='host_"+count+"' id='host_"+count+"' value='"+host+"' /> <img src=\"<?php echo WP_PLUGIN_URL; ?>/wp-link-engine/rightarrow.png\" /> <input type='text' value='"+dest+"' name='dest_host_"+count+"' id='dest_host_"+count+"' style='width:60%;'/>";
                
                    field_area.appendChild(newspan);
                    fixtextfields();
                }
                
                
                function newrefrule(first, ref, dest) {
                    var field_area = document.getElementById("refotargetting");
                     
                    if(!first) {
                        var all_inputs = field_area.getElementsByTagName("input");
                        var last_item = all_inputs.length - 1;
                        var last = all_inputs[last_item].id;
                        var count = Number(last.split("_")[1]);
                        if(count != count)
                            {
                                count = Number(last.split("_")[2]);
                            }
                        count++;
                    } else {
                        var count = 1;
                    }
                    var newspan = document.createElement('span');
                
                    if(!first) newspan.innerHTML += "<br />";
                    newspan.innerHTML += "<input type='text' name='ref_"+count+"' id='ref_"+count+"' value='"+ref+"' /> <img src=\"<?php echo WP_PLUGIN_URL; ?>/wp-link-engine/rightarrow.png\" /> <input type='text' value='"+dest+"' name='dest_ref_"+count+"' id='dest_ref_"+count+"' style='width:60%;'/>";
                
                    
                    field_area.appendChild(newspan);
                    fixtextfields();
                }
                function newarinrule(first, arin, dest) {
                    var field_area = document.getElementById("arintargeting");
                     
                    if(!first) {
                        var all_inputs = field_area.getElementsByTagName("input");
                        var last_item = all_inputs.length - 1;
                        var last = all_inputs[last_item].id;
                        var count = Number(last.split("_")[1]);
                        if(count != count)
                            {
                                count = Number(last.split("_")[2]);
                            }
                        count++;
                    } else {
                        var count = 1;
                    }
                    var newspan = document.createElement('span');
                
                    if(!first) newspan.innerHTML += "<br />";
                    newspan.innerHTML += "<input type='text' name='arin_"+count+"' id='arin_"+count+"' value='"+arin+"' /> <img src=\"<?php echo WP_PLUGIN_URL; ?>/wp-link-engine/rightarrow.png\" /> <input type='text' value='"+dest+"' name='dest_arin_"+count+"' id='dest_arin_"+count+"' style='width:60%;'/>";
                
                    
                    field_area.appendChild(newspan);
                    fixtextfields();
                }
                
                function newccoderule(first, country, value) {
                    var field_area = document.getElementById("geotargetting");
                        
                        
                    if(!first) {
                        var all_inputs = field_area.getElementsByTagName("select");
                        var last_item = all_inputs.length - 1;
                        var last = all_inputs[last_item].id;
                        var count = Number(last.split("_")[1]);

                        if(count != count)
                            {
                                count = Number(last.split("_")[2]);
                            }
                        count++;
                    }
                    
                    if(first) count = 1;
                    
                    var newspan = document.createElement('span');
                    
                    if(!first) newspan.innerHTML += "<br />";
                    newspan.innerHTML += createCCode(count);
                    newspan.innerHTML += createTo(count, value);
                    
                    field_area.appendChild(newspan);
                
                    document.getElementById('ccode_' + count).selectedIndex = getOptionIndex(document.getElementById('ccode_' + count), country);
                     
                    fixtextfields();
                }
                function newdestrule(first, dontadjust, string, weight) {
                    var field_area = document.getElementById("destination_block");    
                    var all_inputs = field_area.getElementsByTagName("input");
                
                    if(!first) {
                        var last_item = all_inputs.length - 1;
                        var last = all_inputs[last_item].id;
                        var count = Number(last.split("_")[1]);
                        if(count == "NaN")
                            {
                                count = Number(last.split("_")[2]);
                            }
                        count++;
                    } else {
                        var count = 1;
                    }
                    
                    var newspan = document.createElement('span');
                    if(!first) newspan.innerHTML += "<br />";
                    
                    newspan.innerHTML += createDestTo(count, string, weight);  
                    field_area.appendChild(newspan);
                
                    if(!dontadjust) {
                        for(var i=0; i<all_inputs.length+1;i++) {
                            var working = all_inputs[i].id
                            if(working.split("_")[0] == "weight") {
                                if(all_inputs[i].value == (100/(count-1))) {
                                    all_inputs[i].value = ""+(100/count);
                                }
                            }
                        }
                    }
                    fixtextfields();
                }
                
                function createDestTo(count, value, weight) {
                    if(weight == "" || typeof(weight) == "undefined") {
                        weight = 100/count;
                    }
                    return "<input name='dest_to_" + count+"' id='dest_to_" + count+"' type='text' value='" + value + "' style='width:80%'  /><input type='text' name='weight_"+count+"' id='weight_"+count+"' value='"+weight+"' size='2' style='width:3em;'/>%";
                
                }
                
                function createTo(count, value) {
                    return "<input type='text' name='to_" + count + "' id='to_" + count + "' style='width:440px;' value='"+value+"' />";
                }
                
                function createCCode(count) {
                    return '<select style="width:200px;" name="ccode_' + count + '" id="ccode_' + count + '">\
                                <option value="AF">Afghanistan</option>\
                                <option value="AL">Albania</option>\
                                <option value="DZ">Algeria</option>\
                                <option value="AS">American Samoa</option>\
                                <option value="AD">Andorra</option>\
                                <option value="AO">Angola</option>\
                                <option value="AI">Anguilla</option>\
                                <option value="AQ">Antarctica</option>\
                                <option value="AG">Antigua and Barbuda</option>\
                                <option value="AR">Argentina</option>\
                                <option value="AM">Armenia</option>\
                                <option value="AW">Aruba</option>\
                                <option value="AU">Australia</option>\
                                <option value="AT">Austria</option>\
                                <option value="AZ">Azerbaijan</option>\
                                <option value="BS">Bahamas</option>\
                                <option value="BH">Bahrain</option>\
                                <option value="BD">Bangladesh</option>\
                                <option value="BB">Barbados</option>\
                                <option value="BY">Belarus</option>\
                                <option value="BE">Belgium</option>\
                                <option value="BZ">Belize</option>\
                                <option value="BJ">Benin</option>\
                                <option value="BM">Bermuda</option>\
                                <option value="BT">Bhutan</option>\
                                <option value="BO">Bolivia</option>\
                                <option value="BA">Bosnia and Herzegovina</option>\
                                <option value="BW">Botswana</option>\
                                <option value="BV">Bouvet Island</option>\
                                <option value="BR">Brazil</option>\
                                <option value="IO">British Indian Ocean Territory</option>\
                                <option value="BN">Brunei Darussalam</option>\
                                <option value="BG">Bulgaria</option>\
                                <option value="BF">Burkina Faso</option>\
                                <option value="BI">Burundi</option>\
                                <option value="KH">Cambodia</option>\
                                <option value="CM">Cameroon</option>\
                                <option value="CA">Canada</option>\
                                <option value="CV">Cape Verde</option>\
                                <option value="KY">Cayman Islands</option>\
                                <option value="CF">Central African Republic</option>\
                                <option value="TD">Chad</option>\
                                <option value="CL">Chile</option>\
                                <option value="CN">China</option>\
                                <option value="CX">Christmas Island</option>\
                                <option value="CC">Cocos (Keeling) Islands</option>\
                                <option value="CO">Colombia</option>\
                                <option value="KM">Comoros</option>\
                                <option value="CG">Congo</option>\
                                <option value="CD">Congo, the Democratic Republic of the</option>\
                                <option value="CK">Cook Islands</option>\
                                <option value="CR">Costa Rica</option>\
                                <option value="CI">Cote D\'Ivoire</option>\
                                <option value="HR">Croatia</option>\
                                <option value="CU">Cuba</option>\
                                <option value="CY">Cyprus</option>\
                                <option value="CZ">Czech Republic</option>\
                                <option value="DK">Denmark</option>\
                                <option value="DJ">Djibouti</option>\
                                <option value="DM">Dominica</option>\
                                <option value="DO">Dominican Republic</option>\
                                <option value="EC">Ecuador</option>\
                                <option value="EG">Egypt</option>\
                                <option value="SV">El Salvador</option>\
                                <option value="GQ">Equatorial Guinea</option>\
                                <option value="ER">Eritrea</option>\
                                <option value="EE">Estonia</option>\
                                <option value="ET">Ethiopia</option>\
                                <option value="FK">Falkland Islands (Malvinas)</option>\
                                <option value="FO">Faroe Islands</option>\
                                <option value="FJ">Fiji</option>\
                                <option value="FI">Finland</option>\
                                <option value="FR">France</option>\
                                <option value="GF">French Guiana</option>\
                                <option value="PF">French Polynesia</option>\
                                <option value="TF">French Southern Territories</option>\
                                <option value="GA">Gabon</option>\
                                <option value="GM">Gambia</option>\
                                <option value="GE">Georgia</option>\
                                <option value="DE">Germany</option>\
                                <option value="GH">Ghana</option>\
                                <option value="GI">Gibraltar</option>\
                                <option value="GR">Greece</option>\
                                <option value="GL">Greenland</option>\
                                <option value="GD">Grenada</option>\
                                <option value="GP">Guadeloupe</option>\
                                <option value="GU">Guam</option>\
                                <option value="GT">Guatemala</option>\
                                <option value="GN">Guinea</option>\
                                <option value="GW">Guinea-Bissau</option>\
                                <option value="GY">Guyana</option>\
                                <option value="HT">Haiti</option>\
                                <option value="HM">Heard Island and Mcdonald Islands</option>\
                                <option value="VA">Holy See (Vatican City State)</option>\
                                <option value="HN">Honduras</option>\
                                <option value="HK">Hong Kong</option>\
                                <option value="HU">Hungary</option>\
                                <option value="IS">Iceland</option>\
                                <option value="IN">India</option>\
                                <option value="ID">Indonesia</option>\
                                <option value="IR">Iran, Islamic Republic of</option>\
                                <option value="IQ">Iraq</option>\
                                <option value="IE">Ireland</option>\
                                <option value="IL">Israel</option>\
                                <option value="IT">Italy</option>\
                                <option value="JM">Jamaica</option>\
                                <option value="JP">Japan</option>\
                                <option value="JO">Jordan</option>\
                                <option value="KZ">Kazakhstan</option>\
                                <option value="KE">Kenya</option>\
                                <option value="KI">Kiribati</option>\
                                <option value="KP">Korea, Democratic People\'s Republic of</option>\
                                <option value="KR">Korea, Republic of</option>\
                                <option value="KW">Kuwait</option>\
                                <option value="KG">Kyrgyzstan</option>\
                                <option value="LA">Lao People\'s Democratic Republic</option>\
                                <option value="LV">Latvia</option>\
                                <option value="LB">Lebanon</option>\
                                <option value="LS">Lesotho</option>\
                                <option value="LR">Liberia</option>\
                                <option value="LY">Libyan Arab Jamahiriya</option>\
                                <option value="LI">Liechtenstein</option>\
                                <option value="LT">Lithuania</option>\
                                <option value="LU">Luxembourg</option>\
                                <option value="MO">Macao</option>\
                                <option value="MK">Macedonia, the Former Yugoslav Republic of</option>\
                                <option value="MG">Madagascar</option>\
                                <option value="MW">Malawi</option>\
                                <option value="MY">Malaysia</option>\
                                <option value="MV">Maldives</option>\
                                <option value="ML">Mali</option>\
                                <option value="MT">Malta</option>\
                                <option value="MH">Marshall Islands</option>\
                                <option value="MQ">Martinique</option>\
                                <option value="MR">Mauritania</option>\
                                <option value="MU">Mauritius</option>\
                                <option value="YT">Mayotte</option>\
                                <option value="MX">Mexico</option>\
                                <option value="FM">Micronesia, Federated States of</option>\
                                <option value="MD">Moldova, Republic of</option>\
                                <option value="MC">Monaco</option>\
                                <option value="MN">Mongolia</option>\
                                <option value="MS">Montserrat</option>\
                                <option value="MA">Morocco</option>\
                                <option value="MZ">Mozambique</option>\
                                <option value="MM">Myanmar</option>\
                                <option value="NA">Namibia</option>\
                                <option value="NR">Nauru</option>\
                                <option value="NP">Nepal</option>\
                                <option value="NL">Netherlands</option>\
                                <option value="AN">Netherlands Antilles</option>\
                                <option value="NC">New Caledonia</option>\
                                <option value="NZ">New Zealand</option>\
                                <option value="NI">Nicaragua</option>\
                                <option value="NE">Niger</option>\
                                <option value="NG">Nigeria</option>\
                                <option value="NU">Niue</option>\
                                <option value="NF">Norfolk Island</option>\
                                <option value="MP">Northern Mariana Islands</option>\
                                <option value="NO">Norway</option>\
                                <option value="OM">Oman</option>\
                                <option value="PK">Pakistan</option>\
                                <option value="PW">Palau</option>\
                                <option value="PS">Palestinian Territory, Occupied</option>\
                                <option value="PA">Panama</option>\
                                <option value="PG">Papua New Guinea</option>\
                                <option value="PY">Paraguay</option>\
                                <option value="PE">Peru</option>\
                                <option value="PH">Philippines</option>\
                                <option value="PN">Pitcairn</option>\
                                <option value="PL">Poland</option>\
                                <option value="PT">Portugal</option>\
                                <option value="PR">Puerto Rico</option>\
                                <option value="QA">Qatar</option>\
                                <option value="RE">Reunion</option>\
                                <option value="RO">Romania</option>\
                                <option value="RU">Russian Federation</option>\
                                <option value="RW">Rwanda</option>\
                                <option value="SH">Saint Helena</option>\
                                <option value="KN">Saint Kitts and Nevis</option>\
                                <option value="LC">Saint Lucia</option>\
                                <option value="PM">Saint Pierre and Miquelon</option>\
                                <option value="VC">Saint Vincent and the Grenadines</option>\
                                <option value="WS">Samoa</option>\
                                <option value="SM">San Marino</option>\
                                <option value="ST">Sao Tome and Principe</option>\
                                <option value="SA">Saudi Arabia</option>\
                                <option value="SN">Senegal</option>\
                                <option value="CS">Serbia and Montenegro</option>\
                                <option value="SC">Seychelles</option>\
                                <option value="SL">Sierra Leone</option>\
                                <option value="SG">Singapore</option>\
                                <option value="SK">Slovakia</option>\
                                <option value="SI">Slovenia</option>\
                                <option value="SB">Solomon Islands</option>\
                                <option value="SO">Somalia</option>\
                                <option value="ZA">South Africa</option>\
                                <option value="GS">South Georgia and the South Sandwich Islands</option>\
                                <option value="ES">Spain</option>\
                                <option value="LK">Sri Lanka</option>\
                                <option value="SD">Sudan</option>\
                                <option value="SR">Suriname</option>\
                                <option value="SJ">Svalbard and Jan Mayen</option>\
                                <option value="SZ">Swaziland</option>\
                                <option value="SE">Sweden</option>\
                                <option value="CH">Switzerland</option>\
                                <option value="SY">Syrian Arab Republic</option>\
                                <option value="TW">Taiwan, Province of China</option>\
                                <option value="TJ">Tajikistan</option>\
                                <option value="TZ">Tanzania, United Republic of</option>\
                                <option value="TH">Thailand</option>\
                                <option value="TL">Timor-Leste</option>\
                                <option value="TG">Togo</option>\
                                <option value="TK">Tokelau</option>\
                                <option value="TO">Tonga</option>\
                                <option value="TT">Trinidad and Tobago</option>\
                                <option value="TN">Tunisia</option>\
                                <option value="TR">Turkey</option>\
                                <option value="TM">Turkmenistan</option>\
                                <option value="TC">Turks and Caicos Islands</option>\
                                <option value="TV">Tuvalu</option>\
                                <option value="UG">Uganda</option>\
                                <option value="UA">Ukraine</option>\
                                <option value="AE">United Arab Emirates</option>\
                                <option value="GB">United Kingdom</option>\
                                <option value="US">United States</option>\
                                <option value="UM">United States Minor Outlying Islands</option>\
                                <option value="UY">Uruguay</option>\
                                <option value="UZ">Uzbekistan</option>\
                                <option value="VU">Vanuatu</option>\
                                <option value="VE">Venezuela</option>\
                                <option value="VN">Viet Nam</option>\
                                <option value="VG">Virgin Islands, British</option>\
                                <option value="VI">Virgin Islands, U.S.</option>\
                                <option value="WF">Wallis and Futuna</option>\
                                <option value="EH">Western Sahara</option>\
                                <option value="YE">Yemen</option>\
                                <option value="ZM">Zambia</option>\
                                <option value="ZW">Zimbabwe</option>\
                            </select>';
                            
                    }
                
                    function getOptionIndex(theElement, yy) {
                        
                        var select = theElement; //get a reference to the select object
                        for (var i = 0; i < select.options.length; i++) {
                            if (select.options[i].value == yy) {
                                return i;
                            }
                        }
                        return -1;
                    }
                    
                
                   function docollapse(thingstring) {
                       var linkstring = thingstring+"-title";
                       
                       thing = document.getElementById(thingstring);
                       link = document.getElementById(linkstring);

                       if (thing.style.height == '') {
                         //  thing.style.visibility = 'hidden';
                           thing.style.height = '0px';
                           thing.style.display = 'none';
                           link.innerHTML = link.innerHTML.split("-").join("+");

                       } else {
                          // thing.style.visibility = 'visible'
                           thing.style.height = '';
                           thing.style.display = '';

                           link.innerHTML = link.innerHTML.split("+").join("-");

                       }
                       
                       fixtextfields() ;
                   }
                   
                   function fixtextfields() {
                   if(document.getElementById("txtcolor") != null) {
                           repositiontextfield(document.getElementById("color"));
                           repositiontextfield(document.getElementById("family"));
                           repositiontextfield(document.getElementById("size"));
                           repositiontextfield(document.getElementById("extra"));
                        }
                    }
                   // -->
                  </script>
                <?php if(isset($saved)) { ?>
                <div class='updated fade'><p><?php if(isset($message)) { echo $message; } else { ?>Link saved. <code><?php echo $url; ?><?php echo $entry->from;?></code>. <a href="admin.php?page=wplink-manage&action=new&ID=new">Click here to create a new link.</a><?php } ?></p></div>
                
                <?php } ?>
    
                <style type='text/css'>
        			tbody { border: 1px solid #CCCCCC; }
                                .submenubox { border: 1px solid #888; }
    		</style>
                <form name="editentry" id="editentry" method="post" action="admin.php?page=wplink-manage" class="validate">
                <input type="hidden" name="action" value="do-edit" />
                <input type="hidden" name="ID" value="<?php echo $ID; ?>" />
                <?php wp_original_referer_field(true, 'previous'); wp_nonce_field('update-entry_' . $ID); ?>
                        <table class="form-table">
                            <tbody id='top'>
                            <tr class="form-field form-required">
                                <th scope="row" valign="top"><label for="link_title"><?php _e('Link Text') ?></label></th>
                                <td><input name="link_title" id="link_title" style='width: 280px' type="text" value="<?php if(isset($_POST['link_title'])) { echo attribute_escape($_POST['link_title']); } else { echo attribute_escape($entry->link_title); } ?>" size="40" aria-required="true" /></td>
                            </tr>
                            </tbody>
                            <tr class="title"><td colspan='2'><strong><a href="javascript:docollapse('meta');" id="meta-title">[+] Meta Options</a></strong></td></tr>
                                
                            <tbody id='meta' class='submenubox'>
                            <tr class='form-field form-required'>
                                <th scope='row' valign='top'><label for='name'><?php _e("Internal Name"); ?></label></th>
                                <td><input name='name' id='name' type='text' style='width:250px;' value='<?php if(isset($_POST['name'])) { echo attribute_escape($_POST['name']); } else { echo attribute_escape($entry->name); } ?>' />
                                <br /><span class='setting-description'>If you don't specify this, link text is used.</span></td>
                            </tr>
                            <tr class='form-field form-required'>
                                <th scope='row' valign='top'><label for='title'><?php _e("Title Attribute"); ?></label></th>
                                <td><input name='title' id='title' type='text' style='width:200px;' value='<?php if(isset($_POST['title'])) { echo attribute_escape($_POST['title']); } else { echo attribute_escape($entry->title); } ?>' /></td>
                            </tr>
                            <tr class='form-field form-required'>
                                <th scope='row' valign='top'><label for='class'><?php _e("Class Attribute"); ?></label></th>
                                <td><input name='class' id='class' type='text' style='width:100px;' value='<?php if(isset($_POST['class'])) { echo attribute_escape($_POST['class']); } else { echo attribute_escape($entry->class); } ?>' /></td>
                            </tr>
                            <tr class='form-field form-required'>
                                <th scope='row' valign='top'><label for='target'><?php _e("Target Attribute"); ?></label></th>
                                <td><input name='target' id='target' type='text' style='width:100px;' value='<?php if(isset($_POST['target'])) { echo attribute_escape($_POST['target']); } else { echo attribute_escape($entry->target); } ?>' /><br /><span class="setting-description">Use _blank or _new to force a new window</span></td>
                            </tr>
                            <tr class="form-field form-required">
                                <th scope="row" valign="top"><label for="group"><?php _e('Group / Note') ?><br /><small>(optional)</small></label></th>
                                <td><input name="group" id="group" type="text" value="<?php if(isset($_POST['group'])) { echo attribute_escape($_POST['group']); } else { echo attribute_escape($entry->group); } ?>" style="width:200px;" aria-required="true" /></td>
                            </tr>
                            </tbody>
                            
                            <tbody id='middle'>                            
                            <tr class="form-field form-required">
                                <th scope="row" valign="top"><label for="from"><?php _e('Slug') ?> (<em>from</em>)</label></th>
                                <td><strong><?php echo $url; ?></strong><input name="from" id="from" type="text" style="width:150px;" value="<?php if(isset($_POST['from'])) { echo attribute_escape($_POST['from']); } else { echo attribute_escape($entry->from); } ?>" size="40" aria-required="true" /><br />
                                <span class="setting-description"> It is important that this field only contains letters, numbers, ".", "-" and "_".</span>
                                </td>
                            </tr>
                            
                            <tr class="form-field form-required">
                                <th scope="row" valign="top"><label for="to"><?php _e('Primary Destination') ?> (<em>to</em>)</label>
                                    <a href="#" class="hintanchor" onMouseover="showhint('Specify one, or multiple primary destinations to have them rotated according to the percentages listed on their right. Other links such as geotargetted links and multi-destination cannot be directly rotated, because you can effectively nest Link Engine links by creating multiple rotated links and using them within your primary link.', this, event, '375px')">[?]</a>
                                </th>
                                <td>
                                    <span id='destination_block'>
                                        <script type='text/javascript'>
                                        <?php
                                        $first = "true";
                                        $count = 0;

                                        
                                        for($i=0;$i<count($_POST);$i++) {
                                            if(isset($_POST['dest_to_'.$i]) && !empty($_POST['dest_to_'.$i])) {
                                                $weight = intval($_POST['weight_' . $i]);
                                                $destination = trim($_POST['dest_to_' . $i]);
                                                
                                                $count++;
                                                echo "newdestrule($first, true, '{$destination}', '{$weight}');";
                                                $first = "false";
                                            }
                                        }
                    
                    
                                        if(isset($dest)) {
                                            $destinations = $dest;
                                        } else {
                                            $destinations = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_destinations` WHERE `link_id`='{$entry->id}'");
                                        }
                                        
                                        foreach($destinations as $destination) {
                                            $count++;
                                            echo "newdestrule($first, true, '{$destination->destination}', '{$destination->weight}');";
                                            $first = "false";
                                        }
                                        
                                        if($count == 0) echo "newdestrule(true, true, '','');";
                                   
                                        
                                        ?>
                                       </script>
                                    </span> <a href="javascript:newdestrule(false, '', '')">Add Rule</a><br />
                                    
                                <span class="setting-description">This should begin with a proper URL scheme, such as "http," "https" or "ftp."</span><br />
                                <div align='center'><strong> - or - </strong></div>
                                ...to a WordPress post: <select name='to_post'>
                                    <option value=''></option>
                                    <?php
                                        $posts = get_posts();
                                        foreach($posts as $post) {
                                            echo "<option value='" . $post->ID . "' ";
                                                if($post->ID == $entry->post_id || $_POST['to_post'] == $post->ID) echo "selected='selected'";
                                            echo ">" . get_the_title($post->ID) . "</option>";  
                                        }
                                    ?>
                                </select><br />
                                ...or a WordPress page: <select name='to_page'>
                                    <option value=''></option>
                                    <?php
                                        $posts = get_pages();
                                        foreach($posts as $post) {
                                            echo "<option value='" . $post->ID . "' ";
                                                if($post->ID == $entry->post_id || $_POST['to_page'] == $post->ID) echo "selected='selected'";
                                            echo ">" . get_the_title($post->ID) . "</option>";  
                                        }
                                    ?>
                                </select><br />
                                
                                
                                </td>
                            </tr>
                            </tbody>
                            <tr class="title"><td colspan='2'><strong><a href="javascript:docollapse('morelinks');" id="morelinks-title">[+] Geotargeting/Multiple Destination Options</a></strong></td></tr>
                            
                            <tbody id='morelinks' class='submenubox'>

                                <tr>
                                <th scope='row' valign='top'><label for='geoform'><?php _e("Geotargetted Destinations"); ?></label></th>
                                <td>
                                    <span id='geotargetting'>
                                    <script type='text/javascript'>
                                    <?php 
                                        $first = "true";
                                        $count=0;
                                        for($i=0;$i<count($_POST);$i++) {
                                            if(isset($_POST['to_'.$i]) && !empty($_POST['to_'.$i])) {
                                                $countrycode = trim($_POST['ccode_' . $i]);
                                                $destination = trim($_POST['to_' . $i]);
                                                $count++;
                                                
                                                echo "newccoderule($first, '$countrycode', '$destination');";
                                                $first = "false";
                                            }
                                        }
				   
                                        if(isset($geo)) {
                                            $countries = $geo;
                                        } else {
                                            $countries = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_geo_links` WHERE `link_id`='{$entry->id}'");
                                        }
                                        
                                        foreach($countries as $country) {
                                            $count++;
                                            echo "newccoderule($first, '{$country->countrycode}', '{$country->destination}');";
                                            $first = "false";
                                        }
                                        
                                        if($count == 0) echo "newccoderule(true, '','');";
                                    ?>
                                    
                                    </script></span> <a href="javascript:newccoderule(false, '', '');">Add Rule</a><br />
                                    
                                    <span class='setting-description'>The "to" URL above will be used for any georesults that do not match these rules. Please do not specify more than one URL per country code.</span>
                              
                                </td></tr>
                               
                            
                                <tr>
                                <th scope='row' valign='top'><label for='destinations'><?php _e("Multiple Destinations"); ?></label></th>
                                <td><textarea name='destinations' style='width:80%'><?php echo attribute_escape($entry->destinations); ?></textarea><br />
                                <span class='setting-description'>One per line. This works by creating a Javascript popup for each extra destination (the "to" destination above, being the primary link destination).<br />
                                This will only work on browsers that do not block the popup &mdash; since the popup is created on click, this includes most modern browsers, but not recent versions of Internet Explorer.</span></td>
                                </tr>
                                
                                
                            </tbody>
                                <tr class="title"><td colspan='2'><strong><a href="javascript:docollapse('expirelinks');" id="expirelinks-title">[+] Expiration Options</a></strong></td></tr>
                            
                            <tbody id='expirelinks' class='submenubox'>
                                <tr>
                                <th scope='row' valign='top'><label for='expired'><?php _e("Expiration Date"); ?></label></th>
                                <td>
                                    <input type='text' name='expired' id='expired' value='<?php if(intval($entry->expired) != 0) { echo date("Y-m-d H:i:s", $entry->expired); } ?>' /><br />
                                    <span class='setting-description'>Leave blank to never expire, otherwise, enter a date and time like "December 14th, <?php echo date("Y", strtotime("+1 year")); ?> 4:15 PM".</span>
                                </td>
                                </tr>
                                
                                <tr>
                                <th scope='row' valign='top'><label for='expire_url'><?php _e("Expired Link Destination"); ?></label></th>
                                <td>
                                    <input type='text' name='expire_url' style='width:80%;' id='expire_url' value='<?php if(isset($_POST['expire_url'])) { echo $_POST['expire_url']; } else { echo ($entry->expire_url); } ?>' />
                                </td>
                                </tr>
                                
                                
                                </tbody>    
                                
                           
                                    
                            <tr class="title"><td colspan='2'><strong><a href="javascript:docollapse('ua');" id="ua-title">[+] User Agent Options</a></strong></td></tr>
                            
                            <tbody id='ua' class='submenubox'>
                            <tr>
                                <th scope='row' valign='top'><label for='uatargeting'><?php _e("...by User Agent"); ?></label></th>
                                <td>
                                    <span id='uatargeting'><script type='text/javascript'>
                                    <?php 
                                        $first = "true";
                                        $count=0;
                                        for($i=0;$i<count($_POST);$i++) {
                                            if(isset($_POST['full_'.$i]) && !empty($_POST['full_'.$i])) {
                                                $ua = trim($_POST['full_' . $i]);
                                                $uan = trim($_POST['not_' . $i]);
                                                
                                                $destination = trim($_POST['dest_ua_' . $i]);
                                                      
                                                $count++;
                                                echo "newuarule($first, '$ua','$uan', $destination');";
						$first = "false";
                                            }
                                        }
				
                                        if(isset($_ua)) { 
                                            $hostnames = $_ua;
                                        } else {
                                            $hostnames = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_user_agent` WHERE `link_id`='{$entry->id}'");
                                        }
                                        
                                        foreach($hostnames as $host) {
                                            $count++;
                                            echo "newuarule($first, '{$host->full}', '{$host->not}',  '{$host->destination}');";
                                            $first = "false";
                                        }
                                        
                                        if($count == 0) echo "newuarule(true, '','','');";
                                    ?>
                                    
                                    </script>
                                    </span> <a href="javascript:newuarule(false, '', '','');">Add Rule</a><br />
                                    <span class='setting-description'>
                                        <p>Enter any fragment of a user agent string, a complete string in quotes (use * as a wildcard) or begin and end your string with / to have it parsed as a <a href="http://en.wikipedia.org/wiki/Regular_expression">regular expression</a>. </p>
                                        <p>As an example, if you'd like to show users with the string "Zedo" anywhere within their user agent, but NOT "FunWebProducts" (i.e., Mozilla/Zedo goes to the new URL, but Mozilla/Zedo FunWebProducts doesn't) a different URL, in the checkmarks box type <code>Zedo</code>, and in the red x box type <code>FunWebProducts</code>). </span>
                                </td>
                                </tr>
                            </tbody>
                            
                            <tr class="title"><td colspan='2'><strong><a href="javascript:docollapse('restrictions');" id="restrictions-title">[+] IP/Company Options</a></strong></td></tr>
                            
                            <tbody id='restrictions' class='submenubox'>
                                <tr>
                                <th scope='row' valign='top'><label for='arintargeting'><?php _e("...by Intelligent 'Company' Range"); ?></label></th>
                                <td>
                                    <span id='arintargeting'><script type='text/javascript'>
                                    <?php 
                                        $first = "true";
                                        $count=0;
                                        for($i=0;$i<count($_POST);$i++) {
                                            if(isset($_POST['arin_'.$i]) && !empty($_POST['arin_'.$i])) {
                                                $ipa = trim($_POST['arin_' . $i]);
                                                $destination = trim($_POST['dest_arin_' . $i]);
                                                      
                                                $count++;
                                                echo "newarinrule($first, '$ipa', '$destination');";
                                                $first = "false";
                                            }
                                        }
				
                                        if(isset($_arin)) { 
                                            $hostnames = $_arin;
                                        } else {
                                            $hostnames = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_restrictions` WHERE `link_id`='{$entry->id}' AND `arin`!=''");
                                        }
                                        
                                        foreach($hostnames as $host) {
                                            $count++;
                                            echo "newarinrule($first, '{$host->arin}', '{$host->destination}');";
                                            $first = "false";
                                        }
                                        
                                        if($count == 0) echo "newarinrule(true, '','');";
                                    ?>
                                    
                                    </script>
                                    </span> <a href="javascript:newarinrule(false, '', '');">Add Rule</a><br />
                                    <span class='setting-description'>Enter a company name in lower case. This works by querying ARIN for whatever you enter &mdash; it requires a query format that is basically a lower case company name like "facebook" or "google".
                                    If you want to run an ARIN query to check what its going to return, run it here <a href="http://ws.arin.net/whois/?queryinput=">ARIN WHOIS UI</a>. 
                                    <br /><small>Note: The script automatically adds a - to the beginning of your string to ensure it comes back in the right format. These queries are cached for <?php echo WPLINK_QUERY_CACHE/60/60/24; ?> days.</small>
                                    </span>
                                </td>
                                </tr>
                                <tr>
                                <th scope='row' valign='top'><label for='ipotargeting'><?php _e("...by IP Address / Range"); ?></label></th>
                                <td>
                                    <span id='ipotargetting'><script type='text/javascript'>
                                    <?php 
                                        $first = "true";
                                        $count=0;
                                        for($i=0;$i<count($_POST);$i++) {
                                            if(isset($_POST['ip_'.$i]) && !empty($_POST['ip_'.$i])) {
                                                $ipa = trim($_POST['ip_' . $i]);
                                                $destination = trim($_POST['dest_ip_' . $i]);
                                                      
                                                $count++;
                                                echo "newiprule($first, '$ipa', '$destination');";
                                                $first = "false";
                                            }
                                        }
				
                                        if(isset($_ip)) { 
                                            $hostnames = $_ip;
                                        } else {
                                            $hostnames = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_restrictions` WHERE `link_id`='{$entry->id}' AND `ip`!=''");
                                        }
                                        
                                        foreach($hostnames as $host) {
                                            $count++;
                                            echo "newiprule($first, '{$host->ip}', '{$host->destination}');";
                                            $first = "false";
                                        }
                                        
                                        if($count == 0) echo "newiprule(true, '','');";
                                    ?>
                                    
                                    </script>
                                    </span> <a href="javascript:newiprule(false, '', '');">Add Rule</a><br />
                                    <span class='setting-description'>Enter an IP, part of an IP (for partial match) or an IP range and a destination to be redirected to. Leave the destination field blank to have the user fall right through to a Not Found page.</span>
                                </td>
                                </tr>
                                <tr>
                                <th scope='row' valign='top'><label for='resolveotargeting'><?php _e("...by Hostname"); ?></label>
                                <a href="#" class="hintanchor" onMouseover="showhint('A hostname is a resolved IP address. Its basically an IP address with a name. IP Tools.com will let you research hostnames, but so will the hostnames section of Google Analytics and many statistical packages.', this, event, '375px')">[?]</a>
                                </th>
                                <td>
                                    <span id='resolveotargetting'>
                                    <script type='text/javascript'>
                                    <?php 
                                        $first = "true";
                                        $count=0;
                                        
                                                            
                                        for($i=0;$i<count($_POST);$i++) {
                                            if(isset($_POST['host_'.$i]) && !empty($_POST['host_'.$i])) {
                                                $hostna = trim($_POST['host_' . $i]);
                                                $destination = trim($_POST['dest_host_' . $i]);
                                                
                                                $count++;
                                                echo "newhostrule($first, '$hostna', '$destination');";
                                                $first = "false";
                                            }
                                        }
                                        
                                        if(isset($_host)) {
                                            $hostnames = $_host;
                                        } else {
                                            $hostnames = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_restrictions` WHERE `link_id`='{$entry->id}' AND `hostname`!=''");
                                        }
                                        
                                        foreach($hostnames as $host) {
                                            $count++;
                                            echo "newhostrule($first, '{$host->hostname}', '{$host->destination}');";
                                            $first = "false";
                                        }
                                        
                                        if($count == 0) echo "newhostrule(true, '','');";
                                    ?>
                                    
                                    </script>
                                    </span> <a href="javascript:newhostrule(false, '', '');">Add Rule</a><br />
                                    <span class='setting-description'>
                                        Enter a resolved IP or hostname and a destination to redirect to. Use * anywhere within hostname to indicate a wildcard.                                    
                                    </span>
                                </td>
                                </tr>
                                <tr>
                                <th scope='row' valign='top'><label for='referotargeting'><?php _e("...by Referrer"); ?></label></th>
                                <td>
                                    <span id='refotargetting'>
                                    
                                    <script type='text/javascript'>
                                    <?php 
                                        $first = "true";
                                        $count=0;                                        
                                                               
                                        for($i=0;$i<count($_POST);$i++) {
                                            if(isset($_POST['ref_'.$i]) && !empty($_POST['ref_'.$i])) {
                                                $refer = trim($_POST['ref_' . $i]);
                                                $destination = trim($_POST['dest_ref_' . $i]);
                                                
                                                $count++;
                                                echo "newrefrule($first, '$refer', '$destination');";
                                                $first = "false";
                                            }
                                        }
                                             
                                              
                                        if(isset($_ref)) {
                                            $hostnames = $_ref;
                                        } else {
                                            $hostnames = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_restrictions` WHERE `link_id`='{$entry->id}' AND `referrer`!=''");
                                        }
                                        foreach($hostnames as $host) {
                                            $count++;
                                            echo "newrefrule($first, '{$host->referrer}', '{$host->destination}');";
                                            $first = "false";
                                        }
                                        
                                        if($count == 0) echo "newrefrule(true, '','');";
                                    ?>
                                    
                                    </script>
                                    </span> <a href="javascript:newrefrule(false, '', '');">Add Rule</a><br />
                                    <span class='setting-description'>
                                        Enter a referrer and a destination to redirect to. Use * anywhere within referrer to indicate a wildcard.                                    
                                    </span>
                                </td>
                                </tr>
                                
                            </tbody>
                                 
                           <tr class="title"><td colspan='2'><strong><a href="javascript:docollapse('varforward');" id="varforward-title">[+] URL Variable Forwarding</a></strong></td></tr>

                            <tbody id='varforward' class='submenubox'>
                                <tr>
                                <th scope='row' valign='top'><label for='vars'><?php _e("Variables to Forward"); ?></label></th>
                                <td>
                                    <input type='text' name='vars' id='vars' value='<?php if(($entry->vars) != "") { echo $entry->vars; } ?>' /><br />
                                    <span class='setting-description'>A comma separated list of variables here will be forwarded on links from the one's past to your landing page. This only works when the links are used within WordPress (as in, on a post or page). As an example, if you specify "a" here, and then post your link on a page, THEN send visitors to that page with ?a=1 on the URL, ?a=1 will be forwarded on to the destination.</span>
                                </td>
                                </tr>

                                <tr>
                                <th scope='row' valign='top'><label for='forwarding'><?php _e("Extra Options"); ?></label></th>
                                <td><input style='width:18px;' type='checkbox' name='forwarding' id='forwarding' value='1' <?php if($entry->forwarding == 1 || $ID=="" || $_POST['forwarding']==1) echo " checked='checked'"; ?> /> Forward query string variables to the destination (ex. yourslug?a=1 -> destination?a=1).
                                <a href="#" class="hintanchor" onMouseover="showhint('Disable query string forwarding to prevent URLs like www.yoursite.com/yourslug?a=1 from going to yourdestination.com/?a=1, rather it will go to yourdestination.com/', this, event, '375px')">[?]</a>
                                <br />
                                <input style='width:18px;' type='checkbox' name='subid' id='subid' value='1' <?php if($entry->subid == 1 || $ID == "" || $_POST['subid']==1) echo " checked='checked'"; ?> /> Allow subid campaigns &mdash; track individual statistics with URLs like yourslug<strong>/subid</strong>.
                                <a href="#" class="hintanchor" onMouseover="showhint('Subid tracking allows you to on-the-fly define new links... like yoursite.com/yourslug/subcampaign which will be tracked independently of just yoursite.com/yourslug.', this, event, '375px')">[?]</a>
                                <br />
                                </td>
                                </tr>

                            </tbody>

                            <tr class="title"><td colspan='2'><strong><a href="javascript:docollapse('bulk');" id="bulk-title">[+] Mass Import Settings</a></strong></td></tr>

                            <tbody id='bulk' class='submenubox'>
                                <tr>
                                <th scope='row' valign='top'><label for='bulkips'><?php _e("IP Addresses"); ?></label></th>
                                <td>
                                    <textarea name="bulkips" cols="50" rows="8"> <?php echo $_POST['bulkips']; ?></textarea><br />
                                    <span class="settings-description">Paste IP addresses, partials or ranges here seperated by newlines. If you want to specify destinations, separate them with pipe characters (|). ex. <code>24.71.70.201|http://www.google.com/</code></span><br />
                                    <br />
                                    Destination: <input type="text" style="width:80%" value="<?php echo $_POST['bulkipdestination']; ?>" name="bulkipdestination" /><br />
                                    <span class="settings-description">Bulk IP addresess which do not have destinations specified with pipes will use this one.</span><br />
                                    <br /> 
                                    <input type="checkbox" name="bulkipremove" value="1" <?php if($_POST['bulkipremove'] == 1) echo "checked"; ?> /> Clear existing IP-based redirects (from above) before applying these.<br />
                                    <input type="checkbox" name="bulkipoverwrite" <?php if($_POST['bulkipoverwrite'] == 1 || !isset($_POST['bulkipoverwrite'])) echo "checked"; ?> value="1" /> Allow bulk IPs to overwrite existing (on duplicate).<br />
                                </td>
                                </tr>


                            </tbody>

                            <tbody id='cloaking-main'>
                            
                            <tr class="form-field form-required">
                                <th scope="row" valign="top"><label for="cloaked"><?php _e('Redirect Type') ?></label>
                                <a href="#" class="hintanchor" onMouseover="showhint('If you select the Guaranteed Blank Referrer (Guaranteed Wipe) redirect system, your referrer information will NEVER be sent on. Please specify an Alternate URL within \'Extra Cloaking Options\' for users to be directed to if the referrer cannot be wiped. Note that this does not apply to the expired link or restricted link destinations... because it actually doesn\'t really make sense in that context.', this, event, '375px')">[?]</a>
                                </th>
                                <td><select name='cloaked'>
                                    <option value=''<?php if($entry->cloaked == "" || (isset($_POST['cloaked']) && $_POST['cloaked'] == "")) echo " selected='selected'";?>>301 Redirect (permanent)</option>
                                    <option value='302'<?php if($entry->cloaked == "302" || $_POST['cloaked'] == "302") echo " selected='selected'";?>>302 Redirect (found)</option>
                                    <option value='307'<?php if($entry->cloaked == "307" || $_POST['cloaked'] == "307") echo " selected='selected'";?>>307 Redirect (temporary)</option>
                                    <!--<option value='1'<?php if($entry->cloaked == "1" || $_POST['cloaked'] == "1") echo " selected='selected'";?>>Single Meta Refresh</option>-->
                                    <option value='2'<?php if($entry->cloaked == "2" || $_POST['cloaked'] == "2") echo " selected='selected'";?>>Double Meta Refresh (Referrer Scrubbing)</option>
                                    <option value='js'<?php if($entry->cloaked == "js" || $_POST['cloaked'] == "js") echo " selected='selected'";?>>Javascript Redirect (Stealth)</option>
                                    <option value='js2'<?php if($entry->cloaked == "js2" || $_POST['cloaked'] == "js2") echo " selected='selected'";?>>Javascript + Meta Redirect (Stealth/Scrub)</option>
                                    <option value='frame'<?php if($entry->cloaked == "frame" || $_POST['cloaked'] == "frame") echo " selected='selected'";?>>Framed Page (URL Hiding)</option>
                                    <option value='guaranteed'<?php if($entry->cloaked == "guaranteed" || $_POST['cloaked'] == "guaranteed") echo " selected='selected'";?>>Guaranteed Wipe (specify alt. URL in extra options)</option>
                                    <?php if(file_exists("redirects/custom-redirect.php")) { ?>
                                        <option value='custom'<?php if($entry->cloaked == "custom" || $_POST['cloaked'] == "custom") echo " selected='selected'";?>>Custom HTML</option>
                                    <?php } ?>
                                    </select></td>
                            </tr>
                            </tbody> 
                            <tr class="title"><td colspan='2'><strong><a href="javascript:docollapse('cloaking');">[+] Extra Cloaking Options</a></strong></td></tr>	
                                
                            <tbody id='cloaking' class='submenubox'>
                            <tr class='form-field form-required'>
                                <th scope='row' valign='top'><label for='meta_timer'><?php _e("Meta Refresh Length"); ?></label></th>
                                <td><input name='meta_timer' id='meta_timer' type='text' style='width:3em;'value='<?php if(isset($_POST['meta_timer'])) { echo attribute_escape($_POST['meta_timer']); } else { echo attribute_escape($entry->meta_timer); } ?>' />
                                <br /><span class='setting-description'>A longer length can increase the likelihood of blanking the referrer entirely. Over 4 seconds seems to be most likely to clear referrer in all browsers which will clear it, but longer lengths irritate visitors and may cause them to back out.</span></td>
                            </tr>
                            
                            <tr class="form-field form-required">
                                <th scope="row" valign="top"><label for="status_bar"><?php _e('Status Bar Text') ?></label></th>
                                <td>
                                    <input name="status_bar" style='width:65%' id="status_bar" type="text" value="<?php if(isset($_POST['status_bar'])) { echo attribute_escape($_POST['status_bar']); } else { echo attribute_escape($entry->status_bar); } ?>" aria-required="true" />
                                    <br /><span class='setting-description'>This attempts to cloak the URL displayed at the bottom left of the screen. Unreliable (works only in some old versions of Internet Explorer and Firefox if enabled).</span>
                                </td>
                            </tr>
                            <tr class="form-field form-required">
                                <th scope="row" valign="top"><label for="require_blank_fail"><?php _e('Alternate URL') ?></label><br /><small>Used when Guaranteed Wipe cannot find a method to blank the referrer.</small></th>
                                <td>
                                    <input type='text' name='require_blank_fail' style='width:80%;' id='require_blank_fail' value='<?php if(isset($_POST['require_blank_fail'])) { echo attribute_escape($_POST['require_blank_fail']); } else { echo attribute_escape($entry->require_blank_fail); } ?>' /><br />
                                    <span class='setting-description'>URL to forward users to if referrer cannot be blanked in guaranteed mode. Note, <strong>usually,</strong> the browsers Safari and Opera make it impossible to hide the referrer, meaning this URL is generally used for them. This URL could be used to redirect to a redirect script on another domain to <strong>mask</strong> rather than blank the referrer.</span>
                                </td>
                            </tr>
                            <tr class="form-field form-required">
                                <th scope="row" valign="top"><label for="nofollow"><?php _e('Search Engines') ?></label></th>
                                <td>
                                    <input type='checkbox' name='nofollow' id='nofollow' style='width:18px;' value='1' <?php if($entry->nofollow == 1 || $_POST['nofollow'] == 1) { echo 'checked="checked"'; } ?> /> Add 'rel="nofollow"' to link to prevent search engines from following it.<br />
                                </td>
                            </tr>
                            </tbody>
                            
                            <tbody id='bot'>

                            <tr class="form-field form-required">
                                <th scope="row" valign="top"><label for="filter"><?php _e('Automatch Links') ?>
                                <a href="#" class="hintanchor" onMouseover="showhint('Beyond the \'primary\' and \'slug\' checkbox, you usually don\'t want any of these. The other ones will replace direct links to the geotargetted, multiple destination, ban/restriction or the guaranteed wipe alternate URL link with the link to the short-link; meaning the destination will no longer mean the same thing.', this, event, '375px')">[?]</a>
                                </label></th>
                                <td>
                                    <input style='width:18px;' type='checkbox' name='match_primary' id='match_primary' value='1' <?php if($entry->replace_destinations & 1 || ($ID=="") || $_POST['match_primary'] == 1) { echo " checked='checked'"; } ?> /> Match primary destination links and replace with managed links.<br />
                                    <input style='width:18px;' type='checkbox' name='match_slug' id='match_slug' value='32' <?php if($entry->replace_destinations & 32 || ($ID=="") || $_POST['match_slug'] == 1) { echo " checked='checked'"; } ?> /> Match proper slug URL and replace with managed links.<br />
                                    <input style='width:18px;' type='checkbox' name='match_geos' id='match_geos' value='16' <?php if($entry->replace_destinations & 16 || $_POST['match_geos'] == 1) { echo " checked='checked'"; } ?> /> Match geotargetted links URLs and replace with managed link.<br />
                                    <input style='width:18px;' type='checkbox' name='match_multiple' id='match_multiple' value='2' <?php if($entry->replace_destinations & 2 || $_POST['match_multiple'] == 1) { echo " checked='checked'"; } ?>/> Match multiple destination URLs and replace with managed link.<br />
                                    <input style='width:18px;' type='checkbox' name='match_banned' id='match_banned' value='4' <?php if($entry->replace_destinations & 4 || $_POST['match_banned'] == 1) { echo " checked='checked'"; } ?>/> Match restriction URLs and replace with managed link.<br />
                                    <input style='width:18px;' type='checkbox' name='match_require_fail' id='match_require_fail' value='8' <?php if($entry->replace_destinations & 8 || $_POST['match_require_fail'] == 1) { echo " checked='checked'"; } ?>/> Match Guaranteed Wipe alternate URLs and replace with managed link.<br />
                                    
                                </td>
                            </tr>

                            <tr class="form-field form-required">
                                <th scope="row" valign="top"><label for="filter"><?php _e('Autolink Keywords') ?><br /><small>(comma delimited)</small></label></th>
                                <td><input name="filter" id="filter" type="text" value="<?php if(isset($_POST['filter'])) { echo attribute_escape($_POST['filter']); } else { echo attribute_escape($keywords); } ?>" size="40" aria-required="true" /><br />
					<input style='width:16px;' type='checkbox' name='auto_insensitive' value='1' <?php if($_POST['auto_insensitive']==1) { echo "checked='checked'"; } else { if($case == 1) echo "checked='checked'"; } ?>  /> Case sensitive.<br />
					<input style='width:16px;' type='checkbox' name='auto_whole' value='1' <?php if($_POST['auto_whole']==1) { echo "checked='checked'"; } else { if($whole == 1) echo "checked='checked'"; } ?> /> Whole words only.<br />
<!--					<input style='width:16px;' type='checkbox' name='auto_noth1' value='1' <?php if($_POST['auto_noth1']==1) { echo "checked='checked'"; } else { if($h1 == 1) echo "checked='checked'"; } ?> /> Avoid replacing words in title tags.--> <input type='hidden' name='auto_noth1' value='0' />

                                </td>
                            </tr>
                            
                            <tr class="form-field form-required">
                                <th scope="row" valign="top"><label for="style"><?php _e('Autolink Style') ?><br /><small>(applies to replaced keywords, leave blank for theme-defined formatting)</small></label></th>
                                <td>
                                    <table><tr><td><label for='color'>Color</label>:</td> <td><select name='color'<?php if (!preg_match("/MSIE/i", $agent)) { ?> class='comboBox' <?php } ?> id='color' style='width:150px;'>
                                                                        <option value=''></option>
                                                                        <option value='#FF0000'>Red</option>
                                                                        <option value='#00FF00'>Green</option>
                                                                        <option value='#0000FF'>Blue</option>
                                                                        <option value='#000000'>Black</option>
                                                                        <option value='#FFFFFF'>White</option>
                                                                        <option value='#CCCCCC'>Gray</option>                                                                        
                                                                        <?php if(!empty($color)) echo "<option value='{$color}' selected='selected'>{$color}</option>"; ?>
                                                                        
                                                                       </select></td></tr>
                                    
                                    <tr><td><label for='size'>Size</label>:</td> <td><select name='size'<?php if (!preg_match("/MSIE/i", $agent)) { ?> class='comboBox' <?php } ?> id='size'>
                                                                        <option value=''></option>
                                                                        <option value='8px'>8px</option>
                                                                        <option value='10px'>10px</option>
                                                                        <option value='12px'>12px</option>
                                                                        <option value='14px'>14px</option>
                                                                        <option value='16px'>16px</option>
                                                                        <option value='24px'>24px</option>
                                                                        <option value='32px'>32px</option>
                                                                        <option value='1em'>1em</option>
                                                                        <option value='10pt'>10pt</option>
                                                                        <option value='12pt'>12pt</option>
                                                                        <option value='14pt'>14pt</option>
                                                                        <?php if(!empty($size)) echo "<option value='{$size}' selected='selected'>{$size}</option>"; ?>
                                                                        </select></td></tr>
                                    <tr><td><label for='family'>Family / Typeface</label>:</td> <td><select name='family'<?php if (!preg_match("/MSIE/i", $agent)) { ?> class='comboBox' <?php } ?> id='family'>
                                                                        <option value=''></option>
                                                                        <option value='"Andale Mono", "Monotype.com", monospace'>"Andale Mono", "Monotype.com", monospace</option>
                                                                        <option value='Arial, Helvetica, sans-serif'>Arial, Helvetica, sans-serif</option>
                                                                        <option value='"Comic Sans MS", cursive '>"Comic Sans MS", cursive</option>
                                                                        <option value='"Courier New", Courier, monospace'>"Courier New", Courier, monospace</option>
                                                                        <option value='Geneva, "MS Sans Serif", sans-serif'>Geneva, "MS Sans Serif", sans-serif </option>
                                                                        <option value='Georgia, serif'>Georgia, serif</option>
                                                                        <option value='Impact, sans-serif'>Impact, sans-serif</option>
                                                                        <option value='Palatino, serif'>Palatino, serif</option>
                                                                        <option value='Tahoma, sans-serif'>Tahoma, sans-serif</option>
                                                                        <option value='"Times New Roman", Times, serif'>"Times New Roman", Times, serif</option>
                                                                        <option value='"Trebuchet MS", sans-serif'>"Trebuchet MS", sans-serif</option>
                                                                        <option value='Verdana, Arial, Helvetica, sans-serif'>Verdana, Arial, Helvetica, sans-serif</option>
                                                                        <?php if(!empty($family)) echo "<option value='{$family}' selected='selected'>{$family}</option>"; ?>
                                                                       </select></td></tr>
                                                                       
                                    <tr><td> <label for='extra'>Additional CSS</label>:</td> <td><select name='extra'<?php if (!preg_match("/MSIE/i", $agent)) { ?> class='comboBox' <?php } ?> id='extra'>
                                                                        <option value=''></option>
                                                                        <option value='font-weight:bold'>font-weight:bold</option>
                                                                        <option value='font-weight:bolder'>font-weight:bolder</option>
                                                                        <option value='font-weight:lighter'>font-weight:lighter</option>
                                                                        <option value='font-style:italic'>font-style:italic</option>
                                                                        <option value='font-style:oblique'>font-style:oblique</option>
                                                                        <option value='text-decoration:none'>text-decoration:none</option>
                                                                        <option value='text-decoration:underline'>text-decoration:underline</option>
                                                                        <option value='font-variant:small-caps'>font-variant:small-caps</option>
                                                                        <option value='font-stretch:wider'>font-stretch:wider</option>
                                                                        <option value='font-stretch:ultra-expanded'>font-stretch:ultra-expanded</option>
                                                                        <option value='font-stretch:ultra-condensed'>font-stretch:ultra-condensed</option>
                                                                        <option value='font-stretch:narrower'>font-stretch:narrower</option>
                                                                        <?php if(!empty($extra)) echo "<option value='{$extra}' selected='selected'>{$extra}</option>"; ?>
                                                                       </select></td></tr></table>
                                                                       
                                                                       
                                                                        
                                </td>
                            </tr>
                            
                            <tr><th scope='row' valign='top'>Autolink Options</th>
                                <td>
                                <input type='text' name='max' value='<?php if(isset($_POST['max'])) { echo $_POST['max']; } else { echo $max; } ?>' style='width:32px;' /> Maximum number of times to replace each keyword per page.<br />
                                
                            </td></tr>

                                </tbody><tbody> 
                            <tr><th scope='row' valign='top'><small>Save as Preset</small></th>
                                <td>
 
                                <input type='text' name='preset' value='<?php echo @$_POST['preset']; ?>' style="width:50%;" /> Name
                            </td></tr>

                            <script type='text/javascript'>docollapse('cloaking');</script>
                            <script type='text/javascript'>docollapse('meta');</script>
                            <script type='text/javascript'>docollapse('morelinks');</script>
                            <script type='text/javascript'>docollapse('expirelinks');</script>
                            <script type='text/javascript'>docollapse('restrictions');</script>
                            <!-- <script type='text/javascript'>docollapse('geoform');</script> -->
                            <script type='text/javascript'>docollapse('ua');</script>
                            <script type='text/javascript'>docollapse('varforward');</script>
                            <script type='text/javascript'>docollapse('bulk');</script>
                            
                        </table>
                      	<p class="submit"><input type="submit" class="button-primary" name="submit" value="<?php _e('Add / Update'); ?>" />
                </form>

                <?php
            break;
            
            case "delete":
                $entry_ID = (int) $_GET['ID'];
                check_admin_referer('delete-entry_' .  $entry_ID);
                if ( !current_user_can('manage_categories') )
                        wp_die(__('Not allowed to do that.'));

		        $delete = $wpdb->query('DELETE FROM `'.$wpdb->prefix.'wplink_links` WHERE `id`="'.$entry_ID.'"');   
		        $delete = $wpdb->query('DELETE FROM `'.$wpdb->prefix.'wplink_destinations` WHERE `link_id`="'.$entry_ID.'"');   
		        $delete = $wpdb->query('DELETE FROM `'.$wpdb->prefix.'wplink_restrictions` WHERE `link_id`="'.$entry_ID.'"');   
		        $delete = $wpdb->query('DELETE FROM `'.$wpdb->prefix.'wplink_geo_links` WHERE `link_id`="'.$entry_ID.'"');   
		        
				$dodelete = true;
          
            case "manage": default:
            register_column_headers("edit-link", array("name"=>__("Title"), "from"=>__("Slug"), "to"=>__("Destination"), "cloaked"=>__("Double Refresh"), "group"=>__("Group")));
		    ?>
		    

			<div class="wrap">
				<div id="icon-edit" class="icon32"><br /></div>
				<h2>Manage Links</h2>
				<script type='text/javascript'>
                                
                    function IsNumeric(sText)
                    
                    {
                    var ValidChars = "0123456789.";
                    var IsNumber=true;
                    var Char;
                    
                    
                    for (i = 0; i < sText.length && IsNumber == true; i++) 
                      { 
                      Char = sText.charAt(i); 
                      if (ValidChars.indexOf(Char) == -1) 
                         {
                         IsNumber = false;
                         }
                      }
                    return IsNumber;
                    
                    }
                    
                    


				    function presets() {
                        var id = document.getElementById("presets").options[document.getElementById("presets").selectedIndex].value;
                        if(IsNumeric(id)) {
                            window.location = "admin.php?page=wplink-manage&action=preset&ID=" + id
                        }
				    }
				</script>
				
				<?php if($dodelete === true || $_GET['deleted'] == "true") { ?>
	    	            <div id="message" class="updated fade"><p>Link(s) deleted. Continue managing below.</p></div>
                <?php } ?>
    
				<p><a href="admin.php?page=wplink-manage&action=new&ID=new">Create new link</a> 
				<?php
				    $presets = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_presets` WHERE `type`='all'");
	                if(count($presets) > 0) {
	            ?>
	(or from preset <select name='presets' id='presets' onchange='presets()'>
	<option value='none'></option>
                <?php
				    foreach($presets as $preset) {
				        echo "<option value='" . $preset->id . "'>" . $preset->name . "</option>";
				    }
				?>
				</select>)<?php } ?></p>

                <form action='admin.php?page=wplink-manage&action=delete-mass' method='post'>
				<table class="widefat poll fixed" cellspacing="0">
        			<thead>	
        				<tr>
        				    <th scope="col"><a href="admin.php?page=wplink-manage&sort_field=id">ID</a></th>
        				    <th scope="col"><a href="admin.php?page=wplink-manage&sort_field=name">Title</a></th>
        				    <th scope="col"><a href="admin.php?page=wplink-manage&sort_field=from">Slug</a></th>
        				    <th scope="col" width='25%'><a href="admin.php?page=wplink-manage&sort_field=to">Primary Destinations</a></th>
        				    <th scope="col" width='10%'><a href="admin.php?page=wplink-manage&sort_field=cloaked">Cloaking</a></th>
        				    <th scope="col"><a href="admin.php?page=wplink-manage&sort_field=group">Group</a></th>
        				    

					      	<th colspan='2' width='25%' scope="col" id="actions" class="manage-column column-actions" style="">Actions</th>
        				</tr>
		    	    </thead>

        			<tfoot>
			        <tr>    
			                <th scope="col"><a href="admin.php?page=wplink-manage&sort_field=id">ID</a></th>
			                <th scope="col"><a href="admin.php?page=wplink&sort_field=name">Title</a></th>
        				    <th scope="col"><a href="admin.php?page=wplink-manage&sort_field=from">Slug</a></th>
        				    <th scope="col"><a href="admin.php?page=wplink-manage&sort_field=to">Primary Destinations</a></th>
        				    <th scope="col"><a href="admin.php?page=wplink-manage&sort_field=cloaked">Cloaking</a></th>
        				    <th scope="col"><a href="admin.php?page=wplink-manage&sort_field=group">Group</a></th>

				      	<th colspan='2' scope="col" id="actions" class="manage-column column-actions" style="">Actions</th>
			        </tr>
    	    		</tfoot>

		        	<tbody id="the-list" class="list:link">
						<?php wplink_link_rows(); ?>
		        	</tbody>
				</table>
				<input type='submit' style='margin-top:8px;' value='Delete Selected' onClick="return confirm('Are you sure you would like to delete all checked rows?');"/>
				</form>
				
				<h2>Quick Create</h2>
				<?php  $url = ((get_option('home'))?get_option('home'):get_option('siteurl'));
                $url = rtrim($url, "/") . "/";
                ?>
				<form name="editentry" id="editentry" method="post" action="admin.php?page=wplink-manage" class="validate">
                <input type="hidden" name="action" value="do-edit" />
                <input type="hidden" name="ID" value="<?php echo $ID; ?>" />
                <?php wp_original_referer_field(true, 'previous'); wp_nonce_field('update-entry_' . $ID); ?>
                        <table class="form-table">
                           <tr class="form-field form-required">
                                <th scope="row" valign="top"><label for="link_title"><?php _e('Link Text') ?></label></th>
                                <td><input name="link_title" id="link_title" style='width: 280px' type="text" value="<?php echo attribute_escape($entry->link_title); ?>" size="40" aria-required="true" /></td>
                            </tr>
                                             
                            <tr class="form-field form-required">
                                <th scope="row" valign="top"><label for="from"><?php _e('Slug') ?> (<em>from</em>)</label></th>
                                <td><strong><?php echo $url; ?></strong><input name="from" id="from" type="text" style="width:150px;" value="<?php echo attribute_escape($entry->from); ?>" size="40" aria-required="true" /><br />
                                <span class="setting-description"> It is important that this field only contains letters, numbers, ".", "-" and "_".</span>
                                </td>
                            </tr>
                            
                            <tr class="form-field form-required">
                                <th scope="row" valign="top"><label for="to"><?php _e('Primary Destination') ?> (<em>to</em>)</label>
                                </th>
                                <td><input name='dest_to_1' id='dest_to_1' type='text' value='' style='width:80%'  /><input type='hidden' name='weight_1' value='100' /><br />
                                <span class="setting-description">This should begin with a proper URL scheme, such as "http," "https" or "ftp."</span>
                                </td>
                            </tr>
                                <input type='hidden' name='forwarding' value='1' />
                                <input type='hidden' name='subid' value='1' />
                                <input type='hidden' name='match_primary' value='1' />
                                <input type='hidden' name='match_slug' value='1' />
                                
                        </table>
                      	<p class="submit">
                      	    <input type="submit" class="button-primary" name="submit" value="<?php _e('Quick Add'); ?>" />
                      	</p>
                </form>

			</div>
			<?php
			break;
        }
    }
    
    function wplink_settings() {
    
    }
    
    function wplink_addlink_box() {
        
    echo '<script type="text/javascript">
                function wplink_ie(url) {
                    var t = document.getElementById("content");
                    var vlink = document.getElementById("wplink_link");

                    
                    if(url) {
                        string = (" ['.WPLINK_SHORTCODE_URL.' id=\"" + vlink.value + "\"]");
                    } else {
                        string = (" ['.WPLINK_SHORTCODE.' id=\"" + vlink.value + "\"]");
                    }
                    t.value += string;
                    tinyMCE.execInstanceCommand(\'content\',\'mceInsertContent\',false,string); 
                }
          </script>';
          
        echo "<p>
            <select name='wplink_link' id='wplink_link' style='width:100%'>
			    <option value=''>&nbsp;</option>";
			        global $wpdb;
			        $results = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_links`");
			        foreach($results as $result) {
			            $name = trim($result->name);
			            if(!isset($name) || strlen($name) == 0) {
			                $name = $result->link_title;
			            }
			            
			            echo "<option value='" . $result->id . "'>" . $name  . "</option>";
			        }
			    
			echo "</select>
			
	    </p>
	    ";
	    
    	echo "<p class='submit'><input type='button' onclick='wplink_ie(false);' value='Insert Link' /><input type='button' onclick='wplink_ie(true);' value='Insert URL' /></p>";
    	echo "<p>Shortcode: <span style=\"font-family: courier,monospace;\">[".WPLINK_SHORTCODE." id='[value]']</span> or <span style=\"font-family: courier,monospace;\">[".WPLINK_SHORTCODE_URL." id='[value]']</span>  </p>";
    	
    	echo "<p>You can also use the format [" . WPLINK_SHORTCODE . " name='the name of a link'], however, it is important to assure the name is exactly as it is in the database, and if you are to change the name, the link will no longer work.</p>";
    }    
    
    function wplink_link_rows() {
        global $wpdb;
        if(!isset($_GET['sort_field'])) {
            $_GET['sort_field'] = "group";
        }

        $_GET['sort_field'] = str_replace("`", "", $_GET['sort_field']);
        $_GET['sort_field'] = str_replace("\\", "", $_GET['sort_field']);
        
        //$query = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."wplink_links` ORDER BY `{$_GET['sort_field']}` ASC");

        $links = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_links` ORDER BY `{$_GET['sort_field']}` ASC");
        
        $out = '';
        $count = 0;
        foreach( $links as $entry )
                $out .= wplink_link_row($entry, ++$count % 2 ? ' class="row-b"' : '' );

        // filter and send to screen
        echo $out;
        return $count;
	}
	
	
	function wplink_link_row( $entry, $class = '' ) {
    	global $wpdb;
	       $url = ((get_option('home'))?get_option('home'):get_option('siteurl'));
                $url = rtrim($url, "/") . "/";
                
        $name = $entry->name;
        if(!(strlen($name) > 0)) {
            $name = $entry->link_title;
        }
        
        $from = $entry->from;
        $destinations = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_destinations` WHERE `link_id`='{$entry->id}'");
        
        $to = "<div style='margin-left:10px;'> <small>";
            foreach($destinations as $d) {
                $to .= $d->destination;
                if(count($destinations)>1) {
                    $to .= " - " . number_format($d->weight, 2) . "%<br />";
                }
            }
        $to .= "</small></div>";
        
        switch($entry->cloaked) {
            case "1": $cloaked = "Single Meta Refresh"; break;
            case "2": $cloaked = "Double Meta Refresh"; break;
            case "301": $cloaked = "301 Redirect"; break;
            case "302": $cloaked = "302 Redirect"; break;
            case "307": $cloaked = "307 Redirect"; break;
            case "js": $cloaked = "Javascript Redirect"; break;
            case "frame": $cloaked = "Framed Redirect"; break;
            case "js2": $cloaked = "Javascript + Meta"; break;
            case "guaranteed": $cloaked = "Guaranteed Wipe"; break;
            case "custom": $cloaked = "Custom HTML"; break;
            
            default: case "0": $cloaked = "No.";
        }
        $group = $entry->group;
        
        $edit_link = 'admin.php?page=wplink-manage&amp;action=edit&amp;ID='.$entry->id;
        $clone_link = 'admin.php?page=wplink-manage&amp;action=clone&amp;ID='.$entry->id;
        $delete_link = 'admin.php?page=wplink-manage&amp;action=delete&amp;ID='.$entry->id;
        
        $output = "<tr id='entry-" . $entry->id . "'>";
        $output .= "<td><input type='checkbox' name='ids[]' value='" . $entry->id . "' /> " . $entry->id . "</td>";
        $output .= "<td class='name column-name'><strong><a class='row-name' href='" . $edit_link . "'>" . $name . "</a></strong></td>";
        $output .= "<td class='from column-from'>" . $from . "</td>";
        $output .= "<td class='to column-to'>" . $to . "</td>";
        $output .= "<td class='cloaked column-cloaked'>" . $cloaked . "</td>";
        $output .= "<td class='group column-group'>" . $group . "</td>";
        
        $output .= "<td colspan='2'> ";
        $output .= "<span class='edit'><a href='" . $edit_link . "'>Edit</a></span>";
        $output .= " | <span class='clone'><a href='" . $clone_link . "'>Clone</a></span>";
        
        $output .= " | <span class='delete'><a href='"	. wp_nonce_url($delete_link, 'delete-entry_' . $entry->id) . "' onclick=\"if ( confirm('" . js_escape(__("You're about to delete this link, are you sure? All pages dependent on it will stop working.")) . "') ) { return true;}return false;\">" . __('Delete') . "</a></span>";
        $output .= " | <input type='text' style='font-size:10px;font-family:monospace;' onclick='this.select();' name='url' id='url' value='" .  ($url . $from) . "'/>";
        $output .= "</td></tr>";
        
        return $output;
        
	}
	
	    
	function wplink_disable_box() {
	    global $post;

	   // $title = trim(get_post_meta($post->ID, "_wplead_title", true));
	    $disable = trim(get_post_meta($post->ID, "_wplink_disable_keywords", true));
	    $links = trim(get_post_meta($post->ID, "_wplink_disable_links", true));
	    ?>
        <p>
            <input type='checkbox' name='_wplink_disable_keywords' value='1' id='_wplink_disable_keywords' <?php if($disable == 1) echo " checked='checked'"; ?> /> Disable keyword autolinking from WP Link Engine on this post.<br />
            <input type='checkbox' name='_wplink_disable_links' value='1' id='_wplink_disable_links' <?php if($links == 1) echo " checked='checked'"; ?> /> Disable link automatch from WP Link Engine on this post.<br />
        </p>     
	    <?php
	}
	
	
	function wplink_disable_save($id) {
	    $disable = $_POST['_wplink_disable_keywords'];
	    $links = $_POST['_wplink_disable_links'];
	    
    	add_post_meta($id, "_wplink_disable_keywords", $disable, true) or update_post_meta($id, "_wplink_disable_keywords", $disable);  	
        add_post_meta($id, "_wplink_disable_links", $links, true) or update_post_meta($id, "_wplink_disable_links", $links);  	
    }
?>
