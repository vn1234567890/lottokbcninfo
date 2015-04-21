<?php

    function wplink_bulk_getArrayFromLineAndPipe($lineAndPipe) {
        $lineAndPipe = explode("\n", $lineAndPipe);
        $array = array();
        foreach($lineAndPipe as $line)
        {
            $line = explode("|", $line);
            if(trim($line[0]) != "")
            {
                $line[0] = trim($line[0]);
                
                $array[] = array($line[0], @$line[1]);
            }
        }
        return $array;
    }

    function wplink_bulk_processIPs($linkID, $array, $default, $remove=false, $overwrite=false) {
        global $wpdb;

        if(!intval($linkID)>0) return false;
        
        if($remove && count($array) > 1) {
            $wpdb->query("DELETE FROM `" . $wpdb->prefix . "wplink_restrictions` WHERE `link_id`='{$linkID}'");
        }
        foreach($array as $item)  {
            $url = "";
            if(isset($item[1]) && $item[1] != "")   {
                $url = $item[1];
            } else {
                $url = $default;
            }
            $ip = trim($item[0]);
            $url = trim($url);

            // let's not make any duplicates
            $id = $wpdb->get_var("SELECT `ID` FROM `".$wpdb->prefix."wplink_restrictions` WHERE `ip`='$ip' AND `link_id`='$linkID' LIMIT 1");
            $run = true;
            if(intval($id)>0)
            {
                $run = false;
                if( $overwrite == true )
                {
                    $wpdb->query("DELETE FROM `".$wpdb->prefix . "wplink_restrictions` WHERE `ip`='$ip' AND `link_id`='$linkID' LIMIT 1");
                    $run = true;
                }

            }
            /// duplicate mess sorted, $run is set if we should add now.
            
            if($run) {
                $wpdb->query("INSERT INTO `".$wpdb->prefix."wplink_restrictions` (link_id, ip, destination) VALUES('$linkID', '$ip', '$url') ");
            }
        }
        return true;

    }
?>
