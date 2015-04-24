<?php
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;
?>

<?php
date_default_timezone_set('UTC');
$btntext = 'Play Now';
$feed_url = "http://feeds.lottoelite.com/rss.php?lang=en&account=offpista&site=2&type=3"; 
$content = file_get_contents($feed_url);  
$x = new SimpleXmlElement($content);  

$lottos = array(
    2 => array("name" => "Mega Millions", "currency" => "USD", "nextday" => true, "GMT" => "04:00:00"),
    3 => array("name" => "Powerball", "currency" => "USD", "nextday" => true, "GMT" => "04:00:00"),
    4 => array("name" => "California SuperLotto", "currency" => "USD", "nextday" => true, "GMT" => "00:45:00"),
    5 => array("name" => "New York Lotto", "currency" => "USD", "nextday" => true, "GMT" => "04:21:00"),
    6 => array("name" => "Florida Lotto", "currency" => "USD", "nextday" => true, "GMT" => "04:15:00"),
    8 => array("name" => "EuroMillions", "currency" => "EUR", "nextday" => false, "GMT" => "21:00:00"),
    9 => array("name" => "Lotto 6/49", "currency" => "CAD", "nextday" => true, "GMT" => "02:10:00"),
    11 => array("name" => "Mega-Sena", "currency" => "BRL", "nextday" => false, "GMT" => "22:00:00"),
    12 => array("name" => "El Gordo", "currency" => "EUR", "nextday" => false, "GMT" => "12:00:00"),
    14 => array("name" => "Powerball Australia", "currency" => "AUD", "nextday" => false, "GMT" => "09:30:00"),
    15 => array("name" => "German Lotto", "currency" => "EUR", "nextday" => false, "GMT" => "17:50:00"),
    16 => array("name" => "UK National Lottery", "currency" => "GBP", "nextday" => false, "GMT" => "21:30:00"),
    17 => array("name" => "French Loto", "currency" => "EUR", "nextday" => false, "GMT" => "19:00:00"),
    18 => array("name" => "SuperEnalotto", "currency" => "EUR", "nextday" => false, "GMT" => "19:00:00"),
    19 => array("name" => "La Primitiva", "currency" => "EUR", "nextday" => false, "GMT" => "20:30:00"),
    20 => array("name" => "Hot Lotto", "currency" => "USD", "nextday" => true, "GMT" => "04:00:00"),
    21 => array("name" => "Irish Lotto", "currency" => "EUR", "nextday" => false, "GMT" => "20:00:00"),
    22 => array("name" => "Hoosier Lotto", "currency" => "USD", "nextday" => true, "GMT" => "03:50:00"),
    23 => array("name" => "UK Thunderball", "currency" => "GBP", "nextday" => false, "GMT" => "19:30:00"),
    24 => array("name" => "EuroJackpot", "currency" => "EUR", "nextday" => false, "GMT" => "20:00:00"),
    25 => array("name" => "EuroMillions UK", "currency" => "GBP", "nextday" => false, "GMT" => "21:00:00")
);

$i = 1;
$lottodata = array();
foreach($x->channel->item as $entry) {
	  
if ($i <4) {

$url = (string) $entry->link;
$query = parse_url($url, PHP_URL_QUERY);
$vars = array();
parse_str($query, $vars);
$lot_id = $vars['lot_id'];

$desc = $entry->description ;

str_replace("&nbsp;", "", $desc);

$ex1 = explode ("Draw date:", $desc ); 

$ex2 = explode ("Jackpot:", $ex1[1] ); 

$ex3 = explode ("<br /><a", $ex2[1] );


$title = (string) $entry->title ; 
$enddate = $ex2[0] ; 
$amount = trim($ex3[0]);

$exdate = explode ("<br />",$enddate); 
$enddate = $exdate[0] ; 

$newstr = $title . $enddate.$amount  ; 

$explodedate = explode ("-",$enddate); 
$year = trim($explodedate[0]);
$month = trim($explodedate[1]);
$day = trim($explodedate[2]);

if ($lottos[$lot_id]['nextday']) {
	$drawdate = date('m/d/Y H:i:s', strtotime($year.'-'.$month.'-'.$day.' '.$lottos[$lot_id]['GMT'] . ' + 1 day'));
} else {
	$drawdate = date('m/d/Y H:i:s', strtotime($year.'-'.$month.'-'.$day.' '.$lottos[$lot_id]['GMT']));
}

if ($lot_id == 2) {
$afflink = 'http://www.lottoexposed.com/usamega1';
} else if ($lot_id == 3) {
$afflink = 'http://www.lottoexposed.com/uspowerball1';
} else if ($lot_id == 4) {
$afflink = 'http://www.lottoexposed.com/superlotto1';
} else if ($lot_id == 5) {
$afflink = 'http://www.lottoexposed.com/nylotto1';
} else if ($lot_id == 6) {
$afflink = 'http://www.lottoexposed.com/FloridaLotto1';
} else if ($lot_id == 8) {
$afflink = 'http://www.lottoexposed.com/euromillion1';
} else if ($lot_id == 9) {
$afflink = 'http://www.lottoexposed.com/lotto6491';
} else if ($lot_id == 11) {
$afflink = 'http://www.lottoexposed.com/megasena1';
} else if ($lot_id == 12) {
$afflink = 'http://www.lottoexposed.com/elgordo1';
} else if ($lot_id == 13) {
$afflink = 'http://www.lottoexposed.com/OzLotteries1';
} else if ($lot_id == 14) {
$afflink = 'http://www.lottoexposed.com/OzPowerball1';
} else if ($lot_id == 16) {
$afflink = 'http://www.lottoexposed.com/uklottery1';
} else if ($lot_id == 17) {
$afflink = 'http://www.lottoexposed.com/francelotto1';
} else if ($lot_id == 18) {
$afflink = 'http://www.lottoexposed.com/superenalotto1';
} else if ($lot_id == 19) {
$afflink = 'http://www.lottoexposed.com/Primitiva1';
} else if ($lot_id == 20) {
$afflink = 'http://www.lottoexposed.com/hotlotto1';
} else if ($lot_id == 21) {
$afflink = 'http://www.lottoexposed.com/irishlotto1';
} else if ($lot_id == 22) {
$afflink = 'http://www.lottoexposed.com/indiana1';
} else if ($lot_id == 23) {
$afflink = 'http://www.lottoexposed.com/Thunderball1';
} else if ($lot_id == 24) {
$afflink = 'http://www.lottoexposed.com/eurojackpot1';
} else if ($lot_id == 25) {
$afflink = 'http://www.lottoexposed.com/euromillionUK';
} else {
$afflink = 'http://www.lottoexposed.com/PlayHugeLottos1';
}

$lottologo = 'http://feeds.lottoelite.com/iframe/logos/'.$lot_id.'.png';
$jpdate = $drawdate." UTC";

$lottodata[$i]['afflink'] = $afflink;
$lottodata[$i]['logo'] = $lottologo;
$lottodata[$i]['title'] = $title;
$lottodata[$i]['amount'] = $amount;
$lottodata[$i]['jpdate'] = $jpdate;

$i++; }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<style type="text/css">
body {
font-family:"Trebuchet MS", Verdana;
}
.clear { /* generic container (i.e. div) for floating buttons */
    overflow: hidden;
    width: 100%;
}

.logos {
float: left;
margin-top: 8px;
width: 152px;
}

a.playbutton {
    background: #231f20;
    display: block;
    height: 24px;
    width:83px;
    text-align: center;
    margin:0 auto;
    color:#fff;
    font-size:12px;
    font-family:Arial, sans-serif;
    font-weight: bold;
    text-decoration: none;
    line-height: 23px;
	float: right;
}
.jackpots_box {
    background:url("/wp-content/themes/lottoexposed/images/jackpots_box.png");
    padding:2px 4px;
    border:1px solid #e0dfdd;
    width:640px;
    box-shadow:0 4px 7px #ccc;
}
.jackpots_box:after {
    content:".";
    display:block;
    height:0;
    line-height: 0;
    clear:both;
}
.jackpots_box_header {
    background: #041563;
    height: 44px;
    color:#fff;
    padding:0 8px;
    line-height: 43px;
    text-transform: uppercase;
    margin:0 0 24px;
    font-size:20px;
    position: relative;
}
.jackposts_bag {
    width:89px;
    height:68px;
    background:url("/wp-content/themes/lottoexposed/images/money_bag_icon.png") right top no-repeat;
    position: absolute;
    right: -2px;
    top: -12px;
}
.sidebar-jackpot {
    width:270px;
    text-align: left;
    height:85px;
    margin: 0 auto;
}
.android {
    display: inline-block!important;
    width: 278px!important;
    height: auto;
    margin: 0 auto;
}
.android_logos {
    float: left;
    margin-top: 8px;
    width: 118px;
}
.jackpots_box .sidebar-jackpot:first-child {
    background: none !important;
}
a.lottery_link {
    color: #2f2f2f;
    font-size: 18px;
    text-transform: uppercase;
    font-family: "PT Sans";
    font-weight: 400;
    text-decoration: none;
}

a.lottery_link:hover {
    text-decoration: underline;
}
.lottery_amount {
    color:#0f4a8c;
    font-size:23px;
    font-weight:bold;
}
.countdownTimer {
    color:#303030;
    font-size: 18px;
    font-weight: normal;
    font-family: 'PT Sans', sans-serif;
	float: right;
	margin-right: 5px;
}

.countdownContainer {
float: left;
width: 100%;
}

.countdownTitle {
    color: #fd641b !important;
    float: left;
    position:absolute;
    border-bottom:3px double #F0F0F0;
    font-size: 23px;
    text-align: left;
    width: 275px;
    margin-top: -4px;
}

#timers1, #timers2, #timers3 {
line-height: 34px;
} 

.playnow2 {
padding:3px 14px;
background: #006400;
text-transform: uppercase;
text-align: center;
color:#fff;
text-decoration: none;
line-height: 23px;
font-size:10px;
float: right;
}

.playRegular {float: right; line-height: 23px;}
.play_btn_right{ float:left;margin-left:450px}

.playRegular { cursor:pointer}
.playRegular span,.playRegular a { color:#FFFFFF;font-weight:bold;display:block;text-align:center;text-decoration:none;font-family:Tahoma,Geneva,Sans-Serif;font-size:12px;padding:0 6px}

.playRegular span{ font-size:15px;padding-top:12px;font-family:Tahoma,Geneva,Sans-Serif}
.playRegular a{
    font-family: "oswald";
    font-size: 18px;
    font-weight: normal;
    letter-spacing: 1px;}
.playRegularStart_int,.playRegularEnd_int,.playRegular_int{ background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAEvCAIAAAAYcXzYAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RkM3QzhGNTdBQUIxMTFFM0ExRkI4MTVGMDk0ODA0QTMiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RkM3QzhGNThBQUIxMTFFM0ExRkI4MTVGMDk0ODA0QTMiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpGQzdDOEY1NUFBQjExMUUzQTFGQjgxNUYwOTQ4MDRBMyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpGQzdDOEY1NkFBQjExMUUzQTFGQjgxNUYwOTQ4MDRBMyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Pl2KghEAAAQjSURBVHja1Ji/b9NAFMfvHNuUJpUatQMTEgwVlWBhQB26UESFxMKAxFYkfixMiP+Dka0TjPwHlSgSRYIuDEi0EoxVWFoBahJC4pwfzznH9a/3enaTKj1lcPz1e/fe3flzzycBQBDNjq70QzBsRxr+8QdNKaUv8I4dCXjX87xer9cftFDDhhoKnVYTNl/bPz673b+hT3wEjdDCf/+m1njrXtyXFYX3rcgn+nG+f3Ln9qWlBIYCSc3qtrVFIocw7sHjOfkN0zy6tFK5549L1s5OK1DGjo0TZG6c3PwdGycXCxQfs2NjAdPcjX0CGwuYjotFm7E5cHGajwuAKDu3McOy88DlXiA/yNeklAXWpxUZZe0sLViWZds2uFVQVrhqIKl5i8vdw3ok21qrVCqu66rVxy0B3d2PstsO7mtCkMzSPiMHEetkhIcsIyXDVrM5Gh93/Y11Z/ejM8g9wV21sV7d23YuX8A0M9zd2XLm68GE+D7+7LhWQe7iRPkql7sgfUW/t36fyB1/pB0aqj69riktmDO/T8dC+sQOlVc8FkxCMrGQ+QnepyjjEyVJ98fYCc4nBKuBHJfYK5C1K7E/ALM3ArNXAcs6en8AZj8CUc4u1d94feLrChx7cnPX3M3ZUyO2iqma8mU+d53rtw88O5IT3J29//yPgF9fNkSnNWHcZZmMIZFap9MhtWazSdaR1VePSLvalW/0/gAlaw0Qk+KztCbPRpyTNA+TZDeeWARMSg6nn3vJtXv48xKlyUajQTJrZmaGtEN+k1rZWvjE3M2mIX+/WCbtpq8u0OMZK3SymqKZxWjx4reIz3gBWESTfr+kT69cf5zP0rH0xzAPZTVmTXBna/6Z36vOyv4wjv5Ka7v/po7nbpZZp81dAybLYYsf7gRM1jU7NizY9YWWAybjlT1o+CngOE7Q00AOa2Fwp72FJbWyJmozUekf1sKgKr3GXmvL7d16WBm04An9iSEt5c7tOzsfMDT9gZD8Bqooq9uOa8k5AhF9PBRcZ5D4vjVeE1BuLQFXC8PprmuAMXACTHM39gnmZ5XmOYBxDqNhDxSY25HUwmCa+8nPhbOnw0XWUvyA+MgOfAvcKlLmiD1aQ6HbrHvXbjpxTdfCcK7qLS5bK2uIJg2XkMkpZmmqBTeRyRTrQibnMvKEtfBouTv98kGUu1p9kuCuroVBKW9vu73p9u48jXF3cASMV8583fn6LsnWYb0UdJ/ibqIGix3apOtB4GqwmFG6HgTgakUga+H0fpvwydXCnB3QtXDmnC8Ri0XnAC4Tp0OOWTo/mdCEZMaa9ilAUrVwZjxj/zNz5AvGzozXwDCZ8wks64z7489wDe0KnQuPxGeCu+a5U9xVuB6manHuhvWZ8uWBZzs37iaYHNbC52vu0ursvWeTyt3/AgwAuEHkXjJpDWoAAAAASUVORK5CYII=); background-repeat:repeat-y;float:left;height:30px}
.playRegular:hover .playRegularStart_int{ background-position:0px 253px}
.playRegularStart_int{ background-position:0px 303px;width:9px;height:50px;}
.playRegular:hover .playRegularEnd_int{ background-position:0px 51px}
.playRegularEnd_int{ background-position:0px 101px;width:9px;height: 50px;}
.playRegular:hover .playRegular_int{ background-position:0px 152px}
.playRegular_int{ cursor:pointer;background-position:0px 202px;background-repeat:repeat;height: 50px;text-align:center}

.PlayButton>input{ margin:1px !important}
.PlayButton>span{ margin:2px !important}
</style>

<script type="text/javascript">
function DateStringToDateObject(e){var t=null;try{t=new Date(e);if(t=="Invalid Date")throw new Error("Invalid Date Format: "+e);return t}catch(n){var r=e.split(" ");var i=r[0].split(/[-\/]/);var s;if(r.length>1)s=r[1].split(":");var o=null;var u=null;var a=null;var f=null;var l=null;var c=null;if(i.length>0){o=parseInt(i[0],10)-1;u=parseInt(i[1],10);a=parseInt(i[2],10)}if(s&&s.length>0){f=parseInt(s[0],10);l=parseInt(s[1],10);c=parseInt(s[2],10)}t=new Date(a,o,u,f,l,c);return t}}function CreateCountdown(e,t,n,r,i){var s="{days} days {hours} hours {minutes} minutes {seconds} seconds";if(i&&typeof i=="string"&&i.length>0)s=i;var o="countdownDiv";if(r&&typeof r=="string"&&r.length>0)o=r;var u=new Date;var a=DateStringToDateObject(t);if(u.getTime()>=a.getTime()){return false}if(n){var f=document.createElement("div");f.id=o;f.className="countdownContainer";f.endDateMilliseconds=a.getTime();f.timerTemplateHtml=s;var l=document.createElement("div");l.id=o+"-title";l.className="countdownTitle";l.innerHTML=e;f.appendChild(l);var c=document.createElement("div");c.id=o+"-timer";c.className="countdownTimer";f.appendChild(c);f.interval=setInterval('UpdateTimer(document.getElementById("'+o+'"));',1e3);n.appendChild(f)}}function UpdateTimer(e){var t=new Date;if(e&&e.endDateMilliseconds-t.getTime()>0){var n=e.id.split("-")[0];var r=document.getElementById(n+"-timer");var i="";var s=e.endDateMilliseconds-t.getTime();var o=1e3;var u=60*o;var a=60*u;var f=24*a;var l=Math.floor(s/f);var c=s%f;var h=l*24;var p=Math.floor(c/a)+h;c=c%a;var d=Math.floor(c/u);c=c%u;var v=Math.floor(c/o);i=e.timerTemplateHtml;i=i.replace("{days}",PadString(new String(l),2,"0"));i=i.replace("{hours}",PadString(new String(p),2,"0"));i=i.replace("{minutes}",PadString(new String(d),2,"0"));i=i.replace("{seconds}",PadString(new String(v),2,"0"));r.innerHTML=i}else{clearInterval(e.interval);e.parentNode.removeChild(e)}}function AddCountdownTester(e,t){var n="ctTester";if(document.getElementById(n))return;var r="-";var i=":";var s=59;var o=new Date;var u=o.getSeconds()+e;if(u>s){o.setMinutes(o.getMinutes()+1);u=0+(u-s)}o.setSeconds(u);var a=MDYHIS_DateString(o);var f=!t?document.body:t;CreateCountdown("... Tester will disappear in ...",a,f,n,"{seconds} seconds")}function MDYHIS_DateString(e){var t=59;var n=59;var r=23;var i="-";var s=":";var o=e;var u=o.getMonth()+1;var a=o.getDate();var f=o.getFullYear();var l=o.getHours();var c=o.getMinutes();var h=o.getSeconds();return u+i+a+i+f+" "+l+s+c+s+h}function PadString(e,t,n){var r=t-e.length;if(r<=0)return e;var i="";for(var s=1;s<=r;s++)i+=n;return i+e}

function timers()
{
<?php
for($i = 1; $i < 4; $i++) {
echo "CreateCountdown('".$lottodata[$i]['amount']."', new Date('".$lottodata[$i]['jpdate']."'), document.getElementById('timers".$i."'), 'timer".$i."', '{hours}:{minutes}:{seconds}');";
}
?>
}
</script>
	
</head>
<body onload="timers();">
<?php for($i = 1; $i < 4; $i++) { ?>

<div class="sidebar-jackpot <?php if($detect->version('Android')){ ?>android<?php } ?>">
<div class="logos <?php if($detect->version('Android')){ ?>android_logos<?php } ?>"><a target="_blank" href="<?php echo $lottodata[$i]['afflink']; ?>"><img src="<?php echo $lottodata[$i]['logo']; ?>" border="0" /></a></div>

<div class="playRegular"><div class="playRegularStart_int"></div><div class="playRegular_int"><span class="playRegular"><a target="_blank" href="<?php echo $lottodata[$i]['afflink']; ?>" class="playRegular" id="PlayLinkButton_60"><?=$btntext;?></a></span></div><div class="playRegularEnd_int"></div></div>

<div id="timers<?php echo $i; ?>"></div>

</div>


<?php } ?>
</body>
</html>