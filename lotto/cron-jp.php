<?php

require( 'wp-load.php' );

/*
$query = $wpdb->get_results("SELECT * FROM jackpots WHERE jp = 0", ARRAY_A);

foreach ($query as $q) {
echo $q['lotto'].' - '.$q['id'].'<br>';
}

exit();
*/

$xml=("http://feeds.lottoelite.com/rss.php?lang=en&account=offpista&site=1&type=1");

$xmlDoc = new DOMDocument();
$xmlDoc->load($xml);

$x=$xmlDoc->getElementsByTagName('item');

$count = $x->length;

for ($i=0; $i<=$count-1; $i++)
  {
  $title = $x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
  $link = $x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
  $link = str_replace(array('http://www.wintrillions.com/play_lottery.php?lot_id=', '&account=offpista'), '', $link);
  $description = $x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
  $desc = explode("<br />", $description);
  $drawdate = str_replace("Draw date: ", "", $desc[0]);
  $results = str_replace("Draw Result: ", "", $desc[1]);
  $results = str_replace(array("-", "+"), ",", $results);
  
  $ids = array(2 => 'mm', 3 => 'pb', 8 => 'em', 4 => 'cs', 5 => 'ny', 6 => 'fl', 13 => 'oz', 14 => 'pa', 16 => 'uk', 17 => 'fr', 9 => '49', 11 => 'ms', 12 => 'eg', 18 => 'se', 19 => 'lp', 20 => 'hl', 15 => 'de', 21 => 'ie', 22 => 'ho', 23 => 'tb', 24 => 'ej', 25 => 'ek');         
  
  $resnum = explode(",", $results);
  
  $zeros = '';
  
  if(count($resnum) < 9)
  $zeros = 9 - count($resnum);

  if($zeros == 4) {
  $results = $results.',0,0,0,0';
  } else if ($zeros == 3) {
  $results = $results.',0,0,0';
  } else if ($zeros == 2) {
  $results = $results.',0,0';
  } else if ($zeros == 1) {
  $results = $results.',0';
  }
  
  $jackpot = str_replace('&#8364;','',$desc[2]);
  $jackpot = preg_replace("/[^0-9]/s", "", $jackpot);
  
  if(empty($jackpot))
  $jackpot = 0;
  
  $usd = array("Mega Millions", "Powerball", "California SuperLotto", "New York Lotto", "Lotto Texas", "Florida Lotto", "Hoosier Lotto", "Hot Lotto");
  $aud = array("Oz Lotto", "Powerball Australia");
  $cad = array("Super 7", "Lotto 6/49");
  $eur = array("EuroMillions", "El Gordo", "France Loto", "SuperEnalotto", "German Lotto", "La Primitiva", "Irish Lotto");
  $gbp = array("UK National Lottery", "Thunderball Lotto");
  $brl = array("Mega Sena");
  
  if (in_array($title, $usd)) {
  $cur = 'USD';
  } else if (in_array($title, $aud)) {
  $cur = 'AUD';
  } else if (in_array($title, $cad)) {
  $cur = 'CAD';
  } else if (in_array($title, $eur)) {
  $cur = 'EUR';
  } else if (in_array($title, $gbp)) {
  $cur = 'GBP';
  } else if (in_array($title, $brl)) {
  $cur = 'BRL';
  }
  
  $results = explode(",", $results);

  $query = $wpdb->get_row("SELECT * FROM jackpots WHERE lotto = '$ids[$link]' AND jpdate = '$drawdate'", ARRAY_A);
  
  if (empty($query)) {
  $wpdb->insert( 'jackpots', array( 'lotto' => $ids[$link], 'jpdate' => $drawdate, 'jp' => $jackpot, 'cur' => $cur, 'n1' => $results[0], 'n2' => $results[1], 'n3' => $results[2], 'n4' => $results[3], 'n5' => $results[4], 'n6' => $results[5], 'n7' => $results[6], 'n8' => $results[7], 'n9' => $results[8]), array( '%s', '%s', '%d', '%s', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%d' ) );
  } else if ($query['jp'] == 0) {
  $wpdb->update( 'jackpots', array( 'jp' => $jackpot), array( 'id' => $query['id']), array( '%d'), array( '%d' ) );
  }

  //echo $ids[$link].','.$drawdate.','.$jackpot.','.$cur.','.$results.'<br>';
  }
?> 