<?
function unescape($matches) {
	$ch = chr(octdec(substr($matches[0],1,3)));
	if ($ch == '"') return '\\"';
	return $ch;
}
$v = file_get_contents('C:\VLZ\oDesk\Offpista\lotto\wp-content\plugins\pushbuttonseo\pbseo-mod-optimizer.php');


echo preg_replace_callback('|\\\\\d\d\d|mSu','unescape',$v);

?>