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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>TREW | TREW Team</title>
<?php require_once("meta.php"); ?>
<link href="/resources/css/styles_2013.css" rel="stylesheet" type="text/css"/>
<link href="/resources/css/styles-responsive.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="/resources/js/vendor/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/resources/js/jquery-more.js"></script>
<script type="text/javascript" src="/resources/js/modernizr-2.5.3.min.js"></script>

<!-- <script type="text/javascript" src="resources/js/json2.js"></script>
<script src="//api.hubsoft.ws/js/cartgui.js"></script>
<script src="//api.hubsoft.ws/js/api.js"></script>
<script src="//api.hubsoft.ws/js/plugins/ejs.js"></script> -->
<script src="//api.hubsoft.ws/@js"></script>

<script type="text/javascript" src="/resources/js/main.js"></script>

<style type="text/css">

	#column1 {
		width: 350px;
		float: left;
		padding:40px 0px 0px 0px;
	}
	
	#column1 p {
		margin-right:20px;
		margin-top:10px;
	}
	
	#column2 {
		padding:40px 0px 0px 0px;
		float: right;
		width: 570px;
	}
	
	#memberImage {
		text-align: left;
		margin: 0px 0px 0px 0px;
	}
	
	#memberImage img {
	   border:10px solid #f6f6f6;
	}
	
	#teamNav {
		margin-bottom:20px;
/*		height: 384px;*/
		padding: 0px 0px 0px 0px;
/*		font: 12px/1.5em Verdana,sans-serif;*/
		font-weight: bold;
		color: #000;
	}
	
	#teamNav a {
		color: #ff0000;
		text-decoration:none;
	}
	
	#teamBio {
		color:#000;
		padding: 0px 0px 20px 0px;
		/*height: 400px;*/
	}
	
	a {
		color: #ff0000;
		text-decoration:none;
	}

</style>



<?php

function getTeamID($url) {
	$url = str_replace("/trew-team-", "", $url);
	$url = str_replace("-detail", "", $url);
	return $url;
}


//102951
$teamID = "";
$tID = $_GET["tID"];
if ($tID != "") {
	$teamID = $tID;
};

// nav:
$json = "http://trewgear.hubsoft.ws/api/v1/productColors?productUID=102951";
$ch =  curl_init($json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$nav = json_decode($result);

if ($teamID == "") {
	$teamID = getTeamID($nav[0]->colors[0]->productURL);
}

// detail:
$json = "http://trewgear.hubsoft.ws/api/v1/products?productURL=/trew-team-{$teamID}-detail";
$ch =  curl_init($json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$info = json_decode($result);
$detail = $info->product;
?>


</head>
<body>
	
<div id="outer">
	
	<?php 
	require_once("navigation.php");
	?>
	
	<div id="contentWrap">
	<div class="content" style="padding:100px 0 50px 0;">
		
		<div id="column2">
			<div style="margin-bottom:59px;">
			<?php 
			//echo $teamID;
			//echo '<div id="memberImage"><img src="'.$rootpath.'resources/images/team/'.$teamID.'.jpg"/></div>';
			?>
			</div>
			<div id="teamBio">
			<div id="memberImage">
				<img src="<?php echo $detail->images[0];?>"/>
			</div>
			<br/>
			<div><?php echo $detail->descriptions[0];?></div>
			</div>
		</div>
		
		<div id="column1">
		
		<div id="teamNav">
			<h1 class="header1">THE TREW CREW</h1>
			<?php
			
			$colors = $nav[0]->colors;
			$len = count($colors);
			for ($i=0; $i < $len; $i++) {
				$name = $colors[$i]->productNumber;
				$url  = $colors[$i]->productURL;
				
				$url = getTeamID($url);
				
				if ($url != $teamID) {
					echo '<div class="teamLink"><a href="'.$rootpath.'team/'.$url.'">'.$name.'</a></div>';
				} else {
					echo '<div class="teamLink">'.$name.'</div>';
				}
			}
				
			// if ($id != $teamID) {
			// 	echo '<div class="teamLink"><a href="team.php?tID='.$id.'">'.$label.'</a></div>';
			// } else {
			// 	echo '<div class="teamLink">'.$label.'</div>';
			// }
			
			?>
		</div>
		
		<div><img src="/resources/images/team/crew.jpg"/></div>
		<div style="padding-top:10px;">
		<p>The TREW Crew consists of diversely talented individuals whose lives revolve around sliding down snowy mountains. Some choose one plank and some choose two. Some free their heels and talk about freeing their minds. Others talk about tall PBRs and late night urban rails illuminated by truck headlights and camera flashes. Some are at the trailhead at 4 a.m. to start long climbs up tall peaks in search of sunrise pow turns.  Some are on the first chair for a pow day, and some are on the last chair after shredding the pipe all day. Each member is original, each member pursues his or her dreams in the mountains, and they all wear TREW.</p>
		<p class="photoCredit" style="color:#999;">Photo By Lance Koudele</p>
		</div>
		</div><!-- #column1 -->
		
		
		<div class="clear">&nbsp;</div>
	</div><!-- #container -->
	</div><!-- #htmlLayer -->
	
	<?php 
	require_once("footer.php");
	?>
	
</div><!-- outer -->
</body>