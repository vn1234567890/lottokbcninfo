<?php
/**
 * PHP Class to get a website Alexa Ranking
 * @author http://www.paulund.co.uk
 *
 */
//echo shell_exec('whereis php5');
//mail('lightdesign@tut.by','LE.com Alexa ratinsg were updated','That is true ;)');
class Get_Alexa_Ranking{
	/**
	 * Get the rank from alexa for the given domain
	 *
	 * @param $domain
	 * The domain to search on
	 */
	public function get_rank($domain){
		$data=@file_get_contents('http://data.alexa.com/data?cli=10&dat=snbamz&url='.trim($domain));
			$pattern = '~<POPULARITY URL="(.*)" TEXT="([0-9]*)" ~';//<POPULARITY URL="pix6.com/" TEXT="6075421" SOURCE="panel"/>
			preg_match($pattern, $data, $matches);
			return $matches[2];
			//if ($matches[2]) return $matches[2]; else return 0;
			//var_dump($matches);
		    //return $rank;
	}
}
require_once ("../../../wp-config.php");
$results=$wpdb->get_results('SELECT id, site_name FROM '.$wpdb->prefix.'lotteries');
$alexa=new Get_Alexa_Ranking;
//var_dump($results);
foreach ($results as $r) {
	$rank=0;
$sitename=str_replace('www.','',strtolower($r->site_name));
	$rank=$alexa->get_rank($sitename);
	echo $sitename.' - '.$rank.'<br>';
	if (intval($rank)) {
		//echo $r->site_name."-".$rank."\n";
		$wpdb->query('UPDATE '.$wpdb->prefix.'lotteries SET alexa='.$rank.' WHERE id='.$r->id);
	}
}
?>
