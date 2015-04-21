<?php
/*
Plugin Name: Lotteries
Plugin URI: http://best-programmers.com/wordpress/lotteries
Description: Lotteries listings and clicks counter
Version: 0.1.0
Author: Pavel Martsinchyk pmartsinchyk@gmail.com
Author URI: http://best-programmers.com
License: Proprietary
*/

add_action( 'admin_menu', 'admin_lotteries' );
function admin_lotteries() {
	add_menu_page('Lotteries', 'Lotteries', 'manage_options', 'admin_lotteries', 'update_lotteries');
	add_submenu_page('admin_lotteries','Lotteries clicks', 'Clicks', 'manage_options', 'admin_lotteries_clicks', 'view_lotteries_clicks');
	add_submenu_page('admin_lotteries','Review tables', 'Review tables', 'manage_options', 'admin_lotteries_review_table', 'view_lotteries_review_table');
	add_submenu_page('admin_lotteries','Fields', 'Fields', 'manage_options', 'admin_lotteries_fields', 'view_lotteries_fields');
}

function update_lotteries() {
    global $wpdb;
    $wpdb->query("CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}lotteries_clicks` (
  `lottery_id` smallint(5) unsigned NOT NULL,
  `date` date NOT NULL,
  `clicks` bigint(20) unsigned NOT NULL,
  KEY `lottery_id` (`lottery_id`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

$wpdb->query("CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}lotteries` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `position` tinyint(3) unsigned NOT NULL,
  `slug` varchar(255) NOT NULL,
  `alexa` int(11) unsigned NOT NULL DEFAULT '0',
  `visit_url` varchar(255) NOT NULL DEFAULT '',
  `logo` varchar(255) NOT NULL DEFAULT '',
  `other_sites` varchar(255) NOT NULL DEFAULT '',
  `longest_expiry` text NOT NULL,
  `number_of_lotteries` char(255) NOT NULL,
  `funding_methods` char(255) NOT NULL,
  `languages` char(255) NOT NULL,
  `approved` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;");
$wpdb->query("CREATE TABLE IF NOT EXISTS  `{$wpdb->prefix}lotteries_tables` (
`id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
`title` varchar(255) NOT NULL DEFAULT '',
`category` INT NOT NULL ,
`content` MEDIUMTEXT NOT NULL ,
PRIMARY KEY (  `id` ) ,
UNIQUE (
`category`
)
) ENGINE = INNODB;");
  if ( !current_user_can( 'manage_options' ) )  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }
  
  echo "<style type='text/css'>.lotteries_table_head {font-weight:bold;}
        .lotteries_table {border:1px solid #ccc;border-collapse:collapse;}
        .lotteries_table td {padding:3px 5px;border:1px solid #ccc;}
        textarea { min-width:600px; }
        </style>";
  
  if (intval($_GET['add_form']) > 0) {
    
        echo  "<form action='admin.php?page=admin_lotteries' method='post'><table class='lotteries_table'>";
        $columns=$wpdb->get_results("SHOW COLUMNS FROM  {$wpdb->prefix}lotteries ");
				$columns=array_slice($columns,1);
				foreach ($columns as $col) {
						$array_insert[$col->Field]=$_POST[$col->Field];
						echo "<tr><td class='lotteries_table_head'>{$col->Field}</td><td><textarea name='{$col->Field}'>{$l[$col->Field]}</textarea></td></tr>";
				}
				echo  "<tr><td></td><td><input type='hidden' name='add' value='1'><input type='submit' value='Save'></td></tr>".
              "</table></form>";
            
    } elseif (intval($_POST['add']) > 0) {
        $columns=$wpdb->get_results("SHOW COLUMNS FROM  {$wpdb->prefix}lotteries ");
				$columns=array_slice($columns,1);
				foreach ($columns as $col) {
						$array_insert[$col->Field]=$_POST[$col->Field];
				}
        $wpdb->insert($wpdb->prefix.'lotteries',$array_insert);
        echo '<script type="text/javascript">document.location="/wp-admin/admin.php?page=admin_lotteries&edit='.$wpdb->insert_id.'";</script>';
        
    } elseif (intval($_POST['save']) > 0) {
        $columns=$wpdb->get_results("SHOW COLUMNS FROM  {$wpdb->prefix}lotteries ");
				$columns=array_slice($columns,1);
				foreach ($columns as $col) {
						$array_update[$col->Field]=$_POST[$col->Field];
				}
        $wpdb->update($wpdb->prefix.'lotteries',$array_update,array('id'=>$_POST['save']));
        
        echo '<script type="text/javascript">document.location="/wp-admin/admin.php?page=admin_lotteries&edit='.$_POST['save'].'";</script>';
        
    } elseif (intval($_GET['edit']) > 0) {
        
        $l=$wpdb->get_row("SELECT * FROM {$wpdb->prefix}lotteries WHERE id=".intval($_GET['edit']),ARRAY_A);
        
        $columns=$wpdb->get_results("SHOW COLUMNS FROM  {$wpdb->prefix}lotteries ");
				$columns=array_slice($columns,1);
        echo  "<table class='lotteries_table'>".
            "<form action='admin.php?page=admin_lotteries' method='post'><tr><td><img src='{$l['logo']}'></td><td></td></tr>";
				foreach ($columns as $col) {
						$array_insert[$col->Field]=$_POST[$col->Field];
						echo "<tr><td class='lotteries_table_head'>{$col->Field}</td><td><textarea name='{$col->Field}'>{$l[$col->Field]}</textarea></td></tr>";
				}
        echo "<tr><td></td><td><input type='hidden' name='save' value='{$_GET['edit']}'><input type='submit' value='Save'></td></tr></form>".
            "<tr><td></td><td><form action='' method='GET'><input type='hidden' name='page' value='admin_lotteries'><input type='hidden' name='delete' value='{$_GET['edit']}'><input type='submit' value='Delete'></form></td></tr>".
            "</table>";
            
            echo '<a href="admin.php?page=admin_lotteries">Back to the listing</a>';
            
    } elseif (intval($_GET['delete']) > 0) {
        
        $wpdb->query("DELETE FROM {$wpdb->prefix}lotteries WHERE id=".intval($_GET['delete']));
        echo '<script type="text/javascript">document.location="/wp-admin/admin.php?page=admin_lotteries";</script>';
        
    } else {
        
        echo '<div class="wrap"><h2>The listing</h2>';
        echo "<p><form action='' method='GET'><table class='lotteries_table'>";
        
        $data=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}lotteries");
        echo "<td class='lotteries_table_head'>Number:</td>".
	    "<td class='lotteries_table_head'>Position:</td>".
            "<td class='lotteries_table_head'>Slug:</td>".
            "<td class='lotteries_table_head'>Site Name:</td>".
            "<td class='lotteries_table_head'>Visit url:</td>".
            "<td>Logo url:</td>".
            "<td class='lotteries_table_head'>Other sites:</td>".
            "<td class='lotteries_table_head'>Domain registration date:</td>".
            "<td class='lotteries_table_head'>Number of lotteries:</td>".
            "<td class='lotteries_table_head'>Funding methods:</td>".
            "<td class='lotteries_table_head'>Languages:</td>".
            "<td class='lotteries_table_head'>Approved:</td><td></td></tr>";

        foreach ($data as $l) {
            echo "<tr><td>{$l->id}.</td>".
	    "<td>{$l->position}</td>".
            "<td>{$l->slug}</td>".
            "<td>{$l->site_name}</td>".
            "<td>{$l->visit_url}";
						if (isset($_GET['check_url'])) :
							$redirect_page=@file_get_contents($l->visit_url,false,null,0,500);
							if (!$redirect_page) {
								echo '<span style="color:brown;"> - website seems down!</span>';
							} else {
								if (strstr($redirect_page,'lottoexposed')) echo '<span style="color:red;"> - wrong url!</span>';
							}
						endif;
            echo "<td><img src='{$l->logo}'><br>{$l->logo}</td>".
            "<td>{$l->other_sites}</td>".
            "<td>{$l->longest_expiry}</td>".
            "<td>{$l->number_of_lotteries}</td>".
            "<td>{$l->funding_methods}</td>".
            "<td>{$l->languages}</td>".
            "<td>";
            if ($l->approved > 0) echo "Yes";
            if ($l->approved <= 0) echo "No";
            echo "</td>".
            "<td><form action='' method='GET'><input type='hidden' name='page' value='admin_lotteries'><input type='hidden' name='edit' value='{$l->id}'><input type='submit' value='Edit'></form></td>".
            "</tr>";
        }
    echo "</table></form><form action='' method='GET'><input type='hidden' name='page' value='admin_lotteries'><input type='hidden' name='add_form' value='1'><input type='submit' value='Add new'></form></p>";
    echo '</div>';
    echo '<form action="/wp-admin/admin.php" method="get"><input type="hidden" name="page" value="admin_lotteries"><input type="hidden" name="check_url" value="1"><input type="submit" value="Check urls"></form>';
    }
}
function view_lotteries_clicks(){
	global $wpdb;
?>
<style type="text/css">
	.table_width_border { border:1px solid #ccc; border-collapse:collapse; }
	.table_width_border td { border:1px solid #ccc; }
</style>
<?php	if (isset($_GET['lottery'])) { ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
 <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
	['Month and Year', 'Clicks',],
	<?php
	
	if (!isset($_GET['date'])) {
	$cur_month=date('Y-m-01');
	} else {
	$cur_month=$_GET['date'];
	}
	
	$lotteries=$wpdb->get_results($wpdb->prepare("SELECT date, clicks FROM {$wpdb->prefix}lotteries JOIN {$wpdb->prefix}lotteries_clicks ON id=lottery_id WHERE site_name=%s AND date = '".$cur_month."' ORDER BY date ASC",$_GET['lottery']));
	
	foreach ($lotteries as $l) {
		$date=explode('-',$l->date);

		$clicks = unserialize($l->clicks);
		
		$total = '';
		
			if ($clicks) {
			foreach($clicks as $c) {
			$total = $total + $c;
			}
			} else {
			$total = 0;
			}
		
		$monthName = date("F", mktime(0, 0, 0, intval($date[1])));
		if($clicks) {
		foreach($clicks as $day => $clicks) {
		echo "['".$day."',  ".$clicks."],";
		}
		}
	}
	?>]);

        var options = {
          title: 'Clicks by Month - <?php echo $monthName.' '.$date[0];?>',
          hAxis: {title: 'Days - <?php echo $monthName.' '.$date[0];?>', titleTextStyle: {color: 'red'}},
		  vAxis: {title: 'Clicks', titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
<div id="chart_div" style="width:100%;height:200px;"></div>
<table class="table_width_border">
<tr><td>Month</td><td>Total clicks</td></tr>
<?php
		$lotteries=$wpdb->get_results($wpdb->prepare("SELECT date, clicks FROM {$wpdb->prefix}lotteries JOIN {$wpdb->prefix}lotteries_clicks ON id=lottery_id WHERE site_name=%s ORDER BY date ASC",$_GET['lottery']));
		
		foreach ($lotteries as $l) {
			$date=explode('-',$l->date);
			$monthName = date("F", mktime(0, 0, 0, intval($date[1])));
			$clicks = unserialize($l->clicks);
			
			
			
			$total = '';
			
			if ($clicks) {
			foreach($clicks as $c) {
			$total = $total + $c;
			}
			} else {
			$total = 0;
			}
			
			echo '<tr><td><a href="admin.php?page=admin_lotteries_clicks&lottery='.$_GET['lottery'].'&date='.$l->date.'">'.$monthName.' '.$date[0].'</a></td><td>'.$total.'</td></tr>';
		}
?>
</table>
<?php	} else {
		$lotteries=$wpdb->get_results("SELECT id, site_name, approved FROM {$wpdb->prefix}lotteries ORDER BY site_name ASC");
		$dates=$wpdb->get_results("SELECT DISTINCT(date) FROM {$wpdb->prefix}lotteries_clicks ORDER BY date ASC") ?>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
 <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
	['Month and Year' <?php foreach ($lotteries as $l) { echo ',\''.$l->site_name.'\''; } ?>],
          <?php foreach ($dates as $d) {
						$date=strtotime($d->date);
						echo "['".date('F Y',$date)."',";
						foreach ($lotteries as $l) {
						$clicks=$wpdb->get_var("SELECT clicks FROM {$wpdb->prefix}lotteries_clicks WHERE lottery_id={$l->id} AND date='{$d->date}'");
							
						$clicks = unserialize($clicks);
						
						$total = '';
						
						if ($clicks) {
								foreach($clicks as $c) {
								$total = $total + $c;
								}
								} else {
								$total = 0;
						}
						
						echo $total.',';
						}
						echo "],";
					}?>]);

        var options = {
          title: 'Clicks by Month',
          hAxis: {title: 'Month and Year', titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
<div id="chart_div" style="width:100%;height:900px;"></div>

<script type='text/javascript'>
      google.load('visualization', '1', {packages:['table']});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Lottery');
				<?php 
				foreach ($dates as $d) {
					$date=strtotime($d->date);
					echo 'data.addColumn(\'number\',\''.date('M Y',$date).'\');';
				}
				?>
        data.addColumn('boolean', 'Approved');
        data.addRows([
        <?php foreach ($lotteries as $l) {
						echo "['<a href=\'admin.php?page=admin_lotteries_clicks&lottery={$l->site_name}\'>{$l->site_name}</a>',";
						foreach ($dates as $d) {
						$clicks=$wpdb->get_var("SELECT clicks FROM {$wpdb->prefix}lotteries_clicks WHERE lottery_id={$l->id} AND date='{$d->date}'");
						
						$clicks = unserialize($clicks);
						
						$total = '';
						
						if ($clicks) {
								foreach($clicks as $c) {
								$total = $total + $c;
								}
								} else {
								$total = 0;
						}
						
						echo $total.',';						
						}
						if ($l->approved) echo 'true'; else echo 'false'; echo '],';
				}?>
        ]);

        var table = new google.visualization.Table(document.getElementById('table_div'));
        table.draw(data, {showRowNumber: true, allowHtml:true});
      }
</script>
<div id="table_div" style="margin-bottom:20px;"></div>
<?php	
	}
}

add_shortcode('all_lotteries_table','showAllLotteriesTable');
function showAllLotteriesTable() {
    global $wpdb;
    $res=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}lotteries");
    $out="<table class='lotteries_table'>".
    "<tr><td class='lotteries_table_head'>Site name:</td>".
    "<td class='lotteries_table_head'>Alexa:</td>".
    "<td class='lotteries_table_head'>Visit url:</td>".
    "<td class='lotteries_table_head'>Logo source file:</td>".
    "<td class='lotteries_table_head'>Other sites:</td>".
    "<td class='lotteries_table_head'>Domain registration date:</td></tr>".
    "<td class='lotteries_table_head'>Number of lotteries:</td>".
    "<td class='lotteries_table_head'>Funding methods:</td>".
     "<td class='lotteries_table_head'>Languages:</td>".
    "<td class='lotteries_table_head'>Approved:</td></tr>";
    foreach ($res as $l):
        $out.="<tr><td colspan='2'><img src='{$l->logo}'></td>".
        "<td>{$l->site_name}</td>".
        "<td>{$l->alexa}</td>".
        "<td>{$l->visit_url}</td>".
        "<td>{$l->logo}".
        "<td>{$l->other_sites}</td>".
        "<td>{$l->longest_expiry}</td>".
        "<td>{$l->number_of_lotteries}</td>".
        "<td>{$l->funding_methods}</td>".
        "<td>{$l->languages}</td>".
        "<td><select name='approved'><option value='1'>Yes</option><option value='0'>No</option></select>".
        "</tr>";
    endforeach;
        $out.="</table>";
    
    return $out;
}
function show_review_table() {
    global $wpdb,$wp_query;
    $query_vars=explode('/',$_SERVER['REQUEST_URI']);
    $res=$wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}lotteries WHERE slug=%s",array($query_vars[1])),ARRAY_A);

			$columns=$wpdb->get_results("SHOW COLUMNS FROM  {$wpdb->prefix}lotteries ");
			$columns=array_slice($columns,1);
			
			$category=get_the_category();
			$table=$wpdb->get_var("SELECT content FROM {$wpdb->prefix}lotteries_tables WHERE category=".$category[0]->term_id);
			foreach ($columns as $col) {
							$table=str_replace('['.$col->Field.']',$res[$col->Field],$table);
			}
			if ($res['approved'] > 0) $approved_or_not='<span class="lotteries-list-title-approved"></span>'; else $approved_or_not='<span class="lotteries-list-title-not-approved"></span>'; 
			$table=str_replace('[approved_or_not]',$approved_or_not,$table);
			if ($res['approved']) {
					$visit_button="<a href='{$res['visit_url']}' class='lotteries-list-approved'></a>";
			} else {
				$visit_button="<a href='{$res['visit_url']}'>Visit the website &raquo;</a>";
			}
			$table=str_replace('[visit_button]',$visit_button,$table); 
			
			if ($res['rating_stars']) {
				$show_rating_stars='<div class="review_rating_stars">';
				for ($i=0;$i<=$res['rating_stars'];$i++) {
					$show_rating_stars.='<div class="review_rating_star"></div>'; 
				}
				$show_rating_stars.=' '.$res['rating_stars'].'/5</div>';
			} else {
				$show_rating_stars='';
			}
			$table=str_replace('[show_rating_stars]',$show_rating_stars,$table); 
			
			$table=str_replace('[logo_image]','<img src="'.$res['logo'].'" alt="'.$res['site_name'].'">',$table);?>
			<div id="lotteries-list-wrap">
        <div class='lotteries-list'>
					<?php echo $table; ?>
				</div>
			</div>
<?php
}
function show_lotteries_list() {
    global $wpdb;
    $result=$wpdb->get_results("SELECT * FROM {$wpdb->prefix}lotteries ORDER BY alexa ASC"); ?>
    <div id="lotteries-list-wrap">
    <?php foreach ($result as $res): ?>
        <div class='lotteries-list'>
            <div class='lotteries-list-header'><?php if ($res->approved > 0) echo '<span class="approved">Approved</span>'; else echo '<span class="not_approved">Not Approved</span>'; ?></div>
        <div class='lotteries-list-logo'><img src='<?php echo $res->logo; ?>' alt='<?php echo $res->site_name; ?>'></div>
        <div class='lotteries-list-table'>
            <div class='lotteries-list-item-row'><div class='lotteries-list-title'>Site Name:</div><?php echo $res->site_name; ?></div>
            <div class='lotteries-list-item-row'><div class='lotteries-list-title'>Alexa:</div><?php echo $res->alexa; ?></div>
            <div class='lotteries-list-links'><a href='<?php echo $res->visit_url; ?>'>Visit the website &raquo;</a><a href='/<?php echo $res->slug; ?>/'>Read the review &raquo;</a></div>
        </div>
        </div>
    <?php endforeach; ?>
    </div>
    <?php
}
function view_lotteries_review_table() {
	global $wpdb;
		switch ($_GET['act']) {
				case 'add_table':
					$q=$wpdb->prepare("INSERT INTO {$wpdb->prefix}lotteries_tables (id,title,category,content) VALUES ('',%s,%d,'')",$_POST['title'],$_POST['category']);
					$wpdb->query($q);
					echo '<script type="text/javascript">location.href="/wp-admin/admin.php?page=admin_lotteries_review_table&act=edit_table&id='.$wpdb->insert_id.'";</script>';
				break;
				
				case 'edit_table':
					$table=$wpdb->get_row("SELECT title,category,content FROM {$wpdb->prefix}lotteries_tables WHERE id=".intval($_GET['id']));?>
					<form action="/wp-admin/admin.php?page=admin_lotteries_review_table&act=update_table&id=<?php echo intval($_GET['id']); ?>" method="post">
						<table width="100%">
							<tr><td>ID</td><td><?php echo intval($_GET['id']); ?></td></tr>
							<tr><td>Title</td><td><input type="text" name="title" value="<?php echo $table->title;?>"></td></tr>
							<tr><td>Category</td><td><select name="category">
							<?php $categories=get_categories();
									foreach ($categories as $c) {
											($c->term_id == $table->category) ? $selected='selected=\'selected\'' : $selected='';
											echo "<option value='{$c->term_id}' {$selected}>{$c->name}</option>";
									}
							?>
						</select></td></tr>
							<tr><td>Content</td><td><?php the_editor($table->content,'content'); ?></td></tr>
							<tr><td></td><td><input type="submit" value="Save"></td></tr>
						</table>
					</form>
					<?php $columns=$wpdb->get_results("SHOW COLUMNS FROM  {$wpdb->prefix}lotteries ");
					$columns=array_slice($columns,1);?>
					<h2>Avaible fields:</h2>
					<div>[approved_or_not]</div>
					<?php foreach ($columns as $col) {
							echo "<div>[{$col->Field}]</div>";
					} ?>
					<div>[show_rating_stars]</div>
					<div>[visit_button]</div>
				<?php 
				break;
				
				case 'update_table':
					$q=$wpdb->prepare("UPDATE {$wpdb->prefix}lotteries_tables SET title=%s,category=%d,content=%s WHERE id=%d",$_POST['title'],$_POST['category'],$_POST['content'],$_GET['id']);
					$wpdb->query($q);
					echo '<script type="text/javascript">location.href="/wp-admin/admin.php?page=admin_lotteries_review_table&act=edit_table&id='.$_GET['id'].'";</script>';
				break;
				
				default: ?>
					<h2>Select a table</h2>
					<?php $tables=$wpdb->get_results("SELECT id,title FROM {$wpdb->prefix}lotteries_tables");?>
					<ul>
					<?php foreach ($tables as $t) {
						echo '<li><a href="/wp-admin/admin.php?page=admin_lotteries_review_table&act=edit_table&id='.$t->id.'">'.$t->title.'</a></li>';
					} ?>
					</ul>
					<br><br>
					<h2>Or create new</h2>
					<form action="/wp-admin/admin.php?page=admin_lotteries_review_table&act=add_table" method="post">
						<label>Name</label><input type="text" name="title">
						<label>Category</label>
						<select name="category">
							<?php $categories=get_categories();
									foreach ($categories as $c) {
											echo "<option value='{$c->term_id}'>{$c->name}</option>";
									}
							?>
						</select>
						<input type="submit" value="Create">
					</form>
					<?php
		}	
}
function view_lotteries_fields() {
	global $wpdb;
		switch ($_GET['act']) {
				case 'add_field':
					switch ($_POST['type']) {
							case 'int':
								$type='INT NOT NULL DEFAULT 0';
							break;
							case 'text':
								$type='MEDIUMTEXT NOT NULL DEFAULT \'\'';
							break;
							case 'float':
								$type='FLOAT NOT NULL DEFAULT 0';
							break;
						
					}
					if (preg_match('/^[a-z0-9_]+$/',$_POST['title'])) {
						$q="ALTER TABLE {$wpdb->prefix}lotteries ADD COLUMN {$_POST['title']} $type";
						$wpdb->query($q);
						echo '<script type="text/javascript">location.href="/wp-admin/admin.php?page=admin_lotteries_fields&act=edit_field&title='.$_POST['title'].'";</script>';
					} else echo 'wrong tablename';
					
				break;
				
				case 'edit_field': 
					$columns=$wpdb->get_results("SHOW COLUMNS FROM  {$wpdb->prefix}lotteries "); ?>
					<?php foreach ($columns as $col) {
							if ($col->Field == $_GET['title']) $column=$col;
					}
				?>
					<form action="/wp-admin/admin.php?page=admin_lotteries_fields&act=save_field" method="post" id="lotteries_create_field_form">
						<label>Name</label><input type="text" name="title" value="<?php echo $column->Field; ?>" id="lotteries_field_name">
						<input type="hidden" name="old_title" value="<?php echo $column->Field; ?>">
						<label>Type</label>
						<?php $my_types=array(array('text','Text'),array('int','Integer'),array('float','Float')); ?>
						<select name="type">
							<?php foreach ($my_types as $my_type) {
									(strstr($column->Type, $my_type[0])) ? $selected='selected="selected"' : $selected='';
									echo '<option value="'.$my_type[0].'" '.$selected.'">'.$my_type[1].'</option>';
								} ?>
						</select>
						<input type="submit" value="Save">
					</form>
					<script type="text/javascript">
						jQuery(document).ready(function(){
								jQuery("#lotteries_create_field_form").submit(function(e){
									var re=/^[0-9a-z_]+$/gi;
									if (!re.test(jQuery("#lotteries_field_name").val())) {
										 alert('Wrong field name. Only digits, letters and unserscores are allowed');
										 e.preventDefault();
										 return false;
									}
								});
						});
					</script><br><br>
					<form action="/wp-admin/admin.php?page=admin_lotteries_fields&act=remove_field&title=<?php echo $column->Field; ?>" method="post">
						<lable>Aattention! All data will be removed</lable>
					<input type="submit" value="Delete">
					</form>
				<?php
				break;
				case 'save_field':
					if (preg_match('/^[a-z0-9_]+$/',$_POST['old_title']) && preg_match('/^[a-z0-9_]+$/',$_POST['title'])) {
						switch ($_POST['type']) {
							case 'int':
								$type='INT NOT NULL DEFAULT 0';
							break;
							case 'text':
								$type='MEDIUMTEXT NOT NULL DEFAULT \'\'';
							break;
							case 'float':
								$type='FLOAT NOT NULL DEFAULT 0';
							break;
						
						}
						$q="ALTER TABLE {$wpdb->prefix}lotteries CHANGE {$_POST['old_title']} {$_POST['title']} $type";
						$wpdb->query($q);
						echo '<script type="text/javascript">location.href="/wp-admin/admin.php?page=admin_lotteries_fields&act=edit_field&title='.$_POST['title'].'";</script>';
					}
				break;
				
				case 'remove_field':
					if (preg_match('/^[a-z0-9_]+$/',$_GET['title'])) {
						$q="ALTER TABLE {$wpdb->prefix}lotteries DROP {$_GET['title']}";
						$wpdb->query($q);
						echo '<script type="text/javascript">location.href="/wp-admin/admin.php?page=admin_lotteries_fields";</script>';
					}
				break;
				
				default: ?>
					<h2>Select a field</h2>
					<?php $columns=$wpdb->get_results("SHOW COLUMNS FROM  {$wpdb->prefix}lotteries ");
					$columns=array_slice($columns,1);?>
					<?php foreach ($columns as $col) {
							echo "<li><a href='/wp-admin/admin.php?page=admin_lotteries_fields&act=edit_field&title={$col->Field}'>{$col->Field}</a></li>";
					}?>
					</ul>
					<br><br>
					<h2>Or create new</h2>
					<form action="/wp-admin/admin.php?page=admin_lotteries_fields&act=add_field" method="post" id="lotteries_create_field_form">
						<label>Name</label><input type="text" name="title" id="lotteries_field_name">
						<label>Type</label>
						<select name="type">
							<option value="text">Text</option>
							<option value="int">Integer</option>
							<option value="float">Float</option>
						</select>
						<input type="submit" value="Create">
					</form>
					<script type="text/javascript">
						jQuery(document).ready(function(){
								jQuery("#lotteries_create_field_form").submit(function(e){
									var re=/^[0-9a-z_]+$/gi;
									if (!re.test(jQuery("#lotteries_field_name").val())) {
										 alert('Wrong field name. Only digits, letters and unserscores are allowed');
										 e.preventDefault();
										 return false;
									}
								});
						});
					</script>
					<?php
		}	
}
?>
