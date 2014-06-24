<?php
function stnl_get_editors($cur=''){

	$theme_dir =  dirname(__FILE__).'/visual_editors';
	
	$editor = array('QuickTags', 'Tiny MCE');
	
	$myDirectory = opendir($theme_dir);

	// get each entry
	while($entryName = readdir($myDirectory)) {
		$dirArray[] = $entryName;
	}
	
	// close directory
	closedir($myDirectory);
	
	//	count elements in array
	$indexCount	= count($dirArray);
	
	// sort 'em
	sort($dirArray);
	
	// loop through the array of files and print them all
	for($index=0; $index < $indexCount; $index++) {
			if (substr("$dirArray[$index]", 0, 1) != "."){ // don't list hidden files
				$name =  $dirArray[$index];
				if(is_dir($theme_dir."/".$name)){
					$editor[] = $name;
				}
		}
	}
	foreach($editor as $ed){
		$valu = strtolower($ed);
		$valu = str_replace(' ', '', $valu);
		?>
        <option value="<?php echo $valu;?>" <?php if ($cur == $valu){echo 'selected="selected"';} ?>><?php echo $ed;?></option>
        <?php
	}
}
function stnl_editor($id, $content='', $prev='', $edit=''){
	global $wp_version;
	$stnl_config = get_option('stnl_config');
	
	$editor = $stnl_config['editor'];
	$wp_uri = get_option('home');
	
	
	if ($editor == 'quicktags'){
	
		if($wp_version < 2.1){ // FOR 2.0 SERIES
			?>

<?php the_quicktags(); ?>

<div><textarea title="true" rows="20" name="<?php echo $id;?>" tabindex="4" id="<?php echo $id;?>" style="width:98%; height: 400px;"><?php echo $content;?></textarea></div>

		<?php
		}else{
	?>
    <?php wp_print_scripts( 'quicktags' ); ?>
	<script type="text/javascript">edToolbar();</script>
		<textarea id="<?php echo $id;?>" name="<?php echo $id;?>" rows="20" cols="50" style="width:98%; height: 400px;"><?php echo $content;?></textarea>
		<script type="text/javascript">var edCanvas = document.getElementById('<?php echo $id;?>');</script>
		<?php
		}
		
	}elseif ($editor == 'tinymce'){
		
		if($wp_version < 2.1){ // FOR 2.0 SERIES
			?>

<?php the_quicktags(); ?>
<?php the_editor($content, $id, $prev); ?>
<!--<div><textarea title="true" rows="20" name="<?php echo $id;?>" tabindex="4" id="<?php echo $id;?>" style="width:98%; height: 400px;"><?php echo $content;?></textarea></div>-->

		<?php
		}else{
	
	?>
	<input id="edButtonPreview" class="edButtonFore" value="Visual" type="button" disabled="disabled">
<textarea class="mceEditor" id="<?php echo $id;?>" name="<?php echo $id;?>" rows="20" cols="50" style="width:98%; height: 400px;"><?php echo $content;?></textarea>
<?php	
	}


	}elseif ($editor == 'fckeditor'){
	
		$oFCKeditor = new FCKeditor($id);
		$oFCKeditor->Width  = '100%';
		$oFCKeditor->Height = '400';
		$oFCKeditor->BasePath = $wp_uri.'/wp-content/plugins/st_newsletter/visual_editors/fckeditor/';
		$oFCKeditor->Value = $content;
		$oFCKeditor->Create();
		
	}elseif ($editor == 'wysiwygpro'){
	
		// include the config file and editor class:
		include_once (ABSPATH.'/wp-content/plugins/WysiwygPro/editor_files/config.php');
		include_once (ABSPATH.'/wp-content/plugins/WysiwygPro/editor_files/editor_class.php');
		// create a new instance of the wysiwygPro class:
		$editor = new wysiwygPro();
		// Give the editor a name
		$editor->set_name($id);
		$editor->set_code($content);
		$editor->usexhtml();
		$editor->set_charset(get_option('blog_charset'));
		if (!WysiwygPro_get_option('image_manager', 1)) {
			$editor->disableimgmngr();
		}
		if (!WysiwygPro_get_option('image_thumbnails', 1)) {
			$editor->disablethumbnails();
		}
		
		// color swatches
		if ($values = WysiwygPro_get_option('colors', '')) {
			$editor->set_color_swatches($values);
		}
		
		// set menus
		
		// format menu
		if ($values = WysiwygPro_get_option('formats', '')) {
			$values = explode(',', $values);
			$array = array();
			$num = count($values);
			for ($i=0; $i<$num; $i++) {
				switch(strtolower(trim($values[$i]))) {
					case 'p':
						$v = '##normal## (p)';
						break;
					case 'div':
						$v = '##normal## (div)';
						break;
					case 'h1':
						$v = '##heading_1##';
						break;
					case 'h2':
						$v = '##heading_2##';
						break;
					case 'h3':
						$v = '##heading_3##';
						break;
					case 'h4':
						$v = '##heading_4##';
						break;
					case 'h5':
						$v = '##heading_5##';
						break;
					case 'h6':
						$v = '##heading_6##';
						break;
					case 'pre':
						$v = '##pre_formatted##';
						break;
					case 'address':
						$v = '##address1##';
						break;
					default:
						$v = $values[$i];
						break;
				}
				$array[$values[$i]] = $v;
			}
			$editor->set_formatmenu($array);
		}
		
		// font menu
		if ($values = WysiwygPro_get_option( 'fonts', '')) {
			$editor->set_fontmenu($values);
		}
		
		// class menu
		if ($values = WysiwygPro_get_option( 'classes', '')) {
			$values = explode(',', $values);
			$array = array();
			$num = count($values);
			for ($i=0; $i<$num; $i++) {
				$array[$values[$i]] = $values[$i];
			}
			$editor->set_classmenu($array);
		}
		
		// size menu
		if ($values = WysiwygPro_get_option( 'sizes', '')) {
			$values = explode(',', $values);
			$array = array();
			$num = count($values);
			for ($i=0; $i<$num; $i++) {
				$array[$values[$i]] = $values[$i];
			}
			$editor->set_sizemenu($array);
		}
		
		// remove buttons
		static $deadbuttons = array();
		if (empty($deadbuttons)) {
			$definitions = array('toolbar1','toolbar2','tab','html','preview','print','find','spacer1','pasteword','spacer2','undo','redo','spacer3','tbl','edittable','spacer4','image','smiley','ruler','link','document','bookmark','special','format','font','size','spacer5','bold','italic','underline','spacer6','left','center','right','full','spacer7','ol','ul','indent','outdent','spacer8','color','highlight');
			$num = count($definitions);
			for ($i=0; $i<$num; $i++) {
				if (!WysiwygPro_get_option( $definitions[$i], 1 )) {
					array_push($deadbuttons, $definitions[$i]);
				}
			}
		}
		$editor->removebuttons(implode(',',$deadbuttons));
		
		// build inserts menu
		static $inserts = array();
		if (empty($inserts)) {
				if ( $label = WysiwygPro_get_option( 'snippet1_label', '' ) ) {
					$h = WysiwygPro_get_option( 'snippet1_html', '' );
					$inserts[$label] = $h;
				}
				if ( $label = WysiwygPro_get_option( 'snippet2_label', '' ) ) {
					$h = WysiwygPro_get_option( 'snippet2_html', '' );
					$inserts[$label] = $h;
				}
				if ( $label = WysiwygPro_get_option( 'snippet3_label', '' ) ) {
					$h = WysiwygPro_get_option( 'snippet3_html', '' );
					$inserts[$label] = $h;
				}
				if ( $label = WysiwygPro_get_option( 'snippet4_label', '' ) ) {
					$h = WysiwygPro_get_option( 'snippet4_html', '' );
					$inserts[$label] = $h;
				}
				if ( $label = WysiwygPro_get_option( 'snippet5_label', '' ) ) {
					$h = WysiwygPro_get_option( 'snippet5_html', '' );
					$inserts[$label] = $h;
				}
				$editor->set_inserts($inserts);
		}	
		
		// set editor GUI language
		$editor->set_instance_lang(WysiwygPro_get_option( 'lang', 'en-us.php'));
		
		// base url
		$editor->set_baseurl(get_option('siteurl'));
		
		// line returns
		$usep = WysiwygPro_get_option( 'line_returns', 1 );
		$editor->usep($usep);
		
		// url scheme
		$fullurls = WysiwygPro_get_option( 'full_urls', 0 );
		$editor->usefullurls($fullurls);
		
		$editor->loadmethod('inline');
		
		// escape characters?
		$editor->escapeCharacters = WysiwygPro_get_option('escape_characters', true)?true:false;
		
		// get editor height
		$height = WysiwygPro_get_option('height', 400);
		
		// get editor code
		$code = $editor->return_editor('100%', intval($height));
		echo $code;
		
		//END WYSIWYGPRO CODE
	}
?>
	<script type='text/javascript' src='<?php echo $wp_uri;?>/wp-includes/js/quicktags.js?ver=3958'></script>
	<script type="text/javascript">
<!--
edCanvas = document.getElementById('<?php echo $id;?>');
//-->
</script><?php
	/*if (current_user_can('upload_files')) {
		$uploading_iframe_ID = (0 == $id);
		if($wp_version < 2.1){
			$uploading_iframe_src = wp_nonce_url("inline-uploading.php?action=view&amp;post=$uploading_iframe_ID", 'inlineuploading');
		}else{
			$uploading_iframe_src = wp_nonce_url("upload.php?style=inline&amp;tab=upload&amp;post_id=$uploading_iframe_ID", 'inlineuploading');
		}
		$uploading_iframe_src = apply_filters('uploading_iframe_src', $uploading_iframe_src);
		if ( false != $uploading_iframe_src )
			echo '<iframe id="uploading" frameborder="0" src="' . $uploading_iframe_src . '">' . __('This feature requires iframe support.') . '</iframe>';
	}*/
	
	if (current_user_can('upload_files')) {
		if(!$edit){$edit = 2;}
	$uploading_iframe_ID = $edit;
	$uploading_iframe_src = wp_nonce_url("upload.php?style=inline&amp;tab=upload&amp;post_id=$uploading_iframe_ID", 'inlineuploading');
	$uploading_iframe_src = apply_filters('uploading_iframe_src', $uploading_iframe_src);
	if ( false != $uploading_iframe_src )
		echo '<iframe id="uploading" name="uploading" frameborder="0" src="' . $uploading_iframe_src . '">' . __('This feature requires iframe support.') . '</iframe>';
}
	
}
function stnl_editor_css(){
?>
<link rel='stylesheet' href='<?php echo get_option('siteurl');?>/wp-includes/js/thickbox/thickbox.css?ver=20080613' type='text/css' media='all' />
<?php
}
function stnl_editor_js(){
	global $wp_version;
	$stnl_config = get_option('stnl_config');
	$wp_uri = get_option('siteurl');
	$editor = $stnl_config['editor'];
	
	if($editor == 'quicktags'){
	
		?><script src="<?php echo $wp_uri.'/wp-includes/js/quicktags.js';?>" type="text/javascript"></script><?php
		
	}elseif($editor == 'tinymce'){
		if($wp_version < 2.1){
		?>
<script type="text/javascript" src="../wp-includes/js/tinymce/tiny_mce_gzip.php?ver=20051211"></script>
		<?php }else{?>
<script type='text/javascript' src='<?php echo $wp_uri;?>/wp-includes/js/tinymce/tiny_mce_gzip.php?ver=20061113'></script>
<script type='text/javascript' src='<?php echo $wp_uri;?>/wp-includes/js/tinymce/tiny_mce_config.php?ver=20070225'></script>
		<?php }
		
	}elseif($editor == 'fckeditor'){
	
		include(ABSPATH.'/wp-content/plugins/st_newsletter/visual_editors/fckeditor/fckeditor.php');
	}
}
include_once( ABSPATH . 'wp-includes/pluggable.php' );
/*
if ( !function_exists('wp_nonce_url') ) :
function wp_nonce_url($actionurl, $action = -1) {
	return wp_specialchars(add_query_arg('_wpnonce', wp_create_nonce($action), $actionurl));
}
endif;
if ( !function_exists('wp_create_nonce') ) :
function wp_create_nonce($action = -1) {
	$user = wp_get_current_user();
	$uid = $user->id;

	$i = ceil(time() / 43200);

	return substr(wp_hash($i . $action . $uid), -12, 10);
}
endif;
if ( !function_exists('wp_get_current_user') ) :
function wp_get_current_user() {
	global $current_user;

	get_currentuserinfo();

	return $current_user;
}
endif;
if ( !function_exists('wp_hash') ) :
function wp_hash($data) {
	$salt = wp_salt();

	if ( function_exists('hash_hmac') ) {
		return hash_hmac('md5', $data, $salt);
	} else {
		return md5($data . $salt);
	}
}
endif;
if ( !function_exists('wp_salt') ) :
function wp_salt() {
	$salt = get_option('secret');
	if ( empty($salt) )
		$salt = DB_PASSWORD . DB_USER . DB_NAME . DB_HOST . ABSPATH;

	return $salt;
}
endif;
*/
?>