<?php

 /*Template Name: Archive with pagination for all Lottery Sites

 */

get_header(); ?>
<?php
$total_posts = $wp_query->found_posts ;
$i = 1; ?>
<style>
    #content {
        width: 708px;
        float: left;
    }
    .content_mid_left{
        max-height: 1130px;
        overflow-y: auto;
        width: 705px;
        border: 1px solid #eee;
        margin-top: 15px;
    }
    .post-type-archive-lottery_sites .lottery_sites{
        padding: 5px;
        margin: 0;
        border: 1px solid #f9f9f9;
    }
    .ticket_sellers_wrap{
        background: none repeat scroll 0 0 #5e6574;
        border-bottom: 5px double #fff;
        color: #fff;
        height: 35px;
        margin-top: 10px;
        padding: 7px 0 0 9px;
    }
    .counter{
        background-color: #84cdc7;
        color: #fff;
        float: left;
        font-family: avant_guardregular;
        font-weight: bold;
        height: 33px;
        line-height: 30px;
        padding: 0;
        text-align: center;
        vertical-align: middle;
        width: 33px;
    }

    .lottery_name_single {
        font-family: oswald;
        font-size: 35px;
        left: 0;
        position: relative;
        top: 0px;
        text-align: center;
        color: #000;
        text-transform: capitalize;
        float: left;
        width: 280px;
    }
    .lottery_name_single img {
         position: relative;
         top: 10px;
     }
    .lottery_review_left {
        float: left;
        width: 215px;
        position: relative;
        left: 20px;
        top: 10px;
    }
    .approved_wrap{
        width: 160px;
        position: absolute;
        top: 37px;
        right: 0;
        float: right;
        height: auto;
    }
    .approved_wrap img{
        width: 100%;
        height: 100%;
    }
    .approved_sellers {
        background-color: #C10000;
        border: 5px double #FFF;
        font-family: Oswald;
        font-size: 16px;
        font-weight: 400;
        height: 58px;
        padding: 0 7px;
        position: absolute;
        right: 0;
        text-align: center;
        width: 108px;
        z-index: 0;
        top: 36px;
        cursor: pointer;
        color: white;
        display: block;

    }
    .filter_submit{
        border: none;
        height: 25px;
        width: 25px;
    }
    .filter_search_text{
        border: none;
        padding: 5px;
        width: 170px;
    }
    .filter_select{
        border: none;
        padding: 5px;
    }
    .filter_go_to{
        border: none;
        padding: 5px;
        width: 20px;
    }
    .lottery_review {
        position: relative;
        color: #069;
        padding: 0px;
        margin: 0 0 0px;
        min-height: 170px;
    }
    .lottery_draws_details {
        font-size: 25px;
        font-family: avant_guardregular;
        color: #fff;
        text-align: center;
        line-height: 33px;
    }
    .devider{
        display: inline-block;
        border-left: 1px solid #B3B3B3;
        height: 23px;
        padding: 0 0px;
        margin: -6px 0;
    }
    .blueline {
        height: 33px;
        background: #4EB3B1;
        border-bottom: 5px double #fff;
    }
    .search_result_text{
        font-family: 'PT Sans',sans-serif;
        font-weight: 700;
        font-size: 15px;
        text-transform: uppercase;
        position: relative;
        color: #A8A8A8;
        background: #f3f3f3;
        text-align: center;
    }
    .checkbox_1{
        margin: 4px;
        height: 13px;
        border: none;
    }
</style>

	<div id="container">

	  <div id="content" role="main">
<div class="ticket_sellers_wrap">
    <form style="display: inline-block" action="../all-lotteries/" method="post">
        <input type="text" class="filter_search_text" name="Ticket_Sellers_search" id="search_text" placeholder="Search for Ticket Sellers" />
        <input type="submit" class="filter_submit" value="Go" />

    </form>

    <form style="margin-left:10px; display: inline-block" action="../all-lotteries/" method="post">
        <div class="devider"></div>
        <label for="go_to">Go to:</label>
        <input type="text" class="filter_go_to" name="go_to" id="go_to" maxlength="2" value="<?php if (isset($_POST['go_to'])){echo  $_POST['go_to'];} else echo '1'; ?>" />
        <label for="num_rows">Show Ticket Sellers:</label>
        <select class="filter_select" id="num_rows" name="Ticket_Sellers" onchange="this.form.submit()">
            <option value="10" <?php if ($_POST['Ticket_Sellers'] == 10 ) echo ('selected="selected"');?>>10</option>
            <option value="15" <?php if ($_POST['Ticket_Sellers'] == 15 ) echo ('selected="selected"');?> >15</option>
            <option value="25" <?php if ($_POST['Ticket_Sellers'] == 25 ) echo ('selected="selected"');?>>25</option>
            <option value="50" <?php if ($_POST['Ticket_Sellers'] == 50 ) echo ('selected="selected"');?>>50</option>
            <option value="<?php echo $total_posts ; ?>" <?php if ($_POST['Ticket_Sellers'] == $total_posts ) echo ('selected="selected"');?>>all</option>
        </select>

        of <?php echo $total_posts ; ?> <div class="devider"></div>
        <input class="checkbox_1" type="checkbox" id="approved_only" name="approved_only"  onchange="this.form.submit()" <?php if (isset($_POST['approved_only'])){
        echo 'checked'; } ?>><label for="approved_only">Approved only</label>
    </form>
    <script>
        function myFunction() {
            $(this).closest('form').trigger('submit');
        }
    </script>
</div>
	  <div class="content_mid_left">

     <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
     $go_to = $_POST['go_to'];

     /* Check is Search form submited */
     if (isset($_POST['Ticket_Sellers_search'])) {
         $Ticket_Sellers_search = $_POST['Ticket_Sellers_search'];
         $mypost = array( 'post_type' => 'lottery_sites', 's'   => $Ticket_Sellers_search );

     } else {
     /* Check is Post per page form submited */
         if (isset($_POST['Ticket_Sellers']) ) {
             $Ticket_Sellers = $_POST['Ticket_Sellers'];
         }

         else $Ticket_Sellers = 10;
             $mypost = array( 'post_type' => 'lottery_sites', 'paged' =>$go_to ,'posts_per_page'   => $Ticket_Sellers );
     if (isset($_POST['approved_only'])){
         $mypost = array( 'post_type' => 'lottery_sites','meta_key' => 'lottery_sites_approved', 'meta_value' => '1' );
     }
     }

      $loop = new WP_Query( $mypost ); ?>

	  <!-- Cycle through all posts -->

      <?php while ( $loop->have_posts() ) : $loop->the_post(); $themedir = get_stylesheet_directory_uri(); $lottery_logo = wp_get_attachment_url( get_post_thumbnail_id($loop->ID) );?>

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		 

		<div class="reviewheader all_lotteries_reviewheader">
            <div class="blueline">

               <div class="counter"><?php  echo $i++ ; ?></div>  <div class="lottery_draws_details"><?php the_title(); ?></div>

            </div>

            <div class="lottery_basic">
                <div class="lottery_review_left">

                    <?php

                    $sitename = get_post_meta( get_the_ID(), 'lottery_sites_sitename', true );
                    $screenshot = get_post_meta( get_the_ID(), 'lottery_sites_screenshot', true );
                    $afflink = esc_html( get_post_meta( get_the_ID(), 'lottery_sites_afflink', true ) );

                    if($sitename != '' && empty($screenshot)) {
                        echo '<div class="lottery_review_screenshot"><a href="'.$afflink.'"><img src="http://s.wordpress.com/mshots/v1/http%3A%2F%2F'.$sitename.'?w=220" /></a></div>';
                    } else {
                        echo '<div class="lottery_review_screenshot"><a href="'.$afflink.'"><img src="'.$screenshot.'" /></a></div>';
                    }

                    ?>

                    <!-- <a class="promotions" href="http://www.lottoexposed.com/lottery-promotions/"></a> -->

                </div>

                <div class="lottery_name_single"><img src="<?php echo $lottery_logo; ?>" /></div>

                <div class="rating"></div>

                <div><?php  $approved = intval( get_post_meta( get_the_ID(), 'lottery_sites_approved', true ) );

                if ($approved == 1) {

                echo '<div class="approved_wrap"><img style="border: 0;" src="'.$themedir.'/images/approved.png" /></div>';

                } else {

                echo '<a class="approved_sellers" href="'.get_post_meta(get_the_ID(),'lottery_sites_revurl',true).'#respond'.'">Read and Submit<br />User Review</a>';

                }

                ?></div>
            </div>

		</div>

		<div class="lottery_review all_lotteries_lottery_review">

		<table class="review_table">

		<tr class="review_row">

		<td class="review_title"><span class="v-icon2">Funding methods:</span></td>

		<td class="review_postmeta" style="line-height: normal;"><?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_sites_funding', true ) ); ?></td>

		</tr>

		<tr class="review_row">

		<td class="review_title"><span class="v-icon2">Languages:</span></td>

		<td class="review_postmeta" ><?php $langs = esc_html( get_post_meta( get_the_ID(), 'lottery_sites_langs', true ) ); 

		$lang = explode (',', $langs);

		foreach ($lang as $l) {

		$l = trim($l);

		$lang_array = array("Arabic","Bahasa Indonesia","Belgium","Brazilian Portuguese","Bulgarian","Cantonese","Chinese","Croatian","Czech","Danish","Deutsch","Dutch","English","Estonian","Finnish","French Canadian","French","Greek","Hebrew","Hindi","Hungarian","Icelandic","Italian","Japanese","Korean","Latvian","Lithuanian","Macedonian","Moldovan","Norwegian","Polish","Portuguese","Romanian","Russian","Serbian","Slovakian","Slovenian","Spanish","Swedish","Turkish","Ukrainian","Vietnamese");

			if (!empty($l) && in_array($l, $lang_array)) {

			echo '<img style="border: 0; margin-top: 2px; vertical-align: middle;" src="'.$themedir.'/images/flags/'.$l.'.png" title="'.$l.'"/>';

			}

		} ?></td>

		</tr>

		<tr class="review_row">

		<td class="review_title"><a class="playnow" href="<?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_sites_afflink', true ) ); ?>"></a></td>

		<td class="review_postmeta"><?php $review_url = esc_html( get_post_meta( get_the_ID(), 'lottery_sites_revurl', true ) );

            if (!empty($review_url)) { ?>

                <a class="readreview" href="<?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_sites_revurl', true ) );?>"></a>

            <?php } ?></td>

		</tr>

				

		<?php /* $wot = get_post_meta( get_the_ID(), 'lottery_sites_wot', true );

		

		$r_trustworthiness = $wot['r0'];

		$r_reliability = $wot['r1'];

		$r_privacy = $wot['r2'];

		$r_child_safety = $wot['r4'];

		

		$r_array = array('trustworthiness' => $r_trustworthiness, 'reliability' => $r_reliability, 'privacy' => $r_privacy, 'child_safety' => $r_child_safety);

		

		$c_trustworthiness = $wot['c0'];

		$c_reliability = $wot['c1'];

		$c_privacy = $wot['c2'];

		$c_child_safety = $wot['c4'];

		

		$c_array = array('trustworthiness' => $c_trustworthiness, 'reliability' => $c_reliability, 'privacy' => $c_privacy, 'child_safety' => $c_child_safety);

		

		$rep = array();

		$con = array();

		

		foreach ($r_array as $key => $value) {

		

		if($value >= 0 && $value < 20) {

		$rep[$key] = "Very poor";

		$rep_icon = '';

		} else if($value >= 20 && $value < 40) {

		$rep[$key] = "Poor";

		$rep_icon = '';

		} else if($value >= 40 && $value < 60) {

		$rep[$key] = "Unsatisfactory";

		$rep_icon = '';

		} else if($value >= 60 && $value < 80) {

		$rep[$key] = "Good";

		$rep_icon = '';

		} else if($value >= 80 && $value <= 100) {

		$rep[$key] = "Excellent";

		$rep_icon = '';

		}

		

		}

		

		foreach ($c_array as $key => $value) {

		

		if($value >= 0 && $value < 6) {

		$con[$key] = 0;

		$rep_icon = '';

		} else if($value >= 6 && $value < 12) {

		$con[$key] = 1;

		$rep_icon = '';

		} else if($value >= 12 && $value < 23) {

		$con[$key] = 2;

		$rep_icon = '';

		} else if($value >= 23 && $value < 34) {

		$con[$key] = 3;

		$rep_icon = '';

		} else if($value >= 34 && $value < 45) {

		$con[$key] = 4;

		$rep_icon = '';

		} else if($value >= 45 && $value <= 100) {

		$con[$key] = 5;

		}

		

		}

		*/

		?>

		

		<!--

		

		<tr class="review_row">

		<td class="review_title">Web of Trust Reputation:</td>

		</tr>

		

		<tr class="review_row">

		<td class="review_title"><span class="wot-icon">Trustworthiness:</span></td>

		<td class="review_postmeta"></td>

		</tr>

		

		<tr class="review_row">

		<td class="review_title"><span class="wot-icon">Vendor reliability:</span></td>

		<td class="review_postmeta"></td>

		</tr>

		

		<tr class="review_row">

		<td class="review_title"><span class="wot-icon">Privacy:</span></td>

		<td class="review_postmeta"></td>

		</tr>

		

		<tr class="review_row">

		<td class="review_title"><span class="wot-icon">Child Safety:</span></td>

		<td class="review_postmeta"></td>

		</tr>

		--->

		

		</table>

		

		</div>

		

		</div>

		

   <?php endwhile;
      if (isset($Ticket_Sellers_search)){
          if (($loop->have_posts())) { ?>
              <div class="search_result_text">
                  Search found <?php echo $i-1; ?> results.
              </div>
          <?php    } else { ?>
              <div class="search_result_text">
              Nothing found in search. Please check spelling or try another term.
          </div>
         <?php    } ?>

    <?php  }?>
</div>

	</div><!-- #content -->

      <?php get_sidebar(); ?>

		</div><!-- #container -->

<?php wp_reset_query(); ?>

<?php get_footer(); ?>