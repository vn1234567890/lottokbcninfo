    <div class="content_right">
	
	<div class="sidebar-block sidebar-block-bg" style="height: 305px;">
	<div class="sidebar-block-header"><span class="arrow-down"></span>Lottery jackpots</div>
	<?php echo do_shortcode('[top3jps]'); ?>
	</div>
	
	<!-- <div class="newsletter_box_wraper">

	<div class="sidebar-block newsletter_wrap">

		<div class="sidebar-block subscribe-newsletter overflow_hidden">

		<div class="sidebar-block-header">Subscribe newsletter</div>

            <form action="http://www.lottoexposed.com/newsletter/subscribe" name="subscription" method="post">

                <input type="hidden" name="list" value="74FQj5qkynNsmxD2fezckw"/>

                <div class="text_box"><input name="email" type="text" value="" placeholder="name@domain.com" class="box"/></div>

                <p>I want to receive news by email &nbsp; </p>

                <button>subscribe now</button>

            </form>

		</div> 

         </div>

		</div> -->
	
	<div class="sidebar-block sidebar-block-bg">
	<div class="sidebar-block-header">Approved Lotteries</div>
	<?php
	if ( has_nav_menu( 'sidebar-approved-lotteries-menu' ) ) {
      wp_nav_menu( array( 'theme_location' => 'sidebar-approved-lotteries-menu') ); 
	}
	?>

	</div>

<!--
	<div class="sidebar-block sidebar-block-bg">
	<div class="sidebar-block-header">Weekly Poll</div> -->
	<?php /* if (function_exists('vote_poll') && !in_pollarchive()):  */?>
    <?php /* get_poll(2); */?>
	<?php /* endif; */ ?>
<!--	</div> -->

	<div class="sidebar-block">
		<div class="textwidget">
        <div class="sidebar-block-header">Most read/commented posts</div>
		<div class="approved_mid">
		
		<section id="most-popular">
 <ul class="module-tabs">
     <li><a class="recent-comm active" onclick="jQuery(this).addClass('active');jQuery('#recent-comm').addClass('active');jQuery('.most-comment, #most-comments, .most-read, #most-read').removeClass('active');return false;" href="#" >Recent comments</a></li>
     <li><a class="most-comment" onclick="jQuery(this).addClass('active');jQuery('#most-comments').addClass('active');jQuery('.most-read, #most-read, .recent-comm, #recent-comm').removeClass('active');return false;" href="#">Most commented</a></li>
     <li><a class="most-read" onclick="jQuery(this).addClass('active');jQuery('#most-read').addClass('active');jQuery('.most-comment, #most-comments, .recent-comm, #recent-comm').removeClass('active');return false;" href="#" >Most Read</a></li>

 </ul>

<div class="module-block" id="most-comments"><h2>Most Comments</h2><ul>

<?php
if (is_front_page()) { $x = 3; } else { $x = 5;}

$mostcomm = new WP_Query('orderby=comment_count');
for ($c = 0; $c < $x; $c++) {
$permalink = get_permalink( $mostcomm->posts[$c]->ID ); ?>
<li><span class="comment-count"><a href="<?=$permalink;?>" title="<?=$mostcomm->posts[$c]->comment_count;?> comments"><?=$mostcomm->posts[$c]->comment_count;?></a></span><a href="<?=$permalink;?>"><?=$mostcomm->posts[$c]->post_title;?></a></li>
<?php } ?>

</ul></div>


<div class="module-block" id="most-read">
  <h2>Most Read</h2>
<?php
$mostread = new WP_Query( array( 'posts_per_page' => $x, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC'  ) );
for ($r = 0; $r < $x; $r++) {
$permalink = get_permalink( $mostread->posts[$r]->ID ); ?>
<ul><li><a href="<?=$permalink;?>"><?=$mostread->posts[$r]->post_title;?></a></li></ul>
<?php } ?>
 </div>
 
 <div class="module-block active" id="recent-comm">
 <?php 
        if (is_front_page()) $show_comments=3; else $show_comments=6;
        if(function_exists('jme_display_comments')) { jme_display_comments( array( 1 => $show_comments, 2 => 10,
            3 => '%AVATAR%<div class="recentcomment_content"><h3 style="line-height:90%; color: #222222;">%AUTHORLINK%:</h3> <div class="comment-text">%COMMENT%</div> Posted at <a href="%PERMALINK%">%POSTTITLE%</a> on %CDATE%</div>', 6 => 'F d'));} ?>
 </div>
 
</section>
		
		</div>
		</div>
	</div>
        <div class="sidebar-block sidebar-block-bg">

	        <?
	        /*
	        ?>
            <div class="sidebar-block-header">Lotteries Exposed</div>
            <?php
            if ( has_nav_menu( 'sidebar-menu' ) ) {
                wp_nav_menu( array( 'theme_location' => 'sidebar-menu') );
            }
            ?>
            <button class="reportBtn">Submit for Review</button>
			*/
	        ?>

            <div class="transBg"> <div class="report"> <?php echo do_shortcode('[contact-form-7 id="6473" title="Report News"]'); ?></div>

                <script type="text/javascript">
                    jQuery(document).ready(function(){
                        $('.reportBtn').click(function(){
                            $('.transBg').show();
                        });
                        $('.close').click(function(){
                            $('.transBg').hide();
                        });
                        $('.resetBtn').click(function(e){
                            e.preventDefault();
                            $('.wpcf7-form').trigger("reset");
                        });
                    });
                </script>
            </div><br/>
	        <?php dynamic_sidebar('right-sidebar'); ?>
    <!--<div class="sidebar-block sidebar-block-bg">
		<div class="sidebar-block-header">Recent comments</div>
		<?php /*
        if (is_front_page()) $show_comments=3; else $show_comments=6;
        if(function_exists('jme_display_comments')) { jme_display_comments( array( 1 => $show_comments, 2 => 10,
            3 => '%AVATAR%<div class="recentcomment_content"><h3 style="line-height:90%; color: #1E4A84;">%AUTHORLINK% on <a href="%PERMALINK%">%POSTTITLE%</a></h3><span style="color: #1E4A84;">%COMMENT%</span><div class="comment-meta" style="color: #1E4A84;">Posted %CDATE%</div></div>'));} */?>
	</div>-->
	
	<!--<div class="sidebar-block sidebar-block-bg">
		<div class="sidebar-block-header">Recent posts</div>
		<ul class="customized-recent-comments">-->
	<?php /*
		$recent_posts = get_posts(array('posts_per_page' => 3));
		foreach( $recent_posts as $p){
			echo '<li class="recentcomment">';
			echo get_avatar( $p->author, '40');
			echo '<div class="recentcomment_content">';
			echo '<h3 style="line-height:90%; color: #1E4A84;">'; the_author($p->ID);
			echo '<br><a href="' . get_permalink($p->ID) . '" title="Look '.esc_attr($p->post_title).'" >'.$p->post_title.'</a></h3>
			<span style="color: #1E4A84;">';
			echo '</span><div class="comment-meta" style="color: #1E4A84;">Posted ';
			echo date('D m, Y',strtotime($p->post_date));
			echo '</div></div>
			</li> ';
		}
		*/
	?>
	<!--</ul>
	</div>-->
	
</div><!-- .content_right -->
