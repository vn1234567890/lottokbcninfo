<?php

/**

 * The Header for our theme.

 *

 * Displays all of the <head> section and everything up till <div id="main">

 *

 * @package WordPress

 * @subpackage LottoExposed

 * @since LottoExposed 1.0

 */

//nocache_headers(); //disable CF cache for dynamic content
//header('Expires: ' . gmdate('D, d M Y H:i:s', time()+10) . ' GMT');

require_once 'Mobile_Detect.php';

$detect = new Mobile_Detect;
$layout = $_COOKIE["name"];

if ($_COOKIE["ismobile"] == "yes") {
    if ($_COOKIE["name"] == "desktop") {
//		setcookie ("name", "", time() - 3600);
    }
}
?>
<!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>">

<title>Lotto Exposed</title>

<link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/stylesheet.css?t=<?php echo time(); ?>">
<?php

$detect->version('iPhone');
  if($detect->version('iPhone') && $layout != "desktop" ){ ?>
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<?php } ?>
<?php
if($detect->version('Android')){ ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<?php } ?>

<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/webfontkit-20120821-045252/stylesheet.css?t=<?php echo time(); ?>">

<link rel="icon" href="<?php bloginfo( 'template_url' ); ?>/images/favicon.ico">

<link rel="apple-touch-icon" sizes="57x57" href="apple-icon-57x57-precomposed.png" />
   
<?php

	/* We add some JavaScript to pages with the comment form

	 * to support sites with threaded comments (when in use).

	 */

	if ( is_singular() && get_option( 'thread_comments' ) )

		wp_enqueue_script( 'comment-reply' );



	/* Always have wp_head() just before the closing </head>

	 * tag of your theme, or you will break many plugins, which

	 * generally use this hook to add elements to <head> such

	 * as styles, scripts, and meta tags.

	 */

	wp_head();

	$home_url = get_site_url();

?>

<script>

var flipcounter_image = '<?php echo get_stylesheet_directory_uri().'/graph/img/flipCounter-medium.png'; ?>';

function si_captcha_refresh(e,t,n,r){var i="0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";var s=16;var o="";for(var u=0;u<s;u++){var a=Math.floor(Math.random()*i.length);o+=i.substring(a,a+1)}document.getElementById("si_code_"+t).value=o;var f=r+o;if(e=="si_image_side_login"){document.getElementById("si_image_side_login").src=f}else{document.getElementById("si_image_"+t).src=f}}

</script>



<script>

function xyz_em_verify_fields()

{

var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

var address = document.subscription.xyz_em_email.value;

if(reg.test(address) == false) {

alert("Please check whether the email is correct.");

return false;

}else{

//document.subscription.submit();

return true;

}

}

</script>


<script type="text/javascript">



    var _gaq = _gaq || [];

    _gaq.push(['_setAccount', 'UA-25309209-3']);
	_gaq.push(['_setAccount', 'UA-53470122-1']);
    _gaq.push(['_trackPageview']);



    (function() {

        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;

        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';

        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);

    })();



</script>

<?php

if($detect->version('iPhone') && $layout != "desktop"){ ?>

    <script type="text/javascript">

        jQuery(document).ready(function($) {



            $("iframe").each(

                function(index, elem) {

                    elem.setAttribute("width","320");

                }

            );





        });

    </script>





<?php } ?>

</head>

<body <?php body_class(); ?>>
<div id="top_header_email_test"><div style="font-size: 20px; color: #fff; height: 48px; text-align: center; background-image: url(http://www.lottoexposed.com/wp-content/uploads/custom/topbg.png)"><form action="http://www.lottoexposed.com/newsletter/sub.php" method="POST" accept-charset="utf-8" name="signup-form" id="signup-form"><p style="padding-top:10px;"><label for="email" style="margin-right: 10px;">Get The Limited Edition of Our Lotto Tickets Price Comparison !</label><input type="hidden" name="list_id" value="m6bFK11ZFCV7swoXNQ5ZBw"><input type="text" name="email" placeholder="example@email.com" style="height: 30px; padding-left: 10px; margin-right: 10px;"/><input type="submit" value="Teach me" style="background: #f2b130; background-image: -webkit-linear-gradient(top, #f2b130, #f88f1f); background-image: -moz-linear-gradient(top, #f2b130, #f88f1f); background-image: -ms-linear-gradient(top, #f2b130, #f88f1f); background-image: -o-linear-gradient(top, #f2b130, #f88f1f); background-image: linear-gradient(to bottom, #f2b130, #f88f1f); border: none; font-family: Arial; color: #ffffff; font-size: 17px; padding: 5px 15px 5px 15px; text-decoration: none;"/></p></form></div></div>

<div class="header_top_mid"></div>

<div class="container">

<!-- Place this tag where you want the +1 button to render.-->

    <div class="g1">

<div class="g-plusone" data-annotation="inline" data-width="300"></div>

</div>

<!-- Place this tag after the last +1 button tag. -->

<script type="text/javascript">

  (function() {

    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;

    po.src = 'https://apis.google.com/js/plusone.js';

    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);

  })();

</script>







    <script type="text/javascript">

        jQuery(document).ready(function($) {



            $("#mmenu").hide();



            $(".menu_mobi").click(function() {

                $("#mmenu").slideToggle(500);



            });





        });

    </script>

<div class="clear"></div>



  <div class="header_in">







    <div id="logo"><a href="/"><img src="<?php bloginfo( 'template_url' ); ?>/images/logo.png"  alt="LottoExposed.com" width="400" height="133" /></a></div>

	<div id="access" role="navigation" class="navigation">

		<?php wp_nav_menu( array( 'menu'=>'mainmenu','container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>

		<ul style="display:none;">

		<li><a href="#">HOME PAGE</a></li>

		<li><a href="#">MULTI GROUP</a></li>

		<li><a href="#">WEBSITES</a></li>

		<li><a href="#">ABOUT</a></li>

		<li><a href="#">SIGN UP</a></li>

		</ul>

        <div id="sidebar-search">
			
			<form action="http://www.lottoexposed.com" class="searchform" id="searchform" method="get" role="search">
				<div>
					<span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input type="text" id="s" name="s" value="" placeholder="Search Lotto Exposed" class="ui-autocomplete-input" autocomplete="off">
					<input type="submit" value="" class="ui-autocomplete-input" id="searchsubmit">
				</div>
			</form>

        </div>

	</div><!-- } .navigation -->



      <?php if (( $detect->version('iPhone') && $layout != "desktop")||( $detect->version('Android') && $layout != "desktop" )||( $detect->version('iPad') && $layout != "desktop" )){ ?>



          <div class="nav_fixed_mobi">

              <div class="menu_mobi">

                  <ul id="mmenu">
                      <li ><a title="Welcome" href="<?php echo site_url(); ?>">Home</a></li>
                      <li ><a title="Recommended Lottery Agents" href="<?php echo site_url(); ?>/recommended-approved-lottery-ticket-sellers/">Reliable Lotto Agents!</a></li>
                      <li ><a title="The Best Lottery Tools To Boost Your Winning Chances" href="<?php echo site_url(); ?>/lottery-tools/">Tools</a></li>
                      <li ><a title="The Best Online Lottery Ticket Seller Promotions" href="<?php echo site_url(); ?>/lottery-promotions/">Lottery Promotions</a></li>
                      <li ><a title="Lotto Exposed Forums – Fighting Scams with Your Complaints" href="<?php echo site_url(); ?>/forums/">Forums</a></li>
                  </ul>

              </div>

              <div id="sidebar-search_mobi">



                  <form action="/" method="get">

                      <input type="text" name="s" value="" placeholder="Search Lotto Exposed">

                      <input type="submit" value="" style="width:56px;height:36px;border:none;background:url('<?php bloginfo('template_url'); ?>/images/search-button.png') 0 0 no-repeat;float: left;margin: 0; cursor: pointer;">

                  </form>

              </div>

          </div>



          <div id="logo_mobi"><a href="/"><img src="<?php bloginfo( 'template_url' ); ?>/images/logo.png"  alt="LottoExposed.com" width="320" /></a></div>



          <script type="text/javascript">

          $( document ).ready(function() {

          $("div.g1").addClass("g1-mobile");

          });

          </script>

      <?php }  ?>







      <?php if (is_front_page()) { ?><div id="about-us"><?php dynamic_sidebar('sidebar-text'); ?></div>

          <?php  if($detect->version('iPhone') && $layout != "desktop"){  ?>

              <div class="sidebar-block-mobi">

              <div class="textwidget">

                  <div class="sidebar-block-header arrow-down">Lottery jackpots</div>

                  <div class="approved_mid">
                      <iframe src="http://www.lottoexposed.com/jackpots.php" width="320" height="306" frameborder="0" scrolling="no" style="float:left; display:block;"></iframe>
                  </div>

              </div>

          </div>

       <?php    }  elseif($detect->version('Android') && $layout != "desktop") {  ?>

              <div class="sidebar-block-mobi">
                  <div class="textwidget">
                      <div class="sidebar-block-header arrow-down">Lottery jackpots</div>
                      <div class="approved_mid">
                          <script type="text/javascript">
                              jQuery(document).ready(function($) {



                                  $(".sidebar-jackpot").addClass("android");



                              });

                          </script>

                          <iframe src="http://www.lottoexposed.com/jackpots.php" width="320" height="306" frameborder="0" scrolling="no" style="float:left; display:block;"></iframe>



                      </div>

                  </div>

              </div>

          <?php    }  ?>

	<?php } ?>

  </div>

