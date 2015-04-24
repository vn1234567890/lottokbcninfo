<?php
/*
Plugin Name: WP Theme Rotator
Plugin URI: http://www.wplinkengine.com/
Version: 1.0
Description: Easily rotate your themes, ideal for split testing.
*/

$wplink_template_cache = "";

function wplink_add_theme_menus() {
    wplink_confirm();

    add_submenu_page("options-general.php", "Theme Rotator", "Theme Rotator", 8, "wplink_theme_rotator_menu", "wplink_theme_rotator_menu");
}

function wplink_theme_rotator_menu() {
    ?>
    <div class="wrap">
				<div id="icon-edit" class="icon32"><br /></div>
				<h2>Manage Theme Rotation Weights</h2>
				<?php
				    if(isset($_POST['action'])) {
				        $options = explode(",", trim($_POST['page_options'], ","));
				        $weights = array();
				        $sum = 0;
				        foreach($options as $o) {
				            $weights[$o] = intval($_POST[$o]);
				            $sum += $weights[$o];
				        }
				        
				        $ratio = 100/$sum;
				        if($ratio != 1) {
				            $updated = true;
				        } else {
				            $updated = false;
				        }
				        
				        foreach($options as $o) {
				            $weights[$o] *= $ratio;
				        }
				       
				       update_option("wple-weights", $weights);
				       update_option("wple-values", $options);
				    }
				?>

                <?php if($updated === true) {  ?>
                <div class='updated fade'><p>Your weights didn't add up to 100%; they have been adjusted accordingly.</p></div>
                <?php } ?>
                
                
                <?php if(isset($updated)) {  ?>
                <div class='updated fade'><p>
                Options updated.
                </p></div>
                  
             
                <?php } ?>
        <form method="post" action="options-general.php?page=wplink_theme_rotator_menu">
            <?php wp_nonce_field('update-options'); ?>
            <?php
                        
            echo "<table width='250' style='margin-left:10px;'>";
            $themes = get_themes();
            $save_string = "";

            $weights = get_option("wple-weights");
            $options = get_option("wple-values");

            foreach($themes as $theme) {
                $weight = $weights[$theme['Template']];
                if(!isset($weight) || empty($weight)) {
                    $weight = (100/count($themes));
                }
                
                echo "<tr><td><strong>" . $theme['Title'] . "</strong></td>";
                echo "<td><input type='text' name='" . $theme['Template'] . "' value='{$weight}' size='3' />%</td></tr>";
                $save_string .= ($theme['Template'] . ",");
            }
            echo "</table>";
            
            ?>
            <br />
        
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="<?php echo $save_string; ?>" />
    
            <input type='submit' value='Save Weights' />
        </form>
    </div><?php
}

function wplink_rotator($t='') {
    if(is_admin() || is_preview()) {
		return $t;
	}
	$template = $t;
	
	global $wplink_template_cache;
	if($wplink_template_cache != "") {
		return $wplink_template_cache;
	}
    
    $weights = get_option("wple-weights");
    if(!isset($weights)) return $t; 
    if(!is_array($weights)) return $t;
    
    foreach($weights as $k=>$v) {
        $weights[$k] = $v/100;
    }
    
    
    if(count($weights) > 1) {
        if(function_exists("wplink_rand")) {
            $theme = wplink_rand($weights);

        	$wplink_template_cache = $theme;
	        return $theme;
	    } else {
	        return $t;
	    }
	} else {
	    return $t;
	}
}

function wplink_confirm() {
    if(!defined(("WPLINK_PLUGIN_NAME"))) {
        deactivate_plugins((WP_PLUGIN_DIR."/wp-link-engine/theme-rotator.php"));
        wp_die("Please activate WP Link Engine before WP Theme Rotator. <a href='./'>Click here to reload with WP Theme Rotator deactivated.</a>");
    }
}

add_action('admin_menu', 'wplink_add_theme_menus');
add_filter('template', 'wplink_rotator');
add_filter('stylesheet', 'wplink_rotator');

register_activation_hook((WP_PLUGIN_DIR . "/wp-link-engine/" . "theme-rotator.php"), "wplink_confirm"); 

?>