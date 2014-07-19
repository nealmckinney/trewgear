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


<script>
	var rootpath = "/";
	window.rootpath = rootpath;
</script>


<div id="trew-nav-outer">
	<div id="trew-nav-top">
		<div class="content">
			<div class="trew-nav-social">
				<a href="http://www.facebook.com/TREWGear" class="nav social facebook"></a>
				<a href="http://twitter.com/trew_gear" class="nav social twitter"></a>
				<a href="#" class="nav social youtube"></a>
				<a href="#" class="nav social pinterest"></a>
				<a href="http://instagram.com/trew_gear" class="nav social instagram"></a>
				<a href="#" class="nav social googleplus"></a>
				<!-- <a href="https://vimeo.com/trewgear" class="social vimeo"></a>
				<!-- <a href="http://www.flickr.com/photos/33132443@N04" class="social flickr"></a> -->
			</div>
			<p class="note shipping-notice">FREE GROUND SHIPPING FOR US CUSTOMERS ON ORDERS OVER $100</p>
		</div>
	</div>
<div id="trew-nav-main">
	
	<div class="btn btn-navbar">
        <div class="icon-bar"></div>
        <div class="icon-bar"></div>
        <div class="icon-bar"></div>
    </div>
	
	<a id="trew-nav-logo" href="/"></a>
	<div id="trew-nav-wrap">
		<div class="nav-collapse">
			<ul id="trew-nav">
			    <li><a class="animated" href="/productwall/mens">MEN</a></li>
				<li><a class="animated" href="/productwall/womens">WOMEN</a></li>
				<li><a class="animated" href="/productwall/accessories">ACCESSORIES</a></li>
			    <li><a class="animated" href="/about-us">ABOUT US</a></li>
				<li><a class="animated" href="/blog">BLOG</a></li>
				<li><a class="animated" href="/dealers">DEALERS</a></li>
				<li><a class="animated" href="/tour">TOUR</a></li>
				<li><a class="animated last" href="/team">TEAM</a></li>
			</ul>
		</div>
	</div>

</div>
<div class="clear"></div>
</div>
