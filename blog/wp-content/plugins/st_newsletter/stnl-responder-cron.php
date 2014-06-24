<?php
//RESPONDER SENDING FUNCTIONS
//REQUIRES WP_CRON!!
function str_unsubscribe($before='If you do not wish to receive any further emails, ', $after=' to unsubscribe or edit your subscriptions.', $link='click here'){
global $wpdb, $st_newsletter_config, $j, $table_prefix;
	$x = st_news_q();
			$unsub = $before.'<a href="'.$st_newsletter_config['newsletter_uri'].$x.'account={code}">'.$link.'</a>'.$after;
			return $unsub;
}
if (function_exists('wp_cron_init')){
	add_action('wp_cron_daily', 'wp_cron_send_responders');
}
	function wp_cron_send_responders(){ //THIS WILL SEND OUT ALL INTERVALS GREATER THAN 0
		global $wpdb, $table_prefix, $st_newsletter_config;
		
		//Load in the components
									require_once('Swift/Swift.php');
									require_once('Swift/Swift/Plugin/AntiFlood.php');
									
									if ($st_newsletter_config['newsletter_sendwith'] == "smtp"){
										require_once('Swift/Swift/Connection/SMTP.php');
										if ($st_newsletter_config['newsletter_smtptls'] == "tls"){
											$swiftconn = new Swift_Connection_SMTP($st_newsletter_config['newsletter_smtpserver'], SWIFT_SECURE_PORT, SWIFT_TLS);
										} else if ($st_newsletter_config['newsletter_smtptls'] == "ssl"){
											$swiftconn = new Swift_Connection_SMTP($st_newsletter_config['newsletter_smtpserver'], SWIFT_SECURE_PORT, SWIFT_SSL);
										} else {
											$swiftconn = new Swift_Connection_SMTP($st_newsletter_config['newsletter_smtpserver']);
										}
									} elseif ($st_newsletter_config['newsletter_sendwith'] == "sendmail") {
										require('Swift/Swift/Connection/Sendmail.php');
										$swiftconn = new Swift_Connection_Sendmail;
									}
									
									//Instantiate swift
									
									
									$autore = new Swift($swiftconn);
									if ($st_newsletter_config['newsletter_sendwith'] == "smtp"){
									//Log in to the server
									$autore->authenticate($st_newsletter_config['newsletter_smtpuser'], $st_newsletter_config['newsletter_smtppass']);
									}
		
		$getml_users = "SELECT * FROM ".$table_prefix."st_mailinglist WHERE st_responder IS NOT NULL";
		$users = $wpdb->get_results($getml_users);
		
			foreach($users as $sub){
				
				$cats = unserialize($sub->st_responder);
			//	print_r($cats);
					foreach($cats as $cat=>$date){
					
						$get_messages = "SELECT * FROM ".$table_prefix."st_responder WHERE st_cat = '$cat'";
						$messages = $wpdb->get_results($get_messages);
							foreach($messages as $msg){
								$done = st_trackcheck($sub->st_id, $msg->st_id);
								if($msg->st_interval >= 1 && $done != true){
								$send = st_datecheck($msg->st_interval, $date);
								//echo $send;
								if($send == true){
								//echo "TRUE";
									//SEND THE EMAIL
									$to = $sub->st_email;
									$from = $st_newsletter_config['newsletter_efrom'];
									$subject = $msg->st_subject;
									$headers  .= 'MIME-Version: 1.0' . "\r\n";
									$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
									$headers .= 'From: '. $from . "\r\n";
									$html = $msg->st_message.'<hr /><p style="text-align:center; font-size:0.9em;"><small>'. str_unsubscribe().'</small></p>';
								//	echo '<textarea rows="20" columns="50">'.$html.'</textarea>';

									
									//Make the script run until it's finished in the background
									set_time_limit(0); ignore_user_abort();
									
												$rep = preg_replace("[{email}]", $sub->st_email, $html);
												$rep = preg_replace("[{code}]", $sub->st_code, $rep);
												$rep = preg_replace("[{first}]", $sub->st_firstnm, $rep);
												$rep = preg_replace("[{last}]", $sub->st_lastnm, $rep);
												$rep = preg_replace("[{first_fix}]", ucwords(strtolower($sub->st_firstnm)), $rep);
												$rep = preg_replace("[{last_fix}]", ucwords(strtolower($sub->st_lastnm)), $rep);
												$message = $rep;
									
								//	echo $message;
												//NEW ADD PLAINTEXT
												// Include the class definition file.
												require_once('class.html2text.inc');
												$h2t =& new html2text($message);
												$plain_part = $h2t->get_text();
												$autore->addPart($plain_part);
												//END PLAIN TEXT ADD
									
												//EMBED ATTACHMENTS ADD
									if ($st_newsletter_config['newsletter_images'] == 'embed' || $st_newsletter_config['newsletter_images'] == 'embedall'){
												$splitimgs = explode('src="', $message);
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
													if($st_newsletter_config['newsletter_images'] == 'embedall'){
													$localimg = strpos($old, 'http://');
													}else{
													$localimg = strpos($old, get_settings('siteurl'));
													}
													if($localimg !== false){
														$new =str_replace(get_settings('siteurl'), ABSPATH, $old);
														$message = str_replace($old, $autore->addImage($new), $message);
													} 
												}
									
												
												
												//END EMBED
									}			
										$autore->addPart($message, 'text/html');
										$autore->send($sub->st_email, $from, $subject);
										
										//UPDATE RESPONDER TRACKING DB
										$today = date('Ymd');
										$track = "INSERT INTO 
										".$table_prefix."st_responder_track
										(st_userid, st_catid, st_msgid, st_sent)
										VALUES
										('$sub->st_id', '$cat', '$msg->st_id', '$today')
										";
									
										$wpdb->query($track);
		
												
								}
								else{// echo "FALSE";
								}
								//$autore->close();
							}}
						
					}
			
			}$autore->close();
	}

function wp_send_firstresponder($code){ //THIS WILL SEND OUT ALL INTERVALS EQUAL TO 0 INSTANTLY
		global $wpdb, $table_prefix, $st_newsletter_config;
		
		//Load in the components
									require_once('Swift/Swift.php');
									require_once('Swift/Swift/Plugin/AntiFlood.php');
									
									if ($st_newsletter_config['newsletter_sendwith'] == "smtp"){
										require_once('Swift/Swift/Connection/SMTP.php');
										if ($st_newsletter_config['newsletter_smtptls'] == "tls"){
											$swiftconn = new Swift_Connection_SMTP($st_newsletter_config['newsletter_smtpserver'], SWIFT_SECURE_PORT, SWIFT_TLS);
										} else if ($st_newsletter_config['newsletter_smtptls'] == "ssl"){
											$swiftconn = new Swift_Connection_SMTP($st_newsletter_config['newsletter_smtpserver'], SWIFT_SECURE_PORT, SWIFT_SSL);
										} else {
											$swiftconn = new Swift_Connection_SMTP($st_newsletter_config['newsletter_smtpserver']);
										}
									} elseif ($st_newsletter_config['newsletter_sendwith'] == "sendmail") {
										require('Swift/Swift/Connection/Sendmail.php');
										$swiftconn = new Swift_Connection_Sendmail;
									}
									
									//Instantiate swift
									
									
									$autore = new Swift($swiftconn);
									if ($st_newsletter_config['newsletter_sendwith'] == "smtp"){
									//Log in to the server
									$autore->authenticate($st_newsletter_config['newsletter_smtpuser'], $st_newsletter_config['newsletter_smtppass']);
									}
		
		$getml_users = "SELECT * FROM ".$table_prefix."st_mailinglist WHERE st_responder IS NOT NULL AND st_code='$code'";
		$sub = $wpdb->get_row($getml_users);
		
			//foreach($users as $sub){
				
				$cats = unserialize($sub->st_responder);
			if($cats != ''){
					foreach($cats as $cat=>$date){
					
						$get_messages = "SELECT * FROM ".$table_prefix."st_responder WHERE st_cat = '$cat'";
						$messages = $wpdb->get_results($get_messages);
							foreach($messages as $msg){
								
								$done = st_trackcheck($sub->st_id, $msg->st_id);
								
								if($msg->st_interval == 0 && $done != true){
								$send = st_datecheck($msg->st_interval, $date);
								//echo $send;
								if($send == true){
								//echo "TRUE";
									//SEND THE EMAIL
									$to = $sub->st_email;
									$from = $st_newsletter_config['newsletter_efrom'];
									$subject = $msg->st_subject;
									$headers  .= 'MIME-Version: 1.0' . "\r\n";
									$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
									$headers .= 'From: '. $from . "\r\n";
									$html = $msg->st_message.'<hr /><p style="text-align:center; font-size:0.9em;"><small>'.str_unsubscribe().'</small></p>';
								//	echo '<textarea rows="20" columns="50">'.$html.'</textarea>';

									
									//Make the script run until it's finished in the background
									set_time_limit(0); ignore_user_abort();
									
												$rep = preg_replace("[{email}]", $sub->st_email, $html);
												$rep = preg_replace("[{code}]", $sub->st_code, $rep);
												$rep = preg_replace("[{first}]", $sub->st_firstnm, $rep);
												$rep = preg_replace("[{last}]", $sub->st_lastnm, $rep);
												$rep = preg_replace("[{first_fix}]", ucwords(strtolower($sub->st_firstnm)), $rep);
												$rep = preg_replace("[{last_fix}]", ucwords(strtolower($sub->st_lastnm)), $rep);
												$message = $rep;
									
								//	echo $message;
												//NEW ADD PLAINTEXT
												// Include the class definition file.
												require_once('class.html2text.inc');
												$h2t =& new html2text($message);
												$plain_part = $h2t->get_text();
												$autore->addPart($plain_part);
												//END PLAIN TEXT ADD
									
												//EMBED ATTACHMENTS ADD
									if ($st_newsletter_config['newsletter_images'] == 'embed' || $st_newsletter_config['newsletter_images'] == 'embedall'){
												$splitimgs = explode('src="', $message);
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
													if($st_newsletter_config['newsletter_images'] == 'embedall'){
													$localimg = strpos($old, 'http://');
													}else{
													$localimg = strpos($old, get_settings('siteurl'));
													}
													if($localimg !== false){
														$new =str_replace(get_settings('siteurl'), ABSPATH, $old);
														$message = str_replace($old, $autore->addImage($new), $message);
													} 
												}
									
												
												
												//END EMBED
									}			
										$autore->addPart($message, 'text/html');
										$autore->send($sub->st_email, $from, $subject);
										
										//UPDATE RESPONDER TRACKING DB
										$today = date('Ymd');
										$track = "INSERT INTO 
										".$table_prefix."st_responder_track
										(st_userid, st_catid, st_msgid, st_sent)
										VALUES
										('$sub->st_id', '$cat', '$msg->st_id', '$today')
										";
									
										$wpdb->query($track);
		
												
								}
								else{// echo "FALSE";
								}
								//$autore->close();
							}}
						
					}
			
			}$autore->close();
		//}
	}
?>