<?php function pbseo_get_incoming_search() {
	$pb1l8z = get_option( pbseo_opt_DEFINE . "i\156coming\137\163ear\143\150_a\143\164ive" );
	if ( TRUE_BOOL_DEFINE != $pb1l8z ) {
		return FALSE_BOOL_DEFINE;
	}
	if ( ( isset ( $_REQUEST["p\162\145view"] ) ) && ( $_REQUEST["p\162\145view"] == "true" ) ) {
		return FALSE_BOOL_DEFINE;
	}
	$pb1O8z = pb1l90();
	if ( FALSE_BOOL_DEFINE === $pb1O8z ) {
		return FALSE_BOOL_DEFINE;
	}
	$pb1O90 = pb1l91( $pb1O8z );
	if ( ! empty( $pb1O90 ) ) {
		$pb1O91 = pb1l92( $pb1O90 );
		if ( ! empty( $pb1O91 ) ) {
			global $post;
			if ( is_home() ) {
				pb1O92( $pb1O91, 0 );
			} else if ( isset ( $post->ID ) ) {
				pb1O92( $pb1O91, $post->ID );
			}
		}
	}
}

function pb1l90() {
	if ( ! isset ( $_SERVER["\110TTP_R\105\106ERE\122"] ) || ( $_SERVER["HTT\120\137REFE\122\105R"] == '' ) ) {
		return FALSE_BOOL_DEFINE;
	}
	$pb1l93 = @parse_url( $_SERVER["H\124\124P_RE\106\105RE\122"], PHP_URL_HOST );
	if ( "www." == substr( $pb1l93, 0, 4 ) ) {
		$pb1l93 = substr( $pb1l93, 4 );
	}

	return strtolower( $pb1l93 );
}

function pb1l91( $pb1O8z ) {
	$pb1O4q = array( "\142ing\056\143om"                             => "\161",
	                 "\142logs\145\141rch.\147\157ogl\145\056co\155" => "q",
	                 "\147\157.goo\147\154e.c\157\155"               => "q",
	                 "go\157\147le.co\155"                           => "\161",
	                 "g\157\157gle.c\157\056uk"                      => "q",
	                 "\151mage\163\056goo\147\154e.co\155"           => "\161",
	                 "local\056\147oogl\145\056co\155"               => "\161",
	                 "map\163\056goog\154\145.co\155"                => "\161",
	                 "new\163\056goog\154\145.co\155"                => "\161",
	                 "searc\150\056msn.\143\157m"                    => "q",
	                 "sear\143\150.yah\157\157.co\155"               => "p",
	                 "\166\151deo.\147\157ogl\145\056com"            => "\161",
	);
	if ( isset ( $pb1O4q[ $pb1O8z ] ) ) {
		$pb1O93 = $pb1O4q[ $pb1O8z ];
	} else {
		$pb1O93 = FALSE_BOOL_DEFINE;
	}

	return $pb1O93;
}

function pb1l92( $pb1O93 ) {
	$pb1O91 = FALSE_BOOL_DEFINE;
	$pb1l94 = array();
	$pb1O94 = FALSE_BOOL_DEFINE;
	$pb1l95 = explode( $pb1O93 . "\075", $_SERVER["H\124\124P_RE\106\105RER"] );
	$pb1l95 = explode( "&", $pb1l95[1] );
	$pb1l95 = urldecode( $pb1l95[0] );
	$pb1l95 = @preg_replace( '/[\\"\']{1,}/', '', $pb1l95 );
	$pb1l94 = @preg_split( '/[\\s,\\+\\.]+/', $pb1l95 );
	$pb1O94 = implode( " ", $pb1l94 );
	$pb1O91 = htmlspecialchars( urldecode( trim( $pb1O94 ) ) );

	return $pb1O91;
}

function pb1O92( $pb1O91, $pb1l5k = 0 ) {
	$pb1O95 = pb1l96( $pb1O91, $pb1l5k );
	if ( ! empty( $pb1O95 ) ) {
		$pb1O96 = pb1l97( $pb1O95, $pb1l5k );
	} else {
		$pb1O96 = pb1O97( $pb1O91, $pb1l5k );
	}

	return $pb1O96;
}

function pb1l96( $pb1O91, $pb1l5k = 0 ) {
	global $wpdb;
	$pb1l98 = md5( $pb1O91 );
	$pb1O2e = "\123\105LECT\040\052 ";
	$pb1O2e .= "\106\122OM " . $wpdb->prefix . pb1lv . " ";
	$pb1O2e .= "WHERE\040" . pb1Ou . "\151\144 = '" . @mysql_real_escape_string( $pb1l98 ) . "' ";
	$pb1O2e .= "\101ND " . pb1Ou . "po\163\164_id \075\040" . intval( $pb1l5k ) . "\040";
	$pb1O2e .= "\114\111MIT \061";
	$pb1O96 = $wpdb->get_row( $pb1O2e, ARRAY_A );
	if ( null !== $pb1O96 ) {
		return $pb1O96;
	}

	return FALSE_BOOL_DEFINE;
}

function pb1l97( $pb1O95 ) {
	global $wpdb;
	if ( ! is_array( $pb1O95 ) ) {
		return FALSE_BOOL_DEFINE;
	}
	$pb1O98 = pb1Ou . "i\144";
	$pb1l99 = pb1Ou . "\160\157st_i\144";
	$pb1O99 = pb1Ou . "\164erm";
	$pb1l9a = pb1Ou . "\164erm_c\157\165nt";
	$pb1O9a = pb1Ou . "\154as\164\137sear\143\150";
	$pb1O98 = isset ( $pb1O95[ $pb1O98 ] ) ? $pb1O95[ $pb1O98 ] : FALSE_BOOL_DEFINE;
	$pb1l99 = isset ( $pb1O95[ $pb1l99 ] ) ? intval( $pb1O95[ $pb1l99 ] ) : FALSE_BOOL_DEFINE;
	$pb1O99 = isset ( $pb1O95[ $pb1O99 ] ) ? $pb1O95[ $pb1O99 ] : FALSE_BOOL_DEFINE;
	$pb1l9a = isset ( $pb1O95[ $pb1l9a ] ) ? intval( $pb1O95[ $pb1l9a ] ) : FALSE_BOOL_DEFINE;
	$pb1O9a = isset ( $pb1O95[ $pb1O9a ] ) ? intval( $pb1O95[ $pb1O9a ] ) : FALSE_BOOL_DEFINE;
	if ( ( FALSE_BOOL_DEFINE !== $pb1O98 ) && ( FALSE_BOOL_DEFINE !== $pb1l99 ) && ( FALSE_BOOL_DEFINE !== $pb1O99 ) && ( FALSE_BOOL_DEFINE !== $pb1l9a ) && ( FALSE_BOOL_DEFINE !== $pb1O9a ) ) {
		$pb1l9a ++;
		$pb1O2e = "U\120DAT\105\040" . $wpdb->prefix . pb1lv . "\040";
		$pb1O2e .= "\123ET ";
		$pb1O2e .= pb1Ou . "\164erm_\143\157unt \075\040" . intval( $pb1l9a ) . ", ";
		$pb1O2e .= pb1Ou . "\154ast\137\163ear\143\150 = " . time() . " ";
		$pb1O2e .= "WHER\105\040" . pb1Ou . "\151d =\040\047" . @mysql_real_escape_string( $pb1O98 ) . "' ";
		$pb1O2e .= "\101ND " . pb1Ou . "p\157\163t_id\040\075 " . intval( $pb1l99 ) . "\040";
		$pb1O96 = $wpdb->query( $pb1O2e );

		return $pb1O96;
	}

	return FALSE_BOOL_DEFINE;
}

function pb1O97( $pb1O91, $pb1l5k = 0 ) {
	global $wpdb;
	if ( empty( $pb1O91 ) ) {
		return FALSE_BOOL_DEFINE;
	}
	$pb1O98 = pb1Ou . "i\144";
	$pb1l99 = pb1Ou . "pos\164\137id";
	$pb1O99 = pb1Ou . "ter\155";
	$pb1l9a = pb1Ou . "term_\143\157unt";
	$pb1O9a = pb1Ou . "last_s\145\141rch";
	$pb1O2e = "INS\105\122T I\116\124O " . $wpdb->prefix . pb1lv . " (";
	$pb1O2e .= $pb1O98 . ",";
	$pb1O2e .= $pb1l99 . "\054";
	$pb1O2e .= $pb1O99 . "\054";
	$pb1O2e .= $pb1l9a . ",";
	$pb1O2e .= $pb1O9a;
	$pb1O2e .= "\051 VAL\125\105S (";
	$pb1O2e .= "'" . @mysql_real_escape_string( md5( trim( $pb1O91 ) ) ) . "', ";
	$pb1O2e .= "'" . intval( $pb1l5k ) . "'\054\040";
	$pb1O2e .= "\047" . @mysql_real_escape_string( trim( $pb1O91 ) ) . "', ";
	$pb1O2e .= "\0471', ";
	$pb1O2e .= "'" . time() . "\047 ";
	$pb1O2e .= "\051\040";
	$pb1O96 = $wpdb->query( $pb1O2e );

	return $pb1O96;
}

function pb1O5v( $pb1l5k = FALSE_BOOL_DEFINE ) {
	global $wpdb;
	if ( FALSE_BOOL_DEFINE === $pb1l5k ) {
		return FALSE_BOOL_DEFINE;
	} else {
		$pb1l5k = intval( $pb1l5k );
	}
	$pb1l9b = intval( pb1lj );
	$pb1O9b = time() - intval( pb1Oi );
	$pb1O2e = "\123ELE\103\124 ";
	$pb1O2e .= pb1Ou . "te\162\155, ";
	$pb1O2e .= pb1Ou . "ter\155\137coun\164\040";
	$pb1O2e .= "FRO\115\040" . $wpdb->prefix . pb1lv . " ";
	$pb1O2e .= "\127HERE ";
	$pb1O2e .= pb1Ou . "\160\157st_\151\144 = '" . $pb1l5k . "\047 ";
	$pb1O2e .= "\101ND " . pb1Ou . "ter\155\137cou\156\164 >=\040\047" . $pb1l9b . "' ";
	$pb1O2e .= "\101ND " . pb1Ou . "\154ast_\163\145arch\040\076= \047" . $pb1O9b . "'\040";
	$pb1O2e .= "\117RDE\122\040BY " . pb1Ou . "\164erm\137\143oun\164\040DES\103\040";
	$pb1O2e .= "\114IMI\124\040" . pb1Oj;
	$pb1O96 = $wpdb->get_results( $pb1O2e, ARRAY_A );
	if ( is_array( $pb1O96 ) && count( $pb1O96 ) ) {
		return $pb1O96;
	}

	return FALSE_BOOL_DEFINE;
} ?>