<?php

$base_path = $_SERVER['DOCUMENT_ROOT'];

/* gets the contents of a file if it exists, otherwise grabs and caches */
function get_content($file,$url,$hours = 24,$fn = '',$fn_args = '') {
	
	global $base_path;
	$file = $base_path."/".$file;
	//echo $file;
	
	//vars
	$current_time = time(); $expire_time = $hours * 60 * 60;
	if(file_exists($file)) {
		$file_time = filemtime($file);
	} else {
		$file_time = $current_time;
	}
	//decisions, decisions
	if(file_exists($file) && ($current_time - $expire_time < $file_time)) {
		//echo 'returning from cached file';
		return file_get_contents($file);
	} else {
		$content = get_url($url);
		if($fn) { $content = $fn($content,$fn_args); }
		//$content.= '<!-- cached:  '.time().'-->';
		file_put_contents($file,$content);
		//echo 'retrieved fresh from '.$url.':: '.$content;
		return $content;
	}
	
}

/* gets content from a URL via curl */
function get_url($url) {
	
	$ch =  curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	return $result;
	
	//$ch = curl_init();
	//curl_setopt($ch,CURLOPT_URL,$url);
	//curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
	//curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
	//$content = curl_exec($ch);
	//curl_close($ch);
	//return $content;
}

function getProductColors($theId, $products) {
	$stringy = "<div class='rotation-nav'>";
	$len = count($products);
	for ($i=0; $i < $len; $i++) {
		$item = $products[$i];
		$id = $item->productUID;
		$filePath = $item->images[0];
		$hex = str_replace("#", "", $item->colorValue);
		$tags = implode(",", $item->tags);
		//$class = ($filePath == $defaultFile) ? 'multi-nav-item selected' : 'multi-nav-item';
		if ($theId == $id) {
			$stringy .= "<div class='multi-nav-item' style='background-color:#$hex;' data-name='$item->colorName' data-image='$filePath' data-tags='$tags'><div class='indicator animated'></div></div>";
		}
	}
	return $stringy .="</div>";
}

function catMatch($classification, $cats) {
	$found = false;
	if ($cats) {
		$theCats = explode(",", $cats);
		$len = count($theCats);
		for ($i=0; $i < $len; $i++) {
			if ($classification == $theCats[$i]) {
				$found = true;
				break;
			}
		}
	} else {
		$found = true;
	}
	
	return $found;
}

function getCategories($products, $cats, $includeDescription) {
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
			
			$classifications = $item->classifications;
			$len2 = count($item->classifications);
			for ($j=0; $j < $len2; $j++) {

				$classification = $item->classifications[$j]->ClassificationUID;
				$id = $item->productUID;
				if (catMatch($classification, $cats) && !in_array($id, $ids)) {
					$ids[] = $id;
					
					if ($includeDescription) {
						
						// featured products:
						if ($i == 0) {
							echo "<div class='item featured'>";
						} else {
							echo "<div class='item featured' style='display:none;'>";
						}
						
						echo "<div class='left'><div class='vertical-center'><img src=''/></div></div>";
						echo "<div class='right center'><div class='vertical-center'>";
						echo "<h4 class='title'>$name</h4>";
						echo $item->descriptions[0];
						echo $item->descriptions[2];
						echo "<a href='{$rootpath}pdp.php?uID={$id}' class='button radius animated'>Buy Now</a>";
						echo getProductColors($id, $products);
						echo "</div></div></div>";
						
					} else {
						
						// product walls:
						echo "<div class='wallItem' data-prod-num='$productNumber' data-name='$name'><div class='imageCenter'><a href='{$rootpath}pdp.php?uID={$id}'><div class='button-wrap'><div class='button radius animated'>Learn More</div></div><img src=''/></a></div><a href='{$rootpath}pdp.php?uID={$id}'><h4 class='title'>$name</h4></a><p class='price'>$price</p>";
						echo getProductColors($id, $products);
						echo "</div>";
						
					}
				}
			}
		}
	}
}

?>