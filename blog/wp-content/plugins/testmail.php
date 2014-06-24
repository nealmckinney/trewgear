<?php
/*
Plugin Name: Mail Test
Description: PHP Mail Function Tester
Author: Matthew Robinson.
Version: 1.0
Author URI: http://subscribe2.wordpress.com
*/

function mail_test() {
//Define the following as your email address
$myemail = 'neal@summitprojects.com';
// Leave the following alone
$subject = 'WordPress Email Test';
$mailtext = 'This email was sent from your WordPress blog by the Mail Test Plugin - your emails are working for simple mail';
$headers .= "MIME-Version: 1.0\n";
$headers .= "Content-Type: text/plain; charset=\"". get_bloginfo('charset') . "\"\n";
$headers .= "From: " . 'tripp@trewgear.com' . "\n";
$headers .= "Return-Path: " . $myemail . "\n";
$headers .= "Reply-To: " . $myemail . "\n";
$headers .= "X-Mailer:PHP" . phpversion() . "\n";
$headers .= "Precedence: list\nList-Id: " . get_option('blogname') . "\n";
@mail($myemail, $subject, $mailtext, $headers);
}

// Run our code after the plugins have loaded.
add_action('plugins_loaded', 'mail_test');
?>