<?php
##########UPGRADE NEWSLETTER DB##################
function stnl_dbupgrade_check(){
	global $wpdb, $table_prefix;
	$table_name = $table_prefix . "st_newsletter";
	$po_checksql = "SHOW COLUMNS FROM $table_name LIKE 'st_postorder'";
	$po_check = $wpdb->get_results($po_checksql);
	
	$cat_checksql = "SHOW COLUMNS FROM $table_name LIKE 'st_cat'";
	$cat_check = $wpdb->get_results($cat_checksql);
	
	$tem_checksql = "SHOW COLUMNS FROM $table_name LIKE 'st_template'";
	$tem_check = $wpdb->get_results($tem_checksql);
	
	$head_checksql = "SHOW COLUMNS FROM $table_name LIKE 'st_header'";
	$head_check = $wpdb->get_results($head_checksql);
	
		if (count($po_check) == 0 || count($cat_check) == 0 || count($tem_check) == 0 || count($head_check) == 0) {    
			echo '<div class="updated fade-ff0000"><form action="'.get_option('siteurl').'/wp-admin/admin.php?page=options-newsletter" method="post"><p><strong>';
			_e("This version of the ShiftThis Newsletter requires a database update.", 'stnl');
			echo ' <input style="cursor:pointer" type="submit" name="upgrade" value="'. __('Update Now', 'stnl').'" />';
			echo '</strong></p></form></div>';
		} 
}
function stnl_dbupgrade_check_nl(){
	global $wpdb, $table_prefix;
	$table_name = $table_prefix . "st_newsletter";
	$po_checksql = "SHOW COLUMNS FROM $table_name LIKE 'st_postorder'";
	$po_check = $wpdb->get_results($po_checksql);
	
	$cat_checksql = "SHOW COLUMNS FROM $table_name LIKE 'st_cat'";
	$cat_check = $wpdb->get_results($cat_checksql);
	
	$tem_checksql = "SHOW COLUMNS FROM $table_name LIKE 'st_template'";
	$tem_check = $wpdb->get_results($tem_checksql);
	
	$head_checksql = "SHOW COLUMNS FROM $table_name LIKE 'st_header'";
	$head_check = $wpdb->get_results($head_checksql);
	
		if (count($po_check) == 0) {    
			stnl_dbupgrade_nl('postorder');
		} 
		if (count($cat_check) == 0){
			stnl_dbupgrade_nl('catmime');
		}
		if (count($tem_check) == 0) {    
			stnl_dbupgrade_nl('template');
		} 
		if (count($head_check) == 0) {    
			stnl_dbupgrade_nl('header');
		} 
}

function stnl_dbupgrade_nl($type){
	global $wpdb, $table_prefix;
	$table_name = $table_prefix . "st_newsletter";
	if($type == 'postorder'){
		$sqlup = "ALTER TABLE $table_name ADD st_postorder VARCHAR(255) NOT NULL AFTER st_posts";
		$wpdb->query($sqlup);
	}
	if($type == 'catmime'){
		$newsqlup = "ALTER TABLE ".$table_prefix."st_newsletter ADD st_cat VARCHAR(120) DEFAULT 1 NOT NULL, ADD st_mime VARCHAR(120) DEFAULT 'multi' NOT NULL";
		$wpdb->query($newsqlup);
	}
	if($type == 'template'){
		$newsqlup = "ALTER TABLE ".$table_prefix."st_newsletter ADD st_template VARCHAR(120) NOT NULL";
		$wpdb->query($newsqlup);
	}
	if($type == 'header'){
		$newsqlup = "ALTER TABLE ".$table_prefix."st_newsletter ADD st_header VARCHAR(120) NOT NULL";
		$wpdb->query($newsqlup);
	}
}

##################UPGRADE MAILING LIST DB#####################
function stnl_dbupgrade_check_ml(){
	global $wpdb, $table_prefix;
	$table_name = $table_prefix . "st_mailinglist";
	$ml_checksql = "SHOW COLUMNS FROM $table_name LIKE 'st_extras'";
	$ml_check = $wpdb->get_results($ml_checksql);
		if (count($ml_check) == 0) {    
			stnl_dbupgrade_ml();
		} 
}

function stnl_dbupgrade_ml(){
	global $wpdb, $table_prefix;
	$table_name = $table_prefix . "st_mailinglist";
	
	$currentml = $wpdb->get_results("SELECT * FROM $table_name");
	
	
	$add= "ALTER TABLE `".$table_prefix."st_mailinglist` ADD `st_extras` LONGTEXT NOT NULL ,
ADD `st_cat` VARCHAR( 120 ) NOT NULL ,
ADD `st_responder` VARCHAR( 120 ) NOT NULL";
	
	$wpdb->query($add);
	
	foreach($currentml as $ml){
		$id = $ml->st_id;
		$first = $ml->st_firstnm;
		$last = $ml->st_lastnm;
		$phone = $ml->st_phone;
		$address = $ml->st_address;
		$city = $ml->st_city;
		$state = $ml->st_state;
		$zip = $ml->st_zip;
		$country = $ml->st_country;
		
		if($first != ''){ $new .= 'FirstName[:]'.$first.'[*]';}
		if($last != ''){ $new .= 'LastName[:]'.$last.'[*]';}
		if($phone != ''){ $new .= 'Phone[:]'.$phone.'[*]';}
		if($address != ''){ $new .= 'Address[:]'.$address.'[*]';}
		if($city != ''){ $new .= 'City[:]'.$city.'[*]';}
		if($state != ''){ $new .= 'State[:]'.$state.'[*]';}
		if($zip != ''){ $new .= 'Zip[:]'.$zip.'[*]';}
		if($country != ''){ $new .= 'Country[:]'.$country.'[*]';}
		
		$new = rtrim($new, '[*]');
		$update =  "UPDATE ".$table_prefix."st_mailinglist SET st_extras='$new', st_cat='1' WHERE st_id='$id'";
		$wpdb->query($update);		
	}
	
	$drop = "ALTER TABLE `".$table_prefix."st_mailinglist`
  DROP `st_firstnm`,
  DROP `st_lastnm`,
  DROP `st_phone`,
  DROP `st_address`,
  DROP `st_city`,
  DROP `st_state`,
  DROP `st_zip`,
  DROP `st_country`";
	$wpdb->query($drop);
	
}
?>