<?php
/**
 * Template Name: Review page
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

						<?php the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="contentbg_top_left"></div>
				<div class="contentbg_mid_left">
				<div class="content_container">
					<div class="content1">
						<div class="date">
							<div class="bigdate">
								<?php echo get_the_date('d'); ?><div><?php echo get_the_date('M'); ?></div>
							</div>
						</div>
					</div>
					<div class="content2">
						<div class="text">
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
							<div class="posted_on"><?php twentyten_posted_on(); ?></div>
						</div>
					</div>
					<div class="clear"></div>
				</div><!-- .content_container -->
				<div class="content_inner_container">

					<div class="text_inner">
						<?php show_review_table(); ?>
						<?php echo the_content(); ?>
						<div class="comment_and_readmore">
							<a href="" id="show_comments"><img width="117" height="44" alt="" src="<?php bloginfo('template_url') ?>/images/comment_btn.png"></a> 
						</div>
						<?php comments_template( '', true ); ?>
					</div>
					
				</div>
				
				<div class="clear"></div>
				</div><!-- .contentbg_mid_lef -->

				<div class="contentbg_btm_left"></div>
				</div><!-- #post-## -->
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
