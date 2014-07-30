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
		$productUID = 111253;
		break;

		case "powfunk":
		$productUID = 111530;
		break;

		case "eaglepant":
		$productUID = 111532;
		break;

		case "trewthbib":
		$productUID = 111533;
		break;
		
		case "hunter":
		$productUID = 111585;
		break;
		
		case "tracker":
		$productUID = 111738;
		break;


		default:
		// cosmic
		$productUID = 111253;
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
$cachePath = "cache/{$productUID}-product-detail.txt";

if (isset($_COOKIE["promotion"])) {
	$promo = $_COOKIE["promotion"];
	$json = $json . '&promotion=' . $promo;
	$cachePath = "cache/{$productUID}-promo-product-wall.txt";
}

//$json = $json . '&promotion=GFFAZKQV';
//echo $json;

//$ch =  curl_init($json);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//$result = curl_exec($ch);

$result = get_content($cachePath, $json, 3);

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
		echo '<div class="rotation-nav sizeSelect" id="sizeSelect"><h5 class="title">Choose Size</h5>';
		for ($i=0; $i < $len; $i++) {
			$sku = $sizes[$i]->sku;
			$qty = $sizes[$i]->QtyAvailable;
			$name = $sizes[$i]->sizeName;
			echo "<div class='multi-nav-item size animated' data-size='{$name}' data-value='{$sku},{$qty},{$name}'>{$name}</div>";
		}
		echo '</div>';
		echo "<div class='clear'></div>";
		
		// color nav:
		echo '<div class="rotation-nav colorSelect" id="colorSelect"><h5 class="title">Choose Color</h5>';
		$len = count($colors);
		for ($i=0; $i < $len; $i++) {
			$imagePath = $colors[$i]->images[0];
			if (strpos($imagePath, "disabled") === false) {
				$zoomPath = $colors[$i]->images[2];
				$hex = str_replace("#", "", $colors[$i]->colorValue);
				$colorName = $colors[$i]->colorName;
				echo "<div class='multi-nav-item color' data-value='{$i}' data-name='{$colorName}' style='background-color:#{$hex};'><div class='indicator'></div></div>";
			}
		}
		echo "<span id='selectedColor'></span></div>";

		echo "<div class='clear'></div>";
		
		$msrp = $info[0]->colors[0]->sizes[0]->msrp;
		$unitPrice = $info[0]->colors[0]->sizes[0]->unitPrice;
		
		if ($unitPrice != $msrp) {
			echo "<h5 id='price' class='discounted'><span class='crossed'>\${$msrp}</span>\${$unitPrice}</h5>";
			echo "<div id='buyBtn' class='button radius animated discounted'>PRE-ORDER</div>";
		} else {
			echo "<h5 id='price'>\${$info[0]->colors[0]->sizes[0]->unitPrice}</h5>";
			echo "<div id='buyBtn' class='button radius animated'>PRE-ORDER</div>";
		}
		
		echo "<div class='error-message' id='pdp-error'></div>";
		echo "<div class='clear'></div>";
		
		if (!$productData->isSwag) {
			echo "<a id='chartBtn' href='{$rootpath}resources/images/pdp/sizingChart.jpg' rel='shadowbox'>Sizing Chart</a>";
			echo "<div class='clear'></div>";
			echo "<p style='font-size:14px;'>We are here to help get you fitted for the correct size.<br/>Please email <a href='mailto:sizing@trewgear.com' style='color:#0092c5;'>sizing@trewgear.com</a> or call 541-241-6867</p>";
			
			echo "<div class='image-nav' id='image-nav'>
				<div class='image-item'><img data-index='0' src=''/></div>
				<div class='image-item'><img data-index='1' src=''/></div>
				<div class='image-item'><img data-index='3' src=''/></div>
				<div class='image-item'><img data-index='4' src=''/></div>
				<div class='image-item'><img data-index='5' src=''/></div>
			</div>";
			
		}
		echo "<div class='clear'></div>";
		echo "</div>";
		echo "</div><div class='clear'></div>"; /* description close */
		?>
			
	</div>
	</div><!-- pdpWrap -->
	
	<div id="featuresWrap">
	<div class="content">
		
	<?
	
	$video = $info[0]->descriptions[7];
	$features = $info[0]->descriptions[4];
	$construction = $info[0]->descriptions[3];
	$warranty = $info[0]->descriptions[6];
	$fabricInfo = $info[0]->descriptions[5];
	
	
	?>
	
	<?php if ($video) { ?>
	<div id="productVideo">
		<?php echo $video;?>
	</div>
	<?php } ?>
	
	<?php if ($features) { ?>
	<div id="featureBullets" class="textblock">
		<h5>Features</h5>
		<?php echo $features;?>
	</div>
	<?php } ?>
	
	<?php if ($construction) { ?>
	<div id="construction" class="textblock">
		<h5>Construction</h5>
		<?php echo $construction;?>
		<?php if ($warranty) { ?>
		<div style="margin-top:20px;">
			<?php echo $warranty;?>
		</div>
		<?php } ?>
	</div>
	<?php } ?>
	
	<div class="clear"></div>
</div><!-- content -->

<?php if ($fabricInfo) { ?>
<div id="fabricInfo" class="textblock">
	<div class="content">
		<?php echo $fabricInfo;?>
	</div>
</div>
<?php } ?>
<div class="clear"></div>
	
	<?php
	$related = $colors[0]->relatedProducts;
	if ($related) {
	?>
	<div class="content">
	<div id="productWall">
		
		<h4 class="title wall-category">Related Products</h4>
		
		<?php
		
		$related = $colors[0]->relatedProducts;
		
		//print_r($related);
		
		
		$len = count($related);
		for ($i=0; $i < $len; $i++) {
		$item = $related[$i];
		$filePath = $item->images[0];
		$name = $item->productName;
		$id = $item->productUID;
		$price = $item->msrp;
		$image = $item->images[0];
		echo "<div class='wallItem'><div class='imageCenter'><a href='{$rootpath}pdp.php?uID={$id}'><div class='button-wrap'><div class='button radius animated'>Learn More</div></div><img src='$image'/></a></div><a href='{$rootpath}pdp.php?uID={$id}'><h4 class='title'>$name</h4></a><p class='price'>$$price</p></div>";
		}
		
		?>
	</div>
	</div>
	<?php } ?>
	</div><!-- features -->
	</div><!-- featuresWrap -->
	
	
	<?php
	require_once("footer.php");
	?>
	
	<script src="<?php echo $rootpath?>resources/js/product/Pdp.js"></script>
	<script src="<?php echo $rootpath?>resources/js/product/Wall.js"></script>
	
	<script>
	
	var sizeSelect;
	var colorSelect;
	
	function getDefaultIndex() {
		
	}
	
	function onSizeSelectChange() {
		var index = sizeSelect.selectedIndex;
		var btn = sizeSelect.getCurrentButton();
		var values = $(btn).data("value").split(",");
		if (values.length < 2) return;
		var sku = values[0];
		var qty = values[1];
		window.selectedSize = $(btn).data("size");
		var buyBtn = $("#buyBtn");
		if (!buyBtn.hasClass("delayed")) {
			if (qty == 0) {
				buyBtn.addClass("disabled");
				buyBtn.html("Out Of Stock");
			} else {
				buyBtn.removeClass("disabled");
				buyBtn.html("PRE-ORDER");
			}
		}
	}
	
	function onColorSelectChange() {
		var index = colorSelect.selectedIndex;
		if (index == -1) index = getDefaultIndex();//index = 0;
		var color = colors[index];
		if (!color) return;
		
		$(".colorThumb").removeClass("selected");
		$(".colorThumb[data-index*="+index+"]").addClass("selected");
		
		var currentSrc = $("#productImage").attr("src");
		var src = color.images[0];
		var zoom = color.images[2];
		if (src == currentSrc) return;
		//var index = $(this).attr("data-index");
		//$("#productImage").hide();
		
		var btn = colorSelect.getCurrentButton();
		var name = $(btn).data("name");
		$("#selectedColor").text(name);
		
		/*
		addLoader($("#productImageWrap"));
		
		$("#productImage").on("load", function() {
			$(this).fadeIn();
			$("#productImageWrap").css("width", $(this).width());
			removeLoader($("#productImageWrap"));
		});
		
		$("#productImage").attr("src", src);
		*/
		
		var image = $("#productImage");
		
		if ($(btn).attr("data-loaded")) {
			image.css("opacity", .5);
			image.attr("src", src);
			image.animate({"opacity":1}, 500, "easeOutQuad");
		} else {
			image.animate({"opacity":.5}, 250, "easeOutQuad");
			addLoader($("#productImageWrap"));
			image.on("load", function() {
				$(this).stop(true).animate({"opacity":1}, 500, "easeOutQuad");
				$(btn).attr("data-loaded", "true");
				removeLoader($("#productImageWrap"));
			});
			image.attr("src", src);
		}
		
		$("#productZoomCta").attr("data-img", zoom);
		
		

		$("#sizeSelect").empty();
		var sizes = colors[index].sizes;
		var len = sizes.length;
		$("#sizeSelect").append('<h5 class="title">Choose Size</h5>');
		for (var i=0; i < len; i++) {
			$("#sizeSelect").append("<div class='multi-nav-item size animated' data-index='"+i+"' data-size='"+sizes[i].sizeName+"' data-value='"+sizes[i].sku+","+sizes[i].QtyAvailable+","+sizes[i].sizeName+"'>"+sizes[i].sizeName+"</div>");
		};
		
		if (len < 2) {
			$("#sizeSelect").hide();
		} else {
			$("#sizeSelect").show();
		}
		
		sizeSelect.updateButtons($("#sizeSelect").find(".multi-nav-item"));
		
		if (window.selectedSize) {
			var selected = $("#sizeSelect").find(".multi-nav-item[data-size='"+window.selectedSize+"']");
			var triggerIndex = (selected.length == 1) ? selected.data("index") : 0;
		}
		sizeSelect.triggerButton(triggerIndex);
		
		
		//populate image nav:
		var items = $("#image-nav").find(".image-item img");
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
		sizeSelect = new ButtonGroup($("#sizeSelect").find(".multi-nav-item"));
		sizeSelect.addEventListener("click", root, root.onSizeSelectChange);
		sizeSelect.triggerButton(0);
		//sizeSelect.onChange = onSizeSelectChange;
		// show first color:
		$("#productBackground").css("opacity", 0);
		$("#productBackground").on("load", function() { $(this).fadeIn()});

		var colors = jQuery.parseJSON(<?php echo json_encode($colorsTest); ?>);
		root.colors = colors;
		
		colorSelect = new ButtonGroup($("#colorSelect").find(".multi-nav-item"));
		colorSelect.addEventListener("click", root, root.onColorSelectChange);
		colorSelect.triggerButton(0);
		
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
		
		$(".image-item img").on("click", function() {
			var src = $(this).attr("src");
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
			
			var btn = sizeSelect.getCurrentButton();
			var values = $(btn).data("value").split(",");
			var sku = values[0];
			//var qty = values[1];
			
	        //var sku   = $('#sizeSelect').val().split(",")[0];
			//var color = $('#colorSelect').val();
			
			var index = colorSelect.selectedIndex;
			if (index == -1) {
				var color = -1;
			} else {
				var color = colors[index];
			}
			
	        var qty   = 1;//$('.quantity-box select').val();
	
			//return;

	        if (sku == "select size" || !sku) {
	            showError("Please select a size.");
	            return;
	        }
	
			if (color == -1) {
				showError("Please select a color.");
	            return;
			}
	
	        //ec.loadingModal(ec.page.messages.addToCartLoading);
	        ec.cart.snapshot();
	        ec.cart.addQuantity(sku, parseInt(qty));

	        ec.validateCart(function (data) {
			//console.log("ec.validateCart data: "+JSON.stringify(data));
	            if (data.success == false) {
	                ec.cart.undo();
					//console.log("data.errors: "+data.errors);
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
	//console.log("promoCookie: "+promoCookie);
	</script>
	
</body>
</html>
