<?php
/**
 * The loop that displays a page.
 *
 * The loop displays the posts and the post content. See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-page.php.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.2
 */
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="content_container2">
					<div class="content2">
						<div class="text">
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						</div>
					</div>
					<div class="clear"></div>
				</div><!-- .content_container -->
				<div class="content_inner_container">
					<?php /*<div class="img">
						<?php
							$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
							if ( $images ) {
							$total_images = count( $images );
							$image = array_shift( $images );
							$thumb = wp_get_attachment_image_src( $image->ID, array(200,160) );
							?>
							<a class="size-thumbnail" href="<?php the_permalink(); ?>"><img src="<?php echo $thumb[0]; ?>" alt=""></a>
							<?php } ?>
					</div><!-- .img --> <?php */ ?>
					<div class="text_inner">
						<?php echo the_content(); ?>
						<?php comments_template( '/custom-comments2.php', true ); ?>
					</div>
					
				</div>
				
				<div class="clear"></div>
				</div><!-- #post-## -->

<?php endwhile; // end of the loop. ?>
