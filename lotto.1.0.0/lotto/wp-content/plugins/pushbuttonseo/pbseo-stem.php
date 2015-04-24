<?php class StemClass {
	private static $pb1O9n = '(?:[bcdfghjklmnpqrstvwxz]|(?<=[aeiou])y|^y)';
	private static $pb1l9o = '(?:[aeiou]|(?<![aeiou])y)';

	public static function stem_it( $pb1O9o ) {
		if ( strlen( $pb1O9o ) <= 2 ) {
			return $pb1O9o;
		}
		$pb1O9o = self::pb1l9p( $pb1O9o );
		$pb1O9o = self::pb1O9p( $pb1O9o );
		$pb1O9o = self::pb1l9q( $pb1O9o );
		$pb1O9o = self::pb1O9q( $pb1O9o );
		$pb1O9o = self::pb1l9r( $pb1O9o );
		$pb1O9o = self::pb1O9r( $pb1O9o );

		return $pb1O9o;
	}

	private static function pb1l9p( $pb1O9o ) {
		if ( substr( $pb1O9o, - 1 ) == 's' ) {
			self::pb1l9s( $pb1O9o, 'sses', 'ss' ) or self::pb1l9s( $pb1O9o, 'ies', 'i' ) or self::pb1l9s( $pb1O9o, 'ss', 'ss' ) or self::pb1l9s( $pb1O9o, 's', '' );
		}
		if ( substr( $pb1O9o, - 2, 1 ) != 'e' or ! self::pb1l9s( $pb1O9o, 'eed', 'ee', 0 ) ) {
			$pb1O9s = self::$pb1l9o;
			if ( preg_match( "#$pb1O9s+#", substr( $pb1O9o, 0, - 3 ) ) && self::pb1l9s( $pb1O9o, 'ing', '' ) or preg_match( "#$pb1O9s+#", substr( $pb1O9o, 0, - 2 ) ) && self::pb1l9s( $pb1O9o, 'ed', '' ) ) {
				if ( ! self::pb1l9s( $pb1O9o, 'at', 'ate' ) and ! self::pb1l9s( $pb1O9o, 'bl', 'ble' ) and ! self::pb1l9s( $pb1O9o, 'iz', 'ize' ) ) {
					if ( self::pb1l9t( $pb1O9o ) and substr( $pb1O9o, - 2 ) != 'll' and substr( $pb1O9o, - 2 ) != 'ss' and substr( $pb1O9o, - 2 ) != 'zz' ) {
						$pb1O9o = substr( $pb1O9o, 0, - 1 );
					} else if ( self::pb1O9t( $pb1O9o ) == 1 and self::pb1l9u( $pb1O9o ) ) {
						$pb1O9o .= 'e';
					}
				}
			}
		}

		return $pb1O9o;
	}

	private static function pb1O9p( $pb1O9o ) {
		$pb1O9s = self::$pb1l9o;
		if ( substr( $pb1O9o, - 1 ) == 'y' && preg_match( "#$pb1O9s+#", substr( $pb1O9o, 0, - 1 ) ) ) {
			self::pb1l9s( $pb1O9o, 'y', 'i' );
		}

		return $pb1O9o;
	}

	private static function pb1l9q( $pb1O9o ) {
		switch ( substr( $pb1O9o, - 2, 1 ) ) {
			case 'a':
				self::pb1l9s( $pb1O9o, 'ational', 'ate', 0 ) or self::pb1l9s( $pb1O9o, 'tional', 'tion', 0 );
				break;
			case 'c':
				self::pb1l9s( $pb1O9o, 'enci', 'ence', 0 ) or self::pb1l9s( $pb1O9o, 'anci', 'ance', 0 );
				break;
			case 'e':
				self::pb1l9s( $pb1O9o, 'izer', 'ize', 0 );
				break;
			case 'g':
				self::pb1l9s( $pb1O9o, 'logi', 'log', 0 );
				break;
			case 'l':
				self::pb1l9s( $pb1O9o, 'entli', 'ent', 0 ) or self::pb1l9s( $pb1O9o, 'ousli', 'ous', 0 ) or self::pb1l9s( $pb1O9o, 'alli', 'al', 0 ) or self::pb1l9s( $pb1O9o, 'bli', 'ble', 0 ) or self::pb1l9s( $pb1O9o, 'eli', 'e', 0 );
				break;
			case 'o':
				self::pb1l9s( $pb1O9o, 'ization', 'ize', 0 ) or self::pb1l9s( $pb1O9o, 'ation', 'ate', 0 ) or self::pb1l9s( $pb1O9o, 'ator', 'ate', 0 );
				break;
			case 's':
				self::pb1l9s( $pb1O9o, 'iveness', 'ive', 0 ) or self::pb1l9s( $pb1O9o, 'fulness', 'ful', 0 ) or self::pb1l9s( $pb1O9o, 'ousness', 'ous', 0 ) or self::pb1l9s( $pb1O9o, 'alism', 'al', 0 );
				break;
			case 't':
				self::pb1l9s( $pb1O9o, 'biliti', 'ble', 0 ) or self::pb1l9s( $pb1O9o, 'aliti', 'al', 0 ) or self::pb1l9s( $pb1O9o, 'iviti', 'ive', 0 );
				break;
		}

		return $pb1O9o;
	}

	private static function pb1O9q( $pb1O9o ) {
		switch ( substr( $pb1O9o, - 2, 1 ) ) {
			case 'a':
				self::pb1l9s( $pb1O9o, 'ical', 'ic', 0 );
				break;
			case 's':
				self::pb1l9s( $pb1O9o, 'ness', '', 0 );
				break;
			case 't':
				self::pb1l9s( $pb1O9o, 'icate', 'ic', 0 ) or self::pb1l9s( $pb1O9o, 'iciti', 'ic', 0 );
				break;
			case 'u':
				self::pb1l9s( $pb1O9o, 'ful', '', 0 );
				break;
			case 'v':
				self::pb1l9s( $pb1O9o, 'ative', '', 0 );
				break;
			case 'z':
				self::pb1l9s( $pb1O9o, 'alize', 'al', 0 );
				break;
		}

		return $pb1O9o;
	}

	private static function pb1l9r( $pb1O9o ) {
		switch ( substr( $pb1O9o, - 2, 1 ) ) {
			case 'a':
				self::pb1l9s( $pb1O9o, 'al', '', 1 );
				break;
			case 'c':
				self::pb1l9s( $pb1O9o, 'ance', '', 1 ) or self::pb1l9s( $pb1O9o, 'ence', '', 1 );
				break;
			case 'e':
				self::pb1l9s( $pb1O9o, 'er', '', 1 );
				break;
			case 'i':
				self::pb1l9s( $pb1O9o, 'ic', '', 1 );
				break;
			case 'l':
				self::pb1l9s( $pb1O9o, 'able', '', 1 ) or self::pb1l9s( $pb1O9o, 'ible', '', 1 );
				break;
			case 'n':
				self::pb1l9s( $pb1O9o, 'ant', '', 1 ) or self::pb1l9s( $pb1O9o, 'ement', '', 1 ) or self::pb1l9s( $pb1O9o, 'ment', '', 1 ) or self::pb1l9s( $pb1O9o, 'ent', '', 1 );
				break;
			case 'o':
				if ( substr( $pb1O9o, - 4 ) == 'tion' or substr( $pb1O9o, - 4 ) == 'sion' ) {
					self::pb1l9s( $pb1O9o, 'ion', '', 1 );
				} else {
					self::pb1l9s( $pb1O9o, 'ou', '', 1 );
				}
				break;
			case 's':
				self::pb1l9s( $pb1O9o, 'ism', '', 1 );
				break;
			case 't':
				self::pb1l9s( $pb1O9o, 'ate', '', 1 ) or self::pb1l9s( $pb1O9o, 'iti', '', 1 );
				break;
			case 'u':
				self::pb1l9s( $pb1O9o, 'ous', '', 1 );
				break;
			case 'v':
				self::pb1l9s( $pb1O9o, 'ive', '', 1 );
				break;
			case 'z':
				self::pb1l9s( $pb1O9o, 'ize', '', 1 );
				break;
		}

		return $pb1O9o;
	}

	private static function pb1O9r( $pb1O9o ) {
		if ( substr( $pb1O9o, - 1 ) == 'e' ) {
			if ( self::pb1O9t( substr( $pb1O9o, 0, - 1 ) ) > 1 ) {
				self::pb1l9s( $pb1O9o, 'e', '' );
			} else if ( self::pb1O9t( substr( $pb1O9o, 0, - 1 ) ) == 1 ) {
				if ( ! self::pb1l9u( substr( $pb1O9o, 0, - 1 ) ) ) {
					self::pb1l9s( $pb1O9o, 'e', '' );
				}
			}
		}
		if ( self::pb1O9t( $pb1O9o ) > 1 and self::pb1l9t( $pb1O9o ) and substr( $pb1O9o, - 1 ) == 'l' ) {
			$pb1O9o = substr( $pb1O9o, 0, - 1 );
		}

		return $pb1O9o;
	}

	private static function pb1l9s( &$pb1O9u, $pb1l9v, $pb1O9v, $pb1l9w = null ) {
		$pb1O9w = 0 - strlen( $pb1l9v );
		if ( substr( $pb1O9u, $pb1O9w ) == $pb1l9v ) {
			$pb1l9x = substr( $pb1O9u, 0, $pb1O9w );
			if ( is_null( $pb1l9w ) or self::pb1O9t( $pb1l9x ) > $pb1l9w ) {
				$pb1O9u = $pb1l9x . $pb1O9v;
			}

			return TRUE;
		}

		return FALSE;
	}

	private static function pb1O9t( $pb1O9u ) {
		$pb1O9x = self::$pb1O9n;
		$pb1O9s = self::$pb1l9o;
		$pb1O9u = preg_replace( "#^$pb1O9x+#", '', $pb1O9u );
		$pb1O9u = preg_replace( "#$pb1O9s+$#", '', $pb1O9u );
		preg_match_all( "#($pb1O9s+$pb1O9x+)#", $pb1O9u, $pb1l9y );

		return count( $pb1l9y[1] );
	}

	private static function pb1l9t( $pb1O9u ) {
		$pb1O9x = self::$pb1O9n;

		return preg_match( "#$pb1O9x{2}$#", $pb1O9u, $pb1l9y ) and $pb1l9y[0]{0} == $pb1l9y[0]{1};
	}

	private static function pb1l9u( $pb1O9u ) {
		$pb1O9x = self::$pb1O9n;
		$pb1O9s = self::$pb1l9o;

		return preg_match( "#($pb1O9x$pb1O9s$pb1O9x)$#", $pb1O9u, $pb1l9y ) and strlen( $pb1l9y[1] ) == 3 and $pb1l9y[1]{2} != 'w' and $pb1l9y[1]{2} != 'x' and $pb1l9y[1]{2} != 'y';
	}
} ?>