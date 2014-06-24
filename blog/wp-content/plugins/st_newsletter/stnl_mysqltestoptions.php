<?php

function stnl_check_testconfig() {

	if ( !$option = get_option('stnl_testconfig') ) {

		// Default Options

		$option['conn'] = "sendmail";

		$option['from'] = get_option('admin_email');

		$option['to'] = get_option('admin_email');

		$option['fname'] = "ShiftThis Newsletter";

		$option['tname'] = "WordPress Admin";

		$option['smtpserver'] = '';

		$option['smtpuser'] = '';

		$option['smtppass'] = '';

		$option['smtptls'] = false;

		$option['smtpport'] = '25';

		$option['sendmail'] = '/usr/sbin/sendmail -bs';

		$option['simpletest'] = ABSPATH.'/simpletest';

		

		update_option('stnl_testconfig', $option);



	}



}



function newsletter_testoptions_submit() {

	global $stnl_config;
	
	$showme = $stnl_config['minlevel'];
	if($showme == ''){
		$showme = 10;
	}


	if ( current_user_can('level_'.$showme) ) {

		//options page

		$option['conn'] = $_POST['stn_conn'];

		$option['from'] = $_POST['stn_from'];

		$option['to'] = $_POST['stn_to'];

		$option['fname'] = $_POST['stn_fname'];

		$option['tname'] = $_POST['stn_tname'];



		$option['sendmail'] = $_POST['stn_sendmail'];

		$option['simpletest'] = ABSPATH.$_POST['stn_simpletest'];

		

		$option['sendwith'] = $_POST['stn_sendwith'];

		$option['smtpserver'] = $_POST['stn_smtpserver'];

		$option['smtpuser'] = $_POST['stn_smtpuser'];

		$option['smtppass'] = $_POST['stn_smtppass'];

		$option['smtptls'] = $_POST['stn_smtptls'];

		$option['smtpport'] = $_POST['stn_smtpport'];

		

		

		update_option('stnl_testconfig', $option);



	}



}

?>