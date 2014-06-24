<?php
function stnl_uri($page=''){
	$uri = get_option('siteurl').'/wp-admin/admin.php?page='.$page;
	return $uri;
}
function stnl_dir($type='reg'){
	if($type != 'reg'){
		$dir = ABSPATH.'/wp-content/plugins/st_newsletter/';
	}else{
		$dir = get_option('siteurl').'/wp-content/plugins/st_newsletter/';
	}
	return $dir;
}
function stnl_subfieldsjs(){
	global $wpdb, $table_prefix;
	$stnl_config = get_option('stnl_config');
	$isoptions = strpos($_SERVER['REQUEST_URI'], 'options-newsletter');
	if ( $isoptions === false ) {}else{
		$fields = $stnl_config['formfields'];
		$fieldarr = unserialize($fields);
		$fieldcount = count($fieldarr);
		$counter = "+".$fieldcount;
?>
<script type="text/javascript">
<!--

var counter = 0<?php echo $counter; ?>;

function init() {
	document.getElementById('moreFields').onclick = moreFields;
	moreFields();
	document.getElementById('moreHeadings').onclick = moreHeadings;
	moreHeadings();
}

function moreFields() {
	counter++;

	var newFields = document.getElementById('readroot').cloneNode(true);
	
	newFields.id = '';
	newFields.style.display = 'block';
	var newField = newFields.childNodes;
	for (var i=0;i<newField.length;i++) {
		var theName = newField[i].name
		var theID = newField[i].id
		if (theName)
			newField[i].name = theName + counter;
		if (theID)
			newField[i].id = theID + counter;
			
	}

	var insertHere = document.getElementById('writeroot');
	insertHere.parentNode.insertBefore(newFields,insertHere);
}

// -->
</script>
<?php
	}
}



function rel2ab($src){
	
	$abslink = preg_replace('/src=\\\"(.*)\.(.*)\\\" /', 'src="'.get_option('siteurl').'$1.$2"', $src);
	$abslink = str_replace(get_option('siteurl').get_option('siteurl'), get_option('siteurl'), $abslink);
	$abslink = str_replace(get_option('siteurl').'http', 'http', $abslink);
	
	return $abslink;
}


function genunique($length){ 

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
for($i = 0; $i < $length; $i++) {
$x = rand(0, strlen($chars) -1);
$password .= $chars{$x};
    }
    return($password);
}  
function st_uri(){
	global $stnl_config;
	if($stnl_config['suburi'] == ''){
		$wp_base = get_option('home');
		$base_arr = explode('/', $wp_base);
		$base_count = count($base_arr)-1;
		$uri = $wp_base.$_SERVER['REQUEST_URI'];
		if ($base_count > 2){
			unset($base_arr[0]);
			unset($base_arr[1]);
			unset($base_arr[2]);
			$base_uri = implode('/', $base_arr); 
			$base_uri = '/'.$base_uri;
			$uri = $wp_base.str_replace($base_uri, '', $_SERVER['REQUEST_URI']);
		}
	}else{
		$uri = $stnl_config['suburi'];
	}
	return $uri;
}
function st_formuri(){	
	$furi = str_replace('/?subscribe=true','', st_uri());
	$furi = str_replace('&amp;subscribe=true','', $furi);
	$furi = str_replace('&subscribe=true','', $furi);
	$furi = rtrim($furi, '/');
	$qcheck = strpos($furi, '?');
	$phpcheck = strpos($furi, '.php');
	if ($qcheck === false && $phpcheck === false){
	$furi = $furi.'/';
	}
	
	return $furi;
}
function st_q($uri=''){
	global $stnl_config;
	if($uri == ''){$uri = $_SERVER['REQUEST_URI'];}
	$qcheck = strpos($uri, '?');
	if($qcheck === false){
		$j = '?';
	}else{
		$j = '&amp;';
	}
	if(strpos($uri, '?subscribe=true') === false){
	}else{
		$j = '?';
	}
	return $j;
}
function st_hq(){
	global $stnl_config;
	$uri = $stnl_config['uri'];
	$qcheck = strpos($uri, '?');
	if($qcheck === false){
		$j = '?';
	}else{
		$j = '&amp;';
	}
	return $j;
}

function st_news_q(){
global $stnl_config;
	$uri = $stnl_config['uri'];
	$qcheck = strpos($uri, '?');
	if($qcheck === false){
		$j = '?';
	}else{
		$j = '&amp;';
	}
	
	return $j;
}
function st_getcat($catid){
	global $wpdb, $table_prefix;
	$id = $catid;
	$getcat = "SELECT st_name FROM ".$table_prefix."st_categories WHERE st_id = '".$catid."'";
	$catname = $wpdb->get_var($getcat);
	return $catname;
}
function st_catoptions($selected='', $type='nl'){
	global $wpdb, $table_prefix;
	$getcats = "SELECT * FROM ".$table_prefix."st_categories WHERE st_type='$type'";
	$cats = $wpdb->get_results($getcats);
	$sel = explode('[|]',$selected);
	foreach ($cats as $cat){ 
		$select .= "<option value='".$cat->st_id."'";
		if (in_array($cat->st_id,$sel)) { $select .= 'selected="selected"';}
		$select .= ">".$cat->st_name."</option>";
	}
	return $select;
}
function st_catcheck($selected=''){
	global $wpdb, $table_prefix;
	$getcats = "SELECT * FROM ".$table_prefix."st_categories ORDER BY st_type";
	$cats = $wpdb->get_results($getcats);
	
	$check .= "<div id='nlcheck'><h4>".__('Newsletter', 'stnl').'</h4>';
	foreach ($cats as $cat){ 
		$id = $cat->st_id;
		if($cat->st_type == 'nl'){
			$check .= '<input type="checkbox" class="checkbox" name="sts_cats[]" id="cats'.$id.'"  value="'.$id.'"';
			if (is_array($selected) == true){
				if (in_array($id,$selected) == true) { $check .= 'checked="checked"';}
			}
			$check .= ' /> <label class="checklabel" for="cats'.$id.'">'.$cat->st_name.'</label> <br />';
		}
	}
	$check .= '</div>';
	
	$responder = ABSPATH."/wp-content/plugins/st_newsletter/shiftthis-responder.php";
	if (file_exists($responder)) {
		$check .= "<div id='nlcheck'><h4>".__('Responders', 'stnl').'</h4>';
		foreach ($cats as $cat){ 
			$id = $cat->st_id;
			if($cat->st_type == 'ar'){
				$check .= '<input type="checkbox" class="checkbox" name="sts_cats[]" id="cats'.$id.'"  value="'.$id.'"';
				if (is_array($selected) == true){
					if (in_array($id,$selected) == true) { $check .= 'checked="checked"';}
				}
				$check .= ' /> <label class="checklabel" for="cats'.$id.'">'.$cat->st_name.'</label> <br />';
			}
		}
		$check .= '</div>';
	}
	return $check;
}
function st_catname($id){
	global $wpdb, $table_prefix;
	$getcat = "SELECT st_name FROM ".$table_prefix."st_categories WHERE st_id='$id'";
	$cat = $wpdb->get_var($getcat);
	return $cat;
}
function st_defaultcat($type='nl'){
	global $wpdb, $table_prefix;
	$getcat = "SELECT st_name FROM ".$table_prefix."st_categories WHERE st_default='1' AND st_type='$type'";
	$cat = $wpdb->get_var($getcat);
	return $cat;
}
function st_defaultcatid($type='nl'){
	global $wpdb, $table_prefix;
	$getcat = "SELECT st_id FROM ".$table_prefix."st_categories WHERE st_default='1' AND st_type='$type'";
	$cat = $wpdb->get_var($getcat);
	return $cat;
}
function st_cattype($id){
	global $wpdb, $table_prefix;
	$gettype = "SELECT st_type FROM ".$table_prefix."st_categories WHERE st_id='$id'";
	$type = $wpdb->get_var($gettype);
	return $type;
}
function st_respcheck($email, $catid){
	global $wpdb, $table_prefix;
	$getresp= "SELECT st_responder FROM ".$table_prefix."st_mailinglist WHERE st_email='$email'";
	$ar = $wpdb->get_var($getresp);
	
	$ar = unserialize($ar);
	//print_r($ar);
	if(is_array($ar) == true){
		if (array_key_exists($catid, $ar)){	
			return true;
		}else{
			return false;
		}
	}
}
function st_respdate($email, $catid){
	global $wpdb, $table_prefix;
	$getresp= "SELECT st_responder FROM ".$table_prefix."st_mailinglist WHERE st_email='$email'";
	$ar = $wpdb->get_var($getresp);
	$ar = unserialize($ar);
	$date = $ar[$catid];
	return $date;
}
if (!function_exists('array_combine')) {
   function array_combine($a, $b) {
       $c = array();
       if (is_array($a) && is_array($b))
           while (list(, $va) = each($a))
               if (list(, $vb) = each($b))
                   $c[$va] = $vb;
               else
                   break 1;
       return $c;
   }
}
if (!function_exists('str_split')) {
	function str_split($str, $nr){   
	   return split("-l-", chunk_split($str, $nr, '-l-'));
	}
}

function st_datecheck($interval, $date){
	$today = date('Ymd');
	$monthmax = array('01'=>'31', '02'=>'28', '03'=>'31', '04'=>'30', '05'=>'31', '06'=>'30', '07'=>'31', '08'=>'31', '09'=>'30', '10'=>'31', '11'=>'30', '12'=>'31');
	$dsplit = str_split($date, 2);
	$year = $dsplit[0].$dsplit[1];
	$month = $dsplit[2];
	$day = $dsplit[3];
	$curmax = $monthmax[$month]; //current months max days
	
	$newday = $day + $interval; //date plus interval
	
	if ($newday > $curmax){ //if New date exceeds month max
		$newday = $newday - $curmax; //next months date
		$newmonth = $curmonth+1; //move the month up one
		$newyear = $year; //same year if not DEC
		if ($month == '12'){ //if it's December
			$newmonth = '01'; //new month is JAN
			$newyear = $year + 1; //new year goes up one
		}
		$senddate = $newyear.$newmonth.$newday; //NEW END DATE
	}else{
		$senddate = $date + $interval;
	}
	//echo $senddate;
	if($senddate == $today){
		return true;
	}else{
		return false;
	}			
}

function stnl_extras($values='', $out='form'){
	global $wpdb, $table_prefix, $stnl_config;
	
	$what_extras = $stnl_config['subscribefields'];
	//echo $what_extras;
	//echo $values;
	$the_extras = explode('[|]', $what_extras);
	$the_values = explode('[*]', $values);
	//print_r($the_values);
	foreach($the_extras as $ex){
		$prev = $extras;
		$extra = explode('[*]', $ex);
		$extras = array($extra[0] => $extra[1]);
		if($prev != ''){
			$extras = array_merge($prev, $extras);
		}
	}
	foreach($the_values as $val){
		$prev = $evals;
		$eval = explode('[:]', $val);
		$evals = array($eval[0] => $eval[1]);
		if($prev != ''){
			$evals = array_merge($prev, $evals);
		}
	}
	//print_r($evals);
	if($out == 'form'){
		foreach($extras as $label => $req){
		$id = str_replace(' ', '', $label);
		if($req == 'Yes'){
			$reqtext = stripslashes($stnl_config['req']);
		}
		if($label != ''){
		$output .= '<p><label for="'.$id.'">'.$label.': </label><br /><input type="text" id="'.$id.'" name="'.$id.'" value="'.$evals[$id].'" /> '.$reqtext.'</p>';
		}
		$reqtext='';
		
		}
	}
	return $output;
}

function stnl_returnhtml($nid, $st_email=''){
	global $table_prefix, $wpdb, $stnl_config;
	
	//$e_sql = "SELECT * FROM " . $table_prefix . "st_mailinglist WHERE st_email='".$st_email."'";
	//$e_subscriber = $wpdb->get_row($e_sql);
	if (get_option('gzipcompression')){

				update_option('gzipcompression', '');

				$gzipfix = true;

		}
	ob_start(); # start buffer
	include_once( 'stnl_display_template.php' );
	# we pass the output to a variable
	$html = ob_get_contents();
	ob_end_clean(); # end buffer
	# and here's our variable filled up with the html
	if ($gzipfix == true){

				update_option('gzipcompression', 1);

		}
	return $html;
}
function stnl_phpversion(){
	switch(true)
	{
		case (version_compare("5", phpversion(), "<=")):
		$phpv = '5';
	break;
		case (version_compare("5", phpversion(), ">")):
		$phpv = '4';
	break;
	}
	return $phpv;
}
function stnl_swiftlog_js(){
	if($_POST['send_cat'] || $_POST['send_single']){
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#swiftlog').hide();
  jQuery('a#log-toggle').click(function() {
	jQuery('#swiftlog').toggle(400);
	return false;
  });
});
</script>
<?php
	}
}

function stnl_dupecheck($email){
	global $wpdb;
	$table = $wpdb->prefix.'st_mailinglist';
	//echo $email;
	$dupe = $wpdb->get_var("SELECT st_id FROM $table WHERE st_email = '$email'");
	//echo 'dupe='.$dupe;
	if($dupe){
		return $dupe;
	}else{
		return false;
	}
}
?>