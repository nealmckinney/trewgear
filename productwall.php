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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once("meta.php"); ?>

<link href="/resources/css/styles_2014.css" rel="stylesheet" type="text/css"/>
<link href="/resources/css/pdp_2013.css" rel="stylesheet" type="text/css"/>
<link href="/resources/css/productwall_2013.css" rel="stylesheet" type="text/css"/>
<link href="/resources/css/styles-responsive.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="/resources/js/vendor/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/resources/js/jquery-more.js"></script>
<script type="text/javascript" src="/resources/js/vendor/jquery.cookie.js"></script>
<script type="text/javascript" src="/resources/js/modernizr-2.5.3.min.js"></script>

<script type="text/javascript" src="/resources/js/core/events/EventDispatcher.js"></script>
<script type="text/javascript" src="/resources/js/core/ui/ButtonGroup.js"></script>
<script type="text/javascript" src="/resources/js/product/Wall.js"></script>

<!-- <script type="text/javascript" src="/resources/js/json2.js"></script>
<script src="//api.hubsoft.ws/js/cartgui.js"></script>
<script src="//api.hubsoft.ws/js/api.js"></script>
<script src="//api.hubsoft.ws/js/plugins/ejs.js"></script> -->
<script src="//api.hubsoft.ws/@js"></script>

<script type="text/javascript" src="/resources/js/main.js"></script>

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

$urlID = "Men's%20Jackets,Women's%20Jackets";
if ($categoryID == "Pants") $urlID = "Men's%20Pants,Women's%20Pants";
if ($categoryID == "mens-apparel") $urlID = "Men's%20Apparel%20and%20Accesories";
if ($categoryID == "womens-apparel") $urlID = "Women's%20Accessories%20and%20Apparel";

if ($categoryID == "Mens") $urlID = "Men's%20Jackets,Men's%20Pants,Men's%20Apparel%20and%20Accesories";
if ($categoryID == "Womens") $urlID = "Women's%20Jackets,Women's%20Pants,Women's%20Accessories%20and%20Apparel";
if ($categoryID == "Apparel") $urlID = "Men's%20Apparel%20and%20Accesories,Women's%20Accessories%20and%20Apparel";

if ($categoryID == "mens-jackets") $urlID = "Men's%20Jackets";
if ($categoryID == "mens-pants") $urlID = "Men's%20Pants";

if ($categoryID == "womens-jackets") $urlID = "Women's%20Jackets";
if ($categoryID == "womens-pants") $urlID = "Women's%20Pants";

$json = "http://trewgear.hubsoft.ws/api/v1/products?classifications={$urlID}";
// http://trewgear.hubsoft.ws/api/v1/products?promotion=GFFAZKQV
// TGF13-W112-GRY 
//$json = $json . '&promotion=GFFAZKQV';
//echo $json;
//$jsonfile = file_get_contents($json);
$ch =  curl_init($json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$info = json_decode($result);
$products = $info->products;

?>

</head>
<body onload="init();">
<div class="tooltip"></div>
<div id="outer">

	<?php 
	require_once("navigation.php");
	?>
	
	<div id="productWall">
		<?php 
		//print_r($categoryID);
		//print_r($info->products);
		
		$len = count($products);
		for ($i=0; $i < $len; $i++) {
			$item = $products[$i];
			
			$productNumber = $item->productNumber;
			
			//echo "prodNumber: ".$productNumber;
			
			if (strpos($productNumber, "TGF13") !== false || $productNumber === "TG-37-BLKG" || $productNumber === "TG-37-BLKO") {
				$filePath = $item->images[6];
				$name = $item->productName;
				// $inStock = true;
				// $len2 = count($item->sizes);
				// for ($j=0; $j < $len2; $j++) {
				// 	if ($item->sizes[$j]->outOfStock == true) {
				// 		$inStock = false;
				// 	}
				// }	

				if ($filePath && strpos($item->images[0], "disabled") === false) {
				    echo "<a class='wallItem' id='wallItem{$i}' data-name='$name' href='{$rootpath}pdp.php?uID={$item->productUID}'><div class='imageCenter'><img src='{$filePath}'/></div></a>";
				}
			}
			
		}
		
		$wallItems = json_encode($products);
		
		?>
	</div>
		
	<?php 
	require_once("footer.php");
	?>
	
	<script>
		function init() {
			var wallItems = <?php echo $wallItems; ?>;
			new Wall(wallItems);
		}
	</script>
	
</div>
</body>
</html>
	