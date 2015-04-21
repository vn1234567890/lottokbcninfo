<?php function pbseo_plugin_activate() {
	global $wpdb;
	if ( $wpdb->get_var( "SHOW TABLES LIKE '" . $wpdb->prefix . pb1lv . "'" ) != $wpdb->prefix . pb1lv ) {
		$pb1O2e = "CREATE TABLE " . $wpdb->prefix . pb1lv . " ( ";
		$pb1O2e .= pb1Ou . "id char(32) NOT NULL, ";
		$pb1O2e .= pb1Ou . "post_id int(10) unsigned NOT NULL, ";
		$pb1O2e .= pb1Ou . "term varchar(127), ";
		$pb1O2e .= pb1Ou . "term_count int(10) unsigned NOT NULL, ";
		$pb1O2e .= pb1Ou . "last_search int(10) unsigned NOT NULL, ";
		$pb1O2e .= "PRIMARY KEY (" . pb1Ou . "id, " . pb1Ou . "post_id), ";
		$pb1O2e .= "KEY " . pb1Ou . "post_id (" . pb1Ou . "post_id) ";
		$pb1O2e .= ") ";
		if ( FALSE === $wpdb->query( $pb1O2e ) ) {
			write_log( __( "Incoming search database table could not be created", PluginTextDomain_DEFINE ) );
		} else {
			update_option_wrapper( pbseo_opt_DEFINE . "incoming_search_active", TRUE_BOOL_DEFINE );
		}
		unset ( $pb1O2e );
	} else {
		update_option_wrapper( pbseo_opt_DEFINE . "incoming_search_active", TRUE_BOOL_DEFINE );
	}
	$pb1O2e = "DELETE FROM " . $wpdb->prefix . "options ";
	$pb1O2e .= "WHERE option_name LIKE '%" . pbseo_trans_DEFINE . "%'";
	$wpdb->query( $pb1O2e );
	$pb1O2e = "DELETE FROM " . $wpdb->prefix . "postmeta ";
	$pb1O2e .= "WHERE meta_key = '_pbseo_meta_incoming_search'";
	$wpdb->query( $pb1O2e );
}

function pbseo_plugin_deactivate() {
	pb1O2f( pbseo_opt_DEFINE . "incoming_search_active" );
	global $wpdb;
	$pb1O2e = "DELETE FROM " . $wpdb->prefix . "options ";
	$pb1O2e .= "WHERE option_name LIKE '%" . pbseo_trans_DEFINE . "%'";
	$wpdb->query( $pb1O2e );
}

function pbseo_add_plugin_menu() {
	if ( pb1l2g( "manage_options" ) ) {
		$pb1O2g = add_menu_page( PushButtonSEO_DEFINE . " Options v" . pb1Oc, PushButtonSEO_DEFINE, "manage_options", pb1l24, "pbseo_plugin_settings_screen", pb1l1l . "img/pushbutton-seo-icon.png" );
		$pb1O2g = add_submenu_page( pb1Ob, PushButtonSEO_DEFINE . " Options v" . pb1Oc, __( "General Settings", PluginTextDomain_DEFINE ), "manage_options", pb1l24, "pbseo_plugin_settings_screen" );
		$pb1O2g = add_submenu_page( pb1Ob, PushButtonSEO_DEFINE . " Training and Support", __( "Training and Support", PluginTextDomain_DEFINE ), "manage_options", pb1O24, "pbseo_plugin_training_screen" );
	}
}

function pbseo_register_admin_settings() {
	if ( pb1l2g( "manage_options" ) ) {
		register_setting( "pbseo_options_general", pbseo_opt_DEFINE . "activation_code", "pbseo_options_sanitize_activation_code" );
		register_setting( "pbseo_options_optimizer", pbseo_opt_DEFINE . "enable_warnings" );
		register_setting( "pbseo_options_optimizer", pbseo_opt_DEFINE . "disable_autosave_warning" );
		register_setting( "pbseo_options_optimizer", pbseo_opt_DEFINE . "proximity_threshold", "pbseo_options_sanitize_proximity_threshold" );
		register_setting( "pbseo_options_links", pbseo_opt_DEFINE . "homepage_keyword" );
		register_setting( "pbseo_options_content", pbseo_opt_DEFINE . "flickr_api" );
		register_setting( "pbseo_options_content", pbseo_opt_DEFINE . "content_region", "pbseo_options_sanitize_content_region" );
	}
}

function pbseo_init_post_meta_panel() {
	if ( pb1l2g( "edit_posts" ) ) {
		$pb1l2h = get_option_wrapper( pbseo_opt_DEFINE . "post_types" );
		foreach ( $pb1l2h as $pb1O2h ) {
			add_meta_box( "pbseo_meta_panel", PushButtonSEO_DEFINE, "pbseo_meta_panel", $pb1O2h, "side", "high" );
		}
	}
}

function pbseo_include_javascript() {
	pb1l2i( pb1Ob . "-js-shared", pb1l1l . "js/admin-shared" . ( TRUE_BOOL_DEFINE !== pb1l0 ? ".min" : "" ) . ".js", array( "jquery" ), pb1Oc );
	pb1O2i( pb1Ob . "-js-shared" );
	if ( isset ( $_REQUEST["page"] ) && ( ( pb1l24 == $_REQUEST["page"] ) || ( pb1O24 == $_REQUEST["page"] ) ) ) {
		pb1l2i( pb1Ob . "-js-settings", pb1l1l . "js/admin-settings" . ( TRUE_BOOL_DEFINE !== pb1l0 ? ".min" : "" ) . ".js", array( "jquery" ), pb1Oc );
		pb1O2i( pb1Ob . "-js-settings" );
	}
	$pb1l2j = ( basename( $_SERVER["SCRIPT_FILENAME"] ) );
	if ( ( "post.php" == $pb1l2j ) || ( "post-new.php" == $pb1l2j ) || ( "page.php" == $pb1l2j ) || ( "page-new.php" == $pb1l2j ) ) {
		pb1l2i( pb1Ob . "-js-meta", pb1l1l . "js/admin-meta" . ( TRUE_BOOL_DEFINE !== pb1l0 ? ".min" : "" ) . ".js", array( "jquery" ), pb1Oc );
		pb1O2i( pb1Ob . "-js-meta" );
	}
}

function pbseo_include_javascript_header() {
	$pb1O2j = wp_create_nonce( pb1Of );
	echo "<script type=\"text/javascript\">";
	echo "var " . pb1Of . "='" . $pb1O2j . "'; ";
	echo "var pbseo_close='" . __( "Close", PluginTextDomain_DEFINE ) . "';";
	if ( "1" == get_option_wrapper( pbseo_opt_DEFINE . "disable_autosave_warning", "0" ) ) {
		echo "var pbseo_daw=true;";
	} else {
		echo "var pbseo_daw=false;";
	}
	echo "</script>\n";
}

function pbseo_include_stylesheets() {
	$pb1l2j = ( basename( $_SERVER["SCRIPT_FILENAME"] ) );
	if ( ( isset ( $_REQUEST["page"] ) && ( ( pb1l24 == $_REQUEST["page"] ) || ( pb1O24 == $_REQUEST["page"] ) ) ) || ( ( "post.php" == $pb1l2j ) || ( "post-new.php" == $pb1l2j ) || ( "page.php" == $pb1l2j ) || ( "page-new.php" == $pb1l2j ) ) || ( ( "edit.php" == $pb1l2j ) ) ) {
		pb1l2k( pb1Ob . "-css-admin", pb1l1l . "css/admin" . ( TRUE_BOOL_DEFINE !== pb1l0 ? ".min" : "" ) . ".css", array(), pb1Oc );
		pb1O2k( pb1Ob . "-css-admin" );
	}
}

function pb1l2l() {
	$pb1O2l = check_ajax_referer( pb1Of, "pbseo_ajax_nonce", FALSE_BOOL_DEFINE );
	if ( FALSE_BOOL_DEFINE === $pb1O2l ) {
		write_log( __( "Access denied" ) . " : " . __FUNCTION__ );
		echo "<p class=\"pbseo_ajax_error\">" . __( "Denied", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
}

function pb1l2m( $pb1O2m, $pb1l2n = array(), $pb1O2n = pb1Ok, $pb1l2o = TRUE_BOOL_DEFINE ) {
	$pb1O2o = FALSE_BOOL_DEFINE;
	$pb1l2p = FALSE_BOOL_DEFINE;
	if ( is_array( $pb1l2n ) ) {
		if ( ! empty( $pb1l2n ) ) {
			if ( isset ( $pb1l2n["expected_content_type"] ) ) {
				$pb1O2o = trim_wrapper( pb1O2p( $pb1l2n["expected_content_type"] ) );
				unset ( $pb1l2n["expected_content_type"] );
			}
			if ( isset ( $pb1l2n["cache_response"] ) ) {
				$pb1l2p = (bool) $pb1l2n["cache_response"];
				unset ( $pb1l2n["cache_response"] );
			}
			$pb1l2q = array();
			foreach ( $pb1l2n as $pb1O2q => $pb1l2r ) {
				$pb1O2q   = (string) $pb1O2q;
				$pb1l2r   = (string) $pb1l2r;
				$pb1O2q   = urlencode( trim_wrapper( $pb1O2q ) );
				$pb1l2r   = urlencode( trim_wrapper( $pb1l2r ) );
				$pb1l2q[] = $pb1O2q . "=" . $pb1l2r;
			}
			$pb1l2n = implode( "&", $pb1l2q );
			unset ( $pb1l2q );
		} else {
			$pb1l2n = '';
		}
	} else {
		$pb1l2n = '';
	}
	if ( ! empty( $pb1l2n ) ) {
		if ( FALSE_BOOL_DEFINE !== pb1O2r( $pb1O2m, "?" ) ) {
			$pb1O2m .= "&" . $pb1l2n;
		} else {
			$pb1O2m .= "?" . $pb1l2n;
		}
	}
	unset ( $pb1l2n );
	if ( TRUE_BOOL_DEFINE === $pb1l2p ) {
		$pb1l2s = pbseo_trans_DEFINE . md5( $pb1O2m . pb1Oc );
		$pb1O2s = pb1l2t( $pb1l2s );
		if ( FALSE_BOOL_DEFINE !== $pb1O2s ) {
			return $pb1O2s;
		}
		unset ( $pb1l2s, $pb1O2s );
	}
	$pb1O2t = array( "timeout" => $pb1O2n, "redirection" => 5, "httpversion" => "1.0", "user-agent" => pb1l2u(), "blocking" => $pb1l2o, "headers" => array(), "cookies" => array(), "sslverify" => FALSE_BOOL_DEFINE, );
	pb1le( array( "url" => $pb1O2m, "params" => $pb1O2t ), "REMOTE REQUEST", __FUNCTION__, TRUE_BOOL_DEFINE );
	pb1le( array( "method" => "GET", "url" => $pb1O2m, "payload" => $pb1O2t ), "REMOTE REQUEST", __FUNCTION__, TRUE_BOOL_DEFINE );
	try {
		$pb1O2u = wp_remote_get( $pb1O2m, $pb1O2t );
		if ( is_wp_error( $pb1O2u ) ) {
			$pb1l2v = $pb1O2u->get_error_message();
			write_log( print_r( array( "error" => $pb1l2v, "request" => $pb1O2m, "params" => $pb1O2t ), TRUE_BOOL_DEFINE ), TRUE_BOOL_DEFINE );

			return FALSE_BOOL_DEFINE;
		} else if ( ( isset ( $pb1O2u["response"]["code"] ) ) && ( $pb1O2u["response"]["code"] < 0454 ) ) {
			if ( FALSE_BOOL_DEFINE !== $pb1O2o ) {
				if ( isset ( $pb1O2u["headers"]["content-type"] ) ) {
					$pb1O2v = trim_wrapper( pb1O2p( $pb1O2u["headers"]["content-type"] ) );
					if ( FALSE_BOOL_DEFINE === pb1O2r( $pb1O2v, $pb1O2o ) ) {
						write_log( print_r( array( "error" => __( "Remote response is unexpected content type", PluginTextDomain_DEFINE ) . '. ' . __( "Expected", PluginTextDomain_DEFINE ) . ' ' . $pb1O2o . ' ' . __( "recieved", PluginTextDomain_DEFINE ) . ' ' . $pb1O2v, "request" => $pb1O2m, "params" => $pb1O2t, "response" => $pb1O2u ), TRUE_BOOL_DEFINE ), TRUE_BOOL_DEFINE );

						return FALSE_BOOL_DEFINE;
					}
				} else {
					write_log( print_r( array( "error" => __( "Remote response is unknown content type", PluginTextDomain_DEFINE ) . '. ' . __( "Expected", PluginTextDomain_DEFINE ) . ' ' . $pb1O2o, "request" => $pb1O2m, "params" => $pb1O2t, "response" => $pb1O2u ), TRUE_BOOL_DEFINE ), TRUE_BOOL_DEFINE );

					return FALSE_BOOL_DEFINE;
				}
			}
			if ( TRUE_BOOL_DEFINE === $pb1l2p ) {
				$pb1l2s = pbseo_trans_DEFINE . md5( $pb1O2m . pb1Oc );
				pb1l2w( $pb1l2s, $pb1O2u["body"], pb1Oh );
				unset ( $pb1l2s );
			}

			return trim_wrapper( $pb1O2u["body"] );
		}
	} catch ( exception $pb1O2w ) {
		write_log( print_r( array( "error" => $pb1O2w->getmessage(), "request" => $pb1O2m, "params" => $pb1O2t, "response" => $pb1O2u ), TRUE_BOOL_DEFINE ), TRUE_BOOL_DEFINE );

		return FALSE_BOOL_DEFINE;
	}
	write_log( print_r( array( "error" => __( "Unspecified error", PluginTextDomain_DEFINE ), "request" => $pb1O2m, "params" => $pb1O2t, "response" => $pb1O2u ), TRUE_BOOL_DEFINE ), TRUE_BOOL_DEFINE );

	return FALSE_BOOL_DEFINE;
}

function pb1l2x( $pb1O2m, $pb1l2n = array(), $pb1O2n = pb1Ok, $pb1l2o = TRUE_BOOL_DEFINE ) {
	$pb1O2o = FALSE_BOOL_DEFINE;
	$pb1l2p = FALSE_BOOL_DEFINE;
	if ( is_array( $pb1l2n ) ) {
		if ( ! empty( $pb1l2n ) ) {
			if ( isset ( $pb1l2n["expected_content_type"] ) ) {
				$pb1O2o = trim_wrapper( pb1O2p( $pb1l2n["expected_content_type"] ) );
				unset ( $pb1l2n["expected_content_type"] );
			}
			if ( isset ( $pb1l2n["cache_response"] ) ) {
				$pb1l2p = (bool) $pb1l2n["cache_response"];
				unset ( $pb1l2n["cache_response"] );
				if ( TRUE_BOOL_DEFINE === $pb1l2p ) {
					$pb1O2x = md5( implode( '', $pb1l2n ) );
				}
			}
		} else {
			$pb1l2n = array();
		}
	} else {
		$pb1l2n = array();
	}
	if ( TRUE_BOOL_DEFINE === $pb1l2p ) {
		$pb1l2s = pbseo_trans_DEFINE . md5( $pb1O2m . $pb1O2x . pb1Oc );
		$pb1O2s = pb1l2t( $pb1l2s );
		if ( FALSE_BOOL_DEFINE !== $pb1O2s ) {
			return $pb1O2s;
		}
		unset ( $pb1l2s, $pb1O2s );
	}
	$pb1O2t = array( "timeout" => $pb1O2n, "redirection" => 5, "httpversion" => "1.0", "user-agent" => pb1l2u(), "blocking" => $pb1l2o, "headers" => array(), "cookies" => array(), "sslverify" => FALSE_BOOL_DEFINE, "body" => $pb1l2n, );
	pb1le( array( "url" => $pb1O2m, "params" => $pb1O2t ), "REMOTE REQUEST", __FUNCTION__, TRUE_BOOL_DEFINE );
	pb1le( array( "method" => "POST", "url" => $pb1O2m, "payload" => $pb1O2t ), "REMOTE REQUEST", __FUNCTION__, TRUE_BOOL_DEFINE );
	try {
		$pb1O2u = wp_remote_post( $pb1O2m, $pb1O2t );
		if ( is_wp_error( $pb1O2u ) ) {
			$pb1l2v = $pb1O2u->get_error_message();
			write_log( print_r( array( "error" => $pb1l2v, "request" => $pb1O2m, "params" => $pb1O2t ), TRUE_BOOL_DEFINE ), TRUE_BOOL_DEFINE );

			return FALSE_BOOL_DEFINE;
		} else if ( ( isset ( $pb1O2u["response"]["code"] ) ) && ( $pb1O2u["response"]["code"] < 0454 ) ) {
			if ( FALSE_BOOL_DEFINE !== $pb1O2o ) {
				if ( isset ( $pb1O2u["headers"]["content-type"] ) ) {
					$pb1O2v = trim_wrapper( pb1O2p( $pb1O2u["headers"]["content-type"] ) );
					if ( FALSE_BOOL_DEFINE === pb1O2r( $pb1O2v, $pb1O2o ) ) {
						write_log( print_r( array( "error" => __( "Remote response is unexpected content type", PluginTextDomain_DEFINE ) . '. ' . __( "Expected", PluginTextDomain_DEFINE ) . ' ' . $pb1O2o . ' ' . __( "recieved", PluginTextDomain_DEFINE ) . ' ' . $pb1O2v, "request" => $pb1O2m, "params" => $pb1O2t, "response" => $pb1O2u ), TRUE_BOOL_DEFINE ), TRUE_BOOL_DEFINE );

						return FALSE_BOOL_DEFINE;
					}
				} else {
					write_log( print_r( array( "error" => __( "Remote response is unknown content type", PluginTextDomain_DEFINE ) . '. ' . __( "Expected", PluginTextDomain_DEFINE ) . ' ' . $pb1O2o, "request" => $pb1O2m, "params" => $pb1O2t, "response" => $pb1O2u ), TRUE_BOOL_DEFINE ), TRUE_BOOL_DEFINE );

					return FALSE_BOOL_DEFINE;
				}
			}
			if ( TRUE_BOOL_DEFINE === $pb1l2p ) {
				$pb1l2s = pbseo_trans_DEFINE . md5( $pb1O2m . $pb1O2x . pb1Oc );
				pb1l2w( $pb1l2s, $pb1O2u["body"], pb1Oh );
				unset ( $pb1l2s );
			}

			return trim_wrapper( $pb1O2u["body"] );
		}
	} catch ( exception $pb1O2w ) {
		write_log( print_r( array( "error" => $pb1O2w->getmessage(), "request" => $pb1O2m, "params" => $pb1O2t, "response" => $pb1O2u ), TRUE_BOOL_DEFINE ), TRUE_BOOL_DEFINE );

		return FALSE_BOOL_DEFINE;
	}
	write_log( print_r( array( "error" => __( "Unspecified error", PluginTextDomain_DEFINE ), "request" => $pb1O2m, "params" => $pb1O2t, "response" => $pb1O2u ), TRUE_BOOL_DEFINE ), TRUE_BOOL_DEFINE );

	return FALSE_BOOL_DEFINE;
}

function pbseo_wp_get_post_types() {
	$pb1l2h = array( "post", "page" );
	$pb1l2y = array( 'public' => TRUE, '_builtin' => FALSE );
	$pb1O2y = 'names';
	$pb1l2z = 'and';
	$pb1O2z = get_post_types( $pb1l2y, $pb1O2y, $pb1l2z );
	foreach ( $pb1O2z as $pb1O2h ) {
		$pb1l2h[] = $pb1O2h;
	}
	update_option_wrapper( pbseo_opt_DEFINE . "post_types", $pb1l2h );
} ?>