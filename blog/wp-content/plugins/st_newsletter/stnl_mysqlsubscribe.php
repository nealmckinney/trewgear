<?php

function st_mailinglist_insert_input() {
	global $wpdb, $table_prefix, $userdata, $stnl_config;
		$cusfields = $stnl_config['subscribefields'];
		$cfields = explode('[|]', $cusfields);
		$prev = array();
		foreach($cfields as $cf){
			$split = explode('[*]', $cf);
			$sp1 = str_replace(' ', '', $split[0]);
			$prev = $cf_arr;
			$cf_arr = array($sp1 => $split[1]);
			if($prev != ''){
				$cf_arr = array_merge($prev, $cf_arr);
			}
		}

	$j = st_q();
		$n_email = $_POST['sts_email'];
		$cats = $_POST['sts_cats'];
		if(is_array($cats) != true){
			$cats = array($cats);
		}
		foreach($cats as $cat){
			$n_cats .= $cat.'[|]';
		}
		$n_cats = substr($n_cats, 0, -3);
//echo $n_cats;

		foreach($_POST as $key=>$val){
			if($key != 'sts_email' && $key != 'sts_cats' && $key != 'submit'){
				$extras .= str_replace(' ', '', $key).'[:]'.$val.'[*]';
			}
		}
			$n_extras = rtrim($extras, '[*]');

		foreach($cf_arr as $field=>$req){
			if($_POST[$field] == '' && $req == 'Yes'){
				$error[] = $field;
			}
		}
		$iserror = count($error);

		if($n_email == ''){
			echo st_subscribe_form();
			_e('Please enter an email address.', 'stnl');
		}elseif(st_checkEmail($n_email) == FALSE) {
   			echo st_subscribe_form();
			echo __('The email [ <strong>', 'stnl').$n_email.__('</strong> ] is not a valid email address.', 'stnl');
		}else if($iserror > 0){
			echo st_subscribe_form();
			foreach($error as $fieldnm){
				echo __('The ', 'stnl').$fieldnm.__(' field is required', 'stnl');
			}
		} else {
		$n_confirmed = "0";
		$n_code = genunique(20);
		$n_subip = $_SERVER['REMOTE_ADDR'];
		$n_subdate = date('g:ia d/m/Y'); 

			/* Query */
			$postquery = "INSERT INTO 
			".$table_prefix."st_mailinglist
			(st_email, st_status, st_code, st_subip, st_subdate, st_extras, st_cat)
			VALUES
			('$n_email', '$n_confirmed', '$n_code', '$n_subip', '$n_subdate', '$n_extras', '$n_cats')
			";
			$wpdb->query($postquery);
				st_regmail($n_email,$n_code); 
		}	
}

function st_mailinglist_insert_update() {
	global $wpdb, $table_prefix, $userdata, $stnl_config;
		$cusfields = $stnl_config['subscribefields'];
		$cfields = explode('[|]', $cusfields);
		$prev = array();
		foreach($cfields as $cf){
			$split = explode('[*]', $cf);
			$sp1 = str_replace(' ', '', $split[0]);
			$prev = $cf_arr;
			$cf_arr = array($sp1 => $split[1]);
			if($prev != ''){
				$cf_arr = array_merge($prev, $cf_arr);
			}
		}

	$j = st_q();
		$n_email = $_POST['sts_email'];
		$cats = $_POST['sts_cats'];
		if(is_array($cats) != true){
			$cats = array($cats);
		}
		foreach($cats as $cat){
			$n_cats .= $cat.'[|]';
		}
		$n_cats = substr($n_cats, 0, -3);
//echo $n_cats;

		foreach($_POST as $key=>$val){
			if($key != 'sts_email' && $key != 'sts_cats' && $key != 'submit'){
				$extras .= str_replace(' ', '', $key).'[:]'.$val.'[*]';
			}
		}
			$n_extras = rtrim($extras, '[*]');

		foreach($cf_arr as $field=>$req){
			if($_POST[$field] == '' && $req == 'Yes'){
				$error[] = $field;
			}
		}
		$iserror = count($error);

		if($n_email == ''){
			echo st_subscribe_form();
			_e('Please enter an email address.', 'stnl');
		}elseif(st_checkEmail($n_email) == FALSE) {
   			echo st_subscribe_form();
			echo __('The email [ <strong>', 'stnl').$n_email.__('</strong> ] is not a valid email address.', 'stnl');
		}else if($iserror > 0){
			echo st_subscribe_form();
			foreach($error as $fieldnm){
				echo __('The ', 'stnl').$fieldnm.__(' field is required', 'stnl');
			}
		} else {
		$n_confirmed = "0";
		$n_code = genunique(20);
		$n_subip = $_SERVER['REMOTE_ADDR'];
		$n_subdate = date('g:ia d/m/Y'); 

			/* Query */
			$postquery = "UPDATE ".$table_prefix."st_mailinglist SET st_status='$n_confirmed', st_code='$n_code', st_subip='$n_subip', st_subdate='$n_subdate', st_extras='$n_extras', st_cat='$n_cats' WHERE st_email='$n_email'";
			$wpdb->query($postquery);
				st_regmail($n_email,$n_code); 
		}	
}

function st_mailinglist_verified($code) {
	global $wpdb, $table_prefix, $userdata, $stnl_config;
		$n_confirmed = "1";
		$n_confip = $_SERVER['REMOTE_ADDR'];
		$n_confdate = date('g:ia d/m/Y'); 
		



			/* Query */

			$postquery = "UPDATE

			".$table_prefix."st_mailinglist SET st_status='$n_confirmed', st_confip='$n_confip', st_confdate='$n_confdate' WHERE st_code='$code'";

		

			$wpdb->query($postquery);





	$SQL = "SELECT * FROM ".$table_prefix."st_mailinglist WHERE st_code='$code'";

	$user = $wpdb->get_row($SQL);



echo "<strong>".__('The email address, ', 'stnl').$user->st_email.__(' has been verified.  Thank you for subscribing!', 'stnl')."</strong><br />&nbsp;";

		}

/*-------------------------------------------------------------

 Name:      st_mailinglist_update_input



 Purpose:   Prepare input form on advanced edit post page

 Receive:   -None-

-------------------------------------------------------------*/

function st_mailinglist_update_input() {



	global $wpdb,  $table_prefix, $userdata, $stnl_config;
	$showme = $stnl_config['minlevel'];
	if($showme == ''){
		$showme = 10;
	}

	$j = st_q();

	if ( current_user_can('level_'.$showme) ) {



		$n_id = $_POST['sts_id'];

		$n_email = $_POST['sts_email'];

		$n_email = $_POST['sts_email'];

		$cats = $_POST['sts_cats'];

		foreach($cats as $cat){

			$n_cats = $cat.'[|]';

		}

		$n_cats = rtrim($n_cats, '[|]');

		

		foreach($_POST as $key=>$val){

			if($key != 'sts_email' || $key != 'sts_cats' || $key != 'submit'){

				$extras .= str_replace(' ', '', $key).'[:]'.$val.'[*]';

			}

		}

			$n_extras = rtrim($extras, '[*]');

			/* Query */

			$postquery = "UPDATE

			".$table_prefix."st_mailinglist SET st_email='$n_email', st_extras='$n_extras', st_cat='$n_cats' WHERE st_id='$n_id'";

		

			$wpdb->query($postquery);



		}

	

	$ref = $_SERVER['HTTP_REFERER'];

	$location = trim($ref, $j."edit_st_mailinglist=".$n_id);

	header('Location: '.$location);



}





?>