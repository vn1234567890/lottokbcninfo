<?php
function wplink_links($content) {
    global $wpdb;
    global $wp_query;
    
    $url = ((get_option('home'))?get_option('home'):get_option('siteurl'));
    $url = rtrim($url, "/") . "/";

    if(get_post_meta($wp_query->post->ID, "_wplink_disable_links", true) == 1) return $content;

    preg_match_all(WPLINK_WITHIN_URL, $content, $links, PREG_PATTERN_ORDER);
    $db_links = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_links`");
    for($i=0;$i<count($links[1]);$i++) {
        foreach($db_links as $l) {
                           
            $array = wplink_add_variables($l->id);
            $class = $array[0];
            $title = $array[1];
            $javascript = $array[2];
            $style = $array[3];
            $follow = $array[4];
            $target = $array[5];

            if($l->replace_destinations & WPLINK_PRIMARY) {
                $destinations = $wpdb->get_results("SELECT `destination` FROM `".$wpdb->prefix."wplink_destinations` WHERE `link_id`='{$l->id}'");
                foreach($destinations as $d) {
                    if($d->destination == $links[1][$i] || substr($links[1][$i], 0, strlen($d->destination))==$d->destination) {
                        $replacement = str_replace(
                                            substr($links[1][$i],0,strlen($d->destination)), 
                                            ($url.$l->from), 
                                            $links[0][$i]
                                        );  
                        $replacement = str_replace("<a", "<a {$class}{$title}{$javascript}{$style}{$follow}{$target}", $replacement);
                        $query_string = "";
                        foreach(explode(",",$l->vars) as $var) {
                            if(isset($_GET[$var])) {
                                $query_string .= ($var . "=" . $_GET[$var] . "&");
                            }
                        }
                        $query_string = rtrim($query_string, "&");
                        if(strlen($query_string) > 0) {
                            if(stristr($link, "?")) {
                                $replacement = str_replace($link, $link . "&".$query_string, $replacement);
                            } else {
                                $replacement = str_replace($link, $link. "?".$query_string, $replacement);         
                            }
                        }
                        
                        $content = str_replace($links[0][$i], $replacement, $content);
                    }
                }
            }
            
            if($l->replace_destinations & WPLINK_MULTIPLE) {
                $destinations = explode("\n", $l->destinations);
                foreach($destinations as $d) {
                    if($d->destination == $links[1][$i] || substr($links[1][$i], 0, strlen($d->destination))==$d->destination) {
                        $replacement = str_replace(
                                            substr($links[1][$i],0,strlen($d->destination)), 
                                            ($url.$l->from), 
                                            $links[0][$i]
                                        );  
                        $replacement = str_replace("<a", "<a {$class}{$title}{$javascript}{$style}{$follow}{$target}", $replacement);
                        $query_string = "";
                        foreach(explode(",",$l->vars) as $var) {
                            if(isset($_GET[$var])) {
                                $query_string .= ($var . "=" . $_GET[$var] . "&");
                            }
                        }
                        $query_string = rtrim($query_string, "&");
                        if(strlen($query_string) > 0) {
                            if(stristr($link, "?")) {
                                $replacement = str_replace($link, $link . "&".$query_string, $replacement);
                            } else {
                                $replacement = str_replace($link, $link. "?".$query_string, $replacement);         
                            }
                        }
                        
                        $content = str_replace($links[0][$i], $replacement, $content);
                    }
                }
            }
            
            if($l->replace_destinations & WPLINK_BANNED) {
                $destinations = $wpdb->get_results("SELECT `destination` FROM `".$wpdb->prefix."wplink_restrictions` WHERE `link_id`='{$l->id}'");
                foreach($destinations as $d) {
                    if($d->destination == $links[1][$i] || substr($links[1][$i], 0, strlen($d->destination))==$d->destination) {
                        $replacement = str_replace(
                                            substr($links[1][$i],0,strlen($d->destination)), 
                                            ($url.$l->from), 
                                            $links[0][$i]
                                        );  
                        $replacement = str_replace("<a", "<a {$class}{$title}{$javascript}{$style}{$follow}{$target}", $replacement);
                        $query_string = "";
                        foreach(explode(",",$l->vars) as $var) {
                            if(isset($_GET[$var])) {
                                $query_string .= ($var . "=" . $_GET[$var] . "&");
                            }
                        }
                        $query_string = rtrim($query_string, "&");
                        if(strlen($query_string) > 0) {
                            if(stristr($link, "?")) {
                                $replacement = str_replace($link, $link . "&".$query_string, $replacement);
                            } else {
                                $replacement = str_replace($link, $link. "?".$query_string, $replacement);         
                            }
                        }
                        
                        $content = str_replace($links[0][$i], $replacement, $content);
                    }
                }
            }
            
            if($l->replace_destinations & WPLINK_REQUIRE_FAIL) {
                $destination = ($l->require_blank_fail);
                if($destination == $links[1][$i] || substr($links[1][$i], 0, strlen($destination))==$destination) {
                        $replacement = str_replace(
                                            substr($links[1][$i],0,strlen($d->destination)), 
                                            ($url.$l->from), 
                                            $links[0][$i]
                                        );  
                        $replacement = str_replace("<a", "<a {$class}{$title}{$javascript}{$style}{$follow}{$target}", $replacement);
                        $query_string = "";
                        foreach(explode(",",$l->vars) as $var) {
                            if(isset($_GET[$var])) {
                                $query_string .= ($var . "=" . $_GET[$var] . "&");
                            }
                        }
                        $query_string = rtrim($query_string, "&");
                        if(strlen($query_string) > 0) {
                            if(stristr($link, "?")) {
                                $replacement = str_replace($link, $link . "&".$query_string, $replacement);
                            } else {
                                $replacement = str_replace($link, $link. "?".$query_string, $replacement);         
                            }
                        }
                        
                        $content = str_replace($links[0][$i], $replacement, $content);
                }
            }
            
            if($l->replace_destinations & WPLINK_GEOS) {
                $destinations = $wpdb->get_results("SELECT `destination` FROM `".$wpdb->prefix."wplink_geo_links` WHERE `link_id`='{$l->id}'");
                foreach($destinations as $d) {
                    if($d->destination == $links[1][$i] || substr($links[1][$i], 0, strlen($d->destination))==$d->destination) {
                        $replacement = str_replace(
                                            substr($links[1][$i],0,strlen($d->destination)), 
                                            ($url.$l->from), 
                                            $links[0][$i]
                                        );  
                        $replacement = str_replace("<a", "<a {$class}{$title}{$javascript}{$style}{$follow}{$target}", $replacement);
                        $query_string = "";
                        foreach(explode(",",$l->vars) as $var) {
                            if(isset($_GET[$var])) {
                                $query_string .= ($var . "=" . $_GET[$var] . "&");
                            }
                        }
                        $query_string = rtrim($query_string, "&");
                        if(strlen($query_string) > 0) {
                            if(stristr($link, "?")) {
                                $replacement = str_replace($link, $link . "&".$query_string, $replacement);
                            } else {
                                $replacement = str_replace($link, $link. "?".$query_string, $replacement);         
                            }
                        }
                        
                        $content = str_replace($links[0][$i], $replacement, $content);
                    }
                }
            }
            
             if($l->replace_destinations & WPLINK_SLUG) {
                $url = ((get_option('home'))?get_option('home'):get_option('siteurl'));
                $url = rtrim($url, "/") . "/";
                
                    $link = $url . $l->from;
                    if($link == $links[1][$i] || substr($links[1][$i], 0, strlen($link))==$link) {
///                        $replacement = str_replace(
   ///                                         substr($links[1][$i],0,strlen($link)), 
      ///                                      ($link), 
         //                                   $links[0][$i]
           //                             );  
                        $replacement = $links[0][$i];
                        $replacement = str_replace("<a", "<a {$class}{$title}{$javascript}{$style}{$follow}{$target}", $replacement);
                        $query_string = "";
                        foreach(explode(",",$l->vars) as $var) {
                            if(isset($_GET[$var])) {
                                $query_string .= ($var . "=" . $_GET[$var] . "&");
                            }
                        }
                        $query_string = rtrim($query_string, "&");
                        if(strlen($query_string) > 0) {
                            if(stristr($link, "?")) {
                                $replacement = str_replace($link, $link . "&".$query_string, $replacement);
                            } else {
                                $replacement = str_replace($link, $link. "?".$query_string, $replacement);         
                            }
                        }
                        
                        $content = str_replace($links[0][$i], $replacement, $content);
                    }
                
            }
        }
    }
    
    
    
    return $content;
}

function wplink_keywords($content) {
    global $wpdb;
    global $wp_query;
    
    if(get_post_meta($wp_query->post->ID, "_wplink_disable_keywords", true) == 1) return $content;
    
    $to_replace = array();
    
    $count = 1;
    $keywords = $wpdb->get_results("SELECT *, `link`.`id` as lid, `link`.`nofollow` as lnofollow FROM `".$wpdb->prefix."wplink_keywords` as `kwd`,`".$wpdb->prefix ."wplink_links` as `link` WHERE `kwd`.`link_id`=`link`.`id`");
    

    preg_match_all(WPLINK_WITHIN_LINK, $content, $within_link, PREG_PATTERN_ORDER);
    if(count($within_link) > 0) {
        for($i=0;$i<count($within_link[0]);$i++) {
            $count++;
            $replacing_with = (microtime() . "-" . $count . "-WPLINK_REPLACE");
            $content = str_replace($within_link[0][$i], $replacing_with, $content);
            $to_replace[$replacing_with] = $within_link[0][$i];
        }
	}
	
	
	if(count($keywords) > 0) {
        foreach($keywords as $keyword) {
            $keyword->keyword = trim($keyword->keyword);
            if(!empty($keyword->keyword) && strlen($keyword->keyword) > 2) {
                $count++;

                $escaped = wplink_escapeRegexCharacters($keyword->keyword);
                preg_match_all(str_replace("~keyword~", $escaped, WPLINK_WITHIN_TAG), $content, $within_tag, PREG_PATTERN_ORDER);
                foreach($within_tag[0] as $within) {
                    $count++;
                    $replacing_with = (microtime() . "-" . $count . "-WPLINK_REPLACE");
                    $content = str_replace($within, $replacing_with, $content);
                    $to_replace[$replacing_with] = $within;
                }
        
                $url = ((get_option('home'))?get_option('home'):get_option('siteurl'));
                $url = rtrim($url, "/") . "/";

                // this could determine how to title it and stuff i guess.
            
                $array = wplink_add_variables($keyword->lid);

                $class = $array[0];
                $title = $array[1];
                $javascript = $array[2];
                $style=$array[3];
                $follow = $array[4];
                $target = $array[5];
            
                if($keyword->max > 0) {
                    $max = $keyword->max;
                } else {
                    $max = -1;
                }
            
                $escaped = wplink_escapeRegexCharacters($keyword->keyword);
                if(!empty($escaped)) {
			$modifier = 'i';
			if($keyword->case == 0) { 
				$modifier = '';
			}
			if($keyword->whole == 1) {
				$escaped = "\\b{$escaped}\\b";
			}
			if($keyword->h1 == 1) {
//				$extra = "<h(\d)>(.*?)</h\1>|";
			}
                    $content = preg_replace("/([^<(class=')(class=\")(id=')(id=\")(style=')(style=\")(title=')(title=\")])(".$escaped.")([^>])/{$modifier}",  "\${1}<a href='{$url}{$keyword->from}' {$class}{$title}{$follow}{$style}{$target}{$javascript}>{$keyword->keyword}</a>\${3}", $content, $max);
                }
            }
        }
    }
    foreach($to_replace as $code => $value) {
        $content = str_replace($code, $value, $content);
    }
                
return $content;
}

function wplink_escapeRegexCharacters($string) {
		$string = str_replace("\\", "\\\\", $string);
		$string = str_replace("(", "\(", $string);
		$string = str_replace(")", "\)", $string);
		$string = str_replace("^", "\^", $string);
		$string = str_replace("$", "\$", $string);
		$string = str_replace(".", "\.", $string);
		$string = str_replace("?", "\?", $string);
		$string = str_replace("*", "\*", $string);
		$string = str_replace("+", "\+", $string);
		$string = str_replace("|", "\|", $string);
		$string = str_replace("[", "\[", $string);
		$string = str_replace("/", "\/", $string);
		
		return $string;
}
?>
