<?php
//rss feed:
require_once(MAGPIE_DIR.'rss_fetch.inc');
// $rss = fetch_rss("http://api.twitter.com/1/statuses/user_timeline.rss?screen_name=trew_gear");
$rss = fetch_rss("http://search.twitter.com/search.atom?q=trew_gear");

function ago($timestamp){
	$difference = time() - $timestamp;
	$periods = array("second", "minute", "hour", "day", "week", "month", "years", "decade");
	$lengths = array("60","60","24","7","4.35","12","10");
	for($j = 0; $difference >= $lengths[$j]; $j++)
	$difference /= $lengths[$j];
	$difference = round($difference);
	if($difference != 1) $periods[$j].= "s";
	$text = "$difference $periods[$j] ago";
	return $text;
}
?>

<div class="tweet">
	<?php
	
		$item = $rss->items[0];
	
		//$i = 0;
		//foreach ($rss->items as $item) {
			
			//print_r($item);
			//die();

			//if ($i < 5) {
				$author = $item['author_name'];
				$href = $item['link'];
				$title = $item['title'];
				$date = $item['published'];
				
				// print $date;
				// print "\n";
				// print strtotime($date);
				
				$date_format = ago(strtotime($date));
				echo "<div class='content'>";
				echo "<a href=$href>";
				echo "<span class='postText'>$title</span>";
				echo "<span class='postInfo'> {$date_format}</span>";
				echo "</a>";
				echo "</div>";
			//}
			//$i++;
		//}

	?>
</div>