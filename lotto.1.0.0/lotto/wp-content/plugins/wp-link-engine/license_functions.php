<?php
    if(!defined("WPLINK_PID")) {
        define("WPLINK_PID", "409666");
        
        define("WPLINK_NO_CONNECTIVITY", 1);
        define("WPLINK_EXPIRED", 2);
        define("WPLINK_MACHINE", 4);
        define("WPLINK_COUNT", 8);
        define("WPLINK_NO_KEY", 16);
        
        function WPLINKlicensing_validate_license() {
                return true;
        }
        
        function WPLINKlicensing_process_plimus_response($key) {
	        return true;        
        }
    }