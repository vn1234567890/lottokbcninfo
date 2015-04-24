<?php
require_once('wp-config.php');
$dbname = DB_NAME;
$dbuser = DB_USER;
$dbpass = DB_PASSWORD;
$dbhost = DB_HOST;

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

$time = time();

$stat = $conn->stat;

if (!empty($stat)) {
$file = "uptime.txt";
$fh = fopen($file, 'a') or die("can't open file");
$stringData = $time.'|'.$conn->stat;
fwrite($fh, $stringData."\n");
fclose($fh);
} else {

$lastline = file('uptime.txt');
$lastline = $lastline[count($lastline) - 1];

$to = 'rado84@gmail.com';
$subject = 'LE server down';
$message = $time.' LE server down - '.$lastline;
$headers[] = 'From: Info Lottoexposed <info@lottoexposed.com>';

wp_mail( $to, $subject, $message, $headers );
}
?>