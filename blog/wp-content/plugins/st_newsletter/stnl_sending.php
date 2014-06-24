<?php

function stnl_sending($nid, $type, $arg, $arg2=''){

	global $wpdb, $table_prefix, $stnl_config;

			

	$html = stnl_returnhtml($nid, $email);

	if($type == 'catsend'){

		$catid = $arg;
		$catsend = 1;
		$wpusers = $arg2;	

		$mlSQL = "SELECT * FROM ".$table_prefix."st_mailinglist WHERE st_status=1 ORDER BY st_email";

		$subscriber = $wpdb->get_results($mlSQL);

		if($catid != "allcats" && $catid != "wpusers"){
		
			foreach ($subscriber as $id=>$sub){
				$cats = explode('[|]', $sub->st_cat);
				foreach( $cats as $k=>$cat ){
					$ncat = str_replace("\r", '', $cat);
					$ncat = str_replace("\n", '', $ncat);
					$cats[$k] = trim($ncat);
				}
				if( !in_array( $catid, $cats ) ){
					unset($subscriber[$id]);
				}
			}
/*
			foreach($subscriber as $k=>$sub){
				$subcats = explode('[|]', $sub->st_cat);
				foreach($subcats as $scat){
					if($catid == $scat){
						$keep[] = $k;
					}
				}
			}
			//print_r($keep);
			foreach($subscriber as $ky=>$sb){			
				if(!in_array($ky, $keep)){
					//echo '<br />remove='.$ky.'<br />';
					unset($subscriber[$ky]);
				}
			}*/
		
		}
		if($catid == 'wp_users'){
			$mlSQL = "SELECT user_email FROM $wpdb->users ORDER BY user_email";
			$subscriber = $wpdb->get_results($mlSQL);
		}

		$countsubs = count($subscriber);
	
	
	}else if($type == 'emailsend'){

		$eid = $arg;

		$mlSQL = "SELECT * FROM ".$table_prefix."st_mailinglist WHERE st_status=1 AND st_id=".$eid;

		$subscriber = $wpdb->get_results($mlSQL);

		$countsubs = count($subscriber);
		
		$catsend = 0;

	}

	

	if ( count($subscriber) == 0 ) {

		echo '<div class="updated"><p><strong>'.__('Whoops! It seems there are no Subscribers to send to.', 'stnl').'</strong></p></div>';

	}else{

		

		// Flush all buffers

				ob_end_flush();  

				flush();

				

				$loopsize = $countsubs; 

				

				$imgfolder = get_option('home').'/wp-content/plugins/st_newsletter/img/';

				?>

				

<div class="wrap" >

	<span style="float:right;display:block;font-size:0.7em"><a href="#" style="text-decoration:none;" id="log-toggle"><?php _e('Show/Hide Swift Log','stnl');?></a></span><h2><?php  _e("Sending in Progress:", 'stnl');?> <?php echo $loopsize;?> <?php _e("Subscribers");?> </h2>
<br />
	<div style="z-index:1; text-align:center; font-weight:bold; padding-top:10px">

		<div class="mailbar" style="background-image: url('<?php echo $imgfolder;?>mailerbar-bg.gif');	background-repeat: no-repeat; height: 60px; width: 514px; margin-right: auto; margin-left: auto;">

			<div class="baritems" style="padding-top: 10px; padding-left: 7px; text-align: left;">	
					<?php //echo $loopsize; ?>
				  <?php stnl_swift_connect($nid, $subscriber, $html, $loopsize);
				  //foreach($subscriber as $sub){
				  	//echo $sub->st_email.'<br />';
				 // }
				  ?>

			</div>

		</div>

	</div>



<div id="status2" class="statusbox" style="z-index:2; text-align:center; font-weight:bold;">
<?php if($catsend==1){stnl_publishnewsletter($nid);}?>
<?php _e("Sending Complete!", 'stnl');?>

</div>

</div>

<?php

		}

	

}

?>