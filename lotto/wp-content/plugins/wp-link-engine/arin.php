<?php

if(!class_exists("WPLEARIN")) {
    class WPLEARIN {
    var $port = 43;  
    var $errno;
    var $errstr;
    var $timeout = 10;
    var $domain;
    var $data;
    
    function WPLEARIN($domain){
        
        $this->domain = $domain;
        
        
        if(strlen($this->domain)>0){
            $this->whoisserver = "whois.arin.net";
            
            if($result = $this->queryServer()) {    // intentional
                preg_match("/Whois Server: (.*)/", $result, $matches);
                $this->data = $result;
            }
            else {
                $this->data = "Error: No results retrieved from $whoisserver server for {$this->domain} domain!";
            }
        }
    }
    
     function queryServer(){
        global $wpdb;
        $time = time() + WPLINK_QUERY_CACHE;
        $results = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_arin_cache` WHERE `query`='{$this->domain}' AND `timestamp`<$time");
        if(isset($results->data)) {
            return $results->data;
        } else {          
            $out = "";
            $fp = @fsockopen($this->whoisserver, $this->port, $this->errno, $this->errstr, $this->timeout);
            fputs($fp, $this->domain . "\r\n");
            while(!feof($fp)) $out .= fgets($fp);
            fclose($fp);
            if(strlen($out)>0) {
                $dbout = mysql_real_escape_string($out);
                $wpdb->query("INSERT INTO `".$wpdb->prefix."wplink_arin_cache` VALUES('', '{$this->domain}', NOW(), '$dbout')");
                return $out;
            } else {
                return false;
            }
        }
     }
      
      function getIPs() {
        $return = array();
        $newlines = explode("\n", $this->data);
        foreach($newlines as $newline) {
            if(preg_match_all("/([0-9A-Fa-f]{1,4}:){7}[0-9A-Fa-f]{1,4}|(\d{1,3}\.){3}\d{1,3}/", $newline, $matches)) {
                $return[] = ($matches[0][0] . "-" . $matches[0][1]);   
            }
        }
        return $return;
      }
      
    }
}


?>
