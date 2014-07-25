<?php
# Using HTTP_HOST

$domain = $_SERVER['HTTP_HOST'];
$rootpath = "http://{$domain}/";
$url = $_SERVER['REQUEST_URI'];
$pos = strrpos($url, "stage");
if ($pos == true) {
	$rootpath = $rootpath."stage/trewgear/";
}

?>


<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php
//$isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
// if iPad, allow layout to scale to fit minimum width:
//if ($isiPad === true) {
	//echo '<meta name="viewport" content="width=device-width" id="viewport-meta">';
//} else {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1" id="viewport-meta">';
//}
?>
<meta http-equiv="Content-Language" content="en-us" />
<meta name = "description" content = "TREW Gear makes uniquely stylish, technical ski and snowboard outerwear for your backcountry freeride adventures.">
<meta name="abstract" content= "Technical ski and snowboard outerwear">
<meta name = "keyword" content = "true gear, trewgear, trew blog, trew ski clothing, technical outerwear">
<meta name="Author" content="TREW Gear LLC">
<meta name="copyright" content="©2014 TREW Gear LLC, All rights reserved.">
<meta name="google-site-verification" content="MpahA5d53hTF03x47XvpzouRgbll4N3MOQd-lhdEXqA" />
<meta name="msvalidate.01" content="424C1652D2045E8F0E2605760EA90F53" />

<link rel="stylesheet" type="text/css" href="//cloud.typography.com/7607112/719304/css/fonts.css" />

<link href="<?php echo $rootpath?>resources/css/styles_2014.css" rel="stylesheet" type="text/css"/>
<?php //if ($isiPad === false) { ?>
<link href="<?php echo $rootpath?>resources/css/styles-responsive.css" rel="stylesheet" type="text/css"/>
<? //} ?>
<link href="<?php echo $rootpath?>resources/js/shadowbox-3.0.3/shadowbox.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo $rootpath?>resources/js/vendor/modernizr-2.6.2.min.js"></script>
