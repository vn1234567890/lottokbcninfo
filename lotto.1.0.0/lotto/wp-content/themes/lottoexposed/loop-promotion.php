<?php
/**
 * Template Name: Promotion page
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

<?php get_header(); ?>
<div id="container">
    <div id="content" role="main">
        <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <?php echo the_content(); ?>
        <?php endwhile; // end of the loop. ?>

        <div>
            <div class="promo_table_header">Online Lottery Ticket Seller</div>
            <div class="promo_table_body">
                <div class="promo_table_row1"><img src="<?php the_field('logo_no1'); ?>" width="211" height="59" />
                    <div class="promo_table_founded">Founded in <?php the_field('founded_no1'); ?></div>
                    <div class="promo_table_video"><?php the_field('video_no1'); ?></div>
                    <a href="<?php the_field('play_now_no1'); ?>"><div class="promo_table_button"></div></a>
                    <div class="promo_table_small_heading">Incredible Live Promotions</div>
                    <div class="promo_table_text"><p><?php the_field('review_no1_1'); ?></p></div>

                    <a href="<?php the_field('review_button_no1'); ?>" target="_blank"><div class="promo_table_review_button"></div></a>
                </div>
                <!-- end first row -->
                <div class="promo_table_row2"><img src="<?php the_field('logo_no2'); ?>" width="211" height="59" />
                    <div class="promo_table_founded">Founded in <?php the_field('founded_no2'); ?></div>
                    <div class="promo_table_video"><?php the_field('video_no2'); ?></div>
                    <a href="<?php the_field('play_now_no2'); ?>"><div class="promo_table_button"></div></a>
                    <div class="promo_table_small_heading_gray">Incredible Live Promotions</div>
                    <div class="promo_table_text"><p><?php the_field('review_text_2_1'); ?></p></div>

                    <a href="<?php the_field('review_btn_no2'); ?>" target="_blank"><div class="promo_table_review_button"></div></a>

                </div>
                <!-- end second row -->
                <div class="promo_table_row3"><img src="<?php the_field('logo_no3'); ?>" width="211" height="59" />
                    <div class="promo_table_founded">Founded in <?php the_field('founded_no3'); ?></div>
                    <div class="promo_table_video"><?php the_field('video_no3'); ?></div>
                    <a href="<?php the_field('play_now_no3'); ?>"><div class="promo_table_button"></div></a>
                    <div class="promo_table_small_heading">Incredible Live Promotions</div>
                    <div class="promo_table_text"><p><?php the_field('review_text_3_1'); ?></p></div>
                    
                    <a href="<?php the_field('review_button_no3'); ?>" target="_blank"><div class="promo_table_review_button"></div></a>
                </div>
                <!-- end third row --></div>
            <!-- end body -->
            <div class="promo_table_footer clear">Check Out Our Top Lottery Ticket Sellers Promotions</div>
        </div>
        <!-- end table row -->
        <h2>Enjoy,</h2>
        <img class="size-full wp-image-768 alignnone" src="http://www.lottoexposed.com/wp-content/uploads/2012/12/sign-nick-s1.png" alt="Nick Silver" width="299" height="93" />

        <?php comments_template( '/custom-comments2.php', true ); ?>
    </div><!-- #content -->



<?php get_sidebar(); ?></div><!-- #container -->
<?php get_footer(); ?>

