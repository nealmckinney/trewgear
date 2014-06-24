<?php
function stnl_swift_connect($nid, $subscriber, $html, $loopsize){ 
# CONNECT TO MAIL, GET SUBSCRIBERS AND SEND TO LIST
	global $wpdb, $table_prefix, $stnl_config;
	$phpv = stnl_phpversion();
	require_once "Swift".$phpv."/lib/Swift.php";
	require_once "Swift".$phpv."/lib/Swift/Plugin/AntiFlood.php";
	
	$sendwith = $stnl_config['sendwith'];
	$server = $stnl_config['smtpserver'];
	$port = $stnl_config['smtpport'];
	$smtp_tls = $stnl_config['smtptls'];
	$user = $stnl_config['smtpuser'];
	$pass = $stnl_config['smtppass'];
	$bounce = $stnl_config['bounce'];
	$batch = $stnl_config['floodbatch'];
	$pause = $stnl_config['floodpause'];
	$fields = $stnl_config['subscribefields'];
	$from = $stnl_config['efrom'];
	$from_name = $stnl_config['efname'];
	$to_name = $stnl_config['etoname'];
	$to_custom = $stnl_config['ectoname'];
	$slog = $stnl_config['log'];
	// Flush all buffers
				ob_end_flush();  
				flush();
				$imgfolder = get_option('home').'/wp-content/plugins/st_newsletter/img/';
				$percent_per_loop = 100 / $loopsize;
				$percent_last = 0;
				$redirect_url = '';		
				$i=1;

//$html = stnl_returnhtml($nid);
//echo '<textarea style="width:90%; height:500px;">'.$html.'</textarea>';

#Get proper connection
	if($sendwith == 'sendmail'){
#SEND USING SENDMAIL
		require_once "Swift".$phpv."/lib/Swift/Connection/Sendmail.php";
		
		//Let the connection try to work out the path itself (PHP4)
		$swift =& new Swift(new Swift_Connection_Sendmail(SWIFT_SENDMAIL_AUTO_DETECT));
		
		
	}elseif($sendwith == 'smtp' || $sendwith == 'smtplocal'){
#SEND USING SMTP	
		require_once "Swift".$phpv."/lib/Swift/Connection/SMTP.php";
		require_once "Swift".$phpv."/lib/Swift/Authenticator/LOGIN.php";

		if($smtp_tls == "tls"){ 
			$smtp =& new Swift_Connection_SMTP($server, $port, SWIFT_SMTP_ENC_TLS);
		}else if($smtp_tls == "ssl"){ 
			$smtp =& new Swift_Connection_SMTP($server, $port, SWIFT_SMTP_ENC_SSL);
		}else{ 
			$smtp =& new Swift_Connection_SMTP($server, $port, SWIFT_SMTP_ENC_OFF);
		} 
		$smtp->setUsername($user);
		$smtp->setpassword($pass);
		//$smtp->attachAuthenticator(new Swift_Authenticator_LOGIN());
		$swift =& new Swift($smtp);
		
	}else{ 
#SEND USING PHP NATIVE MAIL() FUNCTION
		require_once "Swift".$phpv."/lib/Swift/Connection/NativeMail.php";
		$swift =& new Swift(new Swift_Connection_NativeMail());
	}
#ENABLE LOGGING		
	if($slog == true){
		$log =& Swift_LogContainer::getLog();
		if(stnl_phpversion() == '4'){
			$log->setLogLevel(SWIFT_LOG_FAILURES); //level 4 
		}else{
			$log->setLogLevel(Swift_Log::LOG_FAILURES); //level 4 
		}
		$log->setMaxSize($stnl_config['logmax']);
	}
	
#ENABLE FLOODING PROTECTION (DEFAULTS TO 50 EMAILS AND 5 Seconds
	$swift->attachPlugin(new Swift_Plugin_AntiFlood($batch, $pause), "anti-flood");	
	
#ENABLE THROTTLER
	require_once "Swift".$phpv."/lib/Swift/Plugin/Throttler.php";
	$throttler =& new Swift_Plugin_Throttler();
	$throttler->setEmailsPerMinute(30); //Max of 1 email every 2 seconds
	$swift->attachPlugin($throttler, "throttler");

#Enable Verbose DEBUG
	#require_once "Swift".$phpv."/lib/Swift/Plugin/VerboseSending.php";
	#$view =& new Swift_Plugin_VerboseSending_DefaultView();
	#$swift->attachPlugin(new Swift_Plugin_VerboseSending($view), "verbose");

#Make the script run until it's finished in the background
if( ini_get('safe_mode') ){
    // Do it the safe mode way
}else{
    set_time_limit(300);
}
 ignore_user_abort();


	$the_nl = $wpdb->get_row("SELECT * FROM ".$table_prefix."st_newsletter WHERE st_id=".$nid);
	
	
	
	
	$subject = $stnl_config['esubject'].$the_nl->st_title;
	
foreach($subscriber as $email){

			$rep = preg_replace("[{email}]", $email->st_email, $html);
			$rep = preg_replace("[{nid}]", $nid, $rep);
			$rep = preg_replace("[{code}]", $email->st_code, $rep);
			if($to_name == 'email'){
				$tname = $email->st_email;
			}
		
		$spec = explode('[|]', $fields);
		foreach($spec as $sp){
			$split = explode('[*]', $sp);
			$cus_fields[] = str_replace(' ', '', $split[0]);
		}
		$user_custom = explode('[*]', $email->st_extras);
		foreach($user_custom as $uc){
			$split = explode('[:]', $uc);
			$prev = $user_fields;
			$user_fields = array($split[0] => $split[1]);
			if($prev != ''){
				$user_fields = array_merge($prev, $user_fields);
			}
		}
		foreach ($cus_fields as $cf){
			$rep = preg_replace("[{".$cf."}]", $user_fields[$cf], $rep);
		}
		if($to_name != 'custom' && $tname == ''){
				$tname = $user_fields[str_replace(' ', '', $to_name)];
		}
			
			$htmlmessage = $rep;

if($to_name == 'custom'){
	$tname = $to_custom;
}

$message =& new Swift_Message($subject);	
			

#EMBED ATTACHMENTS ADD
if ($stnl_config['images'] == 'embed'){
			$splitimgs = explode('src="', $htmlmessage);
			foreach($splitimgs as $newimg){
				$imgend = strpos($newimg, '"');
				$img[] = substr($newimg, 0, $imgend);
			}
			unset($img[0]);
			$count = count($img)+1;
			$splitbks = explode('background="', $message);
			foreach($splitbks as $newimg){
				$imgend = strpos($newimg, '"');
				$img[] = substr($newimg, 0, $imgend);
			}
			unset($img[$count]);
			
			
			foreach ($img as $old){
				
				$localimg = strpos($old, get_option('home'));
				if($localimg !== false){
					$new =str_replace(get_option('home'), ABSPATH, $old);
					$simg =& new Swift_Message_Image(new Swift_File($new));
					$src = $message->attach($simg);
					$htmlmessage =& new Swift_Message_Part(str_replace($old, $src, $htmlmessage), "text/html");
				} 
			}			
			//END EMBED
}			


	#GET SEND TYPE
	$mime = $the_nl->st_mime;

	if($mime == 'multi'){
		//$message =& new Swift_Message($subject);	
		
			//ADD PLAINTEXT
			require_once('class.html2text.inc.php');
			$h2t =& new html2text($html);
			$plaintext = $h2t->get_text();
			//END PLAIN TEXT ADD
			
		$message->attach(new Swift_Message_Part($plaintext)); #text
		if ($stnl_config['images'] == 'embed'){
			$message->attach($htmlmessage);
		}else{
			$message->attach(new Swift_Message_Part($htmlmessage, "text/html")); #html
		}
	}elseif($mime == 'html'){
		//$message =& new Swift_Message($subject);
		if ($stnl_config['images'] == 'embed'){
			$message->attach($htmlmessage);
		}else{
			$message->attach(new Swift_Message_Part($htmlmessage, "text/html")); #html
		}
	}else{
		if ($stnl_config['images'] == 'embed'){
			$message->attach($htmlmessage);
		}else{
			$message =& new Swift_Message_Part($htmlmessage);
		}
	}

	
#BOUNCE DETECTION
	$message->setReturnPath(new Swift_Address($bounce));
	
	
#SEND THE EMAIL
	if($slog == true){
		
		if($to_name != 'none'){
			$swift->send($message, new Swift_Address($email->st_email, $tname),new Swift_Address($from, $from_name));
		}else{
			$swift->send($message, new Swift_Address($email->st_email), new Swift_Address($from, $from_name));
		}
		
	}else{
		if($to_name != 'none'){
			@$swift->send($message, new Swift_Address($email->st_email, $tname),new Swift_Address($from, $from_name));
		}else{
			@$swift->send($message, $email->st_email, new Swift_Address($from, $from_name));
		}
	}
	
	$percent_now = round($i * $percent_per_loop);
	   if($percent_now != $percent_last) {
	   		?><span class="percentbox" style="z-index:<?php echo $percent_now; ?>; 
	background-color: #FFFFFF;
	position:absolute;
	left: 50%;
	width: 514px;
	margin-top:-35px;
	margin-left: -257px;
	height: 30px;
	font-size: 24px;
	font-weight: bold;
	color: #999999;
	text-align: center;"><?php echo $percent_now; ?> %</span><?php
	   		$difference = $percent_now - $percent_last;
			
			for($j=1;$j<=$difference;$j++) {
			
			   echo '<img src="'.$imgfolder.'mailerbar-single.gif" width="5" height="15">';
			   }
			$percent_last = $percent_now;
		   }
		   
		// Finally, flush the output of this loop, advancing the progressbar as needed
	   flush();
	   $i = $i+1;
			}
			
		if($slog == true){
		echo '<div id="swiftlog" style="z-index:999999;background-color: #000;
		position:absolute;
		top: 335px;
		left: 20px;
		width: 500px;
		height: 300px;
		padding: 10px;
		overflow: scroll;
		font-size: 10px;
		border: solid 2px #333;
		color: #fff;"><h3>SWIFT LOG</h2><pre>';	
		echo $log->dump(true);
		echo "</pre></div>";
		}

}


function stnl_get_subscribers(){
	global $wpdb, $table_prefix, $stnl_config;
}


function stnl_swift_sendmail($email, $subject, $message, $success){ 
# CONNECT TO MAIL, GET SUBSCRIBERS AND SEND TO LIST
	global $stnl_config;
	$phpv = stnl_phpversion();
	require_once "Swift".$phpv."/lib/Swift.php";
	require_once "Swift".$phpv."/lib/Swift/Plugin/AntiFlood.php";
	
	$sendwith = $stnl_config['sendwith'];
	$server = $stnl_config['smtpserver'];
	$port = $stnl_config['smtpport'];
	$smtp_tls = $stnl_config['smtptls'];
	$user = $stnl_config['smtpuser'];
	$pass = $stnl_config['smtppass'];
	$from = $stnl_config['efrom'];
	$fname = $stnl_config['efname'];
	
	#Get proper connection
	if($sendwith == 'sendmail'){
#SEND USING SENDMAIL
		require_once "Swift".$phpv."/lib/Swift/Connection/Sendmail.php";
		
		//Let the connection try to work out the path itself (PHP4)
		$swift =& new Swift(new Swift_Connection_Sendmail(SWIFT_SENDMAIL_AUTO_DETECT));
		
	}elseif($sendwith == 'smtp'){
#SEND USING SMTP	
		require_once "Swift".$phpv."/lib/Swift/Connection/SMTP.php";
		require_once "Swift".$phpv."/lib/Swift/Authenticator/LOGIN.php";
		
		if($smtp_tls == "tls"){ 
			$smtp =& new Swift_Connection_SMTP($server, $port, SWIFT_SMTP_ENC_TLS);
		}else if($smtp_tls == "ssl"){ 
			$smtp =& new Swift_Connection_SMTP($server, $port, SWIFT_SMTP_ENC_SSL);
		}else{ 
			$smtp =& new Swift_Connection_SMTP($server, $port, SWIFT_SMTP_ENC_OFF);
		} 
		$smtp->setUsername($user);
		$smtp->setpassword($pass);
		//$smtp->attachAuthenticator(new Swift_Authenticator_LOGIN());
		$swift =& new Swift($smtp);
		
	}else{ 
#SEND USING PHP NATIVE MAIL() FUNCTION
		require_once "Swift".$phpv."/lib/Swift/Connection/NativeMail.php";
		$swift =& new Swift(new Swift_Connection_NativeMail());
	}
	 
	$msg =& new Swift_Message($subject, $message, "text/html");
	
	if ($swift->send($msg, $email, new Swift_Address($from, $fname)))
	{
		echo $success;
	}
	else
	{
		echo "Message failed to send";
	}
	 
	//It's polite to do this when you're finished
	$swift->disconnect();
}
?>