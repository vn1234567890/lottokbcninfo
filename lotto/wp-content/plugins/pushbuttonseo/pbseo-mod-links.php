<?php function pb1l5q( $pb1O79 = FALSE_BOOL_DEFINE, $pb1l7a = TRUE_BOOL_DEFINE ) {
	if ( ! pb1O3u( pb1O1 ) ) {
		return '';
	}
	global $wpdb;
	global $post;
	$pb1O7a = array();
	if ( TRUE_BOOL_DEFINE === $pb1l7a ) {
		$pb1l7b = trim_wrapper( get_option_wrapper( pbseo_opt_DEFINE . "homepage_keyword" ) );
		if ( empty( $pb1l7b ) ) {
			$pb1l7b = pb1O35( "name" );
		}
		$pb1O7a[] = array( 'type' => 'home', 'title' => pb1O7b( $pb1l7b ), 'permalink' => site_url() );
	}
	$pb1l2h = get_option_wrapper( pbseo_opt_DEFINE . "post_types" );
	if ( empty( $pb1l2h ) || ( ! is_array( $pb1l2h ) ) ) {
		$pb1l7c = "('post','page')";
	} else {
		$pb1l7c = "(";
		foreach ( $pb1l2h as $pb1O2q => $pb1l2r ) {
			$pb1l2h[ $pb1O2q ] = "'" . pb1O2p( $pb1l2r ) . "'";
		}
		$pb1l7c .= implode( ",", $pb1l2h );
		$pb1l7c .= ")";
	}
	unset ( $pb1l2h );
	$pb1O2e = "SELECT p.post_type, p.post_title, p.ID ";
	$pb1O2e .= "FROM " . $wpdb->prefix . "posts AS p, " . $wpdb->prefix . "postmeta AS pm WHERE ";
	$pb1O2e .= "p.ID = pm.post_id ";
	$pb1O2e .= "AND p.ID <> " . intval( $post->ID ) . " ";
	$pb1O2e .= "AND pm.meta_key = '" . _pbseo_meta_DEFINE . "links_seo_target' AND pm.meta_value = '1' ";
	$pb1O2e .= "AND p.post_status = 'publish' AND ( p.post_type IN " . $pb1l7c . " ) ";
	$pb1O2e .= "AND p.post_date < NOW() ORDER BY p.post_type ASC ";
	$pb1O7c = $wpdb->get_results( $pb1O2e, OBJECT );
	$pb1l7d = array();
	if ( $pb1O7c ) {
		foreach ( $pb1O7c as $pb1O2q => $pb1l5h ) {
			$pb1O7d   = get_permalink( $pb1l5h->ID );
			$pb1O7a[] = array( 'type' => $pb1l5h->post_type, 'title' => $pb1l5h->post_title, 'permalink' => $pb1O7d, );
		}
	}
	$pb1l7e = get_categories();
	foreach ( $pb1l7e as $pb1O2q => $pb1l5h ) {
		$pb1O7d   = get_category_link( $pb1l5h->cat_ID );
		$pb1O7a[] = array( 'type' => 'catg', 'title' => $pb1l5h->cat_name, 'permalink' => $pb1O7d, );
	}
	$pb1O4x = '';
	$pb1l5u = 0;
	$pb1O5u = '#fff';
	foreach ( $pb1O7a as $pb1O2q => $pb1l5w ) {
		$pb1O7e = $pb1l5w['title'];
		$pb1l7f = $pb1l5w['permalink'];
		$pb1O7f = pb1l1q( $pb1l5w['type'] );
		if ( ( "CATG" == $pb1O7f ) && ( "uncategorized" == pb1O2p( $pb1O7e ) ) ) {
			continue;
		}
		$pb1l5u ++;
		if ( $pb1O5u == '#fff' ) {
			$pb1O5u = '#f5f5f5';
		} else {
			$pb1O5u = '#fff';
		}
		$pb1O4x .= "<tr valign=\"top\">";
		$pb1O4x .= "<td width=\"38px;\" class=\"pbseo_results_row\" style=\"background:" . $pb1O5u . ";\">";
		$pb1O4x .= "<small class=\"pbseo_links_type\">";
		$pb1O4x .= pb_htmlspecialchars( pb1O1q( $pb1O7f, 0, 4 ) );
		$pb1O4x .= "</small>";
		$pb1O4x .= "</td>";
		$pb1O4x .= "<td width=\"14px;\" class=\"pbseo_results_row\" style=\"background:" . $pb1O5u . ";\">";
		$pb1O4x .= "<a href=\"" . pb_htmlspecialchars( $pb1l7f ) . "\" target=\"_blank\">";
		$pb1O4x .= "<img class=\"pbseo_link_external\" src=\"" . pb1l1l . "img/icon-external.png?x=1\" />";
		$pb1O4x .= "</a>";
		$pb1O4x .= "</td>";
		$pb1O4x .= "<td class=\"pbseo_results_row\" style=\"background:" . $pb1O5u . ";\">";
		$pb1O4x .= "<a class=\"pbseo_links_insert\" title=\"" . pb_htmlspecialchars( $pb1O7e ) . "\" href=\"" . pb_htmlspecialchars( $pb1l7f ) . "\">";
		$pb1O4x .= pb_htmlspecialchars( $pb1O7e );
		$pb1O4x .= "</a>";
		$pb1O4x .= "</td>";
		$pb1O4x .= "</tr>";
	}
	if ( $pb1l5u > 0 ) {
		echo "<table width=\"100%\" class=\"pbseo_links_table\">" . $pb1O4x . "</table>";
	} else {
		echo "<p class=\"pbseo_ajax_error\">" . __( "No results found", PluginTextDomain_DEFINE ) . "</p>";
	}
} ?>