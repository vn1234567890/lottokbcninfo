<?php function pbseo_ajax_optimizer_analyze() {
	global $pb1O58, $pb1O3v;
	$pb1O45 = FALSE_BOOL_DEFINE;
	pb1l2l();
	$pb1l7g = intval( get_option_wrapper( "pbseo_opt_proximity_threshold", pb1Ov ) );
	$pb1O7g = intval( get_option_wrapper( "pbseo_opt_enable_warnings", 1 ) );
	$tmp_file_name = plugin_dir_path_DEFINE . "pbseo-mod-optimizer-config.php";
	if ( @file_exists( $tmp_file_name ) ) {
		include_once( $tmp_file_name );
	} else {
		write_log( __( "Failed to include optimizer configuration library", PluginTextDomain_DEFINE ) );
		echo "<p class=\"pbseo_ajax_error\">" . __( "Failed to include optimizer configuration library", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$tmp_file_name = plugin_dir_path_DEFINE . "pbseo-stem.php";
	if ( @file_exists( $tmp_file_name ) ) {
		include_once( $tmp_file_name );
		if ( ! defined( "STEM_FILE_INCLUDED" ) ) {
			define( "STEM_FILE_INCLUDED", TRUE_BOOL_DEFINE );
		}
	} else {
		if ( ! defined( "STEM_FILE_INCLUDED" ) ) {
			define( "STEM_FILE_INCLUDED", FALSE_BOOL_DEFINE );
		}
	}
	$pbseo_post_id = isset ( $_POST["pbseo_post_id"] ) ? intval( stripslashes( $_POST["pbseo_post_id"] ) ) : FALSE_BOOL_DEFINE;
	$pbseo_post_content = isset ( $_POST["pbseo_post_content"] ) ? trim_wrapper( stripslashes( $_POST["pbseo_post_content"] ) ) : FALSE_BOOL_DEFINE;
	if ( FALSE_BOOL_DEFINE !== $pbseo_post_content ) {
		$_POST["pbseo_post_content"] = '';
	}
	$pbseo_post_content = "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/></head><body><div>" . $pbseo_post_content . "</div></body></html>";
	$pbseo_post_preview = isset ( $_POST["pbseo_post_preview"] ) ? trim_wrapper( stripslashes( urldecode( $_POST["pbseo_post_preview"] ) ) ) : FALSE_BOOL_DEFINE;
	if ( FALSE_BOOL_DEFINE !== $pbseo_post_preview ) {
		$_POST["pbseo_post_preview"] = '';
	}
	$pbseo_post_preview = @preg_replace( "/<head>/ui", "<head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>", $pbseo_post_preview );
	$pbseo_keyword = isset ( $_POST["pbseo_keyword"] ) ? trim_wrapper( stripslashes( $_POST["pbseo_keyword"] ) ) : FALSE_BOOL_DEFINE;
	if ( empty( $pbseo_post_preview ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Could not render content", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	if ( empty( $pbseo_post_content ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "No content found", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	if ( empty( $pbseo_keyword ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "No keyword found", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	if ( empty( $pbseo_post_id ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Post ID not found", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	$keywords_prepared = prepare_keywords( $pbseo_keyword );
	if ( empty( $keywords_prepared ) ) {
		echo "<p class=\"pbseo_ajax_error\">" . __( "Illegal keyword", PluginTextDomain_DEFINE ) . "</p>";
		exit ();
	}
	if ( pb_string_length( $keywords_prepared ) < 2 ) {
		echo "<p class=\"pbseo_ajax_error\">" . sprintf( __( "Keyword must be at least %d characters in length", PluginTextDomain_DEFINE ), 2 ) . "</p>";
		exit ();
	}
	$pbseo_post_preview = html_entity_decode_plus( $pbseo_post_preview );
	$pbseo_post = get_post( $pbseo_post_id );
	$post_permalink = pb_get_post_permalink( $pbseo_post_id, $pbseo_post );
	$mod_optimizer_config = array();
	get_mod_optimizer_config( $mod_optimizer_config );
	$pb1l42 = array( "preview" => array(), "article" => array(), );
	$pb1O7l = array();
	$pb1l7m = array( "document_size" => pb_string_length( $pbseo_post_preview ), "article_words" => "", );
	$doc_metas = array();
	get_doc_meta( $pbseo_post_preview, $doc_metas );
	$pb1O7n = array();
	pb1l7o( $pbseo_post_content, $pb1O7n );
	$pb1O7o = pb1l7p( $mod_optimizer_config );
	pb1O7p( $mod_optimizer_config, $pb1O7o );
	$pb1l7q = array();
	pb1O7q( $keywords_prepared, $post_permalink, $pbseo_post_preview, $pbseo_post_content, $pb1l42, $doc_metas, $pb1O7n, $pb1l7q, $pb1l7g );
	unset ( $pbseo_post_preview );
	$words_raw_count = explode( " ", $pbseo_post_content );
	$words_raw_count = count( $words_raw_count );
	$normal_score = 0;
	foreach ( $mod_optimizer_config as $mod_conf_key => $mod_conf_val ) {
		$mod_optimizer_config[ $mod_conf_key ]["source"] = "PREVIEW";
		$pb1l7s                      = ( isset ( $pb1l42["preview"][ $mod_conf_key ]["score"] ) ) ? $pb1l42["preview"][ $mod_conf_key ]["score"] : 0;
		$pb1O7s                      = ( isset ( $pb1l42["article"][ $mod_conf_key ]["score"] ) ) ? $pb1l42["article"][ $mod_conf_key ]["score"] : 0;
		if ( ( $pb1l7s > 0 ) || ( $pb1O7s > 0 ) ) {
			if ( $pb1l7s > $pb1O7s ) {
				if ( ( TRUE_BOOL_DEFINE === $mod_optimizer_config[ $mod_conf_key ]["prefer_article"] ) && ( 0 == $pb1O7s ) ) {
					$pb1l7s                                       = ( $pb1l7s * pb1O11 );
					$mod_optimizer_config[ $mod_conf_key ]["info"]["preview_penalty"] = "Y";
				}
				$mod_optimizer_config[ $mod_conf_key ]["score"]        = round( $pb1l7s * 0144, 0 );
				$mod_optimizer_config[ $mod_conf_key ]["normal_score"] = round( $pb1l7s * $mod_optimizer_config[ $mod_conf_key ]["normal"], 2 );
				$normal_score += $mod_optimizer_config[ $mod_conf_key ]["normal_score"];
				$mod_optimizer_config[ $mod_conf_key ]["info"]["exact"]    = ( "EXACT" == $pb1l42["preview"][ $mod_conf_key ]["type"] );
				$mod_optimizer_config[ $mod_conf_key ]["info"]["partial"]  = ( "PARTIAL" == $pb1l42["preview"][ $mod_conf_key ]["type"] );
				$mod_optimizer_config[ $mod_conf_key ]["info"]["no_match"] = ( "NOMATCH" == $pb1l42["preview"][ $mod_conf_key ]["type"] );
			} else {
				$mod_optimizer_config[ $mod_conf_key ]["source"]       = "ARTICLE";
				$mod_optimizer_config[ $mod_conf_key ]["score"]        = round( $pb1O7s * 0144, 0 );
				$mod_optimizer_config[ $mod_conf_key ]["normal_score"] = round( $pb1O7s * $mod_optimizer_config[ $mod_conf_key ]["normal"], 2 );
				$normal_score += $mod_optimizer_config[ $mod_conf_key ]["normal_score"];
				$mod_optimizer_config[ $mod_conf_key ]["info"]["exact"]    = ( "EXACT" == $pb1l42["article"][ $mod_conf_key ]["type"] );
				$mod_optimizer_config[ $mod_conf_key ]["info"]["partial"]  = ( "PARTIAL" == $pb1l42["article"][ $mod_conf_key ]["type"] );
				$mod_optimizer_config[ $mod_conf_key ]["info"]["no_match"] = ( "NOMATCH" == $pb1l42["article"][ $mod_conf_key ]["type"] );
			}
		} else {
			$mod_optimizer_config[ $mod_conf_key ]["info"]["no_match"] = TRUE_BOOL_DEFINE;
		}
	}
	$article_length_is_bad = FALSE_BOOL_DEFINE;
	if ( $words_raw_count < DEC_100_DEFINE ) {
		$normal_score = round( ( $normal_score / DEC_3_DEFINE ), 0 );
		$article_length_is_bad = DEC_100_DEFINE;
	} else if ( $words_raw_count < DEC_200_DEFINE ) {
		$normal_score = round( ( $normal_score / pb1l14 ), 0 );
		$article_length_is_bad = DEC_200_DEFINE;
	} else if ( $words_raw_count < DEC_300_DEFINE ) {
		$normal_score = round( ( $normal_score / pb1O14 ), 0 );
		$article_length_is_bad = DEC_300_DEFINE;
	}
	$pb1l6k = '';
	$pb1O7t = '';
	$pb1l7u = '';
	$pb1O7u = '';
	$pb1l7v = "";
	$pb1O7t .= "<div id=\"pbseo_element_all\">";
	$pb1O7t .= "<div class=\"pbseo_element_label_main\">SEO Rating: </div>";
	$pb1O7t .= "<div class=\"pbseo_element_bar\">";
	if ( $normal_score <= pb1l15 ) {
		$pb1O5e = pb1l17;
	} else {
		$pb1O5e = pb1O18;
	}
	$pb1O7t .= "<div id=\"pbseo_element_all_score\" class=\"pbseo_element_fill\" style=\"background-color:" . $pb1O5e . ";\"></div>";
	$pb1O7t .= "</div>";
	$pb1O7t .= "<div style=\"clear:both;\"></div>";
	$pb1O7t .= "</div>";
	$pb1O7t .= "<p></p>";
	if ( ( isset ( $doc_metas["robots_noindex"] ) ) && ( TRUE_BOOL_DEFINE == $doc_metas["robots_noindex"] ) ) {
		$pb1O7v = __( "Noindex directive set", PluginTextDomain_DEFINE );
		$pb1l7w = __( "This page will not be indexed by the search engines because it contains the robots directive noindex", PluginTextDomain_DEFINE );
		$pb1O7t .= "<p title=\"" . pb_htmlspecialchars( $pb1l7w ) . "\" class=\"pbseo_optimizer_tab_alert pbseo_critical\">" . pb_htmlspecialchars( $pb1O7v ) . "</p>";
		$pb1l7v .= "<span title=\"" . pb_htmlspecialchars( $pb1l7w ) . "\" class=\"pbseo_optimizer_alert pbseo_critical\">" . pb_htmlspecialchars( $pb1O7v ) . "</span>";
	}
	if ( FALSE_BOOL_DEFINE !== $article_length_is_bad ) {
		$pb1O7w = sprintf( __( "Article (%d) is less than %d words", PluginTextDomain_DEFINE ), $words_raw_count,DEC_300_DEFINE );
		$pb1l7x = sprintf( __( "Quality articles should be %d words or more in length", PluginTextDomain_DEFINE ), DEC_300_DEFINE );
		$pb1O7t .= "<p title=\"" . pb_htmlspecialchars( $pb1l7x ) . "\" class=\"pbseo_optimizer_tab_alert\">" . pb_htmlspecialchars( $pb1O7w ) . "</p>";
		$pb1l7v .= "<span title=\"" . pb_htmlspecialchars( $pb1l7x ) . "\" class=\"pbseo_optimizer_alert\">" . pb_htmlspecialchars( $pb1O7w ) . "</span>";
	}
	$pb1O7x = '';
	$pb1l7y = array();
	$pb1O7y = 0;
	$pb1l7z = 0;
	$pb1O7z = "<span style=\"font-weight:bold;color:" . pb1l18 . ";\">" . __( "PASS", PluginTextDomain_DEFINE ) . "</span>";
	$pb1l80 = "<span style=\"font-weight:bold;color:" . pb1O17 . ";\">" . __( "PARTIAL", PluginTextDomain_DEFINE ) . "</span>";
	$pb1O80 = "<span style=\"font-weight:bold;color:" . pb1l17 . ";\">" . __( "FAIL", PluginTextDomain_DEFINE ) . "</span>";
	foreach ( $mod_optimizer_config as $mod_conf_key => $mod_conf_val ) {
		if ( FALSE_BOOL_DEFINE !== $mod_conf_val["display"] ) {
			$pb1l81 = FALSE_BOOL_DEFINE;
			if ( ! empty( $mod_conf_val["suggest"] ) ) {
				if ( $mod_conf_val["priority"] == pb1lw ) {
					if ( $mod_conf_val["score"] <= pb1Oy ) {
						$pb1l81 = TRUE_BOOL_DEFINE;
					}
				} elseif ( $mod_conf_val["priority"] == pb1Ow ) {
					if ( $mod_conf_val["score"] <= pb1ly ) {
						$pb1l81 = TRUE_BOOL_DEFINE;
					}
				}
			}
			if ( TRUE_BOOL_DEFINE !== $pb1l81 ) {
				$pb1l7u .= "<div id=\"pbseo_element_" . $mod_conf_key . "\">";
				$pb1l7u .= "<div class=\"pbseo_element_label\">";
				$pb1l7u .= "<a href=\"#\" rel=\"pbseo_element_" . $mod_conf_key . "_info_box\" >";
				$pb1l7u .= pb_htmlspecialchars( $mod_conf_val["label"] ) . ": ";
				$pb1l7u .= "</a>";
				$pb1l7u .= "</div>";
				$pb1l7u .= "<div class=\"pbseo_element_bar\">";
				if ( $mod_conf_val["score"] <= pb1O15 ) {
					$pb1O5e = pb1l17;
				} else {
					$pb1O5e = pb1O18;
				}
				$pb1l7u .= "<div id=\"pbseo_element_" . $mod_conf_key . "_score\" class=\"pbseo_element_fill\" style=\"background-color:" . $pb1O5e . ";\"></div>";
				$pb1l7u .= "</div>";
				$pb1l7u .= "<div style=\"clear:both;\"></div>";
				$pb1l7u .= "</div>";
				$pb1l7u .= "<div id=\"pbseo_element_" . $mod_conf_key . "_info\" class=\"pbseo_element_info\">";
				$pb1l7u .= "<div id=\"pbseo_element_" . $mod_conf_key . "_info_box\" class=\"pbseo_element_info_box\">";
				$pb1O81 = "<p style=\"font-size:11px;\">" . __( "Priority", PluginTextDomain_DEFINE ) . ": <strong>";
				if ( $mod_conf_val["priority"] == pb1Ox ) {
					$pb1O81 .= "<span style=\"color:" . pb1l17 . ";\">" . pb1O29 . "</span>";
					$pb1l82 = round( ( pb1Oz * 0144 ), 0 );
					if ( $mod_conf_val["score"] < $pb1l82 ) {
						if ( $mod_conf_val["score"] >= pb1O16 ) {
							$pb1l7z ++;
							$mod_optimizer_config[ $mod_conf_key ]["info"]["color_overload"] = pb1O17;
						} else {
							$pb1O7y ++;
							$mod_optimizer_config[ $mod_conf_key ]["info"]["color_overload"] = pb1l17;
						}
						$mod_optimizer_config[ $mod_conf_key ]["alert"] = $mod_conf_val["label"];
						$pb1l7v .= "<span" . ( ! empty( $mod_conf_val["info"]["desc"] ) ? " title=\"" . pb_htmlspecialchars( $mod_conf_val["info"]["desc"] ) . "\"" : "" ) . " class=\"pbseo_optimizer_alert\">" . pb_htmlspecialchars( $mod_conf_val["label"] ) . "</span>";
					}
				} elseif ( $mod_conf_val["priority"] == pb1lx ) {
					$pb1O81 .= "<span style=\"color:" . pb1l17 . ";\">" . pb1l29 . "</span>";
					if ( $mod_conf_val["score"] <= pb1l16 ) {
						$pb1O7y ++;
						$mod_optimizer_config[ $mod_conf_key ]["info"]["color_overload"] = pb1l17;
						$mod_optimizer_config[ $mod_conf_key ]["alert"]                  = $mod_conf_val["label"];
						$pb1l7v .= "<span" . ( ! empty( $mod_conf_val["info"]["desc"] ) ? " title=\"" . pb_htmlspecialchars( $mod_conf_val["info"]["desc"] ) . "\"" : "" ) . " class=\"pbseo_optimizer_alert\">" . pb_htmlspecialchars( $mod_conf_val["label"] ) . "</span>";
					} elseif ( $mod_conf_val["score"] <= pb1O16 ) {
						$mod_optimizer_config[ $mod_conf_key ]["info"]["color_overload"] = pb1O17;
					}
				} elseif ( $mod_conf_val["priority"] == pb1Ow ) {
					$pb1O81 .= "<span style=\"color:" . pb1l19 . ";\">" . pb1O28 . "</span>";
				} elseif ( $mod_conf_val["priority"] == pb1lw ) {
					$pb1O81 .= "<span style=\"color:" . pb1l19 . ";\">" . pb1l28 . "</span>";
				}
				$pb1O81 .= "</strong>";
				$pb1O81 .= "</p>";
				$pb1l7u .= $pb1O81;
				if ( ! empty( $mod_conf_val["info"]["desc"] ) ) {
					if ( empty( $mod_conf_val["info"]["exact"] ) ) {
						$pb1l7u .= "<p>" . __( $mod_conf_val["info"]["desc"], PluginTextDomain_DEFINE ) . ".</p>";
					}
				}
				$pb1l7u .= "</div>";
				$pb1l7u .= "</div>";
			} else {
				$pb1l7y[] = __( $mod_conf_val["suggest"], PluginTextDomain_DEFINE );
			}
		}
	}
	if ( count( $pb1l7y ) ) {
		$pb1O5u = '#fff';
		$pb1l5u = 0;
		foreach ( $pb1l7y as $mod_conf_key => $mod_conf_val ) {
			$pb1l5u ++;
			if ( $pb1O5u == '#fff' ) {
				$pb1O5u = '#f5f5f5';
			} else {
				$pb1O5u = '#fff';
			}
			$pb1O7x .= "<tr valign=\"top\">";
			$pb1O7x .= "<td class=\"pbseo_suggest_row\">";
			$pb1O7x .= pb_htmlspecialchars( $mod_conf_val );
			$pb1O7x .= "</td>";
			$pb1O7x .= "</tr>";
		}
		$pb1l7u .= "<p style=\"border-top:1px solid #f5f5f5;padding-top:6px;\"><strong>" . __( "Suggestions", PluginTextDomain_DEFINE ) . "</strong></p><table width=\"100%\" class=\"pbseo_suggest_table\">" . $pb1O7x . "</table>";
	}
	if ( ! empty( $pb1l7v ) ) {
		$pb1l7v .= "<p style=\"clear:both;\"></p>";
	}
	if ( pb1O3u( pb1O1 ) ) {
		try {
			$pb1O7u .= pb1O5x( $keywords_prepared, FALSE_BOOL_DEFINE );
		} catch ( exception $pb1O2w ) {
		}
	}
	if ( pb1O3u( pb1O1 ) ) {
		try {
			$pb1O7u .= pb1l6a( $keywords_prepared, FALSE_BOOL_DEFINE );
		} catch ( exception $pb1O2w ) {
		}
	}
	if ( $normal_score > 0144 ) {
		$normal_score = 0144;
	}
	if ( $normal_score < 0 ) {
		$normal_score = 0;
	}
	if ( $normal_score > 0 ) {
		$pb1O82 = $normal_score;
		if ( $pb1O82 <= pb1l15 ) {
			$pb1O82 = pb1l15;
		}
		if ( $pb1O82 > 0144 ) {
			$pb1O82 = 0144;
		}
		if ( ( $normal_score <= pb1l16 ) || ( $pb1O7y > 1 ) ) {
			$pb1l83 = pb1l17;
		} else if ( ( $normal_score <= pb1O16 ) || ( $pb1O7y > 0 ) ) {
			$pb1l83 = pb1O17;
		} else {
			$pb1l83 = pb1l18;
		}
		$pb1l6k .= "jQuery(\"div#pbseo_element_all_score\").animate( ";
		$pb1l6k .= "{ width: \"" . $pb1O82 . "px\", backgroundColor: \"" . $pb1l83 . "\" }, ";
		$pb1l6k .= "600, ";
		$pb1l6k .= "\"swing\"";
		$pb1l6k .= ");";
		$pb1O83 = $pb1l83;
	}
	$pb1l6k .= "jQuery(\"input#pbseo_meta_optimizer_keyword\").val(\"" . esc_attr( $keywords_prepared ) . "\");";
	if ( ! empty( $pb1l7u ) ) {
		$pb1l6k .= " jQuery('#pbseo_output_optimizer_report').html('" . addslashes( $pb1l7u ) . "'); ";
	} else {
		$pb1l6k .= " jQuery('#pbseo_output_optimizer_report').html('<p><em>No results</em></p>'); ";
	}
	foreach ( $mod_optimizer_config as $mod_conf_key => $mod_conf_val ) {
		if ( $mod_conf_val["score"] > 0 ) {
			$pb1l84 = $mod_conf_val["score"];
			if ( $pb1l84 <= pb1l15 ) {
				$pb1l84 = pb1l15;
			}
			if ( $pb1l84 > 0144 ) {
				$pb1l84 = 0144;
			}
			if ( $mod_conf_val["score"] <= pb1l16 ) {
				$pb1l83 = pb1l17;
			} else if ( $mod_conf_val["score"] < pb1O16 ) {
				$pb1l83 = pb1O17;
			} else {
				$pb1l83 = pb1l18;
			}
			if ( ! empty( $mod_conf_val["info"]["color_overload"] ) ) {
				$pb1l83 = $mod_conf_val["info"]["color_overload"];
			}
			$pb1l6k .= "jQuery(\"div#pbseo_element_" . $mod_conf_key . "_score\").animate( ";
			$pb1l6k .= "{ width: \"" . $pb1l84 . "px\", backgroundColor: \"" . $pb1l83 . "\" }, ";
			$pb1l6k .= "600, ";
			$pb1l6k .= "\"swing\"";
			$pb1l6k .= ");";
		}
	}
	if ( ! empty( $pb1O7u ) ) {
		$pb1l6k .= " jQuery('#pbseo_output_optimizer_keywords').html('" . addslashes( $pb1O7u ) . "'); ";
	} else {
		$pb1l6k .= " jQuery('#pbseo_output_optimizer_keywords').html('<p><em>No results</em></p>'); ";
	}
	if ( ( ! empty( $pb1O7g ) ) && ( ! empty( $pb1l7v ) ) ) {
		$pb1l6k .= " jQuery('#pbseo_optimizer_alerts').html('" . addslashes( $pb1l7v ) . "').show('fast'); ";
	} else {
		$pb1l6k .= " jQuery('#pbseo_optimizer_alerts').html('').hide('fast'); ";
	}
	if ( ! empty( $pb1O7t ) ) {
		echo $pb1O7t;
	} else {
		echo "<p><em>No results</em></p>";
	}
	if ( ! empty( $pb1l6k ) ) {
		echo "<script type=\"text/javascript\">" . $pb1l6k . "</script>";
	}
	if ( TRUE_BOOL_DEFINE === $pb1O45 ) {
		pb1le( $normal_score, "pbseo_cumulative_score", __FUNCTION__, $pb1O45 );
		pb1le( $pb1l42, "pbseo_report", __FUNCTION__, $pb1O45 );
		pb1le( $mod_optimizer_config, "pbseo_weight", __FUNCTION__, $pb1O45 );
	}
	pb1l5s( $pbseo_post_id, _pbseo_meta_DEFINE . "optimizer_keyword", $keywords_prepared );
	$pb1O84 = ( $normal_score > 0 ) ? $normal_score . "|" . $pb1O83 : pb1l15 . "|#" . pb1l17;
	pb1l5s( $pbseo_post_id, _pbseo_meta_DEFINE . "optimizer_seo_rating", $pb1O84 );
	unset ( $pbseo_post_id, $pbseo_post_content, $pbseo_keyword, $keywords_prepared );
	unset ( $pbseo_post, $post_permalink, $mod_optimizer_config, $pb1l42, $pb1O7l, $pb1l7m );
	unset ( $doc_metas, $pb1O7n, $pb1O7o, $pb1l7q );
	unset ( $words_raw_count, $normal_score, $pb1l6k );
	unset ( $pb1O7t, $pb1O7u, $pb1l7u, $pb1l7v );
	unset ( $pb1l81, $pb1O7x );
	if ( TRUE_BOOL_DEFINE === $pb1O45 ) {
	}
	exit ();
}

function pb_get_post_permalink( $pbseo_post_id, &$pbseo_post ) {
	$post_permalink = get_permalink( $pbseo_post_id );
	$post_permalink = empty( $post_permalink ) ? FALSE_BOOL_DEFINE : $post_permalink;
	$post_sample_permalink = get_sample_permalink( $pbseo_post_id );
	$post_sample_permalink = isset ( $post_sample_permalink[1] ) ? str_replace( array( '%postname%', '%pagename%' ), $post_sample_permalink[1], $post_sample_permalink[0] ) : FALSE_BOOL_DEFINE;
	$ret_val = $post_sample_permalink;
	if ( "publish" == $pbseo_post->post_status ) {
		$ret_val = $post_permalink;
	}

	return $ret_val;
}

function pb1O85( &$pb1l86, $pb1O86, &$pb1l87 = null ) {
	if ( ( ! is_array( $pb1l86 ) ) || ( ! is_array( $pb1O86 ) ) || ( empty( $pb1l86 ) ) || ( empty( $pb1O86 ) ) ) {
		return;
	}
	foreach ( $pb1O86 as $pb1O2q => $pb1l2r ) {
		$pb1O86[ $pb1O2q ] = http_build_query( $pb1l2r );
	}
	foreach ( $pb1l86 as $pb1O2q => $pb1l2r ) {
		$pb1O87 = http_build_query( $pb1l2r );
		if ( in_array( $pb1O87, $pb1O86 ) ) {
			if ( ! is_null( $pb1l87 ) ) {
				$pb1l87[ $pb1O2q ] = $pb1l2r;
			}
			unset ( $pb1l86[ $pb1O2q ] );
		}
	}
}

function pb1l88( &$pb1O88, $pb1l89 ) {
	if ( ( ! is_array( $pb1O88 ) ) || ( empty( $pb1O88 ) ) ) {
		return;
	}
	foreach ( $pb1O88 as $pb1O2q => $pb1l2r ) {
		$pb1O88[ $pb1O2q ]["type"] = "OUT";
		$pb1O89                    = pb1O1q( $pb1l2r["href"], 0, 1 );
		if ( FALSE_BOOL_DEFINE !== pb1O2r( $pb1l2r["href"], "/wp-admin/" ) ) {
			$pb1O88[ $pb1O2q ]["type"] = "ADMIN";
			continue;
		}
		if ( "#" == $pb1O89 ) {
			$pb1O88[ $pb1O2q ]["type"] = "NAME";
			continue;
		}
		if ( ( "." == $pb1O89 ) || ( "/" == $pb1O89 ) ) {
			$pb1O88[ $pb1O2q ]["type"] = "IN";
			continue;
		}
		$pb1l8a = pb1O39( $pb1l2r["href"], PHP_URL_HOST );
		if ( FALSE_BOOL_DEFINE !== pb1O2r( $pb1l89, $pb1l8a ) ) {
			$pb1O88[ $pb1O2q ]["type"] = "IN";
			continue;
		}
	}
}

function pb_parse_tags( $needed_tags, &$DomDoc, &$tags_parsed ) {
	if ( ( ! is_array( $needed_tags ) ) || ( empty( $needed_tags ) ) ) {
		return;
	}
	foreach ( $needed_tags as $tag_name ) {
		$tag_elements = $DomDoc->getelementsbytagname( $tag_name );
		foreach ( $tag_elements as $tag_el ) {
			$t_tag_parsed = array( 'text' => '', 'attr' => '' );
			if ( ! is_object( $tag_el->nodeValue ) ) {
				$t_tag_parsed['text'] = trim( (string) $tag_el->nodeValue );
			}
			if ( ! is_null( $tag_el->attributes ) ) {
				$tag_attrbutes = array();
				foreach ( $tag_el->attributes as $attr => $attr_val ) {
					$tag_attrbutes[ $attr ] = trim( $attr_val->nodeValue );
				}
				if ( count( $tag_attrbutes ) ) {
					$t_tag_parsed['attr'] = $tag_attrbutes;
				}
			}
			if ( count( $t_tag_parsed ) ) {
				$tags_parsed[ $tag_name ][] = $t_tag_parsed;
			}
			$t_tag_parsed = null;
			$tag_el = null;
		}
		$tag_elements = null;
		libxml_clear_errors();
	}
}

function get_doc_meta( &$pbseo_post_preview, &$ret_array ) {
	global $pb1O58;
	$FALSE = FALSE_BOOL_DEFINE;
	$ret_array = array( "meta_title" => "", "meta_description" => "", "robots_noindex" => "", "robots_nofollow" => "", "img" => array(), "a" => array(), "h1" => array(), );
	$i = 0;
	libxml_clear_errors();
	libxml_use_internal_errors( TRUE_BOOL_DEFINE );
	$DomDoc = new domdocument();
	try {
		$DomDoc->loadhtml( $pbseo_post_preview );
	} catch ( exception $e ) {
		write_log( $e->getmessage() );

		return;
	}
	$tags_parsed = array();
	pb_parse_tags( array( "title", "meta", "h1", "img", "a" ), $DomDoc, $tags_parsed );
	$t_array = array();
	$t_tag_name = "title";
	if ( isset ( $tags_parsed[ $t_tag_name ] ) ) {
		foreach ( $tags_parsed[ $t_tag_name ] as $t_tag_val ) {
			if ( isset ( $t_tag_val["text"] ) ) {
				$t_array[ $i ] = trim_wrapper( $t_tag_val["text"] );
				$i ++;
			}
			$t_tag_val = null;
		}
	}
	if ( ! empty( $t_array ) ) {
		$ret_array['meta_title'] = implode( ' ', $t_array );
	}
	$t_array = array( "description" => '', "keywords" => '', "robots" => '' );
	$t_tag_name = "meta";
	if ( isset ( $tags_parsed[ $t_tag_name ] ) ) {
		foreach ( $tags_parsed[ $t_tag_name ] as $t_tag_val ) {
			if ( ( isset ( $t_tag_val["attr"]["name"] ) ) && ( isset ( $t_tag_val["attr"]["content"] ) ) ) {
				if ( "description" == $t_tag_val["attr"]["name"] ) {
					$t_array["description"][ $i ] = trim( $t_tag_val["attr"]["content"] );
					$i ++;
				} else if ( "robots" == $t_tag_val["attr"]["name"] ) {
					$t_array["robots"][ $i ] = trim( $t_tag_val["attr"]["content"] );
					$i ++;
				}
			}
			$t_tag_val = null;
		}
	}
	if ( ! empty( $t_array["description"] ) ) {
		$ret_array["meta_description"] = implode( ' ', $t_array["description"] );
	}
	if ( ! empty( $t_array["robots"] ) ) {
		$tmp_var = implode( ',', $t_array["robots"] );
		if ( FALSE_BOOL_DEFINE !== pb1O2r( $tmp_var, "noindex" ) ) {
			$ret_array["robots_noindex"] = TRUE_BOOL_DEFINE;
		}
		if ( FALSE_BOOL_DEFINE !== pb1O2r( $tmp_var, "nofollow" ) ) {
			$ret_array["robots_nofollow"] = TRUE_BOOL_DEFINE;
		}
		$tmp_var = null;
	}
	$blog_public = get_option_wrapper( "blog_public" );
	if ( 0 == $blog_public ) {
		$ret_array["robots_noindex"]  = TRUE_BOOL_DEFINE;
		$ret_array["robots_nofollow"] = TRUE_BOOL_DEFINE;
	}
	unset ( $blog_public );
	$t_array = array();
	$t_tag_name = "img";
	if ( isset ( $tags_parsed[ $t_tag_name ] ) ) {
		foreach ( $tags_parsed[ $t_tag_name ] as $t_tag_val ) {
			if ( isset ( $t_tag_val["attr"]["src"] ) ) {
				$tmp_var_2 = array( "src" => trim( $t_tag_val["attr"]["src"] ), "alt" => '' );
				if ( isset ( $t_tag_val["attr"]["alt"] ) ) {
					$tmp_var_2["alt"] = trim( $t_tag_val["attr"]["alt"] );
				}
				$t_array[ $i ] = $tmp_var_2;
				$i ++;
				$tmp_var_2 = null;
			}
			$t_tag_val = null;
		}
	}
	if ( ! empty( $t_array ) ) {
		$ret_array["img"] = $t_array;
	}
	$t_array = array();
	$t_tag_name = "a";
	if ( isset ( $tags_parsed[ $t_tag_name ] ) ) {
		foreach ( $tags_parsed[ $t_tag_name ] as $t_tag_val ) {
			if ( isset ( $t_tag_val["text"] ) ) {
				$tmp_var_2 = array( "anchor" => trim( $t_tag_val["text"] ), "href" => '', "title" => '', "rel" => '' );
				if ( isset ( $t_tag_val["attr"]["href"] ) ) {
					$tmp_var_2["href"] = trim( $t_tag_val["attr"]["href"] );
				}
				if ( isset ( $t_tag_val["attr"]["title"] ) ) {
					$tmp_var_2["title"] = trim( $t_tag_val["attr"]["title"] );
				}
				if ( isset ( $t_tag_val["attr"]["rel"] ) ) {
					$tmp_var_2["rel"] = trim( $t_tag_val["attr"]["rel"] );
				}
				$t_array[ $i ] = $tmp_var_2;
				$i ++;
				$tmp_var_2 = null;
			}
			$t_tag_val = null;
		}
	}
	if ( ! empty( $t_array ) ) {
		$ret_array["a"] = $t_array;
	}
	$t_array = array();
	$t_tag_name = "h1";
	if ( isset ( $tags_parsed[ $t_tag_name ] ) ) {
		foreach ( $tags_parsed[ $t_tag_name ] as $t_tag_val ) {
			if ( isset ( $t_tag_val["text"] ) ) {
				$t_array[ $i ]["text"] = trim( $t_tag_val["text"] );
				$i ++;
			}
			$t_tag_val = null;
		}
	}
	if ( ! empty( $t_array ) ) {
		$ret_array["h1"] = $t_array;
	}
	libxml_clear_errors();
	$DomDoc = null;
	$t_array = null;
	$t_tag_name = null;
	pb1le( $tags_parsed, "Preview raw parsed data", __FUNCTION__, $FALSE );
	pb1le( $ret_array, "Preview parsed data", __FUNCTION__, $FALSE );
}

function pb1l7o( &$pb1l8h, &$pb1O8e ) {
	global $pb1O58;
	$pb1O45 = FALSE_BOOL_DEFINE;
	$pb1O8e = array( "img" => array(), "a" => array(), "h2" => array(), "h3" => array(), );
	$i = 0;
	libxml_clear_errors();
	libxml_use_internal_errors( TRUE_BOOL_DEFINE );
	$pb1O4x = new domdocument();
	try {
		$pb1O4x->loadhtml( $pb1l8h );
	} catch ( exception $pb1O2w ) {
		write_log( $pb1O2w->getmessage() );

		return;
	}
	$pb1O8b = array();
	pb_parse_tags( array( "img", "a", "h2", "h3" ), $pb1O4x, $pb1O8b );
	$pb1l3c = array();
	$pb1O65 = "img";
	if ( isset ( $pb1O8b[ $pb1O65 ] ) ) {
		foreach ( $pb1O8b[ $pb1O65 ] as $pb1O38 ) {
			if ( isset ( $pb1O38["attr"]["src"] ) ) {
				$pb1O8g = array( "src" => trim( $pb1O38["attr"]["src"] ), "alt" => '' );
				if ( isset ( $pb1O38["attr"]["alt"] ) ) {
					$pb1O8g["alt"] = trim( $pb1O38["attr"]["alt"] );
				}
				$pb1l3c[ $i ] = $pb1O8g;
				$i ++;
				$pb1O8g = null;
			}
			$pb1O38 = null;
		}
	}
	if ( ! empty( $pb1l3c ) ) {
		$pb1O8e["img"] = $pb1l3c;
	}
	$pb1l3c = array();
	$pb1O65 = "a";
	if ( isset ( $pb1O8b[ $pb1O65 ] ) ) {
		foreach ( $pb1O8b[ $pb1O65 ] as $pb1O38 ) {
			if ( isset ( $pb1O38["text"] ) ) {
				$pb1O8g = array( "anchor" => trim( $pb1O38["text"] ), "href" => '', "title" => '', "rel" => '' );
				if ( isset ( $pb1O38["attr"]["href"] ) ) {
					$pb1O8g["href"] = trim( $pb1O38["attr"]["href"] );
				}
				if ( isset ( $pb1O38["attr"]["title"] ) ) {
					$pb1O8g["title"] = trim( $pb1O38["attr"]["title"] );
				}
				if ( isset ( $pb1O38["attr"]["rel"] ) ) {
					$pb1O8g["rel"] = trim( $pb1O38["attr"]["rel"] );
				}
				$pb1l3c[ $i ] = $pb1O8g;
				$i ++;
				$pb1O8g = null;
			}
			$pb1O38 = null;
		}
	}
	if ( ! empty( $pb1l3c ) ) {
		$pb1O8e["a"] = $pb1l3c;
	}
	$pb1l3c = array();
	$pb1O65 = "h2";
	if ( isset ( $pb1O8b[ $pb1O65 ] ) ) {
		foreach ( $pb1O8b[ $pb1O65 ] as $pb1O38 ) {
			if ( isset ( $pb1O38["text"] ) ) {
				$pb1l3c[ $i ]["text"] = trim( $pb1O38["text"] );
				$i ++;
			}
			$pb1O38 = null;
		}
	}
	if ( ! empty( $pb1l3c ) ) {
		$pb1O8e["h2"] = $pb1l3c;
	}
	$pb1l3c = array();
	$pb1O65 = "h3";
	if ( isset ( $pb1O8b[ $pb1O65 ] ) ) {
		foreach ( $pb1O8b[ $pb1O65 ] as $pb1O38 ) {
			if ( isset ( $pb1O38["text"] ) ) {
				$pb1l3c[ $i ]["text"] = trim( $pb1O38["text"] );
				$i ++;
			}
			$pb1O38 = null;
		}
	}
	if ( ! empty( $pb1l3c ) ) {
		$pb1O8e["h3"] = $pb1l3c;
	}
	libxml_clear_errors();
	$pb1O4x = null;
	$pb1l3c = null;
	$pb1O65 = null;
	pb1le( $pb1O8b, "Article raw parsed data", __FUNCTION__, $pb1O45 );
	pb1le( $pb1O8e, "Article parsed data", __FUNCTION__, $pb1O45 );
}

function pb1l7p( &$pb1O7k ) {
	$pb1O7o = 0;
	foreach ( $pb1O7k as $pb1O2q => $pb1l2r ) {
		$pb1O7o += $pb1l2r["base"];
	}

	return $pb1O7o;
}

function pb1O7p( &$pb1O7k, $pb1O7o ) {
	$pb1O8h = count( $pb1O7k );
	$pb1l8i = array();
	foreach ( $pb1O7k as $pb1O2q => $pb1l2r ) {
		$pb1l8i[] = $pb1l2r["base"];
	}
	$pb1O8i = pb1l51( $pb1l8i );
	$pb1O81 = array( "low" => pb1O54( $pb1l8i ), "medium" => pb1O56( $pb1l8i ), "high" => pb1l57( $pb1l8i ), "critical" => $pb1O8i["val"], );
	foreach ( $pb1O7k as $pb1O2q => $pb1l2r ) {
		$pb1O7k[ $pb1O2q ]["normal"] = round( ( ( $pb1l2r["base"] / $pb1O7o ) * 0144 ), 2 );
		if ( $pb1O7k[ $pb1O2q ]["base"] <= $pb1O81["low"] ) {
			$pb1O7k[ $pb1O2q ]["priority"] = pb1lw;
		} else if ( $pb1O7k[ $pb1O2q ]["base"] <= $pb1O81["medium"] ) {
			$pb1O7k[ $pb1O2q ]["priority"] = pb1Ow;
		} else if ( $pb1O7k[ $pb1O2q ]["base"] <= $pb1O81["high"] ) {
			$pb1O7k[ $pb1O2q ]["priority"] = pb1lx;
		} else {
			$pb1O7k[ $pb1O2q ]["priority"] = pb1Ox;
		}
	}
}

function pb1O7q( $pb1l6d, $pb1O7j, &$pb1l7i, &$pb1O7h, &$pb1l42, &$pb1O7m, &$pb1O7n, &$pb1l8j, $pb1l7g ) {
	$pb1O45 = FALSE_BOOL_DEFINE;
	$pb1l8j = array(
		"preview" => array(
			"permalink"           => 0,
			"meta_title"          => 0,
			"meta_description"    => 0,
			"meta_img"            => 0,
			"meta_links_internal" => 0,
			"meta_links_outbound" => 0,
			"meta_headings"       => 0,
		),
		"article" => array( "meta_img" => 0, "meta_links_internal" => 0, "meta_links_outbound" => 0, "meta_sub_headings" => 0, "meta_video" => 0, ),
	);
	if ( ( pb1O1o != "UTF-8" ) || ( FALSE_BOOL_DEFINE === pb1l1w ) ) {
		$pb1l4b = @preg_replace( '/[^' . pb1Oo . pb1lp . '\\. ]/', '', remove_accents( $pb1l6d ) );
	} else {
		$pb1l4b = @preg_replace( '/[^' . pb1lo . pb1lp . '\\. ]/iu', '', remove_accents( $pb1l6d ) );
	}
	$pb1O8j = explode( "|", pb1lq );
	$pb1l8k = explode( "|", pb1Oq );
	$pb1l4b = explode( '.', $pb1l4b );
	if ( count( $pb1l4b ) > 1 ) {
		$pb1O8k = trim_wrapper( array_pop( $pb1l4b ) );
		if ( ( ! in_array( $pb1O8k, $pb1O8j ) ) && ( ! in_array( $pb1O8k, $pb1l8k ) ) ) {
			array_push( $pb1l4b, $pb1O8k );
		}
	}
	$pb1l4b = implode( ' ', $pb1l4b );
	pb1le( $pb1l4b, "KEYWORD MAP", __FUNCTION__, $pb1O45 );
	$pb1l4b = pb1O47( $pb1l4b, pb1l1r );
	pb1le( $pb1l4b, "Remove stop words from KEYWORD MAP", __FUNCTION__, $pb1O45 );
	$pb1l8l = explode( ' ', $pb1l4b );
	pb1le( $pb1l8l, "KEYWORD ARR", __FUNCTION__, $pb1O45 );
	$pb1l3g = pb1O39( $pb1O7j, PHP_URL_HOST );
	pb1le( $pb1l3g, "RAW DOMAIN", __FUNCTION__, $pb1O45 );
	$pb1O8l = pb1O39( $pb1O7j, PHP_URL_PATH );
	pb1le( $pb1O8l, "RAW PATH", __FUNCTION__, $pb1O45 );
	$pb1l8m = "permalink";
	$pb1l45 = "Permalink";
	$pb1O62 = $pb1l3g . $pb1O8l;
	pb1le( $pb1O62, "RAW URL", __FUNCTION__, $pb1O45 );
	if ( ! empty( $pb1O62 ) ) {
		if ( ( pb1O1o != "UTF-8" ) || ( FALSE_BOOL_DEFINE === pb1l1w ) ) {
			$pb1l89 = @preg_replace( '/[^' . pb1Oo . pb1lp . '\\.]/', '', $pb1l3g );
		} else {
			$pb1l89 = @preg_replace( '/[^' . pb1lo . pb1lp . '\\.]/iu', '', $pb1l3g );
		}
		pb1le( $pb1l89, "Regex host", __FUNCTION__, $pb1O45 );
		$pb1l89 = @preg_replace( '/^www\\./i', '', $pb1l89 );
		pb1le( $pb1l89, "Remove www", __FUNCTION__, $pb1O45 );
		$pb1O8m = explode( '.', $pb1l89 );
		if ( count( $pb1O8m ) > 1 ) {
			$pb1l8n = array_pop( $pb1O8m );
			if ( ! in_array( $pb1l8n, $pb1O8j ) ) {
				array_push( $pb1O8m, $pb1l8n );
			}
		}
		$pb1O8m = implode( '.', $pb1O8m );
		pb1le( $pb1O8m, "Strip TLD", __FUNCTION__, $pb1O45 );
		if ( ( pb1O1o != "UTF-8" ) || ( FALSE_BOOL_DEFINE === pb1l1w ) ) {
			$pb1O8m = trim( preg_replace( '/' . pb1Oo . pb1lp . '/', ' ', $pb1O8m ) );
		} else {
			$pb1O8m = trim( preg_replace( '/' . pb1lo . pb1lp . '/iu', ' ', $pb1O8m ) );
		}
		pb1le( $pb1O8m, "Strip non-alpha", __FUNCTION__, $pb1O45 );
		if ( ( pb1O1o != "UTF-8" ) || ( FALSE_BOOL_DEFINE === pb1l1w ) ) {
			$pb1O8n = @preg_replace( '/[^' . pb1Oo . pb1lp . '\\.]/', ' ', $pb1O8l );
		} else {
			$pb1O8n = @preg_replace( '/[^' . pb1lo . pb1lp . '\\.]/iu', ' ', $pb1O8l );
		}
		pb1le( $pb1O8n, "Regex path", __FUNCTION__, $pb1O45 );
		$pb1l8o = explode( '.', $pb1O8n );
		if ( count( $pb1l8o ) > 1 ) {
			$pb1O8o = array_pop( $pb1l8o );
			if ( ! in_array( trim_wrapper( $pb1O8o ), $pb1l8k ) ) {
				array_push( $pb1l8o, $pb1O8o );
			}
		}
		$pb1l8o = implode( '.', $pb1l8o );
		pb1le( $pb1l8o, "Strip EXT", __FUNCTION__, $pb1O45 );
		$pb1O8m = pb1O47( $pb1O8m, pb1l1r );
		pb1le( $pb1O8m, "Remove stop words from HOST MAP", __FUNCTION__, $pb1O45 );
		$pb1l8o = pb1O47( $pb1l8o, pb1l1r );
		pb1le( $pb1l8o, "Remove stop words from PATH MAP", __FUNCTION__, $pb1O45 );
		foreach ( $pb1l8l as $pb1O2q => $pb1l49 ) {
			$pb1O8m = str_replace( $pb1l49, ' ' . $pb1l49 . ' ', $pb1O8m );
			$pb1l8o = str_replace( $pb1l49, ' ' . $pb1l49 . ' ', $pb1l8o );
		}
		$pb1O8m = trim_wrapper( @preg_replace( '/[ ]{2,}/', ' ', $pb1O8m ) );
		$pb1l8o = trim_wrapper( @preg_replace( '/[ ]{2,}/', ' ', $pb1l8o ) );
		pb1le( $pb1O8m, "Break to words", __FUNCTION__, $pb1O45 );
		pb1le( $pb1l8o, "Break to words", __FUNCTION__, $pb1O45 );
		$pb1O62 = $pb1O8m . ' ' . $pb1l8o;
		pb1le( $pb1O62, "FINAL URL", __FUNCTION__, $pb1O45 );
		$pb1l8p = pb1O3z( $pb1l4b, $pb1O8m, $pb1l7g );
		$pb1O8p = $pb1l8p["score"];
		pb1le( $pb1l8p, "pbseo_host_report", __FUNCTION__, $pb1O45 );
		$pb1l8q = 0;
		if ( $pb1O8p <= pb1Oz ) {
			$pb1O8q = pb1O3z( $pb1l4b, $pb1l8o, $pb1l7g );
			$pb1l8q = $pb1O8q["score"];
			pb1le( $pb1O8q, "pbseo_path_report", __FUNCTION__, $pb1O45 );
		}
		if ( $pb1O8p >= $pb1l8q ) {
			$pb1l42["preview"][ $pb1l8m ] = $pb1l8p;
			pb1le( $pb1O8p, "SELECTED host: pbseo_host_score", __FUNCTION__, $pb1O45 );
		} else {
			$pb1l42["preview"][ $pb1l8m ] = $pb1O8q;
			pb1le( $pb1l8q, "SELECTED path: pbseo_path_score", __FUNCTION__, $pb1O45 );
		}
		unset ( $pb1O8m, $pb1l8p, $pb1l8o, $pb1O8q );
		$pb1l8j["preview"][ $pb1l8m ] = 1;
	} else {
		$pb1l42["preview"][ $pb1l8m ] = array( "score" => 0, "report" => array(), "type" => "NOMATCH", "error" => __( "Missing or empty" ) . " " . $pb1l45 );
	}
	$pb1O5n = $pb1O7m["meta_title"];
	$pb1l8m = "meta_title";
	$pb1l45 = "META Title";
	if ( ! empty( $pb1O5n ) ) {
		$pb1l42["preview"][ $pb1l8m ] = pb1O42( $pb1l6d, prepare_keywords( $pb1O5n ), $pb1l7g, FALSE_BOOL_DEFINE, FALSE_BOOL_DEFINE, "META Title" );
		$pb1l8j["preview"][ $pb1l8m ] = 1;
	} else {
		$pb1l42["preview"][ $pb1l8m ] = array( "score" => 0, "report" => array(), "type" => "NOMATCH", "error" => __( "Missing or empty" ) . " " . $pb1l45 );
	}
	$pb1O5n = $pb1O7m["meta_description"];
	$pb1l8m = "meta_description";
	$pb1l45 = "META Description";
	if ( ! empty( $pb1O5n ) ) {
		$pb1l42["preview"][ $pb1l8m ] = pb1O42( $pb1l6d, prepare_keywords( $pb1O5n ), $pb1l7g );
		$pb1l8j["preview"][ $pb1l8m ] = 1;
	} else {
		$pb1l42["preview"][ $pb1l8m ] = array( "score" => 0, "report" => array(), "type" => "NOMATCH", "error" => __( "Missing or empty" ) . " " . $pb1l45 );
	}
	pb1O85( $pb1O7m["img"], $pb1O7n["img"] );
	$pb1l45 = "Image ALT";
	$pb1l8r = count( $pb1O7m["img"] );
	$pb1O8r = count( $pb1O7n["img"] );
	$pb1l8m = "meta_img";
	$pb1l6x = array();
	if ( ( isset ( $pb1O7m["img"] ) ) && ( is_array( $pb1O7m["img"] ) ) ) {
		foreach ( $pb1O7m["img"] as $pb1O2q => $pb1l2r ) {
			if ( ! empty( $pb1l2r["alt"] ) ) {
				$pb1l6x[ $pb1O2q ] = prepare_keywords( $pb1l2r["alt"] );
				$pb1l8j["preview"][ $pb1l8m ] ++;
			}
		}
	}
	if ( count( $pb1l6x ) ) {
		$pb1l42["preview"][ $pb1l8m ] = pb1O42( $pb1l6d, $pb1l6x, $pb1l7g );
	} else {
		$pb1l42["preview"][ $pb1l8m ] = array( "score" => 0, "report" => array(), "type" => "NOMATCH", "error" => __( "Missing or empty" ) . " " . $pb1l45 );
	}
	$pb1l8m = "meta_img";
	$pb1l6x = array();
	foreach ( $pb1O7n["img"] as $pb1O2q => $pb1l2r ) {
		if ( ! empty( $pb1l2r["alt"] ) ) {
			$pb1l6x[ $pb1O2q ] = prepare_keywords( $pb1l2r["alt"] );
			$pb1l8j["article"][ $pb1l8m ] ++;
		}
	}
	if ( count( $pb1l6x ) ) {
		$pb1l6x                       = pb1O4u( $pb1l6x, $pb1l7g );
		$pb1l42["article"][ $pb1l8m ] = pb1O42( $pb1l6d, $pb1l6x, $pb1l7g );
	} else {
		$pb1l42["article"][ $pb1l8m ] = array( "score" => 0, "report" => array(), "type" => "NOMATCH", "error" => __( "Missing or empty" ) . " " . $pb1l45 );
	}
	unset ( $pb1l6x );
	$pb1l87 = array();
	pb1O85( $pb1O7m["a"], $pb1O7n["a"], $pb1l87 );
	$pb1l8s = count( $pb1O7m["a"] );
	$pb1O8s = count( $pb1O7n["a"] );
	$pb1l8t = pb1O39( pb1l1l, PHP_URL_HOST );
	pb1l88( $pb1O7m["a"], $pb1l8t );
	pb1l88( $pb1O7n["a"], $pb1l8t );
	pb1le( $pb1O7m["a"], "PREVIEW LINKS", "", $pb1O45 );
	pb1le( $pb1O7n["a"], "ARTICLE LINKS", "", $pb1O45 );
	pb1le( $pb1l87, "DUPLICATE LINKS", "", $pb1O45 );
	$pb1O8t = array();
	$pb1l8u = array();
	$pb1O8u = 0;
	$pb1l8v = 0;
	if ( ( isset ( $pb1O7m["a"] ) ) && ( is_array( $pb1O7m["a"] ) ) ) {
		foreach ( $pb1O7m["a"] as $pb1O2q => $pb1l2r ) {
			$pb1O8v = $pb1O8v = prepare_keywords( $pb1l2r["anchor"] );
			if ( ! empty( $pb1O8v ) ) {
				if ( $pb1l2r["type"] == "OUT" ) {
					$pb1O8u ++;
					$pb1O8t[ $pb1O2q ] = $pb1O8v;
					$pb1l8j["preview"]["meta_links_outbound"] ++;
				} else if ( $pb1l2r["type"] == "IN" ) {
					$pb1l8v ++;
					$pb1l8u[ $pb1O2q ] = $pb1O8v;
					$pb1l8j["preview"]["meta_links_internal"] ++;
				}
			}
		}
	}
	$pb1l8m = "meta_links_outbound";
	$pb1l45 = "Outbound Links";
	if ( count( $pb1O8t ) ) {
		$pb1O8t                       = pb1O4u( $pb1O8t, $pb1l7g );
		$pb1l42["preview"][ $pb1l8m ] = pb1O42( $pb1l6d, $pb1O8t, $pb1l7g );
	} else {
		$pb1l42["preview"][ $pb1l8m ] = array( "score" => 0, "report" => array(), "type" => "NOMATCH", "error" => __( "Missing or empty" ) . " " . $pb1l45 );
	}
	$pb1l8m = "meta_links_internal";
	$pb1l45 = "Internal Links";
	if ( count( $pb1l8u ) ) {
		$pb1l8u                       = pb1O4u( $pb1l8u, $pb1l7g );
		$pb1l42["preview"][ $pb1l8m ] = pb1O42( $pb1l6d, $pb1l8u, $pb1l7g );
	} else {
		$pb1l42["preview"][ $pb1l8m ] = array( "score" => 0, "report" => array(), "type" => "NOMATCH", "error" => __( "Missing or empty" ) . " " . $pb1l45 );
	}
	pb1le( $pb1O8t, "pbseo_outbound_links", __FUNCTION__, $pb1O45 );
	pb1le( $pb1l8u, "pbseo_internal_links", __FUNCTION__, $pb1O45 );
	$pb1O8t = array();
	$pb1l8u = array();
	foreach ( $pb1O7n["a"] as $pb1O2q => $pb1l2r ) {
		$pb1O8v = $pb1O8v = prepare_keywords( $pb1l2r["anchor"] );
		if ( ! empty( $pb1O8v ) ) {
			if ( $pb1l2r["type"] == "OUT" ) {
				$pb1O8u ++;
				$pb1O8t[ $pb1O2q ] = $pb1O8v;
				$pb1l8j["article"]["meta_links_outbound"] ++;
			} else if ( $pb1l2r["type"] == "IN" ) {
				$pb1l8v ++;
				$pb1l8u[ $pb1O2q ] = $pb1O8v;
				$pb1l8j["article"]["meta_links_internal"] ++;
			}
		}
	}
	$pb1l8m = "meta_links_outbound";
	$pb1l45 = "Outbound Links";
	if ( count( $pb1O8t ) ) {
		$pb1O8t                       = pb1O4u( $pb1O8t, $pb1l7g );
		$pb1l42["article"][ $pb1l8m ] = pb1O42( $pb1l6d, $pb1O8t, $pb1l7g );
	} else {
		$pb1l42["article"][ $pb1l8m ] = array( "score" => 0, "report" => array(), "type" => "NOMATCH", "error" => __( "Missing or empty" ) . " " . $pb1l45 );
	}
	$pb1l8m = "meta_links_internal";
	$pb1l45 = "Internal Links";
	if ( count( $pb1l8u ) ) {
		$pb1l8u                       = pb1O4u( $pb1l8u, $pb1l7g );
		$pb1l42["article"][ $pb1l8m ] = pb1O42( $pb1l6d, $pb1l8u, $pb1l7g );
	} else {
		$pb1l42["article"][ $pb1l8m ] = array( "score" => 0, "report" => array(), "type" => "NOMATCH", "error" => __( "Missing or empty" ) . " " . $pb1l45 );
	}
	unset ( $pb1O8t, $pb1l8u );
	$pb1l45 = "Headings";
	$pb1l8w = count( $pb1O7m["h1"] );
	$pb1l8m = "meta_headings";
	$pb1O8w = array();
	if ( ( isset ( $pb1O7m["h1"] ) ) && ( is_array( $pb1O7m["h1"] ) ) ) {
		foreach ( $pb1O7m["h1"] as $pb1O2q => $pb1l2r ) {
			if ( ! empty( $pb1l2r["text"] ) ) {
				$pb1O8w[ $pb1O2q ] = prepare_keywords( $pb1l2r["text"] );
				$pb1l8j["preview"][ $pb1l8m ] ++;
			}
		}
	}
	if ( count( $pb1O8w ) ) {
		$pb1O8w                       = pb1O4u( $pb1O8w, $pb1l7g );
		$pb1l42["preview"][ $pb1l8m ] = pb1O42( $pb1l6d, $pb1O8w, $pb1l7g );
	} else {
		$pb1l42["preview"][ $pb1l8m ] = array( "score" => 0, "report" => array(), "type" => "NOMATCH", "error" => __( "Missing or empty" ) . " " . $pb1l45 );
	}
	unset ( $pb1O8w );
	$pb1l8x = $pb1O7n["h2"] + $pb1O7n["h3"];
	$pb1l45 = "Sub Headings";
	$pb1O8x = count( $pb1l8x );
	$pb1l8m = "meta_sub_headings";
	$pb1l8y = array();
	foreach ( $pb1l8x as $pb1O2q => $pb1l2r ) {
		if ( ! empty( $pb1l2r["text"] ) ) {
			$pb1l8y[ $pb1O2q ] = prepare_keywords( $pb1l2r["text"] );
			$pb1l8j["article"][ $pb1l8m ] ++;
		}
	}
	if ( count( $pb1l8y ) ) {
		$pb1l8y                       = pb1O4u( $pb1l8y, $pb1l7g );
		$pb1l42["article"][ $pb1l8m ] = pb1O42( $pb1l6d, $pb1l8y, $pb1l7g );
	} else {
		$pb1l42["article"][ $pb1l8m ] = array( "score" => 0, "report" => array(), "type" => "NOMATCH", "error" => __( "Missing or empty" ) . " " . $pb1l45 );
	}
	unset ( $pb1l8y );
	$pb1l45 = "Video Embed";
	$pb1l8m = "meta_video";
	$pb1O8y = pb1l4x( $pb1l7i );
	if ( $pb1O8y ) {
		$pb1l42["article"][ $pb1l8m ] = array( "score" => 1, "report" => array(), "type" => "EXACT", "error" => "" );
		$pb1l8j["article"][ $pb1l8m ] = $pb1O8y;
	} else {
		$pb1l42["article"][ $pb1l8m ] = array( "score" => 0, "report" => array(), "type" => "NOMATCH", "error" => __( "Missing or empty" ) . " " . $pb1l45 );
	}
}

?>
