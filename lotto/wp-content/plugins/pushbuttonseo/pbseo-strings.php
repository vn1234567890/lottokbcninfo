<?php function pb1O3g( $pb1O9y, $pb1O2q ) {
	$pb1O9y = pb1O3q( $pb1O9y );
	if ( pb1Oe == 1 ) {
		return $pb1O9y;
	}
	$pb1O96 = '';
	for ( $pb1l9z = 1; $pb1l9z <= pb_string_length( $pb1O9y, TRUE_BOOL_DEFINE ); $pb1l9z ++ ) {
		$pb1O9z = pb1O1q( $pb1O9y, $pb1l9z - 1, 1, TRUE_BOOL_DEFINE );
		$pb1la0 = pb1O1q( $pb1O2q, ( $pb1l9z % pb_string_length( $pb1O2q ) ) - 1, 1, TRUE_BOOL_DEFINE );
		$pb1O9z = pb1Oa0( pb1la1( $pb1O9z, TRUE_BOOL_DEFINE ) + pb1la1( $pb1la0, TRUE_BOOL_DEFINE ) );
		$pb1O96 .= $pb1O9z;
	}

	return pb1O3q( $pb1O96 );
}

function pb1l3t( $pb1O9y, $pb1O2q ) {
	$pb1O9y = pb1O3i( $pb1O9y );
	if ( pb1Oe == 1 ) {
		return $pb1O9y;
	}
	$pb1O96 = '';
	for ( $pb1l9z = 1; $pb1l9z <= pb_string_length( $pb1O9y, TRUE_BOOL_DEFINE ); $pb1l9z ++ ) {
		$pb1O9z = pb1O1q( $pb1O9y, $pb1l9z - 1, 1, TRUE_BOOL_DEFINE );
		$pb1la0 = pb1O1q( $pb1O2q, ( $pb1l9z % pb_string_length( $pb1O2q ) ) - 1, 1, TRUE_BOOL_DEFINE );
		$pb1O9z = pb1Oa0( pb1la1( $pb1O9z, TRUE_BOOL_DEFINE ) - pb1la1( $pb1la0, TRUE_BOOL_DEFINE ) );
		$pb1O96 .= $pb1O9z;
	}

	return pb1O3i( $pb1O96 );
}

function pb1Oa1( $pb1O9y, $pb1la2 = FALSE_BOOL_DEFINE, $pb1Oa2 = FALSE_BOOL_DEFINE ) {
	$pb1O9y = trim_wrapper( prepare_keywords( $pb1O9y ) );
	if ( empty( $pb1O9y ) ) {
		return array();
	}
	$pb1la3 = explode( " ", $pb1O9y );
	if ( TRUE_BOOL_DEFINE === $pb1la2 ) {
		$pb1la3 = pb1O47( $pb1la3 );
	}
	$pb1O7a = array();
	foreach ( $pb1la3 as $pb1O2q => $pb1l49 ) {
		if ( isset ( $pb1O7a[ $pb1l49 ] ) ) {
			$pb1O7a[ $pb1l49 ] ++;
		} else {
			$pb1O7a[ $pb1l49 ] = 1;
		}
	}
	if ( FALSE_BOOL_DEFINE !== $pb1Oa2 ) {
		if ( TRUE_BOOL_DEFINE === $pb1Oa2 ) {
			$pb1Oa2 = "DESC";
		}
		if ( is_string( $pb1Oa2 ) ) {
			$pb1Oa2 = pb1l1q( $pb1Oa2 );
			if ( "ASC" == $pb1Oa2 ) {
				asort( $pb1O7a );
			} elseif ( "DESC" == $pb1Oa2 ) {
				arsort( $pb1O7a );
			}
		}
	}

	return $pb1O7a;
}

function prepare_keywords( $pb1O9y, $pb1O41 = FALSE_BOOL_DEFINE ) {
	$pb1O9y = strip_shortcodes( $pb1O9y );
	$pb1O9y = strip_tags( $pb1O9y );
	$pb1O9y = html_entity_decode_plus( $pb1O9y );
	$pb1la4 = array();
	$pb1O9y = pb1Oa4( $pb1O9y, $pb1la4 );
	$pb1O9y = pb1la5( $pb1O9y );
	$pb1O9y = pb1Oa5( $pb1O9y );
	$pb1O9y = pb1la6( $pb1O9y );
	$pb1O9y = pb1Oa6( $pb1O9y );
	$pb1O9y = str_replace( ".", " ", $pb1O9y );
	$pb1O9y = pb1la7( $pb1O9y );
	$pb1O9y = pb1Oa7( $pb1O9y, $pb1la4 );
	$pb1O9y = pb1la8( $pb1O9y );
	$pb1O9y = pb1Oa8( $pb1O9y );

	return $pb1O9y;
}

function pb1O6g( $pb1O4x, $pb1O41 = FALSE_BOOL_DEFINE ) {
	$pb1O4x = strip_shortcodes( $pb1O4x );
	$pb1O4x = nl2br( $pb1O4x );
	$pb1la9 = array( "<br>", "<br/>", "<br />" );
	$pb1O4x = str_replace( $pb1la9, "xbrxdelimiter", $pb1O4x );
	$pb1O4x = @preg_replace( '/(xbrxdelimiter[ ]{0,}){1,}/', ". ", $pb1O4x );
	$pb1Oa9 = array( "div", "p", "h1", "h2", "h3", "h4", "h5", "h6", "blockquote", "li", );
	$pb1laa = array();
	$pb1Oaa = array();
	foreach ( $pb1Oa9 as $pb1lab => $pb1Oab ) {
		$pb1laa[ $pb1lab ] = '</' . $pb1Oab . '>';
		$pb1Oaa[ $pb1lab ] = " x" . $pb1Oab . "xdelimiterx" . $pb1laa[ $pb1lab ];
	}
	$pb1O4x = str_replace( $pb1laa, $pb1Oaa, $pb1O4x );
	$pb1O4x = strip_tags( $pb1O4x );
	$pb1O4x = html_entity_decode_plus( $pb1O4x );
	$pb1la4 = array();
	$pb1O4x = pb1Oa4( $pb1O4x, $pb1la4 );
	$pb1O4x = pb1la5( $pb1O4x );
	$pb1O4x = pb1Oa5( $pb1O4x );
	$pb1O4x = pb1la6( $pb1O4x );
	foreach ( $pb1Oa9 as $pb1lab => $pb1Oab ) {
		$pb1lac = ' x' . $pb1Oab . 'xdelimiterx';
		$pb1O4x = str_replace( $pb1lac, ". ", $pb1O4x );
	}
	$pb1O4x = pb1Oa6( $pb1O4x );
	$pb1O4x = pb1la7( $pb1O4x );
	$pb1O4x = implode( ". ", explode( ".", $pb1O4x ) ) . ".";
	$pb1O4x = pb1Oa7( $pb1O4x, $pb1la4 );
	$pb1O4x = pb1la8( $pb1O4x );
	$pb1O4x = pb1Oa8( $pb1O4x );

	return $pb1O4x;
}

function html_entity_decode_plus( $pb1O9y, $pb1O41 = FALSE_BOOL_DEFINE ) {
	$pb1O9y = str_replace( "&nbsp;", " ", $pb1O9y );
	if ( ( pb1O1o != "UTF-8" ) || ( TRUE_BOOL_DEFINE === $pb1O41 ) || ( FALSE_BOOL_DEFINE === pb1l1w ) ) {
		$pb1O9y = @html_entity_decode( $pb1O9y, ENT_QUOTES );
	} else {
		$pb1O9y = @html_entity_decode( $pb1O9y, ENT_QUOTES, "UTF-8" );
	}

	return $pb1O9y;
}

function pb1Oa4( $pb1O9y, &$pb1la4 = array(), $pb1O41 = FALSE_BOOL_DEFINE ) {
	$pb1Oac = array();
	if ( ( pb1O1o != "UTF-8" ) || ( TRUE_BOOL_DEFINE === $pb1O41 ) || ( FALSE_BOOL_DEFINE === pb1l1w ) ) {
		@preg_match_all( '/((http|https)\\:\\/\\/){0,1}((([' . pb1Oo . pb1lp . '\\-\\_]{2,})\\.){1,}(' . pb1lq . '))\\b/i', $pb1O9y, $pb1Oac );
	} else {
		@preg_match_all( '/((http|https)\\:\\/\\/){0,1}((([' . pb1lo . pb1lp . '\\-\\_]{2,})\\.){1,}(' . pb1lq . '))\\b/iu', $pb1O9y, $pb1Oac );
	}
	if ( isset ( $pb1Oac[3] ) && ( count( $pb1Oac[3] ) ) ) {
		$pb1lad = FALSE_BOOL_DEFINE;
		if ( isset ( $pb1Oac[1] ) ) {
			$pb1lad = $pb1Oac[1];
		}
		$pb1Oac = $pb1Oac[3];
		foreach ( $pb1Oac as $pb1O2q => $pb1l2r ) {
			$pb1Oad = "x" . $pb1O2q . "xdomainx";
			if ( FALSE_BOOL_DEFINE !== $pb1lad ) {
				$pb1O9y = str_replace( array( $pb1l2r, $pb1lad[ $pb1O2q ] ), array( $pb1Oad, " " ), $pb1O9y );
			} else {
				$pb1O9y = str_replace( $pb1l2r, $pb1Oad, $pb1O9y );
			}
			$pb1la4[ $pb1Oad ] = $pb1l2r;
		}
	}

	return $pb1O9y;
}

function pb1Oa7( $pb1O40, $pb1la4 = array() ) {
	if ( ( is_array( $pb1O40 ) ) && ( count( $pb1O40 ) ) && ( count( $pb1la4 ) ) ) {
		foreach ( $pb1O40 as $pb1O2q => $pb1l2r ) {
			if ( count( $pb1la4 ) ) {
				foreach ( $pb1la4 as $pb1lae => $pb1Oae ) {
					$pb1O40[ $pb1O2q ] = str_replace( $pb1lae, $pb1Oae, $pb1l2r );
				}
			}
		}
	} else if ( ( is_string( $pb1O40 ) ) && ( count( $pb1la4 ) ) ) {
		foreach ( $pb1la4 as $pb1lae => $pb1Oae ) {
			$pb1O40 = str_replace( $pb1lae, $pb1Oae, $pb1O40 );
		}
	}

	return $pb1O40;
}

function pb1la5( $pb1O9y ) {
	$pb1O9y = @preg_replace( '/([' . pb1lp . ']{1})\\.([' . pb1lp . ']{1})/', "$1xdecimalxdelimiterx$2", $pb1O9y );
	$pb1O9y = @preg_replace( '/([' . pb1lp . ']{1})\\,([' . pb1lp . ']{1})/', "$1xcommaxdelimiterx$2", $pb1O9y );

	return $pb1O9y;
}

function pb1Oa5( $pb1O9y, $pb1O41 = FALSE_BOOL_DEFINE ) {
	if ( ( pb1O1o != "UTF-8" ) || ( TRUE_BOOL_DEFINE === $pb1O41 ) || ( FALSE_BOOL_DEFINE === pb1l1w ) ) {
		$pb1O9y = @preg_replace( '/([' . pb1Oo . pb1lp . ']{1})\'([' . pb1Oo . pb1lp . ']{1})/', "$1xapostrophexdelimiterx$2", $pb1O9y );
	} else {
		$pb1O9y = @preg_replace( '/([' . pb1lo . pb1lp . ']{1})\'([' . pb1lo . pb1lp . ']{1})/iu', "$1xapostrophexdelimiterx$2", $pb1O9y );
	}

	return $pb1O9y;
}

function pb1la8( $pb1O9y ) {
	$pb1O9y = str_replace( "xdecimalxdelimiterx", ".", $pb1O9y );
	$pb1O9y = str_replace( "xcommaxdelimiterx", ",", $pb1O9y );

	return $pb1O9y;
}

function pb1Oa8( $pb1O9y ) {
	$pb1O9y = str_replace( "xapostrophexdelimiterx", "'", $pb1O9y );

	return $pb1O9y;
}

function pb1la6( $pb1O9y, $pb1O41 = FALSE_BOOL_DEFINE ) {
	if ( ( pb1O1o != "UTF-8" ) || ( TRUE_BOOL_DEFINE === $pb1O41 ) || ( FALSE_BOOL_DEFINE === pb1l1w ) ) {
		$pb1O9y = @preg_replace( '/[^' . pb1Oo . pb1lp . pb1Op . ']/', ' ', $pb1O9y );
	} else {
		$pb1O9y = @preg_replace( '/[^' . pb1lo . pb1lp . pb1Op . ']/iu', ' ', $pb1O9y );
	}

	return $pb1O9y;
}

function pb1Oa6( $pb1O9y, $pb1O41 = FALSE_BOOL_DEFINE ) {
	$pb1l3c = pb1laf( stripslashes( pb1Op ) );
	foreach ( $pb1l3c as $pb1O9z ) {
		if ( ( pb1O1o != "UTF-8" ) || ( TRUE_BOOL_DEFINE === $pb1O41 ) || ( FALSE_BOOL_DEFINE === pb1l1w ) ) {
			$pb1O9y = @preg_replace( '/[' . @preg_quote( $pb1O9z ) . ']{1}[^' . pb1Oo . pb1lp . ']{1,}/', $pb1O9z, $pb1O9y );
		} else {
			$pb1O9y = @preg_replace( '/[' . @preg_quote( $pb1O9z ) . ']{1}[^' . pb1lo . pb1lp . ']{1,}/iu', $pb1O9z, $pb1O9y );
		}
	}

	return $pb1O9y;
}

function pb1la7( $pb1O9y ) {
	$pb1l3c = pb1laf( stripslashes( pb1Op ) );
	foreach ( $pb1l3c as $pb1O9z ) {
		$pb1O9y = @preg_replace( '/^[' . @preg_quote( $pb1O9z ) . ']{1,}/', '', $pb1O9y );
		$pb1O9y = @preg_replace( '/[' . @preg_quote( $pb1O9z ) . ']{1,}$/', '', $pb1O9y );
	}

	return $pb1O9y;
}

function strip_shortcodes_wrapper( $pb1O9y ) {
	return strip_shortcodes( $pb1O9y );
}

function pb1O47( $pb1O40, $pb1Oaf = pb1l1r, $pb1lag = FALSE_BOOL_DEFINE ) {
	$pb1Oag = "array";
	if ( is_string( $pb1O40 ) ) {
		$pb1Oag = "string";
		$pb1O40 = trim_wrapper( $pb1O40 );
		$pb1O40 = @preg_replace( '/[ ]{2,}/', ' ', $pb1O40 );
		$pb1O40 = explode( ' ', $pb1O40 );
	}
	if ( ! is_array( $pb1O40 ) ) {
		return $pb1O40;
	}
	$pb1la2 = pb1lah( $pb1Oaf, $pb1lag );
	foreach ( $pb1O40 as $pb1O2q => $pb1l49 ) {
		$pb1l49 = pb1O2p( $pb1l49 );
		if ( ( pb_string_length( $pb1l49 ) < 1 ) || ( in_array( $pb1l49, $pb1la2 ) ) ) {
			$pb1O40[ $pb1O2q ] = '';
		}
	}
	$pb1O40 = implode( ' ', $pb1O40 );
	$pb1O40 = trim_wrapper( @preg_replace( '/[ ]{2,}/', ' ', $pb1O40 ) );
	if ( "string" == $pb1Oag ) {
		return $pb1O40;
	} else {
		return explode( ' ', $pb1O40 );
	}
}

function pb1lah( $pb1Oaf = pb1l1r, $pb1lag = FALSE_BOOL_DEFINE ) {
	switch ( $pb1Oaf ) {
		case "DE":
		case "FR":
		case "ES":
		default :
			$pb1l3c = array(
				"a",
				"all",
				"also",
				"am",
				"an",
				"and",
				"are",
				"as",
				"at",
				"be",
				"been",
				"but",
				"by",
				"do",
				"don't",
				"else",
				"etc",
				"for",
				"had",
				"has",
				"ie",
				"if",
				"i'll",
				"i'm",
				"in",
				"inc",
				"into",
				"is",
				"it",
				"it's",
				"its",
				"lol",
				"lmao",
				"lmfao",
				"me",
				"my",
				"of",
				"or",
				"rofl",
				"roflmao",
				"so",
				"than",
				"that",
				"the",
				"then",
				"there",
				"these",
				"this",
				"to",
				"too",
				"was",
				"were",
				"which",
				"will",
				"with",
			);
			if ( TRUE_BOOL_DEFINE === $pb1lag ) {
				$pb1Oah = array(
					"also",
					"another",
					"any",
					"anybody",
					"can",
					"can't",
					"could",
					"couldn't",
					"didn't",
					"does",
					"doesn't",
					"even",
					"everybody",
					"go",
					"goes",
					"hadn't",
					"hasn't",
					"however",
					"just",
					"lets",
					"let's",
					"mine",
					"nobody",
					"off",
					"on",
					"them",
					"they",
					"they'll",
					"they're",
					"those",
					"us",
					"we",
					"we're",
					"you",
					"you'll",
					"you're",
					"your",
				);
			}
			if ( TRUE_BOOL_DEFINE == $pb1lag ) {
				return array_merge( $pb1l3c, $pb1Oah );
			} else {
				return $pb1l3c;
			}
			break;
	}
}

function pb1lai( $pb1O9y ) {
	$pb1Oai = '/\\[caption[^\\]]{0,}\\]/iu';
	$pb1O9y = @preg_replace( $pb1Oai, ' ', $pb1O9y );
	$pb1O9y = str_replace( "[/caption]", ' ', $pb1O9y );

	return $pb1O9y;
}

function pb1laj( $pb1l9l, $pb1Oaj, $pb1lak = null ) {
	if ( null === $pb1lak ) {
		$pb1lak = "&hellip;";
	}
	if ( pb_string_length( $pb1l9l ) > $pb1Oaj ) {
		$pb1l9l = pb1O1q( $pb1l9l, 0, pb1O2r( $pb1l9l, ' ', $pb1Oaj ) ) . $pb1lak;
	}

	return $pb1l9l;
} ?>
