<?php 

require( 'wp-load.php' );

$lot = $_GET['lotto'];

if ($lot == 'mm') {
$total_lotto_numbers = 56;
$total_stars_numbers = 46;
$picks = 5;
$stars = 1;
} else if ($lot == 'pb') {
$total_lotto_numbers = 59;
$total_stars_numbers = 35;
$picks = 5;
$stars = 1;
} else if ($lot == 'em') {
$total_lotto_numbers = 50;
$total_stars_numbers = 11;
$picks = 5;
$stars = 2;
} else if ($lot == 'pa') {
$total_lotto_numbers = 45;
$total_stars_numbers = 45;
$picks = 5;
$stars = 1;
} else if ($lot == 'hl') {
$total_lotto_numbers = 39;
$total_stars_numbers = 19;
$picks = 5;
$stars = 1;
} else if ($lot == 'eg') {
$total_lotto_numbers = 54;
$total_stars_numbers = 10;
$picks = 5;
$stars = 1;
} else if ($lot == 'fr') {
$total_lotto_numbers = 49;
$total_stars_numbers = 10;
$picks = 5;
$stars = 1;
} else if ($lot == 'uk') {
$total_lotto_numbers = 49;
$total_stars_numbers = 0;
$picks = 6;
$stars = 0;
} else if ($lot == 'cs') {
$total_lotto_numbers = 47;
$total_stars_numbers = 27;
$picks = 5;
$stars = 1;
} else if ($lot == 'oz') {
$total_lotto_numbers = 45;
$total_stars_numbers = 0;
$picks = 7;
$stars = 0;
} else if ($lot == '49') {
$total_lotto_numbers = 49;
$total_stars_numbers = 0;
$picks = 6;
$stars = 0;
} else if ($lot == 'ho') {
$total_lotto_numbers = 48;
$total_stars_numbers = 0;
$picks = 6;
$stars = 0;
} else if ($lot == 'ny') {
$total_lotto_numbers = 59;
$total_stars_numbers = 0;
$picks = 6;
$stars = 0;
} else if ($lot == 'fl') {
$total_lotto_numbers = 53;
$total_stars_numbers = 0;
$picks = 6;
$stars = 0;
} else if ($lot == 'ms') {
$total_lotto_numbers = 60;
$total_stars_numbers = 0;
$picks = 6;
$stars = 0;
} else if ($lot == 'ie') {
$total_lotto_numbers = 45;
$total_stars_numbers = 1;
$picks = 7;
$stars = 45;
} else if ($lot == 'tb') {
$total_lotto_numbers = 39;
$total_stars_numbers = 14;
$picks = 5;
$stars = 1;
} else if ($lot == 'se') {
$total_lotto_numbers = 90;
$total_stars_numbers = 0;
$picks = 6;
$stars = 0;
} else if ($lot == 'de') {
$total_lotto_numbers = 49;
$total_stars_numbers = 0;
$picks = 6;
$stars = 0;
} else if ($lot == 'lp') {
$total_lotto_numbers = 49;
$total_stars_numbers = 0;
$picks = 6;
$stars = 0;
}

if (isset($_GET) && $_GET['view'] == 'hotcold') {

	if($_GET['from'] != '' && $_GET['to'] != '') {
	$from = (int)$_GET['from'];
	$to = (int)$_GET['to'];	
	$limit = 'LIMIT '.$from.', '.$to;
	} else {
	$limit = '';
	}
	
	if($_GET['chooselotto'] == 'yes')
	$chooselotto = true;
	
$results = $wpdb->get_results("SELECT jpdate, n1, n2, n3, n4, n5, n6, n7, n8, n9 FROM `jackpots` WHERE `lotto` = '$lot' $limit", ARRAY_A);

$draws = count($results);

$numbers = array();
$stars_numbers = array();


foreach ($results as $draw) {
	
	$totalnrs = $picks + $stars;
	
	for ($p = 1; $p <= $picks; $p++) {
	if (!empty($draw['n'.$p]))
	array_push($numbers, $draw['n'.$p]);
	}
	
	for ($s = $picks + 1; $s <= $totalnrs; $s++) {
		if ($lot == 'eg' && empty($draw['n6'])) { // El Gordo contains 0 as stars number at n6 position
		array_push($stars_numbers, $draw['n6']);
		} else {
		if (!empty($draw['n'.$s]))
		array_push($stars_numbers, $draw['n'.$s]);
		}
	}
	
}
	
$draw_count_number = array_count_values($numbers); // Array [drawed_number]=> int(drawed_times)
$draw_count_stars = array_count_values($stars_numbers); // Array [drawed_star_number]=> int(drawed_times)

$hotcold = $draw_count_number;
ksort($draw_count_number);

$hotcold_stars = $draw_count_stars;
ksort($draw_count_stars);

arsort($hotcold); // Sort hottest numbers in reverse order
$hot = $hotcold;

asort($hotcold); // Sort coldest numbers in reverse order
$cold = $hotcold;

$hotarray = array();
$coldarray = array();

$hotcounter = 0;
$coldcounter = 0;

	// Creating numbers array
	foreach($hot as $key => $value) {
	array_push($hotarray, $key);
	$hotcounter++;
	if($hotcounter==$picks)
	break;
	}
	
	foreach($cold as $key => $value) {
	array_push($coldarray, $key);
	$coldcounter++;
	if($coldcounter==$picks)
	break;
	}
	
sort($hotarray);
sort($coldarray);

$hot_html = '';

foreach($hotarray as $key => $value) {
$hot_html .= '<div class="hotnumber">'.$value.'</div>';
}

$cold_html = '';

foreach($coldarray as $key => $value) {
$cold_html .= '<div class="coldnumber">'.$value.'</div>';
}

$drawed_stars_times = 0;

foreach ($draw_count_stars as $key => $value) {
$drawed_stars_times = $drawed_stars_times + $value;
}

if ($total_stars_numbers != 0) 
$average_stars_draw = floor($drawed_stars_times / $total_stars_numbers);

$stars_html = '<span style="float: left; font-family: arial; font-size: 14px; font-style: italic;">Extra numbers:</span><br />';

$tooltipcount = 1;

foreach ($draw_count_stars as $key => $value) {
	
	if ($value > $average_stars_draw) {
	$stars_html .= '<div class="hotstar" title="Drawn number: '.$key.', Drawn '.$value.' times">'.$key.'</div>';
	} else {
	$stars_html .= '<div class="coldstar" title="Drawn number: '.$key.', Drawn '.$value.' times">'.$key.'</div>';
	}
	
	$tooltipcount++;
}

if ($total_stars_numbers == 0 || $lot == 'ie')
$stars_html = '<div style="position: relative; top: 25px; color: red; font-family: arial; font-size: 22px; font-style: italic; text-align: center;">This lotto do not have additional extra numbers!</div><br />';


$drawed_times = 0;

foreach ($draw_count_number as $key => $value) {
$drawed_times = $drawed_times + $value;
}

$average_draw = floor($drawed_times / $total_lotto_numbers);

$addRows = count($draw_count_number);

$data = "var data = new google.visualization.DataTable();";

$data .= "data.addColumn('number', 'Drawed times');
        data.addColumn('number', 'Cold number');
        data.addColumn('number', 'Hot number');
		//data.addColumn({'type': 'string', 'role': 'tooltip', 'p': {'html': true}});
		data.addRows(".$addRows.");";

$cell = 0;

foreach ($draw_count_number as $key => $value) {

	if ($value > $average_draw) {
	$columnIndex = 2; // Cold number
	} else {
	$columnIndex = 1; // Hot number
	}
	
	$data .= "data.setCell(".$cell.", 0, ".$key.", 'Drawn number: ".$key."');
	data.setCell(".$cell.", ".$columnIndex.", ".$value.", 'Drawn ".$value." times');";
	
	$cell++;
}

$data .= "new google.visualization.ColumnChart(document.getElementById('hotcoldgraph')).
          draw(data,{'allowHtml': true, 'chartArea': {width: '90%', height: '85%'}, 'isStacked': true, 'legend': {position: 'top'}, 'vAxis': {'title': 'Drawed Times'}, 'hAxis': {'title': 'Lotto Numbers', 'viewWindowMode': 'explicit', viewWindow: { min: 1, max: ".$total_lotto_numbers." }, gridlines: { count: ".$total_lotto_numbers." }, textStyle: {fontSize: 6} }, 'vAxis': {format:'##', textStyle: { } } });

		  var lotto = '".$lot."';";
		  
	if($chooselotto) {

	$data .= "$('#slider').rangeSlider('destroy');
		  
		  $('#slider').rangeSlider({bounds:{min: 1, max: ".$draws."}, defaultValues:{min: 1, max: ".$draws."},formatter:function(val){var value = Math.round(val); return 'Draw No: ' + value.toString();}});";
			
	} else {
	
	//$data .= "$('#slider').rangeSlider({bounds:{min: 1, max: ".$draws."}, defaultValues:{min: ".($draws-10).", max: ".$draws."}, valueLabels:'change', delayOut: 4000, formatter:function(val){var value = Math.round(val); return 'Draw No: ' + value.toString();}});";
	
	}
	
	$data .= "$('#hotnumbers').html('".$hot_html."');$('#coldnumbers').html('".$cold_html."');$('#starsnumbers').html('".$stars_html."');$('.hotstar').tooltipsy({ css: {'padding': '10px', 'max-width': '250px', 'color': '#303030', 'background-color': '#FFCCAA', 'border': '1px solid #FF3334', '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)', '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)', 'box-shadow': '0 0 10px rgba(0, 0, 0, .5)', 'text-shadow': 'none' } }); $('.coldstar').tooltipsy({ css: {'padding': '10px', 'max-width': '250px', 'color': '#303030', 'background-color': '#9FDAEE', 'border': '1px solid #2BB0D7', '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)', '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)', 'box-shadow': '0 0 10px rgba(0, 0, 0, .5)', 'text-shadow': 'none' } });";

echo $data;

exit();
}

$usd = array("mm", "pb", "cs", "ny", "lt", "fl", "ho", "hl");
$aud = array("oz", "pa");
$cad = array("s7", "49");
$eur = array("em", "eg", "fr", "se", "de", "lp", "ie");
$gbp = array("uk", "tb");
$brl = array("ms");

if (in_array($lot, $usd)) {
$cur = '$';
$rate = 1;
} else if (in_array($lot, $aud)) {
$cur = 'AUD';
$rate = 1.0086;
} else if (in_array($lot, $cad)) {
$cur = 'CAD';
$rate = 0.977326;
} else if (in_array($lot, $eur)) {
$cur = 'EUR';
$rate = 1.2637;
} else if (in_array($lot, $gbp)) {
$cur = 'GBP';
$rate = 1.5678;
} else if (in_array($lot, $brl)) {
$cur = 'BRL';
$rate = 0.49;
} else {
$cur = '$';
$rate = 1;
}

if (strlen($lot) <= 2) {
	$numlottos = 1;
	$columns = '1';
	
	if ($lot == 'mm') { $singlelotto = 'Mega Millions'; }
	else if ($lot == 'pb') { $singlelotto = 'PowerBall'; }
	else if ($lot == 'em') { $singlelotto = 'Euro Millions'; }
	else if ($lot == 'pa') { $singlelotto = 'PowerBall Australia'; }
	else if ($lot == 'hl') { $singlelotto = 'Hot Lotto'; }
	else if ($lot == 'eg') { $singlelotto = 'El Gordo'; }
	else if ($lot == 'fr') { $singlelotto = 'France Lotto'; }
	else if ($lot == 'uk') { $singlelotto = 'UK National Lottery'; }
	else if ($lot == 'cs') { $singlelotto = 'California SuperLotto'; }
	else if ($lot == 'oz') { $singlelotto = 'Oz Lotto'; }
	else if ($lot == '49') { $singlelotto = 'Lotto 6/49'; }
	else if ($lot == 'ho') { $singlelotto = 'Hoosier Lotto'; }
	else if ($lot == 'ny') { $singlelotto = 'New York Lotto'; }
	else if ($lot == 'fl') { $singlelotto = 'Florida Lotto'; }
	else if ($lot == 'ms') { $singlelotto = 'Mega Sena'; }
	else if ($lot == 'ie') { $singlelotto = 'Irish Lotto'; }
	else if ($lot == 'tb') { $singlelotto = 'Thunderball'; }
	else if ($lot == 'se') { $singlelotto = 'Superena Lotto'; }
	else if ($lot == 'de') { $singlelotto = 'German Lotto'; }
	else if ($lot == 'lp') { $singlelotto = 'La Primitiva'; }
	
	$results = $wpdb->get_results("SELECT * FROM `jackpots` WHERE `lotto` = '$lot'", ARRAY_A);

	$constant = array('mm' => 19047453.135654, 'pb' => 19047453.135654, 'em' => 14719940.287338, 'pa' => 1816190.887524, 'hl' => 491621.849854, 'eg' => 3573468.007424, 'fr' => 1552346.957704, 'uk' => 1531460.024304, 'cs' => 4537308.032264, 'oz' => 2785281.474584, '49' => 2444112.397234, 'ho' => 3143180.052374, 'ny' => 2938736.229644, 'fl' => 3488341.546134, 'ms' => 1906064.389734, 'ie' => 754314.388134, 'tb' => -477239.548045999, 'se' => 29198068.067464, 'de' => 1268969.781834, 'lp' => 833787.932324001);
	$seqdata = array('mm' => 38848.691105, 'pb' => 37154.175607, 'em' => 34190.707448, 'pa' => 31212.426052, 'hl' => 30134.366034, 'eg' => 32384.686155, 'fr' => 33101.729769, 'uk' => 33692.470331, 'cs' => 31787.829798, 'oz' => 30720.350099, '49' => 32677.594713, 'ho' => 32047.008952, 'ny' => 31622.666816, 'fl' => 34229.587841, 'ms' => 34909.764058, 'ie' => 31055.137589, 'tb' => 31106.950205, 'se' => 14336.974057, 'de' => 31147.248333, 'lp' => 31509.770994);
	
	$seq2data = -216.414871;
	$seq3data = 0.335585;
	$lag1data = 0.681567;
	$lag2data = 0.017282;
	$seq = count($results) + 1;
	$seq2 = $seq * $seq;
	$seq3 = $seq2 * $seq;
	$lag1n = $seq - 2;
	$lag2n = $seq - 3;
	$lag1 = $results[$lag1n]['jp'] * $rate;
	$lag2 = $results[$lag2n]['jp'] * $rate;
	$predictjp = $constant[$lot] + $seq * $seqdata[$lot] + $seq2 * $seq2data + $seq3 * $seq3data + $lag1 * $lag1data + $lag2 * $lag2data;  
	$predictjp = round($predictjp / $rate);
	$jplength = strlen($predictjp) - 3;
	$predictjpf = $cur.' '.number_format(round($predictjp, -$jplength));
	$predictjpend = round($predictjp, -$jplength);
	$predictjpstart = $predictjpend - 1000;
	
	$showpredictedjp = "$('#jp').flipCounter({number:".$predictjpstart."}); $('#jp').flipCounter('startAnimation', {end_number:".$predictjpend.", easing:jQuery.easing.easeInOutCubic, duration:300}); $('#jpwrap').css('display','block');";
	
	foreach ($results as $result) {
	if(!isset($google_JSON)){
		$google_JSON = "{cols: [{id:'',label:'Date',type:'date'},{id:'',label:'".$singlelotto."',type:'number'}],rows: ["; 
	}
	
	$jpsingle = $cur.' '.number_format($result['jp']);

	$date = explode('-', $result['jpdate']);
	$month = (int)$date[1] - 1;
	$jpdate = 'new Date('.$date[0].', '.$month.', '.(int)$date[2].')';
   
		$google_JSON_rows[] = "{c:[{v: ".$jpdate.",f:null}, {v: ".$result['jp'].",f: '".$jpsingle."'}]}";

	}
	
	$lastdraw = count($results)-1;
	
	$date = explode('-', $results[$lastdraw]['jpdate']);
	$month = (int)$date[1] - 1;
	$endmonth = 'new Date('.$date[0].', '.$month.', '.(int)$date[2].')';
	$startmonth = 'new Date('.$date[0].', '.($month-1).', '.(int)$date[2].')';
	
	$gdata = $google_JSON.implode(",",$google_JSON_rows)."]}";
	
} else if (strlen($lot) > 2 && strlen($lot) <= 5) {
	
	$numlottos = 2;
	$columns = '1, 2';
	$lottos = explode(',', $lot);
	
	if ($lottos[0] == 'mm') { $lotto1 = 'Mega Millions'; $cur1 = '$';}
	else if ($lottos[0] == 'pb') { $lotto1 = 'PowerBall'; }
	else if ($lottos[0] == 'em') { $lotto1 = 'Euro Millions'; }
	else if ($lottos[0] == 'pa') { $lotto1 = 'PowerBall Australia'; }
	else if ($lottos[0] == 'hl') { $lotto1 = 'Hot Lotto'; }
	else if ($lottos[0] == 'eg') { $lotto1 = 'El Gordo'; }
	else if ($lottos[0] == 'fr') { $lotto1 = 'France Lotto'; }
	else if ($lottos[0] == 'uk') { $lotto1 = 'UK National Lottery'; }
	else if ($lottos[0] == 'cs') { $lotto1 = 'California SuperLotto'; }
	else if ($lottos[0] == 'oz') { $lotto1 = 'Oz Lotto'; }
	else if ($lottos[0] == '49') { $lotto1 = 'Lotto 6/49'; }
	else if ($lottos[0] == 'ho') { $lotto1 = 'Hoosier Lotto'; }
	else if ($lottos[0] == 'ny') { $lotto1 = 'New York Lotto'; }
	else if ($lottos[0] == 'fl') { $lotto1 = 'Florida Lotto'; }
	else if ($lottos[0] == 'ms') { $lotto1 = 'Mega Sena'; }
	else if ($lottos[0] == 'ie') { $lotto1 = 'Irish Lotto'; }
	else if ($lottos[0] == 'tb') { $lotto1 = 'Thunderball'; }
	else if ($lottos[0] == 'se') { $lotto1 = 'Superena Lotto'; }
	else if ($lottos[0] == 'de') { $lotto1 = 'German Lotto'; }
	else if ($lottos[0] == 'lp') { $lotto1 = 'La Primitiva'; }
	
	if ($lottos[1] == 'mm') { $lotto2 = 'Mega Millions'; }
	else if ($lottos[1] == 'pb') { $lotto2 = 'PowerBall'; }
	else if ($lottos[1] == 'em') { $lotto2 = 'Euro Millions'; }
	else if ($lottos[1] == 'pa') { $lotto2 = 'PowerBall Australia'; }
	else if ($lottos[1] == 'hl') { $lotto2 = 'Hot Lotto'; }
	else if ($lottos[1] == 'eg') { $lotto2 = 'El Gordo'; }
	else if ($lottos[1] == 'fr') { $lotto2 = 'France Lotto'; }
	else if ($lottos[1] == 'uk') { $lotto2 = 'UK National Lottery'; }
	else if ($lottos[1] == 'cs') { $lotto2 = 'California SuperLotto'; }
	else if ($lottos[1] == 'oz') { $lotto2 = 'Oz Lotto'; }
	else if ($lottos[1] == '49') { $lotto2 = 'Lotto 6/49'; }
	else if ($lottos[1] == 'ho') { $lotto2 = 'Hoosier Lotto'; }
	else if ($lottos[1] == 'ny') { $lotto2 = 'New York Lotto'; }
	else if ($lottos[1] == 'fl') { $lotto2 = 'Florida Lotto'; }
	else if ($lottos[1] == 'ms') { $lotto2 = 'Mega Sena'; }
	else if ($lottos[1] == 'ie') { $lotto2 = 'Irish Lotto'; }
	else if ($lottos[1] == 'tb') { $lotto2 = 'Thunderball'; }
	else if ($lottos[1] == 'se') { $lotto2 = 'Superena Lotto'; }
	else if ($lottos[1] == 'de') { $lotto2 = 'German Lotto'; }
	else if ($lottos[1] == 'lp') { $lotto2 = 'La Primitiva'; }
	
	$firstlotto = $wpdb->get_results("SELECT * FROM `jackpots` WHERE `lotto` = '$lottos[0]'", ARRAY_A);
	
	$secondlotto = $wpdb->get_results("SELECT * FROM `jackpots` WHERE `lotto` = '$lottos[1]'", ARRAY_A);
	
	foreach($firstlotto as $f) {
		$numbers = $f['n1'].', '.$f['n2'].', '.$f['n3'].', '.$f['n4'].', '.$f['n5'].', '.$f['n6'].', '.$f['n7'].', '.$f['n8'].', '.$f['n9'];
		$first[$f['jpdate']] = array('jp' => $f['jp'],'jpdate' => $f['jpdate'], 'n' => $numbers);
		}
		
	foreach($secondlotto as $s) {
		$numbers = $s['n1'].', '.$s['n2'].', '.$s['n3'].', '.$s['n4'].', '.$s['n5'].', '.$s['n6'].', '.$s['n7'].', '.$s['n8'].', '.$s['n9'];
		$second[$s['jpdate']] = array('jp' => $s['jp'],'jpdate' => $s['jpdate'], 'n' => $numbers);
		}
	
	foreach($first as $firstcheck) {
		if (!array_key_exists($firstcheck['jpdate'], $second)) {
			$second[$firstcheck['jpdate']] = array('jp' => 0,'jpdate' => $firstcheck['jpdate'], 'n' => 0);
		}
	}
	
	ksort($second);
	$second = array_values($second);
	
	foreach($second as $secondcheck) {
		if (!array_key_exists($secondcheck['jpdate'], $first)) {
			$first[$secondcheck['jpdate']] = array('jp' => 0,'jpdate' => $secondcheck['jpdate'], 'n' => 0);
		}
	}
	
	ksort($first);
	$first = array_values($first);

	for ($x = 0; $x <= count($first)-1; $x++) {
	if(!isset($google_JSON)){
		$google_JSON = "{cols: [{id:'',label:'Date',type:'date'},{id:'',label:'".$lotto1."',type:'number'},{id:'',label:'".$lotto2."',type:'number'}],rows: ["; 
	}
	
	$jpfirst = $cur.' '.number_format($first[$x]['jp']);
	$jpsecond = $cur.' '.number_format($second[$x]['jp']);

	$date = explode('-', $first[$x]['jpdate']);
	$month = (int)$date[1] - 1;
	$jpdate = 'new Date('.$date[0].', '.$month.', '.(int)$date[2].')';
   
		$google_JSON_rows[] = "{c:[{v: ".$jpdate.",f:null}, {v: ".$first[$x]['jp'].",f: '".$jpfirst."'}, {v: ".$second[$x]['jp'].",f: '".$jpsecond."'}]}";

	}
    
	$gdata = $google_JSON.implode(",",$google_JSON_rows)."]}";
	
	$showpredictedjp = '$("#jpwrap").css("display","none");';
	
	$lastdraw = count($first)-1;
	
	$date = explode('-', $first[$lastdraw]['jpdate']);
	$month = (int)$date[1] - 1;
	$endmonth = 'new Date('.$date[0].', '.$month.', '.(int)$date[2].')';
	$startmonth = 'new Date('.$date[0].', '.($month-1).', '.(int)$date[2].')';
	
} else if (strlen($lot) == 8) {
	$numlottos = 3;
	$columns = '1,2,3';
	
	$lottos = explode(',', $lot);
	
	if ($lottos[0] == 'mm') { $lotto1 = 'Mega Millions'; $cur1 = '$';}
	else if ($lottos[0] == 'pb') { $lotto1 = 'PowerBall'; }
	else if ($lottos[0] == 'em') { $lotto1 = 'Euro Millions'; }
	else if ($lottos[0] == 'pa') { $lotto1 = 'PowerBall Australia'; }
	else if ($lottos[0] == 'hl') { $lotto1 = 'Hot Lotto'; }
	else if ($lottos[0] == 'eg') { $lotto1 = 'El Gordo'; }
	else if ($lottos[0] == 'fr') { $lotto1 = 'France Lotto'; }
	else if ($lottos[0] == 'uk') { $lotto1 = 'UK National Lottery'; }
	else if ($lottos[0] == 'cs') { $lotto1 = 'California SuperLotto'; }
	else if ($lottos[0] == 'oz') { $lotto1 = 'Oz Lotto'; }
	else if ($lottos[0] == '49') { $lotto1 = 'Lotto 6/49'; }
	else if ($lottos[0] == 'ho') { $lotto1 = 'Hoosier Lotto'; }
	else if ($lottos[0] == 'ny') { $lotto1 = 'New York Lotto'; }
	else if ($lottos[0] == 'fl') { $lotto1 = 'Florida Lotto'; }
	else if ($lottos[0] == 'ms') { $lotto1 = 'Mega Sena'; }
	else if ($lottos[0] == 'ie') { $lotto1 = 'Irish Lotto'; }
	else if ($lottos[0] == 'tb') { $lotto1 = 'Thunderball'; }
	else if ($lottos[0] == 'se') { $lotto1 = 'Superena Lotto'; }
	else if ($lottos[0] == 'de') { $lotto1 = 'German Lotto'; }
	else if ($lottos[0] == 'lp') { $lotto1 = 'La Primitiva'; }
	
	if ($lottos[1] == 'mm') { $lotto2 = 'Mega Millions'; }
	else if ($lottos[1] == 'pb') { $lotto2 = 'PowerBall'; }
	else if ($lottos[1] == 'em') { $lotto2 = 'Euro Millions'; }
	else if ($lottos[1] == 'pa') { $lotto2 = 'PowerBall Australia'; }
	else if ($lottos[1] == 'hl') { $lotto2 = 'Hot Lotto'; }
	else if ($lottos[1] == 'eg') { $lotto2 = 'El Gordo'; }
	else if ($lottos[1] == 'fr') { $lotto2 = 'France Lotto'; }
	else if ($lottos[1] == 'uk') { $lotto2 = 'UK National Lottery'; }
	else if ($lottos[1] == 'cs') { $lotto2 = 'California SuperLotto'; }
	else if ($lottos[1] == 'oz') { $lotto2 = 'Oz Lotto'; }
	else if ($lottos[1] == '49') { $lotto2 = 'Lotto 6/49'; }
	else if ($lottos[1] == 'ho') { $lotto2 = 'Hoosier Lotto'; }
	else if ($lottos[1] == 'ny') { $lotto2 = 'New York Lotto'; }
	else if ($lottos[1] == 'fl') { $lotto2 = 'Florida Lotto'; }
	else if ($lottos[1] == 'ms') { $lotto2 = 'Mega Sena'; }
	else if ($lottos[1] == 'ie') { $lotto2 = 'Irish Lotto'; }
	else if ($lottos[1] == 'tb') { $lotto2 = 'Thunderball'; }
	else if ($lottos[1] == 'se') { $lotto2 = 'Superena Lotto'; }
	else if ($lottos[1] == 'de') { $lotto2 = 'German Lotto'; }
	else if ($lottos[1] == 'lp') { $lotto2 = 'La Primitiva'; }
	
	if ($lottos[2]  == 'mm') { $lotto3 = 'Mega Millions'; }
	else if ($lottos[2]  == 'pb') { $lotto3 = 'PowerBall'; }
	else if ($lottos[2]  == 'em') { $lotto3 = 'Euro Millions'; }
	else if ($lottos[2]  == 'pa') { $lotto3 = 'PowerBall Australia'; }
	else if ($lottos[2]  == 'hl') { $lotto3 = 'Hot Lotto'; }
	else if ($lottos[2]  == 'eg') { $lotto3 = 'El Gordo'; }
	else if ($lottos[2]  == 'fr') { $lotto3 = 'France Lotto'; }
	else if ($lottos[2]  == 'uk') { $lotto3 = 'UK National Lottery'; }
	else if ($lottos[2]  == 'cs') { $lotto3 = 'California SuperLotto'; }
	else if ($lottos[2]  == 'oz') { $lotto3 = 'Oz Lotto'; }
	else if ($lottos[2]  == '49') { $lotto3 = 'Lotto 6/49'; }
	else if ($lottos[2]  == 'ho') { $lotto3 = 'Hoosier Lotto'; }
	else if ($lottos[2]  == 'ny') { $lotto3 = 'New York Lotto'; }
	else if ($lottos[2]  == 'fl') { $lotto3 = 'Florida Lotto'; }
	else if ($lottos[2]  == 'ms') { $lotto3 = 'Mega Sena'; }
	else if ($lottos[2]  == 'ie') { $lotto3 = 'Irish Lotto'; }
	else if ($lottos[2]  == 'tb') { $lotto3 = 'Thunderball'; }
	else if ($lottos[2]  == 'se') { $lotto3 = 'Superena Lotto'; }
	else if ($lottos[2]  == 'de') { $lotto3 = 'German Lotto'; }
	else if ($lottos[2]  == 'lp') { $lotto3 = 'La Primitiva'; }
	
	$firstlotto = $wpdb->get_results("SELECT * FROM `jackpots` WHERE `lotto` = '$lottos[0]'", ARRAY_A);
	
	$secondlotto = $wpdb->get_results("SELECT * FROM `jackpots` WHERE `lotto` = '$lottos[1]'", ARRAY_A);
	
	$thirdlotto = $wpdb->get_results("SELECT * FROM `jackpots` WHERE `lotto` = '$lottos[2]'", ARRAY_A);
	
	foreach($firstlotto as $f) {
		$numbers = $f['n1'].', '.$f['n2'].', '.$f['n3'].', '.$f['n4'].', '.$f['n5'].', '.$f['n6'].', '.$f['n7'].', '.$f['n8'].', '.$f['n9'];
		$first[$f['jpdate']] = array('jp' => $f['jp'],'jpdate' => $f['jpdate'], 'n' => $numbers);
		}
		
	foreach($secondlotto as $s) {
		$numbers = $s['n1'].', '.$s['n2'].', '.$s['n3'].', '.$s['n4'].', '.$s['n5'].', '.$s['n6'].', '.$s['n7'].', '.$s['n8'].', '.$s['n9'];
		$second[$s['jpdate']] = array('jp' => $s['jp'],'jpdate' => $s['jpdate'], 'n' => $numbers);
		}
	
	foreach($thirdlotto as $t) {
		$numbers = $s['n1'].', '.$s['n2'].', '.$s['n3'].', '.$s['n4'].', '.$s['n5'].', '.$s['n6'].', '.$s['n7'].', '.$s['n8'].', '.$s['n9'];
		$third[$t['jpdate']] = array('jp' => $t['jp'],'jpdate' => $t['jpdate'], 'n' => $numbers);
		}
	
	foreach($first as $firstcheck) {
		if (!array_key_exists($firstcheck['jpdate'], $second)) {
			$second[$firstcheck['jpdate']] = array('jp' => 0,'jpdate' => $firstcheck['jpdate'], 'n' => 0);
		}
		if (!array_key_exists($firstcheck['jpdate'], $third)) {
			$third[$firstcheck['jpdate']] = array('jp' => 0,'jpdate' => $firstcheck['jpdate'], 'n' => 0);
		}
	}
	
	foreach($second as $secondcheck) {
		if (!array_key_exists($secondcheck['jpdate'], $first)) {
			$first[$secondcheck['jpdate']] = array('jp' => 0,'jpdate' => $secondcheck['jpdate'], 'n' => 0);
		}
		if (!array_key_exists($secondcheck['jpdate'], $third)) {
			$third[$secondcheck['jpdate']] = array('jp' => 0,'jpdate' => $secondcheck['jpdate'], 'n' => 0);
		}
	}
	
	foreach($third as $thirdcheck) {
		if (!array_key_exists($thirdcheck['jpdate'], $first)) {
			$first[$thirdcheck['jpdate']] = array('jp' => 0,'jpdate' => $thirdcheck['jpdate'], 'n' => 0);
		} 
		if (!array_key_exists($thirdcheck['jpdate'], $second)) {
			$second[$thirdcheck['jpdate']] = array('jp' => 0,'jpdate' => $thirdcheck['jpdate'], 'n' => 0);
		}
	}
	
	ksort($first);
	ksort($second);
	ksort($third);
	
	$second = array_values($second);
	$first = array_values($first);
	$third = array_values($third);
	
	for ($x = 0; $x <= count($first)-1; $x++) {
	if(!isset($google_JSON)){
		$google_JSON = "{cols: [{id:'',label:'Date',type:'date'},{id:'',label:'".$lotto1."',type:'number'},{id:'',label:'".$lotto2."',type:'number'},{id:'',label:'".$lotto3."',type:'number'}],rows: ["; 
	}
	
	$jpfirst = $cur1.' '.number_format($first[$x]['jp']);
	$jpsecond = $cur.' '.number_format($second[$x]['jp']);
	$jpthird = $cur.' '.number_format($third[$x]['jp']);
	
	$date = explode('-', $first[$x]['jpdate']);
	$month = (int)$date[1] - 1;
	$jpdate = 'new Date('.$date[0].', '.$month.', '.(int)$date[2].')';
   
		$google_JSON_rows[] = "{c:[{v: ".$jpdate.",f:null}, {v: ".$first[$x]['jp'].",f: '".$jpfirst."'}, {v: ".$second[$x]['jp'].",f: '".$jpsecond."'}, {v: ".$third[$x]['jp'].",f: '".$jpthird."'}]}";

	}
    
	$gdata = $google_JSON.implode(",",$google_JSON_rows)."]}";
	
	$showpredictedjp = '$("#jpwrap").css("display","none");';
	
	$lastdraw = count($first)-1;
	
	$date = explode('-', $first[$lastdraw]['jpdate']);
	$month = (int)$date[1] - 1;
	$endmonth = 'new Date('.$date[0].', '.$month.', '.(int)$date[2].')';
	$startmonth = 'new Date('.$date[0].', '.($month-1).', '.(int)$date[2].')';
	
} else {
	$numlottos = 2;
	$columns = '1, 2';
	
	$lottos[0] = 'mm';
	$lotto1 = 'Mega Millions'; $cur1 = '$';
	$lottos[1] = 'pb';
	$lotto2 = 'PowerBall';
	
	$firstlotto = $wpdb->get_results("SELECT * FROM `jackpots` WHERE `lotto` = '$lottos[0]'", ARRAY_A);
	
	$secondlotto = $wpdb->get_results("SELECT * FROM `jackpots` WHERE `lotto` = '$lottos[1]'", ARRAY_A);
	
	foreach($firstlotto as $f) {
		$numbers = $f['n1'].', '.$f['n2'].', '.$f['n3'].', '.$f['n4'].', '.$f['n5'].', '.$f['n6'].', '.$f['n7'].', '.$f['n8'].', '.$f['n9'];
		$first[$f['jpdate']] = array('jp' => $f['jp'],'jpdate' => $f['jpdate'], 'n' => $numbers);
		}
		
	foreach($secondlotto as $s) {
		$numbers = $s['n1'].', '.$s['n2'].', '.$s['n3'].', '.$s['n4'].', '.$s['n5'].', '.$s['n6'].', '.$s['n7'].', '.$s['n8'].', '.$s['n9'];
		$second[$s['jpdate']] = array('jp' => $s['jp'],'jpdate' => $s['jpdate'], 'n' => $numbers);
		}
	
	foreach($first as $firstcheck) {
		if (!array_key_exists($firstcheck['jpdate'], $second)) {
			$second[$firstcheck['jpdate']] = array('jp' => 0,'jpdate' => $firstcheck['jpdate'], 'n' => 0);
		}
	}
	
	ksort($second);
	$second = array_values($second);
	
	foreach($second as $secondcheck) {
		if (!array_key_exists($secondcheck['jpdate'], $first)) {
			$first[$secondcheck['jpdate']] = array('jp' => 0,'jpdate' => $secondcheck['jpdate'], 'n' => 0);
		}
	}
	
	ksort($first);
	$first = array_values($first);

	for ($x = 0; $x <= count($first)-1; $x++) {
	if(!isset($google_JSON)){
		$google_JSON = "{cols: [{id:'',label:'Date',type:'date'},{id:'',label:'".$lotto1."',type:'number'},{id:'',label:'".$lotto2."',type:'number'}],rows: ["; 
	}
	
	$jpfirst = $cur.' '.number_format($first[$x]['jp']);
	$jpsecond = $cur.' '.number_format($second[$x]['jp']);

	$date = explode('-', $first[$x]['jpdate']);
	$month = (int)$date[1] - 1;
	$jpdate = 'new Date('.$date[0].', '.$month.', '.(int)$date[2].')';
   
		$google_JSON_rows[] = "{c:[{v: ".$jpdate.",f:null}, {v: ".$first[$x]['jp'].",f: '".$jpfirst."'}, {v: ".$second[$x]['jp'].",f: '".$jpsecond."'}]}";

	}
    
	$gdata = $google_JSON.implode(",",$google_JSON_rows)."]}";
	
	$showpredictedjp = '$("#jpwrap").css("display","none");';
	
	$lastdraw = count($first)-1;
	
	$date = explode('-', $first[$lastdraw]['jpdate']);
	$month = (int)$date[1] - 1;
	$endmonth = 'new Date('.$date[0].', '.$month.', '.(int)$date[2].')';
	$startmonth = 'new Date('.$date[0].', '.($month-3).', '.(int)$date[2].')';
}

echo "var dashboard = new google.visualization.Dashboard(
             document.getElementById('dashboard'));
		
		var control = new google.visualization.ControlWrapper({
           'controlType': 'ChartRangeFilter',
           'containerId': 'control',
           'options': {
             // Filter by the date axis.
             'filterColumnIndex': 0,
             'ui': {
               'chartType': 'LineChart',
               'chartOptions': {
                 'chartArea': {'width': '100%'},
                 'hAxis': {'baselineColor': 'none'}
               },
               // Display a single series that shows the closing value of the stock.
               // Thus, this view has two columns: the date (axis) and the stock value (line series).
               'chartView': {
                 'columns': [0, 1]
               },
               // 1 day in milliseconds = 24 * 60 * 60 * 1000 = 86,400,000
               'minRangeSize': 86400000
             }
           },
		   'state': {'range': {'start': ".$startmonth.", 'end': ".$endmonth."}}
         });
      
         var chart = new google.visualization.ChartWrapper({
           'chartType': 'AreaChart',
           'containerId': 'chart',
           'options': {
             // Use the same chart area width as the control for axis alignment.
             'chartArea': {'height': '80%', 'width': '100%'},
             'hAxis': {'slantedText': false},
             //'vAxis': {'viewWindow': {'min': 0, 'max': 2000}},
             'legend': {position: 'top', textStyle: {color: 'red', fontSize: 16}}
			 
           },
           // Convert the first column from 'date' to 'string'.
           'view': {
             'columns': [
               {
                 'calc': function(dataTable, rowIndex) {
                   return dataTable.getFormattedValue(rowIndex, 0);
                 },
                 'type': 'string'
               }, ".$columns."]
           }
         });
		
	var data = new google.visualization.DataTable(".$gdata.")

		
         dashboard.bind(control, chart);
         dashboard.draw(data);".$showpredictedjp;
?>