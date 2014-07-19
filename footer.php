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
	<div class="content">
		<div id="footerLogo"></div>
		<div class="column column1">
			<p><b>TREW GEAR LLC</b><br/>
			Mailing Address:<br>
			1767 12th St. #169 Hood River, OR 97031<br>
			*call 541-241-MTNS for our office location<br>
			t. 541-241-6867</p>
			e. <a href="mailto:info@trewgear.com">info@trewgear.com</a><br>
				
			<a id="newsletter" href="#"></a>


			<div class="trew_footer_social">
				<a href="http://www.facebook.com/TREWGear" class="footer social facebook"></a>
				<a href="http://twitter.com/trew_gear" class="footer social twitter"></a>
				<a href="#" class="footer social youtube"></a>
				<a href="#" class="footer social pinterest"></a>
				<a href="http://instagram.com/trew_gear" class="footer social instagram"></a>
				<a href="#" class="footer social googleplus"></a>
			</div>
			<div class="clear"></div>
			<div class="socialIcon"><a href="http://onepercentfortheplanet.org" target="_blank"><img src="/resources/images/footer/onepercent.gif" border=0></a></div>
		</div>
		<div class="column">
			<ul class="footer-nav">
				<li><a href="/productwall/mens">Men</a></li>
				<li><a href="/productwall/womens">Women</a></li>
				<li><a href="/productwall/accessories">Accessories</a></li>
				<li><a href="/about-us">About Us</a></li>
				<li><a href="/blog">Blog</a></li>
				<li><a href="/warranty">Warranty</a></li>
				<li><a href="/dealers">Dealers</a></li>
				<li><a href="/affiliateprogram">Affiliate Program</a></li>
			</ul>
		</div>
		<div class="column">
			<ul class="footer-nav">
				<li><a href="/dealers">Dealers</a></li>
				<li><a href="/team">Team</a></li>
				<li><a href="/warranty">Warranty & Returns</a></li>
				<li><a href="/affiliateprogram">Affiliate Program</a></li>
			</ul>
		</div>
		<div class="clear"></div>
		<div id="footerBase">
			<span>©2014 Copyright, Trew Gear LLC.</span>
			<span><a href="/pro">Pro Program</a></span>
		</div>
	</div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
<script src="<?php echo $rootpath?>resources/js/jquery.easing.1.3.js"></script>
<script src="<?php echo $rootpath?>resources/js/jquery.touchSwipe.min.js"></script>
<script src="<?php echo $rootpath?>resources/js/vendor/jquery.cookie.js"></script>
<script src="<?php echo $rootpath?>resources/js/shadowbox-3.0.3/shadowbox.js"></script>

<script src="<?php echo $rootpath?>resources/js/core/events/EventDispatcher.js"></script>
<script src="<?php echo $rootpath?>resources/js/core/ui/ButtonGroup.js"></script>

<script src="//api.hubsoft.ws/@js"></script>
<script src="<?php echo $rootpath?>resources/js/plugins.js"></script>
<script src="<?php echo $rootpath?>resources/js/spin.min.js"></script>
<script src="<?php echo $rootpath?>resources/js/ui/SelectSkin.js"></script>
<script src="<?php echo $rootpath?>resources/js/main.js"></script>


<script type="text/javascript">

	Shadowbox.init({
	    handleOversize: "drag",
	    modal: true
	});

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
