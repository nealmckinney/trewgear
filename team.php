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

<?php require_once("functions.php"); ?>

<!doctype html>
<head>
<title>TREW | TREW Team</title>
<?php require_once("meta.php"); ?>

<?php

// team:
$json = "http://trewgear.hubsoft.ws/api/v1/products?tags=team&extras=1";
$result = get_content("cache/team.txt", $json, 3);
$info = json_decode($result);
$products = $info->products;

?>


</head>
<body>
	

	
	<?php 
	require_once("navigation.php");
	?>
	
	<div class="page-header">
		<div class="content overflow-hidden">
			<div class="vertical-center">
				<h1 class="title white">Team</h1>
			</div>
		</div>
	</div>
	
	<div class="content">
		<div class="team-grid">
			<?php 
			$len = count($products);
			for ($i=0; $i < $len; $i++) {
				$item = $products[$i];
				$image = $item->images[0];
				$name = $item->productNumber;
				echo "<div class='team-member'>";
				echo "<div class='image circle' style='background-image:url($image);'></div>";
				echo "<h4 class='title'>$name</h4>";
				echo "</div>";
				//echo $item->descriptions[0];
			}
			?>
		</div>
	</div>
	
	<?php 
	require_once("footer.php");
	?>
	

</body>
</html>