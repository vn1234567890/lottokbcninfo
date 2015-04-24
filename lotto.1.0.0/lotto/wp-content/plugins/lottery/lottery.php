<?php
/*
Plugin Name: Lottery Reviews & All lotteries
Plugin URI: rado@damyanov.eu
Description: Custom post types for lottery reviews & all lotteries
Version: 1.0
Author: Radostin Damyanov
Author URI: rado@damyanov.eu
License: GPLv2
*/
set_time_limit(999);

add_action( 'admin_menu', 'post_assign_metabox' );
add_action( 'save_post', 'post_assign_save_meta', 10, 2 );

function post_assign_metabox() {
	add_meta_box( 'assign-meta-box', 'Assign Review or Lottery Draw to this post', 'assign_metabox', 'post', 'normal', 'high' );
}

function assign_metabox( $assign ) {
$assigned_review = intval( get_post_meta( $assign->ID, '_lottery_reviews_assign', true ) );
$assigned_draw = intval( get_post_meta( $assign->ID, '_lottery_draws_assign', true ) );
?>
<table>

<tr>
<td style="width: 200px">Assign review to the post:</td>
<td>
<select style="width: 180px" name="lottery_reviews_assign">
<option value="0" <?php if ($assigned_review == 0) { echo 'selected'; }?>>* No Review Assigned *</option>
<?php

$posts_array = get_posts(array('post_type' => 'lottery_sites', 'orderby' => 'title', 'order' => 'ASC', 'numberposts' => -1));
	
foreach ($posts_array as $post) {
$post_title = $post->post_title;
$post_id = $post->ID;

if ($assigned_review == $post_id) { $selected = 'selected'; } else { $selected = ''; }
echo '<option value="'.$post_id.'" '.$selected.'>'.$post_title.'</option>';
}

?>
</select> 
</td>
</tr>

<tr>
<td style="width: 200px">Assign lottery draw to the post:</td>
<td>
<select style="width: 180px" name="lottery_draws_assign">
<option value="0" <?php if ($assigned_draw == 0) { echo 'selected'; }?>>* No Draw Assigned *</option>
<?php

$posts_array = get_posts(array('post_type' => 'lottery_draws', 'orderby' => 'title', 'order' => 'ASC', 'numberposts' => -1));
	
foreach ($posts_array as $post) {
$post_title = $post->post_title;
$post_id = $post->ID;

if ($assigned_draw == $post_id) { $selected = 'selected'; } else { $selected = ''; }
echo '<option value="'.$post_id.'" '.$selected.'>'.$post_title.'</option>';
}

?>
</select> 
</td>
</tr>

<tr>
<td><span style="color: red;">Important Note:</span></td>
<td>You cannot have both review and lottery draw assigned to the post. One of them must not be assigned!</td>
</tr>

<input type="hidden" name="assign_meta_box_nonce" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />

</table>
<?php }

function post_assign_save_meta( $post_id, $post ) {
	
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;

	if ( !wp_verify_nonce( $_POST['assign_meta_box_nonce'], plugin_basename( __FILE__ ) ) )
		return $post_id;

	if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;
	
	$current_assigned_review_to = get_post_meta( $post_id, '_lottery_reviews_assign', true );
	$new_assigned_review_to = stripslashes( $_POST['lottery_reviews_assign'] );

	
	if ( $new_assigned_review_to && '' == $current_assigned_review_to )
		add_post_meta( $post_id, '_lottery_reviews_assign', $new_assigned_review_to, true );

	elseif ( $new_assigned_review_to != $current_assigned_review_to )
		update_post_meta( $post_id, '_lottery_reviews_assign', $new_assigned_review_to );

	elseif ( '' == $new_assigned_review_to && $current_assigned_review_to )
		delete_post_meta( $post_id, '_lottery_reviews_assign', $current_assigned_review_to );
	
	$current_assigned_draw_to = get_post_meta( $post_id, '_lottery_draws_assign', true );
	$new_assigned_draw_to = stripslashes( $_POST['lottery_draws_assign'] );

	
	if ( $new_assigned_draw_to && '' == $current_assigned_draw_to )
		add_post_meta( $post_id, '_lottery_draws_assign', $new_assigned_draw_to, true );

	elseif ( $new_assigned_draw_to != $current_assigned_draw_to )
		update_post_meta( $post_id, '_lottery_draws_assign', $new_assigned_draw_to );

	elseif ( '' == $new_assigned_draw_to && $current_assigned_draw_to )
		delete_post_meta( $post_id, '_lottery_draws_assign', $current_assigned_draw_to );
}

// Enqueue admin scripts and CSS

add_action('admin_enqueue_scripts', 'enqueue_lottery_scripts');  
  
function enqueue_lottery_scripts() {  
    // Include JS/CSS only if we're on our options page
	
    if (is_lottery_plugin_page()) {  
        wp_enqueue_script('jquery-ui-autocomplete');
		wp_enqueue_script('autocomplete', plugins_url('autocomplete.js', __FILE__), array('jquery'), '1.0', true);
		wp_register_style( 'autocomplete', plugins_url('autocomplete.css', __FILE__) );
        wp_enqueue_style( 'autocomplete' );
    }
	
} 

// Check if we're on our options page  
function is_lottery_plugin_page() {  
    $screen = get_current_screen();  
    if (is_object($screen) && $screen->id == 'lottery_draws' || $screen->id == 'lottery_sites') {  
        return true;  
    } else {  
        return false;  
    }  
} 

// CREATE CUSTOM POST TYPES

add_action( 'init', 'create_lottery_sites' );

function create_lottery_sites() {
register_post_type( 'lottery_sites',
array(
'labels' => array(
'name' => 'Ticket Seller',
'singular_name' => 'Lottery Ticket Seller',
'add_new' => 'Add New',
'add_new_item' => 'Add New Ticket Seller',
'edit' => 'Edit',
'edit_item' => 'Edit Ticket Seller',
'new_item' => 'New Ticket Seller',
'view' => 'View',
'view_item' => 'View Ticket Seller',
'search_items' => 'Search Ticket Seller',
'not_found' => 'No Ticket Seller found',
'not_found_in_trash' =>
'No Ticket Seller found in Trash',
'parent' => 'Parent Ticket Seller'
),
'public' => true,
'exclude_from_search' => false,
'menu_position' => 15,
'supports' => array( 'title', 'comments', 'thumbnail'),
'taxonomies' => array( '' ),
'menu_icon' =>
plugins_url( 'images/le.png', __FILE__ ),
'has_archive' => true,
'rewrite' => array('slug' => 'all-lotteries', 'with_front' => FALSE),
)
);

}

add_action( 'init', 'create_lottery_draws' );

function create_lottery_draws() {
register_post_type( 'lottery_draws',
array(
'labels' => array(
'name' => 'Lottery Draws',
'singular_name' => 'Lottery Draws',
'add_new' => 'Add New',
'add_new_item' => 'Add New Lottery',
'edit' => 'Edit',
'edit_item' => 'Edit Lottery',
'new_item' => 'New Lottery',
'view' => 'View',
'view_item' => 'View Lottery',
'search_items' => 'Search Lottery',
'not_found' => 'No Lottery found',
'not_found_in_trash' =>
'No Lottery found in Trash',
'parent' => 'Parent Lottery'
),
'public' => true,
'exclude_from_search' => false,
'menu_position' => 15,
'supports' => array( 'title', 'comments', 'thumbnail'),
'taxonomies' => array( '' ),
'menu_icon' =>
plugins_url( 'images/le.png', __FILE__ ),
'has_archive' => true,
'rewrite' => array('slug' => 'lottery-draws', 'with_front' => FALSE),
)
);

}
	
//CREATE CUSTOM META BOXES

add_action( 'admin_init', 'lottery_sites_create_metabox' );

function lottery_sites_create_metabox() {
add_meta_box( 'lottery_sites_meta_box', 'Lottery Details', 'lottery_sites_meta_box', 'lottery_sites', 'normal', 'high' );
}

function lottery_sites_meta_box( $lottery_site ) {
$sitename = esc_html( get_post_meta( $lottery_site->ID, 'lottery_sites_sitename', true ) );

$approved_pos = intval( get_post_meta( $lottery_site->ID, 'lottery_sites_approved_pos', true ) );
$approved = intval( get_post_meta( $lottery_site->ID, 'lottery_sites_approved', true ) );
$alexa = intval( get_post_meta( $lottery_site->ID, 'lottery_sites_alexa', true ) );
$othersites = esc_html( get_post_meta( $lottery_site->ID, 'lottery_sites_othersites', true ) );
$domregdate = esc_html( get_post_meta( $lottery_site->ID, 'lottery_sites_domaindate', true ) );
$funding = esc_html( get_post_meta( $lottery_site->ID, 'lottery_sites_funding', true ) );
$langs = esc_html( get_post_meta( $lottery_site->ID, 'lottery_sites_langs', true ) );
$fbpage = esc_html( get_post_meta( $lottery_site->ID, 'lottery_sites_fbpage', true ) );
$twitter = esc_html( get_post_meta( $lottery_site->ID, 'lottery_sites_twitter', true ) );
$afflink = esc_html( get_post_meta( $lottery_site->ID, 'lottery_sites_afflink', true ) );
$revurl = esc_html( get_post_meta( $lottery_site->ID, 'lottery_sites_revurl', true ) );
$ss_url = esc_html( get_post_meta( $lottery_site->ID, 'lottery_sites_screenshot', true ) );

$google_safebrowsing = intval( get_post_meta( $lottery_site->ID, 'lottery_sites_safebrowsing', true ) );
$website_antivirus = intval( get_post_meta( $lottery_site->ID, 'lottery_sites_antivirus', true ) );
$norton_safeweb = intval( get_post_meta( $lottery_site->ID, 'lottery_sites_norton', true ) );
?>
<table>

<tr>
<td style="width: 150px">Approved position in Sidebar:</td>
<td><input type="text" size="80" name="lottery_sites_approved_pos" value="<?php echo $approved_pos; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Approved:</td>
<td>
<select style="width: 120px" name="lottery_sites_approved">
  <option value="1" <?php if($approved == 1) {echo 'selected';} ?>>Approved</option>
  <option value="0" <?php if($approved == 0) {echo 'selected';} ?>>Not Approved</option>
</select> 
</td>
</tr>

<tr>
<td style="width: 150px">Site name:</td>
<td><input type="text" size="80" name="lottery_sites_sitename" value="<?php echo $sitename; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Alexa Rating:</td>
<td><input type="text" size="80" name="lottery_sites_alexa" value="<?php echo $alexa; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Other sites:</td>
<td><input type="text" size="80" name="lottery_sites_othersites" value="<?php echo $othersites; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Domain registration date:</td>
<td><input type="text" size="80" name="lottery_sites_domaindate" value="<?php echo $domregdate; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Funding methods:</td>
<td><input type="text" size="80" name="lottery_sites_funding" value="<?php echo $funding; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Languages:</td>
<td><input id="langs" type="text" size="80" name="lottery_sites_langs" value="<?php echo $langs; ?>" />Hit SPACE to show the full list of languages</td>
</tr>

<tr>
<td style="width: 150px">Facebook Page:</td>
<td><input type="text" size="80" name="lottery_sites_fbpage" value="<?php echo $fbpage; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Twitter:</td>
<td><input type="text" size="80" name="lottery_sites_twitter" value="<?php echo $twitter; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Affiliate Link:</td>
<td><input type="text" size="80" name="lottery_sites_afflink" value="<?php echo $afflink; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Lottery Review URL:</td>
<td><input type="text" size="80" name="lottery_sites_revurl" value="<?php echo $revurl; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Lottery Screenshot URL:</td>
<td><input type="text" size="80" name="lottery_sites_screenshot" value="<?php echo $ss_url; ?>" /></td>
</tr>

<tr>
<td>Lottery Logo:</td>
<td>For Lottery logo, select a Featured image - 58x56px.</td>
</tr>

<tr>
<td style="width: 150px">Google Safebrowsing:</td>
<td>
<select style="width: 120px" name="lottery_sites_safebrowsing">
  <option value="1" <?php if($google_safebrowsing == 1) {echo 'selected';} ?>>Yes</option>
  <option value="0" <?php if($google_safebrowsing == 0) {echo 'selected';} ?>>No</option>
</select> 
</td>
</tr>

<tr>
<td style="width: 150px">Website antivirus:</td>
<td>
<select style="width: 120px" name="lottery_sites_antivirus">
  <option value="1" <?php if($website_antivirus == 1) {echo 'selected';} ?>>Yes</option>
  <option value="0" <?php if($website_antivirus == 0) {echo 'selected';} ?>>No</option>
</select> 
</td>
</tr>

<tr>
<td style="width: 150px">Norton Safeweb:</td>
<td>
<select style="width: 120px" name="lottery_sites_norton">
  <option value="1" <?php if($norton_safeweb == 1) {echo 'selected';} ?>>Yes</option>
  <option value="0" <?php if($norton_safeweb == 0) {echo 'selected';} ?>>No</option>
</select> 
</td>
</tr>

<input type="hidden" name="sites_meta_box_nonce" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />

</table>
<?php }

add_action( 'save_post', 'add_lottery_sites_fields', 10, 2 );

function add_lottery_sites_fields( $lottery_site_id, $lottery_site ) {

	if ( $lottery_site->post_type == 'lottery_sites' ) {
		
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;

		if ( !wp_verify_nonce( $_POST['sites_meta_box_nonce'], plugin_basename( __FILE__ ) ) )
		return $post_id;

		if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;
		
		if ( isset( $_POST['lottery_sites_approved_pos'] ) ) {
		update_post_meta( $lottery_site_id, 'lottery_sites_approved_pos', $_POST['lottery_sites_approved_pos'] );
		}
		
		if ( isset( $_POST['lottery_sites_approved'] ) ) {
		update_post_meta( $lottery_site_id, 'lottery_sites_approved', $_POST['lottery_sites_approved'] );
		}
		
		if ( isset( $_POST['lottery_sites_sitename'] ) ) {
		update_post_meta( $lottery_site_id, 'lottery_sites_sitename', $_POST['lottery_sites_sitename'] );
		}
		
		if ( isset( $_POST['lottery_sites_alexa'] ) ) {
		update_post_meta( $lottery_site_id, 'lottery_sites_alexa', $_POST['lottery_sites_alexa'] );
		}
		
		if ( isset( $_POST['lottery_sites_othersites'] ) ) {
		update_post_meta( $lottery_site_id, 'lottery_sites_othersites', $_POST['lottery_sites_othersites'] );
		}
		
		if ( isset( $_POST['lottery_sites_domaindate'] ) ) {
		update_post_meta( $lottery_site_id, 'lottery_sites_domaindate', $_POST['lottery_sites_domaindate'] );
		}
		
		if ( isset( $_POST['lottery_sites_funding'] ) ) {
		update_post_meta( $lottery_site_id, 'lottery_sites_funding', $_POST['lottery_sites_funding'] );
		}
		
		if ( isset( $_POST['lottery_sites_langs'] ) ) {
		update_post_meta( $lottery_site_id, 'lottery_sites_langs', $_POST['lottery_sites_langs'] );
		}
		
		if ( isset( $_POST['lottery_sites_fbpage'] ) ) {
		update_post_meta( $lottery_site_id, 'lottery_sites_fbpage', $_POST['lottery_sites_fbpage'] );
		}
		
		if ( isset( $_POST['lottery_sites_twitter'] ) ) {
		update_post_meta( $lottery_site_id, 'lottery_sites_twitter', $_POST['lottery_sites_twitter'] );
		}
		
		if ( isset( $_POST['lottery_sites_afflink'] ) ) {
		update_post_meta( $lottery_site_id, 'lottery_sites_afflink', $_POST['lottery_sites_afflink'] );
		}		
		
		if ( isset( $_POST['lottery_sites_revurl'] ) ) {
		update_post_meta( $lottery_site_id, 'lottery_sites_revurl', $_POST['lottery_sites_revurl'] );
		}		
		
		if ( isset( $_POST['lottery_sites_screenshot'] ) ) {
		update_post_meta( $lottery_site_id, 'lottery_sites_screenshot', $_POST['lottery_sites_screenshot'] );
		}	
		
		if ( isset( $_POST['lottery_sites_safebrowsing'] ) ) {
		update_post_meta( $lottery_site_id, 'lottery_sites_safebrowsing', $_POST['lottery_sites_safebrowsing'] );
		}
		
		if ( isset( $_POST['lottery_sites_antivirus'] ) ) {
		update_post_meta( $lottery_site_id, 'lottery_sites_antivirus', $_POST['lottery_sites_antivirus'] );
		}
		
		if ( isset( $_POST['lottery_sites_norton'] ) ) {
		update_post_meta( $lottery_site_id, 'lottery_sites_norton', $_POST['lottery_sites_norton'] );
		}
	}
}

add_action( 'admin_init', 'lottery_draws_create_metabox' );

function lottery_draws_create_metabox() {
add_meta_box( 'lottery_draws_meta_box', 'Lottery Draws', 'lottery_draws_meta_box', 'lottery_draws', 'normal', 'high' );
}

function lottery_draws_meta_box( $lottery_draw ) {
$lottoname = esc_html( get_post_meta( $lottery_draw->ID, 'lottery_draws_lottoname', true ) );
$founded = esc_html( get_post_meta( $lottery_draw->ID, 'lottery_draws_founded', true ) );
$country = esc_html( get_post_meta( $lottery_draw->ID, 'lottery_draws_country', true ) );
$official = esc_html( get_post_meta( $lottery_draw->ID, 'lottery_draws_official', true ) );
$official_url = esc_html( get_post_meta( $lottery_draw->ID, 'lottery_draws_official_url', true ) );
$drawdays = esc_html( get_post_meta( $lottery_draw->ID, 'lottery_draws_drawdays', true ) );
$avgticket = esc_html( get_post_meta( $lottery_draw->ID, 'lottery_draws_avgticket', true ) );
$odds = esc_html( get_post_meta( $lottery_draw->ID, 'lottery_draws_odds', true ) );
$numbers = esc_html( get_post_meta( $lottery_draw->ID, 'lottery_draws_numbers', true ) );
$syn_text = esc_html( get_post_meta( $lottery_draw->ID, 'lottery_draws_syntext', true ) );
$syn_link = esc_html( get_post_meta( $lottery_draw->ID, 'lottery_draws_synlink', true ) );
$jprec = esc_html( get_post_meta( $lottery_draw->ID, 'lottery_draws_jprec', true ) );
$facebook = esc_html( get_post_meta( $lottery_draw->ID, 'lottery_draws_facebook', true ) );
$twitter = esc_html( get_post_meta( $lottery_draw->ID, 'lottery_draws_twitter', true ) );
$youtube = esc_html( get_post_meta( $lottery_draw->ID, 'lottery_draws_youtube', true ) );
$draws_ss = esc_html( get_post_meta( $lottery_draw->ID, 'lottery_draws_ss', true ) );
$graphdata = esc_html( get_post_meta( $lottery_draw->ID, 'lottery_draws_graph', true ) );
?>
<table>

<tr>
<td style="width: 150px">Lottery Name:</td>
<td><input type="text" size="80" name="lottery_draws_lottoname" value="<?php echo $lottoname; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Founded:</td>
<td><input type="text" size="80" name="lottery_draws_founded" value="<?php echo $founded; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Country:</td>
<td><input id="countries" type="text" size="80" name="lottery_draws_country" value="<?php echo $country; ?>" />Hit SPACE to show the full list of languages</td>
</tr>

<tr>
<td style="width: 150px">Official Site:</td>
<td><input type="text" size="80" name="lottery_draws_official" value="<?php echo $official; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Official Site Aff URL:</td>
<td><input type="text" size="80" name="lottery_draws_official_url" value="<?php echo $official_url; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Days of Draw:</td>
<td><input type="text" size="80" name="lottery_draws_drawdays" value="<?php echo $drawdays; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Average ticket price:</td>
<td><input type="text" size="80" name="lottery_draws_avgticket" value="<?php echo $avgticket; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Odds of winning:</td>
<td><input type="text" size="80" name="lottery_draws_odds" value="<?php echo $odds; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Numbers to choose:</td>
<td><input type="text" size="80" name="lottery_draws_numbers" value="<?php echo $numbers; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">The best syndicate:</td>
<td><input type="text" size="80" name="lottery_draws_syntext" value="<?php echo $syn_text; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">The best syndicate URL:</td>
<td><input type="text" size="80" name="lottery_draws_synlink" value="<?php echo $syn_link; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Jackpot Record:</td>
<td><input type="text" size="80" name="lottery_draws_jprec" value="<?php echo $jprec; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Facebook Fanpage:</td>
<td><input type="text" size="80" name="lottery_draws_facebook" value="<?php echo $facebook; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Twitter:</td>
<td><input type="text" size="80" name="lottery_draws_twitter" value="<?php echo $twitter; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Youtube:</td>
<td><input type="text" size="80" name="lottery_draws_youtube" value="<?php echo $youtube; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Lottery Screenshot URL:</td>
<td><input type="text" size="80" name="lottery_draws_ss" value="<?php echo $draws_ss; ?>" /></td>
</tr>

<tr>
<td style="width: 150px">Assign lottery from the graph:</td>
<td>
<select style="width: 120px" name="lottery_draws_graph">
	<option value="mm" <?php if($graphdata == "mm") {echo 'selected';} ?>>Mega Millions</option>
	<option value="pb" <?php if($graphdata == "pb") {echo 'selected';} ?>>Powerball</option>
	<option value="em" <?php if($graphdata == "em") {echo 'selected';} ?>>Euro Millions</option>
	<option value="pa" <?php if($graphdata == "pa") {echo 'selected';} ?>>Powerball Australia</option>
	<option value="hl" <?php if($graphdata == "hl") {echo 'selected';} ?>>Hot Lotto</option>
	<option value="eg" <?php if($graphdata == "eg") {echo 'selected';} ?>>El Gordo</option>
	<option value="fr" <?php if($graphdata == "fr") {echo 'selected';} ?>>France Loto</option>
	<option value="uk" <?php if($graphdata == "uk") {echo 'selected';} ?>>UK National Lottery</option>
	<option value="cs" <?php if($graphdata == "cs") {echo 'selected';} ?>>California SuperLotto</option>
	<option value="oz" <?php if($graphdata == "oz") {echo 'selected';} ?>>Oz Lotto</option>
	<option value="49" <?php if($graphdata == "49") {echo 'selected';} ?>>Lotto 6/49</option>
	<option value="ho" <?php if($graphdata == "ho") {echo 'selected';} ?>>Hoosier Lotto</option>
	<option value="ny" <?php if($graphdata == "ny") {echo 'selected';} ?>>New York Lotto</option>
	<option value="fl" <?php if($graphdata == "fl") {echo 'selected';} ?>>Florida Lotto</option>
	<option value="ms" <?php if($graphdata == "ms") {echo 'selected';} ?>>Mega Sena</option>
	<option value="ie" <?php if($graphdata == "ie") {echo 'selected';} ?>>Irish Lotto</option>
	<option value="tb" <?php if($graphdata == "tb") {echo 'selected';} ?>>Thunderball</option>
	<option value="se" <?php if($graphdata == "se") {echo 'selected';} ?>>Superena Lotto</option>
	<option value="de" <?php if($graphdata == "de") {echo 'selected';} ?>>German Lotto</option>
	<option value="lp" <?php if($graphdata == "lp") {echo 'selected';} ?>>La Primitiva</option>
</select> 
</td>
</tr>

<tr>
<td>Lottery Logo:</td>
<td>For Lottery logo, select a Featured image - 78x78px.</td>
</tr>

<input type="hidden" name="draws_meta_box_nonce" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />

</table>
<?php }

add_action( 'save_post', 'add_lottery_draws_fields', 10, 2 );

function add_lottery_draws_fields( $lottery_draw_id, $lottery_draw ) {

	if ( $lottery_draw->post_type == 'lottery_draws' ) {
		
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;

		if ( !wp_verify_nonce( $_POST['draws_meta_box_nonce'], plugin_basename( __FILE__ ) ) )
		return $post_id;

		if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;
		
		if ( isset( $_POST['lottery_draws_lottoname'] ) ) {
		update_post_meta( $lottery_draw_id, 'lottery_draws_lottoname', $_POST['lottery_draws_lottoname'] );
		}
		
		if ( isset( $_POST['lottery_draws_founded'] ) ) {
		update_post_meta( $lottery_draw_id, 'lottery_draws_founded', $_POST['lottery_draws_founded'] );
		}
		
		if ( isset( $_POST['lottery_draws_country'] ) ) {
		update_post_meta( $lottery_draw_id, 'lottery_draws_country', $_POST['lottery_draws_country'] );
		}
		
		if ( isset( $_POST['lottery_draws_official'] ) ) {
		update_post_meta( $lottery_draw_id, 'lottery_draws_official', $_POST['lottery_draws_official'] );
		}
		
		if ( isset( $_POST['lottery_draws_official_url'] ) ) {
		update_post_meta( $lottery_draw_id, 'lottery_draws_official_url', $_POST['lottery_draws_official_url'] );
		}
		
		if ( isset( $_POST['lottery_draws_drawdays'] ) ) {
		update_post_meta( $lottery_draw_id, 'lottery_draws_drawdays', $_POST['lottery_draws_drawdays'] );
		}
		
		if ( isset( $_POST['lottery_draws_avgticket'] ) ) {
		update_post_meta( $lottery_draw_id, 'lottery_draws_avgticket', $_POST['lottery_draws_avgticket'] );
		}
		
		if ( isset( $_POST['lottery_draws_odds'] ) ) {
		update_post_meta( $lottery_draw_id, 'lottery_draws_odds', $_POST['lottery_draws_odds'] );
		}
		
		if ( isset( $_POST['lottery_draws_numbers'] ) ) {
		update_post_meta( $lottery_draw_id, 'lottery_draws_numbers', $_POST['lottery_draws_numbers'] );
		}
		
		if ( isset( $_POST['lottery_draws_syntext'] ) ) {
		update_post_meta( $lottery_draw_id, 'lottery_draws_syntext', $_POST['lottery_draws_syntext'] );
		}
		
		if ( isset( $_POST['lottery_draws_synlink'] ) ) {
		update_post_meta( $lottery_draw_id, 'lottery_draws_synlink', $_POST['lottery_draws_synlink'] );
		}		
		
		if ( isset( $_POST['lottery_draws_jprec'] ) ) {
		update_post_meta( $lottery_draw_id, 'lottery_draws_jprec', $_POST['lottery_draws_jprec'] );
		}		
		
		if ( isset( $_POST['lottery_draws_facebook'] ) ) {
		update_post_meta( $lottery_draw_id, 'lottery_draws_facebook', $_POST['lottery_draws_facebook'] );
		}	
		
		if ( isset( $_POST['lottery_draws_twitter'] ) ) {
		update_post_meta( $lottery_draw_id, 'lottery_draws_twitter', $_POST['lottery_draws_twitter'] );
		}
		
		if ( isset( $_POST['lottery_draws_youtube'] ) ) {
		update_post_meta( $lottery_draw_id, 'lottery_draws_youtube', $_POST['lottery_draws_youtube'] );
		}
		
		if ( isset( $_POST['lottery_draws_ss'] ) ) {
		update_post_meta( $lottery_draw_id, 'lottery_draws_ss', $_POST['lottery_draws_ss'] );
		}
		if ( isset( $_POST['lottery_draws_graph'] ) ) {
		update_post_meta( $lottery_draw_id, 'lottery_draws_graph', $_POST['lottery_draws_graph'] );
		}
	}
}

//INCLUDE  CUSTOM TEMPLATE FILE

add_filter( 'template_include', 'lottery_sites_include_template', 1 );

function lottery_sites_include_template( $template_path ) {
	if ( get_post_type() == 'lottery_sites' ) {
		if ( is_single() ) {
		// checks if the file exists in the theme first,
		// otherwise serve the file from the plugin
		if ( $theme_file = locate_template( array
		( 'single-lottery_sites.php' ) ) ) {
		$template_path = $theme_file;
		} else {
		$template_path = plugin_dir_path( __FILE__ ) . '/single-lottery_sites.php';
			}
		} elseif ( is_archive() ) {
		
		if ( $theme_file = locate_template( array ( 'archive-lottery_sites.php' ) ) ) {
		$template_path = $theme_file;
		} else {
		$template_path = plugin_dir_path( __FILE__ ) . '/archive-lottery_sites.php';
		}
		
		}
	}
return $template_path;
}

add_filter( 'template_include', 'lottery_draws_include_template', 1 );

function lottery_draws_include_template( $template_path ) {
	if ( get_post_type() == 'lottery_draws' ) {
		if ( is_single() ) {
		// checks if the file exists in the theme first,
		// otherwise serve the file from the plugin
		if ( $theme_file = locate_template( array
		( 'single-lottery_draws.php' ) ) ) {
		$template_path = $theme_file;
		} else {
		$template_path = plugin_dir_path( __FILE__ ) . '/single-lottery_draws.php';
			}
		} elseif ( is_archive() ) {
		
		if ( $theme_file = locate_template( array ( 'archive-lottery_draws.php' ) ) ) {
		$template_path = $theme_file;
		} else {
		$template_path = plugin_dir_path( __FILE__ ) . '/archive-lottery_draws.php';
		}
		
		}
	}
return $template_path;
}

//ADD ALEXA TO WP_CRON

//Delete specific wp_cron schedule
//register_deactivation_hook( __FILE__, 'cron_deactivate' );
 
function cron_deactivate() {
   $timestamp = wp_next_scheduled( 'lottery_alexa_cron_hook' );
   wp_unschedule_event($timestamp, 'lottery_alexa_cron_hook' );
   wp_clear_scheduled_hook( 'lottery_alexa_cron_hook' ); 
}

add_filter( 'cron_schedules', 'lottery_alexa_add_cron_intervals' );
 
function lottery_alexa_add_cron_intervals( $schedules ) {
   $schedules['daily'] = array('interval' => 86400); // Execute it once a day
   return $schedules;
}
 
//add_action( 'lottery_alexa_cron_hook', 'lottery_alexa_exec' );
 
if( !wp_next_scheduled( 'lottery_alexa_cron_hook' ) ) {
   wp_schedule_event( time(), 'daily', 'lottery_alexa_cron_hook' );
}

function alexa_rank($domain)
{
	$domain = urlencode($domain);
    $alexa = "http://data.alexa.com/data?cli=10&dat=snbamz&url=".$domain;

    $xml = simplexml_load_file($alexa);
    if (!$xml) {
        return NULL;
    }
	$sd = $xml->SD[1];
	
	if(!empty($sd)) {
	$nodeAttributes = $xml->SD[1]->POPULARITY->attributes();
	$rank = (string) $nodeAttributes['TEXT'];
	} else {
	$rank = 0;
	}

    return $rank;
}

function wot_rating($domain)
{
	$domain = urlencode($domain);
    $wot = "http://api.mywot.com/0.4/public_query2?target=".$domain;

    $xml = simplexml_load_file($wot);
    if (!$xml) {
        return NULL;
    }
	
	$r_trustworthiness = (int)$xml->application[0]['r'];
	$r_reliability = (int)$xml->application[1]['r'];
	$r_privacy = (int)$xml->application[2]['r'];
	$r_child_safety = (int)$xml->application[3]['r'];
	
	$c_trustworthiness = (int)$xml->application[0]['c'];
	$c_reliability = (int)$xml->application[1]['c'];
	$c_privacy = (int)$xml->application[2]['c'];
	$c_child_safety = (int)$xml->application[3]['c'];
	
	$wot = array('r0' => $r_trustworthiness, 'r1' => $r_reliability, 'r2' => $r_privacy, 'r4' => $r_child_safety, 'c0' => $c_trustworthiness, 'c1' => $c_reliability, 'c2' => $c_privacy, 'c4' => $c_child_safety, );

    return $wot;
}

function lottery_alexa_exec() {
	
	$posts_array = get_posts(array('post_type' => 'lottery_sites', 'numberposts' => -1));
	
	foreach ($posts_array as $post) {
	$post_id = $post->ID;
	$domain = trim(get_post_meta($post_id, 'lottery_sites_sitename', true));
		if (!empty($domain)) {
		$alexa_rank = alexa_rank($domain);
		update_post_meta($post_id, 'lottery_sites_alexa', $alexa_rank);
		/*
		$wot_meta = get_post_meta($post_id, 'lottery_sites_wot', true);
		$wot_rating = wot_rating($domain);
		
		if(!empty($wot_meta)) {
		update_post_meta($post_id, 'lottery_sites_wot', $wot_rating);
		} else {
		add_post_meta($post_id, 'lottery_sites_wot', $wot_rating);
		}
		
		sleep(10);
		*/
		}
	}
}
