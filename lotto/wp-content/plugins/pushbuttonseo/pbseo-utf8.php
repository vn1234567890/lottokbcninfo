<?php function pb1Oak( $pb1lal ) {
	if ( empty( $pb1lal ) ) {
		return FALSE;
	}
	$pb1Oal = ord( $pb1lal );
	if ( $pb1Oal >= 0 && $pb1Oal <= 0177 ) {
		return $pb1Oal;
	}
	if ( ! isset ( $pb1lal{1} ) ) {
		trigger_error( "Short sequence - at least 2 bytes expected, only 1 seen" );

		return FALSE;
	}
	$pb1lam = ord( $pb1lal{1} );
	if ( $pb1Oal >= 0300 && $pb1Oal <= 0337 ) {
		return ( $pb1Oal - 0300 ) * 0100 + ( $pb1lam - 0200 );
	}
	if ( ! isset ( $pb1lal{2} ) ) {
		trigger_error( "Short sequence - at least 3 bytes expected, only 2 seen" );

		return FALSE;
	}
	$pb1Oam = ord( $pb1lal{2} );
	if ( $pb1Oal >= 0340 && $pb1Oal <= 0357 ) {
		return ( $pb1Oal - 0340 ) * 010000 + ( $pb1lam - 0200 ) * 0100 + ( $pb1Oam - 0200 );
	}
	if ( ! isset ( $pb1lal{3} ) ) {
		trigger_error( "Short sequence - at least 4 bytes expected, only 3 seen" );

		return FALSE;
	}
	$pb1lan = ord( $pb1lal{3} );
	if ( $pb1Oal >= 0360 && $pb1Oal <= 0367 ) {
		return ( $pb1Oal - 0360 ) * 01000000 + ( $pb1lam - 0200 ) * 010000 + ( $pb1Oam - 0200 ) * 0100 + ( $pb1lan - 0200 );
	}
	if ( ! isset ( $pb1lal{4} ) ) {
		trigger_error( "Short sequence - at least 5 bytes expected, only 4 seen" );

		return FALSE;
	}
	$pb1Oan = ord( $pb1lal{4} );
	if ( $pb1Oal >= 0370 && $pb1Oal <= 0373 ) {
		return ( $pb1Oal - 0370 ) * 0100000000 + ( $pb1lam - 0200 ) * 01000000 + ( $pb1Oam - 0200 ) * 010000 + ( $pb1lan - 0200 ) * 0100 + ( $pb1Oan - 0200 );
	}
	if ( ! isset ( $pb1lal{5} ) ) {
		trigger_error( "Short sequence - at least 6 bytes expected, only 5 seen" );

		return FALSE;
	}
	if ( $pb1Oal >= 0374 && $pb1Oal <= 0375 ) {
		return ( $pb1Oal - 0374 ) * 010000000000 + ( $pb1lam - 0200 ) * 0100000000 + ( $pb1Oam - 0200 ) * 01000000 + ( $pb1lan - 0200 ) * 010000 + ( $pb1Oan - 0200 ) * 0100 + ( ord( $pb1lal{5} ) - 0200 );
	}
	if ( $pb1Oal >= 0376 && $pb1Oal <= 0377 ) {
		trigger_error( "Invalid UTF-8 with surrogate ordinal " . $pb1Oal );

		return FALSE;
	}
}

function pb_mbstring_length( $pb1O3b ) {
	if ( empty( $pb1O3b ) ) {
		return 0;
	}
	if ( function_exists_wrapper( "mb_strlen" ) ) {
		return mb_strlen( $pb1O3b );
	}

	return strlen( utf8_decode( $pb1O3b ) );
}

function pb1Oao( $pb1O3b, $pb1lap = 1 ) {
	if ( ( empty( $pb1O3b ) ) || ( empty( $pb1lap ) ) ) {
		return FALSE_BOOL_DEFINE;
	}
	if ( ! @preg_match( '/^[0-9]+$/', $pb1lap ) || $pb1lap < 1 ) {
		return FALSE_BOOL_DEFINE;
	}
	$pb1Oap = pb_mbstring_length( $pb1O3b );
	if ( $pb1Oap <= $pb1lap ) {
		return array( $pb1O3b );
	}
	@preg_match_all( '/.{' . $pb1lap . '}|[^\\x00]{1,' . $pb1lap . '}$/us', $pb1O3b, $pb1laq );

	return $pb1laq[0];
}

function pb1Oaq( $pb1O3b, $pb1lar, $pb1Oar = null ) {
	if ( ( empty( $pb1O3b ) ) || ( empty( $pb1lar ) ) ) {
		return FALSE;
	}
	if ( function_exists_wrapper( "mb_strpos" ) ) {
		if ( is_null( $pb1Oar ) ) {
			return mb_strpos( $pb1O3b, $pb1lar );
		} else {
			return mb_strpos( $pb1O3b, $pb1lar, $pb1Oar );
		}
	}
	if ( is_null( $pb1Oar ) ) {
		$pb1laq = explode( $pb1lar, $pb1O3b, 2 );
		if ( count( $pb1laq ) > 1 ) {
			return pb_mbstring_length( $pb1laq[0] );
		}

		return FALSE;
	} else {
		if ( ! is_int( $pb1Oar ) ) {
			trigger_error( "pbseo_utf8_strpos: Offset must be an integer", E_USER_ERROR );

			return FALSE;
		}
		$pb1O3b = pb1las( $pb1O3b, $pb1Oar );
		if ( FALSE !== ( $pb1Oas = pb1Oaq( $pb1O3b, $pb1lar ) ) ) {
			return $pb1Oas + $pb1Oar;
		}

		return FALSE;
	}
}

function pb1las( $pb1O3b, $pb1Oar = 0, $pb1Oaj = null ) {
	if ( empty( $pb1O3b ) ) {
		return '';
	}
	if ( is_null( $pb1Oaj ) ) {
		return mb_substr( $pb1O3b, $pb1Oar );
	} else {
		return mb_substr( $pb1O3b, $pb1Oar, $pb1Oaj );
	}
	$pb1O3b = (string) $pb1O3b;
	$pb1Oar = (int) $pb1Oar;
	if ( ! is_null( $pb1Oaj ) ) {
		$pb1Oaj = (int) $pb1Oaj;
	}
	if ( $pb1Oaj === 0 ) {
		return '';
	}
	if ( $pb1Oar < 0 && $pb1Oaj < 0 && $pb1Oaj < $pb1Oar ) {
		return '';
	}
	if ( $pb1Oar < 0 ) {
		$pb1lat = strlen( utf8_decode( $pb1O3b ) );
		$pb1Oar = $pb1lat + $pb1Oar;
		if ( $pb1Oar < 0 ) {
			$pb1Oar = 0;
		}
	}
	$pb1Oat = '';
	$pb1lau = '';
	if ( $pb1Oar > 0 ) {
		$pb1Oau = (int) ( $pb1Oar / 0177777 );
		$pb1lav = $pb1Oar % 0177777;
		if ( $pb1Oau ) {
			$pb1Oat = '(?:.{65535}){' . $pb1Oau . '}';
		}
		$pb1Oat = '^(?:' . $pb1Oat . '.{' . $pb1lav . '})';
	} else {
		$pb1Oat = '^';
	}
	if ( is_null( $pb1Oaj ) ) {
		$pb1lau = '(.*)$';
	} else {
		if ( ! isset ( $pb1lat ) ) {
			$pb1lat = strlen( utf8_decode( $pb1O3b ) );
		}
		if ( $pb1Oar > $pb1lat ) {
			return '';
		}
		if ( $pb1Oaj > 0 ) {
			$pb1Oaj = min( $pb1lat - $pb1Oar, $pb1Oaj );
			$pb1Oav = (int) ( $pb1Oaj / 0177777 );
			$pb1law = $pb1Oaj % 0177777;
			if ( $pb1Oav ) {
				$pb1lau = '(?:.{65535}){' . $pb1Oav . '}';
			}
			$pb1lau = '(' . $pb1lau . '.{' . $pb1law . '})';
		} else if ( $pb1Oaj < 0 ) {
			if ( $pb1Oaj < ( $pb1Oar - $pb1lat ) ) {
				return '';
			}
			$pb1Oav = (int) ( ( - $pb1Oaj ) / 0177777 );
			$pb1law = ( - $pb1Oaj ) % 0177777;
			if ( $pb1Oav ) {
				$pb1lau = '(?:.{65535}){' . $pb1Oav . '}';
			}
			$pb1lau = '(.*)(?:' . $pb1lau . '.{' . $pb1law . '})$';
		}
	}
	if ( ! @preg_match( '#' . $pb1Oat . $pb1lau . '#us', $pb1O3b, $pb1l4r ) ) {
		return '';
	}

	return $pb1l4r[1];
}

function pb1Oaw( $pb1O9y ) {
	if ( empty( $pb1O9y ) ) {
		return '';
	}
	if ( function_exists_wrapper( "mb_strtolower" ) ) {
		return mb_strtolower( $pb1O9y );
	}
	static $PBSEO_UTF8_UPPER_TO_LOWER
	=
	null;
	if ( is_null( $PBSEO_UTF8_UPPER_TO_LOWER ) ) {
		$PBSEO_UTF8_UPPER_TO_LOWER = array( 0101   => 0141,
		                                    01646  => 01706,
		                                    0542   => 0543,
		                                    0305   => 0345,
		                                    0102   => 0142,
		                                    0471   => 0472,
		                                    0301   => 0341,
		                                    0501   => 0502,
		                                    01616  => 01715,
		                                    0400   => 0401,
		                                    02220  => 02221,
		                                    01624  => 01664,
		                                    0532   => 0533,
		                                    0104   => 0144,
		                                    01623  => 01663,
		                                    0324   => 0364,
		                                    02052  => 02112,
		                                    02031  => 02071,
		                                    0422   => 0423,
		                                    02034  => 02074,
		                                    0536   => 0537,
		                                    0503   => 0504,
		                                    0316   => 0356,
		                                    02016  => 02136,
		                                    02057  => 02117,
		                                    01632  => 01672,
		                                    0524   => 0525,
		                                    0111   => 0151,
		                                    0123   => 0163,
		                                    017036 => 017037,
		                                    0464   => 0465,
		                                    02047  => 02107,
		                                    01640  => 01700,
		                                    02030  => 02070,
		                                    0323   => 0363,
		                                    02040  => 02100,
		                                    02004  => 02124,
		                                    02025  => 02065,
		                                    02051  => 02111,
		                                    0512   => 0513,
		                                    02021  => 02061,
		                                    02011  => 02131,
		                                    017002 => 017003,
		                                    0326   => 0366,
		                                    0331   => 0371,
		                                    0116   => 0156,
		                                    02001  => 02121,
		                                    01644  => 01704,
		                                    02043  => 02103,
		                                    0534   => 0535,
		                                    02003  => 02123,
		                                    01650  => 01710,
		                                    0530   => 0531,
		                                    0107   => 0147,
		                                    0304   => 0344,
		                                    01606  => 01654,
		                                    01611  => 01656,
		                                    0546   => 0547,
		                                    01636  => 01676,
		                                    0544   => 0545,
		                                    0426   => 0427,
		                                    0410   => 0411,
		                                    0126   => 0166,
		                                    0336   => 0376,
		                                    0526   => 0527,
		                                    0332   => 0372,
		                                    017140 => 017141,
		                                    017202 => 017203,
		                                    0302   => 0342,
		                                    0430   => 0431,
		                                    0505   => 0506,
		                                    0120   => 0160,
		                                    0520   => 0521,
		                                    02056  => 02116,
		                                    0450   => 0451,
		                                    01647  => 01707,
		                                    0475   => 0476,
		                                    02042  => 02102,
		                                    0132   => 0172,
		                                    02050  => 02110,
		                                    01641  => 01701,
		                                    017200 => 017201,
		                                    0554   => 0555,
		                                    0325   => 0365,
		                                    0125   => 0165,
		                                    0566   => 0567,
		                                    0334   => 0374,
		                                    017126 => 017127,
		                                    01643  => 01703,
		                                    02032  => 02072,
		                                    0115   => 0155,
		                                    0552   => 0553,
		                                    0560   => 0561,
		                                    02044  => 02104,
		                                    0314   => 0354,
		                                    0550   => 0551,
		                                    01637  => 01677,
		                                    0113   => 0153,
		                                    0322   => 0362,
		                                    0300   => 0340,
		                                    02024  => 02064,
		                                    01651  => 01711,
		                                    017152 => 017153,
		                                    0303   => 0343,
		                                    02055  => 02115,
		                                    02026  => 02066,
		                                    0640   => 0641,
		                                    0414   => 0415,
		                                    0434   => 0435,
		                                    0320   => 0360,
		                                    0473   => 0474,
		                                    02017  => 02137,
		                                    02012  => 02132,
		                                    0310   => 0350,
		                                    01645  => 01705,
		                                    0106   => 0146,
		                                    0335   => 0375,
		                                    0103   => 0143,
		                                    01032  => 01033,
		                                    0312   => 0352,
		                                    01631  => 01671,
		                                    0571   => 0572,
		                                    0317   => 0357,
		                                    0657   => 0660,
		                                    0105   => 0145,
		                                    01633  => 01673,
		                                    01630  => 01670,
		                                    01634  => 01674,
		                                    02014  => 02134,
		                                    02037  => 02077,
		                                    02054  => 02114,
		                                    0336   => 0376,
		                                    0320   => 0360,
		                                    017362 => 017363,
		                                    0110   => 0150,
		                                    0313   => 0353,
		                                    0420   => 0421,
		                                    02023  => 02063,
		                                    0456   => 0457,
		                                    0306   => 0346,
		                                    0130   => 0170,
		                                    0540   => 0541,
		                                    0556   => 0557,
		                                    01621  => 01661,
		                                    02007  => 02127,
		                                    0562   => 0563,
		                                    0570   => 0377,
		                                    0117   => 0157,
		                                    02033  => 02073,
		                                    01625  => 01665,
		                                    02045  => 02105,
		                                    0440   => 0441,
		                                    0575   => 0576,
		                                    0573   => 0574,
		                                    01626  => 01666,
		                                    01622  => 01662,
		                                    01610  => 01655,
		                                    017204 => 017205,
		                                    0564   => 0565,
		                                    0121   => 0161,
		                                    02027  => 02067,
		                                    017012 => 017013,
		                                    0507   => 0510,
		                                    0404   => 0405,
		                                    02010  => 02130,
		                                    0514   => 0515,
		                                    0315   => 0355,
		                                    0131   => 0171,
		                                    0412   => 0413,
		                                    01617  => 01716,
		                                    0122   => 0162,
		                                    02020  => 02060,
		                                    02005  => 02125,
		                                    02002  => 02122,
		                                    0446   => 0447,
		                                    0466   => 0467,
		                                    0452   => 0453,
		                                    01612  => 01657,
		                                    02053  => 02113,
		                                    0114   => 0154,
		                                    01627  => 01667,
		                                    0444   => 0445,
		                                    01030  => 01031,
		                                    0333   => 0373,
		                                    0436   => 0437,
		                                    02036  => 02076,
		                                    017100 => 017101,
		                                    01635  => 01675,
		                                    0406   => 0407,
		                                    01653  => 01713,
		                                    02046  => 02106,
		                                    0336   => 0376,
		                                    0307   => 0347,
		                                    01652  => 01712,
		                                    02041  => 02101,
		                                    02022  => 02062,
		                                    0416   => 0417,
		                                    0330   => 0370,
		                                    0127   => 0167,
		                                    0432   => 0433,
		                                    0124   => 0164,
		                                    0112   => 0152,
		                                    02013  => 02133,
		                                    02006  => 02126,
		                                    0402   => 0403,
		                                    01633  => 01673,
		                                    0321   => 0361,
		                                    02035  => 02075,
		                                    01614  => 01714,
		                                    0311   => 0351,
		                                    0320   => 0360,
		                                    02007  => 02127,
		                                    0442   => 0443,
		);
	}
	$pb1lax = pb1Oax( $pb1O9y );
	if ( ! $pb1lax ) {
		return FALSE;
	}
	$pb1lay = count( $pb1lax );
	for ( $pb1l9z = 0; $pb1l9z < $pb1lay; $pb1l9z ++ ) {
		if ( isset ( $PBSEO_UTF8_UPPER_TO_LOWER[ $pb1lax[ $pb1l9z ] ] ) ) {
			$pb1lax[ $pb1l9z ] = $PBSEO_UTF8_UPPER_TO_LOWER[ $pb1lax[ $pb1l9z ] ];
		}
	}

	return pb1Oay( $pb1lax );
}

function pb1laz( $pb1O9y ) {
	if ( empty( $pb1O9y ) ) {
		return '';
	}
	if ( function_exists_wrapper( "mb_strtoupper" ) ) {
		return mb_strtoupper( $pb1O9y );
	}
	static $PBSEO_UTF8_LOWER_TO_UPPER
	=
	null;
	if ( is_null( $PBSEO_UTF8_LOWER_TO_UPPER ) ) {
		$PBSEO_UTF8_LOWER_TO_UPPER = array( 0141   => 0101,
		                                    01706  => 01646,
		                                    0543   => 0542,
		                                    0345   => 0305,
		                                    0142   => 0102,
		                                    0472   => 0471,
		                                    0341   => 0301,
		                                    0502   => 0501,
		                                    01715  => 01616,
		                                    0401   => 0400,
		                                    02221  => 02220,
		                                    01664  => 01624,
		                                    0533   => 0532,
		                                    0144   => 0104,
		                                    01663  => 01623,
		                                    0364   => 0324,
		                                    02112  => 02052,
		                                    02071  => 02031,
		                                    0423   => 0422,
		                                    02074  => 02034,
		                                    0537   => 0536,
		                                    0504   => 0503,
		                                    0356   => 0316,
		                                    02136  => 02016,
		                                    02117  => 02057,
		                                    01672  => 01632,
		                                    0525   => 0524,
		                                    0151   => 0111,
		                                    0163   => 0123,
		                                    017037 => 017036,
		                                    0465   => 0464,
		                                    02107  => 02047,
		                                    01700  => 01640,
		                                    02070  => 02030,
		                                    0363   => 0323,
		                                    02100  => 02040,
		                                    02124  => 02004,
		                                    02065  => 02025,
		                                    02111  => 02051,
		                                    0513   => 0512,
		                                    02061  => 02021,
		                                    02131  => 02011,
		                                    017003 => 017002,
		                                    0366   => 0326,
		                                    0371   => 0331,
		                                    0156   => 0116,
		                                    02121  => 02001,
		                                    01704  => 01644,
		                                    02103  => 02043,
		                                    0535   => 0534,
		                                    02123  => 02003,
		                                    01710  => 01650,
		                                    0531   => 0530,
		                                    0147   => 0107,
		                                    0344   => 0304,
		                                    01654  => 01606,
		                                    01656  => 01611,
		                                    0547   => 0546,
		                                    01676  => 01636,
		                                    0545   => 0544,
		                                    0427   => 0426,
		                                    0411   => 0410,
		                                    0166   => 0126,
		                                    0376   => 0336,
		                                    0527   => 0526,
		                                    0372   => 0332,
		                                    017141 => 017140,
		                                    017203 => 017202,
		                                    0342   => 0302,
		                                    0431   => 0430,
		                                    0506   => 0505,
		                                    0160   => 0120,
		                                    0521   => 0520,
		                                    02116  => 02056,
		                                    0451   => 0450,
		                                    01707  => 01647,
		                                    0476   => 0475,
		                                    02102  => 02042,
		                                    0172   => 0132,
		                                    02110  => 02050,
		                                    01701  => 01641,
		                                    017201 => 017200,
		                                    0555   => 0554,
		                                    0365   => 0325,
		                                    0165   => 0125,
		                                    0567   => 0566,
		                                    0374   => 0334,
		                                    017127 => 017126,
		                                    01703  => 01643,
		                                    02072  => 02032,
		                                    0155   => 0115,
		                                    0553   => 0552,
		                                    0561   => 0560,
		                                    02104  => 02044,
		                                    0354   => 0314,
		                                    0551   => 0550,
		                                    01677  => 01637,
		                                    0153   => 0113,
		                                    0362   => 0322,
		                                    0340   => 0300,
		                                    02064  => 02024,
		                                    01711  => 01651,
		                                    017153 => 017152,
		                                    0343   => 0303,
		                                    02115  => 02055,
		                                    02066  => 02026,
		                                    0641   => 0640,
		                                    0415   => 0414,
		                                    0435   => 0434,
		                                    0360   => 0320,
		                                    0474   => 0473,
		                                    02137  => 02017,
		                                    02132  => 02012,
		                                    0350   => 0310,
		                                    01705  => 01645,
		                                    0146   => 0106,
		                                    0375   => 0335,
		                                    0143   => 0103,
		                                    01033  => 01032,
		                                    0352   => 0312,
		                                    01671  => 01631,
		                                    0572   => 0571,
		                                    0357   => 0317,
		                                    0660   => 0657,
		                                    0145   => 0105,
		                                    01673  => 01633,
		                                    01670  => 01630,
		                                    01674  => 01634,
		                                    02134  => 02014,
		                                    02077  => 02037,
		                                    02114  => 02054,
		                                    0376   => 0336,
		                                    0360   => 0320,
		                                    017363 => 017362,
		                                    0150   => 0110,
		                                    0353   => 0313,
		                                    0421   => 0420,
		                                    02063  => 02023,
		                                    0457   => 0456,
		                                    0346   => 0306,
		                                    0170   => 0130,
		                                    0541   => 0540,
		                                    0557   => 0556,
		                                    01661  => 01621,
		                                    02127  => 02007,
		                                    0563   => 0562,
		                                    0377   => 0570,
		                                    0157   => 0117,
		                                    02073  => 02033,
		                                    01665  => 01625,
		                                    02105  => 02045,
		                                    0441   => 0440,
		                                    0576   => 0575,
		                                    0574   => 0573,
		                                    01666  => 01626,
		                                    01662  => 01622,
		                                    01655  => 01610,
		                                    017205 => 017204,
		                                    0565   => 0564,
		                                    0161   => 0121,
		                                    02067  => 02027,
		                                    017013 => 017012,
		                                    0510   => 0507,
		                                    0405   => 0404,
		                                    02130  => 02010,
		                                    0515   => 0514,
		                                    0355   => 0315,
		                                    0171   => 0131,
		                                    0413   => 0412,
		                                    01716  => 01617,
		                                    0162   => 0122,
		                                    02060  => 02020,
		                                    02125  => 02005,
		                                    02122  => 02002,
		                                    0447   => 0446,
		                                    0467   => 0466,
		                                    0453   => 0452,
		                                    01657  => 01612,
		                                    02113  => 02053,
		                                    0154   => 0114,
		                                    01667  => 01627,
		                                    0445   => 0444,
		                                    01031  => 01030,
		                                    0373   => 0333,
		                                    0437   => 0436,
		                                    02076  => 02036,
		                                    017101 => 017100,
		                                    01675  => 01635,
		                                    0407   => 0406,
		                                    01713  => 01653,
		                                    02106  => 02046,
		                                    0376   => 0336,
		                                    0347   => 0307,
		                                    01712  => 01652,
		                                    02101  => 02041,
		                                    02062  => 02022,
		                                    0417   => 0416,
		                                    0370   => 0330,
		                                    0167   => 0127,
		                                    0433   => 0432,
		                                    0164   => 0124,
		                                    0152   => 0112,
		                                    02133  => 02013,
		                                    02126  => 02006,
		                                    0403   => 0402,
		                                    01673  => 01633,
		                                    0361   => 0321,
		                                    02075  => 02035,
		                                    01714  => 01614,
		                                    0351   => 0311,
		                                    0360   => 0320,
		                                    02127  => 02007,
		                                    0443   => 0442,
		);
	}
	$pb1lax = pb1Oax( $pb1O9y );
	if ( ! $pb1lax ) {
		return FALSE;
	}
	$pb1lay = count( $pb1lax );
	for ( $pb1l9z = 0; $pb1l9z < $pb1lay; $pb1l9z ++ ) {
		if ( isset ( $PBSEO_UTF8_LOWER_TO_UPPER[ $pb1lax[ $pb1l9z ] ] ) ) {
			$pb1lax[ $pb1l9z ] = $PBSEO_UTF8_LOWER_TO_UPPER[ $pb1lax[ $pb1l9z ] ];
		}
	}

	return pb1Oay( $pb1lax );
}

function pb1Oaz( $pb1O9y ) {
	if ( empty( $pb1O9y ) ) {
		return '';
	}
	$pb1O4y = '/(^|([\\x0c\\x09\\x0b\\x0a\\x0d\\x20]+))([^\\x0c\\x09\\x0b\\x0a\\x0d\\x20]{1})[^\\x0c\\x09\\x0b\\x0a\\x0d\\x20]*/u';

	return @preg_replace_callback( $pb1O4y, "pbseo_utf8_ucwords_callback", $pb1O9y );
}

function pb1lb0( $pb1l4z ) {
	$pb1Ob0 = $pb1l4z[2];
	$pb1lb1 = pb1laz( $pb1l4z[3] );
	$pb1Ob1 = pb1lb2( ltrim( $pb1l4z[0] ), $pb1lb1, 0, 1 );

	return $pb1Ob0 . $pb1Ob1;
}

function pb1Ob2( $pb1O9y ) {
	switch ( pb_mbstring_length( $pb1O9y ) ) {
		case 0:
			return '';
			break;
		case 1:
			return pb1laz( $pb1O9y );
			break;
		default :
			@preg_match( '/^(.{1})(.*)$/us', $pb1O9y, $pb1l4z );

			return pb1laz( $pb1l4z[1] ) . $pb1l4z[2];
			break;
	}
}

function pb1lb2( $pb1O9y, $pb1lb3, $pb1Ob3, $pb1Oaj = null ) {
	if ( empty( $pb1O9y ) ) {
		return '';
	}
	@preg_match_all( '/./us', $pb1O9y, $pb1laq );
	@preg_match_all( '/./us', $pb1lb3, $pb1lb4 );
	if ( $pb1Oaj === null ) {
		$pb1Oaj = pb_mbstring_length( $pb1O9y );
	}
	array_splice( $pb1laq[0], $pb1Ob3, $pb1Oaj, $pb1lb4[0] );

	return join( '', $pb1laq[0] );
}

function pb1Oax( $pb1O3b ) {
	if ( empty( $pb1O3b ) ) {
		return FALSE;
	}
	$pb1Ob4 = 0;
	$pb1lb5 = 0;
	$pb1Ob5 = 1;
	$pb1O7a = array();
	$pb1Oap = strlen( $pb1O3b );
	for ( $pb1l9z = 0; $pb1l9z < $pb1Oap; $pb1l9z ++ ) {
		$pb1lb6 = ord( $pb1O3b{$pb1l9z} );
		if ( $pb1Ob4 == 0 ) {
			if ( 0 == ( 0200 & ( $pb1lb6 ) ) ) {
				$pb1O7a[] = $pb1lb6;
				$pb1Ob5   = 1;
			} else if ( 0300 == ( 0340 & ( $pb1lb6 ) ) ) {
				$pb1lb5 = ( $pb1lb6 );
				$pb1lb5 = ( $pb1lb5 & 037 ) << 6;
				$pb1Ob4 = 1;
				$pb1Ob5 = 2;
			} else if ( 0340 == ( 0360 & ( $pb1lb6 ) ) ) {
				$pb1lb5 = ( $pb1lb6 );
				$pb1lb5 = ( $pb1lb5 & 017 ) << 014;
				$pb1Ob4 = 2;
				$pb1Ob5 = 3;
			} else if ( 0360 == ( 0370 & ( $pb1lb6 ) ) ) {
				$pb1lb5 = ( $pb1lb6 );
				$pb1lb5 = ( $pb1lb5 & 0x07 ) << 022;
				$pb1Ob4 = 3;
				$pb1Ob5 = 4;
			} else if ( 0370 == ( 0374 & ( $pb1lb6 ) ) ) {
				$pb1lb5 = ( $pb1lb6 );
				$pb1lb5 = ( $pb1lb5 & 0x03 ) << 030;
				$pb1Ob4 = 4;
				$pb1Ob5 = 5;
			} else if ( 0374 == ( 0376 & ( $pb1lb6 ) ) ) {
				$pb1lb5 = ( $pb1lb6 );
				$pb1lb5 = ( $pb1lb5 & 1 ) << 036;
				$pb1Ob4 = 5;
				$pb1Ob5 = 6;
			} else {
				trigger_error( "pbseo_utf8_to_unicode: Illegal sequence identifier " . "in UTF-8 at byte " . $pb1l9z, E_USER_WARNING );

				return FALSE;
			}
		} else {
			if ( 0200 == ( 0300 & ( $pb1lb6 ) ) ) {
				$pb1Ob6 = ( $pb1Ob4 - 1 ) * 6;
				$pb1lb7 = $pb1lb6;
				$pb1lb7 = ( $pb1lb7 & 077 ) << $pb1Ob6;
				$pb1lb5 |= $pb1lb7;
				if ( 0 == -- $pb1Ob4 ) {
					if ( ( ( 2 == $pb1Ob5 ) && ( $pb1lb5 < 0200 ) ) || ( ( 3 == $pb1Ob5 ) && ( $pb1lb5 < 04000 ) ) || ( ( 4 == $pb1Ob5 ) && ( $pb1lb5 < 0200000 ) ) || ( 4 < $pb1Ob5 ) || ( ( $pb1lb5 & 037777774000 ) == 0154000 ) || ( $pb1lb5 > 04177777 ) ) {
						trigger_error( "pbseo_utf8_to_unicode: Illegal sequence or codepoint " . "in UTF-8 at byte " . $pb1l9z, E_USER_WARNING );

						return FALSE;
					}
					if ( 0177377 != $pb1lb5 ) {
						$pb1O7a[] = $pb1lb5;
					}
					$pb1Ob4 = 0;
					$pb1lb5 = 0;
					$pb1Ob5 = 1;
				}
			} else {
				trigger_error( "pbseo_utf8_to_unicode: Incomplete multi-octet " . "   sequence in UTF-8 at byte " . $pb1l9z, E_USER_WARNING );

				return FALSE;
			}
		}
	}

	return $pb1O7a;
}

function pb1Oay( $pb1l3c ) {
	if ( empty( $pb1l3c ) ) {
		return FALSE;
	}
	ob_start();
	foreach ( array_keys( $pb1l3c ) as $pb1Ob7 ) {
		if ( ( $pb1l3c[ $pb1Ob7 ] >= 0 ) && ( $pb1l3c[ $pb1Ob7 ] <= 0177 ) ) {
			echo chr( $pb1l3c[ $pb1Ob7 ] );
		} else if ( $pb1l3c[ $pb1Ob7 ] <= 03777 ) {
			echo chr( 0300 | ( $pb1l3c[ $pb1Ob7 ] >> 6 ) );
			echo chr( 0200 | ( $pb1l3c[ $pb1Ob7 ] & 077 ) );
		} else if ( $pb1l3c[ $pb1Ob7 ] == 0177377 ) {
		} else if ( $pb1l3c[ $pb1Ob7 ] >= 0154000 && $pb1l3c[ $pb1Ob7 ] <= 0157777 ) {
			trigger_error( "pbseo_utf8_from_unicode: Illegal surrogate " . "at index: " . $pb1Ob7 . ", value: " . $pb1l3c[ $pb1Ob7 ], E_USER_WARNING );

			return FALSE;
		} else if ( $pb1l3c[ $pb1Ob7 ] <= 0177777 ) {
			echo chr( 0340 | ( $pb1l3c[ $pb1Ob7 ] >> 014 ) );
			echo chr( 0200 | ( ( $pb1l3c[ $pb1Ob7 ] >> 6 ) & 077 ) );
			echo chr( 0200 | ( $pb1l3c[ $pb1Ob7 ] & 077 ) );
		} else if ( $pb1l3c[ $pb1Ob7 ] <= 04177777 ) {
			echo chr( 0360 | ( $pb1l3c[ $pb1Ob7 ] >> 022 ) );
			echo chr( 0200 | ( ( $pb1l3c[ $pb1Ob7 ] >> 014 ) & 077 ) );
			echo chr( 0200 | ( ( $pb1l3c[ $pb1Ob7 ] >> 6 ) & 077 ) );
			echo chr( 0200 | ( $pb1l3c[ $pb1Ob7 ] & 077 ) );
		} else {
			trigger_error( "pbseo_utf8_from_unicode: Codepoint out of Unicode range " . "at index: " . $pb1Ob7 . ", value: " . $pb1l3c[ $pb1Ob7 ], E_USER_WARNING );

			return FALSE;
		}
	}
	$pb1O96 = ob_get_contents();
	ob_end_clean();

	return $pb1O96;
}

?>