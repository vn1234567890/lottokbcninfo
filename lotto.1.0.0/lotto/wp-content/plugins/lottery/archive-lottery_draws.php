<?php
 /*Template Name: Archive with pagination for all Lottery Draws
 */
get_header(); ?>

	<div id="container">
	  <div id="content" role="main">
	  <div class="content_mid_left">
     <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$mypost = array( 'post_type' => 'lottery_draws', 'paged' => $paged );
      $loop = new WP_Query( $mypost ); ?>
	  <!-- Cycle through all posts -->
      <?php while ( $loop->have_posts() ) : $loop->the_post(); $themedir = get_stylesheet_directory_uri(); $lottery_logo = wp_get_attachment_url( get_post_thumbnail_id($loop->ID) );?>
        <div style="margin-bottom: 20px;" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<div class="reviewheader all_lotteries_reviewheader">
			<img style="border: 0; left: 30px; top: 10px; position: absolute;" src="<?php echo $lottery_logo; ?>" />
			<div class="lottery_draws_name" style="top: 22px;"><?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_draws_lottoname', true ) ); ?> Lottery</div>
			<div class="rating"></div>
		</div>
		
		<div class="blueline">
			<div class="lottery_draws_details">Available For International Players</div>
		</div>
		
		<div class="lottery_review all_lotteries_lottery_review">
		
		<div class="lottery_review_left">
            <?php 
			$draws_ss = get_post_meta( get_the_ID(), 'lottery_draws_ss', true );
			$afflink = esc_html( get_post_meta( get_the_ID(), 'lottery_draws_official_url', true ) );
			if($draws_ss != '') {
			echo '<div class="lottery_review_screenshot"><a href="'.$afflink.'"><img  src="'.$draws_ss.'" /></a></div>';
			}
			
			$lottoname = esc_html( get_post_meta( get_the_ID(), 'lottery_draws_lottoname', true ) );
			$graph = esc_html( get_post_meta( get_the_ID(), 'lottery_draws_graph', true ) );
			$query = $wpdb->get_results("SELECT * FROM jackpots WHERE lotto = '$graph'", ARRAY_A);
			$last = count($query)-1;
			
			$nums = array();
			
			for ($n = 1; $n < 10; $n++) {
				if(!empty($query[$last]['n'.$n])) {
				$nums[] = $query[$last]['n'.$n];
				}
			}
	
			$nums = implode('-', $nums);
			$drawdate = $query[$last]['jpdate'];
			$jp = number_format($query[$last]['jp']);
			?>
            <a class="promotions" href="http://www.lottoexposed.com/lottery-promotions/"></a>
            <a class="playnow0" onclick="scrollToElement('.entry-title');"></a>
        </div>
		
		<table class="review_table">
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Founded:</span></td>
		<td class="review_postmeta"><?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_draws_founded', true ) ); ?></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Country:</span></td>
		<td class="review_postmeta">
		
		<a class="jpbtn green small tooltip">Supported Countries<span class="classic"><?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_draws_country', true ) ); ?></span></a>
		
		</td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Official Site:</span></td>
		<td class="review_postmeta" ><a href="<?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_draws_official_url', true ) ); ?>"><?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_draws_official', true ) ); ?></a></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Days of Draw:</span></td>
		<td class="review_postmeta" ><?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_draws_drawdays', true ) ); ?></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Average ticket price:</span></td>
		<td class="review_postmeta" ><?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_draws_avgticket', true ) ); ?></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Odds of Winning:</span></td>
		<td class="review_postmeta" ><?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_draws_odds', true ) ); ?></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Numbers to choose:</span></td>
		<td class="review_postmeta" ><?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_draws_numbers', true ) ); ?></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">The Best Syndicate:</span></td>
		<td class="review_postmeta" ><a href="<?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_draws_synlink', true ) ); ?>"><?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_draws_syntext', true ) ); ?></a></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Jackpot Record:</span></td>
		<td class="review_postmeta" ><?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_draws_jprec', true ) ); ?></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Facebook Fan Page:</span></td>
		<td class="review_postmeta"><a href="<?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_draws_facebook', true ) ); ?>"><img style="border: 0; margin-bottom: 0.33em; vertical-align: middle;" src="<?php bloginfo('template_directory'); ?>/images/facebook_icon.jpg" /></a></td>
		</tr>
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Follow on Twitter:</span></td>
		<td class="review_postmeta"><a href="<?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_draws_twitter', true ) ); ?>"><img style="border: 0; margin-bottom: 0.33em; vertical-align: middle;" src="<?php bloginfo('template_directory'); ?>/images/twitter_icon.png" /></a></td>
		</tr>
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Youtube channel:</span></td>
		<td class="review_postmeta"><a href="<?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_draws_youtube', true ) ); ?>"><img style="border: 0; margin-bottom: 0.33em; vertical-align: middle;" src="<?php bloginfo('template_directory'); ?>/images/youtube_icon.jpg" /></a></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Latest <?php echo esc_html( get_post_meta( get_the_ID(), 'lottery_draws_lottoname', true ) );?> Winning Numbers:</span></td>
		<td class="review_postmeta" ><?php echo $nums; ?></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Next Draw Date:</span></td>
		<td class="review_postmeta" ><?php echo $drawdate; ?></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Next Jackpot:</span></td>
		<td class="review_postmeta" ><?php echo $jp; ?></td>
		</tr>
		
		</table>
		
		</div>
		
		</div>
   <?php endwhile; if (!isset($_GET['s'])) { wp_pagenavi(array( 'query' => $loop ) ); } ?>
</div>
	</div><!-- #content -->
        <?php get_sidebar(); ?>
		</div><!-- #container -->
<?php wp_reset_query(); ?>
<?php get_footer(); ?>