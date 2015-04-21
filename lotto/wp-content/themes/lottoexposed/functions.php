<?php
/**
 * TwentyTen functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyten_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyten_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
include_once get_stylesheet_directory().'/src/emsgd.php';


//emsgd('remove my!!');

//function update_jpcron_top3jps() {
////	emsgd('$content');die();
//	$feed_url = "http://feeds.lottoelite.com/rss.php?lang=en&account=offpista&site=2&type=3";
//	$content  = file_get_contents( $feed_url );
//
//	$x        = new SimpleXmlElement( $content );
//
//	$lottos = array(
//		2  => array( "name" => "Mega Millions", "currency" => "USD", "nextday" => TRUE, "GMT" => "04:00:00" ),
//		3  => array( "name" => "Powerball", "currency" => "USD", "nextday" => TRUE, "GMT" => "04:00:00" ),
//		4  => array( "name" => "California SuperLotto", "currency" => "USD", "nextday" => TRUE, "GMT" => "00:45:00" ),
//		5  => array( "name" => "New York Lotto", "currency" => "USD", "nextday" => TRUE, "GMT" => "04:21:00" ),
//		6  => array( "name" => "Florida Lotto", "currency" => "USD", "nextday" => TRUE, "GMT" => "04:15:00" ),
//		8  => array( "name" => "EuroMillions", "currency" => "EUR", "nextday" => FALSE, "GMT" => "21:00:00" ),
//		9  => array( "name" => "Lotto 6/49", "currency" => "CAD", "nextday" => TRUE, "GMT" => "02:10:00" ),
//		11 => array( "name" => "Mega-Sena", "currency" => "BRL", "nextday" => FALSE, "GMT" => "22:00:00" ),
//		12 => array( "name" => "El Gordo", "currency" => "EUR", "nextday" => FALSE, "GMT" => "12:00:00" ),
//		14 => array( "name" => "Powerball Australia", "currency" => "AUD", "nextday" => FALSE, "GMT" => "09:30:00" ),
//		15 => array( "name" => "German Lotto", "currency" => "EUR", "nextday" => FALSE, "GMT" => "17:50:00" ),
//		16 => array( "name" => "UK National Lottery", "currency" => "GBP", "nextday" => FALSE, "GMT" => "21:30:00" ),
//		17 => array( "name" => "French Loto", "currency" => "EUR", "nextday" => FALSE, "GMT" => "19:00:00" ),
//		18 => array( "name" => "SuperEnalotto", "currency" => "EUR", "nextday" => FALSE, "GMT" => "19:00:00" ),
//		19 => array( "name" => "La Primitiva", "currency" => "EUR", "nextday" => FALSE, "GMT" => "20:30:00" ),
//		20 => array( "name" => "Hot Lotto", "currency" => "USD", "nextday" => TRUE, "GMT" => "04:00:00" ),
//		21 => array( "name" => "Irish Lotto", "currency" => "EUR", "nextday" => FALSE, "GMT" => "20:00:00" ),
//		22 => array( "name" => "Hoosier Lotto", "currency" => "USD", "nextday" => TRUE, "GMT" => "03:50:00" ),
//		23 => array( "name" => "UK Thunderball", "currency" => "GBP", "nextday" => FALSE, "GMT" => "19:30:00" ),
//		24 => array( "name" => "EuroJackpot", "currency" => "EUR", "nextday" => FALSE, "GMT" => "20:00:00" ),
//		25 => array( "name" => "EuroMillions UK", "currency" => "GBP", "nextday" => FALSE, "GMT" => "21:00:00" )
//	);
//
//	$i         = 1;
//	$lottodata = array();
//	foreach ( $x->channel->item as $entry ) {
//
//		if ( $i < 4 ) {
//
//			$url   = (string) $entry->link;
//			$query = parse_url( $url, PHP_URL_QUERY );
//			$vars  = array();
//			parse_str( $query, $vars );
//			$lot_id = $vars['lot_id'];
//
//			$desc = $entry->description;
//
//			str_replace( "&nbsp;", "", $desc );
//
//			$ex1 = explode( "Draw date:", $desc );
//
//			$ex2 = explode( "Jackpot:", $ex1[1] );
//
//			$ex3 = explode( "<br /><a", $ex2[1] );
//
//
//			$title   = (string) $entry->title;
//			$enddate = $ex2[0];
//			$amount  = trim( $ex3[0] );
//
//			$exdate  = explode( "<br />", $enddate );
//			$enddate = $exdate[0];
//
//			$newstr = $title . $enddate . $amount;
//
//			$explodedate = explode( "-", $enddate );
//			$year        = trim( $explodedate[0] );
//			$month       = trim( $explodedate[1] );
//			$day         = trim( $explodedate[2] );
//
//			if ( $lottos[ $lot_id ]['nextday'] ) {
//				$drawdate = date( 'm/d/Y H:i:s', strtotime( $year . '-' . $month . '-' . $day . ' ' . $lottos[ $lot_id ]['GMT'] . ' + 1 day' ) );
//			} else {
//				$drawdate = date( 'm/d/Y H:i:s', strtotime( $year . '-' . $month . '-' . $day . ' ' . $lottos[ $lot_id ]['GMT'] ) );
//			}
//
//			if ( $lot_id == 2 ) {
//				$afflink = 'http://www.lottoexposed.com/usamega1';
//			} else if ( $lot_id == 3 ) {
//				$afflink = 'http://www.lottoexposed.com/uspowerball1';
//			} else if ( $lot_id == 4 ) {
//				$afflink = 'http://www.lottoexposed.com/superlotto1';
//			} else if ( $lot_id == 5 ) {
//				$afflink = 'http://www.lottoexposed.com/nylotto1';
//			} else if ( $lot_id == 6 ) {
//				$afflink = 'http://www.lottoexposed.com/FloridaLotto1';
//			} else if ( $lot_id == 8 ) {
//				$afflink = 'http://www.lottoexposed.com/euromillion1';
//			} else if ( $lot_id == 9 ) {
//				$afflink = 'http://www.lottoexposed.com/lotto6491';
//			} else if ( $lot_id == 11 ) {
//				$afflink = 'http://www.lottoexposed.com/megasena1';
//			} else if ( $lot_id == 12 ) {
//				$afflink = 'http://www.lottoexposed.com/elgordo1';
//			} else if ( $lot_id == 13 ) {
//				$afflink = 'http://www.lottoexposed.com/OzLotteries1';
//			} else if ( $lot_id == 14 ) {
//				$afflink = 'http://www.lottoexposed.com/OzPowerball1';
//			} else if ( $lot_id == 16 ) {
//				$afflink = 'http://www.lottoexposed.com/uklottery1';
//			} else if ( $lot_id == 17 ) {
//				$afflink = 'http://www.lottoexposed.com/francelotto1';
//			} else if ( $lot_id == 18 ) {
//				$afflink = 'http://www.lottoexposed.com/superenalotto1';
//			} else if ( $lot_id == 19 ) {
//				$afflink = 'http://www.lottoexposed.com/Primitiva1';
//			} else if ( $lot_id == 20 ) {
//				$afflink = 'http://www.lottoexposed.com/hotlotto1';
//			} else if ( $lot_id == 21 ) {
//				$afflink = 'http://www.lottoexposed.com/irishlotto1';
//			} else if ( $lot_id == 22 ) {
//				$afflink = 'http://www.lottoexposed.com/indiana1';
//			} else if ( $lot_id == 23 ) {
//				$afflink = 'http://www.lottoexposed.com/Thunderball1';
//			} else if ( $lot_id == 24 ) {
//				$afflink = 'http://www.lottoexposed.com/eurojackpot1';
//			} else if ( $lot_id == 25 ) {
//				$afflink = 'http://www.lottoexposed.com/euromillionUK';
//			} else {
//				$afflink = 'http://www.lottoexposed.com/PlayHugeLottos1';
//			}
//
//			$lottologo = 'http://feeds.lottoelite.com/iframe/logos/' . $lot_id . '.png';
//			$jpdate    = $drawdate . " UTC";
//
//			$lottodata[ $i ]['afflink'] = $afflink;
//			$lottodata[ $i ]['logo']    = $lottologo;
//			$lottodata[ $i ]['title']   = $title;
//			$lottodata[ $i ]['amount']  = $amount;
//			$lottodata[ $i ]['jpdate']  = $jpdate;
//
//			$i ++;
//		}
//	}
//
//	update_option( 'jps_lottodata', serialize( $lottodata ) );
//
//}
//update_jpcron_top3jps();/


function show_template() { //For debugging
    if( is_super_admin() ){
        global $template;
        //print_r(basename($template));
		//print_r($_COOKIE);
    } 
}
add_action('wp_head', 'show_template');
 
function add_meta_tags_custom_post_type() { //Adds meta tags for title & description to http://www.lottoexposed.com/all-lotteries/
	global $template;
	$template_file = basename($template);
	if ($template_file == 'archive-lottery_sites.php')
    echo '<meta name="title" content="LottoExposed Lottery Directory" />
	<meta name="description" content="LottoExposed Directory is a free database of online lottery agents, lottery strategy developers, lotto industry websites. It is expanding and continuously updated." />';
}

add_action( 'wp_head', 'add_meta_tags_custom_post_type' );

function add_avatar_alt_title_tags($text)
{
$alt = get_the_author_meta( 'display_name' );
$text = str_replace("alt=''", "alt='user avatar' title='user gravatar'",$text);
return $text;
}
add_filter('get_avatar','add_avatar_alt_title_tags');
/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */

function register_sidebar_menu() {
	register_nav_menu('sidebar-menu', __('Sidebar Custom Menu'));
	register_nav_menu('sidebar-approved-lotteries-menu', __('Approved Lotteries (Sidebar 4 lotteries)'));
}
add_action('init', 'register_sidebar_menu');
 
if ( ! isset( $content_width ) )
	$content_width = 640;

/** Tell WordPress to run twentyten_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'twentyten_setup' );

if ( ! function_exists( 'twentyten_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyten_setup() in a child theme, add your own twentyten_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails, custom headers and backgrounds, and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */

//wp_clear_scheduled_hook( 'wpcron_jackpots_anticloudflare' ); //Clear the current wp-cron for wpcron_jackpots_anticloudflare

//Because of Cloudflare, standard cronjob is not working, that why we are using wp-cron to add latest jackpots to the database
if( !wp_next_scheduled( 'wpcron_jackpots_anticloudflare' ) ) {  
   wp_schedule_event( time(), 'twicedaily', 'wpcron_jackpots_anticloudflare' );  
}
  
add_action( 'wpcron_jackpots_anticloudflare', 'update_jackpot_draws' );  

function update_jackpot_draws() {
global $wpdb;

$xml=("http://feeds.lottoelite.com/rss.php?lang=en&account=offpista&site=1&type=1");

$xmlDoc = new DOMDocument();
$xmlDoc->load($xml);

$x=$xmlDoc->getElementsByTagName('item');

$count = $x->length;

for ($i=0; $i<=$count-1; $i++)
  {
  $title = $x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
  $link = $x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
  $link = str_replace(array('http://www.wintrillions.com/play_lottery.php?lot_id=', '&account=offpista'), '', $link);
  $description = $x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
  $desc = explode("<br />", $description);
  $drawdate = str_replace("Draw date: ", "", $desc[0]);
  $results = str_replace("Draw Result: ", "", $desc[1]);
  $results = str_replace(array("-", "+"), ",", $results);
  
  $ids = array(2 => 'mm', 3 => 'pb', 8 => 'em', 4 => 'cs', 5 => 'ny', 6 => 'fl', 13 => 'oz', 14 => 'pa', 16 => 'uk', 17 => 'fr', 9 => '49', 11 => 'ms', 12 => 'eg', 18 => 'se', 19 => 'lp', 20 => 'hl', 15 => 'de', 21 => 'ie', 22 => 'ho', 23 => 'tb', 24 => 'ej', 25 => 'ek');         
  
  $resnum = explode(",", $results);
  
  $zeros = '';
  
  if(count($resnum) < 9)
  $zeros = 9 - count($resnum);

  if($zeros == 4) {
  $results = $results.',0,0,0,0';
  } else if ($zeros == 3) {
  $results = $results.',0,0,0';
  } else if ($zeros == 2) {
  $results = $results.',0,0';
  } else if ($zeros == 1) {
  $results = $results.',0';
  }
  
  $jackpot = str_replace('&#8364;','',$desc[2]);
  $jackpot = preg_replace("/[^0-9]/s", "", $jackpot);
  
  if(empty($jackpot))
  $jackpot = 0;
  
  $usd = array("Mega Millions", "Powerball", "California SuperLotto", "New York Lotto", "Lotto Texas", "Florida Lotto", "Hoosier Lotto", "Hot Lotto");
  $aud = array("Oz Lotto", "Powerball Australia");
  $cad = array("Super 7", "Lotto 6/49");
  $eur = array("EuroMillions", "El Gordo", "France Loto", "SuperEnalotto", "German Lotto", "La Primitiva", "Irish Lotto");
  $gbp = array("UK National Lottery", "Thunderball Lotto");
  $brl = array("Mega Sena");
  
  if (in_array($title, $usd)) {
  $cur = 'USD';
  } else if (in_array($title, $aud)) {
  $cur = 'AUD';
  } else if (in_array($title, $cad)) {
  $cur = 'CAD';
  } else if (in_array($title, $eur)) {
  $cur = 'EUR';
  } else if (in_array($title, $gbp)) {
  $cur = 'GBP';
  } else if (in_array($title, $brl)) {
  $cur = 'BRL';
  }
  
  $results = explode(",", $results);

  $query = $wpdb->get_row("SELECT * FROM jackpots WHERE lotto = '$ids[$link]' AND jpdate = '$drawdate'", ARRAY_A);
  
  if (empty($query)) {
  $wpdb->insert( 'jackpots', array( 'lotto' => $ids[$link], 'jpdate' => $drawdate, 'jp' => $jackpot, 'cur' => $cur, 'n1' => $results[0], 'n2' => $results[1], 'n3' => $results[2], 'n4' => $results[3], 'n5' => $results[4], 'n6' => $results[5], 'n7' => $results[6], 'n8' => $results[7], 'n9' => $results[8]), array( '%s', '%s', '%d', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d' ) );
  } else if ($query['jp'] == 0) {
  $wpdb->update( 'jackpots', array( 'jp' => $jackpot), array( 'id' => $query['id']), array( '%d'), array( '%d' ) );
  }

  }
}

if( !is_admin()){
    wp_deregister_script('jquery');
    wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js", false, '1.7.2', true);
    wp_enqueue_script('jquery');
}

function twentyten_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'twentyten', get_template_directory() . '/languages' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'twentyten' ),
	) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', array(
		// Let WordPress know what our default background color is.
		'default-color' => 'f1f1f1',
	) );

	// The custom header business starts here.

	$custom_header_support = array(
		// The default image to use.
		// The %s is a placeholder for the theme template directory URI.
		'default-image' => '%s/images/headers/path.jpg',
		// The height and width of our custom header.
		'width' => apply_filters( 'twentyten_header_image_width', 940 ),
		'height' => apply_filters( 'twentyten_header_image_height', 198 ),
		// Support flexible heights.
		'flex-height' => true,
		// Don't support text inside the header image.
		'header-text' => false,
		// Callback for styling the header preview in the admin.
		'admin-head-callback' => 'twentyten_admin_header_style',
	);
	
	add_theme_support( 'custom-header', $custom_header_support );
	
	if ( ! function_exists( 'get_custom_header' ) ) {
		// This is all for compatibility with versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR', '' );
		define( 'NO_HEADER_TEXT', true );
		define( 'HEADER_IMAGE', $custom_header_support['default-image'] );
		define( 'HEADER_IMAGE_WIDTH', $custom_header_support['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $custom_header_support['height'] );
		add_custom_image_header( '', $custom_header_support['admin-head-callback'] );
		add_custom_background();
	}

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( $custom_header_support['width'], $custom_header_support['height'], true );

	// ... and thus ends the custom header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'berries' => array(
			'url' => '%s/images/headers/berries.jpg',
			'thumbnail_url' => '%s/images/headers/berries-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Berries', 'twentyten' )
		),
		'cherryblossom' => array(
			'url' => '%s/images/headers/cherryblossoms.jpg',
			'thumbnail_url' => '%s/images/headers/cherryblossoms-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Cherry Blossoms', 'twentyten' )
		),
		'concave' => array(
			'url' => '%s/images/headers/concave.jpg',
			'thumbnail_url' => '%s/images/headers/concave-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Concave', 'twentyten' )
		),
		'fern' => array(
			'url' => '%s/images/headers/fern.jpg',
			'thumbnail_url' => '%s/images/headers/fern-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Fern', 'twentyten' )
		),
		'forestfloor' => array(
			'url' => '%s/images/headers/forestfloor.jpg',
			'thumbnail_url' => '%s/images/headers/forestfloor-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Forest Floor', 'twentyten' )
		),
		'inkwell' => array(
			'url' => '%s/images/headers/inkwell.jpg',
			'thumbnail_url' => '%s/images/headers/inkwell-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Inkwell', 'twentyten' )
		),
		'path' => array(
			'url' => '%s/images/headers/path.jpg',
			'thumbnail_url' => '%s/images/headers/path-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Path', 'twentyten' )
		),
		'sunset' => array(
			'url' => '%s/images/headers/sunset.jpg',
			'thumbnail_url' => '%s/images/headers/sunset-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Sunset', 'twentyten' )
		)
	) );
}
endif;

if ( ! function_exists( 'twentyten_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in twentyten_setup().
 *
 * @since Twenty Ten 1.0
 */
function twentyten_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If header-text was supported, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentyten_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function twentyten_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'twentyten_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function twentyten_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyten_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function twentyten_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyten_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyten_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function twentyten_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyten_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css. This is just
 * a simple filter call that tells WordPress to not use the default styles.
 *
 * @since Twenty Ten 1.2
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Deprecated way to remove inline styles printed when the gallery shortcode is used.
 *
 * This function is no longer needed or used. Use the use_default_gallery_style
 * filter instead, as seen above.
 *
 * @since Twenty Ten 1.0
 * @deprecated Deprecated in Twenty Ten 1.2 for WordPress 3.1
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function twentyten_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
// Backwards compatibility with WordPress 3.0.
if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) )
	add_filter( 'gallery_style', 'twentyten_remove_gallery_css' );

if ( ! function_exists( 'twentyten_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 60 ); ?>
			<?php printf( __( '%s <span class="says">:</span>', 'twentyten' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
            <div class="comment-meta commentmetadata">
               Posted on: <?php
                /* translators: 1: date, 2: time */
                printf( __( '%1$s at %2$s', 'twentyten' ), get_comment_date(),  get_comment_time() ); ?><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' );
                ?>
            </div><!-- .comment-meta .commentmetadata -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyten' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-body"><?php comment_text(); ?></div>



		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyten' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override twentyten_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function twentyten_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => 'Right sidebar - Subscribe form',
		'id' => 'subscribe-form',
		'before_title' => '<div class="sidebar-block-header">',
		'after_title' => '</div>',
	) );
	register_sidebar( array(
		'name' => 'About us text',
		'id' => 'sidebar-text',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => ''
	) );
	register_sidebar( array(
		'name' => 'Right sidebar',
		'id' => 'right-sidebar',
		'before_title' => '<div class="sidebar-block-header">',
		'after_title' => '</div>',
	) );
	register_sidebar( array(
		'name' => 'Footer: first column',
		'id' => 'footer-first-column',
		'before_title' => '<p>',
		'after_title' => '</p>',
	) );
	register_sidebar( array(
		'name' => 'Footer: second column',
		'id' => 'footer-second-column',
		'before_title' => '<p>',
		'after_title' => '</p>',
	) );
	register_sidebar( array(
		'name' => 'Footer: third column',
		'id' => 'footer-third-column',
		'before_title' => '<p>',
		'after_title' => '</p>',
	) );
	register_sidebar( array(
		'name' => 'Footer: fourth column',
		'id' => 'footer-fourth-column',
		'before_title' => '<p>',
		'after_title' => '</p>',
	) );
	register_sidebar( array(
		'name' => 'Footer: fifth column',
		'id' => 'footer-fifth-column',
		'before_title' => '<p>',
		'after_title' => '</p>',
	) );

}
/** Register sidebars by running twentyten_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'twentyten_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * This function uses a filter (show_recent_comments_widget_style) new in WordPress 3.1
 * to remove the default style. Using Twenty Ten 1.2 in WordPress 3.0 will show the styles,
 * but they won't have any effect on the widget in default Twenty Ten styling.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );

if ( ! function_exists( 'twentyten_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_on() {
    $date=get_the_date('D, m/d/Y');
    $text="Exposed by <a href='".get_author_posts_url( get_the_author_meta( 'ID' ) )."'>".get_the_author()."</a> on  $date";
    echo $text;
}
endif;

if ( ! function_exists( 'twentyten_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;
function truncate_post($content,$len) {
    $cont_arr=explode(' ',$content);
    return implode(' ',array_slice($cont_arr,0,$len-1));
}
add_action('init', 'my_html_tags_code', 10);
function my_html_tags_code() {
  define('CUSTOM_TAGS', true);
  global $allowedposttags, $allowedtags;
  $allowedposttags = array();
  $allowedtags = array();
}
add_filter('comment_form_default_fields', 'url_filtered');
function url_filtered($fields) {
    if(isset($fields['url']))
    unset($fields['url']);
    return $fields;
}

function new_excerpt_more( $more ) {
	return ' - <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">Read more »</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

function new_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'new_excerpt_length');

function custom_excerpt_length( $length ) {
    return (is_front_page()) ? 60 : 30;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

//disable WordPress sanitization to allow more than just $allowedtags from /wp-includes/kses.php
remove_filter('pre_user_description', 'wp_filter_kses');

function my_captcha_comment_form() {
	global $si_image_captcha, $si_captcha_url, $si_captcha_opt;
	
	ob_start();
	$si_image_captcha->si_captcha_captcha_html('si_image_com','com');
	$si_captcha_output = ob_get_clean();
	
	$remove_refresh = explode('<div id="si_refresh_com">', $si_captcha_output);
	$si_captcha_output = trim($remove_refresh[0]);
	$captcha_refresh = trim(str_replace('</div>','',$remove_refresh[1]));
	
	$captcha_code = '<p style="position: relative;"><label id="captcha_code_label" for="captcha_code" >CAPTCHA Code:</label><input id="captcha_code" name="captcha_code" type="text" />'.$si_captcha_output.$captcha_refresh;
	
	echo $captcha_code;
	
	remove_action('comment_form', array(&$si_image_captcha, 'si_captcha_comment_form'), 1);
}

function replace_si_captcha_comment_form_wp3() {
	global $si_image_captcha;

	remove_action('comment_form_after_fields', array(&$si_image_captcha, 'si_captcha_comment_form_wp3'), 1);
	remove_action('comment_form_logged_in_after', array(&$si_image_captcha, 'si_captcha_comment_form_wp3'), 1);

	add_action('comment_form_after_fields', 'my_captcha_comment_form', 1);
}
add_action('init', 'replace_si_captcha_comment_form_wp3');

/** Most commented/read widget START */

function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function wpb_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    wpb_set_post_views($post_id);
}
add_action( 'wp_head', 'wpb_track_post_views');

//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

/** Most commented/read widget END */

add_filter('wp_headers','wpitsprite_headers',10,2);

function wpitsprite_headers($headers,$wp){

if(!is_user_logged_in() && empty($wp->query_vars['feed'])){
   return $headers;
// WE USE 	PHP Cache Headers plugin
//		$headers['Cache-Control'] = 'max-age=10';
//		$headers['Expires']       = gmdate( 'D, d M Y H:i:s', time() + 10 ) . " GMT";

$wpitsprite_timestamp = get_lastpostmodified('GMT')>get_lastcommentmodified('GMT')?get_lastpostmodified('GMT'):get_lastcommentmodified('GMT');
$wp_last_modified = mysql2date('D, d M Y H:i:s', $wpitsprite_timestamp, 0).' GMT';
$wp_etag = '"' . md5($wp_last_modified) . '"';
$headers['Last-Modified'] = $wp_last_modified;
$headers['ETag'] = $wp_etag;

// Support for Conditional GET
if (isset($_SERVER['HTTP_IF_NONE_MATCH']))
$client_etag = stripslashes(stripslashes($_SERVER['HTTP_IF_NONE_MATCH']));
else $client_etag = false;

$client_last_modified = empty($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? '' : trim($_SERVER['HTTP_IF_MODIFIED_SINCE']);
// If string is empty, return 0. If not, attempt to parse into a timestamp
$client_modified_timestamp = $client_last_modified ? strtotime($client_last_modified) : 0;

// Make a timestamp for our most recent modification...
$wp_modified_timestamp = strtotime($wp_last_modified);

$exit_required = false;

if ( ($client_last_modified && $client_etag) ?
(($client_modified_timestamp >= $wp_modified_timestamp) && ($client_etag == $wp_etag)) :
(($client_modified_timestamp >= $wp_modified_timestamp) || ($client_etag == $wp_etag)) ) {
$status = 304;
$exit_required = true;
}

if ( $exit_required ){
if ( ! empty( $status ) ){
status_header( $status );
}
foreach( (array) $headers as $name => $field_value ){
@header("{$name}: {$field_value}");
}

if ( isset( $headers['Last-Modified'] ) && empty( $headers['Last-Modified'] ) && function_exists( 'header_remove' ) ){
@header_remove( 'Last-Modified' );
}

exit();
}
}
return $headers;
}


?>