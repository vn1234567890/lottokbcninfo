<?php function pb1O5p( $pb1l5k = FALSE_BOOL_DEFINE, $pb1O5t = FALSE_BOOL_DEFINE ) {
	$pb1l5u = 0;
	$pb1O4x = '';
	$pb1O5u = '#fff';
	if ( TRUE_BOOL_DEFINE === $pb1O5t ) {
		$pb1l5v = pb1O5v( 0 );
	} else {
		$pb1l5v = pb1O5v( $pb1l5k );
	}
	if ( ! empty( $pb1l5v ) ) {
		$pb1l5u = 0;
		foreach ( $pb1l5v as $pb1O2q => $pb1l5w ) {
			$pb1O5w = $pb1l5w[ pb1Ou . "term" ];
			$pb1l5x = $pb1l5w[ pb1Ou . "term_count" ];
			if ( ( empty( $pb1O5w ) ) || ( empty( $pb1l5x ) ) ) {
				continue;
			}
			$pb1l5u ++;
			if ( $pb1O5u == '#fff' ) {
				$pb1O5u = '#f5f5f5';
			} else {
				$pb1O5u = '#fff';
			}
			$pb1O4x .= "<tr valign=\"top\">";
			$pb1O4x .= "<td class=\"pbseo_results_row\" style=\"background:" . $pb1O5u . ";\">";
			$pb1O4x .= pb_htmlspecialchars( $pb1O5w ) . ' (' . number_format_i18n( $pb1l5x, 0 ) . ')';
			$pb1O4x .= "</td>";
			$pb1O4x .= "</tr>";
		}
		if ( $pb1l5u > 0 ) {
			echo "<p><strong>" . __( "Incoming Searches", PluginTextDomain_DEFINE ) . "</strong></p>";
			echo "<table width=\"100%\" class=\"pbseo_links_table\">" . $pb1O4x . "</table>";
		}
	}
}

function pb1O5x( $pb1l5y, $pb1O5y = TRUE_BOOL_DEFINE ) {
	if ( ! pb1O3u( pb1O1 ) ) {
		return '';
	}
	global $pb1O58;
	pb1l58( __FUNCTION__ . ":Ingress" );
	$pb1l2s = pbseo_trans_DEFINE . md5( __FUNCTION__ . $pb1l5y . pb1Oc );
	$pb1O2s = pb1l2t( $pb1l2s );
	if ( FALSE_BOOL_DEFINE !== $pb1O2s ) {
		return $pb1O2s;
	}
	unset ( $pb1l2s, $pb1O2s );
	$pb1l5z = pb1O5z( $pb1l5y );
	$pb1O4x = '';
	$pb1O5u = '#fff';
	$pb1l5u = 0;
	if ( ( is_array( $pb1l5z ) ) && ( count( $pb1l5z ) ) ) {
		foreach ( $pb1l5z as $pb1l3c => $pb1O2q ) {
			$pb1l60[] = $pb1O2q["keyword"];
			$pb1O60[] = $pb1O2q["count"];
		}
		$pb1l61 = pb1l57( $pb1O60 );
		array_multisort( $pb1O60, SORT_DESC, $pb1l60, SORT_STRING, $pb1l5z );
		foreach ( $pb1l5z as $pb1O2q => $pb1l5w ) {
			$pb1O5w = $pb1l5w["keyword"];
			$pb1l5x = $pb1l5w["count"];
			if ( ( empty( $pb1O5w ) ) || ( empty( $pb1l5x ) ) ) {
				continue;
			}
			$pb1l5u ++;
			$pb1O5w = pb_htmlspecialchars( $pb1O5w );
			if ( $pb1l5x > $pb1l61 ) {
				$pb1O5w = "<b>" . $pb1O5w . "</b>";
			}
			if ( $pb1O5u == '#fff' ) {
				$pb1O5u = '#f5f5f5';
			} else {
				$pb1O5u = '#fff';
			}
			$pb1O4x .= "<tr valign=\"top\">";
			$pb1O4x .= "<td class=\"pbseo_results_row\" style=\"background:" . $pb1O5u . ";\">";
			$pb1O4x .= $pb1O5w;
			$pb1O4x .= "</td>";
			if ( TRUE_BOOL_DEFINE === $pb1O5y ) {
				$pb1O4x .= "<td width=\"60px;\" class=\"pbseo_results_row\" style=\"text-align:right;background:" . $pb1O5u . ";\">";
				$pb1O4x .= number_format_i18n( $pb1l5x, 0 );
				$pb1O4x .= "</td>";
			}
			$pb1O4x .= "</tr>";
		}
	}
	unset ( $pb1l5z );
	if ( $pb1l5u > 0 ) {
		$pb1O61 = "<p><strong>" . __( "Related Searches", PluginTextDomain_DEFINE ) . "</strong></p>";
		$pb1O61 .= "<table width=\"100%\" class=\"pbseo_links_table\">" . $pb1O4x . "</table>";
		$pb1O4x = $pb1O61;
	}
	$pb1l2s = pbseo_trans_DEFINE . md5( __FUNCTION__ . $pb1l5y . pb1Oc );
	pb1l2w( $pb1l2s, $pb1O4x, pb1Oh );
	unset ( $pb1l2s );
	pb1l58( __FUNCTION__ . ":Egress" );

	return $pb1O4x;
}

function pb1O5z( $pb1l5y ) {
	if ( ! pb1O3u( pb1O1 ) ) {
		return FALSE_BOOL_DEFINE;
	}
	global $pb1O58;
	pb1l58( __FUNCTION__ . ":Ingress" );
	$pb1l5y = trim_wrapper( $pb1l5y );
	if ( empty( $pb1l5y ) ) {
		return FALSE_BOOL_DEFINE;
	}
	$pb1l5y = pb1O2p( prepare_keywords( $pb1l5y ) );
	$pb1O62 = "http://google.com/complete/search";
	$pb1O2t = array( "output" => "toolbar", "q" => $pb1l5y, "hl" => pb1O2p( pb1O1u ), "gl" => pb1O2p( pb1l1v ), "expected_content_type" => "text/xml", "cache_response" => FALSE_BOOL_DEFINE, );
	$pb1O2u = pb1O37( $pb1O62, $pb1O2t, "GET", pb1Ok );
	if ( empty( $pb1O2u ) ) {
		write_log( __( "Error trying to retrieve response from remote service", PluginTextDomain_DEFINE ) );

		return FALSE_BOOL_DEFINE;
	}
	libxml_use_internal_errors( TRUE_BOOL_DEFINE );
	libxml_clear_errors();
	try {
		$pb1l63 = @simplexml_load_string( $pb1O2u );
	} catch ( exception $pb1O2w ) {
		$pb1l63 = FALSE_BOOL_DEFINE;
	}
	libxml_clear_errors();
	$pb1O2u = null;
	if ( FALSE_BOOL_DEFINE === $pb1l63 ) {
		write_log( __( "Error trying to parse response from remote service", PluginTextDomain_DEFINE ) );

		return FALSE_BOOL_DEFINE;
	}
	$pb1O63 = array();
	$pb1l5u = 0;
	if ( isset ( $pb1l63->CompleteSuggestion ) ) {
		foreach ( $pb1l63->CompleteSuggestion as $pb1O38 ) {
			$pb1l64 = FALSE_BOOL_DEFINE;
			$pb1O64 = FALSE_BOOL_DEFINE;
			if ( isset ( $pb1O38->suggestion["data"] ) ) {
				$pb1l64 = (string) $pb1O38->suggestion['data'];
				$pb1l64 = trim_wrapper( pb1O2p( prepare_keywords( $pb1l64 ) ) );
			}
			if ( isset ( $pb1O38->num_queries["int"] ) ) {
				$pb1O64 = (int) $pb1O38->num_queries["int"];
			}
			if ( ( empty( $pb1l64 ) ) || ( empty( $pb1O64 ) ) ) {
				continue;
			}
			$pb1O63[ $pb1l64 ] = $pb1O64;
			$pb1l5u ++;
			$pb1O38 = null;
			libxml_clear_errors();
		}
		if ( $pb1l5u > 0 ) {
			arsort( $pb1O63 );
			$pb1l65 = array();
			foreach ( $pb1O63 as $pb1O65 => $pb1l5x ) {
				$pb1l65[] = array( "keyword" => $pb1O65, "count" => $pb1l5x );
			}
			$pb1O63 = $pb1l65;
			unset ( $pb1l65 );
		}
	}
	libxml_clear_errors();
	$pb1l63 = null;
	pb1l58( __FUNCTION__ . ":Egress" );

	return $pb1O63;
}

function pb1l66( $pb1l5y ) {
	if ( ! pb1O3u( pb1O1 ) ) {
		return FALSE_BOOL_DEFINE;
	}
	global $pb1O58;
	pb1l58( __FUNCTION__ . ":Ingress" );
	$pb1l5y = trim_wrapper( $pb1l5y );
	if ( empty( $pb1l5y ) ) {
		return FALSE_BOOL_DEFINE;
	}
	$pb1O62 = 'http://gdata.youtube.com/feeds/api/videos/';
	$pb1l5y = pb1O2p( prepare_keywords( $pb1l5y ) );
	$pb1O62 = "http://gdata.youtube.com/feeds/api/videos";
	$pb1O2t = array( "q" => $pb1l5y, "max-results" => 062, "start-index" => 1, "v" => 2, "expected_content_type" => "application/atom+xml", "cache_response" => TRUE_BOOL_DEFINE, );
	if ( "EN" != pb1l1u ) {
		$pb1O2t["lr"] = pb1O2p( pb1l1u );
	}
	$pb1O2u = pb1O37( $pb1O62, $pb1O2t, "GET", pb1Ok );
	if ( empty( $pb1O2u ) ) {
		write_log( __( "Error trying to retrieve response from remote service", PluginTextDomain_DEFINE ) );

		return FALSE_BOOL_DEFINE;
	}
	libxml_use_internal_errors( TRUE_BOOL_DEFINE );
	libxml_clear_errors();
	try {
		$pb1l63 = @simplexml_load_string( $pb1O2u );
	} catch ( exception $pb1O2w ) {
		$pb1l63 = FALSE_BOOL_DEFINE;
	}
	libxml_clear_errors();
	$pb1O2u = null;
	if ( FALSE_BOOL_DEFINE === $pb1l63 ) {
		write_log( __( "Error trying to parse response from remote service", PluginTextDomain_DEFINE ) );

		return FALSE_BOOL_DEFINE;
	}
	try {
		$pb1O66 = $pb1l63->children( "http://a9.com/-/spec/opensearch/1.1/" );
		$pb1l67 = (int) $pb1O66->totalResults;
		$pb1O66 = null;
	} catch ( exception $pb1O2w ) {
		write_log( __( "Failed to determine item count in XML document", PluginTextDomain_DEFINE ) );
		$pb1l67 = FALSE_BOOL_DEFINE;
	}
	$pb1O63 = array();
	if ( $pb1l67 ) {
		$pb1l5u = 0;
		if ( isset ( $pb1l63->entry ) ) {
			foreach ( $pb1l63->entry as $pb1O67 ) {
				$pb1l68 = array();
				if ( isset ( $pb1O67->title ) ) {
					$pb1l68 = (string) $pb1O67->title;
					$pb1l68 = pb1O2p( prepare_keywords( $pb1l68 ) );
					$pb1l68 = explode( " ", $pb1l68 );
				}
				$pb1O68 = array();
				try {
					$pb1l69 = $pb1O67->children( "http://search.yahoo.com/mrss/" );
					$pb1O68 = (string) $pb1l69->group->keywords;
					$pb1O68 = explode( ",", $pb1O68 );
					$pb1l69 = null;
				} catch ( exception $pb1O2w ) {
					if ( empty( $pb1l68 ) ) {
						$pb1O67 = null;
						continue;
					}
				}
				foreach ( $pb1l68 as $pb1O69 => $pb1l49 ) {
					$pb1O68[] = $pb1l49;
				}
				foreach ( $pb1O68 as $pb1O69 => $pb1O65 ) {
					$pb1O65 = trim_wrapper( pb1O2p( prepare_keywords( $pb1O65 ) ) );
					if ( pb_string_length( $pb1O65 ) < 014 ) {
						$pb1O65 = pb1O47( $pb1O65, pb1l1r, TRUE_BOOL_DEFINE );
					}
					if ( pb_string_length( $pb1O65 ) > 1 ) {
						$pb1O63[] = $pb1O65;
					}
				}
				$pb1l5u ++;
				$pb1O67 = null;
				libxml_clear_errors();
			}
		}
		if ( $pb1l5u ) {
			$pb1O63 = array_count_values( $pb1O63 );
			arsort( $pb1O63 );
			$pb1l65 = array();
			foreach ( $pb1O63 as $pb1O65 => $pb1l5x ) {
				if ( $pb1l5x > 1 ) {
					$pb1l65[] = array( "keyword" => $pb1O65, "count" => $pb1l5x );
				}
			}
			$pb1O63 = $pb1l65;
			unset ( $pb1l65 );
		}
	}
	$pb1l63 = null;
	libxml_clear_errors();
	pb1l58( __FUNCTION__ . ":Egress" );

	return $pb1O63;
}

function pb1l6a( $pb1l5y, $pb1O5y = TRUE_BOOL_DEFINE ) {
	if ( ! pb1O3u( pb1O1 ) ) {
		return '';
	}
	global $pb1O58;
	pb1l58( __FUNCTION__ . ":Ingress" );
	$pb1l2s = pbseo_trans_DEFINE . md5( __FUNCTION__ . $pb1l5y . pb1Oc );
	$pb1O2s = pb1l2t( $pb1l2s );
	if ( FALSE_BOOL_DEFINE !== $pb1O2s ) {
		return $pb1O2s;
	}
	unset ( $pb1l2s, $pb1O2s );
	$pb1O6a = pb1l66( $pb1l5y );
	$pb1O4x = '';
	$pb1O5u = '#fff';
	$pb1l5u = 0;
	if ( ( is_array( $pb1O6a ) ) && ( count( $pb1O6a ) ) ) {
		foreach ( $pb1O6a as $pb1l3c => $pb1O2q ) {
			$pb1l60[] = $pb1O2q["keyword"];
			$pb1O60[] = $pb1O2q["count"];
		}
		if ( TRUE_BOOL_DEFINE == $pb1O5y ) {
			array_multisort( $pb1O60, SORT_DESC, $pb1l60, SORT_STRING, $pb1O6a );
			foreach ( $pb1O6a as $pb1O2q => $pb1l5w ) {
				$pb1O5w = $pb1l5w["keyword"];
				$pb1l5x = $pb1l5w["count"];
				if ( ( empty( $pb1O5w ) ) || ( empty( $pb1l5x ) ) ) {
					continue;
				}
				$pb1l5u ++;
				if ( $pb1O5u == '#fff' ) {
					$pb1O5u = '#f5f5f5';
				} else {
					$pb1O5u = '#fff';
				}
				$pb1O4x .= "<tr valign=\"top\">";
				$pb1O4x .= "<td class=\"pbseo_results_row\" style=\"background:" . $pb1O5u . ";\">";
				$pb1O4x .= pb_htmlspecialchars( $pb1O5w );
				$pb1O4x .= "</td>";
				$pb1O4x .= "<td width=\"60px;\" class=\"pbseo_results_row\" style=\"text-align:right;background:" . $pb1O5u . ";\">";
				$pb1O4x .= number_format_i18n( $pb1l5x, 0 );
				$pb1O4x .= "</td>";
				$pb1O4x .= "</tr>";
			}
		} else {
			$pb1l61 = pb1l57( $pb1O60 );
			array_multisort( $pb1l60, SORT_STRING, $pb1O60, SORT_DESC, $pb1O6a );
			$pb1l6b = FALSE_BOOL_DEFINE;
			$pb1O6b = array();
			$pb1l5u = 0;
			foreach ( $pb1O6a as $pb1O2q => $pb1l5w ) {
				$pb1l6c = pb1O2p( pb1O1q( $pb1l5w["keyword"], 0, 1 ) );
				if ( $pb1l6b != $pb1l6c ) {
					$pb1l6b = $pb1l6c;
					$pb1l5u ++;
				}
				$pb1l5w["keyword"] = pb_htmlspecialchars( $pb1l5w["keyword"] );
				if ( $pb1l5w["count"] > $pb1l61 ) {
					$pb1l5w["keyword"] = "<b>" . $pb1l5w["keyword"] . "</b>";
				}
				$pb1O6b[ $pb1l5u ][] = $pb1l5w["keyword"];
			}
			foreach ( $pb1O6b as $pb1O2q => $pb1l3c ) {
				if ( $pb1O5u == '#fff' ) {
					$pb1O5u = '#f5f5f5';
				} else {
					$pb1O5u = '#fff';
				}
				$pb1O4x .= "<tr valign=\"top\">";
				$pb1O4x .= "<td class=\"pbseo_results_row\" style=\"background:" . $pb1O5u . ";\">";
				$pb1O4x .= implode( ", ", $pb1l3c );
				$pb1O4x .= "</td>";
				$pb1O4x .= "</td>";
				$pb1O4x .= "</tr>";
			}
		}
	}
	$pb1O6a = null;
	if ( $pb1l5u > 0 ) {
		$pb1O61 = "<p><strong>" . __( "Related Keywords", PluginTextDomain_DEFINE ) . "</strong></p>";
		$pb1O61 .= "<table width=\"100%\" class=\"pbseo_links_table\">" . $pb1O4x . "</table>";
		$pb1O4x = $pb1O61;
	}
	$pb1l2s = pbseo_trans_DEFINE . md5( __FUNCTION__ . $pb1l5y . pb1Oc );
	pb1l2w( $pb1l2s, $pb1O4x, pb1Oh );
	unset ( $pb1l2s );
	pb1l58( __FUNCTION__ . ":Egress" );

	return $pb1O4x;
}

function pbseo_ajax_links_get_external() {
	if ( ! pb1O3u( pb1O1 ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Denied", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1O2l = check_ajax_referer( pb1Of, "pbseo_ajax_nonce", FALSE_BOOL_DEFINE );
	if ( FALSE_BOOL_DEFINE === $pb1O2l ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Denied", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1O6c = "external";
	$pb1O2y = '';
	$pb1l5k = isset ( $_POST["pbseo_post_id"] ) ? intval( stripslashes( $_POST["pbseo_post_id"] ) ) : FALSE;
	$pb1l5y = isset ( $_POST["pbseo_keyword"] ) ? trim_wrapper( stripslashes( $_POST["pbseo_keyword"] ) ) : FALSE;
	if ( empty( $pb1l5y ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "No keyword found", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	if ( empty( $pb1l5k ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Post ID not found", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1l6d = pb1O2p( prepare_keywords( $pb1l5y ) );
	if ( empty( $pb1l6d ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Illegal keyword", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1O1r = pb1O2p( pb1l1u );
	$pb1O62 = "http://" . $pb1O1r . ".wikipedia.org/w/api.php";
	$pb1O2t = array( "action" => "query", "list" => "search", "srwhat" => "text", "srlimit" => 031, "format" => "xml", "srsearch" => $pb1l6d, "expected_content_type" => "text/xml", "cache_response" => TRUE_BOOL_DEFINE, );
	$pb1O2u = pb1O37( $pb1O62, $pb1O2t, "GET", pb1Ok );
	if ( empty( $pb1O2u ) ) {
		write_log( __( "Error trying to retrieve response from remote service", PluginTextDomain_DEFINE ) );
		echo "<p class=\"pbseo_ajax_error\">" . __( "Error trying to retrieve response from remote service", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	libxml_use_internal_errors( TRUE_BOOL_DEFINE );
	libxml_clear_errors();
	try {
		$pb1l63 = @simplexml_load_string( $pb1O2u );
	} catch ( exception $pb1O2w ) {
		$pb1l63 = FALSE_BOOL_DEFINE;
	}
	if ( FALSE_BOOL_DEFINE === $pb1l63 ) {
		write_log( __( "Error trying to parse response from remote service", PluginTextDomain_DEFINE ) );
		echo "<p class=\"pbseo_ajax_error\">" . __( "Error trying to parse response from remote service", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	if ( isset ( $pb1l63->error ) ) {
		write_log( __( "Server responded with an error", PluginTextDomain_DEFINE ) );
		echo "<p class=\"pbseo_ajax_error\">" . __( "Server responded with an error", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1O4x = '';
	$pb1l5u = 0;
	$pb1O5u = "#fff";
	if ( isset ( $pb1l63->query->search->p ) ) {
		foreach ( $pb1l63->query->search->p as $pb1O38 ) {
			$pb1O6d = $pb1O38->attributes();
			$pb1l68 = isset ( $pb1O6d["title"] ) ? (string) $pb1O6d["title"] : '';
			$pb1l6e = isset ( $pb1O6d["snippet"] ) ? (string) $pb1O6d["snippet"] : '';
			if ( empty( $pb1l68 ) || empty( $pb1l6e ) ) {
				continue;
			}
			$pb1O6e = "http://" . $pb1O1r . ".wikipedia.org/wiki/" . pb_htmlspecialchars( str_replace( " ", "_", $pb1l68 ) );
			$pb1l5u ++;
			$pb1O4x = pb1l6f();
			$pb1O6f = pb_htmlspecialchars( prepare_keywords( $pb1l68 ) );
			$pb1l6g = pb_htmlspecialchars( pb1O6g( $pb1l6e ) ) . "&hellip;";
			if ( pb_string_length( $pb1l68 ) > 0170 ) {
				$pb1l6h = pb_htmlspecialchars( pb1O1q( prepare_keywords( $pb1l68 ), 0, 0170 ) ) . "&hellip;";
			} else {
				$pb1l6h = pb_htmlspecialchars( prepare_keywords( $pb1l68 ) );
			}
			if ( pb_string_length( $pb1l6e ) > 01000 ) {
				$pb1O6h = pb_htmlspecialchars( pb1O1q( pb1O6g( $pb1l6e ), 0, 01000 ) ) . "&hellip;";
			} else {
				$pb1O6h = pb_htmlspecialchars( pb1O6g( $pb1l6e ) ) . "&hellip;";
			}
			$pb1O4x = str_replace( "{PBSEO_TITLE}", $pb1l6h, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_FULL_TITLE}", $pb1O6f, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_LINK}", pb_htmlspecialchars( $pb1O6e ), $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_FULL_DESCRIPTION}", $pb1l6g, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_DESCRIPTION}", $pb1O6h, $pb1O4x );
			if ( $pb1O5u == "#fff" ) {
				$pb1O5u = "#f5f5f5";
				$pb1l6i = " class=\"pbseo_dk\"";
			} else {
				$pb1O5u = "#fff";
				$pb1l6i = '';
			}
			$pb1O4x = str_replace( "{PBSEO_BG_CLASS}", $pb1l6i, $pb1O4x );
			$pb1O2y .= $pb1O4x;
			unset ( $pb1O4x );
			$pb1O6i = null;
			$pb1O38 = null;
		}
	}
	$pb1l63 = null;
	if ( 0 == $pb1l5u ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "No results found", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1l6j = '<table class="pbseo_links_' . $pb1O6c . '_set">';
	$pb1O6j = '</table>';
	if ( $pb1l5u ) {
		$pb1O2y = $pb1l6j . $pb1O2y . $pb1O6j;
	} else {
		$pb1O2y = $pb1l6j . '<p>No results.</p>' . $pb1O6j;
	}
	echo $pb1O2y;
	$pb1O2y = null;
	echo "<p class=\"pbseo_attribute\">" . __( "Information from", PluginTextDomain_DEFINE ) . " <a href=\"http://www.wikipedia.org\" target=\"_blank\">WikiPedia.org</a></p>";
	pb1l5s( $pb1l5k, _pbseo_meta_DEFINE . "links_external_keyword", $pb1l6d );
	$pb1l6k = '';
	$pb1l6k .= "<script type=\"text/javascript\">";
	$pb1l6k .= "jQuery(\"input#pbseo_meta_links_external_keyword\").val(\"" . esc_attr( $pb1l6d ) . "\");";
	$pb1l6k .= "</script>";
	echo $pb1l6k;
	exit ();
}

function pbseo_ajax_content_get_images() {
	if ( ! pb1O3u( pb1O1 ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Denied", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1O2l = check_ajax_referer( pb1Of, "pbseo_ajax_nonce", FALSE_BOOL_DEFINE );
	if ( FALSE_BOOL_DEFINE === $pb1O2l ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Denied", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1O6c = "image";
	$pb1O2y = '';
	$pb1O6k = trim_wrapper( get_option_wrapper( pbseo_opt_DEFINE . "flickr_api", 1 ) );
	$pb1O6k = @preg_replace( '/[^A-Za-z0-9]/', '', $pb1O6k );
	if ( empty( $pb1O6k ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Please provide your Flickr API key in the plugin General Settings page", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1l5k = isset ( $_POST["pbseo_post_id"] ) ? intval( stripslashes( $_POST["pbseo_post_id"] ) ) : FALSE_BOOL_DEFINE;
	$pb1l5y = isset ( $_POST["pbseo_keyword"] ) ? trim_wrapper( stripslashes( $_POST["pbseo_keyword"] ) ) : FALSE_BOOL_DEFINE;
	if ( empty( $pb1l5y ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "No keyword found", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	if ( empty( $pb1l5k ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Post ID not found", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1l6d = pb1O2p( prepare_keywords( $pb1l5y ) );
	$pb1O62 = "http://api.flickr.com/services/rest/";
	$pb1O2t = array(
		"method"                => "flickr.photos.search",
		"api_key"               => $pb1O6k,
		"text"                  => $pb1l6d,
		"sort"                  => "relevance",
		"license"               => "4,5,6,7",
		"privacy_filter"        => "1",
		"content_type"          => "1",
		"media"                 => "photos",
		"per_page"              => "50",
		"page"                  => 1,
		"format"                => "php_serial",
		"extras"                => "owner_name,license,o_dims",
		"expected_content_type" => "text/plain",
		"cache_response"        => TRUE_BOOL_DEFINE,
	);
	$pb1O2u = pb1O37( $pb1O62, $pb1O2t, "GET", pb1Ok );
	if ( FALSE_BOOL_DEFINE === $pb1O2u ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Error trying to retrieve response from remote service", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1O2u = @unserialize( $pb1O2u );
	if ( is_array( $pb1O2u ) && ( isset ( $pb1O2u["stat"] ) ) && ( "ok" == $pb1O2u["stat"] ) ) {
		$pb1l5u = 0;
		$pb1O5u = '#fff';
		$pb1l6l = &$pb1O2u["photos"]["page"];
		$pb1O6l = &$pb1O2u["photos"]["pages"];
		$pb1l6m = &$pb1O2u["photos"]["total"];
		$pb1O6m = &$pb1O2u["photos"]["per_page"];
		$pb1l6n = &$pb1O2u["photos"]["photo"];
		$pb1O6n = array( "thumbnail" => 0144, "small" => 0360, "medium" => 0764, "large" => 02000, );
		foreach ( $pb1l6n as $pb1O2q => $pb1l6o ) {
			$pb1l5u ++;
			$pb1O4x = pb1O6o();
			$pb1l6p = ( isset ( $pb1l6o["o_width"] ) && ( intval( $pb1l6o["o_width"] ) > 0 ) ) ? intval( $pb1l6o["o_width"] ) : 0;
			$pb1O6p = ( isset ( $pb1l6o["o_height"] ) && ( intval( $pb1l6o["o_height"] ) > 0 ) ) ? intval( $pb1l6o["o_height"] ) : 0;
			if ( $pb1l6p && $pb1O6p ) {
				$pb1l6q = ( $pb1l6p >= $pb1O6p ) ? "landscape" : "portrait";
				if ( "landscape" == $pb1l6q ) {
					$pb1O6q = 1;
					$pb1l6r = round( $pb1O6p / $pb1l6p, 3 );
				} else {
					$pb1l6r = 1;
					$pb1O6q = round( $pb1l6p / $pb1O6p, 3 );
				}
				$pb1O6r = array(
					"thumbnail" => array( "width" => intval( $pb1O6n["thumbnail"] * $pb1O6q ), "height" => intval( $pb1O6n["thumbnail"] * $pb1l6r ) ),
					"small"     => array( "width" => intval( $pb1O6n["small"] * $pb1O6q ), "height" => intval( $pb1O6n["small"] * $pb1l6r ) ),
					"medium"    => array( "width" => intval( $pb1O6n["medium"] * $pb1O6q ), "height" => intval( $pb1O6n["medium"] * $pb1l6r ) ),
					"large"     => array( "width" => intval( $pb1O6n["large"] * $pb1O6q ), "height" => intval( $pb1O6n["large"] * $pb1l6r ) ),
				);
			} else {
				$pb1O4x = str_replace( "{PBSEO_WIDTH_THUMBNAIL}", '', $pb1O4x );
				$pb1O4x = str_replace( "{PBSEO_HEIGHT_THUMBNAIL}", '', $pb1O4x );
				$pb1O4x = str_replace( "{PBSEO_WIDTH_SMALL}", '0', $pb1O4x );
				$pb1O4x = str_replace( "{PBSEO_HEIGHT_SMALL}", '0', $pb1O4x );
				$pb1O4x = str_replace( "{PBSEO_WIDTH_MEDIUM}", '0', $pb1O4x );
				$pb1O4x = str_replace( "{PBSEO_HEIGHT_MEDIUM}", '0', $pb1O4x );
				$pb1O4x = str_replace( "{PBSEO_WIDTH_LARGE}", '0', $pb1O4x );
				$pb1O4x = str_replace( "{PBSEO_HEIGHT_LARGE}", '0', $pb1O4x );
			}
			$pb1O4x = str_replace( "{PBSEO_COUNTER}", $pb1l5u, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_PREVIEW_THUMBNAIL}", ( isset ( $pb1O6r["thumbnail"]["width"] ) ? " width=\"" . $pb1O6r["thumbnail"]["width"] : '' ) . "\"", $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_PREVIEW_THUMBNAIL}", " height=\"" . ( isset ( $pb1O6r["thumbnail"]["height"] ) ? $pb1O6r["thumbnail"]["height"] : '' ) . "\"", $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_WIDTH_THUMBNAIL}", ( isset ( $pb1O6r["thumbnail"]["width"] ) ? $pb1O6r["thumbnail"]["width"] : '' ), $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_HEIGHT_THUMBNAIL}", ( isset ( $pb1O6r["thumbnail"]["height"] ) ? $pb1O6r["thumbnail"]["height"] : '' ), $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_WIDTH_SMALL}", ( isset ( $pb1O6r["small"]["width"] ) ? $pb1O6r["small"]["width"] : '' ), $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_HEIGHT_SMALL}", ( isset ( $pb1O6r["small"]["height"] ) ? $pb1O6r["small"]["height"] : '' ), $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_WIDTH_MEDIUM}", ( isset ( $pb1O6r["medium"]["width"] ) ? $pb1O6r["medium"]["width"] : '' ), $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_HEIGHT_MEDIUM}", ( isset ( $pb1O6r["medium"]["height"] ) ? $pb1O6r["medium"]["height"] : '' ), $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_WIDTH_LARGE}", ( isset ( $pb1O6r["large"]["width"] ) ? $pb1O6r["large"]["width"] : '' ), $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_HEIGHT_LARGE}", ( isset ( $pb1O6r["large"]["height"] ) ? $pb1O6r["large"]["height"] : '' ), $pb1O4x );
			if ( $pb1O5u == "#fff" ) {
				$pb1O5u = "#f5f5f5";
				$pb1l6i = " class=\"pbseo_dk\"";
			} else {
				$pb1O5u = "#fff";
				$pb1l6i = '';
			}
			$pb1O4x = str_replace( "{PBSEO_BG_CLASS}", $pb1l6i, $pb1O4x );
			$pb1l68 = $pb1l6o["title"];
			if ( pb_string_length( $pb1l68 ) > 062 ) {
				$pb1l6h = pb_htmlspecialchars( pb1O1q( prepare_keywords( $pb1l68 ), 0, 062 ) ) . "&hellip;";
			} else {
				$pb1l6h = pb_htmlspecialchars( prepare_keywords( $pb1l68 ) );
			}
			$pb1l6s = $pb1l6o["ownername"];
			if ( pb_string_length( $pb1l6s ) > 036 ) {
				$pb1O6s = pb_htmlspecialchars( pb1O1q( prepare_keywords( $pb1l6s ), 0, 036 ) ) . "&hellip;";
			} else {
				$pb1O6s = pb_htmlspecialchars( prepare_keywords( $pb1l6s ) );
			}
			$pb1l6t = pb1O2p( prepare_keywords( $pb1O2t["text"] ) );
			$pb1O6t = pb1O2p( prepare_keywords( $pb1l6h ) );
			$pb1l6u = pb1O2r( $pb1O6t, $pb1l6t );
			if ( $pb1l6u === FALSE_BOOL_DEFINE ) {
				$pb1O6u = pb1l6v( pb_htmlspecialchars( $pb1O2t["text"] ) ) . ', ' . $pb1l6h;
			} else {
				$pb1O6u = $pb1l6h;
			}
			$pb1O4x = str_replace( "{PBSEO_TITLE}", $pb1l6h, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_IMG_THUMBNAIL}", "http://farm" . $pb1l6o["farm"] . ".staticflickr.com/" . $pb1l6o["server"] . "/" . $pb1l6o["id"] . "_" . $pb1l6o["secret"] . "_t.jpg", $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_IMG_SMALL}", "http://farm" . $pb1l6o["farm"] . ".staticflickr.com/" . $pb1l6o["server"] . "/" . $pb1l6o["id"] . "_" . $pb1l6o["secret"] . "_m.jpg", $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_IMG_MEDIUM}", "http://farm" . $pb1l6o["farm"] . ".staticflickr.com/" . $pb1l6o["server"] . "/" . $pb1l6o["id"] . "_" . $pb1l6o["secret"] . ".jpg", $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_IMG_LARGE}", "http://farm" . $pb1l6o["farm"] . ".staticflickr.com/" . $pb1l6o["server"] . "/" . $pb1l6o["id"] . "_" . $pb1l6o["secret"] . "_b.jpg", $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_IMG_ALT}", $pb1O6u, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_AUTHOR_PAGE}", "http://www.flickr.com/people/" . $pb1l6o["owner"] . "/", $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_AUTHOR_NAME}", $pb1O6s, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_AUTHOR_NAME_JS}", addslashes( $pb1O6s ), $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_IMG_ALT_JS}", addslashes( $pb1O6u ), $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_TRANS_THUMBNAIL}", pb1O2c, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_TRANS_SMALL}", pb1l2d, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_TRANS_MEDIUM}", pb1O2d, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_TRANS_LARGE}", pb1l2e, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_REL_THUMBNAIL}", "thumbnail", $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_REL_SMALL}", "small", $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_REL_MEDIUM}", "medium", $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_REL_LARGE}", "large", $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_ALT_ID}", $pb1l6o["id"], $pb1O4x );
			$pb1O2y .= $pb1O4x;
			unset ( $pb1O4x );
		}
	}
	$pb1l6j = '<table class="pbseo_content_' . $pb1O6c . '_set">';
	$pb1O6j = '</table>';
	if ( $pb1l5u ) {
		$pb1O2y = $pb1l6j . $pb1O2y . $pb1O6j;
	} else {
		$pb1O2y = $pb1l6j . '<p>No results.</p>' . $pb1O6j;
	}
	echo $pb1O2y;
	echo "<p class=\"pbseo_attribute\">" . __( "Images from", PluginTextDomain_DEFINE ) . " <a href=\"http://www.flickr.com\" target=\"_blank\">Flickr.com</a> (Creative Commons)</p>";
	pb1l5s( $pb1l5k, _pbseo_meta_DEFINE . "content_images_keyword", $pb1l6d );
	$pb1l6k = '';
	$pb1l6k .= "<script type=\"text/javascript\">";
	$pb1l6k .= "jQuery(\"input#pbseo_meta_content_images_keyword\").val(\"" . esc_attr( $pb1l6d ) . "\");";
	$pb1l6k .= "</script>";
	echo $pb1l6k;
	exit ();
}

function pbseo_ajax_get_flickr_width() {
	$pb1O6v = "-1";
	$pb1O6k = trim_wrapper( get_option_wrapper( pbseo_opt_DEFINE . "flickr_api", 1 ) );
	$pb1O6k = @preg_replace( '/[^A-Za-z0-9]/', '', $pb1O6k );
	if ( ! pb1O3u( pb1O1 ) ) {
		echo $pb1O6v;
		exit ();
	}
	if ( empty( $pb1O6k ) ) {
		echo $pb1O6v;
		exit ();
	}
	$pb1l6w = isset ( $_POST['image_id'] ) ? trim_wrapper( stripslashes( $_POST['image_id'] ) ) : FALSE_BOOL_DEFINE;
	$pb1O6w = isset ( $_POST['image_size'] ) ? trim_wrapper( pb1O2p( stripslashes( $_POST['image_size'] ) ) ) : FALSE_BOOL_DEFINE;
	if ( FALSE_BOOL_DEFINE === $pb1l6w ) {
		echo $pb1O6v;
		exit ();
	}
	$pb1l6x = FALSE_BOOL_DEFINE;
	if ( FALSE_BOOL_DEFINE == $pb1O6w ) {
		$pb1O6x = "medium";
	} else {
		$pb1O6x = FALSE_BOOL_DEFINE;
	}
	$pb1O62 = "http://api.flickr.com/services/rest/";
	$pb1O2t = array( "method" => "flickr.photos.getSizes", "api_key" => $pb1O6k, "photo_id" => $pb1l6w, "format" => "php_serial", "expected_content_type" => "text/plain", "cache_response" => FALSE_BOOL_DEFINE, );
	$pb1O2u = pb1O37( $pb1O62, $pb1O2t, "GET", pb1Ok );
	if ( FALSE_BOOL_DEFINE !== $pb1O2u ) {
		$pb1O2u = @unserialize( $pb1O2u );
		if ( ( ! isset ( $pb1O2u["stat"] ) ) || ( "ok" !== $pb1O2u["stat"] ) ) {
			echo "-1";
			exit ();
		}
		if ( isset ( $pb1O2u["sizes"]["size"] ) ) {
			foreach ( $pb1O2u["sizes"]["size"] as $pb1O2q => $pb1l6y ) {
				if ( $pb1O6x && pb1O2p( $pb1l6y["label"] ) == "medium" ) {
					$pb1l6x = $pb1l6y["width"] . "|" . $pb1l6y["height"] . "|" . $pb1l6y["source"];
					$pb1O6x = FALSE_BOOL_DEFINE;
				}
				if ( pb1O2p( $pb1l6y["label"] ) == $pb1O6w ) {
					echo $pb1l6y["width"] . "|" . $pb1l6y["height"] . "|0";
					exit ();
				}
			}
		} else {
			if ( $pb1l6x ) {
				echo $pb1l6x;
			} else {
				echo $pb1O6v;
			}
			exit ();
		}
	} else {
		echo $pb1O6v;
		exit ();
	}
	$pb1O2u = null;
	$pb1O2t = null;
}

function pbseo_ajax_content_get_video() {
	if ( ! pb1O3u( pb1O1 ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Denied", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1O2l = check_ajax_referer( pb1Of, "pbseo_ajax_nonce", FALSE_BOOL_DEFINE );
	if ( FALSE_BOOL_DEFINE === $pb1O2l ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Denied", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1O6c = "video";
	$pb1O2y = '';
	$pb1l5k = isset ( $_POST["pbseo_post_id"] ) ? intval( stripslashes( $_POST["pbseo_post_id"] ) ) : FALSE_BOOL_DEFINE;
	$pb1l5y = isset ( $_POST["pbseo_keyword"] ) ? trim_wrapper( stripslashes( $_POST["pbseo_keyword"] ) ) : FALSE_BOOL_DEFINE;
	if ( empty( $pb1l5y ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "No keyword found", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	if ( empty( $pb1l5k ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Post ID not found", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1l6d = pb1O2p( prepare_keywords( $pb1l5y ) );
	$pb1O62 = 'http://gdata.youtube.com/feeds/api/videos/';
	$pb1O2t = array( "q" => $pb1l6d, "max-results" => 062, "start-index" => 1, "v" => 2, "expected_content_type" => "application/atom+xml", "cache_response" => TRUE_BOOL_DEFINE, );
	if ( "EN" != pb1l1u ) {
		$pb1O2t["lr"] = pb1O2p( pb1l1u );
	}
	$pb1O2u = pb1O37( $pb1O62, $pb1O2t, "GET", pb1Ok );
	if ( FALSE_BOOL_DEFINE === $pb1O2u ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Error trying to retrieve response from remote service", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	libxml_use_internal_errors( TRUE_BOOL_DEFINE );
	libxml_clear_errors();
	try {
		$pb1l63 = @simplexml_load_string( $pb1O2u );
	} catch ( exception $pb1O2w ) {
		$pb1l63 = FALSE_BOOL_DEFINE;
	}
	libxml_clear_errors();
	$pb1O2u = null;
	if ( FALSE_BOOL_DEFINE === $pb1l63 ) {
		write_log( __( "Error trying to parse response from remote service", PluginTextDomain_DEFINE ) );

		return FALSE_BOOL_DEFINE;
	}
	$pb1O66 = $pb1l63->children( "http://a9.com/-/spec/opensearch/1.1/" );
	$pb1l67 = intval( $pb1O66->totalResults );
	$pb1l5u = 0;
	if ( $pb1l67 ) {
		$pb1O5u = '#fff';
		$pb1l6l = intval( $pb1O66->startIndex );
		$pb1O6m = intval( $pb1O66->itemsPerPage );
		$pb1O6l = ( ( $pb1O6m > 0 ) ? intval( $pb1l67 / $pb1O6m ) + 1 : 0 );
		$pb1O6y = FALSE;
		if ( $pb1l6l < $pb1O6l ) {
			$pb1O6y = $pb1l6l + $pb1O6m;
		}
		foreach ( $pb1l63->entry as $pb1O67 ) {
			$pb1l6z = $pb1O67->children( "http://gdata.youtube.com/schemas/2007" );
			if ( isset ( $pb1l6z->noembed ) ) {
				$pb1O67 = null;
				continue;
			}
			$pb1l5u ++;
			$pb1O4x = pb1O6z();
			$pb1O4x = str_replace( "{PBSEO_COUNTER}", $pb1l5u, $pb1O4x );
			$pb1l69 = $pb1O67->children( "http://search.yahoo.com/mrss/" );
			$pb1l70 = $pb1l69->group->player->attributes();
			$pb1O70 = (string) $pb1l70['url'];
			$pb1l70 = $pb1l69->group->thumbnail[0]->attributes();
			$pb1l71 = (string) $pb1l70['url'];
			$pb1O71 = $pb1l69->children( "http://gdata.youtube.com/schemas/2007" );
			$pb1l72 = (string) $pb1O71->videoid;
			$pb1O72 = $pb1O71->duration->attributes();
			$pb1l73 = (int) $pb1O72['seconds'];
			$pb1O73 = '';
			$pb1l74 = 0;
			if ( isset ( $pb1l6z->statistics ) ) {
				$pb1O74 = $pb1l6z->statistics->attributes();
				$pb1l74 = isset ( $pb1O74['viewCount'] ) ? (int) $pb1O74['viewCount'] : 0;
				if ( ( $pb1l74 > 062 ) && ( isset ( $pb1l6z->rating ) ) ) {
					$pb1l75 = $pb1l6z->rating->attributes();
					$pb1O75 = isset ( $pb1l75['numLikes'] ) ? (int) $pb1l75['numLikes'] : 0;
					$pb1l76 = isset ( $pb1l75['numDislikes'] ) ? (int) $pb1l75['numDislikes'] : 0;
					if ( $pb1O75 >= ( $pb1l76 * 2 ) ) {
						$pb1O73 = "<span style=\"font-size:10px;color:green;\">" . number_format( $pb1l74, 0 ) . "</span>";
					} else if ( $pb1O75 >= $pb1l76 ) {
						$pb1O73 = "<span style=\"font-size:10px;\">" . number_format( $pb1l74, 0 ) . "</span>";
					} else {
						$pb1O73 = "<span style=\"font-size:10px;color:red;\">" . number_format( $pb1l74, 0 ) . "</span>";
					}
				}
			}
			$pb1l6z = null;
			$pb1O4x = str_replace( "{PBSEO_URL}", $pb1O70, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_VID_THUMBNAIL}", $pb1l71, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_VID_DURATION}", $pb1l73, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_VID_RATING}", $pb1O73, $pb1O4x );
			if ( $pb1O5u == "#fff" ) {
				$pb1O5u = "#f5f5f5";
				$pb1l6i = " class=\"pbseo_dk\"";
			} else {
				$pb1O5u = "#fff";
				$pb1l6i = '';
			}
			$pb1O4x = str_replace( "{PBSEO_BG_CLASS}", $pb1l6i, $pb1O4x );
			$pb1l68 = (string) $pb1O67->title;
			if ( pb_string_length( $pb1l68 ) > 062 ) {
				$pb1l6h = pb_htmlspecialchars( pb1O1q( prepare_keywords( $pb1l68 ), 0, 062 ) ) . "&hellip;";
			} else {
				$pb1l6h = pb_htmlspecialchars( prepare_keywords( $pb1l68 ) );
			}
			$pb1O76 = (string) $pb1O67->published;
			$pb1O76 = strtotime( $pb1O76 );
			if ( ! empty( $pb1O76 ) ) {
				$pb1O76 = date( "m", $pb1O76 ) . "-" . date( "Y", $pb1O76 ) . ' ';
			} else {
				$pb1O76 = '';
			}
			$pb1l6s = (string) $pb1O67->author->name;
			if ( pb_string_length( $pb1l6s ) > 036 ) {
				$pb1O6s = pb_htmlspecialchars( pb1O1q( prepare_keywords( $pb1l6s ), 0, 036 ) ) . "&hellip;";
			} else {
				$pb1O6s = pb_htmlspecialchars( prepare_keywords( $pb1l6s ) );
			}
			$pb1l77 = 'http://www.youtube.com/user/' . pb_htmlspecialchars( $pb1O67->author->name );
			$pb1O4x = str_replace( "{PBSEO_TITLE}", $pb1l6h, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_PUBLISHED}", $pb1O76, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_AUTHOR_PAGE}", $pb1l77, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_AUTHOR_NAME}", $pb1O6s, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_TRANS_THUMBNAIL}", pb1O2c, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_TRANS_SMALL}", pb1l2d, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_TRANS_MEDIUM}", pb1O2d, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_TRANS_LARGE}", pb1l2e, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_VIDEO_ID}", $pb1l72, $pb1O4x );
			$pb1O67 = null;
			$pb1O2y .= $pb1O4x;
			unset ( $pb1O4x );
		}
	}
	$pb1l6j = '<table class="pbseo_content_' . $pb1O6c . '_set">';
	$pb1O6j = '</table>';
	if ( $pb1l5u ) {
		$pb1O2y = $pb1l6j . $pb1O2y . $pb1O6j;
	} else {
		$pb1O2y = $pb1l6j . '<p>No results.</p>' . $pb1O6j;
	}
	echo $pb1O2y;
	echo "<p class=\"pbseo_attribute\">" . __( "Video from", PluginTextDomain_DEFINE ) . " <a href=\"http://www.youtube.com\" target=\"_blank\">YouTube.com</a></p>";
	pb1l5s( $pb1l5k, _pbseo_meta_DEFINE . "content_video_keyword", $pb1l6d );
	$pb1l6k = '';
	$pb1l6k .= "<script type=\"text/javascript\">";
	$pb1l6k .= "jQuery(\"input#pbseo_meta_content_video_keyword\").val(\"" . esc_attr( $pb1l6d ) . "\");";
	$pb1l6k .= "</script>";
	echo $pb1l6k;
	exit ();
}

function pbseo_ajax_content_get_blogs() {
	if ( ! pb1O3u( pb1O1 ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Denied", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1O2l = check_ajax_referer( pb1Of, "pbseo_ajax_nonce", FALSE_BOOL_DEFINE );
	if ( FALSE_BOOL_DEFINE === $pb1O2l ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Denied", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1O6c = "blogs";
	$pb1O2y = '';
	$pb1l5k = isset ( $_POST["pbseo_post_id"] ) ? intval( stripslashes( $_POST["pbseo_post_id"] ) ) : FALSE;
	$pb1l5y = isset ( $_POST["pbseo_keyword"] ) ? trim_wrapper( stripslashes( $_POST["pbseo_keyword"] ) ) : FALSE;
	if ( empty( $pb1l5y ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "No keyword found", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	if ( empty( $pb1l5k ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Post ID not found", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1l6d = pb1O2p( prepare_keywords( $pb1l5y ) );
	if ( empty( $pb1l6d ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Illegal keyword", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1O62 = "http://www.google.com/search";
	$pb1O2t = array( "q" => $pb1l6d, "hl" => pb1O2p( pb1O1u ), "tbm" => "blg", "output" => "rss", "ie" => "UTF-8", "num" => 024, "expected_content_type" => "text/xml", "cache_response" => TRUE_BOOL_DEFINE, );
	$pb1O2u = pb1O37( $pb1O62, $pb1O2t, "GET", pb1Ok );
	pb1le( $pb1O2u, "BLOG RESPONSE", __FUNCTION__, TRUE_BOOL_DEFINE );
	if ( empty( $pb1O2u ) ) {
		write_log( __( "Error trying to retrieve response from remote service", PluginTextDomain_DEFINE ) );
		echo "<p class=\"pbseo_ajax_error\">" . __( "Error trying to retrieve response from remote service", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	libxml_use_internal_errors( TRUE_BOOL_DEFINE );
	libxml_clear_errors();
	try {
		$pb1l63 = @simplexml_load_string( $pb1O2u );
	} catch ( exception $pb1O2w ) {
		$pb1l63 = FALSE_BOOL_DEFINE;
	}
	if ( FALSE_BOOL_DEFINE === $pb1l63 ) {
		write_log( __( "Error trying to parse response from remote service", PluginTextDomain_DEFINE ) );
		echo "<p class=\"pbseo_ajax_error\">" . __( "Error trying to parse response from remote service", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	if ( isset ( $pb1l63->error ) ) {
		write_log( __( "Server responded with an error", PluginTextDomain_DEFINE ) );
		echo "<p class=\"pbseo_ajax_error\">" . __( "Server responded with an error", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1O4x = '';
	$pb1l5u = 0;
	$pb1O5u = "#fff";
	if ( isset ( $pb1l63->channel->item ) ) {
		foreach ( $pb1l63->channel->item as $pb1O38 ) {
			$pb1l5u ++;
			$pb1O4x = pb1O77();
			$pb1l68 = (string) $pb1O38->title;
			$pb1O6e = (string) $pb1O38->link;
			$pb1l6e = (string) $pb1O38->description;
			$pb1O6i = $pb1O38->children( "http://purl.org/dc/elements/1.1/" );
			$pb1l78 = (string) $pb1O6i->publisher;
			$pb1O78 = (string) $pb1O6i->date;
			$pb1O6f = pb_htmlspecialchars( prepare_keywords( $pb1l68 ) );
			$pb1l6g = pb_htmlspecialchars( pb1O6g( $pb1l6e ) ) . "&hellip;";
			if ( pb_string_length( $pb1l68 ) > 0170 ) {
				$pb1l6h = pb_htmlspecialchars( pb1O1q( prepare_keywords( $pb1l68 ), 0, 0170 ) ) . "&hellip;";
			} else {
				$pb1l6h = pb_htmlspecialchars( prepare_keywords( $pb1l68 ) );
			}
			if ( pb_string_length( $pb1l6e ) > 01000 ) {
				$pb1O6h = pb_htmlspecialchars( pb1O1q( pb1O6g( $pb1l6e ), 0, 01000 ) ) . "&hellip;";
			} else {
				$pb1O6h = pb_htmlspecialchars( pb1O6g( $pb1l6e ) ) . "&hellip;";
			}
			if ( pb_string_length( $pb1l78 ) > 036 ) {
				$pb1l79 = pb_htmlspecialchars( pb1O1q( prepare_keywords( $pb1l78 ), 0, 036 ) ) . "&hellip;";
			} else {
				$pb1l79 = pb_htmlspecialchars( prepare_keywords( $pb1l78 ) );
			}
			$pb1O4x = str_replace( "{PBSEO_TITLE}", $pb1l6h, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_FULL_TITLE}", $pb1O6f, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_LINK}", pb_htmlspecialchars( $pb1O6e ), $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_FULL_DESCRIPTION}", $pb1l6g, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_DESCRIPTION}", $pb1O6h, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_PUBLISHER}", $pb1l79, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_DATE}", $pb1O78, $pb1O4x );
			if ( $pb1O5u == "#fff" ) {
				$pb1O5u = "#f5f5f5";
				$pb1l6i = " class=\"pbseo_dk\"";
			} else {
				$pb1O5u = "#fff";
				$pb1l6i = '';
			}
			$pb1O4x = str_replace( "{PBSEO_BG_CLASS}", $pb1l6i, $pb1O4x );
			$pb1O2y .= $pb1O4x;
			unset ( $pb1O4x );
			libxml_clear_errors();
			$pb1O6i = null;
			$pb1O38 = null;
		}
	}
	$pb1l63 = null;
	if ( 0 == $pb1l5u ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "No results found", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1l6j = '<table class="pbseo_content_' . $pb1O6c . '_set">';
	$pb1O6j = '</table>';
	if ( $pb1l5u ) {
		$pb1O2y = $pb1l6j . $pb1O2y . $pb1O6j;
	} else {
		$pb1O2y = $pb1l6j . '<p>No results.</p>' . $pb1O6j;
	}
	echo $pb1O2y;
	$pb1O2y = null;
	echo "<p class=\"pbseo_attribute\">" . __( "Information from", PluginTextDomain_DEFINE ) . " <a href=\"http://www.google.com/blogsearch\" target=\"_blank\">Google Blog Search</a></p>";
	pb1l5s( $pb1l5k, _pbseo_meta_DEFINE . "content_blogs_keyword", $pb1l6d );
	$pb1l6k = '';
	$pb1l6k .= "<script type=\"text/javascript\">";
	$pb1l6k .= "jQuery(\"input#pbseo_meta_content_blogs_keyword\").val(\"" . esc_attr( $pb1l6d ) . "\");";
	$pb1l6k .= "</script>";
	echo $pb1l6k;
	exit ();
}

function pbseo_ajax_content_get_news() {
	if ( ! pb1O3u( pb1O1 ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Denied", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1O2l = check_ajax_referer( pb1Of, "pbseo_ajax_nonce", FALSE_BOOL_DEFINE );
	if ( FALSE_BOOL_DEFINE === $pb1O2l ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Denied", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1O6c = "blogs";
	$pb1O2y = '';
	$pb1l5k = isset ( $_POST["pbseo_post_id"] ) ? intval( stripslashes( $_POST["pbseo_post_id"] ) ) : FALSE;
	$pb1l5y = isset ( $_POST["pbseo_keyword"] ) ? trim_wrapper( stripslashes( $_POST["pbseo_keyword"] ) ) : FALSE;
	if ( empty( $pb1l5y ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "No keyword found", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	if ( empty( $pb1l5k ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Post ID not found", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1l6d = pb1O2p( prepare_keywords( $pb1l5y ) );
	if ( empty( $pb1l6d ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Illegal keyword", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1O62 = "http://news.google.com/news";
	$pb1O2t = array( "hl" => pb1O2p( pb1O1u ), "gl" => pb1O2p( pb1l1v ), "q" => $pb1l6d, "ie" => "UTF-8", "num" => 024, "output" => "rss", "expected_content_type" => "application/xml", "cache_response" => TRUE_BOOL_DEFINE, );
	$pb1O2u = pb1O37( $pb1O62, $pb1O2t, "GET", pb1Ok );
	if ( empty( $pb1O2u ) ) {
		write_log( __( "Error trying to retrieve response from remote service", PluginTextDomain_DEFINE ) );
		echo "<p class=\"pbseo_ajax_error\">" . __( "Error trying to retrieve response from remote service", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	libxml_use_internal_errors( TRUE_BOOL_DEFINE );
	libxml_clear_errors();
	try {
		$pb1l63 = @simplexml_load_string( $pb1O2u );
	} catch ( exception $pb1O2w ) {
		$pb1l63 = FALSE_BOOL_DEFINE;
	}
	if ( FALSE_BOOL_DEFINE === $pb1l63 ) {
		write_log( __( "Error trying to parse response from remote service", PluginTextDomain_DEFINE ) );
		echo "<p class=\"pbseo_ajax_error\">" . __( "Error trying to parse response from remote service", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	if ( isset ( $pb1l63->error ) ) {
		write_log( __( "Server responded with an error", PluginTextDomain_DEFINE ) );
		echo "<p class=\"pbseo_ajax_error\">" . __( "Server responded with an error", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1O4x = '';
	$pb1l5u = 0;
	$pb1O5u = "#fff";
	if ( isset ( $pb1l63->channel->item ) ) {
		foreach ( $pb1l63->channel->item as $pb1O38 ) {
			$pb1l5u ++;
			$pb1O4x = pb1O77();
			$pb1l68 = (string) $pb1O38->title;
			$pb1O6e = (string) $pb1O38->link;
			$pb1O6e = explode( "&", $pb1O6e );
			foreach ( $pb1O6e as $pb1O2q => $pb1l2r ) {
				if ( "url=" == pb1O1q( $pb1l2r, 0, 4 ) ) {
					$pb1O6e = trim_wrapper( pb1O1q( $pb1l2r, 4 ) );
				}
			}
			$pb1l6e = (string) $pb1O38->description;
			$pb1O78 = (string) (string) $pb1O38->pubDate;
			$pb1l78 = explode( "-", $pb1l68 );
			$pb1l78 = trim_wrapper( array_pop( $pb1l78 ) );
			$pb1O6f = pb_htmlspecialchars( prepare_keywords( $pb1l68 ) );
			$pb1l6g = pb_htmlspecialchars( pb1O6g( $pb1l6e ) ) . "&hellip;";
			if ( pb_string_length( $pb1l68 ) > 0170 ) {
				$pb1l6h = pb_htmlspecialchars( pb1O1q( prepare_keywords( $pb1l68 ), 0, 0170 ) ) . "&hellip;";
			} else {
				$pb1l6h = pb_htmlspecialchars( prepare_keywords( $pb1l68 ) );
			}
			if ( pb_string_length( $pb1l6e ) > 01000 ) {
				$pb1O6h = pb_htmlspecialchars( pb1O1q( pb1O6g( $pb1l6e ), 0, 01000 ) ) . "&hellip;";
			} else {
				$pb1O6h = pb_htmlspecialchars( pb1O6g( $pb1l6e ) ) . "&hellip;";
			}
			if ( pb_string_length( $pb1l78 ) > 036 ) {
				$pb1l79 = pb_htmlspecialchars( pb1O1q( prepare_keywords( $pb1l78 ), 0, 036 ) ) . "&hellip;";
			} else {
				$pb1l79 = pb_htmlspecialchars( prepare_keywords( $pb1l78 ) );
			}
			$pb1O4x = str_replace( "{PBSEO_TITLE}", $pb1l6h, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_FULL_TITLE}", $pb1O6f, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_LINK}", pb_htmlspecialchars( $pb1O6e ), $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_FULL_DESCRIPTION}", $pb1l6g, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_DESCRIPTION}", $pb1O6h, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_PUBLISHER}", $pb1l79, $pb1O4x );
			$pb1O4x = str_replace( "{PBSEO_DATE}", $pb1O78, $pb1O4x );
			if ( $pb1O5u == "#fff" ) {
				$pb1O5u = "#f5f5f5";
				$pb1l6i = " class=\"pbseo_dk\"";
			} else {
				$pb1O5u = "#fff";
				$pb1l6i = '';
			}
			$pb1O4x = str_replace( "{PBSEO_BG_CLASS}", $pb1l6i, $pb1O4x );
			$pb1O2y .= $pb1O4x;
			unset ( $pb1O4x );
			libxml_clear_errors();
			$pb1O38 = null;
		}
	}
	$pb1l63 = null;
	if ( 0 == $pb1l5u ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "No results found", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$pb1l6j = '<table class="pbseo_content_' . $pb1O6c . '_set">';
	$pb1O6j = '</table>';
	if ( $pb1l5u ) {
		$pb1O2y = $pb1l6j . $pb1O2y . $pb1O6j;
	} else {
		$pb1O2y = $pb1l6j . '<p>No results.</p>' . $pb1O6j;
	}
	echo $pb1O2y;
	$pb1O2y = null;
	echo "<p class=\"pbseo_attribute\">" . __( "Information from", PluginTextDomain_DEFINE ) . " <a href=\"http://news.google.com\" target=\"_blank\">Google News</a></p>";
	pb1l5s( $pb1l5k, _pbseo_meta_DEFINE . "content_news_keyword", $pb1l6d );
	$pb1l6k = '';
	$pb1l6k .= "<script type=\"text/javascript\">";
	$pb1l6k .= "jQuery(\"input#pbseo_meta_content_news_keyword\").val(\"" . esc_attr( $pb1l6d ) . "\");";
	$pb1l6k .= "</script>";
	echo $pb1l6k;
	exit ();
}

function pb1O6o() {
	$pb1O4x = "<tr valign=\"top\"><td{PBSEO_BG_CLASS}>";
	$pb1O4x .= "<p class=\"title\">{PBSEO_TITLE}<br /><span class=\"pbseo_smaller\"><a href=\"{PBSEO_AUTHOR_PAGE}\" target=\"_blank\">{PBSEO_AUTHOR_NAME}</a></span></p>";
	$pb1O4x .= "<p class=\"thumb\"><a target=\"_blank\" href=\"{PBSEO_IMG_LARGE}\">";
	$pb1O4x .= "<img border=\"0\" src=\"{PBSEO_IMG_THUMBNAIL}\"{PBSEO_PREVIEW_THUMBNAIL}{PBSEO_PREVIEW_THUMBNAIL} />";
	$pb1O4x .= "</a></p>";
	$pb1O4x .= "<p class=\"ctrl\">";
	$pb1O4x .= "<div class=\"pbseo_ins\"><a class=\"pbseo_flickr_thumb\" rel=\"{PBSEO_REL_THUMBNAIL}\" alt=\"{PBSEO_ALT_ID}\" title=\"{PBSEO_IMG_ALT_JS}\" href=\"{PBSEO_IMG_THUMBNAIL}\" onclick=\"pbseo_image_insertToEditor(this,'{PBSEO_AUTHOR_PAGE}','{PBSEO_AUTHOR_NAME_JS}',{PBSEO_WIDTH_THUMBNAIL},{PBSEO_HEIGHT_THUMBNAIL});return false;\">{PBSEO_TRANS_THUMBNAIL}</a></div>";
	$pb1O4x .= "<div class=\"pbseo_ins\"><a class=\"pbseo_flickr_small\" rel=\"{PBSEO_REL_SMALL}\" alt=\"{PBSEO_ALT_ID}\" title=\"{PBSEO_IMG_ALT_JS}\" href=\"{PBSEO_IMG_SMALL}\" onclick=\"pbseo_image_insertToEditor(this,'{PBSEO_AUTHOR_PAGE}','{PBSEO_AUTHOR_NAME_JS}',{PBSEO_WIDTH_SMALL},{PBSEO_HEIGHT_SMALL});return false;\">{PBSEO_TRANS_SMALL}</a></div>";
	$pb1O4x .= "<div class=\"pbseo_ins\"><a class=\"pbseo_flickr_medium\" rel=\"{PBSEO_REL_MEDIUM}\" alt=\"{PBSEO_ALT_ID}\" title=\"{PBSEO_IMG_ALT_JS}\" href=\"{PBSEO_IMG_MEDIUM}\" onclick=\"pbseo_image_insertToEditor(this,'{PBSEO_AUTHOR_PAGE}','{PBSEO_AUTHOR_NAME_JS}',{PBSEO_WIDTH_MEDIUM},{PBSEO_HEIGHT_MEDIUM});return false;\">{PBSEO_TRANS_MEDIUM}</a></div>";
	$pb1O4x .= "<div class=\"pbseo_ins\"><a class=\"pbseo_flickr_large\" rel=\"{PBSEO_REL_LARGE}\" alt=\"{PBSEO_ALT_ID}\" title=\"{PBSEO_IMG_ALT_JS}\" href=\"{PBSEO_IMG_LARGE}\" onclick=\"pbseo_image_insertToEditor(this,'{PBSEO_AUTHOR_PAGE}','{PBSEO_AUTHOR_NAME_JS}',{PBSEO_WIDTH_LARGE},{PBSEO_HEIGHT_LARGE});return false;\">{PBSEO_TRANS_LARGE}</a></div>";
	$pb1O4x .= "</p><div style=\"clear:both;\"></div></td></tr>";

	return $pb1O4x;
}

function pb1O6z() {
	$pb1O4x = "<tr valign=\"top\"><td{PBSEO_BG_CLASS}>";
	$pb1O4x .= "<p class=\"title\">{PBSEO_TITLE}<br /><span class=\"pbseo_smaller\"><a href=\"{PBSEO_AUTHOR_PAGE}\" target=\"_blank\">{PBSEO_AUTHOR_NAME}</a> {PBSEO_PUBLISHED}({PBSEO_VID_DURATION}s)</span> {PBSEO_VID_RATING}</p>";
	$pb1O4x .= "<p class=\"thumb\"><a target=\"_blank\" href=\"{PBSEO_URL}\" rel=\"{PBSEO_VIDEO_ID}\" onclick=\"pbseo_send_to_gallery(this);return false\">";
	$pb1O4x .= "<img border=\"0\" width=\"100\" height=\"75\" src=\"{PBSEO_VID_THUMBNAIL}\" />";
	$pb1O4x .= "</a></p>";
	$pb1O4x .= "<p class=\"ctrl\">";
	$pb1O4x .= "<div class=\"pbseo_ins\"><a class=\"pbseo_yt_small\" href=\"{PBSEO_URL}\" onclick=\"pbseo_video_insertToEditor(this,1);return false;\">{PBSEO_TRANS_SMALL}</a></div>";
	$pb1O4x .= "<div class=\"pbseo_ins\"><a class=\"pbseo_yt_medium\" href=\"{PBSEO_URL}\" onclick=\"pbseo_video_insertToEditor(this,2);return false;\">{PBSEO_TRANS_MEDIUM}</a></div>";
	$pb1O4x .= "<div class=\"pbseo_ins\"><a class=\"pbseo_yt_large\" href=\"{PBSEO_URL}\" onclick=\"pbseo_video_insertToEditor(this,-1);return false;\">{PBSEO_TRANS_LARGE}</a></div>";
	$pb1O4x .= "</p><div style=\"clear:both;\"></div></td></tr>";

	return $pb1O4x;
}

function pb1O77() {
	$pb1O4x = "<tr valign=\"top\"><td{PBSEO_BG_CLASS}>";
	$pb1O4x .= "<p class=\"title\"><a class=\"pbseo_links_insert\" title=\"{PBSEO_FULL_TITLE}\" target=\"_blank\" href=\"{PBSEO_LINK}\"><img src=\"" . pb1l1l . "img/icon-ins.png\" /></a> {PBSEO_TITLE}";
	$pb1O4x .= "<br /><span class=\"pbseo_smaller\"><a href=\"{PBSEO_LINK}\" target=\"_blank\">{PBSEO_PUBLISHER}</a></span>";
	$pb1O4x .= "<br /><span class=\"pbseo_date\">{PBSEO_DATE}</span></p>";
	$pb1O4x .= "<p class=\"ctrl\"><span class=\"pbseo_small\"><a class=\"pbseo_text_insert\" title=\"{PBSEO_FULL_DESCRIPTION}\" href=\"\"><img src=\"" . pb1l1l . "img/icon-ins.png\" /></a> {PBSEO_DESCRIPTION}</span>";
	$pb1O4x .= "</td></tr>";

	return $pb1O4x;
}

function pb1l6f() {
	$pb1O4x = "<tr valign=\"top\"><td{PBSEO_BG_CLASS}>";
	$pb1O4x .= "<p class=\"title\"><a class=\"pbseo_links_insert\" title=\"{PBSEO_FULL_TITLE}\" target=\"_blank\" href=\"{PBSEO_LINK}\"><img src=\"" . pb1l1l . "img/icon-ins.png\" /></a> {PBSEO_TITLE}</p>";
	$pb1O4x .= "<p class=\"ctrl\"><span class=\"pbseo_small\"><a class=\"pbseo_text_insert\" title=\"{PBSEO_FULL_DESCRIPTION}\" href=\"\"><img src=\"" . pb1l1l . "img/icon-ins.png\" /></a> {PBSEO_DESCRIPTION}</span></p>";
	$pb1O4x .= "</td></tr>";

	return $pb1O4x;
} ?>