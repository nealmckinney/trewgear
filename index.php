<!doctype html>
<head>
<title>TREW | stylish and technical ski/snowboard outerwear</title>
<meta name = "Title" content = "TREW | stylish and technical ski/snowboard outerwear"/>
<meta property="og:image" content="http://trewgear.com/resources/images/nav/logo_2013.png"/>
<?php require_once("meta.php"); ?>
<!-- <link href="resources/css/normalize.css" rel="stylesheet" type="text/css"/> -->
<link href="resources/css/styles_2014.css" rel="stylesheet" type="text/css"/>
<link href="/resources/css/styles-responsive.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="resources/js/vendor/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="resources/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="resources/js/jquery-more.js"></script>
<script type="text/javascript" src="resources/js/jquery.touchSwipe.min.js"></script>

<script type="text/javascript" src="resources/js/modernizr-2.5.3.min.js"></script>

<script type="text/javascript" src="resources/js/core/events/EventDispatcher.js"></script>
<script type="text/javascript" src="resources/js/core/ui/ButtonGroup.js"></script>

<!-- <script type="text/javascript" src="resources/js/json2.js"></script>
<script src="//api.hubsoft.ws/js/cartgui.js"></script>
<script src="//api.hubsoft.ws/js/api.js"></script>
<script src="//api.hubsoft.ws/js/plugins/ejs.js"></script> -->
<script src="//api.hubsoft.ws/@js"></script>

<script type="text/javascript" src="resources/js/main.js"></script>
<script type="text/javascript" src="resources/js/spin.min.js"></script>
<script type="text/javascript" src="resources/js/PhotoScroll.js?updated=9_28_2013"></script>


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
<div id="outer">

		
	<div id="shell">
		<?php 
		require_once("navigation.php");
		?>
		
		<div id="marqueeWrap">
			<div class="marquee content">
				<div class="vertical-center">
					<h2 class="title">2015 Product<br/>Preview</h2>
					<a class="button radius animated" href="#">Shop Now</a>
				</div>
			</div>
		</div>

		
	</div>
	
	<?php require_once("footer.php"); ?>
	
</div><!-- outer -->
</body>
</html>

<script type="text/javascript" src="resources/js/jquery.tweet.js"></script>

<script>


function replaceURLWithHTMLLinks(text) {
    var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
    return text.replace(exp,"<a href='$1' target='_blank'>$1</a>"); 
}

$.getJSON('/twitter-proxy.php?url='+encodeURIComponent('statuses/user_timeline.json?screen_name=trew_gear&count=1'), function(d) {
	var data = JSON.stringify(d);
	// console.log("data: "+data);
	var info = $.parseJSON(data);
	//console.log("info.text: "+info[0].text);
	$('#feed-twitter').html(replaceURLWithHTMLLinks(info[0].text));
});

</script>


