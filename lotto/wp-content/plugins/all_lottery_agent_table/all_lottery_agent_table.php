<?php
/*
	Plugin Name: All lottery agent table
	Plugin URI: https://trello.com/c/ZORy6EN7/240-all-lottery-agent-table
	Description: Need to create the automatically updated table for all the lottery agents we have reviewed on site.
	Version: 1.0.0
	Author:Valentin B. S.
	Author URI: http://URI_страницы_автора_плагина
	License: GPL2
*/   
	 
	if(!defined('WP_CONTENT_URL'))
		define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
	if(!defined('WP_CONTENT_DIR'))
		define('WP_CONTENT_DIR', ABSPATH . 'wp-content');
	if(!defined('WP_PLUGIN_URL'))
		define('WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins');
	if(!defined('WP_PLUGIN_DIR'))
		define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');

	class STbox {
	    function cssStyles() {
	      $stPath = WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/styles/'.'/';
	      echo '<link rel="stylesheet" type="text/css" media="screen" href="' . $stPath . 'style.css" />'."\n";
	    }
	}
	  
	function tall_lottery_agent_table($atts, $content = null) 
	{ 
	 
		$posts_array = get_posts(array('post_type' => 'lottery_sites', 'orderby' => 'title', 'order' => 'ASC', 'numberposts' => -1));
		?>

			<table border="2" width="650" cellspacing="5" cellpadding="10" align="center">
			<tbody>
			<tr>
				<td style="text-align: center;" bgcolor="#F5FAFF"><strong>Online Lottery Agent</strong></td>
				<td style="text-align: center;" bgcolor="#F5FAFF"><strong>Special Bonus Offer</strong></td>
				<td style="text-align: center;" bgcolor="#F5FAFF"><strong>Approved?</strong></td>
				<td style="text-align: center;" bgcolor="#F5FAFF"><strong>User Rating</strong></td>
				<td style="text-align: center;" bgcolor="#F5FAFF"><strong>Read Review</strong></td>
				<td style="text-align: center;" bgcolor="#F5FAFF"><strong>Join Live Discussion</strong></td>
			</tr>

		<?php
	 	foreach ($posts_array as $post) {
			$arr = array();
			$post_title = $post->post_title;
			$post_id = $post->ID; 
			$arr['post_id'] = $post_id;
			$arr['selected'] = $selected;
			$arr['post_title'] = $post_title;
			$arr['current_assigned_review_to'] = get_post_meta( $post_id, 'lottery_sites_funding', true );
			$arr['sitename'] = esc_html( get_post_meta( $post_id , 'lottery_sites_sitename', true ) );
			$arr['approved_pos'] = intval( get_post_meta( $post_id, 'lottery_sites_approved_pos', true ) );
			$arr['approved'] = intval( get_post_meta( $post_id, 'lottery_sites_approved', true ) );
			$arr['alexa'] = intval( get_post_meta( $post_id, 'lottery_sites_alexa', true ) );
			$arr['othersites'] = esc_html( get_post_meta( $post_id, 'lottery_sites_othersites', true ) );
			$arr['domregdate'] = esc_html( get_post_meta( $post_id, 'lottery_sites_domaindate', true ) );
			$arr['funding'] = esc_html( get_post_meta( $post_id, 'lottery_sites_funding', true ) );
			$arr['langs'] = esc_html( get_post_meta( $post_id, 'lottery_sites_langs', true ) );
			$arr['fbpage'] = esc_html( get_post_meta( $post_id, 'lottery_sites_fbpage', true ) );
			$arr['twitter'] = esc_html( get_post_meta( $post_id, 'lottery_sites_twitter', true ) );
			$arr['afflink'] = esc_html( get_post_meta( $post_id, 'lottery_sites_afflink', true ) );
			$arr['revurl'] = esc_html( get_post_meta( $post_id, 'lottery_sites_revurl', true ) );
			$arr['ss_url'] = esc_html( get_post_meta( $post_id, 'lottery_sites_screenshot', true ) );
			$arr['google_safebrowsing'] = intval( get_post_meta( $post_id, 'lottery_sites_safebrowsing', true ) );
			$arr['website_antivirus'] = intval( get_post_meta( $post_id, 'lottery_sites_antivirus', true ) );
			$arr['norton_safeweb'] = intval( get_post_meta( $post_id, 'lottery_sites_norton', true ) );
			$arr['lottery_sites_bonusinfo'] = get_post_meta( $post_id , 'lottery_sites_bonusinfo' , true ) ;
			$arr['lottery_sites_sitename'] = get_post_meta( $post_id , 'lottery_sites_sitename' , true ) ;

			#$arr['test'] = get_post_meta( $post_id ); var_dump($arr['test']);
		?>  
			<tr>
				<td style="text-align: center;"><a title="<?php substr( $arr['lottery_sites_sitename'] , 0, 8); ?>" href="<?php echo $arr['lottery_sites_sitename']; ?>" target="_blank" rel="nofollow"> <?php echo substr( $arr['lottery_sites_sitename'] , 0, 26); ?> </a></td>
				<td style="text-align: center;"><?php echo  $arr['lottery_sites_bonusinfo'];?></td>
				<td style="text-align: center;"><?php if ($arr['approved']) {echo "YES";} else {echo "NO";} ?></td>
				<td style="text-align: center;"><?php echo $arr['alexa'] ?></td>
				<td style="text-align: center;"><a href="<?php echo $arr['revurl']; ?>" target="_blank"><img src="http://www.lottoexposed.com/wp-content/uploads/2014/11/Blue-review-button.png" alt="Read Our Review" width="100" height="35" /></a></td>
				<td style="text-align: center;"><a href="<?php echo $arr['ss_url']; ?>" target="_blank"><img src="http://www.lottoexposed.com/wp-content/uploads/2014/11/Forum-Button.gif" alt="Join TheLotter Live Discussion" width="100" height="30" /></a></td>
			</tr>  
		<?php 
		}
		?>
			</tbody>
			</table>
		<?php
	    // $posts_array = get_posts(array('post_type' => 'lottery_sites'));  return "test 123";
	}	 

	if (class_exists("STbox")) {
		$dl_plugin = new STbox();
	}

	//  Actions 
	if (isset($dl_plugin)) {
		// Add actions to footer
		add_action('wp_footer', array(&$dl_plugin, 'cssStyles')); //Add the definition of CSS and JS section footer
	} 

	add_shortcode('tall_lottery_agent_table_include', 'tall_lottery_agent_table');
?>



 