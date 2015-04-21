</div>

<?php

    require_once 'Mobile_Detect.php';
    $detect = new Mobile_Detect;

?>

<div class="footer_bg" style="clear: both;">
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
    <div class="footer5">
        <?php dynamic_sidebar('footer-fifth-column'); ?>
    </div>
</div><!-- End Footer BG -->
    <?php wp_footer(); ?>







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
		
		<?php if( is_super_admin() ){ ?>
		alert(value);
		<?php } ?>

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

