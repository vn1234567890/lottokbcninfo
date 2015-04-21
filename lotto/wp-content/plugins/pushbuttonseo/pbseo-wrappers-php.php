<?php function pb1lb8( $pb1Ob8, $pb1lb9 ) {
	define( $pb1Ob8, $pb1lb9 );
}

function function_exists_wrapper( $pb1Ob9 ) {
	return function_exists( $pb1Ob9 );
}

function trim_wrapper( $pb1O3b ) {
	return trim( $pb1O3b );
}

function pb1O1q( $pb1O3b, $pb1Ob3, $pb1Oap = FALSE, $pb1O41 = FALSE_BOOL_DEFINE ) {
	if ( ( pb1O1o != "UTF-8" ) || ( TRUE_BOOL_DEFINE === $pb1O41 ) ) {
		if ( FALSE === $pb1Oap ) {
			return substr( $pb1O3b, $pb1Ob3 );
		} else {
			return substr( $pb1O3b, $pb1Ob3, $pb1Oap );
		}
	}
	if ( FALSE === $pb1Oap ) {
		return pb1las( $pb1O3b, $pb1Ob3 );
	} else {
		return pb1las( $pb1O3b, $pb1Ob3, $pb1Oap );
	}
}

function pb1lba( $pb1O3b, $pb1Oba, $pb1Ob3, $pb1Oap = null, $pb1O41 = FALSE_BOOL_DEFINE ) {
	if ( ( pb1O1o != "UTF-8" ) || ( TRUE_BOOL_DEFINE === $pb1O41 ) ) {
		if ( empty( $pb1Oap ) ) {
			return substr_replace( $pb1O3b, $pb1Oba, $pb1Ob3 );
		} else {
			return substr_replace( $pb1O3b, $pb1Oba, $pb1Ob3, $pb1Oap );
		}
	}
	if ( empty( $pb1Oap ) ) {
		return pb1lb2( $pb1O3b, $pb1Oba, $pb1Ob3 );
	} else {
		return pb1lb2( $pb1O3b, $pb1Oba, $pb1Ob3, $pb1Oap );
	}
}

function pb1O2r( $pb1lbb, $pb1lar, $pb1Oar = 0, $pb1O41 = FALSE_BOOL_DEFINE ) {
	if ( ( pb1O1o != "UTF-8" ) || ( TRUE_BOOL_DEFINE === $pb1O41 ) ) {
		return strpos( $pb1lbb, $pb1lar, $pb1Oar );
	}

	return pb1Oaq( $pb1lbb, $pb1lar, $pb1Oar );
}

function pb_string_length( $pb1O3b, $pb1O41 = FALSE_BOOL_DEFINE ) {
	if ( ( pb1O1o != "UTF-8" ) || ( TRUE_BOOL_DEFINE === $pb1O41 ) ) {
		return strlen( $pb1O3b );
	}

	return pb_mbstring_length( $pb1O3b );
}

function pb1laf( $pb1O3b, $pb1lap = 1, $pb1O41 = FALSE_BOOL_DEFINE ) {
	if ( ( pb1O1o != "UTF-8" ) || ( TRUE_BOOL_DEFINE === $pb1O41 ) ) {
		return str_split( $pb1O3b, $pb1lap );
	}

	return pb1Oao( $pb1O3b, $pb1lap );
}

function pb1la1( $pb1O3b, $pb1O41 = FALSE_BOOL_DEFINE ) {
	if ( ( pb1O1o != "UTF-8" ) || ( TRUE_BOOL_DEFINE === $pb1O41 ) ) {
		return ord( $pb1O3b );
	}

	return pb1Oak( $pb1O3b );
}

function pb1Oa0( $pb1O9z ) {
	return chr( $pb1O9z );
}

function pb_htmlspecialchars( $pb1O3b, $pb1O41 = FALSE_BOOL_DEFINE ) {
	if ( ( pb1O1o != "UTF-8" ) || ( TRUE_BOOL_DEFINE === $pb1O41 ) ) {
		return htmlspecialchars( $pb1O3b );
	}

	return htmlspecialchars( $pb1O3b, ENT_COMPAT, "UTF-8" );
}

function pb1O2p( $pb1O3b, $pb1O41 = FALSE_BOOL_DEFINE ) {
	if ( ( pb1O1o != "UTF-8" ) || ( TRUE_BOOL_DEFINE === $pb1O41 ) ) {
		return strtolower( $pb1O3b );
	}

	return pb1Oaw( $pb1O3b );
}

function pb1l1q( $pb1O3b, $pb1O41 = FALSE_BOOL_DEFINE ) {
	if ( ( pb1O1o != "UTF-8" ) || ( TRUE_BOOL_DEFINE === $pb1O41 ) ) {
		return strtoupper( $pb1O3b );
	}

	return pb1laz( $pb1O3b );
}

function pb1O7b( $pb1O3b, $pb1O41 = FALSE_BOOL_DEFINE ) {
	if ( ( pb1O1o != "UTF-8" ) || ( TRUE_BOOL_DEFINE === $pb1O41 ) ) {
		return ucwords( $pb1O3b );
	}

	return pb1Oaz( $pb1O3b );
}

function pb1l6v( $pb1O3b, $pb1O41 = FALSE_BOOL_DEFINE ) {
	if ( ( pb1O1o != "UTF-8" ) || ( TRUE_BOOL_DEFINE === $pb1O41 ) ) {
		return ucfirst( $pb1O3b );
	}

	return pb1Ob2( $pb1O3b );
}

function pb1O39( $pb1O62, $pb1O38 = FALSE_BOOL_DEFINE ) {
	if ( empty( $pb1O38 ) ) {
		return @parse_url( $pb1O62 );
	} else {
		return @parse_url( $pb1O62, $pb1O38 );
	}
}

function pb1O3q( $pb1O3b ) {
	if ( is_string( $pb1O3b ) ) {
		return base64_encode( $pb1O3b );
	} else {
		return $pb1O3b;
	}
}

function pb1O3i( $pb1O3b ) {
	if ( is_string( $pb1O3b ) ) {
		return base64_decode( $pb1O3b );
	} else {
		return $pb1O3b;
	}
} ?>