<?php

function stnl_create(){
	global $table_prefix, $wpdb, $userdata, $stnl_config;
	$sl = $stnl_config['slashfix'];
 ?>

<?php $h2 = __("Create Newsletter", 'stnl');?>
<?php echo stnl_editing('',$h2); ?>
<?php
}

function stnl_editing($edit='', $h2=''){
global $table_prefix, $wpdb, $stnl_config, $wp_version;
$sl = $stnl_config['slashfix'];
if ( $edit != '' ) {
	$e_sql = "SELECT * FROM " . $table_prefix . "st_newsletter WHERE st_id=". $edit;
	$e_news = $wpdb->get_row($e_sql);
	$newdate = chunk_split($e_news->st_date, 2, '-');
				list($y, $year, $month, $day) = split('[/.-]', $newdate);
			$montharr = array( '', __('January', 'stnl'), __('February', 'stnl'), __('March', 'stnl'), __('April', 'stnl'), __('May', 'stnl'), __('June', 'stnl'), __('July', 'stnl'), __('August', 'stnl'), __('September', 'stnl'), __('October', 'stnl'), __('November', 'stnl'), __('December', 'stnl'));
			$month = ltrim($month, "0");
			$day = ltrim($day, "0");
			$year = $y.$year;
			$news_date = $montharr[$month].' '.$day.', '.$year;


			$postarr = explode(',',$e_news->st_posts);

	$template = $e_news->st_template;

}	else{

	$template = $stnl_config['template'];

}

	if (isset($_POST['Submit'])) {

echo "<div class='updated'><p><strong>".__('Newsletter Updated', 'stnl')."</strong> <small><a href='".stnl_uri('manage-newsletter')."'>".__('Manage Newsletters', 'stnl')." &raquo;</a></small></p></div>";

}



if ($year == ''){ $year = date('Y');}

if ($day == '') { $day = date('j');}

if ($month == '') { $month = date('n');}

?>
<?php if ($edit != ''){ ?>

		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>&amp;edit=true" enctype="multipart/form-data">

	<?php } else { ?>

	  	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>&amp;new=true" enctype="multipart/form-data"> 

	<?php } ?>
    
<div class="wrap">

	<h2><?php echo $h2;?></h2>
    <?php
    $fields = $stnl_config['subscribefields'];

	$fieldmix = explode('[|]', $fields);

	$multi = count($fieldmix);

	foreach($fieldmix as $f){

		$new = explode('[*]', $f);

		$farr = array('label' => $new[0], 'required' => $new[1]);

		$fieldarr[] = $farr;

	}

	//print_r($fieldarr);

	$fieldcount = count($fieldarr);

	//echo $fieldcount;

	$i = 1;

	if($fieldcount >= 1){

		foreach ($fieldarr as $row){

			//print_r($row);
			$req = $row['required'];
			$label = $row['label'];
			$tag = str_replace(' ', '', $label);

			if($label != ''){
				$taginfo .= "<li>";
				if($req == "Yes"){ $taginfo .= '<strong>';}
				$taginfo .= "{".$tag."}";
				if($req == "Yes"){ $taginfo .= '</strong>';}
				$taginfo .="\n";
			}
		}
	}
    ?>
<?php if ($wp_version < 2.5 ){ ?>
<div id="poststuff">

<div id="moremeta">

<div id="grabit" class="dbx-group">

    <fieldset id="dynadiv" class="dbx-box">
    <h3 class="dbx-handle"><?php _e('Dynamic Text Tags', 'stnl');?></h3>
    <div class="dbx-content">

	<p id="jaxcat"></p>
<small><?php _e('These tags can be used as replacements for subscriber data.  When your newsletter is sent these tags will be replaced with actual subscriber data.','stnl');?></small>
			<ul>
			<?php echo $taginfo;?>
            </ul>
      </div>
      </fieldset>

	<fieldset id="datediv" class="dbx-box">

	<h3 class="dbx-handle"><?php _e('Newsletter Date', 'stnl');?></h3>

	<div class="dbx-content">

	<p id="jaxcat"></p>

	<select name="stn_month" style="width:60px">

					<option value="01" <?php if($month == "1"){echo 'selected="selected"';}?>><?php _e("Jan", 'stnl');?></option>

					<option value="02" <?php if($month == "2"){echo 'selected="selected"';}?>><?php _e("Feb", 'stnl');?></option>

					<option value="03" <?php if($month == "3"){echo 'selected="selected"';}?>><?php _e("Mar", 'stnl');?></option>

					<option value="04" <?php if($month == "4"){echo 'selected="selected"';}?>><?php _e("Apr", 'stnl');?></option>

					<option value="05" <?php if($month == "5"){echo 'selected="selected"';}?>><?php _e("May", 'stnl');?></option>

					<option value="06" <?php if($month == "6"){echo 'selected="selected"';}?>><?php _e("Jun", 'stnl');?></option>

					<option value="07" <?php if($month == "7"){echo 'selected="selected"';}?>><?php _e("Jul", 'stnl');?></option>

					<option value="08" <?php if($month == "8"){echo 'selected="selected"';}?>><?php _e("Aug", 'stnl');?></option>

					<option value="09" <?php if($month == "9"){echo 'selected="selected"';}?>><?php _e("Sep", 'stnl');?></option>

					<option value="10" <?php if($month == "10"){echo 'selected="selected"';}?>><?php _e("Oct", 'stnl');?></option>

					<option value="11" <?php if($month == "11"){echo 'selected="selected"';}?>><?php _e("Nov", 'stnl');?></option>

					<option value="12" <?php if($month == "12"){echo 'selected="selected"';}?>><?php _e("Dec", 'stnl');?></option>

					</select> <input name="stn_day" type="text" size="3" value="<?php echo $day; ?>" style="width:20px;" />, <input name="stn_year" type="text" size="6" value="<?php echo $year; ?>" style="width:40px;" /></div>

	</fieldset>

	

	<fieldset id="categorydiv" class="dbx-box">

	<h3 class="dbx-handle"><?php _e('Category', 'stnl');?></h3>

	<div class="dbx-content">

	<p id="jaxcat"></p>

	<select name="stn_category">

						<?php echo st_catoptions($e_news->st_cat);?>

					</select></div>

	</fieldset>

    

    <fieldset id="templatediv" class="dbx-box">

	<h3 class="dbx-handle"><?php _e('Template', 'stnl');?></h3>

	<div class="dbx-content">

	<p id="jaxcat"></p>

	<select name="stn_template">

						<?php stnl_get_template($template);?>

					</select></div>

	</fieldset>

	

	<?php 
if($stnl_config['showposts'] == 'show'){
				if ($stnl_config['recentposts'] != ''){

					$limit = 'LIMIT '.$stnl_config['recentposts'];

				}
				if($stnl_config['pages'] == true){
						$incpages = "";	
					}else{
						$incpages = "AND post_type != 'page'";
					}
					
				$theposts = $wpdb->get_results("SELECT ID, post_title, post_type, post_status FROM $wpdb->posts WHERE post_status IN('publish','private') $incpages ORDER BY ID DESC $limit");		

				$i = 1;

				foreach($theposts as $post){ 

					$curpost = $postvalue[$i];

					//if ($post->post_type == 'post' && $post->post_status != 'draft' || $post->post_type == $incpages){

							$selposts .=  '<option value="'.$post->ID.'"';

							$p = $i-1;

						if($edit != ''){

							if(in_array($post->ID, $postarr) == true){

								$selposts .=  'selected="selected"';

							}

						}

							$selposts .=  '>'.$post->ID.' - '.$post->post_title.'</option>';

							$i = $i+1;

					//}

				}
					?>

	

	<fieldset id="slugdiv" class="dbx-box">

	<h3 class="dbx-handle"><?php _e('Include These Posts', 'stnl');?></h3>

	<div class="dbx-content">

	<p id="jaxcat"></p>

	<small><?php _e('(hold ctrl to select multiple posts)', 'stnl');?></small>

	<select multiple name="stn_posts[]" >

						<?php echo $selposts;?>


					</select> 

					

				<label><?php _e('Custom Post Order:', 'stnl');?> <input type="text" size="20" name="stn_postorder" value="<?php echo $e_news->st_postorder; ?>" /></label>

<small><?php _e('(Place the ID numbers of the posts you selected above seperated by a space in the order you want them to display in your newsletter)', 'stnl');?></small>

	</div>

	</fieldset>
<?php } ?>
	

		<fieldset id="passworddiv" class="dbx-box">

<h3 class="dbx-handle"><?php _e('Send Newsletter as:', 'stnl');?></h3> 



<div class="dbx-content"><select name="stn_mime">

						<option value="multi" <?php if ($e_news->st_mime == 'multi'){echo 'selected="selected"';} ?>><?php _e("Multi-Part (Text/HTML)", 'stnl');?></option>

						<option value="html" <?php if ($e_news->st_mime == 'html'){echo 'selected="selected"';} ?>><?php echo _e("HTML Only", 'stnl');?></option>

						<option value="text" <?php if ($e_news->st_text == 'text'){echo 'selected="selected"';} ?>><?php echo _e("Text Only", 'stnl');?></option>

					</select></div>

</fieldset>



		<fieldset id="poststatusdiv" class="dbx-box">

<h3 class="dbx-handle"><?php _e('Newsletter Archive Status:', 'stnl');?></h3> 



<div class="dbx-content"><select name="stn_status">

						<option value="0" <?php if ($e_news->st_status == 0){echo 'selected="selected"';} ?>><?php _e("Draft", 'stnl');?></option>

						<option value="1" <?php if ($e_news->st_status == 1){echo 'selected="selected"';} ?>><?php echo _e("Private", 'stnl');?></option>

						<option value="2" <?php if ($e_news->st_status == 2){echo 'selected="selected"';} ?>><?php echo _e("Published", 'stnl');?></option>

					</select></div>

</fieldset>

									

		

		

</div></div>





	

	    	<input type="hidden" name="newsletter_submit" value="true" />

			<?php if ($edit != ''){ ?>

			<input name="stn_id" type="hidden" value="<?php echo $e_news->st_id; ?>" />

			<?php } ?>

	    

		<fieldset id="titlediv">

	<legend><strong><?php _e('Newsletter Title / Email Subject:', 'stnl');?></strong></legend>

			        <div><input name="stn_title" type="text" size="50" value="<?php echo $e_news->st_title; ?>" /></div>

		      	</fieldset>
	
    <?php 
	   $stnl_config = get_option('stnl_config');
	   if($stnl_config['showheader']=='show'){ ?>
     <fieldset id="postdivrichheader">
			<legend><strong><?php _e('Header Image :', 'stnl');?></strong></legend>
            	<p style="margin:0;padding:0;">Upload the Header background image which needs to be pre-sized to a minimum of 660px wide by 140px tall. (accepts JPG, GIF or PNG images)</p>
                <input type="file" name="headimg" width="450px" /><br />
                <?php if($e_news->st_header){ ?>
         		<div style="background-image:url(<?php echo $e_news->st_header; ?>); width:660px; height:140px;"></div>
                <?php } ?>
		</fieldset>
	<?php  } ?>
		        				        

		<fieldset id="postdivrich">

			<legend><strong><?php _e('Content:', 'stnl');?></strong></legend>

			        <div><?php stnl_editor('content', apply_filters('the_content', $e_news->st_content), 'stn_title', $edit); ?></div>

		 </fieldset>
         
        

				<?php

				

				

				$boxes = $stnl_config['boxes'];

				for($i = 1; $i <= $boxes; $i++){

				$boxvalue = array( '', $e_news->st_box1, $e_news->st_box2, $e_news->st_box3, $e_news->st_box4, $e_news->st_box5, $e_news->st_box6, $e_news->st_box7, $e_news->st_box8, $e_news->st_box9, $e_news->st_box10);

				$curbox = $boxvalue[$i];

	if($i > 1){

		$prevbox = 'stn_box'.($i-1);

	}else{

		$prevbox = 'content';

	}

	if($boxes > 0){

		$lastbox = 'stn_box'.$boxes;

	}else{

		$lastbox = 'content';

	}

				?>

		      	<fieldset id="postdivrich<?php echo $i;?>">

			<legend><strong><?php _e('Sidebar', 'stnl');?> <?php echo $i;?>:</strong></legend>

			        <div>

<?php

 $rows = get_option('default_post_edit_rows');

 if (($rows < 3) || ($rows > 100)) {

     $rows = 10;

 }?><?php stnl_editor('stn_box'.$i, $curbox, $prevbox); ?>

</div></fieldset>

				<?php 



				} 
				
	if($stnl_config['metabox'] == true){
	?>

				<fieldset id="metadivrich">

				<legend><strong><?php _e('Metabox:', 'stnl');?></strong></legend>

			        <div>

<?php

 $rows = get_option('default_post_edit_rows');

 if (($rows < 3) || ($rows > 100)) {

     $rows = 10;

 }?><?php stnl_editor('stn_metabox', $e_news->st_metabox1, $lastbox); ?>



</div></fieldset>
<?php } ?>

	    	<p class="submit">

	      		<input type="submit" name="Submit" value="<?php _e("Save Newsletter", 'stnl');?> &raquo;" />

	    	</p>

	  	
<?php }else{ 

######################################
# WORDPRESS 2.5 !!!!!!!!!!!!!!!!!!!!!#
######################################
global $user_ID;
$user_ID = (int) $user_ID;
?>
&nbsp;
<div id="poststuff">
<div class="submitbox" id="submitpost">
<div id="previewview">
</div>
<div class="inside">

    <p><strong><?php _e('Publish Status','stnl');?></strong></p>
    

    <p>
    <input type="hidden" id="user-id" name="user_ID" value="<?php echo $user_ID ?>" />
    <input type="hidden" id="tags-input" name="tags" value="" />
        <select name="stn_status" tabindex="4">

						<option value="0" <?php if ($e_news->st_status == 0){echo 'selected="selected"';} ?>><?php _e("Draft", 'stnl');?></option>
                        <option value="1" <?php if ($e_news->st_status == 1){echo 'selected="selected"';} ?>><?php echo _e("Private", 'stnl');?></option>
                        <option value="2" <?php if ($e_news->st_status == 2){echo 'selected="selected"';} ?>><?php echo _e("Published", 'stnl');?></option>
        </select>
    </p>
    
    <p class="curtime"><?php _e('Newsletter Date', 'stnl');?></p>
    
    <div id='timestampdiv'><select name="stn_month" style="width:60px">

					<option value="01" <?php if($month == "1"){echo 'selected="selected"';}?>><?php _e("Jan", 'stnl');?></option>

					<option value="02" <?php if($month == "2"){echo 'selected="selected"';}?>><?php _e("Feb", 'stnl');?></option>

					<option value="03" <?php if($month == "3"){echo 'selected="selected"';}?>><?php _e("Mar", 'stnl');?></option>

					<option value="04" <?php if($month == "4"){echo 'selected="selected"';}?>><?php _e("Apr", 'stnl');?></option>

					<option value="05" <?php if($month == "5"){echo 'selected="selected"';}?>><?php _e("May", 'stnl');?></option>

					<option value="06" <?php if($month == "6"){echo 'selected="selected"';}?>><?php _e("Jun", 'stnl');?></option>

					<option value="07" <?php if($month == "7"){echo 'selected="selected"';}?>><?php _e("Jul", 'stnl');?></option>

					<option value="08" <?php if($month == "8"){echo 'selected="selected"';}?>><?php _e("Aug", 'stnl');?></option>

					<option value="09" <?php if($month == "9"){echo 'selected="selected"';}?>><?php _e("Sep", 'stnl');?></option>

					<option value="10" <?php if($month == "10"){echo 'selected="selected"';}?>><?php _e("Oct", 'stnl');?></option>

					<option value="11" <?php if($month == "11"){echo 'selected="selected"';}?>><?php _e("Nov", 'stnl');?></option>

					<option value="12" <?php if($month == "12"){echo 'selected="selected"';}?>><?php _e("Dec", 'stnl');?></option>

					</select> <input name="stn_day" type="text" size="3" value="<?php echo $day; ?>" style="width:20px;" />, <input name="stn_year" type="text" size="6" value="<?php echo $year; ?>" style="width:40px;" />
    
    </div>

</div>
<p class="submit">
<input type="submit" name="Submit" class="button button-highlighted" value="<?php _e("Save Newsletter", 'stnl');?>" />
<br class="clear" />
</p>
</div>
<div id="post-body">
<div id="titlediv">

<h3><?php _e('Title','stnl');?></h3>
<div id="titlewrap">
	<input name="stn_title" type="text" size="30" id="title" value="<?php echo $e_news->st_title; ?>" autocomplete="off" />
</div>
<div class="inside">
	<div id="edit-slug-box">
	</div>
</div>
</div>
<div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea">
<h3><?php _e('Content','stnl') ?></h3>
<?php the_editor($e_news->st_content, 'content'); ?>
</div>



<div id="categorydiv" class="postbox <?php echo postbox_classes('categorydiv', 'post'); ?>">
<h3><?php _e('Category','stnl') ?></h3>
<div class="inside">
<p><select name="stn_category"><?php echo st_catoptions($e_news->st_cat);?></select></p>
</div>
</div>

<h2><?php _e('Advanced Options','stnl'); ?></h2>

<div id="templatediv" class="postbox <?php echo postbox_classes('templatediv', 'post'); ?>">
<h3><?php _e('Template','stnl') ?></h3>
<div class="inside">
<p><select name="stn_template"><?php stnl_get_template($template);?></select></p>
</div>
</div>

<?php
			if($stnl_config['showposts'] == 'show'){
				if ($stnl_config['recentposts'] != ''){
					$limit = 'LIMIT '.$stnl_config['recentposts'];
				}
				if($stnl_config['pages'] == true){
					$incpages = "";	
				}else{
					$incpages = "AND post_type != 'page'";
				}
				
				$theposts = $wpdb->get_results("SELECT ID, post_title, post_type, post_status FROM $wpdb->posts WHERE post_status IN('publish','private') $incpages ORDER BY ID DESC $limit");		
				$i = 1;
				foreach($theposts as $post){ 
					$curpost = $postvalue[$i];
							$selposts .=  '<option value="'.$post->ID.'"';
							$p = $i-1;
						if($edit != ''){
							if(in_array($post->ID, $postarr) == true){
								$selposts .=  'selected="selected"';
							}
						}
							$selposts .=  '>'.$post->ID.' - '.$post->post_title.'</option>';
							$i = $i+1;
				}
					?>
<div id="includediv" class="postbox <?php echo postbox_classes('includediv', 'post'); ?>">
<h3><?php _e('Include Posts','stnl') ?></h3>
<div class="inside">
<p><select multiple name="stn_posts[]" style="height:200px; width:auto;" ><?php echo $selposts;?></select> <small><?php _e('(hold ctrl to select multiple posts)', 'stnl');?></small></p>
<p><label><?php _e('Custom Post Order:', 'stnl');?> <input type="text" size="20" name="stn_postorder" value="<?php echo $e_news->st_postorder; ?>" /></label><br /><small><?php _e('(Place the ID numbers of the posts you selected above seperated by a space in the order you want them to display in your newsletter)', 'stnl');?></small></p>
</div>
</div>
<?php } ?>

<div id="mimediv" class="postbox <?php echo postbox_classes('mimediv', 'post'); ?>">
<h3><?php _e('MIME Type','stnl') ?></h3>
<div class="inside">
<p><select name="stn_mime">
<option value="multi" <?php if ($e_news->st_mime == 'multi'){echo 'selected="selected"';} ?>><?php _e("Multi-Part (Text/HTML)", 'stnl');?></option>
<option value="html" <?php if ($e_news->st_mime == 'html'){echo 'selected="selected"';} ?>><?php echo _e("HTML Only", 'stnl');?></option>
<option value="text" <?php if ($e_news->st_text == 'text'){echo 'selected="selected"';} ?>><?php echo _e("Text Only", 'stnl');?></option>
</select></p>
</div>
</div>

 <?php 
$stnl_config = get_option('stnl_config');
if($stnl_config['showheader']=='show'){ ?>
<div id="headerdiv" class="postbox <?php echo postbox_classes('headerdiv', 'post'); ?>">
<h3><?php _e('Header Image','stnl') ?></h3>
<div class="inside">
<p<?php _e('>Upload the Header background image which needs to be pre-sized to a minimum of 660px wide by 140px tall. (accepts JPG, GIF or PNG images)','stnl');?></p>
<p><input type="file" name="headimg" width="450px" /></p>
<?php if($e_news->st_header){ ?>
<div style="background-image:url(<?php echo $e_news->st_header; ?>); width:660px; height:140px;"></div>
<?php } ?>
</div>
</div>
<?php } ?>

<?php
$boxes = $stnl_config['boxes'];
for($i = 1; $i <= $boxes; $i++){
	$boxvalue = array( '', $e_news->st_box1, $e_news->st_box2, $e_news->st_box3, $e_news->st_box4, $e_news->st_box5, $e_news->st_box6, $e_news->st_box7, $e_news->st_box8, $e_news->st_box9, $e_news->st_box10);
	$curbox = $boxvalue[$i];
	if($i > 1){
		$prevbox = 'stn_box'.($i-1);
	}else{
		$prevbox = 'content';
	}
	if($boxes > 0){
		$lastbox = 'stn_box'.$boxes;
	}else{
		$lastbox = 'content';
	}?>
<div id="box<?php echo $i; ?>div" class="postbox <?php echo postbox_classes('box'.$i.'div', 'post'); ?>">
<h3><?php _e('Sidebar ', 'stnl'); echo $i; ?></h3>
<div class="inside">
<p><small><?php _e('Sorry HTML only here for now.  Multiple Rich Text editors just don\'t like to work together', 'stnl');?></small></p>
 <textarea name="stn_box<?php echo $i;?>" rows="20" cols="40" style="width:98%;height:200px;"><?php echo $curbox; ?></textarea>
</div>
</div>
<?php } ?>

<?php if($stnl_config['metabox'] == true){
	?>
<div id="metaboxdiv" class="postbox <?php echo postbox_classes('metaboxdiv', 'post'); ?>">
<h3><?php _e('Metabox ', 'stnl'); ?></h3>
<div class="inside">
<p><small><?php _e('Sorry HTML only here for now.  Multiple Rich Text editors just don\'t like to work together', 'stnl');?></small></p>
 <textarea name="stn_metabox" rows="20" cols="40" style="width:98%;height:200px;"><?php echo  $e_news->st_metabox1; ?></textarea>
</div>
</div>
<?php } ?>

<?php } ?>




			<input type="hidden" name="newsletter_submit" value="true" />

			<?php if ($edit != ''){ ?>

			<input name="stn_id" type="hidden" value="<?php echo $e_news->st_id; ?>" />

			<?php } ?>
	</div>

</div>
 </form>
<?php }

?>