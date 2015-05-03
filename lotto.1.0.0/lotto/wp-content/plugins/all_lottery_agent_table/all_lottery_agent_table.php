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
			$stPath = WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/css/css'.'/';
			$stPath2 = WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/css'.'/';
			if ( ('7711' == get_the_ID() ) or (strripos( "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" , 'online-lottery-agents') ) ){
				echo '<link rel="stylesheet" type="text/css" media="screen" href="' . $stPath . 'bootstrap.css?1.0.0" />'."\n";
				echo '<link rel="stylesheet" type="text/css" media="screen" href="' . $stPath2 . 'style.css?1.0.0" />'."\n";
		    }
			// echo '<link rel="stylesheet" type="text/css" media="screen" href="' . $stPath . 'bootstrap.css?1.0.0" />'."\n";
			// echo '<link rel="stylesheet" type="text/css" media="screen" href="' . $stPath2 . 'style.css?1.0.0" />'."\n";
	    }
	}

	function all_lottery_agent_table($atts, $content = null) 
	{ 

		// ======================================= 
	      global $wpdb;
	      $postID  = get_the_ID(); 
		// =========================================
		$posts_array = get_posts(array('post_type' => 'lottery_sites', 'orderby' => 'title', 'order' => 'ASC', 'numberposts' => -1));
    ?>
 

 <?php
if ( ('7711' == get_the_ID() ) or (strripos( "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" , 'online-lottery-agents') ) ){
	?>
<!-- <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/plug-ins/a5734b29083/integration/bootstrap/3/dataTables.bootstrap.css"> -->
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/responsive/1.0.1/css/dataTables.responsive.css">
<script type='text/javascript' src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type='text/javascript' src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
<script type='text/javascript' src="http://cdn.datatables.net/responsive/1.0.1/js/dataTables.responsive.min.js"></script>
<script type='text/javascript' src="http://cdn.datatables.net/plug-ins/a5734b29083/integration/bootstrap/3/dataTables.bootstrap.js"></script>

<style type='text/css'>
 
    body { font-size: 140%} 
    table.dataTable th,
    table.dataTable td { white-space: nowrap; }
    .row {
    	border:1px solid inherit;  
	}   

	#content .post_comment h2 { height: inherit; }

    /*.navigation ul {  width: 720px };*/

</style>
<?php } ?>
<script type='text/javascript'> 
 var cssFCount = 0;
function cssF() { console.log('f');
 
	document.getElementById('row_1').style.paddingLeft = '20px';
	document.getElementById('content').style.width = '680px';

    document.getElementById('example').style.width = '660px';
	document.getElementById('example_filter').getElementsByTagName('input')[0]. setAttribute("placeholder", "Search for Ticket Sellers");
		
	document.getElementById('example_filter').getElementsByTagName('input')[0].style.marginTop = '5px';
	document.getElementById('example_filter').getElementsByTagName('input')[0].style.marginRight = '5px';
 
	document.getElementById('example_paginate').style.marginTop = '10px';
	document.getElementById('example_length').style.marginTop = '5px';

	document.getElementById('row_1').style.paddingLeft = '16px';

	document.getElementsByClassName('row')[1].style.width = '660px';
	document.getElementsByClassName('row')[1].style.marginLeft = '0px';

	document.getElementById('row_2').style.paddingLeft = '0px'; 

	$('.content_container2').html('');
	
	// $('#searchform').html('');
	$('li#search-2.widget.widget_search').remove();


if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
	console.log('PC>');   
    $('.brDel').remove();
    if (cssFCount < 5) { cssFCount++;
	    cssF();
    }
} else {
	console.log('mobile>');
    document.getElementsByClassName('my_class sorting_1')[0].style.paddingLeft = '22px';
 
	$( "#example_filter" ).removeClass( "dataTables_filter" ).addClass( "dataTables_filter_mobile" );
	$( "#example_paginate" ).removeClass( "dataTables_paginate paging_simple_numbers" ).addClass( "dataTables_paginate_mobile paging_simple_numbers_mobile" );
}




 }

  
 

// document.onmousemove = cssF;
// function mouseMove(event){ console.log('4');
// 	cssF();
// 	// event = fixEvent(event)
// 	// document.getElementById('mouseX').value = event.pageX
// 	// document.getElementById('mouseY').value = event.pageY
// }



	// $( ".sorting_desc" ).hover(function() {
	// 	cssF(); // cssEditor();
	// }); 

	 
document.getElementById('content').style.width = '690px';


	function cssEditor() {
		// body... // padding-left: 22px;
			// document.getElementById('row_1').style.paddingLeft = '30px';
			document.getElementById('row_2').style.width = '600px';
			document.getElementById('row_3').style.width = '575px';
			document.getElementById('row_4').style.width = '575px';
	}

	$(document).ready(function() {         
	   

	   var eventFired = function ( type ) { console.log('eventFired>');
			if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
				console.log('PC eventFired> .brDel remove ');   
			   $('.brDel').remove(); 
			}
      	// cssF();
       }


	   var oTable = $('#example')

		.on( 'order.dt',  function () { eventFired( 'Order' ); } )
        .on( 'search.dt', function () { eventFired( 'Search' ); } )
        .on( 'page.dt',   function () { eventFired( 'Page' ); } )

	   .DataTable({
 
	   	 "bAutoWidth": false,
		   	// "pagingType": "full_numbers",
		   	"oLanguage": {
		   		"sLengthMenu": "_MENU_ Showing ",
		   		// "sInfoEmpty": "No entries to show",
 			// "sLengthMenu": "Display _MENU_ records",
		   	"sInfoEmpty": "NOTHING FOUND IN SEARCH. PLEASE CHECK SPELLING OR TRY ANOTHER TERM.",
		   	"sEmptyTable": "No data available in table",
	         "sSearch": "<!-- sSearch -->",
	        	"oPaginate": {
           			"sNext": "next",
           			"sPrevious": "prev"
         		}
	        },

			"bPaginate": true,
			"bProcessing": true,
	    	responsive: true,  
			"sDom": '<"row"flp><"top">', 
			pageLength: 10,
			columnDefs: [ {
			    targets: -1,
			    className: "priority"
			} ],

			"aoColumnDefs": [
				{ "sClass": "my_class", "aTargets": [ 0 ] }
			],

			"iDisplayLength": 25,
			"aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, "All"]] 

 	    });  
 
		cssEditor();
		$( "select.form-control.input-sm" ).change(function() {
		  cssEditor();  cssF();
		});
 
		$( "#example_length > label > select.form-control.input-sm" ).change(function() {
			cssEditor();  cssF();
		});
		$( "#example_paginate").click(function(){
			cssEditor();  cssF();
		});
 		 
		// $( "select.form-control.input-sm" ).mouseenter(function() {
		// 	cssF(); // cssEditor();
		// }); 

		// $( "select.form-control.input-sm" ).mouseleave(function() {
		//     cssF(); //cssEditor();
		// });

        cssF();
	 
		function ff() {
			$( "ul li a" ).on( "click", function() {
				cssF(); console.log( 3 );ff(); return true;
			});
		}
		ff();  

// 		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
//    console.log('mobile>');
//     $('.brDel').remove();
// }
	 	   	// ==========================================
				 // setInterval(function(){  ff();  }, 0);
	   	    // ==========================================



// if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
// 	console.log('PC>');   
//     $('.brDel').remove();
// } else {
// 	console.log('mobile>');
 
// 	$( "#example_filter" ).removeClass( "dataTables_filter" ).addClass( "dataTables_filter_mobile" );
// 	$( "#example_paginate" ).removeClass( "dataTables_paginate paging_simple_numbers" ).addClass( "dataTables_paginate_mobile paging_simple_numbers_mobile" );
// }

		cssF(); 
		 

	});
// setTimeout(function() { cssF();  } , 500);
  </script> 
 
<!-- start -->
<style type="text/css">
	.ticket_sellers_wrap {
		background: none repeat scroll 0 0 #5e6574;
		border-bottom: 5px double #fff;
		color: #fff;
		height: 35px;
		margin-top: 10px;
		padding: 7px 0 0 9px;
	}
</style> 
<!-- end -->  
<div id='row_1' class="row" style='padding-left: 30px;'>
<div id='row_2' class="col-md-8" style=" width: 600px;">
 
<table id="example" class="table table-striped table-hover dt-responsive" cellspacing="0" > 
 <!-- width="400" -->
    <thead id='row_3'  >
        <tr id='row_4' style='/* font-size: 5px; */ font-size: 12px; ' >
            <th style=" padding-left: 2px; padding-right: 18px; width: 100px; " onclick="cssF(); " >Online Lottery Agent</th>
            <th style=" text-align: center; padding-right: 15px;padding-left: 0px;  width: 100px; " >Special Bonus Offer</th>
            <th style=" text-align: center; padding-left: 2px;  width: 70px;" onclick="cssF();">Approved?</th> 
            <th style=" text-align: center; padding-left: 1px; padding-right: 9px; /* width: 100px; */ " onclick="cssF();">Rating</th>
            <th style=" text-align: center; padding-right: 0px; padding-left: 0px; width: 110px;" onclick="cssF();">Read Review</th>
            <th style=" text-align: center; padding-right: 0px; padding-left: 1px; width: 110px;" onclick="cssF();">Join Live</th> <!--  Discussion --> 
          <!--  <th> Rating   RATE  </th>     -->      
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
			

 
			$arr['lottery_sites_bonusinfo'] = get_post_meta( $post_id , 'lottery_sites_bonusinfo' , true );
			$arr['lottery_sites_bonusinfo'] = wordwrap($arr['lottery_sites_bonusinfo'], 16, "<br />", true);
			// $arr['lottery_sites_bonusinfo'] = wordwrap($arr['lottery_sites_bonusinfo'], 2, "<br />\n");

			$arr['lottery_sites_sitename'] = get_post_meta( $post_id , 'lottery_sites_sitename' , true ) ;

			$arr['JoinLiveDiscussion'] = get_post_meta( $post_id ,'lottery_sites_revurl',true); //var_dump($arr['test']); exit;
			
			global $wpdb;
			$result = $wpdb->get_results( "SELECT post_id FROM 	`lottoexp_1`.`wp_postmeta` WHERE  `lottoexp_1`.`wp_postmeta`.`meta_value` = ". $post_id   );
					 
			$arr['ThePostID'] = $result[0]->post_id;
			 
			$rRATE = $wpdb->get_results( " SELECT (meta_value)
				FROM `wp_postmeta`
				WHERE post_id = ".$arr['ThePostID']."
				AND meta_key = '_kksr_casts'
			");	

			 
	           $id = $arr['ThePostID'];

	            if(get_option('kksr_column'))
				{
					$total_stars = get_option('kksr_stars');
					$row = '<br class="brDel" />No  <br /> ratings <br />';
					$raw = (get_post_meta($id, '_kksr_ratings', true)?get_post_meta($id, '_kksr_ratings', true):0);
					if($raw)
					{
						$_avg = get_post_meta($id, '_kksr_avg', true);
						$avg = '';#'<strong>'.($_avg?((number_format((float)($_avg*($total_stars/5)), 2, '.', '')).'/'.$total_stars):'0').'</strong>';
						$cast = (get_post_meta($id, '_kksr_casts', true)?get_post_meta($id, '_kksr_casts', true):'0').' votes';
						$per =  round( ($raw>0?ceil((($raw/$cast)/5)*100):0) ) . '%';
						$row = $avg . '' . $per . ' <br /> ' . $cast;
					} 
				} else {
					$row = '<br class="brDel" />No <br /> ratings <br />';
				}
				$arr['RATE'] = $row;
 
		?>  


		<?php  
// print_r(parse_url($url));

// echo parse_url($url, PHP_URL_PATH); 
// $pos      = strripos( "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" , 'online-lottery-agents');
// var_dump($pos);

		?>

			 <tr style="width: 665px; font-size: 14px;">
				<td style="text-align: center; font-size: 14px; text-align: center; width: 57px;padding-left: 0px;padding-right: 0px;"><a title="<?php substr( $arr['lottery_sites_sitename'] , 0, 8); ?>" href="<?php echo $arr['lottery_sites_sitename']; ?>" target="_blank" rel="nofollow"> <?php echo substr( $arr['lottery_sites_sitename'] , 0, 26); ?> </a></td>
				<td style="text-align: center;  font-size: 14px; width: 57px; padding-left: 2px; padding-right: 2px; "><?php echo  $arr['lottery_sites_bonusinfo'];?></td>
				<td style="text-align: center; width:11px; padding-left: 0px; padding-right: 0px; "><?php if ($arr['approved']) {echo "YES";} else {echo "NO";} ?></td>
				<td style="text-align: center; width: 57px; padding-left: 0px; padding-right: 0px; "><?php echo $arr['RATE'] ?></td>
				<td style="text-align: center; width: 57px; padding-left: 0px; padding-right: 0px; ">
				    <!-- <a href="<?php echo $arr['revurl']; ?>" target="_blank">
				        <img src="http://www.lottoexposed.com/wp-content/uploads/2014/11/Blue-review-button.png" alt="Read Our Review" width="100" height="35" />
				    </a>  -->
					<a href="<?php echo $arr['revurl']; ?>" target="_blank" style="
						display: block;
						color: #fff;
						background: #3072C1;
						/* width: 83%; */
						padding: 5px 10px;
						border-radius: 5px;
						font-size: 13px;
						margin: 3px;
						background: #5aa8eb;
						background: -moz-linear-gradient(top, #5aa8eb 0%, #3072c1 99%, #1e5ca7 100%);
						background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#5aa8eb), color-stop(99%,#3072c1), color-stop(100%,#1e5ca7));
						background: -webkit-linear-gradient(top, #5aa8eb 0%,#3072c1 99%,#1e5ca7 100%);
						background: -o-linear-gradient(top, #5aa8eb 0%,#3072c1 99%,#1e5ca7 100%);
						background: -ms-linear-gradient(top, #5aa8eb 0%,#3072c1 99%,#1e5ca7 100%);
						background: linear-gradient(to bottom, #5aa8eb 0%,#3072c1 99%,#1e5ca7 100%);
						filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#5aa8eb', endColorstr='#1e5ca7',GradientType=0 );
					">Our Review</a>

				</td>
				
				<td style="text-align: center; width: 57px; padding-left: 0px; padding-right: 0px; ">
				
					<a href="<?php echo $arr['JoinLiveDiscussion']; ?>" target="_blank" style="
						display: block;
						color: #fff;
						background: #C72622;
						/* width: 83%; */
						padding: 5px 10px;
						border-radius: 5px;
						font-size: 13px;
						margin: 3px;
					">Go to Forum</a>

				   <!--   --><!-- <a href="<?php echo $arr['JoinLiveDiscussion']; ?>" target="_blank"> -->
				    <!-- <img src="http://www.lottoexposed.com/wp-content/uploads/2014/11/Forum-Button.gif" alt="Join TheLotter Live Discussion" width="100" height="30" /> -->
				<!-- </a> -->
				</td>
				<!-- <td style="text-align: center;"><?php echo $arr['RATE'] ?></td> -->
			</tr>  
		<?php 
		}
		?>
  
		   </tbody>
        </table>
    </div>
</div> 


<script type="text/javascript">
 
        // setInterval(function(){  cssF();  }, 500);
</script>
		<?php
	    // $posts_array = get_posts(array('post_type' => 'lottery_sites'));  return "test 123";
	}	 

	if (class_exists("STbox")) {
		$dl_plugin = new STbox();
	}

	//  Actions 
	// if (isset($dl_plugin)) {
	// 	// Add actions to footer
		add_action('wp_footer', array(&$dl_plugin, 'cssStyles')); //Add the definition of CSS and JS section footer
	// } 

	add_shortcode('all_lottery_agent_table_include', 'all_lottery_agent_table');
?>



 