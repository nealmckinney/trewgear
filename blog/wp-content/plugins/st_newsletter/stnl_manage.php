<?php
function stnl_manage(){
global $table_prefix, $wpdb, $stnl_config;
	
$sl = $stnl_config['slashfix'];

if($_GET['edit_newsletter'] == true){
	stnl_editcreate($_GET['edit_newsletter']);
}else{
?>

<div class="wrap">
  	<h2><?php _e('Manage Newsletters', 'stnl');?></h2>

  	<fieldset class="options">
    
		<?php
		
		if(!isset($_GET['pg'])){
		$page = 1;
	} else {
		$page = $_GET['pg'];
	}
		// Define the number of results per page
		$max_results = 10; 
		
		// Figure out the limit for the query based
		// on the current page number.
		$from = (($page * $max_results) - $max_results);

		/* Fetch Newsletters */
			$SQL = "SELECT * FROM ".$table_prefix."st_newsletter ORDER BY st_date desc LIMIT ".$from.", ".$max_results;
		$newsletter = $wpdb->get_results($SQL);
		
		
		if ( count($newsletter) == 0 ) { ?>
		<p><?php _e('You have not created any Newsletters yet.', 'stnl');?></p>
		<?php } else{ ?>
<table class="widefat">
	<thead>
	<tr>
	<th scope="col" style="text-align: center;"><?php _e('ID', 'stnl');?></th>
       <th scope="col"><?php _e("Date", 'stnl');?></th> 
		<th scope="col"><?php _e("Title", 'stnl');?></th>
		<th scope="col"><?php _e("Category", 'stnl');?></th>
		 <th scope="col"><?php _e("Status", 'stnl');?></th>
        <th colspan="2" style="text-align: center;"><?php _e('Action', 'stnl');?></th>
	</tr>
	</thead><tbody id="the-list">
			<?php
			foreach ( $newsletter as $news ) : 
				$newdate = chunk_split($news->st_date, 2, '-');
				list($y, $year, $month, $day) = split('[/.-]', $newdate);
			$montharr = array( '', __('January', 'stnl'), __('February', 'stnl'), __('March', 'stnl'), __('April', 'stnl'), __('May', 'stnl'), __('June', 'stnl'), __('July', 'stnl'), __('August', 'stnl'), __('September', 'stnl'), __('October', 'stnl'), __('November', 'stnl'), __('December', 'stnl'));
			$nmonth = ltrim($month, "0");
			$day = ltrim($day, "0");
			$year = $y.$year;
			$news_date = $montharr[$nmonth].' '.$day.', '.$year;
			if($news->st_status == 0){$status=__("Draft", 'stnl');}
			if($news->st_status == 1){$status=__("Private", 'stnl');}
			if($news->st_status == 2){$status=__("Published", 'stnl');}
				$class = ('alternate' != $class) ? 'alternate' : ''; ?>
			  	<tr id='news-<?php echo $news->st_id; ?>' class='<?php echo $class; ?>'> 
				    <th scope="row" style="text-align:center;"><?php echo $news->st_id; ?></th> 
					<td><?php echo $news_date;?></td>
					<td><?php echo $news->st_title;?></td>
					<td><?php echo st_getcat($news->st_cat);?></td>
					<td><?php echo $status?></td>
                    <?php
					$check = 'admin.php';
				$page = $_SERVER['REQUEST_URI'];
				if(strpos($page, $check) === false){
					$page = $page.'admin.php';
				}?>
					<td><a href="<?php echo $page;?>&amp;edit_newsletter=<?php echo $news->st_id?>#edit" class="edit"><?php _e('Edit', 'stnl');?></a>
					<a href="<?php echo $page;?>&amp;delete_newsletter=<?php echo $news->st_id?>" class="delete" onclick="return confirm('<?php _e('You are about to delete the newsletter', 'stnl');?> \'<?php echo $news->st_title;?>\'\n  <?php _e('OK to delete, Cancel to stop.', 'stnl');?>')"><?php echo _e('Delete', 'stnl');?></a></td>
			  	</tr>
			<?php
			endforeach; ?>
			</tbody></table> 
		<?php 	
		
		// Figure out the total number of results in DB:
		$SQL = "SELECT st_id FROM ".$table_prefix."st_newsletter";
		$st_nl = $wpdb->get_results($SQL);
		$total_results = count($st_nl);
		
		// Figure out the total number of pages. Always round up using ceil()
		$total_pages = ceil($total_results / $max_results);
	
		// Build Page Number Hyperlinks
		// Build Previous Link
		if ($total_pages > 1){
			if($page > 1){
				$prev = ($page - 1);
				$output_page .= "<a href=\"".st_uri()."&pg=$prev\">&laquo; ".__("Previous", 'stnl')."</a> &nbsp;";
			}
		
			for($i = 1; $i <= $total_pages; $i++){
				if(($page) == $i){
					$output_page .= "&nbsp; $i &nbsp;";
				} else {
					$output_page .= "&nbsp; <a href=\"".st_uri()."&pg=$i\">$i</a> &nbsp;";
				}
			}
		
			// Build Next Link
			if($page < $total_pages){
				$next = ($page + 1);
				$output_page .= "&nbsp; <a href=\"".st_uri()."&pg=$next\">".__("Next", 'stnl')." &raquo;</a>";
			}
		}
	}
		echo $output_page;
		?>
	</fieldset>
</div>
<?php
	}
}

function stnl_editcreate($id){
	global $table_prefix, $wpdb, $userdata, $stnl_config;
	$sl = $stnl_config['slashfix'];
 ?>

<?php $h2 = __("Edit Newsletter", 'stnl');?>
<?php echo stnl_editing($id, $h2); ?>

<?php
}
?>