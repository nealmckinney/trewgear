<!doctype html>
<head>
<title>TREW | stylish and technical ski/snowboard outerwear</title>
<meta name = "Title" content = "TREW | stylish and technical ski/snowboard outerwear"/>
<meta property="og:image" content="http://trewgear.com/resources/images/nav/logo_2013.png"/>
<?php require_once("meta.php"); ?>
<!-- <link href="resources/css/normalize.css" rel="stylesheet" type="text/css"/> -->
<link href="resources/css/styles_2013.css" rel="stylesheet" type="text/css"/>
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

<?php
$json = "http://trewgear.hubsoft.ws/api/v1/productColors?productUID=105042";
$ch =  curl_init($json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$info = json_decode($result);
$colors = $info[0]->colors;
$images = $colors[0]->images;
?>


</head>
<body>
<div id="outer">

		
	<div id="shell">
		<?php 
		require_once("navigation.php");
		?>
		

		
		
		<div class="photo-scroll" id="photo-scroll1" data-center="true">
			<div class="arrow next animated"></div>
			<div class="arrow prev animated"></div>
			<div class="scroll-wrap">
				<div class="scroll animated">
					<?php
					$images = $colors[0]->images;
					$len = count($images);
					for ($i=0; $i < $len; $i++) {
						if ($images[$i]) {
					?>
					
					<div class="slide" data-photo="<?php echo $images[$i]?>">
						<div class="frame">
							<div class="slide-content">
								<div class="hover animated"></div>
							</div>
						</div>
					</div>

					<?php
						}
					}
					?>
				</div>
			</div>
		</div>

		<div id="toutWrap">
			<div id="touts">
				<div class="tout">
					<!-- <div class="over"></div>
											<div class="tout-text">
												<h3 class="widgettitle">Thoughts and Ponderings</h3>
												<p>read more in the blog</p>
											</div> -->
											<iframe src="http://player.vimeo.com/video/52359303" width="100%" height="100%" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
				</div>
				<a class="tout accessorize" href="/productwall/Apparel" style="">
					<div class="over"></div>
					<div class="tout-text">
						<h3 class="widgettitle">Accessorize yourself</h3>
						<p>shop now</p>
					</div>
				</a>
				<a class="tout team last" href="/team" style="">
					<div class="over"></div>
					<div class="tout-text">
						<h3 class="widgettitle">the TREW family</h3>
						<p>meet the team</p>
					</div>
				</a>
			</div>
		</div>
		<div class="content">
			<h3 class="homeDescription">TREW IS BASED IN HOOD RIVER, OREGON AMONG THE CASCADE MOUNTAINS. WE STRIVE TO PRODUCE OUTERWEAR THAT REMAINS RELEVANT AND CONNECTED TO THE CORE OF MOUNTAIN RIDING.</h3>
		</div>
		
		<div class="photo-scroll" id="photo-scroll2" data-center="true">
			<div class="arrow next animated"></div>
			<div class="arrow prev animated"></div>
			<div class="scroll-wrap">
				<div class="scroll animated">
					<?php
					$images = $colors[1]->images;
					$len = count($images);
					for ($i=0; $i < $len; $i++) {
						if ($images[$i]) {
					?>
					
					<div class="slide" data-photo="<?php echo $images[$i]?>">
						<div class="frame">
							<div class="slide-content">
								<div class="hover animated"></div>
							</div>
						</div>
					</div>

					<?php
						}
					}
					?>
				</div>
			</div>
		</div>
		
		<div class="photo-scroll" id="photo-scroll3" data-center="true">
			<div class="arrow next animated"></div>
			<div class="arrow prev animated"></div>
			<div class="scroll-wrap">
				<div class="scroll animated">
					<?php
					$images = $colors[2]->images;
					$len = count($images);
					for ($i=0; $i < $len; $i++) {
						if ($images[$i]) {
					?>
					
					<div class="slide" data-photo="<?php echo $images[$i]?>">
						<div class="frame">
							<div class="slide-content">
								<div class="hover animated"></div>
							</div>
						</div>
					</div>

					<?php
						}
					}
					?>
				</div>
			</div>
		</div>
		
		<div class="content">
			<div class="tweet">
				<div class="content" id="feed-twitter"></div>
			</div>
		</div>
		
	</div>
	
	<?php require_once("footer.php"); ?>
	
</div><!-- outer -->
</body>
</html>

<script type="text/javascript" src="resources/js/jquery.tweet.js"></script>

<script>
new PhotoScroll($("#photo-scroll1"));
new PhotoScroll($("#photo-scroll2"));
new PhotoScroll($("#photo-scroll3"));

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


