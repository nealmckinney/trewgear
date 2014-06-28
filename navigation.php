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


<script language="javascript" type="text/javascript" src="/resources/js/menu_2013.js"></script>
<script language="javascript" type="text/javascript" src="/resources/js/subscribe.js"></script>
<div id="trew_nav_outer">
	<div id="trew-nav-top">
		<div class="content">
			<div class="trew_nav_social">
				<a href="http://www.facebook.com/TREWGear" class="social facebook"></a>
				<a href="http://twitter.com/trew_gear" class="social twitter"></a>
				<!-- <a href="http://www.flickr.com/photos/33132443@N04" class="social flickr"></a> -->
			</div>
			<p class="note shipping-notice">FREE GROUND SHIPPING FOR US CUSTOMERS ON ORDERS OVER $100</p>
		</div>
	</div>
<div id="trew_nav_main">
	
	<div class="btn btn-navbar">
        <div class="icon-bar animated"></div>
        <div class="icon-bar animated"></div>
        <div class="icon-bar animated"></div>
    </div>
	
	<a id="trew_nav_logo" href="/"></a>
	<div id="trew_nav_wrap">
		<div class="nav-collapse animated">
			<ul id="trew_nav">
			    <li><a class="animated" href="/productwall/mens">MEN</a></li>
				<li><a class="animated" href="/productwall/womens">WOMEN</a></li>
				<li><a class="animated" href="/team">TEAM</a></li>
			    <li><a class="animated" href="/mission">ABOUT US</a></li>
				<li><a class="animated" href="/blog">BLOG</a></li>
				<li><a class="animated" href="/dealers">DEALERS</a></li>
				<li><a class="animated" href="/tour">TOUR</a></li>
			</ul>
		</div>
	</div>

</div>
<div class="clear"></div>
</div>
