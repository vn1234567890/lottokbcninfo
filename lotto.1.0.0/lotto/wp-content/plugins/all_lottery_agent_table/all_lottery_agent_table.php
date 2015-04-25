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
	      // $stPath = WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/styles/'.'/';
	      // echo '<link rel="stylesheet" type="text/css" media="screen" href="' . $stPath . 'style.css" />'."\n";
	    }
	}
	   
	  
	function all_lottery_agent_table($atts, $content = null) 
	{ 
		// kksr_ajax(  array('stars' => stars ,'id' => stars ) ) 
		// ======================================= 
	      global $wpdb;
	      $postID  = get_the_ID(); 
		// =========================================
		$posts_array = get_posts(array('post_type' => 'lottery_sites', 'orderby' => 'title', 'order' => 'ASC', 'numberposts' => -1));
	// print_r($posts_array);

	?>
 
 
 
<link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.css">

<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/plug-ins/a5734b29083/integration/bootstrap/3/dataTables.bootstrap.css">
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/responsive/1.0.1/css/dataTables.responsive.css">
<script type='text/javascript' src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type='text/javascript' src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
<script type='text/javascript' src="http://cdn.datatables.net/responsive/1.0.1/js/dataTables.responsive.min.js"></script>
<script type='text/javascript' src="http://cdn.datatables.net/plug-ins/a5734b29083/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<style type='text/css'>

	.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus {
		color: #fff; 
		background-color: #2D2F30;
		border-color: #33373A; 
	} 

	.pagination > li > a, .pagination > li > span { 
		color: #3C4145;
		text-decoration: none;
		background-color: #fff;
		border: 1px solid #ddd;
	} 

    body { font-size: 140%} 
    table.dataTable th,
    table.dataTable td { white-space: nowrap; }
    .row {
    	border:1px solid inherit;  
	}   

    /* .col-xs-6 {  padding-left: 0px; }*/
	#content .post_comment h2 { height: inherit; }
	.col-xs-6 {
		width:inherit; 
	}
   .navigation ul {  width: 720px };
</style>
<script type='text/javascript'> 
 
	$(document).ready(function() {
	    $('#example').DataTable({
	    	responsive: true, 
	    }); // alert('dddd');
	    document.getElementById('example').style.width = '570px';
	    document.getElementById('example_length').style.paddingTop = '10px';
	    // document.getElementById('example_wrapper').getElementsByClassName('row')
	    // document.getElementById('example_wrapper').getElementsByClassName('row').style.width = "444px";
	    document.getElementById('example_paginate').style.width = "444px";
	    document.getElementById('example_length').innerHTML = ''
		document.getElementById('menu-mainmenu').style.marginBottom = '0px';
		document.getElementById('menu-mainmenu').style.height = '52px';
	} );
 
</script> 
 
<div class="row" style='padding-left: 30px;'>
<div class="col-md-8" style=" width: 600px;">
 

<table id="example" class="table table-striped table-hover dt-responsive" cellspacing="0" style="width: 575px;"> 
 <!-- width="400" -->
     <thead style="width: 575px;">
        <tr style="width: 575px;">
            <th>Online Lottery Agent</th>
            <th>Special Bonus Offer</th>
            <th>Approved?</th> 
            <th>User Rating</th>
            <th>Read Review</th>
            <th>Join Live Discussion</th> 
            <th> Rating <!-- RATE --> </th>          
        </tr>
    </thead>
     <tbody> 
		<?php
	 	foreach ($posts_array as $post) {
	 		// print_r($post);
			$arr = array();
			$post_title = $post->post_title;
			$post_id = $post->ID; 
			$arr['get_post'] = get_post($my_id);
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

			$arr['JoinLiveDiscussion'] = get_post_meta( $post_id ,'lottery_sites_revurl',true); //var_dump($arr['test']); exit;
			
			global $wpdb;
			$result = $wpdb->get_results( "SELECT post_id FROM 	`lottoexp_1`.`wp_postmeta` WHERE  `lottoexp_1`.`wp_postmeta`.`meta_value` = ". $post_id   );
			 
			// foreach($result as $ThePostID){
				$arr['ThePostID'] = $result[0]->post_id;
			// }
			
			#$arr['RATE'] = $arr['ThePostID'];
			
			$rRATE = $wpdb->get_results( " SELECT (meta_value)
				FROM `wp_postmeta`
				WHERE post_id = ".$arr['ThePostID']."
				AND meta_key = '_kksr_casts'
			");	

			 
           $id = $arr['ThePostID'];

            if(get_option('kksr_column'))
			{
				$total_stars = get_option('kksr_stars');
				$row = 'No ratings';
				$raw = (get_post_meta($id, '_kksr_ratings', true)?get_post_meta($id, '_kksr_ratings', true):0);
				if($raw)
				{
					$_avg = get_post_meta($id, '_kksr_avg', true);
					$avg = '<strong>'.($_avg?((number_format((float)($_avg*($total_stars/5)), 2, '.', '')).'/'.$total_stars):'0').'</strong>';
					$cast = (get_post_meta($id, '_kksr_casts', true)?get_post_meta($id, '_kksr_casts', true):'0').' votes';
					$per = ($raw>0?ceil((($raw/$cast)/5)*100):0).'%';
					$row = $avg . ' (' . $per . ') ' . $cast;
				} 
			}else {
				$row = 'No ratings';
			}
			$arr['RATE'] = $row;
 
		?>  
			 <tr style="width: 575px;">
				<td style="text-align: center;"><a title="<?php substr( $arr['lottery_sites_sitename'] , 0, 8); ?>" href="<?php echo $arr['lottery_sites_sitename']; ?>" target="_blank" rel="nofollow"> <?php echo substr( $arr['lottery_sites_sitename'] , 0, 26); ?> </a></td>
				<td style="text-align: center;"><?php echo  $arr['lottery_sites_bonusinfo'];?></td>
				<td style="text-align: center;"><?php if ($arr['approved']) {echo "YES";} else {echo "NO";} ?></td>
				<td style="text-align: center;"><?php echo $arr['alexa'] ?></td>
				<td style="text-align: center;"><a href="<?php echo $arr['revurl']; ?>" target="_blank"><img src="http://www.lottoexposed.com/wp-content/uploads/2014/11/Blue-review-button.png" alt="Read Our Review" width="100" height="35" /></a></td>
				<td style="text-align: center;"><a href="<?php echo $arr['JoinLiveDiscussion']; ?>" target="_blank"><img src="http://www.lottoexposed.com/wp-content/uploads/2014/11/Forum-Button.gif" alt="Join TheLotter Live Discussion" width="100" height="30" /></a></td>
				<td style="text-align: center;"><?php echo $arr['RATE'] ?></td>
			</tr>  
		<?php 
		}
		?>
 
<?php  //$postid = url_to_postid( '/online-lottery-agents/' );  var_dump($postid); ?> 



		   </tbody>
        </table>
    </div>
</div>


			<!-- </tbody>
			</table> -->
		<?php
	    // $posts_array = get_posts(array('post_type' => 'lottery_sites'));  return "test 123";
	}	 

	if (class_exists("STbox")) {
		$dl_plugin = new STbox();
	}

	//  Actions 
	// if (isset($dl_plugin)) {
	// 	// Add actions to footer
	// 	add_action('wp_footer', array(&$dl_plugin, 'cssStyles')); //Add the definition of CSS and JS section footer
	// } 

	add_shortcode('all_lottery_agent_table_include', 'all_lottery_agent_table');
?>



 