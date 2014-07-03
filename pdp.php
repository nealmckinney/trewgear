<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
<?php require_once("functions.php"); ?>

<?php

$domain = $_SERVER['HTTP_HOST'];
$rootpath = "http://{$domain}/";
$url = $_SERVER['REQUEST_URI'];
$pos = strrpos($url, "stage");
if ($pos == true) {
	$rootpath = $rootpath."stage/trewgear/";
}

// default to Cosmic
$productNumber = "TG-40-BLK";
$productID = "";

// for old URLS:
$pID = $_GET["pID"];
if ($pID != "") {
	$productID = $pID;
};

$uID = $_GET["uID"];
if ($uID != "") {
	$productUID = $uID;
};

if ($pID != "") {
	switch ($productID) {

		case "cosmic":
		$productUID = 79402;
		break;

		case "powfunk":
		$productUID = 79420;
		break;

		case "bellows":
		$productUID = 79419;
		break;

		case "eaglepant":
		$productUID = 79423;
		break;

		case "trewthbib":
		$productUID = 79424;
		break;

		case "wyeast":
		$productUID = 79422;
		break;
		
		case "ripcitysoftshell":
		$productUID = 69669;
		break;
		
		case "stella":
		$productUID = 79425;
		break;
		
		case "chariot":
		$productUID = 79499;
		break;
		
		case "overtheshoulder":
		$productUID = 79512;
		break;
		
		case "stellazip":
		$productUID = 79510;
		break;
		
		case "swift":
		$productUID = 79421;
		break;
		
		case "vaporizer":
		$productUID = 79502;
		break;
		
		case "womens-vaporizer":
		$productUID = 79503;
		break;
		
		case "polarshift":
		$productUID = 79500;
		break;

		default:
		$productUID = 67492;
	}
}


$pageTitle = "";

if ($productID == "cosmic") {
	$pageTitle = "TREW | Cosmic Jacket – lightweight ski/snowboard shell";
} else if ($productID == "bellows") {
	$pageTitle = "TREW | Bellows Jacket – backcountry ski/snowboard shell";
} else if ($productID == "powfunk") {
	$pageTitle = "TREW | Powfunk Jacket – stylish ski/snowboard shell";
} else if ($productID == "trewthbib") {
	$pageTitle = "TREW | TREWth Bib – backcountry ski/snowboard bib";
} else if ($productID == "eaglepant") {
	$pageTitle = "TREW | Eagle Pant – freeride ski/snowboard bib";
} else if ($productID == "softshell") {
	$pageTitle = "TREW | Soft Shell Anorak – Polartec® Hoodie";
} else if ($productID == "fleece") {
	$pageTitle = "TREW | Fleece Pullover – Polartec® Fleece";
} else if ($productID == "ripcitysoftshell") {
	$pageTitle = "TREW | Rip City Softshell";
} else if ($productID == "yowie") {
	$pageTitle = "TREW | Yowie®";
}

//  else if (strpos($productID, "hoodie")) {
// 	$pageTitle = "TREW |  Hoodies";
// } else if (strpos($productID, "tee")) {
// 	$pageTitle = "TREW | T-Shirts";
// } else if (strpos(strtolower($productID), "beanie") > -1) {
// 	$pageTitle = "TREW | TREW Beanies";
// } else if (strpos($productID, "cap") || strpos($productID, "latbrim") || strpos($productID, "hat")) {
// 	$pageTitle = "TREW | TREW Caps";
// } else {
// 	$pageTitle = "TREW | stylish and technical ski/snowboard outerwear";
// }

$pageThumb = "http://trewgear.com/resources/images/products/medium/".$productID.".png";



$json = "http://trewgear.hubsoft.ws/api/v1/productColors?productUID=$productUID";
if (isset($_COOKIE["promotion"])) {
	$json = $json . '&promotion=' . $_COOKIE["promotion"];
	//echo $json;
}

//$json = $json . '&promotion=GFFAZKQV';
//echo $json;

//$ch =  curl_init($json);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//$result = curl_exec($ch);

$result = get_content("cache/{$productUID}-product-detail.txt", $json, 3);

$info = json_decode($result);


$test = "https://trewgear.hubsoft.ws/api/v1/promotions";


if ($pageTitle === "") $pageTitle = "TREW | {$info[0]->colors[0]->productName}";

echo "<title>".$pageTitle."</title>\n";
echo '<meta property="og:title" content="'.$pageTitle.'"/>';
echo "\n";
require_once("meta.php");
echo '<meta property="og:image" content="'.$info[0]->colors[0]->images[0].'"/>';

$metaDesc = ($info[0]->descriptions[2]) ? $info[0]->descriptions[2] : $info[0]->descriptions[0];
$metaDesc = strip_tags($metaDesc);
$metaDesc = trim($metaDesc);
$metaDesc = str_replace("&nbsp;", "", $metaDesc);
echo "\n";
echo '<meta property="og:description" content="'.$metaDesc.'"/>';
echo "\n";
echo '<meta property="og:url" content="http://'.$domain.$url.'"/>';

?>


<link href="<?php echo $rootpath?>resources/css/pdp_2013.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $rootpath?>resources/css/productwall_2013.css" rel="stylesheet" type="text/css"/>


</head>
<body>
<div class="tooltip"></div>
<div id="outer">
	
	<div id="productZoomOverlay">
		<div class="zoomCenter">
			<p class="closeLabel">CLOSE ZOOM</p>
			<img id="zoomView"/>
		</div>
		<div class="dimmer"></div>
	</div>

	<?php 
	require_once("navigation.php");
	?>
	<div id="pdpWrap">
	<div id="pdp">
		
		<div id="productImageWrap">
			<div id="productZoomCta" data-img="<?php echo $info[0]->colors[0]->images[2];?>"></div>
			<img id="productImage" data-src="<?php echo $info[0]->colors[0]->images[0];?>"/>
			<!-- <p id="productColorLabel">Black</p> -->
		</div>
		
		<?php
		$colors = $info[0]->colors;
		$colorsTest = json_encode($colors);
		echo "<div id='description'>";
		echo "<div class='inner'>";
		echo "<h2 id='pdpTitle'>{$info[0]->colors[0]->productName}</h2>";
		
		if ($info[0]->descriptions[2]) {
			echo $info[0]->descriptions[0];
			echo $info[0]->descriptions[2];
		} else {
			echo $info[0]->descriptions[0];
		}
		
		$sizes = $colors[0]->sizes;
		$len = count($sizes);
		echo '<div class="select-skin" id="sizeSelectWrap">';
		echo '<select id="sizeSelect">';
		echo "<option value=''>SELECT A SIZE</option>";
		for ($i=0; $i < $len; $i++) {
			$sku = $sizes[$i]->sku;
			$qty = $sizes[$i]->QtyAvailable;
			$name = $sizes[$i]->sizeName;
			echo "<option value='{$sku},{$qty},{$name}'>SIZE {$name}</option>";
		}
		echo '</select>';
		echo '</div>';
		echo "<div class='clear'></div>";
		
		// color nav:
		echo '<div class="select-skin" id="colorSelectWrap">';
		echo '<select id="colorSelect">';
		echo "<option value='-1'>SELECT A COLOR</option>";
		$len = count($colors);
		for ($i=0; $i < $len; $i++) {
			$imagePath = $colors[$i]->images[0];
			if (strpos($imagePath, "disabled") === false) {
				$zoomPath = $colors[$i]->images[2];
				$hex = str_replace("#", "", $colors[$i]->colorValue);
				$colorName = $colors[$i]->colorName;
				// echo "<div class='colorThumb' data-image='{$imagePath}' data-zoom='{$zoomPath}' data-name='{$colorName}' data-index='{$i}' style='background:#{$hex};'></div>";
				echo "<option value='{$i}'>COLOR {$colorName}</option>";
			}
		}
		echo "</select>";
		echo "</div>";
		
		echo '<div id="colorNav">';
		$len = count($colors);
		for ($i=0; $i < $len; $i++) {
			$imagePath = $colors[$i]->images[0];
			if (strpos($imagePath, "disabled") === false) {
				$zoomPath = $colors[$i]->images[2];
				$hex = str_replace("#", "", $colors[$i]->colorValue);
				$colorName = $colors[$i]->colorName;
				echo "<a class='colorThumb' href='' title='{$colorName}' data-index='{$i}' style='background:#{$hex};'></a>";
			}
		}
		echo "<div class='background'></div>";
		echo "</div>";

		echo "<div class='clear'></div>";
		
		$msrp = $info[0]->colors[0]->sizes[0]->msrp;
		$unitPrice = $info[0]->colors[0]->sizes[0]->unitPrice;
		
		if ($unitPrice != $msrp) {
			echo "<p id='price' class='discounted'><span class='crossed'>\${$msrp}</span>\${$unitPrice}</p>";
			echo "<div id='buyBtn' class='discounted'>BUY</div>";
		} else {
			echo "<p id='price'>\${$info[0]->colors[0]->sizes[0]->unitPrice}</p>";
			echo "<div id='buyBtn'>BUY</div>";
		}
		
		echo "<div class='error-message' id='pdp-error'></div>";
		echo "<div class='clear'></div>";
		
		if (!$productData->isSwag) {
			echo "<a id='chartBtn' href='{$rootpath}resources/images/pdp/sizingChart.jpg' rel='shadowbox'>SIZING CHART</a>";
			echo "<div class='clear'></div>";
			echo "<p class='photoCredit white'>We are here to help get you fitted for the correct size.<br/>Please email <a href='mailto:sizing@trewgear.com' style='color:#000;'>sizing@trewgear.com</a> or call 541-241-6867</p>";
			
			echo "<div class='image-nav' id='image-nav'>
				<img class='image-item' data-index='0' src=''/>
				<img class='image-item' data-index='1' src=''/>
				<img class='image-item' data-index='3' src=''/>
				<img class='image-item' data-index='4' src=''/>
				<img class='image-item' data-index='5' src=''/>
			</div>";
			
		}
		echo "<div class='clear'></div>";
		
		
		
		// echo '<p class="photoCredit">Photo By Lance Koudele</p>';
		echo "</div>";
		echo "</div>"; /* description close */
		?>
			
	</div>
	<?php if ($info[0]->descriptions[3]) { ?>
	<div id="featuresWrap">
	<div id="features" style="padding-bottom:0;">
		
	<div id="overview" class="textblock">
		<h3>PRODUCT OVERVIEW</h3>
		<?php echo $info[0]->descriptions[3];?>
	</div> <!-- productfeaturebullets -->
	
	<div id="featureBullets" class="textblock">
		<h3>FEATURES</h3>
		<?php echo $info[0]->descriptions[4];?>
	</div> <!-- productfeaturebullets -->
	
	<div class="clear"></div>
	
	<div id="productVideo">
		<?php echo $info[0]->descriptions[7];?>
	</div>
	
	<div id="fabricPics">
		<div class="img construction"></div>
		<div class="img fabric"></div>
	</div>
	<div id="fabricInfo" class="textblock">
		<?php echo $info[0]->descriptions[5];?>
		<div style="margin-top:20px;">
			<?php echo $info[0]->descriptions[6];?>
		</div>
	</div>
	<div class="clear"></div>
	
	<div id="related">
		
		<?php
		
		$related = $colors[0]->relatedProducts;
		
		//print_r($related);
		
		
		$len = count($related);
		if ($len > 0) echo "<h3>Related Products</h3>";
		for ($i=0; $i < $len; $i++) {
		$item = $related[$i];
		$filePath = $item->images[0];
		$name = $item->productName;
		echo "<a class='wallItem' id='wallItem{$i}' data-name='$name' href='{$rootpath}pdp.php?uID={$item->productUID}'><div class='imageCenter'><img src='{$filePath}'/></div></a>";
		}
		
		
		$relatedItems = json_encode($productData->related_products);
		
		//print_r($productData->related_products[0]);
		//die();
		
		?>
	</div>
	</div><!-- features -->
	</div><!-- featuresWrap -->
	<?php } else { echo '<div style="height:100px;"></div>'; } ?>
	</div><!-- pdpWrap -->
	
	<?php
	require_once("footer.php");
	?>
	
	<script src="<?php echo $rootpath?>resources/js/product/Pdp.js"></script>
	<script src="<?php echo $rootpath?>resources/js/product/Wall.js"></script>
	
	<script>
	
	function onSizeSelectChange() {
		var values = $('#sizeSelect').val().split(",");
		console.log("values: "+values);
		if (values.length < 2) return;
		var sku = values[0];
		var qty = values[1];
		window.selectedSize = values[2];
		console.log("onSizeSelectChange sku: " + sku + " qty: " + qty);
		var buyBtn = $("#buyBtn");
		if (!buyBtn.hasClass("delayed")) {
			if (qty == 0) {
				buyBtn.addClass("disabled");
				buyBtn.html("Out Of Stock");
			} else {
				buyBtn.removeClass("disabled");
				buyBtn.html("BUY");
			}
		}
	}
	
	function onColorSelectChange() {
		console.log("onColorSelectChange");
		var index = $('#colorSelect').val();
		if (index == -1) index = 0;
		console.log("index: "+index);
		console.log("colors: "+colors);
		var color = colors[index];
		if (!color) return;
		
		
		console.log("color: "+color);
		
		$(".colorThumb").removeClass("selected");
		$(".colorThumb[data-index*="+index+"]").addClass("selected");
		
		var currentSrc = $("#productImage").attr("src");
		var src = color.images[0];
		var zoom = color.images[2];
		if (src == currentSrc) return;
		//var index = $(this).attr("data-index");
		$("#productImage").hide();
		
		
		addLoader($("#productImageWrap"));
		
		
		$("#productImage").on("load", function() {
			$(this).fadeIn();
			$("#productImageWrap").css("width", $(this).width());
			removeLoader($("#productImageWrap"));
		});
		
		$("#productImage").attr("src", src);
		$("#productZoomCta").attr("data-img", zoom);
		
		

		$("#sizeSelect").empty();
		$("#sizeSelect").append("<option value=''>SELECT A SIZE</option>");
		var sizes = colors[index].sizes;
		var len = sizes.length;
		for (var i=0; i < len; i++) {
			$("#sizeSelect").append("<option value='"+sizes[i].sku+","+sizes[i].QtyAvailable+","+sizes[i].sizeName+"'>SIZE "+sizes[i].sizeName+"</option>");
		};
		
		if (window.selectedSize) {
			$("#sizeSelect option").filter(function() {
			    var values = $(this).val().split(",");
			    return values[2] == window.selectedSize; 
			}).attr('selected', true);
		}
		sizeSelect.onSelectChange();
		
		
		//populate image nav:
		var items = $("#image-nav").find(".image-item");
		var len = items.length;
		var count = 0;
		for (var i=0; i < len; i++) {
			var item = $(items[i]);
			var imageIndex = item.attr("data-index");
			var src = root.colors[index].images[imageIndex];
			if (src) {
				item.attr("src", src);
				count++;
			} else {
				item.hide();
			}
		};
		if (count < 2) $("#image-nav").hide();
	}

	
	function onResize() {
		var width = $(window).width();
		if (width < 980) {
			width = 576;
			height = 324;
		} else {
			width = 960;
			height = 540;
		}
		var videoFrame = $("#productVideo").find("iframe");
		if (videoFrame.length > 0) {
			$(videoFrame).attr("width", width);
			$(videoFrame).attr("height", height);
		} else {
			$("#productVideo").hide();
		}
		
	}
	
	function showError(msg) {
		$("#pdp-error").html(msg);
		$("#pdp-error").fadeIn();
	}
	
	var root = this;
	$(document).ready(function() {
		var sizeSelect = new SelectSkin($("#sizeSelectWrap"));
		sizeSelect.addEventListener("onChange", root, root.onSizeSelectChange);
		sizeSelect.onSelectChange();
		root.sizeSelect = sizeSelect;
		//sizeSelect.onChange = onSizeSelectChange;
		// show first color:
		$("#productBackground").css("opacity", 0);
		$("#productBackground").on("load", function() { $(this).fadeIn()});

		var colors = jQuery.parseJSON(<?php echo json_encode($colorsTest); ?>);
		root.colors = colors;
		
		var colorSelect = new SelectSkin($("#colorSelectWrap"));
		colorSelect.addEventListener("onChange", root, root.onColorSelectChange);
		//colorSelect.onSelectChange();

		$(".colorThumb").on("click", function(e) {
			e.preventDefault();
			var index = $(this).attr("data-index");
			console.log("index: "+index);
			$('#colorSelect').val(index);
			colorSelect.onSelectChange();
		});
		
		//var color1 = $("#colorNav").find(".colorThumb")[0];
		//$(color1).trigger("click");
		colorSelect.onSelectChange();
		
		$(window).resize(function() {
		  onResize();
		});

		onResize();
		
		$("#productZoomCta").on("click", function(e) {
			
			$("#zoomView").hide();
			$("#zoomView").attr("src", "");
			
			$("#zoomView").on("load", function() {
				$(this).fadeIn();
				removeLoader($("#productZoomOverlay"));
			});
			
			$("#zoomView").attr("src", $(this).attr("data-img"));
			$("#productZoomOverlay").css("height", $("#outer").height());
			$("#productZoomOverlay").fadeIn();
			addLoader($("#productZoomOverlay"));
		});
		
		$("#productZoomOverlay").on("click", function(e) {
			$(this).fadeOut();
		});
		
		var zoom = $("#productZoomCta").attr("data-img");
		if (!zoom) $("#productZoomCta").hide();
		
		var sizeOptions = $("#sizeSelect").find("option");
		if (sizeOptions.length == 1) $("#chartBtn").hide();
		
		$(".image-item").on("click", function() {
			var src = $(this).attr("src");
			console.log("src: "+src);
			$("#productImage").attr("src", src);
		});
		
		
		var notReady = [
		// "Cosmic",
		// "Bellows",
		// "Funk",
		// "Eagle",
		// "TREWth",
		// "Stella",
		// "Chariot",
		// "Women's Vaporizer",
		// "Powfunk"
		];
		
		var title = $("#pdpTitle").html();
		var len = notReady.length;
		for (var i=0; i < len; i++) {
			if (title.indexOf(notReady[i]) != -1 && title != "Stella's Zip Hoodie") {
				var buyBtn = $("#buyBtn");
				buyBtn.addClass("disabled");
				buyBtn.addClass("delayed");
				buyBtn.html("Available September");
				buyBtn.width(215);
				break;
			}
		};
		
	});
	
	

	
	
	(function (ec) { // "ec" shortcut for "emeraldcode"

	    // ec.cart.updateUI(function () {
	    //     var cartCount = ec.cart.itemCount();
	    //     if (cartCount > 0) {
	    //         $('#cartStatus').find('.count').text(cartCount).end().show();
	    //     }
	    // });

	    //ec.cart.triggerUpdateUI();
	    ec.clientid = 'trewgear';
	    ec.ready(function () {
			console.log("ec ready");
	        // var hash = window.location.hash.substr(1);
	        // ec.getProduct({
	        //     productURL: hash
	        // }, function (data) {
	        //     document.title = data.product.productName;
	        //     $('h1').text(data.product.productName);
	        //     var html = new EJS({ element: 'productTemplate' }).render(data);
	        //     $('#product').html(html);
	        // });
	    });

	    // events
	    $('#buyBtn').on('click', function () {
		
			$("#pdp-error").hide();
			
			if ($(this).hasClass("disabled")) return;
			
	        var sku   = $('#sizeSelect').val().split(",")[0];
			var color = $('#colorSelect').val();
	        var qty   = 1;//$('.quantity-box select').val();
	
			//console.log("sku: "+sku);
			console.log("color: "+color);
			//return;

	        if (sku == "select size" || !sku) {
	            showError("Please select a size.");
	            return;
	        }
	
			if (color == -1) {
				showError("Please select a color.");
	            return;
			}
	
			console.log("sku: "+sku);
	        //ec.loadingModal(ec.page.messages.addToCartLoading);
	        ec.cart.snapshot();
	        ec.cart.addQuantity(sku, parseInt(qty));

	        ec.validateCart(function (data) {
			console.log("ec.validateCart data: "+JSON.stringify(data));
	            if (data.success == false) {
	                ec.cart.undo();
					console.log("data.errors: "+data.errors);
					var error = JSON.stringify(data.errors, null, 2);
	                alert("Error: " + error);
					Shadowbox.open({
				        content:    '<p class="sb-message">Error: '+data.errors[0].message+'</p>',
				        player:     "html",
				    });
	                return;
	            }
	            window.location = '/cart.php';
	        });
	    });
	})(emeraldcode);
	
	var promoCookie = $.cookie("promotion");
	console.log("promoCookie: "+promoCookie);
	</script>
	
</body>
</html>
