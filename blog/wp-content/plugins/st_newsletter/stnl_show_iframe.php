<?php

function stnl_show_iframe($nid) {

	

	global $wpdb, $table_prefix, $stnl_config;

	$showme = $stnl_config['minlevel'];
	if($showme == ''){
		$showme = 10;
	}

	if(!isset($_GET['page'])){

		$page = 1;

	} else {

		$page = $_GET['page'];

	}



	if(!isset($_GET['newsletter']) && !isset($_GET['preview'])){



		// Define the number of results per page

		$max_results = $stnl_config['maxpages']; 

		

		// Figure out the limit for the query based

		// on the current page number.

		$from = (($page * $max_results) - $max_results);



		/* Fetch newsletter */

		$SQL = "SELECT * FROM ".$table_prefix."st_newsletter ORDER BY st_date desc LIMIT ".$from.", ".$max_results;

		$newsletter = $wpdb->get_results($SQL);

		$output_page .="<h2>".__('Newsletter Archive', 'stnl')."</h2>";

		

		/* Start processing data */	

		if ( count($newsletter) == 0 ) {

			$output_page .= '<i>'.$stnl_config['empty'].'</i>';

		} else	 {

			foreach ( $newsletter as $news ) {	

				

					$class = ('alt' != $class) ? 'alt' : ''; 

					$newdate = chunk_split($news->st_date, 2, '-');

						list($y, $year, $month, $day) = split('[/.-]', $newdate);

					$montharr = array( '', __('January', 'stnl'), __('February', 'stnl'), __('March', 'stnl'), __('April', 'stnl'), __('May', 'stnl'), __('June', 'stnl'), __('July', 'stnl'), __('August', 'stnl'), __('September', 'stnl'), __('October', 'stnl'), __('November', 'stnl'), __('December', 'stnl'));

					$month = ltrim($month, "0");

					$day = ltrim($day, "0");

					$year = $y.$year;

					$news_date = $montharr[$month].' '.$day.', '.$year;

					$status = $news->st_status;

					get_currentuserinfo(); 

				if ($status == 2){	

					$output_page .= '<div class="entrytext yb"><strong><a href="'.get_option('home').'/wp-content/plugins/st_newsletter/stnl_iframe.php?newsletter='.$news->st_id.'" title="'.$news->st_title.'" target="_blank">'.$news->st_title.'</a></strong> <small>'.__('(Sent on ', 'stnl').$news_date.')</small></div>';	

				} elseif($status < 2){

					if (current_user_can('level_'.$showme)){	

						if ($status == 0){$state = "<span style='color:#172973'>[Draft]</span>";}

						elseif ($status == 1){$state = "<small>".__("(Sent on ", 'stnl').$news_date.")</small><span style='color:#FF0000'>[".__('Private', 'stnl')."]</span>";}

						$output_page .= '<div class="entrytext yb"><strong><a href="'.get_option('home').'/wp-content/plugins/st_newsletter/stnl_iframe.php?newsletter='.$news->st_id.'" title="'.$news->st_title.'" target="_blank">'.$news->st_title.'</a></strong> '.$state.'</div>';	

					}

				}		

				

		}



		// Figure out the total number of results in DB:

		$total_results = $wpdb->get_var("SELECT COUNT(st_id) FROM ".$table_prefix."st_newsletter");

		

		// Figure out the total number of pages. Always round up using ceil()

		$total_pages = ceil($total_results / $max_results);

		

		// Build Page Number Hyperlinks

		// Build Previous Link

		if ($total_pages > 1){

			if($page > 1){

				$prev = ($page - 1);

				$output_page .= "<a href=\"?page=$prev\">&laquo; ".__('Previous', 'stnl')."</a> &nbsp;";

			}

		

			for($i = 1; $i <= $total_pages; $i++){

				if(($page) == $i){

					$output_page .= "&nbsp; $i &nbsp;";

				} else {

					$output_page .= "&nbsp; <a href=\"?page=$i\">$i</a> &nbsp;";

			}

		}

		

		// Build Next Link

		if($page < $total_pages){

			$next = ($page + 1);

			$output_page .= "&nbsp; <a href=\"?page=$next\">".__('Next', 'stnl')." &raquo;</a>";

		}

	}

	



	}	

	echo $output_page;

	} else { 

		//$nid = $_GET['newsletter'];

		//if($nid == ''){$nid = $_GET['preview'];}

		

		$code = $_GET['code'];

		$page = stnl_returnhtml($nid);

		$page = preg_replace("[{nid}]", $nid, $page);

		$page = preg_replace("[{code}]", $code, $page);

		echo $page;

		

	}

}

?>