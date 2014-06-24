<?php

function stnl_options(){

	global $wpdb, $table_prefix;

	

	if($_POST['upgrade'] == true){

		stnl_dbupgrade_check_nl();

		stnl_dbupgrade_check_ml();

		echo '<div class="updated"><p>'.__('Your Database has been upgraded', 'stnl').'</p></div>';

	}

	

	// Make sure we have the freshest copy of the options

	$stnl_config = get_option('stnl_config');
	$showme = $stnl_config['minlevel'];
	if($showme == ''){
		$showme = 10;
	}
	

	$sl = $stnl_config['slashfix'];

	//st_upgradecheck(); 

			

	$formRepeat = '<div id="readroot" style="display:none;">

	<input type="button" value="X"

		onclick="this.parentNode.parentNode.removeChild(this.parentNode);" />

	<input name="label" id="label" type="text" />	<label for="required">'.__('Required?', 'stnl').'</label> 

	<select name="required" id="required"><option  value="Yes">'.__('Yes', 'stnl').'</option><option value="No">'.__('No', 'stnl').'</option> </select>

	<br />

</div>';



	// Default options configuration page
	if ( !isset($_GET['error']) && current_user_can('level_'.$showme) ) {

		?>

        <?php stnl_dbupgrade_check();?>

		<div class="wrap">

        

		  	<h2><?php _e("Newsletter Options", 'stnl');?></h2>

			<?php echo $formRepeat; ?>
            
            <?php 
				$check = 'admin.php';
				$optionpage = $_SERVER['REQUEST_URI'];
				if(strpos($optionpage, $check) === false){
					$optionpage = $optionpage.'admin.php';
				}
			
			?>

		  	<form method="post" action="<?php echo $optionpage;?>">

		    	<input type="hidden" name="newsletter_submit_options" value="true" />
                 <p class="submit">

			      	<input type="submit" name="Submit" value="<?php _e('Update Options &raquo;', 'stnl');?>" />

			    </p>

		  <table class="optiontable"> 



		<tr valign="top"> 

		<th scope="row"><label for="minlevel"><?php _e("Minimum User Level for Newsletter Management:", 'stnl');?></label></th>

		<td><select name="stn_minlevel" id="minlevel">

						<option value="10" <?php if ($stnl_config['minlevel'] == 10){echo 'selected="selected"';}?>>10 - <?php _e("Administrator", 'stnl');?></option>

						<option value="7" <?php if ($stnl_config['minlevel'] == 7){echo 'selected="selected"';}?>>7 - <?php _e("Editor", 'stnl');?></option>

						<option value="2" <?php if ($stnl_config['minlevel'] == 2){echo 'selected="selected"';}?>>2 - <?php _e("Author", 'stnl');?></option>

						<option value="1" <?php if ($stnl_config['minlevel'] == 1){echo 'selected="selected"';}?>>1 - <?php _e("Contributor", 'stnl');?></option>

						<option value="0" <?php if ($stnl_config['minlevel'] == 0){echo 'selected="selected"';}?>>0 - <?php _e("Subscriber", 'stnl');?></option>

					</select></td>

				</tr>

                

                <tr valign="top"> 

		<th scope="row"><label for="template"><?php _e("Default Newsletter Template:", 'stnl');?></label></th>

		<td><select name="stn_template" id="template">

						<?php echo stnl_get_template($stnl_config['template']);?>

					</select></td>

				</tr>

					

				<tr valign="top"> 

		<th scope="row"><label for="boxes"><?php _e('Maximum number of Side Boxes for Newsletter:', 'stnl');?></label></th>

			   <td><select name="stn_boxes" id="boxes">

					<option value="0" <?php if ($stnl_config['boxes'] == '0'){echo 'selected="selected"';} ?>>0</option>

					<option value="1" <?php if ($stnl_config['boxes'] == '1'){echo 'selected="selected"';} ?>>1</option>

					<option value="2" <?php if ($stnl_config['boxes'] == '2'){echo 'selected="selected"';} ?>>2</option>

					<option value="3" <?php if ($stnl_config['boxes'] == '3'){echo 'selected="selected"';} ?>>3</option>

					<option value="4" <?php if ($stnl_config['boxes'] == '4'){echo 'selected="selected"';} ?>>4</option>

					<option value="5" <?php if ($stnl_config['boxes'] == '5'){echo 'selected="selected"';} ?>>5</option>

					<option value="6" <?php if ($stnl_config['boxes'] == '6'){echo 'selected="selected"';} ?>>6</option>

					<option value="7" <?php if ($stnl_config['boxes'] == '7'){echo 'selected="selected"';} ?>>7</option>

					<option value="8" <?php if ($stnl_config['boxes'] == '8'){echo 'selected="selected"';} ?>>8</option>

					<option value="9" <?php if ($stnl_config['boxes'] == '9'){echo 'selected="selected"';} ?>>9</option>

					<option value="10" <?php if ($stnl_config['boxes'] == '10'){echo 'selected="selected"';} ?>>10</option>

					</select></td>

					</tr>

				<tr valign="top"> 
					<th scope="row"><label for="metabox"><?php _e("Show Meta Box for Newsletter:", 'stnl');?></label></th>
					<td><input name="stn_metabox" type="checkbox" id="metabox" <?php if($stnl_config['metabox'] == true){ echo'checked="checked"'; }?> /></td>
				</tr>
                
			<tr valign="top"> 
				<th scope="row"><label for="unsubscribe"><?php _e("Delete Unsubscribers from Database:", 'stnl'); ?></label></th>
				<td><input name="stn_unsubscribe" type="checkbox" id="unsubscribe" value="delete" <?php if($stnl_config['unsubscribe'] == 'delete'){ echo'checked="checked"'; }?> /> <small><?php _e('If unchecked, subscriber data will remain in database but will not show in subscriber listings or be sent any emails.','stnl');?></small></td>
			</tr>                
            
            <tr valign="top"> 
				<th scope="row"><label for="showheader"><?php _e("Enable Custom Header Image:", 'stnl'); ?></label></th>
				<td><input name="stn_showheader" type="checkbox" id="showheader" value="show" <?php if($stnl_config['showheader'] == 'show'){ echo'checked="checked"'; }?> /></td>
			</tr>
            <tr valign="top"> 
				<th scope="row"><label for="showposts"><?php _e("Enable Post/Page Includes:", 'stnl');?></label></th>
				<td><input name="stn_showposts" type="checkbox" id="showposts" value="show" <?php if($stnl_config['showposts'] == 'show'){ echo'checked="checked"'; }?> /></td>
			</tr>
            
            <tr valign="top">
            <th scope="row"><label for="pages"><?php _e("Ability to Include Pages:", 'stnl');?></label></th>

			<td><input name="stn_pages" type="checkbox" id="pages" <?php if($stnl_config['pages'] == true){ echo'checked="checked"'; }?> /></td>

			</tr>


			<tr valign="top"> 

		<th scope="row"><label for="subpages"><?php _e('Subscribers Per Page Amount:', 'stnl');?></label></th>

					<td> <input name="stn_subpages" id="subpages" type="text" value="<?php echo $stnl_config['subpages']?>" size="3" /></td>

					</tr>
                    
				<tr valign="top"> 

		<th scope="row"><label for="maxpages"><?php _e('Maximum Pages to show at one time in the Newsletter archive:', 'stnl');?></label></th>

					<td> <input name="stn_maxpages" id="maxpages" type="text" value="<?php echo $stnl_config['maxpages']?>" size="3" /></td>

					</tr>

				

				<tr valign="top"> 

		<th scope="row"><label for="empty"><?php _e('Default Message when no Newsletters are available in the Archive:', 'stnl');?></label></th>

			       <td><input name="stn_empty" id="empty" type="text" value="<?php echo $stnl_config['empty']?>" size="25" /></td>

				   </tr>

				   

				   <tr valign="top"> 

		<th scope="row"><label for="esubject"><?php _e('Optional Pre-Subject:', 'stnl');?></label></th>

			       <td><input name="stn_esubject" id="esubject" type="text" value="<?php echo $stnl_config['esubject']?>" size="25" /> <small><?php _e("(Text to Display Before your Newsletter Title in the Subject Line.)", 'stnl');?></small></td>

				   </tr>



			<tr valign="top"> 

		<th scope="row"><label for="floodbatch"><?php _e('Flood Protection Batch', 'stnl');?>: </label></th>

			<td><input type="text" name="stn_floodbatch" id="floodbatch" value="<?php echo $stnl_config['floodbatch'];?>" size="3" /> <small><?php _e("Set the quantity of emails to send in a batch - Gmails Max is 50.", 'stnl');?></small></td>

			</tr>



		<tr valign="top"> 

		<th scope="row"><label for="floodpause"><?php _e('Flood Protection Pause', 'stnl');?>:</label></th>

			<td><input size="3" type="text" id="floodpause" name="stn_floodpause" value="<?php echo $stnl_config['floodpause'];?>" /> <small><?php _e("Set the time to wait between batches", 'stnl');?></small></td>

			</tr>

			

			<tr valign="top"> 

		<th scope="row"><label for="images"><?php _e('Images:', 'stnl');?></label></th>

		<td><select name="stn_images" id="images">

						<option value="link" <?php if ($stnl_config['images'] == 'link'){echo 'selected="selected"';} ?>><?php _e('Load from site (recommended)', 'stnl');?></option>

						<option value="embed" <?php if ($stnl_config['images'] == 'embed'){echo 'selected="selected"';} ?>><?php _e('Embed Local Images into Email (attached to email)', 'stnl');?></option>

						<!-- NOT POSSIBLE  <option value="embedall" <?php if ($stnl_config['images'] == 'embedall'){echo 'selected="selected"';} ?>><?php _e('Embed All Images into Email (allow_url_fopen must be enabled in php.ini)', 'stnl');?></option> -->

					</select></td>

					</tr>

		

				

				<?php 

				$theposts = $wpdb->get_results("SELECT * FROM $wpdb->posts ORDER BY post_date DESC");

								

				$i = 1;

				foreach($theposts as $post){ 

					$curpost = $postvalue[$i];

					if ($post->post_status == 'static' || $post->post_type == 'page'){

							$pages .= '<option value="'.get_permalink($post->ID).'"';

							$p = $i-1;

							

							if($stnl_config['uri'] == get_permalink($post->ID)){

								$pages .= 'selected="selected"';

							}

							$pages .= '>'.$post->post_title.'</option>';

							$i = $i+1;

					}

				}

			

					?>

				

				



					 <tr valign="top"> 

		<th scope="row"><label for="uri"><?php _e('Subscribe Page', 'stnl');?></label></th>

					<td><select name="stn_uri" id="uri">

					 	<option value="<?php echo get_option('siteurl').'/'; ?>" <?php if ($stnl_config['uri'] == get_option('siteurl').'/'){ echo 'selected="selected"';}?>><?php _e("WordPress Home", 'stnl');?> (<?php echo get_option('siteurl').'/';?>)</option>

						<option value="<?php echo get_option('home').'/'; ?>" <?php if ($stnl_config['uri'] == get_option('home').'/'){ echo 'selected="selected"';}?>><?php _e("Site Home", 'stnl');?> (<?php echo get_option('home').'/';?>)</option>

						<?php

							echo $pages;

						?>

					</select><small>
					<?php _e('This is the page containing <strong>st_mailinglist_subscribe();</strong> so we know where to send subscribers who want to change their options.', 'stnl');?> </small></td>

					</tr> 
                    <tr valign="top"> 

                    <th scope="row"><label for="suburi"><?php _e('Subscribe Form URI Override', 'stnl');?></label></th>

					<td><input type="text" name="stn_suburi" id="suburi" value="<?php echo $stnl_config['suburi'];?>" size="40" /><br /><small>
					<?php _e('This will override your subscribe forms base URI if you are having problems with the subscribe form. Value must begin with http:// Leave blank for default value.', 'stnl');?> </small></td>
                    </td>
                    </tr>

		      	

				<tr valign="top"> 

		<th scope="row"><label for="cats"><?php _e("Show Categories:", 'stnl');?></label></th>

			<td><input name="stn_cats" type="checkbox" id="cats" <?php if($stnl_config['cats'] == true){ echo'checked="checked"'; }?> /> <small><?php _e('Show Category Selection on Subscribe Page', 'stnl');?></small></td>

			</tr>

	

			

	<tr valign="top"> 

		<th scope="row"><?php _e('Subscribe Fields:', 'stnl');?></th>

		<td>

					<input type="button" value="X" disabled="disabled" /> <input disabled="disabled" type="text" id="label0" value="Email" /> <label for="required0"><?php _e('Required?', 'stnl');?></label> <select name="required0" id="required0" disabled="disabled"><option selected="selected" value="Yes"><?php _e('Yes', 'stnl');?></option><option value="No"><?php _e('No', 'stnl');?></option> </select> <br />

			

<?php			

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

			$required = $row['required'];	
			
			

			if($label != ''){
				$cselect .= '<option value="'.$label.'"';
				if ($stnl_config['etoname'] == $label) {$cselect .= 'selected="selected"';}
				$cselect .= '>'.$label.' {from Subscribe Field}</option>'."\n";
			?>

			<div style="display:block;"><input type="button" value="X"

		onclick="this.parentNode.parentNode.removeChild(this.parentNode);" />

	<input name="label<?php echo $i;?>" id="label<?php echo $i;?>" type="text" value="<?php echo $label;?>" />	<label for="required<?php echo $i;?>"><?php _e('Required?', 'stnl');?></label> <select name="required<?php echo $i;?>" id="required<?php echo $i;?>"><option <?php if ($required == 'Yes'){echo 'selected="selected"';}?> value="Yes"><?php _e('Yes', 'stnl');?></option><option <?php if ($required == 'No'){echo 'selected="selected"';}?> value="No"><?php _e('No', 'stnl');?></option> </select>

	<br />

		

	</div>

			<?php

			}

			$i = $i+1;

		}

	}

					?>					

					 <span id="writeroot"></span>

<input type="button" value="<?php _e('Add New Field', 'stnl');?>" onclick="moreFields();" />

				 <br />

											

	     </td>

		 </tr>

		 

		<tr valign="top"> 

		<th scope="row"><label for="req"><?php _e('Required Text', 'stnl');?>: </label></th>

		<td><input type="text" name="stn_req" id="req" value="<?php echo stripslashes($stnl_config['req']);?>" style="width:400px;" /> <small><?php _e("HTML text to appear next to any required fields", 'stnl');?></small></td>

		</tr>

			

			



		<tr valign="top"> 

		<th scope="row"><label for="veditor"><?php _e('Visual Editor:', 'stnl');?></label></th>

		<td><select name="stn_editor" id="veditor">

        	<?php stnl_get_editors($stnl_config['editor']);?>



		</select></td>

</tr>	

<tr valign="top">
            <th scope="row"><label for="nofilter"><?php _e("Disable WordPress Filters:", 'stnl');?></label></th>

			<td><input name="stn_nofilter" type="checkbox" id="nofilter" <?php if($stnl_config['nofilter'] == true){ echo'checked="checked"'; }?> /> <small><?php _e('This will disable Wordpress\'s "the_content" filter which adds formatting tags to your Newsletter content.','stnl');?></small></td>

			</tr>

<tr valign="top"> 

		<th scope="row"><label for="slash"><?php _e('Slash Fix:', 'stnl');?></label></th>

		<td><input type="checkbox" name="stn_slashfix" <?php if($stnl_config['slashfix'] != '%2F'){ echo 'checked="checked"'; }?> /> <small><?php _e("Required if you are running this site off of a Windows host locally and recieving a \"Fatal error: Cannot redeclare...\" error", 'stnl');?></small></td>

		</tr>

<tr valign="top"> 

		<th scope="row"><label for="log"><?php _e('Error Log:', 'stnl');?></label></th>

		<td><input type="checkbox" name="stn_log" <?php if($stnl_config['log'] == true){ echo 'checked="checked"'; }?> /> <small><?php _e("This will display an error log upon sending for troubleshooting sending issues.", 'stnl');?></small><br /><input type="text" name="stn_logmax" style="width:30px;" value="<?php echo $stnl_config['logmax'];?>" /> <?php _e('Set a limit for the amount of entries included in the log. 0 is unlimited.','stnl');?></td>

		</tr>
		

        <tr valign="top"> 

		<th scope="row"><label for="efrom"><?php _e('Send From Email:', 'stnl');?></label></th>

					 <td><input name="stn_efrom" id="efrom" type="text" value="<?php echo $stnl_config['efrom'];?>" size="20" /></td>

					 </tr>
         <tr valign="top"> 

		<th scope="row"><label for="efname"><?php _e('Send From Name:', 'stnl');?></label></th>

					 <td><input name="stn_efname" id="efname" type="text" value="<?php echo $stnl_config['efname'];?>" size="20" /></td>

					 </tr>
                     
         <!--   <tr valign="top"> 

		<th scope="row"><label for="efname"><?php _e('Send To Name:', 'stnl');?></label></th>

					 <td><select name="stn_etoname" id="etoname">
                     			<option value="none" <?php if ($stnl_config['etoname'] == 'none'){echo'selected="selected"';}?>>None</option>
                                <option value="email" <?php if ($stnl_config['etoname'] == 'email'){echo'selected="selected"';}?>>Email Address {from Subscribe Field}</option>
                     			<?php echo $cselect;?>
                                <option value="custom" <?php if ($stnl_config['etoname'] == 'custom'){echo'selected="selected"';}?>>Enter Custom Name Below:</option>
                     </select> 
                     <br />
                     <input name="stn_ectoname" id="ectoname" type="text" value="<?php echo $stnl_config['ectoname'];?>" size="20" /></td>

					 </tr>     --><input type="hidden" name="stn_etoname" value="none" />

		      	

				<tr valign="top"> 

		<th scope="row"><label for="bounce"><?php _e('Bounce Address', 'stnl');?>: </label></th>

			<td><input type="text" name="stn_bounce" id="bounce" value="<?php echo $stnl_config['bounce'];?>" /> <small><?php _e("If an email bounces a notice will be sent to this address.  You may want to set-up a seperate account for bounce detection.", 'stnl');?></small></td>

			</tr>

           

<tr valign="top"> 

		<th scope="row"><label for="sendwith"><?php _e('Send Using:', 'stnl');?></label></th>

		<td><select name="stn_sendwith" id="sendwith">

					 		<option value="sendmail" <?php if ($stnl_config['sendwith'] == "sendmail"){echo 'selected="selected"';} ?>>1. Swift Sendmail <?php _e('(Best)', 'stnl');?></option>

							<option value="smtplocal" <?php if ($stnl_config['sendwith'] == "smtplocal"){echo 'selected="selected"';} ?>>2. Swift SMTP Localhost <?php _e('(Great)', 'stnl');?></option>
							<option value="smtp" <?php if ($stnl_config['sendwith'] == "smtp"){echo 'selected="selected"';} ?>>3. Swift SMTP <?php _e('(Good)', 'stnl');?></option>

							

							<option value="nativemail" <?php if ($stnl_config['sendwith'] == "nativemail"){echo 'selected="selected"';} ?>>4. Native Mail <?php _e('(If nothing else works)', 'stnl');?></option>

					</select></td>

					</tr>

</table>

		<fieldset class="options"><legend><?php _e('Swift SMTP Settings:', 'stnl');?></legend>
			<small><?php _e('This information is only used if you have selected option <em>3. Swift SMTP</em> from the "Send Using:" option above.', 'stnl');?></small>
	<table class="optiontable">

					 <tr valign="top"> 

		<th scope="row"><label for="server"><?php _e('Server:', 'stnl');?></label></th>

					<td> <input name="stn_smtpserver" id="server" type="text" value="<?php echo $stnl_config['smtpserver'];?>" size="20" /> (smtp.yourhost.com)</td>

					</tr>

			<tr valign="top"> 

			

		<th scope="row"><label for="user"><?php _e("Username", 'stnl');?> </label></th>

					<td><input name="stn_smtpuser" id="user" type="text" value="<?php echo $stnl_config['smtpuser']?>" size="20" /></td>

					</tr>

					

				<tr valign="top"> 

		<th scope="row"><label for="pass"><?php _e("Password", 'stnl');?></label></th>

				<td> <input name="stn_smtppass" id="pass" type="password" value="<?php echo $stnl_config['smtppass']?>" size="20" /></td>

				</tr>

				

				<tr valign="top"> 

		<th scope="row"><?php _e("Should we use TLS or SSL?:", 'stnl');?> </th>

		<td><label><input name="stn_smtptls" type="radio" value="false" <?php if ($stnl_config['smtptls'] == "false"){echo 'checked="checked"';} ?> /><?php _e("No");?></label> <label><input name="stn_smtptls" type="radio" value="tls" <?php if ($stnl_config['smtptls'] == "tls"){echo 'checked="checked"';} ?> /> TLS</label> <label><input name="stn_smtptls" type="radio" value="ssl" <?php if ($stnl_config['smtptls'] == "ssl"){echo 'checked="checked"';} ?> /> SSL</label></td>

		</tr>

		

				 <tr valign="top"> 

		<th scope="row"><label for="port"><?php _e("Port:", 'stnl');?> </label></th>

				<td><input name="stn_smtpport" id="port" type="text" value="<?php echo $stnl_config['smtpport'];?>" /></td>

				</tr>

			</table>

</fieldset>

	 

			    <p class="submit">

			      	<input type="submit" name="Submit" value="<?php _e('Update Options &raquo;', 'stnl');?>" />

			    </p>

			</form>

		

			

		

		<?php

	} // End If ?>

	

<h2><?php _e('Documentation', 'stnl');?></h2>

<?php _e('See the <a href="http://docs.shiftthis.net/wordpress_newsletter_plugin">Full Documentation</a> for complete instructions or visit the <a href="http://support.shiftthis.net/">Support Forums</a> for further help (You will need to login to view the Owners Support Forum).', 'stnl');?>

		

</div>

		<?php

}

?>