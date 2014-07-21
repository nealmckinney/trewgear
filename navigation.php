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
				<a href="http://www.facebook.com/TREWGear" target="_blank" class="nav social facebook"></a>
				<a href="http://twitter.com/trew_gear" target="_blank" class="nav social twitter"></a>
				<a href="http://instagram.com/trew_gear" target="_blank" class="nav social instagram"></a>
			</div>
			<p class="note shipping-notice">FREE GROUND SHIPPING FOR U.S.A. CUSTOMERS ON ORDERS OVER $100</p>
		</div>
	</div>
<div id="trew-nav-main">
	
	<div class="btn btn-navbar">
        <div class="icon-bar"></div>
        <div class="icon-bar"></div>
        <div class="icon-bar"></div>
    </div>
	
	<a id="trew-nav-logo" href="<?php echo $rootpath?>"></a>
	<div id="trew-nav-wrap">
		<div class="nav-collapse">
			<div class="nav-inner">
				<ul id="trew-nav">
				    <li><a class="animated" href="<?php echo $rootpath?>productwall/mens">MEN</a></li>
					<li><a class="animated" href="<?php echo $rootpath?>productwall/womens">WOMEN</a></li>
					<li><a class="animated" href="<?php echo $rootpath?>productwall/accessories">ACCESSORIES</a></li>
				    <li><a class="animated" href="<?php echo $rootpath?>about-us">ABOUT US</a></li>
					<li><a class="animated" href="<?php echo $rootpath?>blog">BLOG</a></li>
					<li><a class="animated" href="<?php echo $rootpath?>dealers">DEALERS</a></li>
					<li><a class="animated" href="<?php echo $rootpath?>tour">TOUR</a></li>
					<li><a class="animated last" href="<?php echo $rootpath?>team">TEAM</a></li>
				</ul>
			
				<ul class="nav pullright right-nav">
			        <li class="loggedin"><a>Welcome, <span class="username"></span></a></li>
			        <li class="loggedin"><a href="<?php echo $rootpath?>account">My Account</a></li>
			        <li class="loggedin signoutlink"><a href="#">Sign Out</a></li>
			        <li class="loggedout"><a href="<?php echo $rootpath?>account">Sign In</a></li>
			        <li id="cartStatusLi"><a id="cartStatus" href="<?php echo $rootpath?>cart"><i class="icon-shopping-cart icon-white"></i> Cart <span class="count badge badge-inverse">0</span></a></li>
			    </ul>
			</div>
		
		</div>
	</div>

</div>
<div class="clear"></div>
</div>
