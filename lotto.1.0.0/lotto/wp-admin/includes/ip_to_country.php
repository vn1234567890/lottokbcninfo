<?php

$hostname = 'localhost';
$username = 'lottoexp_1';
$password = 'offoff123';
$dbname   = 'lottoexp_1';
mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);

function get_country($ip)
{
    $iplong = ip_address_to_number($ip);
    $getthecountry = mysql_query ("SELECT * FROM `countriesip` WHERE '$iplong' BETWEEN `from` AND `to` ") ; 
    $countryis = mysql_fetch_array ($getthecountry); 
    $country2 = $countryis['code3'] ;
    return $country2; 
}

function ip_address_to_number($IPaddress)
{
    if ($IPaddress == "") {
        return 0;
    } 
    else {
        $ips = split ("\.", "$IPaddress");
        return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
    }
}
?>