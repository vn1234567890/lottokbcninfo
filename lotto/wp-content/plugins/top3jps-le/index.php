<?php
/*
Plugin Name: Top3 Jackpots widget
Plugin URI: http://damyanov.eu
Description: [top3jps] is the shortcode for the top3 jackpots
Version: The Plugin's Version Number, e.g.: 1.0
Author: Radostin Damyanov
Author URI: http://damyanov.eu
License: A "Slug" license name e.g. GPL2
*/
header( 'Content-type: text/html; charset=UTF-8' );
date_default_timezone_set( 'UTC' );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

//wp_clear_scheduled_hook( 'jpcron_top3jps' ); // Manually delete scheduled event

if ( ! wp_next_scheduled( 'jpcron_top3jps' ) ) {
	wp_schedule_event( time(), 'hourly', 'jpcron_top3jps' );
}

add_action( 'jpcron_top3jps', 'update_jpcron_top3jps' );

function update_jpcron_top3jps() {
//	emsgd('$content');die();
	$feed_url = "http://feeds.lottoelite.com/rss.php?lang=en&account=offpista&site=2&type=3";
	$content  = file_get_contents( $feed_url );

	$x        = new SimpleXmlElement( $content );

	$lottos = array(
		2  => array( "name" => "Mega Millions", "currency" => "USD", "nextday" => TRUE, "GMT" => "04:00:00" ),
		3  => array( "name" => "Powerball", "currency" => "USD", "nextday" => TRUE, "GMT" => "04:00:00" ),
		4  => array( "name" => "California SuperLotto", "currency" => "USD", "nextday" => TRUE, "GMT" => "00:45:00" ),
		5  => array( "name" => "New York Lotto", "currency" => "USD", "nextday" => TRUE, "GMT" => "04:21:00" ),
		6  => array( "name" => "Florida Lotto", "currency" => "USD", "nextday" => TRUE, "GMT" => "04:15:00" ),
		8  => array( "name" => "EuroMillions", "currency" => "EUR", "nextday" => FALSE, "GMT" => "21:00:00" ),
		9  => array( "name" => "Lotto 6/49", "currency" => "CAD", "nextday" => TRUE, "GMT" => "02:10:00" ),
		11 => array( "name" => "Mega-Sena", "currency" => "BRL", "nextday" => FALSE, "GMT" => "22:00:00" ),
		12 => array( "name" => "El Gordo", "currency" => "EUR", "nextday" => FALSE, "GMT" => "12:00:00" ),
		14 => array( "name" => "Powerball Australia", "currency" => "AUD", "nextday" => FALSE, "GMT" => "09:30:00" ),
		15 => array( "name" => "German Lotto", "currency" => "EUR", "nextday" => FALSE, "GMT" => "17:50:00" ),
		16 => array( "name" => "UK National Lottery", "currency" => "GBP", "nextday" => FALSE, "GMT" => "21:30:00" ),
		17 => array( "name" => "French Loto", "currency" => "EUR", "nextday" => FALSE, "GMT" => "19:00:00" ),
		18 => array( "name" => "SuperEnalotto", "currency" => "EUR", "nextday" => FALSE, "GMT" => "19:00:00" ),
		19 => array( "name" => "La Primitiva", "currency" => "EUR", "nextday" => FALSE, "GMT" => "20:30:00" ),
		20 => array( "name" => "Hot Lotto", "currency" => "USD", "nextday" => TRUE, "GMT" => "04:00:00" ),
		21 => array( "name" => "Irish Lotto", "currency" => "EUR", "nextday" => FALSE, "GMT" => "20:00:00" ),
		22 => array( "name" => "Hoosier Lotto", "currency" => "USD", "nextday" => TRUE, "GMT" => "03:50:00" ),
		23 => array( "name" => "UK Thunderball", "currency" => "GBP", "nextday" => FALSE, "GMT" => "19:30:00" ),
		24 => array( "name" => "EuroJackpot", "currency" => "EUR", "nextday" => FALSE, "GMT" => "20:00:00" ),
		25 => array( "name" => "EuroMillions UK", "currency" => "GBP", "nextday" => FALSE, "GMT" => "21:00:00" )
	);

	$i         = 1;
	$lottodata = array();
	foreach ( $x->channel->item as $entry ) {

		if ( $i < 4 ) {

			$url   = (string) $entry->link;
			$query = parse_url( $url, PHP_URL_QUERY );
			$vars  = array();
			parse_str( $query, $vars );
			$lot_id = $vars['lot_id'];

			$desc = $entry->description;

			str_replace( "&nbsp;", "", $desc );

			$ex1 = explode( "Draw date:", $desc );

			$ex2 = explode( "Jackpot:", $ex1[1] );

			$ex3 = explode( "<br /><a", $ex2[1] );


			$title   = (string) $entry->title;
			$enddate = $ex2[0];
			$amount  = trim( $ex3[0] );

			$exdate  = explode( "<br />", $enddate );
			$enddate = $exdate[0];

			$newstr = $title . $enddate . $amount;

			$explodedate = explode( "-", $enddate );
			$year        = trim( $explodedate[0] );
			$month       = trim( $explodedate[1] );
			$day         = trim( $explodedate[2] );

			if ( $lottos[ $lot_id ]['nextday'] ) {
				$drawdate = date( 'm/d/Y H:i:s', strtotime( $year . '-' . $month . '-' . $day . ' ' . $lottos[ $lot_id ]['GMT'] . ' + 1 day' ) );
			} else {
				$drawdate = date( 'm/d/Y H:i:s', strtotime( $year . '-' . $month . '-' . $day . ' ' . $lottos[ $lot_id ]['GMT'] ) );
			}

			if ( $lot_id == 2 ) {
				$afflink = 'http://www.lottoexposed.com/usamega1';
			} else if ( $lot_id == 3 ) {
				$afflink = 'http://www.lottoexposed.com/uspowerball1';
			} else if ( $lot_id == 4 ) {
				$afflink = 'http://www.lottoexposed.com/superlotto1';
			} else if ( $lot_id == 5 ) {
				$afflink = 'http://www.lottoexposed.com/nylotto1';
			} else if ( $lot_id == 6 ) {
				$afflink = 'http://www.lottoexposed.com/FloridaLotto1';
			} else if ( $lot_id == 8 ) {
				$afflink = 'http://www.lottoexposed.com/euromillion1';
			} else if ( $lot_id == 9 ) {
				$afflink = 'http://www.lottoexposed.com/lotto6491';
			} else if ( $lot_id == 11 ) {
				$afflink = 'http://www.lottoexposed.com/megasena1';
			} else if ( $lot_id == 12 ) {
				$afflink = 'http://www.lottoexposed.com/elgordo1';
			} else if ( $lot_id == 13 ) {
				$afflink = 'http://www.lottoexposed.com/OzLotteries1';
			} else if ( $lot_id == 14 ) {
				$afflink = 'http://www.lottoexposed.com/OzPowerball1';
			} else if ( $lot_id == 16 ) {
				$afflink = 'http://www.lottoexposed.com/uklottery1';
			} else if ( $lot_id == 17 ) {
				$afflink = 'http://www.lottoexposed.com/francelotto1';
			} else if ( $lot_id == 18 ) {
				$afflink = 'http://www.lottoexposed.com/superenalotto1';
			} else if ( $lot_id == 19 ) {
				$afflink = 'http://www.lottoexposed.com/Primitiva1';
			} else if ( $lot_id == 20 ) {
				$afflink = 'http://www.lottoexposed.com/hotlotto1';
			} else if ( $lot_id == 21 ) {
				$afflink = 'http://www.lottoexposed.com/irishlotto1';
			} else if ( $lot_id == 22 ) {
				$afflink = 'http://www.lottoexposed.com/indiana1';
			} else if ( $lot_id == 23 ) {
				$afflink = 'http://www.lottoexposed.com/Thunderball1';
			} else if ( $lot_id == 24 ) {
				$afflink = 'http://www.lottoexposed.com/eurojackpot1';
			} else if ( $lot_id == 25 ) {
				$afflink = 'http://www.lottoexposed.com/euromillionUK';
			} else {
				$afflink = 'http://www.lottoexposed.com/PlayHugeLottos1';
			}

			$lottologo = 'http://feeds.lottoelite.com/iframe/logos/' . $lot_id . '.png';
			$jpdate    = $drawdate . " UTC";

			$lottodata[ $i ]['afflink'] = $afflink;
			$lottodata[ $i ]['logo']    = $lottologo;
			$lottodata[ $i ]['title']   = $title;
			$lottodata[ $i ]['amount']  = $amount;
			$lottodata[ $i ]['jpdate']  = $jpdate;

			$i ++;
		}
	}

	update_option( 'jps_lottodata', serialize( $lottodata ) );

}

//update_jpcron_top3jps(); //manually update DB data

function top3jps_shortcode( $atts ) {

	wp_enqueue_style( 'top3jps-style', plugins_url( 'top3jps-le.css', __FILE__ ) );
	wp_enqueue_script( 'top3jps', home_url( '?top3jps=true&r='.date('usihdmy'), __FILE__ ), array( 'jquery' ), date('usihdmy'), TRUE );

	if ( get_option( 'jps_lottodata' ) ) {
		$lottodata = unserialize( get_option( 'jps_lottodata' ) );
	}
	$btntext  = 'Play Now';
	$top3html = '<div id="top3jps-le">';
	$c        = 1;

	foreach ( $lottodata as $ld ) {
		$top3html .= '<div class="sidebar-jackpot"><div class="logos"><a target="_blank" href="' . $ld['afflink'] . '"><img src="' . $ld['logo'] . '" border="0" /></a></div><div class="playRegular"><div class="playRegularStart_int"></div><div class="playRegular_int"><span class="playRegular"><a target="_blank" href="' . $ld['afflink'] . '" class="playRegular" id="PlayLinkButton_60">' . $btntext . '</a></span></div><div class="playRegularEnd_int"></div></div><div id="timers' . $c . '"></div></div>';
		$c ++;
	}

	$top3html .= '</div>';

	return $top3html;

}

add_shortcode( 'top3jps', 'top3jps_shortcode' );

add_action( 'init', 'top3jps_js_php_data' );

function top3jps_js_php_data() {

	if ( get_option( 'jps_lottodata' ) ) {
		$lottodata = unserialize( get_option( 'jps_lottodata' ) );
	}
	$timers_js = '';

	for ( $t = 1; $t < 4; $t ++ ) {
		$timers_js .= "CreateCountdown('" . $lottodata[ $t ]['amount'] . "', new Date('" . $lottodata[ $t ]['jpdate'] . "'), document.getElementById('timers" . $t . "'), 'timer" . $t . "', '{hours}:{minutes}:{seconds}');";
	}

	$siteroot = site_url( '/' );

	$plgroot = plugins_url( '/', __FILE__ );

	if ( isset( $_GET['top3jps'] ) && $_GET['top3jps'] == 'true' ) {

		header( "content-type: application/javascript" );
		header( "Cache-Control: no-store, no-cache, must-revalidate, max-age=0 , private" );
		header( "Cache-Control: post-check=0, pre-check=0", FALSE );
		header( "Pragma: no-cache, private" );
		//header( "Pragma: private" );
		header('Expires: -1');
		?>
		function DateStringToDateObject(e){var t=null;try{t=new Date(e);if(t=="Invalid Date")throw new Error("Invalid Date Format: "+e);return t}catch(n){var r=e.split(" ");var i=r[0].split(/[-\/]/);var s;if(r.length>1)s=r[1].split(":");var o=null;var u=null;var a=null;var f=null;var l=null;var c=null;if(i.length>0){o=parseInt(i[0],10)-1;u=parseInt(i[1],10);a=parseInt(i[2],10)}if(s&&s.length>0){f=parseInt(s[0],10);l=parseInt(s[1],10);c=parseInt(s[2],10)}t=new Date(a,o,u,f,l,c);return t}}function CreateCountdown(e,t,n,r,i){var s="{days} days {hours} hours {minutes} minutes {seconds} seconds";if(i&&typeof i=="string"&&i.length>0)s=i;var o="countdownDiv";if(r&&typeof r=="string"&&r.length>0)o=r;var u=new Date;var a=DateStringToDateObject(t);if(u.getTime()>=a.getTime()){return false}if(n){var f=document.createElement("div");f.id=o;f.className="countdownContainer";f.endDateMilliseconds=a.getTime();f.timerTemplateHtml=s;var l=document.createElement("div");l.id=o+"-title";l.className="countdownTitle";l.innerHTML=e;f.appendChild(l);var c=document.createElement("div");c.id=o+"-timer";c.className="countdownTimer";f.appendChild(c);f.interval=setInterval('UpdateTimer(document.getElementById("'+o+'"));',1e3);n.appendChild(f)}}function UpdateTimer(e){var t=new Date;if(e&&e.endDateMilliseconds-t.getTime()>0){var n=e.id.split("-")[0];var r=document.getElementById(n+"-timer");var i="";var s=e.endDateMilliseconds-t.getTime();var o=1e3;var u=60*o;var a=60*u;var f=24*a;var l=Math.floor(s/f);var c=s%f;var h=l*24;var p=Math.floor(c/a)+h;c=c%a;var d=Math.floor(c/u);c=c%u;var v=Math.floor(c/o);i=e.timerTemplateHtml;i=i.replace("{days}",PadString(new String(l),2,"0"));i=i.replace("{hours}",PadString(new String(p),2,"0"));i=i.replace("{minutes}",PadString(new String(d),2,"0"));i=i.replace("{seconds}",PadString(new String(v),2,"0"));r.innerHTML=i}else{clearInterval(e.interval);e.parentNode.removeChild(e)}}function AddCountdownTester(e,t){var n="ctTester";if(document.getElementById(n))return;var r="-";var i=":";var s=59;var o=new Date;var u=o.getSeconds()+e;if(u>s){o.setMinutes(o.getMinutes()+1);u=0+(u-s)}o.setSeconds(u);var a=MDYHIS_DateString(o);var f=!t?document.body:t;CreateCountdown("... Tester will disappear in ...",a,f,n,"{seconds} seconds")}function MDYHIS_DateString(e){var t=59;var n=59;var r=23;var i="-";var s=":";var o=e;var u=o.getMonth()+1;var a=o.getDate();var f=o.getFullYear();var l=o.getHours();var c=o.getMinutes();var h=o.getSeconds();return u+i+a+i+f+" "+l+s+c+s+h}function PadString(e,t,n){var r=t-e.length;if(r<=0)return e;var i="";for(var s=1;s<=r;s++)i+=n;return i+e}

		function timers() {
		<?php echo $timers_js; ?>
		}

		jQuery(window).load(timers());
		<?php
		exit();
	}
}

?>