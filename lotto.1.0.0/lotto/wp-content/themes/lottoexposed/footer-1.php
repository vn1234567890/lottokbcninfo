</div>



<style>



    .cuckButtons:active {

        top: -1px;

        outline: none;

        -webkit-box-shadow: 1px 1px 1px #000 inset;
	box-shadow: 1px 1px 1px #000 inset;
	background-color: #379482;
	text-shadow: -1px -1px 1px #333;

    }

 .activeCuckButtons{
        top: -1px;

        outline: none;

        -webkit-box-shadow: 1px 1px 1px #000 inset !important;
        box-shadow: 1px 1px 1px #000 inset !important;
        background-color: #379482 !important;
        text-shadow: -1px -1px 1px #333 !important;
    }






    .footer_container>div{

        height:auto;

    }

    .footButtons{

        width: 100%;

        text-align: center;



    }

    .cuckButtons{

        clear:both;

        width: 100px;

        margin: 0 auto;

        position: relative;

        vertical-align: top;



        height: 30px;

        padding: 0;

        font-size: 18px;

        color: white;

        text-align: center;

        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.25);

        background: #16a085;

        border: 0;

        border-bottom: 2px solid #14947b;

        cursor: pointer;

        -webkit-box-shadow: inset 0 -2px #14947b;

        box-shadow: inset 0 -2px #14947b;

    }

    div.footer5{

        top:auto;

    }

</style>



<?php if (is_front_page()) : ?>

    <div class="approved_lotteries_wrapper">

       <div class="jackpots_box">

		<div class="jackpots_box_header">Reliable Lottery Agents</div>

		<?php

		$slides = get_posts(array('meta_query' => array( array( 'key' => 'lottery_sites_approved_pos', 'value' => 0, 'compare' => '>', 'type' => 'numeric')), 'post_type' => 'lottery_sites', 'meta_key' => 'lottery_sites_approved_pos','orderby' => 'meta_value_num', 'order' => 'ASC', 'numberposts' => 3));

		$home_url = get_site_url();

		

		$i=1;

		foreach ($slides as $s):

		

		$post_id = $s->ID;

		$lottery_pos = get_post_meta( $post_id, 'lottery_sites_approved_pos', true );

		$lottery_logo = wp_get_attachment_url( get_post_thumbnail_id($post_id) );

		$lottery_review = get_post_meta( $post_id, 'lottery_sites_revurl', true );

		$lottery_name = get_post_meta( $post_id, 'lottery_sites_sitename', true );

		$lottery_alexa = get_post_meta( $post_id, 'lottery_sites_alexa', true );

		$lottery_aff = get_post_meta( $post_id, 'lottery_sites_afflink', true );

		?>

			<div class="sidebar-jackpot">

			<div><a href="<?php echo $lottery_review; ?>"><img border="0" src="<?php echo $lottery_logo; ?>"></a></div>

			<a class="lottery_link" href="<?php echo $lottery_review; ?>"><?php echo $lottery_name; ?></a>

			<div>Alexa : <?php echo number_format($lottery_alexa); ?></div>

			<a rel="nofollow" class="playnow2" target="_blank" href="<?php echo $lottery_aff; ?>">Visit Now!</a>

			</div>

		<?php $i++; endforeach; ?>

		</div>

		

		<div class="newsletter_box_wraper">

		

		<div class="sidebar-block">

		<div class="sidebar-block subscribe-newsletter overflow_hidden">

		<div class="sidebar-block-header">Subscribe newsletter</div>

            <form action="http://www.lottoexposed.com/index.php?wp_nlm=subscription" name="subscription" method="post" onsubmit="javascript: if(!xyz_em_verify_fields()) return false;">

                <input type="hidden" value="LottoExposed" name="uri"/>

                <input type="hidden" name="loc" value="en_US"/>

                <div class="text_box"><input name="xyz_em_email" type="text" value="" placeholder="name@domain.com" class="box"/></div>

                <p>I want to receive news by email &nbsp; </p>

                <button>subscribe now</button>

            </form>

		</div>

            

         </div>



		</div>



		</div>

    </div>



<?php endif; ?>

</div><!-- . containter -->

<div class="footer_bg" style="clear: both;">
 


    <?php $ismobile = $_COOKIE["ismobile"]; if($ismobile != "yes"):  ?>
    <div class="footer_container" >

        <div class="footer1">
            <?php dynamic_sidebar('footer-first-column'); ?>
        </div>
        <div class="footer2">
            <?php dynamic_sidebar('footer-second-column'); ?>
        </div>
        <div class="footer3">
            <?php dynamic_sidebar('footer-third-column'); ?>
        </div>
        <div class="footer4">
            <?php dynamic_sidebar('footer-fourth-column'); ?>
        </div>

        <div class="clear"></div>
    </div>
    <?php else :  ?>




        <div class="footer_container">

            <div class="footer4">
                <li id="text-8" class="widget widget_text"><p style="text-align: center;">About</p>
                    <div class="textwidget">
                        <ul>
                            <li style=" width: 80px;float: left;"><a style="margin-left:4px;"  title="About Us" href="http://www.lottoexposed.com/about-us/">Our Story</a></li>
                            <li style=" margin-left: 100px;" ><a style="margin-left:10px;" title="Our team" href="http://www.lottoexposed.com/lottoexposed-coms-team/">Our Team</a></li>
                        </ul>

                    </div>
                </li>

        </div>

</div>
    <?php endif; ?>
    <div class="footer5">
        <?php dynamic_sidebar('footer-fifth-column'); ?>
    </div>


     <?php



    require_once 'Mobile_Detect.php';



    $detect = new Mobile_Detect;



    if($detect->version('iPhone') || $detect->version('iPad') || $detect->version('Android') ){ ?>

        <div class="footButtons" >

            <button class="cuckButtons" id="mobile" value = "mobile" >Mobile</button>

            <button class="cuckButtons" id="desktop" value = "desktop">Desktop</button>

        </div>



    <?php } ?>





    <?php wp_footer(); ?>



</div>



<script>
 var monitor_height;
    monitor_height = screen.height;
    if(monitor_height < 600)
    {
        var ismobile = "yes";
        setCookieforheight(ismobile);
	window.location.refresh();
    } 



var cookie_name = getCookie('name');
   if(cookie_name == 'mobile'){
       $('#mobile').addClass('activeCuckButtons');
   }else if(cookie_name == 'desktop'){
       $('#desktop').addClass('activeCuckButtons');
   }


    $('button.cuckButtons').click(function()

    {

        var value = $(this).val();

       setCookie(value);

        location.reload();

    });



    /*setting the cookies*/

    function setCookie(value)

    {

        var d = new Date();

        d.setTime(d.getTime() + (24*60*60*1000)); /* cookies are saving one day*/

        var expires = "expires=" + d.toGMTString();

        document.cookie = "name="+ value+"; "+expires;



    }

function setCookieforheight(value)
    {
        var d = new Date();
        d.setTime(d.getTime() + (24*60*60*1000)); /* cookies are saving one day*/
        var expires = "expires=" + d.toGMTString();
        document.cookie = "ismobile="+ value+"; "+expires;

    }



    /* getting cookies by names */

    function getCookie(name)

    {

        var matches = document.cookie.match(new RegExp(

        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"

    ));

        return matches ? decodeURIComponent(matches[1]) : undefined;

    }



    /* deleting cookies by name */

    function deleteCookie(name)

    {

        setCookie(name, "", { expires: -1 })

    }

</script>

</body>

</html>

