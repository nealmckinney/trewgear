<?php

function stnl_check_config() {

	if ( !$option = get_option('stnl_config') ) {

		// Default Options

		$option['minlevel'] = 7;

		$option['boxes'] = 2;
		
		$option['metabox'] = '';
		
		$option['pages'] = '';

		$option['subpages'] = 25;
		
		$option['maxpages'] = 5;
		
		$option['showheader'] = 0;
		$option['showposts'] = 0;

		$option['empty'] = __("No Newsletters Available", 'stnl');

		$option['efrom'] = get_option('admin_email');
		
		$option['efname'] = get_option('blogname');

		$option['etoname'] = 'email';
		
		$option['ectoname'] = '';

		$option['testto'] = get_option('admin_email');

		$option['bounce'] = get_option('admin_email');

		$option['floodbatch'] = 50;

		$option['floodpause'] = "2";

		$option['images'] = "link";

		$option['slashfix'] = "%2F";
		
		$option['log'] = "";
		$option['logmax'] = "0";

		$option['uri'] = get_option('siteurl').'/';
		
		$option['suburi'] = '';

		$option['editor'] = "tinymce";
		
		$option['nofilter'] = "";

		$option['req'] = '<strong>*</strong>';

		$option['template'] = 'Kubrick';

		

		update_option('stnl_config', $option);



	}



}



function newsletter_options_submit() {

	global $stnl_config;
$showme = $stnl_config['minlevel'];
	if($showme == ''){
		$showme = 10;
	}


	if ( current_user_can('level_'.$showme) ) {



		

		//options page

		$option['license'] = $stnl_config['license'];
		$option['minlevel'] = $_POST['stn_minlevel'];
		$option['language'] = $_POST['stn_language'];
		$option['boxes'] = $_POST['stn_boxes'];	
		$option['metabox'] = $_POST['stn_metabox'];
		$option['showheader'] = $_POST['stn_showheader'];
		$option['showposts'] = $_POST['stn_showposts'];
		$option['pages'] = $_POST['stn_pages'];
		$option['subpages'] = $_POST['stn_subpages'];
		$option['maxpages'] = $_POST['stn_maxpages'];
		$option['empty'] = $_POST['stn_empty'];
		$option['esubject'] = $_POST['stn_esubject'];
		$option['efrom'] = $_POST['stn_efrom'];
		$option['efname'] = $_POST['stn_efname'];
		$option['etoname'] = $_POST['stn_etoname'];
		
		if($_POST['stn_etoname'] == 'custom'){
			$option['ectoname'] = $_POST['stn_ectoname'];
		}

		$option['bounce'] = $_POST['stn_bounce'];

		$option['floodbatch'] = $_POST['stn_floodbatch'];

		$option['floodpause'] = $_POST['stn_floodpause'];

		$option['uri'] = $_POST['stn_uri'];
		
		$option['suburi'] = $_POST['stn_suburi'];

		$option['images'] = $_POST['stn_images'];
		$option['unsubscribe'] = $_POST['stn_unsubscribe'];
		$option['cats'] = $_POST['stn_cats'];

		$option['testto'] = $_POST['stn_testto'];

		$option['editor'] = $_POST['stn_editor'];
		
		$option['nofilter'] = $_POST['stn_nofilter'];

		$option['req'] = str_replace('"', "'", $_POST['stn_req']);

		

		$option['sendwith'] = $_POST['stn_sendwith'];

		$option['smtpserver'] = $_POST['stn_smtpserver'];

		$option['smtpuser'] = $_POST['stn_smtpuser'];

		$option['smtppass'] = $_POST['stn_smtppass'];

		$option['smtptls'] = $_POST['stn_smtptls'];

		$option['smtpport'] = $_POST['stn_smtpport'];

		$option['template'] = $_POST['stn_template'];

		$option['log'] = $_POST['stn_log'];
		$option['logmax'] = $_POST['stn_logmax'];

		if ($_POST['stn_slashfix'] == true){

		$option['slashfix'] = "%5C";

		}else{

		$option['slashfix'] = "%2F";

		}

		$i = 1;

		foreach ($_POST as $key => $value) {		

			$fields .= $_POST['label'.$i].'[*]'.$_POST['required'.$i].'[|]';

			$i++;

		}
		
		if($option['sendwith'] == 'smtplocal'){
			$option['smtpserver'] = 'localhost';
			$option['smtpuser'] = '';
			$option['smtppass'] = '';
			$option['smtptls'] = 'false';
			$option['smtpport'] = '25';
		}

		$fields = str_replace('[*][|]', '', $fields);

		$fields = rtrim($fields, '[|]');

	$option['subscribefields'] = $fields;

		

		update_option('stnl_config', $option);



	}



}

?>