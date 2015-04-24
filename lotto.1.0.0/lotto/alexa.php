<?php
require( 'wp-load.php' );

$domains = array('22lottery.com','bigfatlottos.com','PlayLottoWorld.com','BoxLotto.com','freelotto.com','PlayHugeLottos.com','mylotto.co.nz','Pix6.com','TheLotter.com','lottolondon.com','Lottery.co.uk','Masslottery.com','Tatts.com','Lottozone.com','healthlottery.co.uk','national-lottery.co.uk','congalotto.com','ozlotteries.com','mylotto24.co.uk','interlotto.com','postcodelottery.co.uk','WinTrillions.com','mnlotterysubscription.com','playsalottery.co.za','lotteryonline4u.com','order-us.com','lottery24.com','myplaywin.com','lottobroker.com','playlot.com','Youplayweplay.com','pandalottery.com','ThePlayersLottery.com','troppolotto.com','netlotto.com.au','thebille.com','osalottos.com','lotterywest.wa.gov.au','windowslotto.com','buylottoonline.com','lottoonlineservice.com','icelotto.com','lotterymaster.com','multilotto.com','materprizehome.com.au','lovemylotto.com','eurolotto.com','loopylotto.com','lotto-lottery24.com','Goalmillions.com','whichlotto.com','sports.williamhill.com','lovelotto.com','irishlotto.net','bitmillions.com','lukilotto.com','bclc.com','europeanlotteryguild.com','yourhospicelottery.org.uk','matchmorelotto.com','hospiscare.co.uk','leaderlotto.com','lotteryticketpool.com','lottobytext.co.uk');

foreach ($domains as $domain) {

$domain = urlencode($domain);
    $alexa = "http://data.alexa.com/data?cli=10&dat=snbamz&url=".$domain;
	$alexa = 'http://feeds.lottoelite.com/rss.php?lang=en&account=offpista&site=1&type=1';
	
    $xml = simplexml_load_file($alexa);
    if (!$xml) {
        return NULL;
    }
	
	var_dump($xml);
	$sd = $xml->SD[1];
	
	if(!empty($sd)) {
	$nodeAttributes = $xml->SD[1]->POPULARITY->attributes();
	$rank = (string) $nodeAttributes['TEXT'];
	} else {
	$rank = 0;
	}
	exit();
    echo $domain.' - '.$rank.'<br>';
	}

exit();
lottery_alexa_exec();
?>