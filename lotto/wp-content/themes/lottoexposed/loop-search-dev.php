<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content. See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php /*if ( $wp_query->max_num_pages > 1 ) : ?>
	<div id="nav-above" class="navigation">
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyten' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyten' ) );></div>
	</div><!-- #nav-above -->
<?php endif; */?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<div id="post-0" class="post error404 not-found">
		<div class="contentbg_top_left"></div>
		<h1 class="entry-title"><?php _e( 'Not Found', 'twentyten' ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyten' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
		<div class="contentbg_btm_left"></div>
	</div><!-- #post-0 -->
<?php endif; ?>

<?php
	/* Start the Loop.
	 *
	 * In Twenty Ten we use the same loop in multiple contexts.
	 * It is broken into three main parts: when we're displaying
	 * posts that are in the gallery category, when we're displaying
	 * posts in the asides category, and finally all other posts.
	 *
	 * Additionally, we sometimes check for whether we are on an
	 * archive page, a search page, etc., allowing for small differences
	 * in the loop on each template without actually duplicating
	 * the rest of the loop that is shared.
	 *
	 * Without further ado, the loop:
	 */ ?>

<?php 	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$my_query = new WP_Query( array( 'post_type' => 'post', 'paged' => $paged ) );
		while ( have_posts() ) : the_post(); $assigned_review_to = intval( get_post_meta( $post->ID, '_lottery_reviews_assign', true ) ); $assigned_draw_to = intval( get_post_meta( $post->ID, '_lottery_draws_assign', true ) ); ?>

	<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
	
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="contentbg_top_left"></div>
		<div class="contentbg_mid_left">
			<div class="content_container">
				<div class="content1">
					<p class="date">
					<span class="month"><?php echo get_the_date('M'); ?></span>
					<span class="day"><?php echo get_the_date('d'); ?></span>
					</p>
				</div>
				<div class="content2">
					<div class="text">
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2><g:plusone size="small" href="<?php the_permalink(); ?>"></g:plusone>
						<div class="posted_on"><?php twentyten_posted_on(); ?></div>
					</div>
				</div>
				<div class="clear"></div>
			</div><!-- .content_container -->
			
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
			
			</div><!-- .contentbg_mid_left -->
		<div class="contentbg_btm_left"></div>
		</div><!-- #post-## -->
		
	<?php elseif (is_single() && $assigned_review_to != 0) : // Only display if there is assigned review for the current post. 
	$themedir = get_stylesheet_directory_uri();
	$lottery_logo = wp_get_attachment_url( get_post_thumbnail_id($assigned_review_to) );
	?> 
	
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
		<div class="contentbg_top_left"></div>
		<div class="contentbg_mid_left">
		
		<div id="REVIEWS">
		
		<div class="reviewheader">
			<img style="border: 0; left: 30px; top: 20px; position: absolute;" src="<?php echo $lottery_logo; ?>" />
			<div class="lottery_name_assigned"><?php echo esc_html( get_post_meta( $assigned_review_to, 'lottery_sites_sitename', true ) ); ?></div>
			<div class="rating"></div>
			<div class="approved"><?php $approved = intval( get_post_meta( $assigned_review_to, 'lottery_sites_approved', true ) );
			if ($approved == 1) {
			echo '<img style="border: 0;" src="'.$themedir.'/images/approved.png" />';
			} else {
			echo '<a style="cursor: pointer; color: #ffffff; display: block; position: absolute; top: 10px;" onclick="scrollToElement(\'#respond\');">Read and Submit<br />User Review</a>';
			}
			?></div>
		</div>
		
		<div class="blueline">
			<div class="lottery_draws_details">Lottery Information</div>
		</div>
		
		<div class="lottery_review">
		
		<div class="lottery_review_left">
            <?php 
			$sitename = get_post_meta( $assigned_review_to, 'lottery_sites_sitename', true );
			$afflink = esc_html( get_post_meta( $assigned_review_to, 'lottery_sites_afflink', true ) );
			if($sitename != '') {
			echo '<div class="lottery_review_screenshot""><a href="'.$afflink.'"><img src="http://s.wordpress
			.com/mshots/v1/http%3A%2F%2F'.$sitename
                .'?w=220" /></a></div>';
			}
			?>

		<a class="playnow" target="_blank" href="<?php echo esc_html( get_post_meta( $assigned_review_to, 'lottery_sites_afflink', true ) ); ?>"></a>
		</div>
		
		<table class="review_table">
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Funding methods:</span></td>
		<td class="review_postmeta" style="line-height: normal;"><?php echo esc_html( get_post_meta( $assigned_review_to, 'lottery_sites_funding', true ) ); ?></td>
		</tr>
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Languages:</span></td>
		<td class="review_postmeta" ><?php $langs = esc_html( get_post_meta( $assigned_review_to, 'lottery_sites_langs', true ) ); 
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
		<?php $gsafe = esc_html( get_post_meta( $assigned_review_to, 'lottery_sites_safebrowsing', true ) ); 
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
		<?php $safeb = esc_html( get_post_meta( $assigned_review_to, 'lottery_sites_antivirus', true ) ); 
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
		<?php $norton = esc_html( get_post_meta( $assigned_review_to, 'lottery_sites_norton', true ) ); 
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
		<?php echo number_format(esc_html( get_post_meta( $assigned_review_to, 'lottery_sites_alexa', true ) )); ?>
		</td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title review_group_title" colspan="2"><div>Social Reputation:</div></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Facebook Fan Page:</span></td>
		<td class="review_postmeta"><a href="<?php $fbpage = esc_html( get_post_meta( $assigned_review_to, 'lottery_sites_fbpage', true ) ); if (!empty($fbpage)) { echo $fbpage; } else { echo '#';} ?>"><img style="border: 0; margin-bottom: 0.33em; vertical-align: middle;" src="<?php bloginfo('template_directory'); ?>/images/facebook_icon.jpg" /></a></td>
		</tr>
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Follow on Twitter:</span></td>
		<td class="review_postmeta"><a href="<?php $twitter = esc_html( get_post_meta( $assigned_review_to, 'lottery_sites_twitter', true ) ); if (!empty($twitter)) { echo $twitter; } else { echo '#';} ?>"><img style="border: 0; margin-bottom: 0.33em; vertical-align: middle;" src="<?php bloginfo('template_directory'); ?>/images/twitter_icon.png" /></a></td>
		</tr>
				
		<?php /* $wot = get_post_meta( $assigned_review_to, 'lottery_sites_wot', true );
		
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
		
			<div class="content_container single_lottery_page">
				<div class="content2">
					<div class="text">
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<div class="posted_on">
                            <div class="posted_on_author"><?php the_author_link();?></div>
                            <div class="posted_on_date"><?php the_date('D, j-M-Y H:i');?></div>
                            <div class="posted_on_comments"><?php comments_number();?></div>
                            <div><g:plusone size="small" href="<?php the_permalink(); ?>"></g:plusone></div>
                        </div>
					</div>
				</div>
				<div class="clear"></div>
			</div><!-- .content_container -->
			
			<div class="content_inner_container entry-content">
				<div class="img">
					<?php
						$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
						if ( $images ) {
						$total_images = count( $images );
						$image = array_shift( $images );
						$thumb = wp_get_attachment_image_src( $image->ID, array(200,160) );
						?>
						<a class="size-thumbnail" href="<?php the_permalink(); ?>"><img src="<?php echo $thumb[0]; ?>" alt="post thumbnail"></a>
						<?php } ?>
				</div><!-- .img -->
				<div class="text_inner">
					<?php if (!is_single()) echo truncate_post(get_the_content(),60); else the_content();?>
					<?php comments_template( '/custom-comments2.php', true ); ?>
				</div>
				<div class="clear"></div>
			</div><!-- .content_inner_container -->
			</div><!-- .contentbg_mid_left -->
		<div class="contentbg_btm_left"></div>
		</div><!-- #post-## -->
			
	<?php elseif (is_single() && $assigned_draw_to != 0) : // Only display if there is assigned lottery draw for the current post. 
	$themedir = get_stylesheet_directory_uri();
	$lottery_logo = wp_get_attachment_url( get_post_thumbnail_id($assigned_draw_to) );
	?>
	
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
		<div class="contentbg_top_left"></div>
		<div class="contentbg_mid_left">
		
		<div id="DRAWS">
		
		<div class="reviewheader">
			<img style="border: 0; left: 30px; position: absolute;" src="<?php echo $lottery_logo; ?>" />
			<div class="lottery_draws_name"><?php echo esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_lottoname', true ) ); ?> Lottery</div>
			<div class="rating"></div>
		</div>
		
		<div class="blueline">
			<div class="lottery_draws_details">Available For International Players</div>
		</div>
		
		<div class="lottery_review">
            <div class="lottery_review_left">
            <?php 
			$draws_ss = get_post_meta( $assigned_draw_to, 'lottery_draws_ss', true );
			$afflink = esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_official_url', true ) );
			if($draws_ss != '') {
			echo '<a href="'.$afflink.'"><img style="border: 0; width: 220px; height: 165px;" src="'.$draws_ss.'" /></a>';
			}
			
			$lottoname = esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_lottoname', true ) );
			$graph = esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_graph', true ) );
			$query = $wpdb->get_results("SELECT * FROM jackpots WHERE lotto = '$graph'", ARRAY_A);
			$last = count($query)-1;
			
			for ($n = 1; $n < 10; $n++) {
				if(!empty($query[$last]['n'.$n])) {
				$nums[] = $query[$last]['n'.$n];
				}
			}
	

			$drawdate = $query[$last]['jpdate'];
			$jp = number_format($query[$last]['jp']);
			?>

		<a class="playnow" target="_blank" href="<?php echo esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_official_url', true ) ); ?>"></a>
		</div>
		
		<table class="review_table">
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Founded:</span></td>
		<td class="review_postmeta"><?php echo esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_founded', true ) ); ?></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Country:</span></td>
		<td class="review_postmeta">

            <!-- normally this stuff would be on the html element -->
            <!--[if lt IE 7]>  <div class="ie ie6 lte9 lte8 lte7"> <![endif]-->
            <!--[if IE 7]>     <div class="ie ie7 lte9 lte8 lte7"> <![endif]-->
            <!--[if IE 8]>     <div class="ie ie8 lte9 lte8"> <![endif]-->
            <!--[if IE 9]>     <div class="ie ie9 lte9"> <![endif]-->
            <!--[if gt IE 9]>  <div> <![endif]-->
            <!--[if !IE]><!--> <div>             <!--<![endif]-->
                <div class="atooltip">
                    <a class="jpbtn green small ">Supported Countries</a>
                    <div class="tooltips"><?php echo esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_country', true ) ); ?></div>
                </div>
            </div>
<!--		<a class="jpbtn green small tooltip" title="--><?php //echo esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_country', true ) ); ?><!--">Supported Countries<span class="classic"></span></a>-->
		
		</td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Official Site:</span></td>
		<td class="review_postmeta" ><a href="<?php echo esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_official_url', true ) ); ?>"><?php echo esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_official', true ) ); ?></a></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Days of Draw:</span></td>
		<td class="review_postmeta" ><?php echo esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_drawdays', true ) ); ?></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Average ticket price:</span></td>
		<td class="review_postmeta" ><?php echo esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_avgticket', true ) ); ?></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Odds of Winning:</span></td>
		<td class="review_postmeta" ><?php echo esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_odds', true ) ); ?></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Numbers to choose:</span></td>
		<td class="review_postmeta" ><?php echo esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_numbers', true ) ); ?></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">The Best Syndicate:</span></td>
		<td class="review_postmeta" ><a href="<?php echo esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_synlink', true ) ); ?>"><?php echo esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_syntext', true ) ); ?></a></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Jackpot Record:</span></td>
		<td class="review_postmeta" ><?php echo esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_jprec', true ) ); ?></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Facebook Fan Page:</span></td>
		<td class="review_postmeta"><a href="<?php echo esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_facebook', true ) ); ?>"><img style="border: 0; margin-bottom: 0.33em; vertical-align: middle;" src="<?php bloginfo('template_directory'); ?>/images/facebook_icon.jpg" /></a></td>
		</tr>
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Follow on Twitter:</span></td>
		<td class="review_postmeta"><a href="<?php echo esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_twitter', true ) ); ?>"><img style="border: 0; margin-bottom: 0.33em; vertical-align: middle;" src="<?php bloginfo('template_directory'); ?>/images/twitter_icon.png" /></a></td>
		</tr>
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Youtube channel:</span></td>
		<td class="review_postmeta"><a href="<?php echo esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_youtube', true ) ); ?>"><img style="border: 0; margin-bottom: 0.33em; vertical-align: middle;" src="<?php bloginfo('template_directory'); ?>/images/youtube_icon.jpg" /></a></td>
		</tr>
		
		<tr class="review_row">
		<td class="review_title"><span class="v-icon2">Latest <?php echo esc_html( get_post_meta( $assigned_draw_to, 'lottery_draws_lottoname', true ) );?> Winning Numbers:</span></td>
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

            <div class="content_container single_lottery_page">
                <div class="content2">
                    <div class="text">
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                        <div class="posted_on">
                            <div class="posted_on_author"><?php the_author_link();?></div>
                            <div class="posted_on_date"><?php the_date('D, j-M-Y H:i');?></div>
                            <div class="posted_on_comments"><?php comments_number();?></div>
                            <div><g:plusone size="small" href="<?php the_permalink(); ?>"></g:plusone></div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div><!-- .content_container -->
			
			<div class="content_inner_container entry-content">
				<div class="img">
					<?php
						$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
						if ( $images ) {
						$total_images = count( $images );
						$image = array_shift( $images );
						$thumb = wp_get_attachment_image_src( $image->ID, array(200,160) );
						?>
						<a class="size-thumbnail" href="<?php the_permalink(); ?>"><img src="<?php echo $thumb[0]; ?>" alt="post thumbnail"></a>
						<?php } ?>
				</div><!-- .img -->
				<div class="text_inner">
					<?php if (!is_single()) echo truncate_post(get_the_content(),60); else the_content();?>
					<?php comments_template( '/custom-comments2.php', true ); ?>
				</div>
				<div class="clear"></div>
			</div><!-- .content_inner_container -->
			</div><!-- .contentbg_mid_left -->
		<div class="contentbg_btm_left"></div>
		</div><!-- #post-## -->
		
	<?php else : ?>

                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="content_container">
                        <div class="content2">
                            <div class="text">
                                <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div><!-- .content_container -->
                    <?php
                    $browser = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
                    if ($browser == true){
                        $browser = 'iphone';
                    }
                    ?>
                    <div class="content_inner_container entry-content">
                        <div class="img">
                            <?php
                            $images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
                            if ( $images ) {
                                $total_images = count( $images );
                                $image = array_shift( $images );
                                $thumb = wp_get_attachment_image_src( $image->ID, array(200,160) );
                                ?>
                                <?php if($browser == 'iphone'){ ?><a class="size-thumbnail_mobi" href="<?php the_permalink(); ?>"><img src="<?php echo $thumb[0]; ?>" alt="LottoExposed.com Post Thumbnail" width="150" height="100"></a><?php } ?>

                                <a class="size-thumbnail" href="<?php the_permalink(); ?>"><img src="<?php echo $thumb[0]; ?>" alt="LottoExposed.com Post Thumbnail" width="200" height="150"></a>
                            <?php } ?>
                        </div><!-- .img -->
                        <div class="text_inner">
                            <div><p class="date">
                                    <?php echo get_the_date('d-M-Y'); ?>
                                </p></div>
                            <div class="posted_on"><?php twentyten_posted_on(); ?></div>
                            <div class="text_inner_content<?php if (is_front_page()) echo '_hp';?>">
                                <?php if (!is_single()) the_excerpt(); else the_content();?>
                            </div>
                            <?php comments_template( '/custom-comments2.php', true ); ?>
                            <div class="post_plusone">
                                <g:plusone size="medium" href="<?php the_permalink(); ?>"></g:plusone>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div><!-- .content_inner_container -->
                </div><!-- #post-## -->
			
		<?php endif; //comments_template( '', true ); ?>

<?php endwhile;
if (!isset($_GET['s']) && is_front_page()) { wp_pagenavi(array( 'query' => $my_query ) ); } ?>
<script>
            function scrollToElement(selector, callback){
                var animation = {scrollTop: $(selector).offset().top};
                $('html,body').animate(animation, 'slow', 'swing', function() {
                    if (typeof callback == 'function') {
                        callback();
                    }
                    callback = null;

                });
            }
		</script>


