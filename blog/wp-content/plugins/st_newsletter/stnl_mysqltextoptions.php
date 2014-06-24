<?php

function stnl_check_textconfig() {

	if ( !$option = get_option('stnl_textconfig') ) {

		// Default Options

		$option['listname'] = get_option('blogname').__(' Mailing List', 'stnl');

		$option['optsubject'] = "{list_name} ".__("Confirmation", 'stnl');

		$option['optmessage'] = __("<b>Thank you for your interest in subscribing to the {list_name}!</b><br><br>Someone (hopefully you!) submitted your email address for a subscription to our mailing list.  If you do not wish to receive this email subscription, simply ignore this email and nothing will be sent to you.<br><br>However, if you do wish to be subscribed to the {list_name}, please complete the email verification by following the instructions below:<br><br> To enable this subscription please click or paste the following link into your web browser:<br> {verify_link}<br><br>Thank you!", 'stnl');

		$option['optsuccess'] = __("<strong>Thank you for subscribing.  Please check your email now and click the verification link to enable the subscription.</strong>", 'stnl');

		$option['dupeunv'] = __("<strong>This email is already in our Mailing List, however it has not been verified.  If you would like your verification email re-sent please <a href='{resend_link}'>click here</a></strong>", 'stnl');

		$option['dupev'] = __("<strong>This email is already subscribed and verified.</strong> <br /><small>To access your account details, please enter your email address in the form below.  This will email you the link needed to access your account information. </small><br />{retrieve_account}<br /> <small> If you are not receiving our newsletter, please check your spam settings as the email may have been incorrectly tagged as spam by your email client.</small>", 'stnl');

		$option['retrieve'] = __("Here is your link to update your subscription information.<br /><a href='{account_link}'>{account_link}</a>.", 'stnl');

		update_option('stnl_textconfig', $option);



	}



	// If value not assigned insert default (upgrades)

	if ( strlen($option['optsubject']) < 1 or strlen($option['optmessage']) < 1 or strlen($option['optsuccess']) < 1 or strlen($option['dupeunv']) < 1 or strlen($option['dupev']) < 1 or strlen($option['retrieve']) < 1 ) {



		$option['listname'] = get_option('blogname').__(' Mailing List', 'stnl');

		$option['optsubject'] = "{list_title} ".__("Confirmation", 'stnl');

		$option['optmessage'] = __("<b>Thank your interest in subscribing to the {list_name}!</b><br><br>Someone (hopefully you!) submitted your email address for a subscription to our mailing list.  If you do not wish to receive this email subscription, simply ignore this email and nothing will be sent to you.<br><br>However, if you do wish to be subscribed to the {list_name}, please complete the email verification by following the instructions below:<br><br> To enable this subscription please click or paste the following link into your web browser:<br> {verify_link}<br><br>Thank you!", 'stnl');

		$option['optsuccess'] = __("<strong>Thank you for subscribing.  Please check your email now and click the verification link to enable the subscription.</strong>", 'stnl');

		$option['dupeunv'] = __("<strong>This email is already in our Mailing List, however it has not been verified.  If you would like your verification email re-sent please <a href='{resend_link}'>click here</a></strong>", 'stnl');

		$option['dupev'] = __("<strong>This email is already subscribed and verified.</strong> <br /><small>To access your account details, please enter your email address in the form below.  This will email you the link needed to access your account information. </small><br />{retrieve_account}<br /> <small> If you are not receiving our newsletter, please check your spam settings as the email may have been incorrectly tagged as spam by your email client.</small>", 'stnl');

		$option['retrieve'] = __("Here is your link to update your subscription information.<br /><a href='{account_link}'>{account_link}</a>.", 'stnl');

	

		update_option('stnl_textconfig', $option);



	}



}



function newsletter_textoptions_submit() {

	global $stnl_textconfig, $stnl_config;

	$showme = $stnl_config['minlevel'];
	if($showme == ''){
		$showme = 10;
	}

	if ( current_user_can('level_'.$showme) ) {



		

		//options page

		$option['listname'] = $_POST['stn_listname'];

		$option['optsubject'] = $_POST['stn_optsubject'];

		$option['optmessage'] = $_POST['stn_optmessage'];

		$option['optsuccess'] = $_POST['stn_optsuccess'];

		$option['dupeunv'] = $_POST['stn_dupeunv'];

		$option['dupev'] = $_POST['stn_dupev'];

		$option['retrieve'] = $_POST['stn_retrieve'];

		

		update_option('stnl_textconfig', $option);



	}



}

?>