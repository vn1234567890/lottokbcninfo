<?php

 /*Template Name: Lottery Sites - Single

 */

get_header(); ?>



	  <div id="container">

	  <div id="content" role="main">

	  <div class="content_mid_left">

	  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); $themedir = get_stylesheet_directory_uri(); $lottery_logo = wp_get_attachment_url( get_post_thumbnail_id (get_the_ID()) ); ?>

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		 

		<div class="reviewheader all_lotteries_reviewheader">

			<img style="border: 0; left: 30px; top: 20px; position: absolute;" src="<?php echo $lottery_logo; ?>" />

			<div class="lottery_name_single"><?php the_title(); //echo esc_html( get_post_meta( get_the_ID(), 'lottery_sites_sitename', true ) ); ?></div>

			<div class="rating"></div>

			<div class="approved"><?php /* $approved = intval( get_post_meta( get_the_ID(), 'lottery_sites_approved', true ) );

			if ($approved == 1) {

			echo '<img style="border: 0;" src="'.$themedir.'/images/approved.png" />';

			} else {

			echo '<a style="cursor: pointer; color: red; display: block; position: absolute; top: 4px;" onclick="scrollToElement(\'#respond\');">Read and Submit<br />User Review</a>';

			} */

			?></div>

		</div>

		

		<div class="blueline">

			<div class="lottery_draws_details">Lottery Information</div>

		</div>

		

		<div class="lottery_review all_lotteries_lottery_review">

		

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

            <a class="promotions" href="http://www.lottoexposed.com/lottery-promotions/"></a>



            <?php $review_url = esc_html( get_post_meta( get_the_ID(), 'lottery_sites_revurl', true ) );

            if (!empty($review_url)) { ?>

                <a class="readreview" href="<?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_sites_revurl', true ) );?>"></a>

            <?php } ?>



            <a class="playnow" href="<?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_sites_afflink', true ) ); ?>"></a>

        </div>

		

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

        <td class="review_title review_group_title" colspan="2"><div>Safety:</div></td>

		</tr>

		

		<tr class="review_row">

		<td class="review_title"><span class="google-icon">Google Safebrowsing:</span></td>

		<td class="review_postmeta">

		<?php $gsafe = esc_html( get_post_meta( get_the_ID(), 'lottery_sites_safebrowsing', true ) ); 

		if ($gsafe == 1) {

		echo '<img style="border: 0; vertical-align: middle;" src="'.$themedir.'/images/check-mark.png" />';

		} else {

		echo '<img style="border: 0; vertical-align: middle;" src="'.$themedir.'/images/red-mark.png" />';

		} ?>

		</td>

		</tr>

		

		<tr class="review_row">

		<td class="review_title"><span class="antivirus-icon">Website antivirus:</span></td>

		<td class="review_postmeta">

		<?php $safeb = esc_html( get_post_meta( get_the_ID(), 'lottery_sites_antivirus', true ) ); 

		if ($safeb == 1) {

		echo '<img style="border: 0; vertical-align: middle;" src="'.$themedir.'/images/check-mark.png" />';

		} else {

		echo '<img style="border: 0; vertical-align: middle;" src="'.$themedir.'/images/red-mark.png" />';

		} ?>

		</td>

		</tr>

		

		<tr class="review_row">

		<td class="review_title"><span class="norton-icon">Norton Safeweb:</span></td>

		<td class="review_postmeta">

		<?php $norton = esc_html( get_post_meta( get_the_ID(), 'lottery_sites_norton', true ) ); 

		if ($norton == 1) {

		echo '<img style="border: 0; vertical-align: middle;" src="'.$themedir.'/images/check-mark.png" />';

		} else {

		echo '<img style="border: 0; vertical-align: middle;" src="'.$themedir.'/images/red-mark.png" />';

		} ?>

		</td>

		</tr>

		

		<tr class="review_row">

		<td class="review_title"><span class="alexa-icon">Alexa Ranking:</span></td>

		<td class="review_postmeta">

		<?php echo number_format(esc_html( get_post_meta( get_the_ID(), 'lottery_sites_alexa', true ) )); ?>

		</td>

		</tr>

		

		<tr class="review_row">

        <td class="review_title review_group_title" colspan="2"><div>Social Reputation:</div></td>

		</tr>

		

		<tr class="review_row">

		<td class="review_title"><span class="v-icon2">Facebook Fan Page:</span></td>

		<td class="review_postmeta"><a href="<?php $fbpage = esc_html( get_post_meta( get_the_ID(), 'lottery_sites_fbpage', true ) ); if (!empty($fbpage)) { echo $fbpage; } else { echo '#';} ?>"><img style="border: 0; margin-bottom: 0.33em; vertical-align: middle;" src="<?php bloginfo('template_directory'); ?>/images/facebook_icon.jpg" /></a></td>

		</tr>

		<tr class="review_row">

		<td class="review_title"><span class="v-icon2">Follow on Twitter:</span></td>

		<td class="review_postmeta"><a href="<?php $twitter = esc_html( get_post_meta( get_the_ID(), 'lottery_sites_twitter', true ) ); if (!empty($twitter)) { echo $twitter; } else { echo '#';} ?>"><img style="border: 0; margin-bottom: 0.33em; vertical-align: middle;" src="<?php bloginfo('template_directory'); ?>/images/twitter_icon.png" /></a></td>

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

   <?php endwhile;  ?>

   <?php endif; ?>

</div>

	</div><!-- #content -->

      <?php get_sidebar(); ?>

		</div><!-- #container -->

<?php wp_reset_query(); ?>

<?php get_footer(); ?>