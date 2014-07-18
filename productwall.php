
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once("functions.php"); ?>
<?php require_once("meta.php"); ?>

<link href="<?php echo $rootpath?>resources/css/pdp_2013.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $rootpath?>resources/css/productwall_2013.css" rel="stylesheet" type="text/css"/>



<?php
$categoryID = "Jackets";
$cID = $_GET["cID"];
if ($cID != "") {
	$categoryID = $cID;
};

if ($categoryID == "jacket") $categoryID = "Jackets";
if ($categoryID == "pant") $categoryID = "Pants";
if ($categoryID == "mens") $categoryID = "Mens";
if ($categoryID == "womens") $categoryID = "Womens";




if ($categoryID == "hoodie") {
	$pageTitle = "TREW |  Hoodies";
} else if ($categoryID == "tee") {
	$pageTitle = "TREW | T-Shirts";
} else if ($categoryID == "beanie") {
	$pageTitle = "TREW | TREW Beanies";
} else if ($categoryID == "cap") {
	$pageTitle = "TREW | TREW Caps";
} else if ($categoryID == "swag") {
	$pageTitle = "TREW | Swag";
} else if ($categoryID == "Jackets") {
	$pageTitle = "TREW | Jackets";
} else if ($categoryID == "Pants") {
	$pageTitle = "TREW | Pants";
}

echo "<title>".$pageTitle."</title>";

// $prod = new Product();
// $productData = $prod->getCategoryList($categoryID);

// {"classifications":[{"name":"Trew Gear LLC","id":4880,"parentId":-1},{"name":"Men\u0027s Apparel and Accesories","id":4943,"parentId":4880},{"name":"Women\u0027s Outerwear","id":6429,"parentId":4880},{"name":"Women\u0027s Accessories and Apparel","id":6426,"parentId":4880},{"name":"Men\u0027s Outerwear","id":4940,"parentId":4880},{"name":"Unisex Apparel","id":9377,"parentId":4880},{"name":"Women\u0027s Apparel ","id":6428,"parentId":6426},{"name":"Women\u0027s Jackets","id":6430,"parentId":6429},{"name":"Women\u0027s Pants","id":6431,"parentId":6429},{"name":"Men\u0027s Accesories","id":4945,"parentId":4943},{"name":"Men\u0027s Apparel","id":4944,"parentId":4943},{"name":"Men\u0027s Jackets","id":4941,"parentId":4940},{"name":"Men\u0027s Pants","id":4942,"parentId":4940},{"name":"Women\u0027s Accessories ","id":6427,"parentId":6426},{"name":"Mens Layering","id":9365,"parentId":4941},{"name":"Mens Soft Shell","id":9358,"parentId":4941},{"name":"Mens Hard Shell","id":9379,"parentId":4942},{"name":"Mens Hard Shell","id":9296,"parentId":4941},{"name":"Mens Soft Shell","id":9380,"parentId":4942},{"name":"Womens Hard Shell ","id":9381,"parentId":6430},{"name":"Women Layering","id":9382,"parentId":6430},{"name":"Mens Insulated Shell","id":9449,"parentId":4941},{"name":"Womens Hard Shell ","id":9383,"parentId":6431},{"name":"Mens Insulated Shell","id":9453,"parentId":4942}]}

$urlID = "Men's%20Jackets,Women's%20Jackets";
if ($categoryID == "Pants") $urlID = "Men's%20Pants,Women's%20Pants";
if ($categoryID == "mens-apparel") $urlID = "Men's%20Apparel%20and%20Accesories";
if ($categoryID == "womens-apparel") $urlID = "Women's%20Accessories%20and%20Apparel";

//if ($categoryID == "Mens") $urlID = "Men's%20Jackets,Men's%20Pants,Men's%20Apparel%20and%20Accesories";
if ($categoryID == "Mens") $urlID = "Men's%20Outerwear";
//if ($categoryID == "Womens") $urlID = "Women's%20Jackets,Women's%20Pants,Women's%20Accessories%20and%20Apparel";
if ($categoryID == "Womens") $urlID = "Women's%20Outerwear";
if ($categoryID == "Apparel") $urlID = "Men's%20Apparel%20and%20Accesories,Women's%20Accessories%20and%20Apparel";

if ($categoryID == "mens-jackets") $urlID = "Men's%20Jackets";
if ($categoryID == "mens-pants") $urlID = "Men's%20Pants";

if ($categoryID == "womens-jackets") $urlID = "Women's%20Jackets";
if ($categoryID == "womens-pants") $urlID = "Women's%20Pants";

$json = "http://trewgear.hubsoft.ws/api/v1/products?classifications={$urlID}&extras=1";
//$json = "http://trewgear.hubsoft.ws/api/v1/products?extras=1";
// http://trewgear.hubsoft.ws/api/v1/products?promotion=GFFAZKQV
// TGF13-W112-GRY 
//$json = $json . '&promotion=GFFAZKQV';
//echo $json;
//$jsonfile = file_get_contents($json);


//$ch =  curl_init($json);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//$result = curl_exec($ch);

$result = get_content("cache/{$cID}-product-wall.txt", $json, 3);

//print_r($result);

$info = json_decode($result);
$products = $info->products;

function getProductColors($theId, $products, $defaultFile) {
	$stringy = "<div class='rotation-nav'>";
	$len = count($products);
	for ($i=0; $i < $len; $i++) {
		$item = $products[$i];
		$id = $item->productUID;
		$filePath = $item->images[0];
		$hex = str_replace("#", "", $item->colorValue);
		$class = ($filePath == $defaultFile) ? 'multi-nav-item selected' : 'multi-nav-item';
		if ($theId == $id) {
			$stringy .= "<div class='$class' style='background-color:#$hex;' data-name='$item->colorName' data-image='$filePath'><div class='indicator animated'></div></div>";
		}
	}
	return $stringy .="</div>";
}

function catMatch($classification, $cats) {
	$found = false;
	$theCats = explode(",", $cats);
	$len = count($theCats);
	for ($i=0; $i < $len; $i++) {
		if ($classification == $theCats[$i]) {
			$found = true;
			break;
		}
	}
	return $found;
}

function getCategories($products, $cats) {
	$ids = [];
	global $rootpath;
	$len = count($products);
	for ($i=0; $i < $len; $i++) {
		$item = $products[$i];

		$productNumber = $item->productNumber;

		if (strpos($productNumber, "TGF14") !== false) {
			$filePath = $item->images[0];
			$name = $item->productName;
			$price = $item->sizes[0]->unitPrice;
			$classifications = $item->classifications;
			$len2 = count($item->classifications);
			for ($j=0; $j < $len2; $j++) {

				$classification = $item->classifications[$j]->ClassificationUID;
				$id = $item->productUID;
				//echo $classification."<br/>";
				if (catMatch($classification, $cats) && !in_array($id, $ids)) {
					$ids[] = $id;
					//if ($filePath && strpos($item->images[0], "disabled") === false) {
					    echo "<div class='wallItem' data-prod-num='$productNumber' data-name='$name'><div class='imageCenter'><a href='{$rootpath}pdp.php?uID={$id}'><img src='{$filePath}'/></a></div><a href='{$rootpath}pdp.php?uID={$id}'><h4 class='title'>$name</h4></a><p class='price'>$$price</p>";
						echo getProductColors($id, $products, $filePath);
						echo "</div>";
					//}
				}
			}
		}
	}
}

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
		if ($categoryID == "Mens") {
		?>

			<h4 class="title wall-category">Hard Shell</h4>
			<?php 
			getCategories($products, "9296");
			?>
			<div class="clear"></div>
			
			<h4 class="title wall-category">Insulated Shell</h4>
			<?php 
			getCategories($products, "9449");
			?>
			<div class="clear"></div>
			
			<h4 class="title wall-category">Layering / Lifestyle</h4>
			<?php 
			getCategories($products, "9365");
			?>
			<div class="clear"></div>
			
		<?php } else if ($categoryID == "Womens") { ?>
			
			<h4 class="title wall-category">Hard Shell</h4>
			<?php 
			getCategories($products, "9381,9383");
			?>
			<div class="clear"></div>
			
			<h4 class="title wall-category">Insulated Shell</h4>
			<?php 
			getCategories($products, "9453");
			?>
			<div class="clear"></div>
			
			<h4 class="title wall-category">Layering / Lifestyle</h4>
			<?php 
			getCategories($products, "9382");
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
				var img = $(this).data("image");
				$(this).parent().parent().find(".imageCenter img").attr("src", img);
				$(this).parent().find(".multi-nav-item").removeClass("selected");
				$(this).addClass("selected");
			});
		});
	</script>
	
</div>
</body>
</html>
	