<?php
/**
 * GOTMLS Brute-Force protections
 * @package GOTMLS
*/

if (!(isset($_SESSION["GOTMLS_detected_attacks"]) && $_SESSION["GOTMLS_detected_attacks"])) {
	$file = (isset($_SERVER["SCRIPT_FILENAME"])?$_SERVER["SCRIPT_FILENAME"]:__FILE__);
	$_SESSION["GOTMLS_detected_attacks"] = '&attack[]='.strtolower((isset($_SERVER["DOCUMENT_ROOT"]) && strlen($_SERVER["DOCUMENT_ROOT"]) < strlen($file))?substr($file, strlen($_SERVER["DOCUMENT_ROOT"])):basename($file));
}
foreach (array("REMOTE_ADDR", "HTTP_HOST", "REQUEST_URI", "HTTP_REFERER", "HTTP_USER_AGENT") as $var)
	$_SESSION["GOTMLS_detected_attacks"] .= (isset($_SERVER[$var])?"&SERVER_$var=".urlencode($_SERVER[$var]):"");
foreach (array("log") as $var)
	$_SESSION["GOTMLS_detected_attacks"] .= (isset($_POST[$var])?"&POST_$var=".urlencode($_POST[$var]):"");
header("location: http://safe-load.gotmls.net/report.php?ver=4.14.59".$_SESSION["GOTMLS_detected_attacks"]);
die();