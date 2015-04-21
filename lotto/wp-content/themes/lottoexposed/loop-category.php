<?php
/**
 * The loop that displays a category.
 *
 * The loop displays the posts and the post content. See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-attachment.php.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.2
 */
?>
<?php	while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="contentbg_top_left"></div>
		<div class="contentbg_mid_left">
			<div class="content_container">

				<div class="content2">
					<div class="text">
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2><g:plusone size="small" href="<?php the_permalink(); ?>"></g:plusone>

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
						<a class="size-thumbnail" href="<?php the_permalink(); ?>"><img src="<?php echo $thumb[0]; ?>" alt=""></a>
						<?php } ?>
				</div><!-- .img -->
				<div class="text_inner" style="text-align: justify">

                        <p class="date">
                            <?php echo get_the_date('d-M-Y'); ?>
                        </p>
                        <div class="posted_on"><?php twentyten_posted_on(); ?></div>

					<?php if (!is_single()) echo truncate_post(get_the_content(),50); else the_content();?>

						... <a href="<?php the_permalink(); ?>" class="read-more-cat">Read more »</a>

					<?php comments_template( '/custom-comments.php', true ); ?>
				</div>
				<div class="clear"></div>
			</div><!-- .content_inner_container -->
			</div><!-- .contentbg_mid_left -->
		<div class="contentbg_btm_left"></div>
		</div><!-- #post-## -->
<?php endwhile; wp_pagenavi(); // end of the loop. ?>