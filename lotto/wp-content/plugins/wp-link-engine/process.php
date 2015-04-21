<?php

define("WPLINK_SUBDIR_PATTERN", '#^http://.*?(/.*)$#');
define("WPLINK_WITHIN_TAG",  '/<([a-z][a-z0-9]*)\s[^>]*(~keyword~)[^>]*>/is');
define("WPLINK_WITHIN_LINK", '/<a\s[^>]*>(.*?)<\/a>/is');
define("WPLINK_WITHIN_URL", '/<a\s+[^>]*href=["\']([^"\'][^> ]*)["\'][^>]*>/is');


function wplink_validate_wellformed($destination)
{
    if($destination{0} == "#") return $destination; // allow hash links

    $data = @parse_url($destination);
    if($data === false)
    {
        return get_option("siteurl");
    }

    if($data['scheme'] == "")
    {
        $destination = "http://" . $destination;
    }
    
    return $destination;
}
function wplink_get_country() {
        $wplink_geoPlugin = new GeoPlugin();
        $wplink_geoPlugin->locate($_SERVER["REMOTE_ADDR"]);
        return $wplink_geoPlugin->countryCode;
}
    
function wplink_rand($weights) {
    $r = mt_rand(1,1000);
    $offset = 0;
    foreach ($weights as $k => $w) {
        $offset += $w*1000;
        if ($r <= $offset) {
            return $k;
        }
    }
}
    
function wplink_meta_refresh($destination, $length) {
    echo "<meta http-equiv=\"refresh\" content=\"" . $length . "; URL=" . htmlentities($destination) . "\">";
}

function wplink_get_geo_destination($link_id) {
    global $wpdb;
    if(function_exists("wplink_get_country")) {
        $ccode = (strtoupper( preg_replace("/[^a-zA-Z\s]/", "", wplink_get_country())));
        $resultant = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wplink_geo_links` WHERE `countrycode` LIKE '{$ccode}' AND `link_id`='{$link_id}'");
        if($resultant != null) {
            return $resultant->destination;
        }
    }
    return false;
}

function wplink_format_ip($ip, $end=false) {
    $add = 0;
    if($end) {
        $add = 255;
    }
    
    $ip_octets = explode(".", $ip);
    $octets = count($ip_octets);

    for($i=0;$i<$octets;$i++) {
        if(strlen($ip_octets[$i]) == 0) {
            $ip_octets[$i] = $add;
        }
    }
    
    $ip = implode($ip_octets, ".");
    
    while($octets < 4) {
        $ip .= "." . $add;
        $octets++;
    }
    return $ip;
}

function wplink_check_ip_range($range, $addr) {
    $ip_start = ip2long(wplink_format_ip($range));
    $ip_end = ip2long(wplink_format_ip($range, true));

    if(stristr($range, "-")) {
        $ips = explode("-", $range);
        $ip_start = ip2long(wplink_format_ip($ips[0]));
        $ip_end = ip2long(wplink_format_ip($ips[1], true));
    }

    if(isset($ip_start) && isset($ip_end)) {
        if(($addr > $ip_start && $addr < $ip_end) || ($addr == $ip_start && $addr == $ip_end)) {
            // bad ip.  
            return true;
        }
    }
}

function wplink_check_banned($link_id) {
    global $wpdb;
    
    $referrer = $_SERVER['HTTP_REFERER'];
 
    $ip = ip2long($_SERVER['REMOTE_ADDR']);
    $ua = ($_SERVER['HTTP_USER_AGENT']);
    $result = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_restrictions` WHERE `link_id`='{$link_id}'");
    $hostname = null;
    foreach($result as $r) {  
            if($r->hostname != "" && $hostname === null) {
                $hostname = gethostbyname($ip);
            }
            
            if($r->arin != "") {
                $q_arin = new WPLEARIN($r->arin);
                $arin_ips = $q_arin->getIPs();
                foreach($arin_ips as $qip) {
                    if(wplink_check_ip_range($qip, $ip)) {
                        return trim($r->destination);
                    }
                }
            }
            
            if($r->ip != "") {

                if(wplink_check_ip_range($r->ip, $ip)) {
                    return trim($r->destination);
                }
            }
            
            if($r->hostname != "" && $hostname != "") {
                $hn_compare = "/^" . (str_replace("\*", "(.*)", wplink_escapeRegexCharacters($r->hostname))) . "$/i";

                if(preg_match($hn_compare, $hostname) == 1) {
                    // bad hostname
                    return trim($r->destination);
                }
            }
            
            if($r->referrer != "" && $referrer != "") {
                $rf_compare = "/^" . (str_replace("\*", "(.*)", wplink_escapeRegexCharacters($r->referrer))) . "$/i";
                if(preg_match($rf_compare, $referrer) == 1) {
                    // bad referrer
                    return trim($r->destination);
                }      
            }
    }
    
    $result = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_user_agent` WHERE `link_id`='{$link_id}'");
    foreach($result as $r) {  
            if($r->full != "" || $r->not != "") {
                $full = trim($r->full);
                $not = trim($r->not);
                
                $full_tested = false;
                if($full{0} == '"' && $full{strlen($full)-1} == '"') {
                    $full_tested = true;
                    if(strtolower($full) == strtolower($ua)) return trim($r->destination);
                }
                
                if($full{0} == '/' && $full{strlen($full)-1} == '/') {
                    $full_tested = true;
                    if(preg_match(($full."i"), $ua)) {
                        $full_matched = true;
                    }
                }
                
                if($full_tested == false) {
                    $full_tested = true;
                    if(stristr($ua, $full)) {
                        $full_matched = true;
                    }
                    
                }
                
                $not_matched = true;
                $not_tested = false;
                if($not{0} == '"' && $not{strlen($not)-1} == '"') {
                    $not_tested = true;
                    if(strtolower($not) == strtolower($ua)) $not_matched = false;
                }
                
                if($not{0} == '/' && $not{strlen($not)-1} == '/') {
                    $not_tested = true;
                    if(preg_match(($not."i"), $ua)) {
                        $not_matched = false;
                    }
                }
                
                if($not_tested == false) {
                    $not_tested = true;
                    if(@stristr($ua, $not) && $not != "") {
                        $not_matched = false;
                    }
                    
                }
                
                
                if($full_matched && $not_matched) {
                    // bad referrer
                    return trim($r->destination);
                }      
            }
    }
    return false;
}

function wplink_logic() {
    global $wpdb;
    $url = ((get_option('home'))?get_option('home'):get_option('siteurl'));
    if(!isset($_GET['wplink_query'])) {
        $query = $_SERVER['QUERY_STRING'];
    } else {
        $query = urldecode($_GET['wplink_query']);
    }
    
    $method = "http://";
    if(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == "on") $method = "https://";
    $request_uri = $method . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    
    $results = str_replace($url, "", $request_uri);
    $img= $_GET['img'];
$kw=$img ;
    // support for path_info urls.
    if(substr($results,0,strlen("/index.php")) == "/index.php") {
        $results = substr($results, strlen("/index.php"), strlen($results));
    }
    
    $results = explode("?", $results, 2);
    if(empty($query)) {
        $query = $results[1];
    }
    
    $results = $results[0]; 
    $results = ltrim($results, "/");
    $results = explode("/", $results, 2);

    if(count($results) > 0) {
        $slug = trim($results[0], "/");
        $param = trim($results[1], "/");

        $resultant = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wplink_links` WHERE `from`='$slug'");
        if($resultant->from == $slug && !empty($slug)) {            
            $_GET['wplink_redirect'] = $resultant->id;
            $_GET['wplink_count'] = 0;
        }
    }
            
    if(isset($_GET['wplink_redirect'])) {
        $redirect_id = intval($_GET['wplink_redirect']);
        $count = intval($_GET['wplink_count']) + 1;
        
        $next_url =  $url . "?wplink_redirect={$redirect_id}&wplink_count={$count}&wplink_query=" . urlencode($query);

        $resultant = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wplink_links` WHERE `id`='{$redirect_id}'");
        if($resultant != null) {
            $destination = "";
            
            if(isset($resultant->post_id)) {
                if($post_link = get_permalink($resultant->post_id) != false) {
                     if(substr($post_link, 0, 4) == "http") {
                        $destination = $post_link;
                     }
                }
            }
            
            if(trim($destination) == "" || !isset($destination)) {
                $destinations = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_destinations` WHERE `link_id`='{$resultant->id}'");
                if(isset($destinations)) {
                    $weights = array();
                    $ds = array();
                
                    foreach($destinations as $d) {
                        $weights[] = $d->weight/100;
                        $ds[] = $d->destination;
                    }
                    $destination = $ds[wplink_rand($weights)];
                }
            }

            if(trim($destination) == "" || !isset($destination)) {
                $destination = $ds[0];
            }
            
            if(trim($destination) == "" || !isset($destination)) {
                $destination = $url;    // default goes back to the blog homepage, I guess? make this configurable later.
            }
            
            
            if(($geo_destination = wplink_get_geo_destination($resultant->id)) !== false) {
                $destination = $geo_destination;
            }
            
            
            $cloaking_mode = $resultant->cloaked;
      
            
            // 300, because intval() on the PHP redirects will return 301 or 302
            if( intval($cloaking_mode) < 300 && $cloaking_mode != "" ) {
                // meta refresh
                $refresh_timer = intval($resultant->meta_timer);
                if(!isset($refresh_timer) || !is_integer($refresh_timer)) {
                    $refresh_timer = 0;
                }
             
            }
           
            if($cloaking_mode == "guaranteed") {
                $require_blank_fail = $resultant->require_blank_fail;
                if(!substr($require_blank_fail, 0, 4) == "http") $require_blank_fail = $url;
            }
            
            if(time() > $resultant->expired && $resultant->expired != 0) {
                if(!isset($resultant->expire_url) || strlen($resultant->expire_url) < 0) {
                    return; // exit out of function, URL has expired and we haven't been given a destination. treat like any other bad request.
                } else {
                    $destination = $resultant->expire_url;
                    $cloaking_mode = 301;
                }
            }
          
            if(($banned_destination = wplink_check_banned($resultant->id)) !== false) {
                if(!isset($banned_destination) || $banned_destination == "") {
                    return; // banned, no destination, just drop out to wordpress handling
                } else {
                    $destination = $banned_destination;
                    $cloaking_mode = 301;       
                }
            }
            
            
            if($count == 1) {
                /*$time = time();
                $ip = ip2long($_SERVER['REMOTE_ADDR']);
                $agent = $_SERVER['HTTP_USER_AGENT'];
                $kw = $_GET['img'];
		
                $wpdb->query("INSERT INTO `".$wpdb->prefix."wplink_clicks`
                        (`timestamp`,`link_id`,`destination`,
                        `referrer`, `agent`, `subid`,`query`, `ip_long`,`kw`)
                        VALUES('$time', '{$resultant->id}', '$destination',
                        '{$_SERVER['HTTP_REFERER']}', '$agent', '$param', '$query', '$ip','$kw')");
		*/
		if (!is_admin()) :
			//echo $resultant->link_title;exit;
			$lottery_id=$wpdb->get_var("SELECT id FROM {$wpdb->prefix}lotteries WHERE site_name='{$resultant->link_title}'");
			//echo $_SERVER['REQUEST_URI'].' - '.$lottery_id;exit;
			$cur_month=date('Y-m-01');
			
			$has_this_daily_record=$wpdb->get_row("SELECT clicks FROM {$wpdb->prefix}lotteries_clicks WHERE date='$cur_month' AND lottery_id=$lottery_id");
				
			$cur_day = date('j');
			
			if ($has_this_daily_record) {
				$clicks = unserialize($has_this_daily_record->clicks);
				$clicks[$cur_day] = $clicks[$cur_day] + 1;
				$clicks = serialize($clicks);
					
				$q="UPDATE {$wpdb->prefix}lotteries_clicks SET clicks='$clicks' WHERE lottery_id=$lottery_id AND date='$cur_month'";
				$wpdb->query($q);	
				
			} else {
				$days = date("t");
				$emptydata = array();
				for($i = 1; $i <= $days; $i++) {
				$emptydata[$i] = 0;
				}
				
				$emptydata[$cur_day] = 1;
				$clicks = serialize($emptydata);
				
				$q="INSERT INTO {$wpdb->prefix}lotteries_clicks (lottery_id,date,clicks) VALUES ($lottery_id, '$cur_month', '$clicks')";
				$wpdb->query($q);
			}
		endif;
            }
            if(strlen($query) > 0) {
                if($resultant->forwarding == 1) {
                    
                    parse_str($query, $rebuild);


                    $query = "";
                    foreach($rebuild as $key=>$value)
                    {
                        if(substr($key, 0, 6) != "wplink")
                        {
                            $query .= ($key . "=" . $value . "&");
                        }
                    }
                    $query = rtrim($query, "&");

                    if(stristr($destination, "?")) {
                        $query = ("&" . $query);
                    } else {
                        $query = ("?" . $query);
                    }

                    $destination .= $query;
                }
            }        

            $destination = wplink_validate_wellformed($destination);

            
            switch($cloaking_mode) {
                case "404":
                    header("Status: 404");
                break;
                
                case "":  case "301":
                    header("Status: 301"); //  Moved Permanently
                    header("Location: {$destination}");
                break;  
                
                case "302":
                    header("Status: 302");//  Found
                    header("Location: {$destination}");
                break;
                
                case "307":
                    header("Status: 307"); //  Moved Temporarily
                    header("Location: {$destination}");
                break;
                
                case "js":
                    include "redirects/js-redirect.php";
                break;
                
                case "js2":
                    if($count > 1) {
                        include "redirects/js-redirect.php";   
                    } else {
                        wplink_meta_refresh($next_url, $refresh_timer);
                    }
                break;
                
                case "frame":
                    include "redirects/frame-redirect.php";               
                break;
                
                case "custom":
                    if(file_exists("redirects/custom-redirect.php")) {
                        include "redirects/custom-redirect.php";
                    } else {
                        wplink_meta_refresh($destination, $refresh_timer);
                    }
                break;
                
                case "guaranteed":
                
                    $next = true;
                    if($_SERVER['HTTP_REFERER'] == "") {
                        $next = false;
                    }
                    
                    
                    if($count > 2) {
                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                        if(preg_match("/Safari/i", $user_agent)
                        || preg_match("/Opera/i", $user_agent)
                        || preg_match("/Chrome/i", $user_agent)) {
                            // unfortunately, none of these methods work for these
                            // two browsers; Safari and Opera. It'd be nice, but let's not even
                            // waste the user's time trying; let's just redirect them to the
                            // default fail URL after we test out the meta refresh once. (we
                            // test it once, because some of these browsers have settings
                            // to turn off referrer. which would mean it works)
                        
                            header("301 Found");
                            header("Location: {$require_blank_fail}");
                    
                        }
                    }
                    
                    
                    switch($count) {
                        case 1:
                            wplink_meta_refresh($next_url, 0);
                        break;
                        
                        case 2: 
                            if($next) {
                                wplink_meta_refresh($next_url, 2);
                            } else {
                                wplink_meta_refresh($destination, 0);
                            }
                        break;
                        
                        case 3: // try a js redirect... UNDER IT, put a meta redirect for browsers that can't obey it
                            if($next) {
                                $destination = $next_url;
                                include "redirects/js-redirect.php";
                                wplink_meta_refresh($next_url, 0);
                                die();      // die here cause we've changed destination... confusing otherwise.
                            } else {
                                wplink_meta_refresh($destination, 2);
                            }
                        break;
                        
                        case 4:
                            if($next) {
                                wplink_meta_refresh($next_url, 3);
                            } else {
                                include "redirects/js-redirect.php";
                            }
                        break; 
                        
                        case 5:
                            if($next) {
                                wplink_meta_refresh($next_url, 5);
                            } else {
                                wplink_meta_refresh($destination, 3);
                            }
                        break;    
                        
                        case 6:
                            if($next) {
                                wplink_meta_refresh($next_url, 7);
                            } else {
                                wplink_meta_refresh($destination, 5);
                            }
                        break;  
                        
                        case 7:
                            if($next) {
                                header("301 Found");
                                if($require_blank_fail == "" || !isset($require_blank_fail)) die("Sorry, this link is disabled (set an alternate destination in Extra Configuration to specify where this should go to).");
                                header("Location: {$require_blank_fail}");
                            } else {
                                wplink_meta_refresh($destination, 7);
                            }
                        break;
                    }
                break;
                
                default:    // meta
                    if($count >= $cloaking_mode) {
                        wplink_meta_refresh($destination, $refresh_timer);
                    } else {
                        wplink_meta_refresh($next_url, $refresh_timer);
                    }
                
            }            
        }
    die();
    }
}

   
function wplink_add_variables($link_id) {
    global $wpdb;
    $keyword = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wplink_keywords` WHERE `link_id`='$link_id' LIMIT 1");
    $link = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wplink_links` WHERE `id`='$link_id' LIMIT 1");
        
    
    $class = ""; $title = ""; $javascript=""; $target="";
    
    if(strlen($keyword->class) > 0) {
        $class = "class='{$keyword->class}'";
    }
    
    if(strlen($keyword->title) > 0) {
        $title = "title='{$keyword->title}'";
    }


    if($link->target != "") {
        $target .= " target=\"{$link->target}\"";
    }

    $javascript = wplink_get_javascript($link_id);
    
    $color = "";
    if($keyword->color != "") {
        $color = "color: {$keyword->color};";
    }
    $size = "";
    if($keyword->size != "") {
        $size = "font-size: {$keyword->size};";
    }
    $family = "";
    if($keyword->family != "") {
        $family = "font-family: {$keyword->family};";
    }
    $style = $color . $size . $family;
    $style .= $keyword->extra;

    if(!empty($style)) {
        $style = (" style='" . str_replace("'", "\'", $style) . "' ");
    }

    if($link->nofollow == 1) {
        $follow = " rel='nofollow, wpls' ";
    } else {
        $follow = " rel='wpls' ";
    }
    
    return array($class, $title, $javascript, $style, $follow, $target);
    
}

function wplink_get_javascript($link_id) {
    global $wpdb;
    
    $link = $wpdb->get_row("SELECT * FROM `".$wpdb->prefix."wplink_links` WHERE `id`='{$link_id}'");
    $onMouseOver = "";
    $onMouseOut = "";
    $onClick = "";
    
    if(strlen($link->status_bar) > 0) {
        $onMouseOver .= "self.status='" . str_replace("'", "\'", $link->status_bar) ."';";
        $onMouseOut .= "self.status='';";
    }

    $destinations = trim($link->destinations);
    $destinations = explode("\n", $destinations);
    if(count($destinations) > 0) {
        foreach($destinations as $d) {

            $d = trim($d);
            if((substr($d, 0, 4) == "http")) {
                $onClick .= "window.open('{$d}', '{$d}',  'scrollbars=yes,location=yes,menubar=yes,status=yes,resizable=yes,titlebar=yes,toolbar=yes');";
            }
        }
    }
    $javascript = "";
    
    if($onMouseOver != "") {
        $javascript .= " onMouseOver=\"{$onMouseOver}\"";
    }
    
    if($onMouseOut != "") {
        $javascript .= " onMouseOut=\"{$onMouseOut}\"";
    }

    if($onClick != "") {
        $javascript .= " onClick=\"{$onClick}\"";
    }

    
    return $javascript;
}

?>
