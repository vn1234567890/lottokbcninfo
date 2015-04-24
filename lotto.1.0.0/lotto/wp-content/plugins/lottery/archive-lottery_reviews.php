 <?php

/*

Template Name: Archive with pagination for all Lottery Reviews



*/

get_header(); ?>



	<div id="container">

	  <div id="content" role="main">

	  <div class="content_mid_left">

     <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		$mypost = array( 'post_type' => 'lottery_reviews', 'paged' => $paged );

      $loop = new WP_Query( $mypost ); ?>

	  <!-- Cycle through all posts -->

      <?php while ( $loop->have_posts() ) : $loop->the_post(); $assigned_to = get_post_meta( get_the_ID(), 'lottery_reviews_assign', true ); $themedir = get_stylesheet_directory_uri();?>

        <div style="margin-top: 20px;" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		

		<div class="reviewheader">

			<img style="border: 0; left: 10px; position: absolute; top: 10px;" src="<?php bloginfo('template_directory'); ?>/images/hat.png" />

			<div class="lottery_name"><?php echo strtoupper(esc_html( get_post_meta( $assigned_to, 'lottery_sites_sitename', true ) )); ?></div>

			<div class="rating"></div>

			<div class="approved"><?php $approved = intval( get_post_meta( $assigned_to, 'lottery_sites_approved', true ) );

			if ($approved == 1) {

			echo '<img style="border: 0;" src="'.$themedir.'/images/approved.png" />';

			} else {

			echo '<a style="cursor: pointer; color: red; display: block; position: absolute; top: 4px;" onclick="scrollToElement(\'#respond\');">Read and Submit<br />User Review</a>';

			}

			?></div>

		</div>

		

		<div class="blueline">

			<div class="lottery_details">Lottery Details</div>

		</div>

		

		<div class="lottery_review">

		

		<div style="position: absolute; right: 15px; top: 15px;">

            <?php 

			$sitename = get_post_meta( $assigned_to, 'lottery_sites_sitename', true );

			$has_postimage = get_the_post_thumbnail($assigned_to, array( 220, 165 ));

			$afflink = esc_html( get_post_meta( $assigned_to, 'lottery_sites_afflink', true ) );

			if(empty($has_postimage) && $sitename != '') {

			echo '<a href="'.$afflink.'"><img style="border: 0;" src="http://s.wordpress.com/mshots/v1/http%3A%2F%2F'.$sitename.'?w=220" /></a>';

			} else {

			echo '<a href="'.$afflink.'">'.$has_postimage.'</a>';

			}

			?>

        </div>

		

		<table class="review_table">

		<tr>

		<td class="review_title"><span class="v-icon">Site Name:</span></td>

		<td class="review_postmeta"><?php echo esc_html( get_post_meta( $assigned_to, 'lottery_sites_sitename', true ) ); ?></td>

		</tr>

		<tr class="review_row">

		<td class="review_title"><span class="v-icon">Alexa:</span></td>

		<td class="review_postmeta"><?php echo esc_html( get_post_meta( $assigned_to, 'lottery_sites_alexa', true ) ); ?></td>

		</tr>

		<tr class="review_row">

		<td class="review_title"><span class="v-icon">Other sites:</span></td>

		<td class="review_postmeta"><?php echo esc_html( get_post_meta( $assigned_to, 'lottery_sites_othersites', true ) ); ?></td>

		</tr>

		<tr class="review_row">

		<td class="review_title"><span class="v-icon">Domain registration date:</span></td>

		<td class="review_postmeta"><?php echo esc_html( get_post_meta( $assigned_to, 'lottery_sites_domaindate', true ) ); ?></td>

		</tr>

		<tr class="review_row">

		<td class="review_title"><span class="v-icon">Funding methods:</span></td>

		<td class="review_postmeta" style="line-height: normal;"><?php echo esc_html( get_post_meta( $assigned_to, 'lottery_sites_funding', true ) ); ?></td>

		</tr>

		<tr class="review_row">

		<td class="review_title"><span class="v-icon">Languages:</span></td>

		<td class="review_postmeta" style="line-height: 0px;"><?php $langs = esc_html( get_post_meta( $assigned_to, 'lottery_sites_langs', true ) ); 

		$lang = explode (',', $langs);

		foreach ($lang as $l) {

		$l = trim($l);

		$lang_array = array("Arabic","Bahasa Indonesia","Belgium","Brazilian Portuguese","Bulgarian","Cantonese","Chinese","Croatian","Czech","Danish","Deutsch","Dutch","English","Estonian","Finnish","French Canadian","French","Greek","Hebrew","Hindi","Hungarian","Icelandic","Italian","Japanese","Korean","Latvian","Lithuanian","Macedonian","Moldovan","Norwegian","Polish","Portuguese","Romanian","Russian","Serbian","Slovakian","Slovenian","Spanish","Swedish","Turkish","Ukrainian","Vietnamese");

		if (!empty($l) && in_array($l, $lang_array)) {

		echo '<img style="border: 0; margin-top: 2px; vertical-align: middle;" src="'.$themedir.'/images/flags/'.$l.'.png" title="'.$l.'"/>';

		}

		}

		?></td>

		</tr>

		<tr class="review_row">

		<td class="review_title"><span class="v-icon">Facebook Fan Page:</span></td>

		<td class="review_postmeta"><a href="<?php echo esc_html( get_post_meta( $assigned_to, 'lottery_sites_fbpage', true ) ); ?>"><img style="border: 0; margin-bottom: 0.33em; vertical-align: middle;" src="<?php bloginfo('template_directory'); ?>/images/facebook_icon.jpg" /></a></td>

		</tr>

		<tr class="review_row">

		<td class="review_title"><span class="v-icon">Follow on Twitter:</span></td>

		<td class="review_postmeta"><a href="<?php echo esc_html( get_post_meta( $assigned_to, 'lottery_sites_twitter', true ) ); ?>"><img style="border: 0; margin-bottom: 0.33em; vertical-align: middle;" src="<?php bloginfo('template_directory'); ?>/images/twitter_icon.png" /></a></td>

		</tr>

		

		</table>

		

		<a class="playnow" href="<?php echo esc_html( get_post_meta( $assigned_to, 'lottery_sites_afflink', true ) ); ?>"></a>

		

		<a class="promotions" href="http://www.lottoexposed.com/lottery-promotions/"></a>

		

		</div>

		

		</div>

   <?php endwhile; if (!isset($_GET['s'])) { wp_pagenavi(array( 'query' => $loop ) ); } ?>

</div>

	</div><!-- #content -->

		</div><!-- #container -->

<?php wp_reset_query(); ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>