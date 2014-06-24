<?php
$apikey = '720989656c390355bbdc26ad365282fa-us4';
$listID = '993cb1dae7'; //main
//$listID = 'c1f502c27b'; //test


//$_POST['email'] = "neal_mckinney@yahoo.com";
//$_POST['signup'] = "true";
//$_POST['name'] = "Neal Mckinney";

if (preg_match("(\w[-._\w]*\w@\w[-._\w]*\w\.\w{2,})", $_POST['email'])) {
	$email = $_POST['email'];
	$name = $_POST['name'];

	
	if (!empty($_POST['signup'])) {
		$url = sprintf('http://us4.api.mailchimp.com/1.3/?method=listSubscribe&apikey=%s&id=%s&email_address=%s&merge_vars[OPTINIP]=%s&merge_vars[MERGE1]=%s&output=json', $apikey, $listID, $email, $_SERVER['REMOTE_ADDR'], $name);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);
		curl_close($ch);
		$arr = json_decode($data, true);
		if ($arr == 1) {
			echo 'success';
		} else {
			switch ($arr['code']) {
				
				case 502:
				echo 'Signup Error: Invalid email address.';
				break;
				
				case 214:
				echo 'Signup Error: You are already subscribed.';
				break;
				// check the MailChimp API for more options
				default:
				echo $arr['code'].' Unkown error...';
				break;			
			}
		}
	} else {
		//echo 'generic contact message inquiry: '.$inquiry;
		echo 'Thank you for your inquiry!';
	}
} else {
	echo 'Error: Email field is required.';
}

?>