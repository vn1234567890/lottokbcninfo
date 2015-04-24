<?php
$btntext = 'Play Now';
$feed_url = "http://feeds.lottoelite.com/rss.php?lang=en&account=offpista&site=2&type=3"; 
$content = file_get_contents($feed_url);  
$x = new SimpleXmlElement($content);  
    
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
$jpdate = $month."-".$day."-".$year." 23:59:00";

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
<style type="text/css">
body {
font-family:"Trebuchet MS", Verdana;
}
.clear { /* generic container (i.e. div) for floating buttons */
    overflow: hidden;
    width: 100%;
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
    width:260px;
    text-align: center;
    height:95px;
}
.jackpots_box .sidebar-jackpot:first-child {
    background: none !important;
}
a.lottery_link {
    color:#bf2024;
    text-decoration:none;
    font-size:16px;
    text-decoration: none;
    display: block;
    height: 24px;
    margin: 4px 0 0;
	float: left;
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
	margin-right: 9px;
}

.countdownContainer {
float: left;
width: 100%;
}
.playRegular a{
    padding: 0 15px;
}

.countdownTitle {
    color: #43b1cc !important;
    float: left;
    font-family: 'Pacifico' !important;
    font-size: 20px;
    text-align: left;
    width: 117px;
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

.playRegular {float: right; line-height: 17px;}
.play_btn_right{ float:left;margin-left:450px}

.playRegular { cursor:pointer}
.playRegular span,.playRegular a { color:#FFFFFF;font-weight:bold;display:block;text-align:center;text-decoration:none;font-family:"PT Sans";font-size:18px;padding: 0 15px;}

.playRegular span{ font-size:15px;padding-top:5px;font-family:Tahoma,Geneva,Sans-Serif}
.playRegular a{ font-size:15px;font-family:Tahoma,Geneva,Sans-Serif}
.playRegularStart_int,.playRegularEnd_int,.playRegular_int{ /*background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAcAAAC0CAYAAABYDDYIAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYxIDY0LjE0MDk0OSwgMjAxMC8xMi8wNy0xMDo1NzowMSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo1MTQ0MDZFRDg3OTZFMTExODMwMzkzREU1MkVBNEUwMCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo4M0NGOTc0Rjk2QTExMUUxQTY0OUYyQjAwMTRCRkY1NSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo4M0NGOTc0RTk2QTExMUUxQTY0OUYyQjAwMTRCRkY1NSIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1LjEgV2luZG93cyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkRENTZGRDZFOUQ5NkUxMTE4MzAzOTNERTUyRUE0RTAwIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjUxNDQwNkVEODc5NkUxMTE4MzAzOTNERTUyRUE0RTAwIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+8pvrbQAAA5lJREFUeNrcl0tr1FAUx89JMomd1pm2tipiVVCK+EQ3LsSVuhHBR93pN3ClX0C/gSs/gdSFoKAoxYW6EAWp+EDwUajV+qC1nWk708k0uck9npuZ0bGTRA3GV+A/GfLPPTf35PxyEoSmbeqgtZ93R1n9rA6sH9zKuwGrf/Nxa+OmFXq+K4uZjG7UBw107Dtw0sybPVR4CTA5A+R7gDzq8JKtO89lVxjraGa8eRbQJOEha1l7LxXZIPhGBiL04cInC4hg8WZIAh2ceYRWDww+hsGoMDP4lRBjUpwpVVhKNBLTCIu8FEwWNkgCJlmKCimTJaGunxmpLfhyWnrSWVwiStpoBYaFJwu1G/6t9DEb5geW+3vNTCanaZrZHFYftwmWGtC9LSvyiBqqExAxuBad5d2ZkhPXJiTajmjLkzNriurHarX6QeVMKctaz9rB2sDKq4HNCbVYXXWp/5rRZDp1oCIo286U7WDKlnVm0Wym7BhTtirTQ3PPAT4WgWSDsl1M2RZ9HZXfhFC2NttLpTcRlMGkFZr4gDKv0lojP04ZQNICo8QFBsmKOo4y5gRj6xZ+vakIQ/pdc9YoW/BjKCtSIXhgLFKNspy31+xmyswwynSmzHHzqDNnlm7y3mjcJ8VF/8acduhEn77nwEot39dWu3/JKVM4PICIDf0rpynS9M6ujTQNiLS+bxKkEVYmH0mpzJk4LCYPK/EvS8JfVibxOLDOx5k7k4X1752KoezC6nQoizY1gD9AWfL7mbyok1NG6ZiSfv+c8SamUCYpU+awRlg3WZd7rzvyay/zfenPzdju2OtC9enwjfoJt2u9TOM32bZOwM4+8GRHqTx0dYQ8cUQLluL7APPc098/Ab00ksvu2r1avWJqLa8A5U9gLhE9HO14eFHPvTW0tnYjPEOeAH65xpj0USq9jP6pXkb/Ui8jSREm8ZU4tggtE1f4xddlMdwyUkrp2PP2+NAk3fpiSkmuJ8RsxbbfDb4VD848Fw+/UDbpEN2Zosql9/Lh3Wn/Ch961qBMLajEUt9Bj+vclBuUKdNVFcsqshaCr+B4ylQvU5QVZm33BVN2v5ky1cuQKbO6ANvX8OfS0lL5IlMmGpRJpqw6DTT9iL+mXuWy+6IosyfAXO42KAvJbZUp62g3wh9S0uXLSEwZ/T+9jP6bXhZNmWTLDihrza1bZMpKYrilTKTDlI1WFlEmpOvNMGWjlXeDY6lS9lmAAQCcS4bAIrc3YAAAAABJRU5ErkJggg==);*/background-image: url("../images/play_now_btn.png"); background-repeat:repeat-y;float:left;height:30px}
.playRegular:hover .playRegularStart_int{ background-position:0px 150px}
.playRegularStart_int{ background-position:0px 0px;width:6px}
.playRegular:hover .playRegularEnd_int{ background-position:0px 30px}
.playRegularEnd_int{ background-position:0px 60px;width:7px}
.playRegular:hover .playRegular_int{ background-position:0px 90px}
.playRegular_int{ cursor:pointer;background-position:0px 120px;background-repeat:repeat;min-width:100px;text-align:center}

.PlayButton>input{ margin:1px !important}
.PlayButton>span{ margin:2px !important}
</style>

<script type="text/javascript">
function DateStringToDateObject(e){var t=null;try{t=new Date(e);if(t=="Invalid Date")throw new Error("Invalid Date Format: "+e);return t}catch(n){var r=e.split(" ");var i=r[0].split(/[-\/]/);var s;if(r.length>1)s=r[1].split(":");var o=null;var u=null;var a=null;var f=null;var l=null;var c=null;if(i.length>0){o=parseInt(i[0],10)-1;u=parseInt(i[1],10);a=parseInt(i[2],10)}if(s&&s.length>0){f=parseInt(s[0],10);l=parseInt(s[1],10);c=parseInt(s[2],10)}t=new Date(a,o,u,f,l,c);return t}}function CreateCountdown(e,t,n,r,i){var s="{days} days {hours} hours {minutes} minutes {seconds} seconds";if(i&&typeof i=="string"&&i.length>0)s=i;var o="countdownDiv";if(r&&typeof r=="string"&&r.length>0)o=r;var u=new Date;var a=DateStringToDateObject(t);if(u.getTime()>=a.getTime()){return false}if(n){var f=document.createElement("div");f.id=o;f.className="countdownContainer";f.endDateMilliseconds=a.getTime();f.timerTemplateHtml=s;var l=document.createElement("div");l.id=o+"-title";l.className="countdownTitle";l.innerHTML=e;f.appendChild(l);var c=document.createElement("div");c.id=o+"-timer";c.className="countdownTimer";f.appendChild(c);f.interval=setInterval('UpdateTimer(document.getElementById("'+o+'"));',1e3);n.appendChild(f)}}function UpdateTimer(e){var t=new Date;if(e&&e.endDateMilliseconds-t.getTime()>0){var n=e.id.split("-")[0];var r=document.getElementById(n+"-timer");var i="";var s=e.endDateMilliseconds-t.getTime();var o=1e3;var u=60*o;var a=60*u;var f=24*a;var l=Math.floor(s/f);var c=s%f;var h=l*24;var p=Math.floor(c/a)+h;c=c%a;var d=Math.floor(c/u);c=c%u;var v=Math.floor(c/o);i=e.timerTemplateHtml;i=i.replace("{days}",PadString(new String(l),2,"0"));i=i.replace("{hours}",PadString(new String(p),2,"0"));i=i.replace("{minutes}",PadString(new String(d),2,"0"));i=i.replace("{seconds}",PadString(new String(v),2,"0"));r.innerHTML=i}else{clearInterval(e.interval);e.parentNode.removeChild(e)}}function AddCountdownTester(e,t){var n="ctTester";if(document.getElementById(n))return;var r="-";var i=":";var s=59;var o=new Date;var u=o.getSeconds()+e;if(u>s){o.setMinutes(o.getMinutes()+1);u=0+(u-s)}o.setSeconds(u);var a=MDYHIS_DateString(o);var f=!t?document.body:t;CreateCountdown("... Tester will disappear in ...",a,f,n,"{seconds} seconds")}function MDYHIS_DateString(e){var t=59;var n=59;var r=23;var i="-";var s=":";var o=e;var u=o.getMonth()+1;var a=o.getDate();var f=o.getFullYear();var l=o.getHours();var c=o.getMinutes();var h=o.getSeconds();return u+i+a+i+f+" "+l+s+c+s+h}function PadString(e,t,n){var r=t-e.length;if(r<=0)return e;var i="";for(var s=1;s<=r;s++)i+=n;return i+e}

function timers()
{
<?php
for($i = 1; $i < 4; $i++) {
echo "CreateCountdown('".$lottodata[$i]['amount']."', '".$lottodata[$i]['jpdate']."', document.getElementById('timers".$i."'), 'timer".$i."', '{hours}:{minutes}:{seconds}');";
}
?>
}
</script>
	
</head>
<body onload="timers();">
<?php for($i = 1; $i < 4; $i++) { ?>

<div class="sidebar-jackpot">

<a href="<?php echo $lottodata[$i]['afflink']; ?>" class="lottery_link"><img src="<?php echo $lottodata[$i]['logo']; ?>" border="0" /></a>

<div class="playRegular"><div class="playRegularStart_int"></div><div class="playRegular_int"><span class="playRegular"><a target="_blank" href="<?php echo $lottodata[$i]['afflink']; ?>" class="playRegular" id="PlayLinkButton_60"><?=$btntext;?></a></span></div><div class="playRegularEnd_int"></div></div>

<div id="timers<?php echo $i; ?>"></div>

</div>

<?php } ?>
</body>
</html>