<?php function pb1le( $pb1l30 = FALSE_BOOL_DEFINE, $pb1O30 = '', $pb1l31 = FALSE_BOOL_DEFINE, $pb1O31 = TRUE_BOOL_DEFINE ) {
	if ( FALSE_BOOL_DEFINE === pb1le ) {
		return;
	}
	if ( FALSE_BOOL_DEFINE === $pb1O31 ) {
		return;
	}
	if ( ( defined( "pb1l22" ) ) && ( FALSE_BOOL_DEFINE !== pb1l22 ) ) {
		$pb1l32 = date( "c U" ) . " : ";
		$pb1l32 .= $_SERVER["REQUEST_URI"] . " : ";
		$pb1l32 .= ( ( FALSE_BOOL_DEFINE !== $pb1l31 ) ? $pb1l31 : "-" ) . "\n";
		$pb1l32 .= "LABEL: " . $pb1O30 . " - VALUE: ";
		if ( is_array( $pb1l30 ) || is_object( $pb1l30 ) ) {
			$pb1l30 = print_r( $pb1l30, TRUE );
		}
		$pb1l32 .= $pb1l30 . "\n\n";
		@error_log( $pb1l32, 3, pb1l22 );
		unset ( $pb1l32 );
	}
}

function write_log( $pb1l30 = FALSE_BOOL_DEFINE, $pb1O32 = FALSE_BOOL_DEFINE ) {
	if ( FALSE_BOOL_DEFINE === $pb1l30 ) {
		$pb1l30 = __( "Unspecified error", PluginTextDomain_DEFINE );
	}
	if ( ( defined( "pb1l21" ) ) && ( FALSE_BOOL_DEFINE !== pb1l21 ) ) {
		@error_log( date( "c U" ) . " : " . $_SERVER["REQUEST_URI"] . " : " . $pb1l30 . "\n", 3, pb1l21 );
	}
	if ( FALSE_BOOL_DEFINE === $pb1O32 ) {
		@error_log( "PushButton SEO " . __( "Error", PluginTextDomain_DEFINE ) . " : " . $pb1l30 );
	}
}

function pb1O20() {
	if ( defined( "pb1l20" ) ) {
		return pb1l20;
	}
	if ( FALSE_BOOL_DEFINE === pb1l1z ) {
		return FALSE_BOOL_DEFINE;
	}
	$pb1l33 = plugin_dir_path_DEFINE . "temp";
	if ( ! @file_exists( $pb1l33 ) ) {
		$pb1O33 = @mkdir( $pb1l33, 0700 );
		if ( FALSE_BOOL_DEFINE === $pb1O33 ) {
			return FALSE_BOOL_DEFINE;
		}
	}

	return pb1l34( $pb1l33 );
}

function pb1O21() {
	if ( defined( "pb1l21" ) ) {
		return pb1l21;
	}
	if ( defined( "pb1l20" ) && ( FALSE_BOOL_DEFINE !== pb1l20 ) ) {
		$pb1O34 = pb1l20 . "log";
		if ( ! @file_exists( $pb1O34 ) ) {
			$pb1O33 = @file_put_contents( $pb1O34, "PushButton SEO " . __( "Log File Created", PluginTextDomain_DEFINE ) . " : " . date( "c" ) . "\n" );
			if ( FALSE_BOOL_DEFINE !== $pb1O33 ) {
				return $pb1O34;
			}
		} else {
			return $pb1O34;
		}
	}

	return FALSE_BOOL_DEFINE;
}

function pb1O22() {
	if ( defined( "pb1l22" ) ) {
		return pb1l22;
	}
	if ( defined( "pb1l20" ) && ( FALSE_BOOL_DEFINE !== pb1l20 ) ) {
		$pb1l35 = pb1l20 . "debug";
		if ( ! @file_exists( $pb1l35 ) ) {
			$pb1O33 = @file_put_contents( $pb1l35, "PushButton SEO " . __( "Debug File Created", PluginTextDomain_DEFINE ) . " : " . date( "c" ) . "\n" );
			if ( FALSE_BOOL_DEFINE !== $pb1O33 ) {
				return $pb1l35;
			}
		} else {
			return $pb1l35;
		}
	}

	return FALSE_BOOL_DEFINE;
}

function pb1O1z() {
	if ( defined( "pb1l1z" ) ) {
		return pb1l1z;
	}
	if ( @is_writable( plugin_dir_path_DEFINE ) ) {
		return TRUE_BOOL_DEFINE;
	}

	return FALSE_BOOL_DEFINE;
}

function pb1O1j() {
	if ( defined( "pb1l1j" ) ) {
		return pb1l1j;
	}
	if ( defined( "ABSPATH" ) && function_exists_wrapper( "get_bloginfo" ) ) {
		return TRUE_BOOL_DEFINE;
	}

	return FALSE_BOOL_DEFINE;
}

function pb1O1m() {
	if ( defined( "pb1l1m" ) ) {
		return pb1l1m;
	}
	$pb1O33 = pb1O35( "version" );
	if ( FALSE_BOOL_DEFINE !== $pb1O33 ) {
		$pb1O33 = floatval( $pb1O33 );
		if ( pb1On <= $pb1O33 ) {
			return TRUE_BOOL_DEFINE;
		}
	}

	return FALSE_BOOL_DEFINE;
}

function pb1l2u() {
	$pb1l36 = "HTTP_USER_AGENT";
	if ( isset ( $_SERVER[ $pb1l36 ] ) && pb_string_length( trim_wrapper( $_SERVER[ $pb1l36 ] ) ) ) {
		$pb1l37 = $_SERVER[ $pb1l36 ];
	} else {
		$pb1l37 = "Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; en-US; rv:1.9.2.10) Gecko/20100914 Firefox/3.6.10";
	}

	return $pb1l37;
}

function pb1O37( $pb1O2m, $pb1l2n = array(), $pb1l38 = "GET", $pb1O2n = pb1Ok, $pb1l2o = TRUE_BOOL_DEFINE ) {
	$pb1O2m = str_replace( '&amp;', '&', urldecode( trim_wrapper( $pb1O2m ) ) );
	if ( ! @preg_match( '/^http[s]?:/i', $pb1O2m ) ) {
		if ( @file_exists( $pb1O2m ) ) {
			$pb1O2u = @file_get_contents( $pb1O2m );
			if ( FALSE_BOOL_DEFINE === $pb1O2u ) {
				write_log( __( "Failed to retrieve local file", PluginTextDomain_DEFINE ) . ' ' . $pb1O2m );

				return FALSE_BOOL_DEFINE;
			} else {
				return $pb1O2u;
			}
		} else {
			write_log( __( "Failed to locate local file", PluginTextDomain_DEFINE ) . ' ' . $pb1O2m );

			return FALSE_BOOL_DEFINE;
		}
	}
	$pb1l38 = pb1l1q( $pb1l38 );
	if ( "POST" == $pb1l38 ) {
		return pb1l2x( $pb1O2m, $pb1l2n, $pb1O2n, $pb1l2o );
	} else {
		pb1le( $pb1O2m . print_r( $pb1l2n, TRUE ), "REMOTE REQUEST TO", __FUNCTION__, TRUE_BOOL_DEFINE );

		return pb1l2m( $pb1O2m, $pb1l2n, $pb1O2n, $pb1l2o );
	}
}

function pb1O23() {
	$pb1O38 = "host";
	$pb1l39 = pb1O39( pb1l1l );
	if ( isset ( $pb1l39[ $pb1O38 ] ) ) {
		return $pb1l39[ $pb1O38 ];
	} else {
		return FALSE_BOOL_DEFINE;
	}
}

function pb1O1x( $pb1l2r ) {
	if ( empty( $pb1l2r ) ) {
		return TRUE_BOOL_DEFINE;
	}
	if ( is_string( $pb1l2r ) ) {
		$pb1l3a = trim_wrapper( pb1O2p( $pb1l2r ) );
		if ( ( "no" == $pb1l3a ) || ( "off" == $pb1l3a ) || ( "false" == $pb1l3a ) ) {
			return TRUE_BOOL_DEFINE;
		}
	}

	return FALSE_BOOL_DEFINE;
}

function pb1l1t( $pb1O1r = FALSE_BOOL_DEFINE ) {
	$pb1O3a = array(
		"AR-AR-ME" => __( "Arabic", PluginTextDomain_DEFINE ),
		"CS-CS-CZ" => __( "Czech", PluginTextDomain_DEFINE ),
		"NL-NL-NL" => __( "Dutch", PluginTextDomain_DEFINE ),
		"EN-EN-AU" => __( "English", PluginTextDomain_DEFINE ) . " (Australia)",
		"EN-EN-CA" => __( "English", PluginTextDomain_DEFINE ) . " (Canada)",
		"EN-EN-UK" => __( "English", PluginTextDomain_DEFINE ) . " (UK)",
		"EN-EN-US" => __( "English", PluginTextDomain_DEFINE ) . " (US)",
		"FR-FR-FR" => __( "French", PluginTextDomain_DEFINE ),
		"DE-DE-DE" => __( "German", PluginTextDomain_DEFINE ),
		"EL-EL-GR" => __( "Greek", PluginTextDomain_DEFINE ),
		"HE-IW-IL" => __( "Hebrew", PluginTextDomain_DEFINE ),
		"HI-HI-IN" => __( "Hindi", PluginTextDomain_DEFINE ),
		"IT-IT-IT" => __( "Italian", PluginTextDomain_DEFINE ),
		"JA-JA-JP" => __( "Japanese", PluginTextDomain_DEFINE ),
		"KO-KO-KR" => __( "Korean", PluginTextDomain_DEFINE ),
		"NO-NO-NO" => __( "Norwegian", PluginTextDomain_DEFINE ),
		"PL-PL-PL" => __( "Polish", PluginTextDomain_DEFINE ),
		"PT-PT-PT" => __( "Portugese", PluginTextDomain_DEFINE ),
		"RU-RU-RU" => __( "Russian", PluginTextDomain_DEFINE ),
		"ES-ES-ES" => __( "Spanish", PluginTextDomain_DEFINE ),
		"SV-SV-SE" => __( "Swedish", PluginTextDomain_DEFINE ),
		"TH-TH-TH" => __( "Thai", PluginTextDomain_DEFINE ),
		"TR-TR-TR" => __( "Turkish", PluginTextDomain_DEFINE ),
	);
	if ( FALSE_BOOL_DEFINE === $pb1O1r ) {
		return $pb1O3a;
	}
	if ( array_key_exists( $pb1O1r, $pb1O3a ) ) {
		return TRUE_BOOL_DEFINE;
	}

	return FALSE_BOOL_DEFINE;
}

function pb1l3b( $pb1O3b ) {
	$pb1l3c = array();
	$pb1O3c = explode( "&", $pb1O3b );
	foreach ( $pb1O3c as $pb1l3d ) {
		list ( $pb1O2q, $pb1l2r ) = array_map( "urldecode", explode( "=", $pb1l3d ) );
		$pb1l3c[ $pb1O2q ] = $pb1l2r;
	}

	return $pb1l3c;
}

function pb1O3d( $pb1l3e, $pb1O3e = FALSE_BOOL_DEFINE, $pb1l3f = FALSE_BOOL_DEFINE ) {
	$pb1O3f = "ERROR:";
	$pb1l3g = pb1l23;
	$pb1l3g = pb1O3g( $pb1l3g, $pb1l3e );
	$pb1l3h = "r";
	if ( TRUE_BOOL_DEFINE === $pb1l3f ) {
		$pb1l3h = "t";
	}
	if ( TRUE_BOOL_DEFINE === $pb1O3e ) {
		$pb1l3h = "u";
	}
	$pb1l2n = array( "s" => $pb1l3h, "a" => $pb1l3e, "d" => $pb1l3g, "e" => pb1Oe, );
	$pb1O2u = pb1O37( pb1ll, $pb1l2n, "POST", pb1Ok );
	if ( FALSE_BOOL_DEFINE === $pb1O2u ) {
		$pb1O3h = __( "Failed to contact verification server", PluginTextDomain_DEFINE );
		write_log( $pb1O3h . " - " . __( "attempt", PluginTextDomain_DEFINE ) . " 1" );
		$pb1O2u = pb1O37( pb1lm, $pb1l2n, "POST", pb1Ok );
		if ( FALSE_BOOL_DEFINE === $pb1O2u ) {
			write_log( $pb1O3h . " - " . __( "attempt", PluginTextDomain_DEFINE ) . " 2" );
			update_option_wrapper( pbseo_opt_DEFINE . "auth_error", $pb1O3h );

			return FALSE_BOOL_DEFINE;
		}
	}
	if ( FALSE_BOOL_DEFINE !== pb1O2r( $pb1O2u, $pb1O3f ) ) {
		$pb1O3h = sprintf( __( '%s', PluginTextDomain_DEFINE ), $pb1O2u );
		write_log( $pb1O3h );
		update_option_wrapper( pbseo_opt_DEFINE . "auth_error", $pb1O3h );

		return FALSE_BOOL_DEFINE;
	}
	if ( "r" == $pb1l3h ) {
		pb1O2f( pbseo_opt_DEFINE . "auth_error" );
		update_option_wrapper( pbseo_opt_DEFINE . "auth_success", __( "Code verified, plugin has been activated", PluginTextDomain_DEFINE ) );
		update_option_wrapper( pbseo_opt_DEFINE . "temp_key", $pb1O2u );
	}

	return TRUE_BOOL_DEFINE;
}

function pb1l3i() {
	$pb1O3f = "ERROR:";
	$pb1l2n = array( "s" => "void", );
	$pb1O2u = pb1O37( pb1Om, $pb1l2n, "POST", pb1Ok );
	if ( FALSE_BOOL_DEFINE === $pb1O2u ) {
		$pb1O3h = __( "Failed to contact mc server", PluginTextDomain_DEFINE );
		write_log( $pb1O3h . " - " . __( "attempt", PluginTextDomain_DEFINE ) . " 1" );
		$pb1O2u = pb1O37( pb1Om, $pb1l2n, "POST", pb1Ok );
		if ( FALSE_BOOL_DEFINE === $pb1O2u ) {
			write_log( $pb1O3h . " - " . __( "attempt", PluginTextDomain_DEFINE ) . " 2" );

			return FALSE_BOOL_DEFINE;
		}
	}
	if ( FALSE_BOOL_DEFINE !== pb1O2r( $pb1O2u, $pb1O3f ) ) {
		$pb1O3h = sprintf( __( '%s', PluginTextDomain_DEFINE ), $pb1O2u );
		write_log( $pb1O3h );

		return FALSE_BOOL_DEFINE;
	}
	try {
		$pb1O2u = pb1O3i( $pb1O2u );
		$pb1O2u = @unserialize( $pb1O2u );
		if ( isset ( $pb1O2u["marker"] ) ) {
			pb1l2w( pb1O1g, $pb1O2u, ( pb1Oh * 030 ) );
			$pb1l3j = null;

			return TRUE_BOOL_DEFINE;
		} else {
			write_log( __( "Failed to extract data package", PluginTextDomain_DEFINE ) );

			return FALSE_BOOL_DEFINE;
		}
	} catch ( exception $pb1O2w ) {
		write_log( $pb1O2w->getmessage() );

		return FALSE_BOOL_DEFINE;
	}
}

function pb1O3j( $pb1l3e = FALSE_BOOL_DEFINE ) {
	if ( FALSE_BOOL_DEFINE !== $pb1l3e ) {
		$pb1l3k = pb1O23();
		$pb1O3k = pb1O3d( $pb1l3e, $pb1O3e = FALSE_BOOL_DEFINE, $pb1l3f = FALSE_BOOL_DEFINE );
		if ( TRUE_BOOL_DEFINE === $pb1O3k ) {
			$pb1l3l = get_option_wrapper( pbseo_opt_DEFINE . "temp_key" );
			$pb1O3l = pb1l3m( $pb1l3l );
			if ( FALSE_BOOL_DEFINE !== $pb1O3l ) {
				pb1O3m( $pb1l3l, $pb1l3k );
				pb1l3n( $pb1l3l );
				pb1O2f( pbseo_opt_DEFINE . "temp_key" );

				return $pb1l3l;
			}
		}
		pb1O2f( pbseo_opt_DEFINE . "temp_key" );
	}

	return FALSE_BOOL_DEFINE;
}

function pb1O3m( $pb1l3l, $pb1l3k ) {
	$pb1l2s = pb1O3n( $pb1l3k );
	pb1l2w( $pb1l2s, $pb1l3l, ( pb1Oh * 030 ) );
	pb1l3n( $pb1l3l );
}

function pb1l3o( $pb1l3k ) {
	$pb1l2s = pb1O3n( $pb1l3k );
	$pb1l3l = pb1l2t( $pb1l2s );
	if ( FALSE_BOOL_DEFINE !== $pb1l3l ) {
		$pb1O3o = pb1l3m( $pb1l3l );
		if ( FALSE_BOOL_DEFINE !== $pb1O3o ) {
			return $pb1l3l;
		}
	}
	$pb1l3e = get_option_wrapper( pbseo_opt_DEFINE . "activation_code" );
	if ( ! empty( $pb1l3e ) ) {
		$pb1l3l = pb1O3j( $pb1l3e );
		if ( FALSE_BOOL_DEFINE !== $pb1l3l ) {
			return $pb1l3l;
		}
	}

	return FALSE_BOOL_DEFINE;
}

function pb1O3n( $pb1l3k ) {
	return pbseo_trans_DEFINE . md5( $pb1l3k . "pbseo_license_key" . pb1Oc );
}

function pb1l3p( $pb1l3k ) {
	$pb1l2s = pb1O3n( $pb1l3k );
	pb1O3p( $pb1l2s );
}

function pb1l3n( $pb1l3l ) {
	$pb1l3q = pb1O3q( pb1O1q( $pb1l3l, pb1l2, pb1l6 ) . pb1O1q( $pb1l3l, pb1O2, pb1l6 ) );
	update_option_wrapper( pbseo_opt_DEFINE . "license_key", $pb1l3q );
}

function pb1l2b() {
	$pb1l3k = pb1O23();
	$pb1l3l = pb1l3o( $pb1l3k );
	if ( FALSE_BOOL_DEFINE !== $pb1l3l ) {
		return $pb1l3l;
	}
	$pb1l3l = pb1l3r();
	if ( FALSE_BOOL_DEFINE !== $pb1l3l ) {
		return $pb1l3l;
	}

	return FALSE_BOOL_DEFINE;
}

function pb1O3r() {
	$pb1l3s = get_option_wrapper( pbseo_opt_DEFINE . "pre_launch_unlock_code" );
	if ( pb1l1g == $pb1l3s ) {
		return TRUE_BOOL_DEFINE;
	}

	return FALSE_BOOL_DEFINE;
}

function pb1l2c() {
	$pb1O3s = pb1l2t( pb1O1g );
	if ( FALSE_BOOL_DEFINE !== $pb1O3s ) {
		return TRUE_BOOL_DEFINE;
	} else {
		return pb1l3i();
	}

	return FALSE_BOOL_DEFINE;
}

function pb1l3m( $pb1l3l, $pb1O2q = FALSE_BOOL_DEFINE ) {
	$pb1l3k = pb1O23();
	$pb1l3l = pb1l3t( $pb1l3l, $pb1l3k );
	$pb1l3l = explode( ":", $pb1l3l );
	if ( ( is_array( $pb1l3l ) ) && ( pb1l4 == count( $pb1l3l ) ) ) {
		if ( $pb1l3k == $pb1l3l[ pb1l3 ] ) {
			if ( FALSE_BOOL_DEFINE !== $pb1O2q ) {
				if ( isset ( $pb1l3l[ $pb1O2q ] ) ) {
					return $pb1l3l[ $pb1O2q ];
				} else {
					return FALSE_BOOL_DEFINE;
				}
			} else {
				return $pb1l3l;
			}
		}
	}

	return FALSE_BOOL_DEFINE;
}

function pb1O3t( $pb1O2q = FALSE_BOOL_DEFINE, $pb1O38 = FALSE_BOOL_DEFINE ) {
	static $pb1l3u
	=
	array();
	if ( FALSE_BOOL_DEFINE === pb1O2b ) {
		return '';
	}
	if ( isset ( $pb1l3u[ $pb1O2q ][ $pb1O38 ] ) ) {
		return $pb1l3u[ $pb1O2q ][ $pb1O38 ];
	}
	$pb1l3u = pb1l2t( pb1O1g );
	if ( FALSE_BOOL_DEFINE === $pb1l3u ) {
		$pb1l3u = array();

		return;
	}
	if ( is_array( $pb1l3u ) && isset ( $pb1l3u[ $pb1O2q ][ $pb1O38 ] ) ) {
		return $pb1l3u[ $pb1O2q ][ $pb1O38 ];
	}

	return '';
}

function pb1O3u( $pb1l3v = pb1O1d ) {
	if ( TRUE_BOOL_DEFINE === pb1O0 ) {
		return FALSE_BOOL_DEFINE;
	}
	global $pb1O3v;
	$pb1l3w = isset ( $pb1O3v[ pb1l1b ] ) ? $pb1O3v[ pb1l1b ] : 0;
	if ( $pb1l3w >= $pb1l3v ) {
		return TRUE_BOOL_DEFINE;
	}

	return FALSE_BOOL_DEFINE;
}

function pb1O3w() {
	echo "<p>" . pb1l2a . "</p>";
}

function pb1l3r() {
	$pb1l3x = get_option_wrapper( pbseo_opt_DEFINE . "legacy_flag" );
	if ( ! empty( $pb1l3x ) ) {
		return FALSE_BOOL_DEFINE;
	}
	$pb1l3l = FALSE_BOOL_DEFINE;
	$pb1l3k = pb1O23();
	$pb1O3x = get_option_wrapper( "_pbm_store" );
	if ( FALSE_BOOL_DEFINE !== $pb1O3x ) {
		$pb1O3x = pb1O3i( $pb1O3x );
		try {
			$pb1O3x = unserialize( $pb1O3x );
			$pb1l3y = "pbm_" . pb1O1q( md5( $pb1l3k ), pb1l3, pb1l3 );
			if ( isset ( $pb1O3x[ $pb1l3y ] ) ) {
				$pb1O3l = pb1l3m( $pb1O3x[ $pb1l3y ] );
				if ( FALSE_BOOL_DEFINE !== $pb1O3l ) {
					$pb1l3l = $pb1O3x[ $pb1l3y ];
					update_option_wrapper( pbseo_opt_DEFINE . "legacy_flag", "1" );
					update_option_wrapper( pbseo_opt_DEFINE . "activation_code", $pb1O3l[ pb1O2 ] );
					pb1O3m( $pb1l3l, $pb1l3k );
				}
			}
		} catch ( exception $pb1O2w ) {
			return FALSE_BOOL_DEFINE;
		}
		if ( is_array( $pb1O3x ) ) {
			$pb1O3y = get_option_wrapper( "pbseo_opt_homepage_keyword" );
			if ( FALSE_BOOL_DEFINE === $pb1O3y ) {
				if ( isset ( $pb1O3x["pbm_elements"]["links"]["homepage_keyword"]["current_value"] ) ) {
					update_option_wrapper( "pbseo_opt_homepage_keyword", $pb1O3x["pbm_elements"]["links"]["homepage_keyword"]["current_value"] );
				}
			}
			$pb1l3z = get_option_wrapper( "pbseo_opt_flickr_api" );
			if ( FALSE_BOOL_DEFINE === $pb1l3z ) {
				if ( isset ( $pb1O3x["pbm_elements"]["content"]["api_key_flickr"]["current_value"] ) ) {
					update_option_wrapper( "pbseo_opt_flickr_api", $pb1O3x["pbm_elements"]["content"]["api_key_flickr"]["current_value"] );
				}
			}
		}
	}

	return $pb1l3l;
}

function pb1O3z( $pb1l40, $pb1O40, $pb1l41 = pb1Ov, $pb1O41 = FALSE_BOOL_DEFINE ) {
	$pb1l42 = pb1O42( $pb1l40, $pb1O40, $pb1l41, $pb1O41, TRUE_BOOL_DEFINE );
	$pb1l43 = isset ( $pb1l42["score"] ) ? $pb1l42["score"] : FALSE_BOOL_DEFINE;
	if ( ! empty( $pb1l43 ) ) {
		$pb1O43 = @preg_replace( '/[^' . pb1Oo . pb1lp . ']/', ' ', $pb1l40 );
		$pb1O43 = pb_string_length( $pb1O43 );
		$pb1l44 = @preg_replace( '/[^' . pb1Oo . pb1lp . ']/', ' ', $pb1O40 );
		$pb1l44 = pb_string_length( $pb1l44 );
		$pb1O44 = 0;
		if ( $pb1l44 > 0 ) {
			$pb1O44 = ( $pb1O43 / $pb1l44 );
			$pb1O44 = ( $pb1O44 * .5 ) + .5;
		}
		$pb1l42["score"]              = round( $pb1l43 * $pb1O44, 2 );
		$pb1l42["density"]            = $pb1O44;
		$pb1l42["density_pre_adjust"] = $pb1l43;
	}

	return $pb1l42;
}

function pb1O42( $pb1l40, $pb1O40, $pb1l41 = pb1Ov, $pb1O41 = FALSE_BOOL_DEFINE, $pb1O44 = FALSE_BOOL_DEFINE, $pb1l45 = FALSE_BOOL_DEFINE ) {
	$pb1O45 = FALSE_BOOL_DEFINE;
	if ( ! is_string( $pb1l40 ) ) {
		return array( "score" => 0, "report" => array(), "type" => "ERROR", "error" => "Seek must be a string" );
	}
	if ( ( ! is_string( $pb1O40 ) ) && ( ! is_array( $pb1O40 ) ) ) {
		return array( "score" => 0, "report" => array(), "type" => "ERROR", "error" => "Source must be a string or array of strings" );
	}
	if ( is_array( $pb1O40 ) ) {
		$pb1O40 = implode( ". ", $pb1O40 );
	}
	$pb1O30 = "";
	if ( ( TRUE_BOOL_DEFINE === $pb1O45 ) && ( FALSE_BOOL_DEFINE !== $pb1l45 ) ) {
		$pb1O30 = trim_wrapper( $pb1l45 );
	}
	$pb1l40 = pb1O2p( $pb1l40 );
	$pb1O40 = pb1O2p( $pb1O40 );
	pb1le( $pb1l40, "INCOMING SEEK: " . $pb1O30, __FUNCTION__, $pb1O45 );
	pb1le( $pb1O40, "INCOMING SOURCE " . $pb1O30, __FUNCTION__, $pb1O45 );
	$pb1l46 = trim_wrapper( str_replace( array( ".", ",", "-" ), " ", $pb1O40 ) ) . " ";
	$pb1O46 = trim_wrapper( str_replace( array( ".", ",", "-" ), " ", $pb1l40 ) ) . " ";
	$pb1l47 = pb1O2r( $pb1l46, $pb1O46 );
	if ( FALSE_BOOL_DEFINE !== $pb1l47 ) {
		if ( 0 == $pb1l47 ) {
			pb1le( $pb1l47, "Exact match (start) phrase pos for seek [" . $pb1l40 . "] source[" . $pb1O40 . "]", __FUNCTION__, $pb1O45 );

			return array( "score" => 1, "report" => array(), "type" => "EXACT", "error" => '' );
		} else {
			pb1le( $pb1l47, "Exact match (non-start) phrase pos for seek [" . $pb1l40 . "] source[" . $pb1O40 . "]", __FUNCTION__, $pb1O45 );

			return array( "score" => pb1Oz, "report" => array(), "type" => "EXACT", "error" => '' );
		}
	}
	if ( 0 == $pb1l41 ) {
		return array( "score" => 0, "report" => array(), "type" => "NOMATCH", "error" => "Proximity matching off, no exact match found" );
	}
	$pb1l40 = str_replace( array( "-", ",", "'" ), "", $pb1l40 );
	$pb1l40 = trim_wrapper( $pb1l40 );
	$pb1l40 = remove_accents( $pb1l40 );
	$pb1l40 = explode( ' ', $pb1l40 );
	$pb1l40 = pb1O47( $pb1l40, pb1l1r );
	if ( ! count( $pb1l40 ) ) {
		return array( "score" => 0, "report" => array(), "type" => "NOMATCH", "error" => "No significant keywords to match" );
	}
	$pb1l48 = count( $pb1l40 );
	$pb1O40 = str_replace( array( "-", ",", "'" ), "", $pb1O40 );
	$pb1O40 = str_replace( ".", " ", $pb1O40 );
	$pb1O40 = @preg_replace( '/[\\.]{1,}$/', '', $pb1O40 );
	$pb1O40 = trim_wrapper( $pb1O40 );
	$pb1O40 = remove_accents( $pb1O40 );
	$pb1O40 = explode( ' ', $pb1O40 );
	$pb1O40 = pb1O47( $pb1O40, pb1l1r );
	$pb1O48 = count( $pb1O40 );
	if ( $pb1O48 < 1 ) {
		return array( "score" => 0, "report" => array(), "type" => "NOMATCH", "error" => "No significant words in source" );
	}
	foreach ( $pb1l40 as $pb1O2q => $pb1l49 ) {
		$pb1l40[ $pb1O2q ] = StemClass::stem_it( $pb1l49 );
	}
	foreach ( $pb1O40 as $pb1O2q => $pb1l49 ) {
		$pb1O40[ $pb1O2q ] = StemClass::stem_it( $pb1l49 );
	}
	$pb1O4a = array( "keyword" => '', "keyword_len" => '', "keyword_map" => array(), "keyword_val" => array(), "proximity_map" => array(), "keyword_found" => array(), "keyword_count" => $pb1l48, "source_word_count" => $pb1O48, );
	$pb1l4b = array();
	$pb1O4b = array();
	$pb1l4c = 0;
	foreach ( $pb1l40 as $pb1O2q => $pb1l49 ) {
		$pb1O4b[ $pb1l49 ] = FALSE_BOOL_DEFINE;
		$pb1l4c += pb_string_length( $pb1l49 );
		foreach ( $pb1O40 as $pos => $pb1O4c ) {
			if ( $pb1l49 == $pb1O4c ) {
				$pb1l4b[ $pos ] = $pb1l49;
				if ( FALSE_BOOL_DEFINE === $pb1O4b[ $pb1l49 ] ) {
					$pb1O4b[ $pb1l49 ] = $pos;
				}
			}
		}
	}
	@ksort( $pb1l4b );
	$pb1l4d = array();
	if ( $pb1l4c > 0 ) {
		foreach ( $pb1l4b as $pb1O2q => $pb1l49 ) {
			$pb1l4d[ $pb1l49 ] = round( ( pb_string_length( $pb1l49 ) / $pb1l4c ), 2 );
		}
	}
	$pb1O4d = array();
	foreach ( $pb1O4b as $pb1l49 => $pb1O2q ) {
		$pb1O4d[] = $pb1l49;
	}
	if ( ! count( $pb1O4d ) ) {
		return array( "score" => 0, "report" => array(), "type" => "NOMATCH", "error" => "No significant keywords found" );
	} else {
		$pb1O4d = implode( ' ', $pb1O4d );
	}
	$pb1l4e = array();
	$pb1O4e = array();
	$pb1l4f = array();
	$pb1O4f = array();
	$pb1l4g = array();
	$pb1O4g = 0;
	$pb1l4h = FALSE_BOOL_DEFINE;
	$pb1O4h = $pb1l4b;
	foreach ( $pb1O4h as $pb1O2q => $pb1l49 ) {
		$pb1l4i = '';
		$pb1O4i = '';
		$pb1l4j = '';
		$pb1O4j = '';
		foreach ( $pb1l4b as $pb1l4k => $pb1O4k ) {
			if ( $pb1l4k > ( $pb1O2q + $pb1l41 ) ) {
				continue;
			}
			if ( $pb1l4k != $pb1O2q ) {
				$pb1l4h = abs( $pb1O2q - $pb1l4k );
				if ( $pb1l4h <= ( $pb1l41 + 1 ) ) {
					if ( $pb1l4k < $pb1O2q ) {
						$pb1l4i .= $pb1O4k . ' ';
						$pb1O4i .= $pb1l4k . ' ';
					} else {
						$pb1l4j .= $pb1O4k . ' ';
						$pb1O4j .= $pb1l4k . ' ';
					}
				}
			}
		}
		$pb1l4l = trim_wrapper( $pb1l4i . $pb1l49 . ' ' . $pb1l4j );
		$pb1O4l = trim_wrapper( $pb1O4i . $pb1O2q . ' ' . $pb1O4j );
		if ( ! in_array( $pb1l4l, $pb1l4e ) ) {
			$pb1l4e[ $pb1O2q ] = $pb1l4l;
			$pb1l4f[ $pb1O2q ] = explode( ' ', $pb1O4l );
			foreach ( $pb1l4f[ $pb1O2q ] as $pb1l4m => $pb1O4m ) {
				$pb1l4n = $pb1l4m + 1;
				if ( isset ( $pb1l4f[ $pb1O2q ][ $pb1l4n ] ) ) {
					$pb1l4f[ $pb1O2q ][ $pb1l4m ] = ( ( $pb1l4f[ $pb1O2q ][ $pb1l4n ] - $pb1l4f[ $pb1O2q ][ $pb1l4m ] ) - 1 );
				} else {
					$pb1l4f[ $pb1O2q ][ $pb1l4m ] = 0;
				}
			}
			$pb1l4f[ $pb1O2q ] = array_sum( $pb1l4f[ $pb1O2q ] );
			$pb1O4e[ $pb1O2q ] = str_replace( ' ', ', ', $pb1O4l );
			$pb1O4n            = array_unique( explode( ' ', $pb1l4l ) );
			$pb1l4o            = array_unique( explode( ' ', $pb1O4d ) );
			$pb1O4o            = 0;
			$pb1l4p            = 0;
			foreach ( $pb1l4o as $pb1O4p ) {
				if ( in_array( $pb1O4p, $pb1O4n ) ) {
					$pb1O4o ++;
					$pb1l4p += $pb1l4d[ $pb1O4p ];
				}
			}
			$pb1l4q                         = count( $pb1O4b );
			$pb1l43                         = $pb1l4p;
			$pb1O4f[ $pb1O2q ]["all_words"] = $pb1O4o . " of " . $pb1l4q . " - Score: " . $pb1l43;
			$pb1O4q                         = explode( " ", $pb1O4d );
			$pb1l4r                         = explode( " ", $pb1l4l );
			$pb1O4r                         = count( $pb1O4q );
			$pb1l4s                         = 0;
			foreach ( $pb1O4q as $pb1O4s => $pb1l4t ) {
				if ( isset ( $pb1l4r[ $pb1O4s ] ) && ( $pb1l4t == $pb1l4r[ $pb1O4s ] ) ) {
					$pb1l4s ++;
				}
			}
			$pb1O4t                     = ( $pb1O4r - $pb1l4s );
			$pb1O4t                     = pow( pb1l10, $pb1O4t );
			$pb1l43                     = ( $pb1l43 * $pb1O4t );
			$pb1O4f[ $pb1O2q ]["order"] = $pb1l4s . " of " . $pb1O4r . " - Mod: " . $pb1O4t . " Score: " . $pb1l43;
			$pb1l4u                     = pow( pb1O10, $pb1l4f[ $pb1O2q ] );
			$pb1l43                     = ( $pb1l43 * $pb1l4u );
			$pb1O4f[ $pb1O2q ]["skip"]  = "Mod: " . $pb1l4u . " Score: " . $pb1l43;
			$pb1l43                     = ( $pb1l43 * pb1l11 );
			if ( $pb1l43 < 0 ) {
				$pb1l43 = 0;
			}
			$pb1l4g[ $pb1O2q ] = round( $pb1l43, 2 );
		}
	}
	unset ( $pb1O4h );
	$pb1O4a["keyword"]       = $pb1O4d;
	$pb1O4a["keyword_len"]   = $pb1l4c;
	$pb1O4a["keyword_map"]   = $pb1l4b;
	$pb1O4a["keyword_val"]   = $pb1l4d;
	$pb1O4a["proximity_map"] = array( "map" => $pb1l4e, "keys" => $pb1O4e, "skip" => $pb1l4f, "modifiers" => $pb1O4f, "score" => $pb1l4g );
	$pb1O4a["keyword_found"] = $pb1O4b;
	if ( count( $pb1O4a["proximity_map"]["score"] ) ) {
		$pb1O4g = max( $pb1O4a["proximity_map"]["score"] );
	}
	unset ( $pb1l4b, $pb1l4e, $pb1O4e, $pb1l4g, $pb1O4b );
	if ( $pb1O4g > 0 ) {
		return array( "score" => $pb1O4g, "report" => $pb1O4a, "type" => "PARTIAL", "error" => '' );
	} else {
		return array( "score" => $pb1O4g, "report" => $pb1O4a, "type" => "NOMATCH", "error" => '' );
	}
}

function pb1O4u( $pb1l4v, $pb1O4v = 0 ) {
	$pb1l4w = array();
	$pb1O4w = trim_wrapper( str_repeat( "x0x ", ( $pb1O4v ) + 1 ) );
	foreach ( $pb1l4v as $pb1O2q => $pb1l2r ) {
		$pb1l4w[] = $pb1l2r;
		$pb1l4w[] = $pb1O4w;
	}

	return $pb1l4w;
}

function pb1l4x( $pb1O4x ) {
	$pb1O4x = @preg_replace( '/[\\n\\r]/', ' ', $pb1O4x );
	$pb1l4y = array(
		'/param name=\\"movie\\"/i',
		'/youtube\\.com\\/v\\//i',
		'/youtube\\.com\\/watch/i',
		'/youtube\\.com\\/embed/i',
		'/value=\\"videoId=/i',
		'/dailymotion\\.com\\/embed\\/video/i',
		'/blip\\.tv\\/play/i',
		'/metacafe\\.com\\/fplayer/i',
		'/vimeo\\.com\\/video/i',
		'/\\/\\/embed\\.5min\\.com/i',
		'/googleplayer\\.swf/i',
		'/flowplayer.*?\\.swf/i',
		'/ebvideo-youtube\\.php/i',
		'/photobucket\\.com\\/player\\.swf/i',
		'/<video[^>]{0,}>/i',
	);
	foreach ( $pb1l4y as $pb1O4y ) {
		$pb1l4z = array();
		if ( @preg_match( $pb1O4y, $pb1O4x, $pb1l4z ) ) {
			return count( $pb1l4z );
		}
	}

	return FALSE_BOOL_DEFINE;
}

function pb1O4z( $pb1l3c ) {
	$pb1l50 = array();
	foreach ( $pb1l3c as $val ) {
		if ( isset ( $pb1l50[ $val ] ) ) {
			$pb1l50[ $val ] ++;
		} else {
			$pb1l50[ $val ] = 1;
		}
	}
	$pb1O50 = pb1l51( $pb1l50 );

	return $pb1O50['key'];
}

function pb1l51( $pb1l3c ) {
	reset( $pb1l3c );
	$pb1O51 = key( $pb1l3c );
	$pb1l52 = current( $pb1l3c );
	foreach ( $pb1l3c as $key => $val ) {
		if ( $val > $pb1l52 ) {
			$pb1l52 = $val;
			$pb1O51 = $key;
		}
	}

	return array( 'key' => $pb1O51, 'val' => $pb1l52 );
}

function pb1O52( $pb1l3c ) {
	return array_sum( $pb1l3c );
}

function pb1l53( $pb1l3c ) {
	$pb1O53 = count( $pb1l3c );
	$pb1l54 = pb1O52( $pb1l3c );

	return ( $pb1l54 / $pb1O53 );
}

function pb1O54( $pb1l3c ) {
	$pb1O53 = count( $pb1l3c );
	$pb1l3c = pb1l55( $pb1l3c );
	$pb1O55 = ( $pb1O53 * .25 );
	if ( ceil( $pb1O55 ) == $pb1O55 ) {
		$pb1l56 = ( $pb1O55 - 1 );

		return ( ( $pb1l3c[ $pb1l56 ] + $pb1l3c[ $pb1O55 ] ) / 2 );
	} else {
		$pb1l56 = ( ceil( $pb1O55 ) - 1 );

		return $pb1l3c[ $pb1l56 ];
	}
}

function pb1O56( $pb1l3c ) {
	$pb1O53 = count( $pb1l3c );
	$pb1l3c = pb1l55( $pb1l3c );
	$pb1O55 = ( $pb1O53 / 2 );
	if ( ceil( $pb1O55 ) == $pb1O55 ) {
		$pb1l56 = ( $pb1O55 - 1 );

		return ( ( $pb1l3c[ $pb1l56 ] + $pb1l3c[ $pb1O55 ] ) / 2 );
	} else {
		$pb1l56 = ( ceil( $pb1O55 ) - 1 );

		return $pb1l3c[ $pb1l56 ];
	}
}

function pb1l57( $pb1l3c ) {
	$pb1O53 = count( $pb1l3c );
	$pb1l3c = pb1l55( $pb1l3c );
	$pb1O55 = ( $pb1O53 * .75 );
	if ( ceil( $pb1O55 ) == $pb1O55 ) {
		$pb1l56 = ( $pb1O55 - 1 );

		return ( ( $pb1l3c[ $pb1l56 ] + $pb1l3c[ $pb1O55 ] ) / 2 );
	} else {
		$pb1l56 = ( ceil( $pb1O55 ) - 1 );

		return $pb1l3c[ $pb1l56 ];
	}
}

function pb1l55( $pb1l3c, $pb1O57 = TRUE_BOOL_DEFINE ) {
	if ( TRUE_BOOL_DEFINE === $pb1O57 ) {
		usort( $pb1l3c, 'pbseo_compare_asc' );
	} else {
		usort( $pb1l3c, 'pbseo_compare_desc' );
	}

	return $pb1l3c;
}

function pbseo_compare_asc( $pb1O55, $pb1l56 ) {
	if ( $pb1O55 == $pb1l56 ) {
		return 0;
	}

	return ( ( $pb1O55 < $pb1l56 ) ? - 1 : 1 );
}

function pbseo_compare_desc( $pb1O55, $pb1l56 ) {
	if ( $pb1O55 == $pb1l56 ) {
		return 0;
	}

	return ( ( $pb1O55 > $pb1l56 ) ? - 1 : 1 );
}

function pb1l58( $pb1l45 ) {
	if ( TRUE_BOOL_DEFINE !== pb1le ) {
		return;
	}
	global $pb1O58;
	static $pb1l59
	=
	0;
	static $pb1O59
	=
	0;
	$pb1l5a   = microtime( TRUE_BOOL_DEFINE );
	$pb1O5a   = ( $pb1l5a - $pb1l59 );
	$pb1l5b   = memory_get_usage( TRUE_BOOL_DEFINE );
	$pb1O5b   = ( $pb1l5b - $pb1O59 );
	$pb1O58[] = array( "label" => $pb1l45, "mem_use" => number_format( $pb1l5b, 0 ), "mem_diff" => number_format( $pb1O5b, 0 ), "peak" => number_format( memory_get_peak_usage( TRUE_BOOL_DEFINE ), 0 ), "time" => number_format( $pb1l5a, 4 ), "tim_diff" => number_format( $pb1O5a, 4 ), );
	$pb1l59   = $pb1l5a;
	$pb1O59   = $pb1l5b;
}

function pbseo_post_list_columns( $pb1l5c ) {
	$pb1l5c["pbseo_seorating"] = __( "SEO Rating", PluginTextDomain_DEFINE );

	return $pb1l5c;
}

function pbseo_custom_post_list_columns( $pb1O5c ) {
	global $post;
	switch ( $pb1O5c ) {
		case "pbseo_seorating":
			$pb1l5d = get_post_meta( $post->ID, _pbseo_meta_DEFINE . "links_seo_target", TRUE_BOOL_DEFINE );
			$pb1O5d = get_post_meta( $post->ID, _pbseo_meta_DEFINE . "optimizer_seo_rating", TRUE_BOOL_DEFINE );
			$pb1l5e = get_post_meta( $post->ID, _pbseo_meta_DEFINE . "optimizer_keyword", TRUE_BOOL_DEFINE );
			if ( 1 == $pb1l5d ) {
				echo "<div class=\"pbseo_col_target\"><span class=\"pbseo_optimizer_alert pbseo_ok\">";
				echo __( "SEO Target", PluginTextDomain_DEFINE );
				echo "</span></div>";
			}
			if ( ! empty( $pb1O5d ) ) {
				$pb1O5d = explode( "|", $pb1O5d );
				if ( isset ( $pb1O5d[0] ) && isset ( $pb1O5d[1] ) ) {
					$pb1l43 = intval( $pb1O5d[0] );
					$pb1O5e = $pb1O5d[1];
					if ( $pb1l43 <= pb1l15 ) {
						$pb1l43 = pb1l15;
						$pb1O5e = pb1l17;
					}
					echo "<div class=\"pbseo_col_keyword\">" . pb_htmlspecialchars( $pb1l5e ) . "</div>";
					echo "<div class=\"pbseo_col_bar\">";
					echo "<div class=\"pbseo_col_fill\" style=\"width: " . $pb1l43 . "px; background-color: " . pb_htmlspecialchars( $pb1O5e ) . "; \">";
					echo "</div>";
					echo "</div>";
				}
			} else {
				echo "<div class=\"pbseo_col_keyword\">" . __( "Not Rated", PluginTextDomain_DEFINE ) . "</div>";
			}
			break;
	}
}

function pbseo_deactivate() {
	$pb1l3e = get_option_wrapper( pbseo_opt_DEFINE . "activation_code" );
	if ( FALSE_BOOL_DEFINE !== $pb1l3e ) {
		$pb1O3k = pb1O3d( $pb1l3e, $pb1O3e = TRUE_BOOL_DEFINE, $pb1l3f = FALSE_BOOL_DEFINE );
	}
	pb1O5f( TRUE_BOOL_DEFINE );
}

function pb1O5f( $pb1l5g = FALSE_BOOL_DEFINE ) {
	global $wpdb;
	$pb1O2e .= "SELECT ";
	$pb1O2e .= "RIGHT(" . $wpdb->options . ".option_name,32) AS transient ";
	$pb1O2e .= "FROM " . $wpdb->options . " ";
	$pb1O2e .= "WHERE " . $wpdb->options . ".option_name LIKE(\"_transient_timeout_" . pbseo_trans_DEFINE . "%\") ";
	if ( TRUE_BOOL_DEFINE !== $pb1l5g ) {
		$pb1O2e .= "AND ( CONVERT(" . $wpdb->options . ".option_value, signed) < UNIX_TIMESTAMP( NOW() ) ) ";
		$pb1O2e .= "LIMIT 500";
	}
	$pb1O5g = $wpdb->get_results( $pb1O2e, ARRAY_N );
	$pb1O2e = null;
	if ( count( $pb1O5g ) ) {
		foreach ( $pb1O5g as $pb1O2q => $pb1l5h ) {
			pb1O3p( pbseo_trans_DEFINE . $pb1l5h[0] );
		}
	}
	$pb1O5g = null;
	$wpdb->flush();
}

?>