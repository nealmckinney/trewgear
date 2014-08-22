
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once("functions.php"); ?>
<?php require_once("meta.php"); ?>

<link href="<?php echo $rootpath?>resources/css/pdp_2013.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $rootpath?>resources/css/productwall_2013.css" rel="stylesheet" type="text/css"/>



<?php
$categoryID = "mens";
$cID = $_GET["cID"];
if ($cID != "") {
	$categoryID = $cID;
};

if ($categoryID == "mens") {
	$pageTitle = "TREW | Men's Outerwear";
} else if ($categoryID == "womens") {
	$pageTitle = "TREW | Women's Outerwear";
} else if ($categoryID == "accessories") {
	$pageTitle = "TREW | Accessories";
}

echo "<title>".$pageTitle."</title>";

/*
{"classifications":[
	{"name":"Trew Gear LLC","id":4880,"parentId":-1},
	{"name":"Men\u0027s Apparel and Accesories","id":4943,"parentId":4880},
	{"name":"Women\u0027s Outerwear","id":6429,"parentId":4880},
	{"name":"Women\u0027s Accessories and Apparel","id":6426,"parentId":4880},
	{"name":"Men\u0027s Outerwear","id":4940,"parentId":4880},
	{"name":"Unisex Apparel","id":9377,"parentId":4880},
	{"name":"Women\u0027s Apparel ","id":6428,"parentId":6426},
	{"name":"Women\u0027s Jackets","id":6430,"parentId":6429},
	{"name":"Women\u0027s Pants","id":6431,"parentId":6429},
	{"name":"Men\u0027s Accesories","id":4945,"parentId":4943},
	{"name":"Men\u0027s Apparel","id":4944,"parentId":4943},
	{"name":"Men\u0027s Jackets","id":4941,"parentId":4940},
	{"name":"Men\u0027s Pants","id":4942,"parentId":4940},
	{"name":"Women\u0027s Accessories ","id":6427,"parentId":6426},
	
	{"name":"Mens Layering","id":9365,"parentId":4941},
	{"name":"Mens Soft Shell","id":9358,"parentId":4941},
	
	{"name":"Mens Hard Shell","id":9379,"parentId":4942},
	{"name":"Mens Hard Shell","id":9296,"parentId":4941},
	
	{"name":"Mens Soft Shell","id":9380,"parentId":4942},
	{"name":"Womens Hard Shell ","id":9381,"parentId":6430},
	{"name":"Women Layering","id":9382,"parentId":6430},
	
	{"name":"Mens Insulated Shell","id":9449,"parentId":4941},
	{"name":"Mens Insulated Shell","id":9453,"parentId":4942}]}
	
	{"name":"Womens Hard Shell ","id":9383,"parentId":6431},
*/

if ($categoryID == "mens") $urlID = "Men's%20Outerwear";
if ($categoryID == "womens") $urlID = "Women's%20Outerwear";
if ($categoryID == "accessories") $urlID = "Men's%20Apparel%20and%20Accesories,Women's%20Accessories%20and%20Apparel,Unisex%20Apparel";

$json = "http://trewgear.hubsoft.ws/api/v1/products?classifications={$urlID}&extras=1";
$cachePath = "cache/{$cID}-product-wall.txt";

if (isset($_COOKIE["promotion"])) {
	$promo = $_COOKIE["promotion"];
	$json = $json . '&promotion=' . $promo;
	$promoCacheID = substr($promo, 0, 10);
	$cachePath = "cache/{$cID}-{$promoCacheID}-product-wall.txt";
}

$result = get_content($cachePath, $json, 3);
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
	
	<div class="content">
		<div id="productWall">
		
		<?php 
		if ($categoryID == "mens") {
		?>

			<h4 class="title wall-category">Hard Shell</h4>
			<?php 
			getCategories($products, "9296,9379", false);
			?>
			<div class="clear"></div>
			
			<h4 class="title wall-category">Insulated Shell</h4>
			<?php 
			getCategories($products, "9449,9453", false);
			?>
			<div class="clear"></div>
			
			<h4 class="title wall-category">Layering / Lifestyle</h4>
			<?php 
			getCategories($products, "9365", false);
			?>
			<div class="clear"></div>
			
		<?php } else if ($categoryID == "womens") { ?>
			
			<h4 class="title wall-category">Hard Shell</h4>
			<?php 
			getCategories($products, "9381,9383", false);
			?>
			<div class="clear"></div>
			
			<h4 class="title wall-category">Layering / Lifestyle</h4>
			<?php 
			getCategories($products, "9382", false);
			?>
			<div class="clear"></div>
		
		<?php } else if ($categoryID == "accessories") { ?>
			
			<h4 class="title wall-category">Accessories</h4>
			<?php 
			getCategories($products, null, false);
			?>
			<div class="clear"></div>

		<?php } ?>
			
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
	