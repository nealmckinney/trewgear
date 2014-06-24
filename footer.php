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

<style type="text/css">

	.socialIcon {
		float: left;
		padding: 10px 10px 0px 0px;
	}
	
</style>

<div id="footer">
	<div id="footerContent">
		<div id="footerLogo"></div>
		<div class="column wide">
			<h5>Trew Gear LLC</h5>
			<p>Mailing Address:<br>
			1767 12th St. #169 Hood River, OR 97031<br>
			*call 541-241-MTNS for our office location<br>
			t. 541-241-6867</p>
			e. <a href="mailto:info@trewgear.com">info@trewgear.com</a>
			<div class="trew_nav_social">
				<a href="http://www.facebook.com/TREWGear" class="social facebook"></a>
				<a href="http://twitter.com/trew_gear" class="social twitter"></a>
				<a href="http://www.flickr.com/photos/33132443@N04" class="social flickr"></a>
			</div>
			<div class="clear"></div>
			<div class="socialIcon"><a href="http://onepercentfortheplanet.org" target="_blank"><img src="/resources/images/footer/onepercent.gif" border=0></a></div>
		</div>
		<div class="column">
			<h5><a href="/productwall/Jackets">Jackets</a></h5>
			<h5><a href="/productwall/Pants">Pants</a></h5>
			<h5><a href="/productwall/Apparel">Accessories</a></h5>
			<h5><a href="/warranty">Warranty</a></h5>
			<h5><a href="/mission">About Us</a></h5>
			<h5><a href="/blog">Blog</a></h5>
			<h5><a href="/dealers">Dealers</a></h5>
			<h5><a href="/affiliateprogram">Affiliate Program</a></h5>
		</div>
	</div>
	<div id="footerBase">
		<div class="content">
			<span>©2013 Copyright, Trew Gear LLC.</span>
			<span><a href="/pro">Pro Program</a></span>
		</div>
	</div>
</div>


<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-8829428-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    // ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<?php if (!$isCheckout) { ?>
<script type="text/javascript" src="/resources/js/avmws_1012281.js"></script>
<?php } ?>
