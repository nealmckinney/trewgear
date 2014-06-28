<?php
$json = "http://trewgear.hubsoft.ws/api/v1/productColors?productUID=105723";
$ch =  curl_init($json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$info = json_decode($result);
$colors = $info[0]->colors;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>TREW | Ski/Snowboard Outerwear – Hood River, OR</title>
<?php require_once("meta.php"); ?>
<link href="resources/css/styles_2014.css" rel="stylesheet" type="text/css"/>
<link href="/resources/css/styles-responsive.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="/resources/js/vendor/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/resources/js/jquery-more.js"></script>
<script type="text/javascript" src="/resources/js/modernizr-2.5.3.min.js"></script>

<!-- <script type="text/javascript" src="resources/js/json2.js"></script>
<script src="//api.hubsoft.ws/js/cartgui.js"></script>
<script src="//api.hubsoft.ws/js/api.js"></script>
<script src="//api.hubsoft.ws/js/plugins/ejs.js"></script> -->
<script src="//api.hubsoft.ws/@js"></script>

<script type="text/javascript" src="/resources/js/main.js"></script>

</head>
<body>
	
<div id="outer">

	<?php 
	require_once("navigation.php");
	?>

	<div id="content">
		<div class="page-marquee" style="background:#fff url(/resources/images/tour/tour-header.jpg) top center no-repeat;"></div>
		<div class="content">
			<p class="photoCredit about">Photo By Lance Koudele</p>
			<h2>Tour Schedule</h2>
			<?php
			echo $info[0]->descriptions[0];
			?>

		</div><!-- content -->
	<?php 
	require_once("footer.php");
	?>

</div><!-- outer -->

</body>