<?php
function stnl_subscribe($buttontext='Subscribe') {
	
	global $wpdb, $table_prefix, $stnl_config, $stnl_textconfig;
	
	$j = st_q(st_formuri());
	
	
	if ( isset($_GET['verify'])) {
	$code = $_GET['verify'];
		st_mailinglist_verified($code);
	}elseif( isset($_GET['retrieve_account'])){
		st_retrieve_account($_POST['email']);
	}elseif ( isset($_POST['mailinglist_subscriber']) AND $_GET['subscribe'] == "true") {
		
		//CHECK THE REQUIRED FIELDS!!
		if($_POST['sts_email'] == ''){$error .= __("Please enter an email address.<br />", 'stnl');}
		if($_POST['sts_cats'] == ''){$error .= __("Please select a category.<br />", 'stnl');}
		$extrafields = explode('[|]',$stnl_config['subscribefields']);
		foreach($extrafields as $af){
			$split = explode('[*]', $af);
			$prev = $thefields;
			$thefields = array($split[0] => $split[1]);
			if($prev != ''){
				$thefields = array_merge($prev, $thefields);
			}
		}
		foreach($thefields as $field=>$req){
			$safefield = str_replace(' ', '', $field);
			if($req == "Yes"){
				if($_POST[$safefield] == ''){$error .= __("Please enter your ", 'stnl').$field.".<br />";}
			}
		}
		
		if($error != ''){
			echo $error;
			echo st_subscribe_form('', $buttontext);
		}else{
		
			//Check if already Subscribed
			$tempemail = $_POST['sts_email'];
			$st_dupe = $wpdb->get_results("SELECT * FROM " . $table_prefix . "st_mailinglist WHERE st_email ='" . $tempemail ."'");
			if ($st_dupe){
				foreach ( $st_dupe as $dupe ) {
					
					if($dupe->st_status == "0"){
					$uri = str_replace($j."subscribe=true", "", $_SERVER['REQUEST_URI']);
					$resend = $uri.$j."resend=".urlencode($dupe->st_email);
					$dupeunv = str_replace('{resend_link}', $resend, $stnl_textconfig['dupeunv']);
					echo stripslashes($dupeunv);
				
					} else if($dupe->st_status == "3"){
						st_mailinglist_insert_update();
					}else{
					
					$dupeverified = stripslashes($stnl_textconfig['dupev']);
					
					$form = '<form action="'.st_formuri().$j.'retrieve_account=true" method="post">
			<label for="email">'.__('Email:', 'stnl').'</label> <input type="text" name="email" id="email" value="'.$_POST['sts_email'].'" /> <input type="submit" value="'.__("Send Account Link", 'stnl').'" /><br />';
						$dv = str_replace('{retrieve_account}', $form, $dupeverified);
						echo $dv;
					
					}
				}
			}else{
				
				//Subscribe the email!
				st_mailinglist_insert_input();	
				
			}
		}
	} elseif ( isset($_GET['resend'])) {
			$email = $_GET['resend'];
			$resend = $wpdb->get_row("SELECT * FROM " . $table_prefix . "st_mailinglist WHERE st_email ='" . $email ."'");
			
				if ($resend){
				$success = __("Verification Email has been re-sent.", 'stnl');
				st_regmail($email,$resend->st_code,$success); 
				}else{
					echo __('There was an error sending your verification email to ', 'stnl').$email.__('. Please contact us for further help in this matter.', 'stnl');  
				}
	} elseif ( isset($_GET['account'])) {
	
			
			if ($_POST['update'] == true){
		$code = $_POST['update'];
		
	
		if($_POST['sts_unsubscribe'] == true){
			// Set to unsubscribe status
			if($stnl_config['unsubscribe'] == 'delete'){
				$SQL = "DELETE FROM ".$table_prefix."st_mailinglist WHERE st_code = '$code'";
			}else{
				$SQL = "UPDATE ".$table_prefix."st_mailinglist SET st_status = '3' WHERE st_code = '$code'";
			}
			if ( !$wpdb->query($SQL) ) {
				_e('There was an error unsubscribing your email address.  Please contact the site owner for further help in this matter', 'stnl');
			}else{
			echo '<fieldset class="editaccount" style="border:solid 2px $000000;" ><legend><strong>'.__('Edit Subscription', 'stnl').'</strong></legend>';
				_e('<strong>You have been unsubscribed.</strong>', 'stnl');
		echo '</fieldset>';
			}
		}else{
			$email = $_POST['sts_email'];
			$cats = $_POST['sts_cats'];
			foreach($_POST as $key=>$val){
			if($key != 'sts_email' || $key != 'sts_cats' || $key != 'submit'){
				$extras .= str_replace(' ', '', $key).'[:]'.$val.'[*]';
			}
		}
			$extras = rtrim($extras, '[*]');
			
						
			/* Query */
			$postquery = "UPDATE
			".$table_prefix."st_mailinglist SET st_email='$email', st_extras='$extras', st_cat='$cats' WHERE st_code='$code'";
		
			$wpdb->query($postquery);
	
			echo '<fieldset class="editaccount" style="border:solid 2px $000000;" ><legend><strong>'.__('Edit Subscription', 'stnl').'</strong></legend>';
				_e('<strong>Account Updated</strong>', 'stnl');
		echo '</fieldset>';
		
		}		
	
			} else {
			$code = $_GET['account'];
			$nodupe = $wpdb->get_row("SELECT * FROM " . $table_prefix . "st_mailinglist WHERE st_code ='" . $code ."'");
			$status = $nodupe->st_status;
			if ($nodupe && $status != '3'){
		
		echo '<fieldset class="editaccount" style="border:solid 2px $000000;" ><legend><strong>'.__('Edit Subscription', 'stnl').'</strong></legend>';
		echo st_subscribe_form($code, $buttontext);
		echo '</fieldset>';
			
				}
				else {_e("<strong>This account is no longer subscribed.</strong> <br /><small>What a shame! Go ahead and re-subscribe, we won't mind!</small>", 'stnl');
				echo st_subscribe_form('', $buttontext);
				}
			}
	
	} else {
	
	
	echo st_subscribe_form('', $buttontext);
	
	}

}

function st_subscribe_form($code='', $buttontext='Subscribe'){
global $wpdb, $table_prefix, $stnl_config;

$getuser = "SELECT * FROM ".$table_prefix."st_mailinglist WHERE st_code = \"$code\"";
	$account = $wpdb->get_row($getuser);
$j = st_q();
$e_fields = $stnl_config['subscribefields'];
	$ef_arr = explode('[|]', $e_fields);
	foreach($ef_arr as $ef){
		$split = explode('[*]', $ef);
		$prev = $efields;
		$efields = array($split[0] => $split[1]);
		if($prev != ''){
			$efields = array_merge($prev, $efields);
		}
	}
	
	if($account == true){
		$email = $account->st_email;
		$extras = $account->st_extras;
		$code = $account->st_code;
		$cats = explode('[|]', $account->st_cat);
	}else{
		$email = $_POST['sts_email'];
		$cats = $_POST['sts_cats'];
		
		foreach($_POST as $key=>$val){
			if($key != 'sts_email' && $key != 'sts_cats' && $key != 'submit'){
				$extras .= str_replace(' ', '', $key).'[:]'.$val.'[*]';
			}
		}
		$extras = rtrim($extras, '[*]');
		
		$earr = explode('[*]', $extras);
		foreach($earr as $ex){
			$split = explode('[:]',$ex);
			$prev = $uextra;
			$uextra = array($split[0] => $split[1]);
			if($prev != ''){
				$uextra = array_merge($prev, $uextra);
			}
		}
	}
$required = $stnl_config['req'];
$formuri = st_uri();

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

?>
 	     
	<?php if ($account != true){ 
		echo'<form action="'.st_formuri().$j.'subscribe=true" method="post" class="subscribeform">';
		}else{ echo'<form id="stnl_form" action="'.st_formuri().$j.'account='.$code.'" method="post" class="subscribeform">';} ?>
		
	<input type="hidden" name="mailinglist_subscriber" value="true" />
	
<p><label for="email"><?php _e('Email:', 'stnl');?> <br />
<input type="text"  name="sts_email" id="email" value="<?php echo $email;?>" /> <?php  echo $required; ?></label></p>
	
<?php foreach($efields as $key=>$val){
	if($key != ''){
	$safekey = str_replace(' ', '', $key);
?>
		<p><label for="<?php echo $safekey;?>"><?php echo $key;?>: <br />
<input type="text"  name="<?php echo $safekey;?>" id="<?php echo $safekey;?>" value="<?php echo $extra[$safekey];?>" /> <?php if ($val == 'Yes'){ echo $required; } ?></label></p>
<?php
	}
 } if($stnl_config['cats'] == true){ ?>
 	<p><?php _e('Categories:', 'stnl');?> <br />
<?php	echo stnl_getcat_checks($cats); ?>
	</p>
<?php }else {echo stnl_getcat_checks($cats, true);}
	if ($account == true){
		echo '<p><label for="unsubscribe"><input type="checkbox" name="sts_unsubscribe" id="unsubscribe" />'.__('Unsubscribe', 'stnl').'</label></p>';
		echo '<input type="hidden" name="update" value="'.$code.'" /><input type="submit" value="'.__('Update', 'stnl').'" id="stnl_submit" name="submit" />';
	}else{
		echo '<input type="submit" id="stnl_submit" value="'.$buttontext.'" name="submit" />';
	}
?>
</form>
<?php
}

function st_mailinglist_subscribe($action='', $buttontext='Subscribe'){
	stnl_subscribe($buttontext);
}
?>