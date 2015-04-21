<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to twentyten_comment which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

			<div id="comments">
                <div id="commentbox-top"></div>
                <div id="commentbox-mid">
                    <?php if (have_comments()) { ?>
                        <div id="commenbox-mid-headline"><h3 id="comments-title"><?php
                            echo get_comments_number(); ?> comments
                        </h3></div>
                    <?php } ?>
               <div id="current-author-avatar">
				   <?php global $current_user;
					get_currentuserinfo();
					echo get_avatar( $current_user->ID, 60 ); 
					?>
				</div>
                <?php   $title_reply = '';

                    $comments_args = array(
                    'label_submit'=>'',
                    'title_reply'=> $title_reply,
                    );

                    comment_form($comments_args);
                ?>
<?php if ( post_password_required() ) : ?>
				<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'twentyten' ); ?></p>
			</div><!-- #comments -->
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if ( have_comments() ) : ?>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'twentyten' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>
			</div> <!-- .navigation -->
<?php endif; // check for comment navigation ?>
			<script type="text/javascript">
jQuery(function($){
    window.comments_per_page=5;
    var n=$("#comments_wrapper li").size();
    var pages=Math.ceil(n/window.comments_per_page);
    var text='';
    for (i=0;i<pages;i++) {
        var ii=i+1;
        text=text + '<a href="" onclick="show_comment_page(' + i + ');return false;">' + ii + '</a>';
    }
    jQuery("#comments_wrapper li").hide();
    jQuery("#comments_wrapper li").slice(0,window.comments_per_page).show();
    jQuery("#comment-pagination span").html(text);
    jQuery("#comment-pagination a").eq(0).addClass("current-comment-page");
});
function show_comment_page(n) {
    jQuery("#comments_wrapper li").hide();
    var start=n*window.comments_per_page;
    var end=start + window.comments_per_page;
    jQuery("#comments_wrapper li").slice(start,end).show();
    jQuery("#comment-pagination a").removeClass("current-comment-page");
    jQuery("#comment-pagination a").eq(n).addClass("current-comment-page");
}
</script>

			<ol class="commentlist" id="comments_wrapper">
				<?php
					/* Loop through and list the comments. Tell wp_list_comments()
					 * to use twentyten_comment() to format the comments.
					 * If you want to overload this in a child theme then you can
					 * define twentyten_comment() and that will be used instead.
					 * See twentyten_comment() in twentyten/functions.php for more.
					 */
					wp_list_comments( array( 'callback' => 'twentyten_comment' ) );
				?>
			</ol>
<div id="comment-pagination">Pages: <span></span></div>
<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'twentyten' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>
			</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	if ( ! comments_open() ) :
?>
	<p class="nocomments"><?php _e( 'Comments are closed.', 'twentyten' ); ?></p>
<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

<?php
/*
$assigned_to = intval( get_post_meta( $post->ID, '_lottery_reviews_assign', true ) );
if ($assigned_to != 0) {
$title_reply = 'Have Your Say'; 
} else {
$title_reply = 'Leave a reply'; 
}
*/
?>
            </div><!-- #commentbox-mid -->
<div id="commentbox-bottom"></div>
</div><!-- #comments -->
