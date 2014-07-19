<?php
$json = "http://trewgear.hubsoft.ws/api/v1/productColors?productUID=105723";
$ch =  curl_init($json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$info = json_decode($result);
$colors = $info[0]->colors;
?>

<!doctype html>
<head>
<title>TREW | Ski/Snowboard Outerwear – Hood River, OR</title>
<?php require_once("meta.php"); ?>
</head>
<body>
	


	<?php 
	require_once("navigation.php");
	?>
	
	<div class="page-header">
		<div class="content overflow-hidden">
			<div class="vertical-center">
				<h1 class="title white">Tour Schedule</h1>
			</div>
		</div>
	</div>


		<div class="content">
			<?php
			echo $info[0]->descriptions[0];
			?>

		</div>
	<?php 
	require_once("footer.php");
	?>



</body>
</html>