<!doctype html>
<head>
<title>TREW | stylish and technical ski/snowboard outerwear</title>
<meta name = "Title" content = "TREW | stylish and technical ski/snowboard outerwear"/>
<meta property="og:image" content="http://trewgear.com/resources/images/nav/logo_2013.png"/>
<?php require_once("meta.php"); ?>
<?php require_once("functions.php"); ?>

<?php

$json = "http://trewgear.hubsoft.ws/api/v1/products?tags=featured&extras=1";
$result = get_content("cache/home-featured.txt", $json, 3);
$info = json_decode($result);
$products = $info->products;

?>

<script type="text/javascript">
adroll_adv_id = "FOFPXQOGZZGRPNRWIXRQQA";
adroll_pix_id = "WKNTCG44KVGHNJNZQNCNQT";
(function () {
var oldonload = window.onload;
window.onload = function(){
  __adroll_loaded=true;
  var scr = document.createElement("script");
  var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
  scr.setAttribute('async', 'true');
  scr.type = "text/javascript";
  scr.src = host + "/j/roundtrip.js";
  document.documentElement.firstChild.appendChild(scr);
  if(oldonload){oldonload()}};
}());
</script>

</head>
<body>
		
	<?php require_once("navigation.php"); ?>
	
	<div id="marqueeWrap">
		<div class="marquee content">
			<div class="vertical-center">
				<h2 class="title">2015 Product<br/>Preview</h2>
				<a class="button radius animated" href="/productwall/mens">Shop Now</a>
			</div>
		</div>
		<div class="marquee-background" style="background-image:url(/resources/images/home/marquee-2015-products.jpg);"></div>
	</div>
	<div class="we-are-trew">
		<div class="content center">
			<h4 class="title">WE ARE TREW</h4>
			<hr/>
			<p class="intro">Trew is based in Hood River, Oregon among the Cascade Mountains. We strive to produce outerwear that remains relevant and connected to the core of mountain riding.</p>
			<a class="cta" href="http://player.vimeo.com/video/52359303" rel="shadowbox">Watch Our Brand Video <span class="arrow"></span></a>
		</div>
	</div>
	
	<div class="circle-touts">
		<div class="content">
			<a href="/productwall/mens" class="circle-tout">
				<img class="circle" src="/resources/images/home/tout-mens.jpg"/>
				<span class="cta">Shop Mens <span class="arrow"></span></span>
			</a>
			<a href="/productwall/womens" class="circle-tout">
				<img class="circle" src="/resources/images/home/tout-womens.jpg"/>
				<span class="cta">Shop Womens <span class="arrow"></span></span>
			</a>
			<a href="/productwall/accessories" class="circle-tout last">
				<img class="circle" src="/resources/images/home/tout-accessories.jpg"/>
				<span class="cta">Shop Accessories <span class="arrow"></span></span>
			</a>
		</div>
	</div>
	
	<div class="product-scroller" data-index="0">
		<div class="arrow-large arrow-left animated"></div>
		<div class="arrow-large arrow-right animated"></div>
		<div class="content overflow-hidden">
			
			<?php 
			getCategories($products, "", true);
			?>
			
		</div>
	</div>
	
	<div class="trew-social">
		<div class="content">
			<div class="social-left">
				<h3 class="title">Trew Social</h3>
				<div id="facebook-feed">
					<?php
					require_once 'magpie/rss_fetch.inc';

					// App ID: 546632712068618
					// App Secret: 3802aa9f51a0e798360dfa9728f372e9

					// http://graph.facebook.com/endpoint?key=value&access_token=app_id|app_secret
					// https://graph.facebook.com/PAGE_ID/posts?limit=1&access_token=ACCESS_TOKEN_HERE
					// http://www.facebook.com/feeds/page.php?id=178635730946&format=atom10&count=1

					$url = 'http://www.facebook.com/feeds/page.php?id=178635730946&format=atom10&count=1';
					$rss = fetch_rss($url);

					foreach ($rss->items as $item ) {
						//print_r($item);
						$title = $item[title];
						$url   = $item[link];
						//$published = $item[published];
						$ts = strtotime($item[published]);
						$published = date("m/d/Y", $ts);
						$author = $item[author_name];
						echo "<a href='https://www.facebook.com/TREWGear'>$author</a>: <a href=$url>$title</a><br/>";
						echo "<div class='date'>$published</div>";
						break;

					}
					?>
				</div>
				<div id="twitter-feed"></div>
			</div>
			<a class="instagram-bg" href="http://instagram.com/trew_gear" target="_blank">
				<div class="instagram-icon"></div>
			</a>
		</div>
	</div>
	
	<?php require_once("footer.php"); ?>
	
</body>
</html>

<script src="/resources/js/tweetie.min.js"></script>
<script src="/resources/js/vendor/instagram.min.js"></script>

<script>
	
	var root = this;
	
	function onResize() {
		$(".featured .left .vertical-center").each(function() {
			$(this).width($(this).parent().width());
		});
	}
	
	$(document).ready(function() {
		
		//https://api.instagram.com/v1/users/search?q=[ USER NAME ]&client_id=[ YOU APP Client ID ]
		//https://api.instagram.com/v1/users/search?q=[USERNAME]&access_token=[ACCESS TOKEN]
		// https://api.instagram.com/v1/users/search?q=trewgear&access_token=461850189.9f8dc06.aafb3f17a3c64166b8de7a5daf618c17
		
		//9f8dc063a7194a5ebfdb7ffe526b0427
		
		//https://instagram.com/oauth/authorize/?client_id=9f8dc063a7194a5ebfdb7ffe526b0427&redirect_uri=http://localhost&response_type=token
		// #access_token=461850189.9f8dc06.aafb3f17a3c64166b8de7a5daf618c17
		
		$('#twitter-feed').twittie({
			username:"trew_gear",
			dateFormat: '%m/%d/%Y',
			template: '{{screen_name}}: {{tweet}} <div class="date">{{date}}</div>',
			count:1
		});
		
		
		$(".instagram-bg").instagram({
			userId: '184855074',
			accessToken: '461850189.9f8dc06.aafb3f17a3c64166b8de7a5daf618c17',
			count:1
	    });
	
		$('.instagram-bg').on('didLoadInstagram', function(event, response) {
			var test = JSON.stringify(response.data);
			var url = response.data[0].images.low_resolution.url;
			//console.log("url: "+url);
			$(this).css("background-image", "url("+url+")");
		});
		
		$(".featured .multi-nav-item").on("click", function() {
			var img = $(this).data("image");
			$(this).parent().parent().parent().parent().find(".left img").attr("src", img);
			$(this).parent().find(".multi-nav-item").removeClass("selected");
			$(this).addClass("selected");
		});
		
		$(".featured").each(function() {
			var colors = $(this).find(".multi-nav-item");
			var defaultColor = $(this).find(".multi-nav-item[data-tags*='default-color']");
			var start = (defaultColor.length == 1) ? defaultColor : colors[0];
			start.click();
		});
		
		$(".product-scroller .arrow-large").on("click", function() {
			var index = $(this).parent().attr("data-index");
			var featured = $(this).parent().find(".featured");
			var count = featured.length;
			if ($(this).hasClass("arrow-left")) {
				// left
				if (index > 0) {
					index--;
				} else {
					index = count-1;
				}
			} else {
				// right
				if (index < count-1) {
					index++;
				} else {
					index = 0;
				}
			}
			featured.hide();
			$(featured[index]).fadeIn();
			$(this).parent().attr("data-index", index);
			root.onResize();
		});
		
		
		$(window).resize(function() {
			root.onResize();
		});
		root.onResize();
	});
	
</script>



