<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>
<div id="container-wrap">
		<div id="container">
			<div id="content" role="main">
             <div class="top_table">
                 <?php if(is_front_page()){ ?>
                 <div class="approved_lotteries_wrapper">
                     <div class="jackpots_box">
                         <div class="jackpots_box_header">Reliable Lotto Agents!<span class="arrow-down_left"></span></div>
                         <div class="jackpots_box_header_elm"><span class="box_header_1">Lottery Name</span><span class="box_header_2">Promotions</span><span class="box_header_3">Review</span> </div>
                         <div class="sidebar-jackpot">
                             <div class="sidebar-jackpot-logo"><a href="http://www.lottoexposed.com/thelotter-com-exposed/"><img border="0" src="http://www.lottoexposed.com/wp-content/uploads/2013/03/thelotter-lottoexposed.png"></a></div>
                             <a class="lottery_link" href="http://www.lottoexposed.com/thelotter-com-exposed/">theLotter.com</a>
                             <div class="sidebar-jackpot-promotion">Buy 1 and Get 1 Free</div>
                             <a rel="nofollow" class="visit_now_table" target="_blank" href="http://www.lottoexposed.com/TheLotter1"> » Visit Now</a>
                         </div>
                         <div class="sidebar-jackpot">
                             <div class="sidebar-jackpot-logo"><a href="http://www.lottoexposed.com/playhugelottos-com-exposed/"><img border="0" src="http://www.lottoexposed.com/wp-content/uploads/2013/03/phl-logo-58x56.png"></a></div>
                             <a class="lottery_link" href="http://www.lottoexposed.com/playhugelottos-com-exposed/">PlayHugeLottos.com</a>
                             <div class="sidebar-jackpot-promotion">100% Deposit Bonus</div>
                             <a rel="nofollow" class="visit_now_table" target="_blank" href="http://www.lottoexposed.com/PlayHugeLottos1"> » Visit Now</a>
                         </div>
                         <div class="sidebar-jackpot">
                             <div class="sidebar-jackpot-logo"><a href="http://www.lottoexposed.com/wintrillions-com-exposed/"><img border="0" src="http://www.lottoexposed.com/wp-content/uploads/2012/12/wintrillions.com_.png"></a></div>
                             <a class="lottery_link" href="http://www.lottoexposed.com/wintrillions-com-exposed/">WinTrillions.com</a>
                             <div class="sidebar-jackpot-promotion" style="margin-top: 15px">Get 1 Free Ticket <br/>+ 101% Welcome Bonus</div>
                             <a rel="nofollow" class="visit_now_table" target="_blank" href=" http://www.lottoexposed.com/WinTrillions"> » Visit Now</a>
                         </div>
                     </div>
                 </div>
                 <?php } ?>
             </div>
			<?php
			/* Run the loop to output the posts.
			 * If you want to overload this in a child theme then include a file
			 * called loop-index.php and that will be used instead.
			 */
			 get_template_part( 'loop', 'index' );
			?>
			</div><!-- #content -->
            <?php get_sidebar(); ?>
		</div><!-- #container -->
</div><!-- #container-wrap -->
<?php get_footer(); ?>
