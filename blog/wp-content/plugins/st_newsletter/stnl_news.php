<?php
function stnl_news(){

	global $stnl_version, $wpdb, $table_prefix, $wp_version, $stnl_php;

	echo '<div class="wrap">';

	echo '<h2>'.__('WP Newsletter v','stnl').$stnl_version.'</h2>';
	echo '<div id="zeitgeist"><h2>'.__('Latest Activity','stnl').'</h2>';
	$all_nl = $wpdb->get_results("SELECT st_id FROM ".$table_prefix."st_newsletter");
	$total_nl = count($all_nl);

	$all_sub = $wpdb->get_results("SELECT st_id FROM ".$table_prefix."st_mailinglist");
	$total_sub = count($all_sub);
	
	$five_nl = $wpdb->get_results("SELECT st_id, st_title FROM ".$table_prefix."st_newsletter ORDER BY st_id DESC LIMIT 5");
	$all_cats = $wpdb->get_results("SELECT st_id, st_name FROM ".$table_prefix."st_categories");
	$total_cats = count($all_cats);
	
	echo '<div><h3>'.__('Newsletters','stnl').'</h3><ul>';
		foreach($five_nl as $id=>$nl){
			echo '<li><a href="admin.php?page=manage-newsletter&edit_newsletter='.$nl->st_id.'#edit">'.$nl->st_title.'</a></li>';
		}
	
	echo '</ul></div>';
	echo '<div><h3>'.__('Newsletter Stats','stnl').'</h3><p>';
	if($total_nl == 1){
		echo __('There are currently ', 'stnl').$total_nl.__(' newsletter', 'stnl');
	}else{
		echo __('There are currently ', 'stnl').$total_nl.__(' newsletters', 'stnl');
	}

	if($total_sub == 1){
		echo __(' and ', 'stnl').$total_sub.__(' subscriber', 'stnl');
	}else{
		echo __(' and ', 'stnl').$total_sub.__(' subscribers', 'stnl');
	}
	
	if($total_cats == 1){
		echo __(' in ', 'stnl').$total_cats.__(' category', 'stnl');
	}else{
		echo __(' in ', 'stnl').$total_cats.__(' categories', 'stnl');
	}
	
	
	
	echo '.</p></div>';
	echo '</div>';
	
?>

<ul>
	<li><a href="admin.php?page=create-newsletter"><?php _e('Create','stnl');?></a></li>
	<li><a href="admin.php?page=manage-newsletter"><?php _e('Manage','stnl');?></a></li>
	<li><a href="admin.php?page=cat-newsletter"><?php _e('Categories','stnl');?></a></li>
	<li><a href="admin.php?page=preview-newsletter"><?php _e('Preview/Send','stnl');?></a></li>
	<li><a href="admin.php?page=subscribers-newsletter"><?php _e('Subscribers','stnl');?></a></li>
</ul>
<p><?php _e('Need help? Please see our <a href="http://docs.shiftthis.net/">documentation</a>.','stnl');?></p>

<?php
	if(stnl_phpversion() != $stnl_php && $stnl_php != '0'){
	echo '<h3>'.__('Version Compatibility Warning','stnl').'</h3><p style="color:red;">'.__('This plugin requires PHP ','stnl').$stnl_php.__(' and you are running PHP ','stnl').stnl_phpversion().'.  '.__('Please download the version of this plugin that is compatible with PHP ','stnl').stnl_phpversion().'.</p>';
 	}
  $rssfile = 'http://www.shiftthis.net/category/news-and-updates/wp-newsletter/';

  	echo '<p>'.__('View the latest ','stnl').' <a href="'.$rssfile.'">'.__('Developer News','stnl').'</a></p>';

	echo '</div>';

}

//http://www.shiftthis.net/category/news-and-updates/wp-newsletter/feed/

?>