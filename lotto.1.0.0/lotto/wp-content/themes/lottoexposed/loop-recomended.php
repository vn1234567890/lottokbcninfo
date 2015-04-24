<?php
/**
 * Template Name: Recommended page
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


            <div class="recommended_table_header">Recomended Online Lottery Ticket Seller</div>
            <div class="recommended_table_body">
                <div class="recommended_table_row1"><img src="<?php the_field('rec_logo_no1'); ?>" width="211" height="59" />
                    <div class="recommended_table_featured"><span></span> <?php the_field('rec_featured_no1'); ?></div>
                    <div class="recommended_table_small_heading">Hot Welcome Offer</div>
                    <div class="recommended_table_hot"><p><?php the_field('hot_welcome_offer_1'); ?></p></div>
                    <div class="recommended_table_small_heading">Lottery Seller Review</div>
                    <div class="recommended_table_text"><p><?php the_field('lottery_seller_review_1'); ?></p>
                        <div class="recommended_table_review_button"><a href="<?php the_field('rec_review_button_no1'); ?>" target="_blank"></a></div>
                    </div>
                    <div class="recommended_table_small_heading">Worth The Money?</div>
                    <div class="recommended_table_text"><p><?php the_field('worth_the_money_1'); ?></p></div>
                    <div class="recommended_table_button"><a href="<?php the_field('play_now_button_no1'); ?>"></a></div>

                </div>
                <!-- end first row -->
                <div class="recommended_table_row2"><img src="<?php the_field('rec_logo_no2'); ?>" width="211" height="59" />
                    <div class="recommended_table_featured"><span></span> <?php the_field('rec_featured_no2'); ?></div>
                    <div class="recommended_table_small_heading">Hot Welcome Offer</div>
                    <div class="recommended_table_hot"><p><?php the_field('hot_welcome_offer_2'); ?></p></div>
                    <div class="recommended_table_small_heading">Lottery Seller Review</div>
                    <div class="recommended_table_text"><p><?php the_field('lottery_seller_review_2'); ?></p>
                        <div class="recommended_table_review_button"><a href="<?php the_field('rec_review_button_no2'); ?>" target="_blank"></a></div>
                    </div>
                    <div class="recommended_table_small_heading">Worth The Money?</div>
                    <div class="recommended_table_text"><p><?php the_field('worth_the_money_2'); ?></p></div>
                    <div class="recommended_table_button"><a href="<?php the_field('play_now_button_no2'); ?>"></a></div>

                </div>
                <!-- end second row -->
                <div class="recommended_table_row3"><img src="<?php the_field('rec_logo_no3'); ?>" width="211" height="59" />
                    <div class="recommended_table_featured"><span></span> <?php the_field('rec_featured_no3'); ?></div>
                    <div class="recommended_table_small_heading red">ATTENTION! OUR HOT OFFER!</div>
                    <div class="recommended_table_hot"><p><?php the_field('hot_welcome_offer_3'); ?></p></div>
                    <div class="recommended_table_small_heading">Lottery Seller Review</div>
                    <div class="recommended_table_text"><p><?php the_field('lottery_seller_review_3'); ?></p>
                        <div class="recommended_table_review_button"><a href="<?php the_field('rec_review_button_no3'); ?>" target="_blank"></a></div>
                    </div>
                    <div class="recommended_table_small_heading">Worth The Money?</div>
                    <div class="recommended_table_text"><p><?php the_field('worth_the_money_3'); ?></p></div>
                    <div class="recommended_table_button"><a href="<?php the_field('play_now_button_no3'); ?>"></a></div>

                </div>
                <!-- end third row --></div>
            <!-- end body -->
            <div class="promo_table_footer clear">Check Out Our Top Lottery Ticket Sellers Promotions</div>

        <!-- end table row -->
        <h3>What makes these recommended lottery ticket sellers great?</h3>

        <p>What do these lotteries have in common? Simple yet beautiful design and a user friendly interface, a nice variety of lottery games and an unswerving pledge
            for preserving the highest security standards. All my recommended lotteries use secure encryption protocols Like SSL to their Credit Card Clearing on site,
            have an excellent customer support and are fully licensed. Below you’ll find our recommended ticket seller features compared.</p>
        <!-- Featured table -->
        <div class="featured_table">
                <div class="featured_table_heading_column">
                <div class="featured_table_heading_row_header">Feature</div>
                    <div class="featured_table_heading_row_odd"><p>Number of games available</p></div>
                    <div class="featured_table_heading_row_even"><p>Is it possible to buy a single ticket?</p></div>
                    <div class="featured_table_heading_row_odd"><p>Is it easy to buy the tickets?</p></div>
                    <div class="featured_table_heading_row_even"><p>Is it secure?</p></div>
                    <div class="featured_table_heading_row_odd"><p>Is site multilingual?</p></div>
                    <div class="featured_table_heading_row_even"><p>Any commission on winnings?</p></div>
                    <div class="featured_table_heading_row_odd"><p>Is it possible to play in groups?</p></div>
                    <div class="featured_table_heading_row_even"><p>Bonuses offered</p></div>
                    <div class="featured_table_heading_row_odd" style="height: 55px"><p>Deposit methods Credit Card</p></div>
                    <div class="featured_table_heading_row_even"><p>Deposit methods Other</p></div>
                    <div class="featured_table_heading_row_odd"><p>Donations</p></div>
                    <div class="featured_table_heading_row_even"><p>Mobile applications</p></div>
                </div>
            <!-- First Seller Features -->
                <div class="featured_table_col_1">
                    <div class="featured_table_heading_row_seller"><a href="<?php the_field('play_now_button_no1'); ?>"><?php the_field('lottery_ticket_seller_name_no1'); ?></a></div>
                    <div class="featured_table_seller_row_odd"><span><?php the_field('number_of_games_available_1'); ?></span></div>
                    <div class="featured_table_seller_row_even"><?php the_field('is_it_possible_to_buy_a_single_ticket_1'); ?></div>
                    <div class="featured_table_seller_row_odd"><?php the_field('is_it_easy_to_buy_the_tickets_1'); ?></div>
                    <div class="featured_table_seller_row_even"><?php the_field('is_it_secure_1'); ?></div>
                    <div class="featured_table_seller_row_odd"><?php the_field('is_site_multilingual_1'); ?></div>
                    <div class="featured_table_seller_row_even"><span><?php the_field('any_commission_on_winnings_1'); ?></span></div>
                    <div class="featured_table_seller_row_odd"><?php the_field('is_it_possible_to_play_in_groups_1'); ?></div>
                    <div class="featured_table_seller_row_even"><?php the_field('bonuses_offered_1'); ?></div>
                    <div class="featured_table_seller_row_odd" style="min-height: 26px;padding: 15px 0 0 7px;text-indent: -9999px;"><?php the_field('deposit_methods_credit_card_1'); ?></div>
                    <div class="featured_table_seller_row_even"><?php the_field('deposit_methods_other_1'); ?></div>
                    <div class="featured_table_seller_row_odd"><?php the_field('donations_1'); ?></div>
                    <div class="featured_table_seller_row_even"><?php the_field('mobile_applications_1'); ?></div>
                </div>
            <!-- End First Seller Features -->
            <!-- Second Seller Features -->
                <div class="featured_table_col_2">
                    <div class="featured_table_heading_row_seller"><a href="<?php the_field('play_now_button_no2'); ?>"><?php the_field('lottery_ticket_seller_name_no2'); ?></a></div>
                    <div class="featured_table_seller_row_odd"><span><?php the_field('number_of_games_available_2'); ?></span></div>
                    <div class="featured_table_seller_row_even"><?php the_field('is_it_possible_to_buy_a_single_ticket_2'); ?></div>
                    <div class="featured_table_seller_row_odd"><?php the_field('is_it_easy_to_buy_the_tickets_2'); ?></div>
                    <div class="featured_table_seller_row_even"><?php the_field('is_it_secure_2'); ?></div>
                    <div class="featured_table_seller_row_odd"><?php the_field('is_site_multilingual_2'); ?></div>
                    <div class="featured_table_seller_row_even"><span><?php the_field('any_commission_on_winnings_2'); ?></span></div>
                    <div class="featured_table_seller_row_odd"><?php the_field('is_it_possible_to_play_in_groups_2'); ?></div>
                    <div class="featured_table_seller_row_even"><?php the_field('bonuses_offered_2'); ?></div>
                    <div class="featured_table_seller_row_odd"  style="min-height: 52px;padding: 3px 10px 0 23px;text-indent: -9999px;"><?php the_field('deposit_methods_credit_card_2'); ?></div>
                    <div class="featured_table_seller_row_even" style="line-height: 20px;overflow:visible"><?php the_field('deposit_methods_other_2'); ?></div>
                    <div class="featured_table_seller_row_odd" style="line-height: 11px;overflow:visible"><?php the_field('donations_2'); ?></div>
                    <div class="featured_table_seller_row_even"><?php the_field('mobile_applications_2'); ?></div>
            <!--End Second Seller Features -->
            <!--Third Seller Features -->
                </div>
                <div class="featured_table_col_3">
                    <div class="featured_table_heading_row_seller"><a href="<?php the_field('play_now_button_no3'); ?>"><?php the_field('lottery_ticket_seller_name_no3'); ?></a></div>
                    <div class="featured_table_seller_row_odd"><span><?php the_field('number_of_games_available_3'); ?></span></div>
                    <div class="featured_table_seller_row_even"><?php the_field('is_it_possible_to_buy_a_single_ticket_3'); ?></div>
                    <div class="featured_table_seller_row_odd"><?php the_field('is_it_easy_to_buy_the_tickets_3'); ?></div>
                    <div class="featured_table_seller_row_even"><?php the_field('is_it_secure_3'); ?></div>
                    <div class="featured_table_seller_row_odd"><?php the_field('is_site_multilingual_3'); ?></div>
                    <div class="featured_table_seller_row_even"><span><?php the_field('any_commission_on_winnings_3'); ?></span></div>
                    <div class="featured_table_seller_row_odd"><?php the_field('is_it_possible_to_play_in_groups_3'); ?></div>
                    <div class="featured_table_seller_row_even"><?php the_field('bonuses_offered_3'); ?></div>
                    <div class="featured_table_seller_row_odd"  style="min-height: 26px;padding: 15px 0 0 7px;text-indent: -9999px;"><?php the_field('deposit_methods_credit_card_3'); ?></div>
                    <div class="featured_table_seller_row_even"><?php the_field('deposit_methods_other_3'); ?></div>
                    <div class="featured_table_seller_row_odd"><?php the_field('donations_3'); ?></div>
                    <div class="featured_table_seller_row_even"><?php the_field('mobile_applications_3'); ?></div>
                </div>
            <!-- End Third Seller Features -->
        </div><!-- End Featured table -->
        <div class="clear"></div>
        <p>I know how difficult it is to beat the odds in lottery draws, and I don’t want my visitors to be pitted against unnecessary challenges.
            Finding the right lottery is one of them, and that’s why I make it my mission to find the best ones and rate them accordingly.
            I don’t hesitate to make a harsh criticism when needed, because I feel that my readers deserve an honest opinion.</p>
        <h3>Stay safe and enjoy the game</h3>
        <p>In an industry where the number of dishonest operators greatly exceeds trustworthy ones, you can rest assured that my recommended lotteries are 100% secure.
            Moreover, I have checked and reviewed all user complaints, lottery frauds, and lottery scams about the lotteries and add their reviews.
            I frequently update the list of endorsed lotteries and strive to create a bridge between the best operators and lottery players.</p>
        <h2>Enjoy,</h2>
        <img class="size-full wp-image-768 alignnone" src="http://www.lottoexposed.com/wp-content/uploads/2012/12/sign-nick-s1.png" alt="Nick Silver" width="299" height="93" />

        <?php comments_template( '/custom-comments2.php', true ); ?>
    </div><!-- #content -->



<?php get_sidebar(); ?></div><!-- #container -->
<?php get_footer(); ?>

