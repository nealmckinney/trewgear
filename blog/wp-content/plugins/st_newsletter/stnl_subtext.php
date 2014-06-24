<?php

function stnl_subtext(){

	global $wpdb, $table_prefix, $stnl_config;

	
	$fields = $stnl_config['subscribefields'];

	$fieldmix = explode('[|]', $fields);

	$multi = count($fieldmix);

	foreach($fieldmix as $f){

		$new = explode('[*]', $f);

		$farr = array('label' => $new[0], 'required' => $new[1]);

		$fieldarr[] = $farr;

	}

	//print_r($fieldarr);

	$fieldcount = count($fieldarr);

	//echo $fieldcount;

	$i = 1;

	if($fieldcount >= 1){

		foreach ($fieldarr as $row){

			//print_r($row);

			$label = $row['label'];
			$tag = str_replace(' ', '', $label);

			if($label != ''){
				$taginfo .= "<li><strong>{".$tag."}</strong> - Subscriber's ".$label.".</li>"."\n";
			}
		}
	}
	// Make sure we have the freshest copy of the options

	$stnl_textconfig = get_option('stnl_textconfig');
	$showme = $stnl_config['minlevel'];
	if($showme == ''){
		$showme = 10;
	}
	// Default options configuration page

	if ( !isset($_GET['error']) && current_user_can('level_'.$showme) ) {

		?>

		<div class="wrap">

		  	<h2><?php _e('Dynamic Text Tags', 'stnl');?></h2>
			<ul>
			   <?php _e("<li><strong>{presubject}</strong> - The Pre-Subject you set in the Newsletter Options Page</li>

						<li><strong>{list_name}</strong> - The Mailing List Name you set below</li>

						<li><strong>{verify_link}</strong> - Prints the verification link needed to enable the subscription.  This needs to be included somewhere in the Opt-In Message or you won't get many subscribers!</li>

						<li><strong>{resend_link}</strong> - Link that will resend verification email.  This can be used only in Duplicate Address (unverified)</li>

						<li><strong>{retrieve_account}</strong> - Link that will send account management email.  This can be used only in Duplicate Address (verified)</li>

						<li><strong>{account_link}</strong> - Link to the subscription account management page.  This can be used only in Retrieve Account Link Message</li>", 'stnl');
						echo $taginfo;
						
						?>
                 </ul>
					<p>&nbsp;</p>

			<h2><?php _e('Edit Subscription Text', 'stnl');?></h2>	
            <?php
					$check = 'admin.php';
				$page = $_SERVER['REQUEST_URI'];
				if(strpos($page, $check) === false){
					$page = $page.'admin.php';
				}?>		

		  	<form method="post" action="<?php echo $page;?>">

		    	<input type="hidden" name="newsletter_submit_textoptions" value="true" />

	<table class="optiontable"> 



		<tr valign="top"> 

		<th scope="row"><label for="listname"><?php _e('Mailing List Name:', 'stnl');?></label></th>

		<td><input type="text" name="stn_listname" id="listname" value="<?php echo stripslashes($stnl_textconfig['listname']);?>" size="50"  /></td>

		</tr>

		

		<tr valign="top"> 

		<th scope="row"><label for="optsubject"><?php _e('Opt-In Subject:', 'stnl');?></label></th>

		<td><input type="text" name="stn_optsubject" id="optsubject" value="<?php echo stripslashes($stnl_textconfig['optsubject']);?>" size="50"  /></td>

		</tr>

		

	<tr valign="top"> 

		<th scope="row"><label for="optmessage"><?php _e('Opt-In Message:', 'stnl');?></label></th>

		<td><textarea style="width:95%; height:200px;" id="optmessage" name="stn_optmessage"><?php echo stripslashes($stnl_textconfig['optmessage']);?></textarea></td>

		</tr>

		

	<tr valign="top"> 

		<th scope="row"><label for="optsuccess"><?php _e('Success Message:', 'stnl');?></label></th>

		<td><textarea style="width:95%; height:50px;" id="optsuccess" name="stn_optsuccess"><?php echo stripslashes($stnl_textconfig['optsuccess']);?></textarea></td>

		</tr>

		

	<tr valign="top"> 

		<th scope="row"><label for="dupeunv"><?php _e('Duplicate Address (unverified):', 'stnl');?></label></th>

		<td><textarea style="width:95%; height:50px;" name="stn_dupeunv"><?php echo stripslashes($stnl_textconfig['dupeunv']);?></textarea></td>

		</tr>

		

	<tr valign="top"> 

		<th scope="row"><label for="dupev"><?php _e('Duplicate Address (verified):', 'stnl');?></label></th>

		<td><textarea style="width:95%; height:50px;" id="dupev" name="stn_dupev"><?php echo stripslashes($stnl_textconfig['dupev']);?></textarea></td></tr>

		

	<tr valign="top"> 

		<th scope="row"><label for="retrieve"><?php _e('Retrieve Account Link Message:', 'stnl');?></label></th>

		<td><textarea style="width:95%; height:50px;" id="retrieve" name="stn_retrieve"><?php echo stripslashes($stnl_textconfig['retrieve']);?></textarea></td>

		</tr>

		

	</table>	

			    <p class="submit">

			      	<input type="submit" name="Submit" value="<?php _e('Update Subscription Text &raquo;', 'stnl');?>" />

			    </p>

			</form>

		

			

			

		

		

	

<h2><?php _e('Instructions', 'stnl');?></h2>

<?php _e('See <a href="http://docs.shiftthis.net/wordpress_newsletter_plugin">Full Documentation</a> for complete instructions or visit the <a href="http://support.shiftthis.net/">Support Forums</a> for further help (You will need to login to view the Owners Support Forum).', 'stnl');?>

		

</div>
<?php

	} // End If 
}
?>