<?php
$authcode = $_GET["authcode"];
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
		            <h3>TREW Pro Program</h3>
					<h5 style="color:#000;">Enter your one time use code here:</h5>
		        </div>
		        <div class="modal-body">
		            <input type="text" id="authCode" required="" class="email" placeholder="promo code">
		        </div>
		        <div class="modal-footer">
		            <button type="submit" class="btn btn-primary" id="promoBtn">Submit</button>
		        </div>
				<h3 id="message" style="color:#000; display:none;">Looking up code...</h3>
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

			(function () {
				
				$("#promoBtn").on("click", function(e) {
					var authcode = $("#authCode").val();
					if (authcode) {
						$("#message").fadeIn();
						emeraldcode.validateAuthCode({code : authcode}, function(data) {
							if (data.success) {
								var promoCookie = $.cookie("promotion");
							    $("#message").html("Code has been validated. Shop now!");
								setTimeout(goHome, 2000);
							} else {
							     $("#message").html('bad authorization code: ' + authcode);
							}
						});
					}
					e.preventDefault();
				})
				
				
				var authcode = "<?php echo $authcode; ?>";
				//console.log("authcode: "+authcode);
				emeraldcode.clientid = 'trewgear';
                emeraldcode.ready(function () {
							//                     emeraldcode.validateAuthCode({code : authcode}, function(data) {
							//                         if (data.success) {
							// var promoCookie = $.cookie("promotion");
							//                             $("#message").html("Code has been validated. Shop now!");
							// setTimeout(goHome, 2000);
							//                         } else {
							//                             $("#message").html('bad authorization code: ' + authcode);
							//                         }
							//                     });
                });
            })();

			</script>

		</div>
	</div>
	<?php require_once("footer.php"); ?>
</div>
</body>
</html>
