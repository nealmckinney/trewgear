<?php

/*-------------------------------------------------------------

 Name:      st_regmail

 Purpose:   Send confirmation emails using wp_mail

-------------------------------------------------------------*/

function st_regmail($email,$code,$success=''){

	global $wpdb, $table_prefix, $stnl_config, $stnl_textconfig;



	$j = st_q();



	require_once('class.html2text.inc.php');

	

	$SQL = "SELECT * FROM ".$table_prefix."st_mailinglist WHERE st_code='$code'";

	$user = $wpdb->get_row($SQL);

			

	$from = $stnl_config['efrom'];

	$theextras = $user->st_extras;

	$extras = explode('[*]',$theextras);

	//print_r($extras);

	foreach($extras as $ext){

		$prev = $extra;

		$ex = explode('[:]', $ext);

		$extra = array( $ex[0] => $ex[1] );

		if($prev != ''){

			$extra = array_merge($prev, $extra);

		}

	}

	//print_r($extra);

	$success = $stnl_textconfig['optsuccess'];

	if ($success != ''){

		foreach($extra as $type=>$ext){

			$success = str_replace('{'.$type.'}', $ext, $success);

			//echo '{'.$type.'} : '. $ext;

		}

	}

	if (strpos($_SERVER['REQUEST_URI'], 'resend') === false){} else {

		$uri = $stnl_config['uri'];

		$j2 = st_news_q();

	}

	if (strpos($_SERVER['REQUEST_URI'], 'getaccount') === false){} else {

		$uri = $stnl_config['uri'];

		$j2 = st_news_q();

	}

	if (strpos($_SERVER['REQUEST_URI'], 'subscribe') === false){} else {

		$uri = $stnl_config['uri'];

		$j2 = st_news_q();

	}

	$subject = str_replace('{presubject}', $stnl_config['esubject'], $stnl_textconfig['optsubject']);

	$subject = str_replace('{list_name}',$stnl_textconfig['listname'], $subject);

	$subject = stripslashes($subject);

	

	$html = str_replace('{list_name}',$stnl_textconfig['listname'], $stnl_textconfig['optmessage']);

	foreach($extra as $type=>$ext){

			$success = str_replace('{'.$type.'}', $ext, $success);

			$html = str_replace('{'.$type.'}', $ext, $html);

			//echo '{'.$type.'} : '. $ext;

		}

	$verifylink = "<a href='".$uri.$j2."verify=".$code."'>".$uri.$j2."verify=".$code."</a>";

	$html = str_replace('{verify_link}',$verifylink, $html);

	

	

	$replyto='';

	

	$email = urldecode($email);

	if (eregi("\r",$to) || eregi("\n",$email)){

		 die("No injections please!");

	   }

	$message = stripslashes($html);

	//$headers .= 'To:'. $email . "\r\n";

	$headers .= 'From:'. $from . "\r\n";

	$headers .= 'Return-Path: ' . $from . "\n";

	$headers  .= 'MIME-Version: 1.0' . "\r\n";

	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	

	//if (wp_mail($email, $subject, $message, $headers)) { echo $success; }

	stnl_swift_sendmail($email, $subject, $message, $success);

}





function st_checkEmail($email) {

	$ename = '^[+_a-z0-9-]+([\.\+][+_a-z0-9-]+)';

	$edomain = '[a-z0-9-]+(\.[a-z0-9-]+)';

	$ext = '(\.[a-z]{2,6})$';

	$regs = $ename.'*@'.$edomain.'*'.$ext;

   if(eregi($regs, $email)) 

   {

    

	  return TRUE;

   } else {

   		return FALSE;

	}

}



function st_getmailinglist_reg() {

/* Fetch Mailing List */

global $wpdb, $table_prefix;

		$SQL = "SELECT st_email FROM ".$table_prefix."st_mailinglist WHERE st_status=1";

		$mailinglist = $wpdb->get_results($SQL);

if ( count($mailinglist) == 0 ) {

		$warn = '<i>'.__('No Subscribers yet.', 'stnl').'</i>';	

} else	 {

	foreach ( $mailinglist as $email ) {	

			

			//$confirmed .= $email->st_email.'|';

			$bcc .= $email->st_email.', ';

			}

			

			//$bcc = array($list);

		}

		//$bcc = explode("|", $confirmed);

		//$bcc = array($confirmed);

		$bcc = rtrim($bcc, ', ');

			return $bcc;

}



function stnl_getsubscribers($cat='all', $type='select', $val=''){

	global $wpdb, $table_prefix, $stnl_config;

	

	$allsubs = $wpdb->get_results("SELECT * FROM ".$table_prefix."st_mailinglist ORDER BY st_email");

	

	if($type == 'select'){

		$before = '<option value="{id}" {selected} >';

		$after = '</option>';

	}

	

	foreach($allsubs as $em){

		if($cat == 'all'){

			$pre = str_replace('{id}', $em->st_id, $before);

			if($em->st_id == $val){

				$pre = str_replace('{selected}', 'selected="selected"', $pre);

			}else{

				$pre = str_replace('{selected}', '', $pre);

			}

			$output .= $pre.$em->st_email.$after;

		}else{

			$cats = explode('[|]', $em->st_cat);

			foreach($cats as $c){

				if($c == $cat){

					$pre = str_replace('{id}', $em->st_id, $before);

					if($em->st_id == $val){

						$pre = str_replace('{selected}', 'selected="selected"', $pre);

					}else{

						$pre = str_replace('{selected}', '', $pre);

					}

					$output .= $pre.$em->st_email.$after;

				}

			}

		}	

	}

	return $output;

}

function cat_count($cat_id=''){
	global $wpdb, $table_prefix;
	//if($cat_id) $narrow = "WHERE st_cat LIKE '%".$cat_id."%'";
	$subs = $wpdb->get_results("SELECT st_cat FROM ".$table_prefix."st_mailinglist WHERE st_status=1");
	//print_r($subs);
	if( $cat_id ){
		foreach ($subs as $id=>$sub){
			$cats = explode('[|]', $sub->st_cat);
			foreach( $cats as $k=>$cat ){
				$ncat = str_replace("\r", '', $cat);
				$ncat = str_replace("\n", '', $ncat);
				$cats[$k] = trim($ncat);
			}
			if( !in_array( $cat_id, $cats ) ){
				unset($subs[$id]);
			}
		}
	}
	return count($subs);
}

function wp_count(){
	global $wpdb, $table_prefix;
	$users = $wpdb->get_results("SELECT ID FROM ".$table_prefix."users");
	return count($users);
}

function stnl_getcats($nid='', $type='select'){

	global $wpdb, $table_prefix;

	

	$default = $wpdb->get_var("SELECT st_cat FROM ".$table_prefix."st_newsletter WHERE st_id=".$nid);

	

	$categories = $wpdb->get_results("SELECT * FROM ".$table_prefix."st_categories WHERE st_type='nl'");

	

	if($type == 'select'){

		$before = '<option value="{id}" {selected} >';

		$after = '</option>';

	}

	foreach($categories as $cat){

		$pre = str_replace('{id}', $cat->st_id, $before);

		if($default == $cat->st_id){

			$pre = str_replace('{selected}', 'selected="selected"', $pre);

			$cur = "&laquo;";

			$curr = "&raquo;";

		}else{

			$cur='';

			$curr='';

			$pre = str_replace('{selected}', '', $pre);

		}

		$output .= $pre.$cur.$cat->st_name.$curr. ' ['. cat_count($cat->st_id) .']' .$after;

	}

	return $output;

}

function stnl_getcat_checks($values='', $hide=''){

global $wpdb, $table_prefix;

	if($values == ''){
		$default = array($wpdb->get_var("SELECT st_id FROM ".$table_prefix."st_categories WHERE st_default=1"));
	}else if(is_array($values)){
		$default = $values; 
	}else{
		$default = array($values);
	}
	if (function_exists('st_responder_manage_page'))
		$categories = $wpdb->get_results("SELECT * FROM ".$table_prefix."st_categories");
	else
		$categories = $wpdb->get_results("SELECT * FROM ".$table_prefix."st_categories WHERE st_type='nl'");

	if($hide != true){

		foreach($categories as $cat){

			$output .= '<label><input type="checkbox" name="sts_cats[]" value="'.$cat->st_id.'"';

			foreach($default as $k=>$d){

				if($d == $cat->st_id){

					$output .= ' checked="checked"';

				}

			}

			$output .= ' /> '.$cat->st_name.'</label><br />';

		}

	}else{

		foreach($categories as $cat){

			$output .= '<input style="display:none;" type="checkbox" name="sts_cats" value="'.$cat->st_id.'"';

			foreach($default as $k=>$d){

				if($d == $cat->st_id){

					$output .= ' checked="checked"';

				}

			}

			$output .= ' />';

		}

	}

	return $output;

}

function st_retrieve_account($email){

	global $wpdb, $table_prefix, $userdata, $stnl_config, $stnl_textconfig;

	

	$getuser = "SELECT * FROM ".$table_prefix."st_mailinglist WHERE st_email = '$email'";

	$account = $wpdb->get_row($getuser);



	$theextras = $account->st_extras;

	$extras = explode('[*]',$theextras);

	foreach($extras as $ext){

		$prev = $extra;

		$ex = explode('[:]', $ext);

		$extra = array( $ex[0] => $ex[1] );

		if($prev != ''){

			$extra = array_merge($prev, $extra);

		}

	}

	

	$x = st_news_q();

	$accountlink = $stnl_config['uri'].$x.'account='.$account->st_code;

	$message = stripslashes($stnl_textconfig['retrieve']);

	$html = str_replace('{account_link}', $accountlink, $message);

	foreach($extra as $type=>$ext){

			$html = str_replace('{'.$type.'}', $ext, $html);

		}	

	$subject = $stnl_textconfig['listname'].' '.__('Subscription Management', 'stnl');

	$headers  = 'MIME-Version: 1.0' . "\r\n";

	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	

	//if (wp_mail($email, $subject, $html, $headers))

		$success = __('Your subscription management link has been sent to your email address.', 'stnl');

		stnl_swift_sendmail($email, $subject, $html, $success);



}

function stnl_checkbox_js(){

?>

<script type="text/javascript"><!--

 function checkAll (obj) {

   var arrInput = document.getElementsByTagName("input");

   for (i=0; i<arrInput.length; i++) {

     if (arrInput[i].type == 'checkbox') {

       arrInput[i].checked = obj.checked;

     } else {

       //arrInput[i].value = "not a checkbox";

     }

   }

 }

 --></script>

<?php

}

?>