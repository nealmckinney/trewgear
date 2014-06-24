<?php

function stnl_preview(){

	global $wpdb, $table_prefix, $stnl_config;

	

	$sl = $stnl_config['slashfix'];





if($_GET['preview'] == true){

	stnl_send($_GET['preview']);

}else{

	

	?><div class="wrap">

	<h2><?php _e('Select Newsletter', 'stnl');?></h2>

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

					<td><a href="<?php echo $page;?>&amp;preview=<?php echo $news->st_id?>" class="edit"><?php _e('Preview/Send', 'stnl');?></a>

</td>

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

function stnl_send($id){

	global $table_prefix, $wpdb, $userdata, $stnl_config;

	$sl = $stnl_config['slashfix'];

	

	if($_POST['send_cat'] == true){

		$cats = $_POST['cats'];

		$wpusers = $_POST['wpusers'];

		stnl_sending($id, 'catsend', $cats, $wpusers);

	}else if($_POST['send_single'] == true){

		$email= $_POST['email'];

		stnl_sending($id, 'emailsend', $email);

	}

 ?>

<div class="wrap">

	<h2><?php _e("Preview/Send Newsletter", 'stnl');?></h2>

	<p></p>

	<form action="" method="post" id="your-profile">

	<?php stnl_send_options($id);?>

	</form>

	</div><div class="wrap">

<h2><?php _e("Newsletter Preview", 'stnl');?></h2>

	<iframe src="<?php echo get_option('siteurl');?>/wp-content/plugins/st_newsletter/stnl_iframe.php?newsletter=<?php echo $id;?>" width="100%" height="600px" />



</div>

<?php

}



function stnl_send_options($id){

	

	?>

	<fieldset>

		<legend><?php _e("Send to Subscribers", 'stnl');?></legend>

		<p><?php _e('This will send your newsletter to its current subscribers.  This is based upon the newsletter category matching the subscribers category.  If you would like to override this default setting, select an alternative category below or choose "send to all".', 'stnl');?></p>

		<p><label><strong><?php _e('Category', 'stnl');?>:</strong> <select name="cats"><?php echo stnl_getcats($id);?>

		
        <option value="allcats">[--<?php _e('All Categories', 'stnl');?>--] [<?php echo cat_count();?>]</option>
		<option value="wpusers">[--<?php _e('All WordPress Users', 'stnl');?>--] [<?php echo wp_count();?>]</option>
		</select></label></p>

		<!-- COMING SOON! <p><label><input style="width:20px;" type="checkbox" name="wpusers" value="yes" /><strong> <?php _e('Include all WP Users.', 'stnl');?></strong></label> -->

		<p><input type="submit" value="<?php _e('SEND', 'stnl');?>" name="send_cat" /></p> 

	</fieldset>

	

	<fieldset>

		<legend><?php _e('Send to Single Email', 'stnl');?></legend>

		<p><?php _e("This will send your newsletter to a single email address in your subscriber base. If you would like to send it to yourself you will need to", 'stnl');?> <a href="<?php echo stnl_uri('subscribers-newsletter');?>"><?php _e("subscribe your address</a> to the mailing list.", 'stnl');?></p>

		

		<p><label><strong><?php _e("Select Email:", 'stnl');?></strong> <select name="email"><?php echo stnl_getsubscribers();?></select></label></p>

		<p><input type="submit" value="<?php _e('SEND', 'stnl');?>" name="send_single" /></p>

	

	</fieldset>

	<br clear="all" />

&nbsp;

	<?php

}

?>