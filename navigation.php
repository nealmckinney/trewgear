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

<style>
	.shipping-notice {
		color:#ff0000;
		text-align:center;
		width:100%;
		position:absolute;
		top:15px;
		left:0;
	}
</style>

<script language="javascript" type="text/javascript" src="/resources/js/menu_2013.js"></script>
<script language="javascript" type="text/javascript" src="/resources/js/subscribe.js"></script>
<div id="trew_nav_outer">
<div id="trew_nav_main">
	
	<p class="note shipping-notice">FREE GROUND SHIPPING FOR US CUSTOMERS ON ORDERS OVER $100<br/>FREE RETURN SHIPPING -  HASSLE FREE EXCHANGES & RETURNS</p>
	
	<div class="btn btn-navbar">
        <div class="icon-bar animated"></div>
        <div class="icon-bar animated"></div>
        <div class="icon-bar animated"></div>
    </div>
	
	<a id="trew_nav_logo" href="/"></a>
	<div id="trew_nav_wrap">
	<div class="nav-collapse animated">
	<ul id="trew_nav">
	    <li class="topButton"><a class="topA" href="/productwall/mens">MEN</a>
			<ul class="tier1">
				<li class="subButton top"><a class="level-1" href="/productwall/mens-jackets">JACKETS</a>
					<ul class="tier1 secondary">
						<li class="subButton top"><a href="/productwall/Jackets">HARD SHELLS</a>
							<ul class="tier2">
								<li class="subButton"><a href="/pdp/cosmic">THE COSMIC</a><ul class="product_cta" id="cosmic" data-image="https://s3.amazonaws.com/F13_TREWGEAR_THUMBNAIL/F13_COSMIC_EG_FRONT.png"></ul></li>
								<li class="subButton"><a href="/pdp/powfunk">THE POW-FUNK</a><ul class="product_cta" id="powfunk" data-image="https://s3.amazonaws.com/F13_TREWGEAR_THUMBNAIL/F13_POWFUNK_CP_FRONT.png"></ul></li>
								<li class="subButton"><a href="/pdp/bellows">THE BELLOWS</a><ul class="product_cta" id="bellows" data-image="https://s3.amazonaws.com/F13_TREWGEAR_THUMBNAIL/F13_BELLOWS_CAMO_FRONT.png"></ul></li>
							</ul>
						</li>
						<li class="subButton top"><a href="/productwall/mens-jackets">SOFT SHELLS</a>
							<ul class="tier2">
								<li class="subButton"><a href="/pdp/wyeast">WYEAST</a><ul class="product_cta" id="wyeast" data-image="https://s3.amazonaws.com/F13_TREWGEAR_THUMBNAIL/F13_WYEAST_GLD_FRONT.png"></ul></li>
								<li class="subButton"><a href="/pdp/swift">SWIFT</a><ul class="product_cta" id="swift" data-image="https://s3.amazonaws.com/F13_TREWGEAR_THUMBNAIL/F13_SWIFT_RYL_FRONT.png"></ul></li>
								<li class="subButton"><a href="/pdp/ripcitysoftshell">RIP City Softshell</a><ul class="product_cta" id="swift" data-image="https://s3.amazonaws.com/F13_TREWGEAR_THUMBNAIL/F13_RIPCITY_BLKOLV_FRONT.png"></ul></li>
							</ul>
						</li>
						<li class="subButton top"><a href="/productwall/mens-jackets">LAYERING/INSULATION</a>
							<ul class="tier2">
								<li class="subButton"><a href="/pdp/polarshift">Polar Shift</a><ul class="product_cta" id="polarshift" data-image="https://s3.amazonaws.com/F13_TREWGEAR_THUMBNAIL/F13_POLARSHIFT_BG_FRONT.png"></ul></li>
								<li class="subButton"><a href="/pdp/vaporizer">Vaporizer</a><ul class="product_cta" id="vaporizer" data-image="https://s3.amazonaws.com/F13_TREWGEAR_THUMBNAIL/F13_VAPORIZER_GE_FRONT.png"></ul></li>
							</ul>
						</li>
					</ul>
				</li>
				<li class="subButton"><a class="level-1" href="/productwall/mens-pants">Pants</a>
					<ul class="tier2">
						<li class="subButton"><a href="/pdp/trewthbib">THE TREWTH BIB</a><ul class="product_cta" id="trewthbib" data-image="https://s3.amazonaws.com/F13_TREWGEAR_THUMBNAIL/F13_TREWTH_BRWN_FRONT.png"></ul></li>
						<li class="subButton"><a href="/pdp/eaglepant">THE EAGLE PANT</a><ul class="product_cta" id="eaglepant" data-image="https://s3.amazonaws.com/F13_TREWGEAR_THUMBNAIL/F13_EAGLE_CAMO_FRONT.png"></ul></li>
					</ul>
				</li>
				<li class="subButton"><a class="level-1" href="/productwall/mens-apparel">Apparel & Accessories</a>
					<!-- <ul class="tier2">
						<li class="subButton"><a href="/pdp/fpo">Tees</a><ul class="product_cta" id="fpo"></ul></li>
						<li class="subButton"><a href="/pdp/fpo">Sweatshirts</a><ul class="product_cta" id="fpo"></ul></li>
						<li class="subButton"><a href="/pdp/fpo">Beanies</a><ul class="product_cta" id="fpo"></ul></li>
						<li class="subButton"><a href="/pdp/fpo">Caps</a><ul class="product_cta" id="fpo"></ul></li>
					</ul> -->
				</li>
				<li class="subButton"><a class="level-1" href="/warranty">WARRANTY</a></li>
			</ul>
		</li>
		<li class="topButton"><a class="topA" href="/productwall/womens">WOMEN</a>
			<ul class="tier1">
				<li class="subButton top"><a class="level-1" href="/productwall/womens-jackets">JACKETS</a>
					<ul class="tier1 secondary">
						<li class="subButton top"><a href="/productwall/womens-jackets">HARD SHELLS</a>
							<ul class="tier2">
								<li class="subButton"><a href="/pdp/stella">Stella Jacket</a><ul class="product_cta" id="stella" data-image="https://s3.amazonaws.com/F13_TREWGEAR_THUMBNAIL/F13_STELLA_TRC_FRONT.png"></ul></li>
							</ul>
						</li>
						<li class="subButton top"><a href="/productwall/womens-jackets">Layering</a>
							<ul class="tier2">
								<li class="subButton"><a href="/pdp/womens-vaporizer">Vaporizer</a><ul class="product_cta" id="womens-vaporizer" data-image="https://s3.amazonaws.com/F13_TREWGEAR_THUMBNAIL/F13_VAPORIZER_W_GE_FRONT.png"></ul></li>
							</ul>
						</li>
					</ul>
				</li>
				<li class="subButton"><a class="level-1" href="/productwall/womens-pants">Hard Shell Bibs</a>
					<ul class="tier2">
						<li class="subButton"><a href="/pdp/chariot">Chariot Bib</a><ul class="product_cta" id="chariot" data-image="https://s3.amazonaws.com/F13_TREWGEAR_THUMBNAIL/F13_CHARIOT_CNY_FRONT.png"></ul></li>
					</ul>
				</li>
				<li class="subButton"><a class="level-1" href="/productwall/womens-apparel">Apparel</a>
					<!-- <ul class="tier2">
						<li class="subButton"><a href="/pdp/fpo">Tees</a><ul class="product_cta" id="fpo"></ul></li>
						<li class="subButton"><a href="/pdp/fpo">Sweatshirts</a><ul class="product_cta" id="fpo"></ul></li>
						<li class="subButton"><a href="/pdp/fpo">OTS long sleeve</a><ul class="product_cta" id="fpo"></ul></li>
						<li class="subButton"><a href="/pdp/fpo">Beanies</a><ul class="product_cta" id="fpo"></ul></li>
						<li class="subButton"><a href="/pdp/fpo">Caps</a><ul class="product_cta" id="fpo"></ul></li>
					</ul> -->
				</li>
				<li class="subButton"><a class="level-1" href="/warranty">WARRANTY</a></li>
			</ul>
		</li>
		<li class="topButton"><a class="topA" href="/team">TEAM</a></li>
	    <li class="topButton"><a class="topA" href="/mission">ABOUT US</a>
			<ul class="tier1">
				<li class="subButton"><a href="/mission">MISSION</a></li>
				<li class="subButton"><a href="/trewth">TREWTH</a></li>
			</ul>
		</li>
		<li class="topButton"><a class="topA" href="/blog">BLOG</a></li>
		<li class="topButton"><a class="topA" href="/dealers">DEALERS</a></li>
		<li class="topButton last"><a class="topA" href="/tour">TOUR</a></li>
		<!-- <li id="cartStatusLi"><a id="cartStatus" href="./cart.php" style="display:none"><i class="icon-shopping-cart icon-white"></i> Cart <span class="count badge badge-inverse">0</span></a></li> -->
	</ul>
	</div>
	<ul class="nav pullright right-nav">
        <li class="loggedin"><a>Welcome, <span class="username"></span></a></li>
        <li class="loggedin"><a href="/account">My Account</a></li>
        <li class="loggedin signoutlink"><a href="#">Sign Out</a></li>
        <li class="loggedout"><a href="/account">Sign In</a></li>
        <li id="cartStatusLi"><a id="cartStatus" href="/cart"><i class="icon-shopping-cart icon-white"></i> Cart <span class="count badge badge-inverse">0</span></a></li>
    </ul>
	
	</div>
	<div class="trew_nav_social">
		<a href="http://www.facebook.com/TREWGear" class="social facebook"></a>
		<a href="http://twitter.com/trew_gear" class="social twitter"></a>
		<!-- <a href="http://www.flickr.com/photos/33132443@N04" class="social flickr"></a> -->
	</div>
	
	<!-- Begin MailChimp Signup Form -->
	<div id="mc_embed_signup">
	<form action="http://trewgear.us4.list-manage.com/subscribe/post?u=2d18e9aed6fe74bdfb3e09bc7&amp;id=993cb1dae7" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
		<label for="mce-EMAIL">Newsletter</label>
		<input type="submit" value="" name="subscribe" id="mc-embedded-subscribe" class="button">
		<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Your Email Address" required>
	</form>
	</div>

	<!--End mc_embed_signup-->
</div>
<div class="clear"></div>
</div>
