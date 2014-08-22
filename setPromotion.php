<?php
$promotion = $_GET["promotion"];
?>


<!doctype html>
<head>
<title>TREW | stylish and technical ski/snowboard outerwear</title>
<meta name = "Title" content = "TREW | stylish and technical ski/snowboard outerwear"/>
<meta property="og:image" content="http://trewgear.com/resources/images/nav/logo_2013.png"/>
<?php require_once("meta.php"); ?>

<link href="//api.hubsoft.ws/demo/css/checkout.css" rel="stylesheet" type="text/css"/>
<link href="/resources/css/styles_2014.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="/resources/js/vendor/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/resources/js/jquery-more.js"></script>
<script type="text/javascript" src="/resources/js/vendor/jquery.cookie.js"></script>
<script type="text/javascript" src="/resources/js/vendor/modernizr-2.6.2.min.js"></script>


</head>
<body>
<div id="outer">
	<?php require_once("navigation.php");?>
	<div style="background:#fff; min-height:600px;">
		<div class="content" id="accountPage" style="padding-top:100px;">

			
			<form action="#" class="form-inline modal in" id="signInForm" tabindex="-1" role="dialog" style="display: block; ">
		        <div class="modal-header">
		            <h3>TREW Special Promotions</h3>
		        </div>
				<h3 id="message" style="display:none; color:#000; font-size:22px;">Promotion is set and you will now be redirected to the homepage!</h3>
		    </form>
			
			
			<!-- this is the required script files to run the demo -->
			<!-- <script type="text/javascript" src="/resources/js/json2.js"></script>
			<script src="//api.hubsoft.ws/js/cartgui.js"></script>
			<script src="//api.hubsoft.ws/js/api.js"></script> -->
			<script src="//api.hubsoft.ws/@js"></script>
			
			<script type="text/javascript" src="/resources/js/main.js"></script>


			<script>
			
			function goHome() {
				window.location.href = "/";
			}

			$(document).ready(function() {
				hubsoft.clientid = 'trewgear';
				var promotion = "<?php echo $promotion; ?>";
				//console.log("promotion: "+promotion);
				//if (promotion == "GFFAZKQV") {
					$.cookie('promotion', promotion, { expires: 1, path: '/' });
					 $("#message").fadeIn();
					setTimeout(goHome, 2000);
				//}
			});
				

				
				
				
				



			</script>

		</div>
	</div>
	<?php require_once("footer.php"); ?>
</div>
</body>
</html>
