
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once("functions.php"); ?>
<?php require_once("meta.php"); ?>

<link href="<?php echo $rootpath?>resources/css/pdp_2013.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $rootpath?>resources/css/productwall_2013.css" rel="stylesheet" type="text/css"/>



<?php

function getTags($products, $tag) {
	$ids = array();
	global $rootpath;
	$len = count($products);
	for ($i=0; $i < $len; $i++) {
		$item = $products[$i];

		$productNumber = $item->productNumber;

		if (strpos($productNumber, "TGF14") !== false) {
			$filePath = $item->images[0];
			$name = $item->productName;
			$msrp = $item->sizes[0]->msrp;
			$unitPrice = $item->sizes[0]->unitPrice;
			
			if ($unitPrice != $msrp) {
				$price = "<span class='discounted'><span class='crossed'>\${$msrp}</span> \${$unitPrice}</span>";
			} else {
				$price = "<span>\${$unitPrice}</span>";
			}
			
			$tags = $item->tags;
			$id = $item->productUID;
			
			if (in_array($tag, $tags) && !in_array($id, $ids)) {
				$ids[] = $id;
				echo "<div class='wallItem' data-prod-num='$productNumber' data-name='$name'><div class='imageCenter'><a href='{$rootpath}pdp.php?uID={$id}'><div class='button-wrap'><div class='button radius animated'>Learn More</div></div><img src=''/></a></div><a href='{$rootpath}pdp.php?uID={$id}'><h4 class='title'>$name</h4></a><p class='price'>$price</p>";
				echo getProductColors($id, $products);
				echo "</div>";
			}

		}
	}
}


$pageTitle = "TREW | Exclusives";
echo "<title>".$pageTitle."</title>";

$json = "http://trewgear.hubsoft.ws/api/v1/products?tags=exclusive&extras=1";
$cachePath = "cache/exclusive-product-wall.txt";

if (isset($_COOKIE["promotion"])) {
	$promo = $_COOKIE["promotion"];
	$json = $json . '&promotion=' . $promo;
	$promoCacheID = substr($promo, 0, 10);
	$cachePath = "cache/exclusive-{$promoCacheID}-product-wall.txt";
}

$result = get_content($cachePath, $json, 1);
$info = json_decode($result);
$products = $info->products;
?>

</head>
<body>
<div class="tooltip"></div>
<div id="outer">

	<?php 
	require_once("navigation.php");
	?>
<div class="exclusives">
	<div class="content">
		<div id="productWall">


			<h4 class="title wall-category">Shirts</h4>
			<?php 
			getTags($products, "exclusive shirt");
			?>
			<div class="clear"></div>
			
			<h4 class="title wall-category">TRUCE Co-Lab</h4>
			<?php 
			getTags($products, "exclusive truce");
			?>
			<div class="clear"></div>
			
			<h4 class="title wall-category">NWAC Partnership</h4>
			<?php 
			getTags($products, "exclusive nwac");
			?>
			<div class="clear"></div>

			
		</div>
	</div>
</div>		
	<?php 
	require_once("footer.php");
	?>
	
	<script>
		$(document).ready(function() {
			$(".wallItem .multi-nav-item").on("click", function() {
				var navItem = $(this);
				var img = $(this).data("image");
				//$(this).parent().parent().find(".imageCenter img").attr("src", img);
				var image = $(this).parent().parent().find(".imageCenter img");
				var parent = image.parent().parent();
				
				if (img) {
					if ($(this).attr("data-loaded")) {
						image.css("opacity", .5);
						image.attr("src", img);
						image.animate({"opacity":1}, 500, "easeOutQuad");
					} else {
						image.animate({"opacity":.5}, 250, "easeOutQuad");
						addLoader(parent);
						image.on("load", function() {
							$(this).stop(true).animate({"opacity":1}, 500, "easeOutQuad");
							navItem.attr("data-loaded", "true");
							removeLoader(parent);
						});
						image.attr("src", img);
					}
				}
				
				$(this).parent().find(".multi-nav-item").removeClass("selected");
				$(this).addClass("selected");
			});
			
			$(".wallItem").each(function() {
				var colors = $(this).find(".multi-nav-item");
				var defaultColor = $(this).find(".multi-nav-item[data-tags*='default-color']");
				var start = (defaultColor.length == 1) ? defaultColor : colors[0];
				start.click();
			});
		});
	</script>
	
</div>
</body>
</html>
	