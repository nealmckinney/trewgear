<?php

function st_get_nid_theme(){

global $wpdb, $nid, $table_prefix;

	$nid = $wpdb->escape($_GET['newsletter']);

	if($nid == ''){$nid = $wpdb->escape($_GET['preview']);}
	
	if(is_numeric($nid))
	$theme = $wpdb->get_var("SELECT st_template FROM ".$table_prefix."st_newsletter WHERE st_id=".$nid);

	return $theme;

}

function st_the_title(){

global $wpdb, $nid, $table_prefix;

	

	$nid = $wpdb->escape($_GET['newsletter']);

	if($nid == ''){$nid = $wpdb->escape($_GET['preview']);}

	if(is_numeric($nid))
			$title = $wpdb->get_var("SELECT st_title FROM $table_prefix"."st_newsletter WHERE st_id=$nid");

			echo $title;

}
function st_the_headimg(){

global $wpdb, $nid, $table_prefix;

	$nid = $wpdb->escape($_GET['newsletter']);
	if($nid == ''){$nid = $wpdb->escape($_GET['preview']);}
		if(is_numeric($nid))
			$head = $wpdb->get_var("SELECT st_header FROM $table_prefix"."st_newsletter WHERE st_id=$nid");
			
			echo $head;
}

function st_the_date(){

global $wpdb, $nid, $table_prefix;

$nid = $wpdb->escape($_GET['newsletter']);

	if($nid == ''){$nid = $wpdb->escape($_GET['preview']);}
			if(is_numeric($nid))
			$date = $wpdb->get_var("SELECT st_date FROM ".$table_prefix."st_newsletter WHERE st_id=".$nid);

			$newdate = chunk_split($date, 2, '-');

				list($y, $year, $month, $day) = split('[/.-]', $newdate);

			$montharr = array( '', __('January', 'stnl'), __('February', 'stnl'), __('March', 'stnl'), __('April', 'stnl'), __('May', 'stnl'), __('June', 'stnl'), __('July', 'stnl'), __('August', 'stnl'), __('September', 'stnl'), __('October', 'stnl'), __('November', 'stnl'), __('December', 'stnl'));

			$month = ltrim($month, "0");

			$day = ltrim($day, "0");

			$year = $y.$year;

			$news_date = $montharr[$month].' '.$day.', '.$year; 

			echo $news_date;

}

function st_post_count(){

	global $wpdb, $nid, $table_prefix;
	
	$nid = $wpdb->escape($_GET['newsletter']);

	if($nid == ''){$nid = $wpdb->escape($_GET['preview']);}
		if(is_numeric($nid))
		$posts = $wpdb->get_var("SELECT st_posts FROM ".$table_prefix."st_newsletter WHERE st_id=".$nid);

		if ($posts != ''){

			$theposts = explode(',',$posts);

			$post_amount = count($theposts);

			return $post_amount;

		}else{

			return FALSE;

		}

}



function st_the_post($no, $cell){

	global $wpdb, $nid, $table_prefix;

	$nid = $wpdb->escape($_GET['newsletter']);

	if($nid == ''){$nid = $wpdb->escape($_GET['preview']);}
			if(is_numeric($nid))
			$posts = $wpdb->get_var("SELECT st_posts FROM ".$table_prefix."st_newsletter WHERE st_id=".$nid);

			$theposts = explode(',',$posts);

			$idno = $theposts[$no];

			$thepost = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID=$idno");

			if($cell == 'post_author'){

				$theid = $thepost->post_author;

				$author = $wpdb->get_var("SELECT user_nicename FROM $wpdb->users WHERE ID=$theid");

				echo $author;

			}else{

			echo $thepost->$cell;

			}		

}



function st_posts($single=''){

	global $wpdb, $table_prefix, $nid;

	require(ABSPATH.'/wp-blog-header.php');

	$nid = $wpdb->escape($_GET['newsletter']);

	if($nid == ''){$nid = $wpdb->escape($_GET['preview']);}

	if (st_post_count() != FALSE){ 
		if(is_numeric($nid)){
			$posts = $wpdb->get_var("SELECT st_posts FROM ".$table_prefix."st_newsletter WHERE st_id=".$nid);
			$postorder = $wpdb->get_var("SELECT st_postorder FROM ".$table_prefix."st_newsletter WHERE st_id=".$nid);
		}
		

		

		$theposts = explode(',',$posts);

		//print_r($theposts);

		

		if ($postorder != ''){

		$theorder = explode(' ', $postorder);

		//print_r($theorder);

			foreach ($theorder as $oid){

				foreach($theposts as $key=>$pid){

					if($oid == $pid){

						unset($theposts[$key]);

					}

				}

			}

			$theposts = array_merge($theorder, $theposts);

		}

		



			if ($theposts): 

 				foreach ($theposts as $post):  

						$q='p='.$post;

						query_posts($q);

						while (have_posts()) : the_post();

						include('templates/'.st_get_nid_theme().'/st_posts.php'); 

						endwhile; 

				endforeach;

			endif;



	} 



}



function st_the_sidebox($no){

	global $wpdb, $nid, $table_prefix;

	$nid = $wpdb->escape($_GET['newsletter']);

	if($nid == ''){$nid = $wpdb->escape($_GET['preview']);}

			$boxno = "st_box".$no;
			if(is_numeric($nid))
			$box = $wpdb->get_var("SELECT ".$boxno." FROM ".$table_prefix."st_newsletter WHERE st_id=".$nid);

			if($box != '' && $stnl_config['nofilter'] != true){

				$box = apply_filters('the_content', $box);

			}

			return $box; 		

}



function st_the_content(){

global $wpdb, $nid, $table_prefix, $stnl_config;

$nid = $wpdb->escape($_GET['newsletter']);

	if($nid == ''){$nid = $wpdb->escape($_GET['preview']);}
			if(is_numeric($nid))
			$content = $wpdb->get_var("SELECT st_content FROM ".$table_prefix."st_newsletter WHERE st_id=".$nid);
			
			if( !$stnl_config['nofilter'] ){
				$content = apply_filters('the_content', $content);
			}
				$regex =  "/cellpadding=[\'\"]*([0-9])[\'\"]*/i";
				$replace = "cellpadding='$1' style='font-size:12px;'";
				$content = preg_replace($regex, $replace, $content);
				//$regex =  "/alt=[\'\"]*(.*)[\'\"]*/i";
				//$replace = "title='$1'";
				//$content = preg_replace($regex, $replace, $content);

			echo $content;

}



function st_the_metabox(){

global $wpdb, $nid, $table_prefix, $stnl_config;

$nid = $wpdb->escape($_GET['newsletter']);

	if($nid == ''){$nid = $wpdb->escape($_GET['preview']);}

			if(is_numeric($nid))
			$metabox = $wpdb->get_var("SELECT st_metabox1 FROM ".$table_prefix."st_newsletter WHERE st_id=".$nid);
			
			if($stnl_config['nofilter'] != true){
				$metabox = apply_filters('the_content', $metabox);
			}

			echo $metabox;

}

function st_view_online($before=false, $after=false, $link=false){

	if($before == false){$before = __('If you experience issues with the display of this newsletter, ', 'stnl');}

	if($after == false){$after = __(' to view it in your web browser.', 'stnl');}

	if($link == false){$link = __('click here');}

	$url = get_option('home').'/wp-content/plugins/st_newsletter/stnl_iframe.php?newsletter={nid}&amp;code={code}';

	 $view = $before.'<a href="'.$url.'">'.$link.'</a> '.$after;

	 echo $view;

} 

function st_unsubscribe($before=false, $after=false, $link=false){

global $wpdb, $stnl_config, $j, $table_prefix;

	if($before == false){$before = __('If you do not wish to receive this newsletter, ', 'stnl');}

	if($after == false){$after = __(' to unsubscribe or edit your settings.', 'stnl');}

	if($link == false){$link = __('click here');}

	

	$x = st_news_q();

			$unsub = $before.'<a href="'.$stnl_config['uri'].$x.'account={code}">'.$link.'</a>'.$after;

			echo $unsub;

}

function st_header(){

	include("templates/".st_get_nid_theme()."/st_header.php");

}

function st_footer(){

	include("templates/".st_get_nid_theme()."/st_footer.php");

}

function st_sidebar(){

	include("templates/".st_get_nid_theme()."/st_sidebar.php");

}

function st_template_uri(){

	$theme_dir =  dirname(__FILE__).'/templates/'.st_get_nid_theme();

	$theme_dir = get_option('siteurl').'/'.str_replace( ABSPATH, '', $theme_dir);

	return $theme_dir;

}

require("templates/".st_get_nid_theme()."/st_newsletter.php");

?>