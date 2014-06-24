<?php
function stnl_subscribers(){
global $table_prefix, $wpdb, $stnl_config;

	if ($_POST['delete_checked'] == true){
		foreach ($_POST as $key => $value){
			$dSQL = "DELETE FROM ".$table_prefix."st_mailinglist WHERE st_id = '$key'";
			$wpdb->query($dSQL);
		}
	}
	if ($_POST['delete_all'] == true){
		$dSQL = "TRUNCATE TABLE ".$table_prefix."st_mailinglist ";
		$wpdb->query($dSQL);
	}
	if($_POST['delete_dupes'] == true){
		$allsubs = $wpdb->get_results("SELECT st_email, st_id FROM ".$table_prefix."st_mailinglist");
		foreach($allsubs as $i=>$sub){
	
			$dupe = $wpdb->get_var("SELECT st_id FROM ".$table_prefix."st_mailinglist WHERE st_email = '".$sub->st_email."' AND st_id != ".$sub->st_id);
			if($dupe){
				$safe[] = $sub->st_id;
				if(!in_array($dupe, $safe)){
					$dSQL = "DELETE FROM ".$table_prefix."st_mailinglist WHERE st_id = '$dupe'";;
					$wpdb->query($dSQL);		
				}	
			}
		}
		
	}



 if ( !isset($_GET['edit_st_email']) ) { ?>
<div class="wrap">
  	<h2><?php _e('Find A Subscriber', 'stnl');?></h2>

		<fieldset class="options">
			<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>">
			
			<label for="stnl_search_email"><?php _e('Email', 'stnl');?>: </label> <input name="stnl_search_email" id="stnl_search_email" type="text" style="width:193px;" value="<?php if (isset($_POST['stnl_search_email'])) echo htmlspecialchars($_POST['stnl_search_email']); ?>" />  <input type="submit" name="Submit" value="<?php _e('Search Email', 'stnl');?> &raquo;" />

			</form>
		</fieldset>
</div>

<div class="wrap">
  	<h2><?php _e('Subscribers', 'stnl');?></h2>
	  	
	  	<fieldset class="options">
    
		<?php
		if(!isset($_GET['pg'])){
		$page = 1;
	} else {
		$page = $_GET['pg'];
	}
		// Define the number of results per page
		if($stnl_config['subpages'] != ''){
			$max_results = $stnl_config['subpages'];
		}else{
			$max_results = 25;
		}
		
		// Figure out the limit for the query based
		// on the current page number.
		$from = (($page * $max_results) - $max_results);

		/* Fetch MailingList */
			$SQL  = "SELECT * FROM ".$table_prefix."st_mailinglist WHERE 1=1 ";
			if (isset($_POST['stnl_search_email']) && !empty($_POST['stnl_search_email'])) {
				$SQL .= " AND st_email LIKE '%".$wpdb->escape(trim($_POST['stnl_search_email']))."%'";
			}
			$SQL .= "ORDER BY st_status, st_email asc LIMIT ".$from.", ".$max_results;
		$st_mailinglist = $wpdb->get_results($SQL);
		
		//$st_mailinglist = $wpdb->get_results("SELECT * FROM " . $table_prefix . "st_mailinglist ORDER BY st_id desc LIMIT ".$from.", ".$max_results);
		
		if ( count($st_mailinglist) == 0 ) { ?>
		<p><?php _e('No Subscribers corresponding to your search or no subscribers yet.', 'stnl');?></p>
		<?php } else{ ?>
        <script type="text/javascript">

function verify(){
	msg = "<?php _e('Are you absolutely sure that you want to delete these subscribers? Have you backed up your subscribers just in case?','stnl');?>";
    return confirm(msg);
    }
</script>

		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>" onsubmit="return verify()">

       <div>
     <label for="chk_all_1"><input type="checkbox" id="chk_all_1" onchange="checkAll(this);" /> <?php _e('Check/Uncheck All', 'stnl');?></label>
   </div>
		
	<table class="widefat">
	<thead>
	<tr>
	<th scope="col"></th>
       <th scope="col"><?php _e('Email', 'stnl');?></th>
				<th scope="col"><?php _e('Status', 'stnl');?></th>
				<?php if($stnl_config['cats'] == true){ ?>
				<th scope="col"><?php _e('Categories', 'stnl');?></th> 
				<?php } ?>				
				<th scope="col"><?php _e('Subscribe IP', 'stnl');?></th> 
				<th scope="col"><?php _e('Subscribe Date', 'stnl');?></th> 
        <th colspan="2" style="text-align: center;"><?php _e('Action', 'stnl');?></th>
	</tr>
	</thead><tbody id="the-list">
			<?php
		
			foreach ( $st_mailinglist as $mailinglist ) : 
			
				$class = ('alternate' != $class) ? 'alternate' : ''; ?>
			  	<tr id='mailinglist-<?php echo $mailinglist->st_id; ?>' class='<?php echo $class; ?>'> 
				    <th scope="row" style="text-align:center;"><input name="<?php echo $mailinglist->st_id; ?>" type="checkbox" id="chk_<?php echo $mailinglist->st_id; ?>" /></th> 
					<td><?php echo $mailinglist->st_email;?></td>
					<td><?php if ($mailinglist->st_status == 1){_e('Confirmed');} else {_e('Unconfirmed');} ?></td>
					<?php if($stnl_config['cats'] == true){ 
					echo "<td> <ul>";
							if ($stnl_config['cats'] != ''){
								$cats = explode('[|]', $mailinglist->st_cat);
								
								foreach($cats as $cat){				
									 echo '<li><small>'.st_catname($cat).'</small></li>';
								}
							}else{
								echo '<li>'.st_catname('0')."</li>";
							}
						echo "</ul></td>";
					 } ?>
					
					<td><?php if($mailinglist->st_status == 1){ echo $mailinglist->st_confip; }else{ echo $mailinglist->st_subip;}?></td>
					<td><?php if($mailinglist->st_status == 1){ echo $mailinglist->st_confdate;}else{echo $mailinglist->st_subdate;}?></td>	
					<td>
					<a href="<?php echo stnl_uri('subscribers-newsletter').'&amp;edit_st_email='.$mailinglist->st_id;?>#edit" class="edit"><?php _e('Edit');?></a>
					<a href="<?php echo stnl_uri('subscribers-newsletter').'&amp;delete_st_email='.$mailinglist->st_id;?>" class="delete" onclick="return confirm('<?php _e('You are about to delete this email', 'stnl');?> \'<?php echo $mailinglist->st_email;?>\' \n  <?php _e("\'OK\' to delete, \'Cancel\' to stop.", 'stnl');?>')"><?php _e('Delete', 'stnl');?></a></td>
			  	</tr>
			<?php
			endforeach; ?>
			</tbody></table> 
             <div>
     <label for="chk_all_2"><input type="checkbox" id="chk_all_2" onchange="checkAll(this);" /> <?php _e('Check/Uncheck All', 'stnl');?></label>
   </div>
<p>
			<input type="submit" name="delete_checked" class="delete" value="<?php _e('Delete All Checked', 'stnl');?>" />  
            <input type="submit" name="delete_all" class="delete" value="<?php _e('Delete All Subscribers', 'stnl');?>" />  
            <input type="submit" name="delete_dupes" class="delete" value="<?php _e('Delete All Duplicates', 'stnl');?>" />
</p>
			</form>
		
			
		<?php 	
		
		// Figure out the total number of results in DB:
		$SQL = "SELECT st_id FROM ".$table_prefix."st_mailinglist WHERE 1=1 ";
		if (isset($_POST['stnl_search_email']) && !empty($_POST['stnl_search_email'])) {
			$SQL .= " AND st_email LIKE '%".$wpdb->escape(trim($_POST['stnl_search_email']))."%'";
		}
		$st_ml = $wpdb->get_results($SQL);
		$total_results = count($st_ml);
		
		// Figure out the total number of pages. Always round up using ceil()
		$total_pages = ceil($total_results / $max_results);
	
		// Build Page Number Hyperlinks
		// Build Previous Link
		if ($total_pages > 1){
			if($page > 1){
				$prev = ($page - 1);
				$output_page .= "<a href=\"".get_option('site_url').$_SERVER['REQUEST_URI']."&amp;pg=$prev\">&laquo; ".__('Previous', 'stnl')."</a> &nbsp;";
			}
		
			for($i = 1; $i <= $total_pages; $i++){
				if(($page) == $i){
					$output_page .= "&nbsp; $i &nbsp;";
				} else {
					$output_page .= "&nbsp; <a href=\"".get_option('site_url').$_SERVER['REQUEST_URI']."&amp;pg=$i\">$i</a> &nbsp;";
				}
			}
		
			// Build Next Link
			if($page < $total_pages){
				$next = ($page + 1);
				$output_page .= "&nbsp; <a href=\"".get_option('site_url').$_SERVER['REQUEST_URI']."&amp;pg=$next\">".__('Next', 'stnl')." &raquo;</a>";
			}
		}
	}
		echo $output_page;
		?>
		</fieldset>
	</div>

	<div class="wrap">
		<h2><?php _e('Delete A Subscriber', 'stnl');?></h2>
		<?php
	if ($_GET['email_delete'] == true){
		global $wpdb, $table_prefix;
			$email = $_POST['edelete'];
		// Delete Record from meta and data table
		$SQL = "DELETE FROM ".$table_prefix."st_mailinglist WHERE st_email = '$email'";
		if ( !$wpdb->query($SQL) ) {
			_e('<p><strong>Failed to delete subscriber. This email is not in the Mailing List. Please make sure the email address is correct.</strong></p>', 'stnl');
		}else{
		echo '<p><strong>'.$email.'</strong> '.__('has been successfully removed from the Mailing List!', 'stnl').'</p>';
		}
	}
	
	?>
	
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>&amp;email_delete=true"> 
		<br />
		<label><?php _e('Delete this E-mail Address:', 'stnl');?> <input type="text" size="20" name="edelete" style="padding:0.2em;" /> </label>
		<input type="submit" class="delete" value="<?php _e('Delete', 'stnl'); ?>" onclick="return confirm('<?php _e('You are about to delete this subscriber \n  \\\'OK\\\' to delete, \\\'Cancel\\\' to stop.', 'stnl');?>')" />
		<br /><br />
	</form>
	</div>

	
	
	
	<?php
	}
	// EDITING
	$etitle = __('Add New Subscriber', 'stnl');
if ( isset($_GET['edit_st_email']) ) {
	$edit_st_mailinglist = (int) $_GET['edit_st_email'];
	$e_sql = "SELECT * FROM " . $table_prefix . "st_mailinglist WHERE st_id=".$edit_st_mailinglist;
	$e_mailinglist = $wpdb->get_row($e_sql);
	//print_r($e_mailinglist);
	$etitle = __('Edit Subscriber', 'stnl');
}		
	if ($_POST['stnl_email'] == true) {
		
		if($_POST['stnl_id'] == true){
			stnl_update_subscriber();
			echo "<div class='updated'><p><strong>".__('Subscriber Updated', 'stnl')."</strong> <small> ( <a href='".stnl_uri('subscribers-newsletter')."'>".__('Refresh', 'stnl')."</a> )</small></p></div>";
		}else{
			stnl_add_subscriber();
			echo "<div class='updated'><p><strong>".__('Subscriber Saved', 'stnl')."</strong> <small> ( <a href='".stnl_uri('subscribers-newsletter')."'>".__('Refresh', 'stnl')."</a> )</small></p></div>";
		}
}

?>
		<div class="wrap">
		<h2 id="edit"><?php echo $etitle;?></h2>

	  	<form method="post" action="<?php echo stnl_uri('subscribers-newsletter');?>">
	    	<input type="hidden" name="st_mailinglist_submit" value="true" />
		<?php if($_GET['edit_st_email'] == true){?>
			<input name="stnl_id" type="hidden" value="<?php echo $e_mailinglist->st_id; ?>" />
		<?php }	?>
	    	<p><label for="stnl_email"><?php _e('Email', 'stnl');?>: </label><br />
			   <input name="stnl_email" id="stnl_email" type="text" style="width:193px;" value="<?php echo $e_mailinglist->st_email; ?>" /> <?php echo stripslashes($stnl_config['req']);?></p>
	
		<?php echo stnl_extras($e_mailinglist->st_extras);?>
		
		<p><label for="stnl_cats"><?php _e('Categories', 'stnl');?>:</label> <br />
	<select multiple="multiple" name="stnl_cats[]" id="stnl_cats" style="width:200px;height:100px;" >
		<?php 
		if($e_mailinglist->st_cat != ''){
			echo st_catoptions($e_mailinglist->st_cat);
		}else{
			echo st_catoptions(st_defaultcatid());
		} ?>
		</select></p>
	    	<p class="submit">
	      		<input type="submit" name="Submit" value="<?php _e('Save Email', 'stnl');?> &raquo;" />
	    	</p>
	  	</form>
		</div>


	
<?php 
}
?>