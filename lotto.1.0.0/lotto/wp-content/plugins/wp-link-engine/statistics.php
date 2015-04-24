<?php
global $thenew;
$thenew = strtotime('-2 week');

function getstart () 
{
$targetpage = "admin.php?page=wplink-statistics"; 	//your file name  (the name of this file)
	$limit = 1000; 								//how many items to show per page
	$paging = $_GET['paging'];
	if($paging) 
		$start = ($paging - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
		
		return $start ;
}

function pagin () 
{
	/*
		Place code to connect to your DB here.
	*/
	
$thenew = strtotime('-2 week');
	$tbl_name="wp_wplink_clicks";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 5;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/

	$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE `timestamp` > '$thenew'";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	/* Setup vars for query. */
	$targetpage = "admin.php?page=wplink-statistics"; 	//your file name  (the name of this file)
	$limit = 250; 								//how many items to show per page
	$paging = $_GET['paging'];
	if($paging) 
		$start = ($paging - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	$sql = "SELECT * FROM $tbl_name WHERE `timestamp` > '$thenew' LIMIT $start, $limit";
	$result = mysql_query($sql);
	
	/* Setup page vars for display. */
	if ($paging == 0) $paging = 1;					//if no page var is given, default to 1.
	$prev = $paging	 - 1;							//previous page is page - 1
	$next = $paging + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($paging > 1) 
			$pagination.= "<a href=\"$targetpage&paging=$prev\">&#65533; previous</a>&nbsp;|&nbsp;";
		else
			$pagination.= "<span class=\"disabled\">&#65533; previous</span>&nbsp;|&nbsp;";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $paging)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "&nbsp;|&nbsp;<a href=\"$targetpage&paging=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($paging < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $paging)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "&nbsp;|&nbsp;<a href=\"$targetpage&paging=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "&nbsp;|&nbsp;<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
				$pagination.= "&nbsp;|&nbsp;<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $paging && $paging > ($adjacents * 2))
			{
				$pagination.= "&nbsp;|&nbsp;<a href=\"$targetpage?paging=1\">1</a>";
				$pagination.= "&nbsp;|&nbsp;<a href=\"$targetpage?paging=2\">2</a>";
				$pagination.= "...";
				for ($counter = $paging - $adjacents; $counter <= $paging + $adjacents; $counter++)
				{
					if ($counter == $paging)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "&nbsp;|&nbsp;<a href=\"$targetpage&paging=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "&nbsp;|&nbsp;<a href=\"$targetpage&paging=$lpm1\">$lpm1</a>";
				$pagination.= "&nbsp;|&nbsp;<a href=\"$targetpage&paging=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "&nbsp;|&nbsp;<a href=\"$targetpage&paging=1\">1</a>";
				$pagination.= "&nbsp;|&nbsp;<a href=\"$targetpage&paging=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $paging)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "&nbsp;|&nbsp;<a href=\"$targetpage&paging=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button

		if ($paging < $counter - 1) 
			$pagination.= "&nbsp;|&nbsp;<a href=\"$targetpage&paging=$next\">next &#65533;</a>";
		else
			$pagination.= "&nbsp;|&nbsp;<span class=\"disabled\">next &#65533;</span>";
		//$pagination.= "</div>\n.".$start."".$limit."";		
	}
	
return ($pagination); 	
}





    function wplink_statistics() {
    ?>
    <div class="wrap">
        <div id="icon-edit" class="icon32"><br /></div>
        <h2>Statistics</h2>
        <table class="widefat poll fixed" cellspacing="0">
            <thead>	
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Total Clicks</th>
                    <th scope="col">Unique Clicks (total)</th>
                    <th scope="col">Total Clicks Today</th>
                    <th scope="col">Unique Clicks Today</th>
                </tr>
            </thead>
            
            <tfoot>
            <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Total Clicks</th>
                    <th scope="col">Unique Clicks (total)</th>
                    <th scope="col">Total Clicks Today</th>
                    <th scope="col">Unique Clicks Today</th>
            </tr>
            </tfoot>

            <tbody id="the-list" class="list:link">
                <?php wplink_stats_rows(); ?>
            </tbody>
        </table>
        
<?php
$thenew = strtotime('-2 week');
$query = mysql_query("SELECT * FROM `wp_wplink_clicks` WHERE `timestamp` > '$thenew' "); 
$numrow= mysql_num_rows ($query); 



?>


          




        <h2>Last 2 Weeks <?php echo($numrow);  ?> clicks...</h2>
        <table class="widefat poll fixed" cellspacing="0">
            <thead>	
                <tr>
<th scope="col">ID</th>

                    <th scope="col">Link</th>
                    <th scope="col">Time</th>
                    <th scope="col">Destination</th>
                    <th scope="col">Referrer</th>
                    <th scope="col">User Agent</th>
                    <th scope="col">Country</th>
 <th scope="col">Keyword</th>
                </tr>
            </thead>
            
            <tfoot>
            <tr>
<th scope="col">ID</th>

                    <th scope="col">Link</th>
                    <th scope="col">Time</th>
                    <th scope="col">Destination</th>
                    <th scope="col">Referrer</th>
                    <th scope="col">User Agent</th>
                    <th scope="col">country</th>
 <th scope="col">Keyword</th>
            </tr>
            </tfoot>

            <tbody id="the-list" class="list:link">
                <?php wplink_clicks_rows(); ?>
            </tbody>
        </table>    
     <div align="center" >

<?

echo(pagin()); 
?>
</div>






















<h2>Referer Stats Last 2 Weeks</h2>
        <table class="widefat poll fixed" cellspacing="0">
            <thead>	
                <tr>

                    <th scope="col">URL</th>
                    <th scope="col">Count</th>
                                    </tr>
            </thead>
            
            <tfoot>
            <tr>

            <th scope="col">URL</th>
                    <th scope="col">Count</th>
            </tr>
            </tfoot>

            <tbody id="the-list" class="list:link">
               <?
			   $query = mysql_query ("SELECT COUNT( * ) AS num,  `referrer` FROM  `wp_wplink_clicks` WHERE `timestamp` > '$thenew' GROUP BY  `referrer` HAVING COUNT( * ) >= 1 ORDER BY COUNT(*) DESC");  
			   while ($row = mysql_fetch_array($query) ) 
			   {
			    echo("<tr>
				<td>".$row['referrer']."</td>
				<td>".$row['num']."</td>
					</tr>");
			   }
			   
			   
			   ?>
            </tbody>
        </table>    
     <div align="center" >





    </div>
    <?php
    }
 


  
    
    function wplink_clicks_rows() {
        global $wpdb;


$start = getstart (); 
$thenew = strtotime('-2 week');
       $query = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."wplink_clicks` WHERE `timestamp` > '$thenew' ORDER BY `timestamp` DESC LIMIT $start, 1000 ");
       $clicks = $wpdb->get_results($query);
        
        $out = '';
        $count = 0;
        foreach( $clicks as $entry )
                $out .= wplink_clicks_row($entry, ++$count % 2 ? ' class="row-b"' : '' );

        // filter and send to screen
        echo $out;
        return $count;
	}
	
	
	function wplink_clicks_row( $entry, $class = '' ) {
    	global $wpdb;
        
        $link = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."wplink_links` WHERE `id`='{$entry->link_id}'");

        $name = $link[0]->name;
        if(!(strlen($name) > 0)) {
            $name = $link[0]->link_title;
        }
        
$getcountry = mysql_query ("SELECT * FROM `wp_wplink_clicks` where `id`='$entry->id'"); 
$iprow = mysql_fetch_array ($getcountry); 

$iplong = $iprow['ip_long'] ; 

$getthecountry = mysql_query ("SELECT * FROM `countries` WHERE '$iplong' BETWEEN `from` AND `to` ") ; 
$countryis = mysql_fetch_array ($getthecountry); 

$country = $countryis['code3'] ; 



        $output = "<tr id='entry-" . $entry->id . "'>";
        $output ="<td id='entry-" . $entry->id . "'>".$entry->id."</td>";
        $output .= "<td class='name column-name'><strong>" . $name . "</strong></td>";
        $output .= "<td class='timestamp column-from'>" . date("F j, Y, g:i a", $entry->timestamp) . "</td>";
        $output .= "<td class='destination column-to'>" . ($entry->destination)  . "</td>";
        $output .= "<td class='referrer column-cloaked'>" .(!empty($entry->referrer) ? $entry->referrer : "n/a") . "</td>";
        $output .= "<td class='agent column-group'><small>" . ($entry->agent). "</small></td>";
        $output .= "<td class='subid column-group'>" . ($country). "</td>";
       $output .= "<td class='agent column-group'>" . ($entry->kw). "</td>";
        
        $output .= "</tr>";
		
        
        return $output;
        
	}
	
    function wplink_stats_rows() {
        global $wpdb;

        $query = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."wplink_links");
        $clicks = $wpdb->get_results($query);
        
        $out = '';
        $count = 0;
        foreach( $clicks as $entry )
                $out .= wplink_stats_row($entry, ++$count % 2 ? ' class="row-b"' : '' );

        // filter and send to screen
        echo $out;
        return $count;
	}
	
	
	function wplink_stats_row( $entry, $class = '' ) {
    	global $wpdb;
                
        $name = $entry->name;
        if(!(strlen($name) > 0)) {
            $name = $entry->link_title;
        }
        
        $today = strtotime("today");
        
        $total_clicks = $wpdb->get_results("SELECT COUNT(*) as `cn` FROM `".$wpdb->prefix."wplink_clicks` WHERE `link_id`='{$entry->id}'");
        $unique_total_clicks = $wpdb->get_results("SELECT COUNT(DISTINCT `ip_long`) as `cn` FROM `".$wpdb->prefix."wplink_clicks` WHERE `link_id`='{$entry->id}'");
        $daily_total_clicks = $wpdb->get_results("SELECT COUNT(*) as `cn` FROM `".$wpdb->prefix."wplink_clicks` WHERE `link_id`='{$entry->id}' AND `timestamp` < NOW() AND `timestamp` AND `timestamp` > $today");
        $unique_daily_total_clicks = $wpdb->get_results("SELECT COUNT(DISTINCT `ip_long`) as `cn` FROM `".$wpdb->prefix."wplink_clicks` WHERE `link_id`='{$entry->id}' AND `timestamp` < NOW() AND `timestamp` AND `timestamp` > $today");
        
        $output = "<tr id='entry-" . $entry->id . "'>";
        $output .= "<td class='name column-name'><strong>" . $name . "</strong> (" . $entry->id . ")</td>";
        $output .= "<td class='from column-from'>" . (is_numeric($total_clicks[0]->cn) ? $total_clicks[0]->cn : 0) . "</td>";
        $output .= "<td class='to column-to'>" . (is_numeric($unique_total_clicks[0]->cn) ? $unique_total_clicks[0]->cn : 0)  . "</td>";
        $output .= "<td class='cloaked column-cloaked'>" .(is_numeric($daily_total_clicks[0]->cn) ? $daily_total_clicks[0]->cn : 0) . "</td>";
        $output .= "<td class='group column-group'>" . (is_numeric($unique_daily_total_clicks[0]->cn) ? $unique_daily_total_clicks[0]->cn : 0). "</td>";
        $output .= "</tr>";
        
        if($entry->subid == 1) {
            $unique_subid = $wpdb->get_results("SELECT DISTINCT `subid` FROM `".$wpdb->prefix . "wplink_clicks` WHERE `link_id`='{$entry->id}'");
            foreach($unique_subid as $subid) {
                if($subid->subid != "") {
                    $output .= "<tr><td>&nbsp; <small><strong>Subid: " . $subid->subid . "</strong></small></td>";
                        
                    $total_clicks = $wpdb->get_results("SELECT COUNT(*) as `cn` FROM `".$wpdb->prefix."wplink_clicks` WHERE `link_id`='{$entry->id}' AND `subid`='{$subid->subid}'");
                    $unique_total_clicks = $wpdb->get_results("SELECT COUNT(DISTINCT `ip_long`) as `cn` FROM `".$wpdb->prefix."wplink_clicks` WHERE `link_id`='{$entry->id}' AND `subid`='{$subid->subid}'");
                    $daily_total_clicks = $wpdb->get_results("SELECT COUNT(*) as `cn` FROM `".$wpdb->prefix."wplink_clicks` WHERE `link_id`='{$entry->id}' AND `timestamp` < NOW() AND `timestamp` AND `timestamp` > $today AND `subid`='{$subid->subid}'");
                    $unique_daily_total_clicks = $wpdb->get_results("SELECT COUNT(DISTINCT `ip_long`) as `cn` FROM `".$wpdb->prefix."wplink_clicks` WHERE `link_id`='{$entry->id}' AND `timestamp` < NOW() AND `timestamp` AND `timestamp` > $today AND `subid`='{$subid->subid}'");
        
                    $output .= "<td class='from column-from'><small>" . (is_numeric($total_clicks[0]->cn) ? $total_clicks[0]->cn : 0) . "</small></td>";
                    $output .= "<td class='to column-to'><small>" . (is_numeric($unique_total_clicks[0]->cn) ? $unique_total_clicks[0]->cn : 0)  . "</small></td>";
                    $output .= "<td class='cloaked column-cloaked'><small>" .(is_numeric($daily_total_clicks[0]->cn) ? $daily_total_clicks[0]->cn : 0) . "</small></td>";
                    $output .= "<td class='group column-group'><small>" . (is_numeric($unique_daily_total_clicks[0]->cn) ? $unique_daily_total_clicks[0]->cn : 0). "</small></td>";
                    $output .= "</tr> ";

                }                               
            }
        }
        
       
        return $output;
        
	}

	
?>