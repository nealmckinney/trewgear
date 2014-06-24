<?php
/*
AutoResponder Add-On for ShiftThis Newsletter Plugin
Version: 0.1
Copyright: ©2006 Marcus Vanstone - ShiftThis.net
This Plugin requires the ShiftThis Newsletter Plugin and will not work on it's own.
*/
global $wpdb;
#---------------------------------------------------
# Install MySQL Tables
#---------------------------------------------------
if ( !st_responder_mysql_table_exists($wpdb, $table_prefix."st_responder") ) st_responder_mysql_install($wpdb, $table_prefix);

#---------------------------------------------------
# Only proceed with the plugin if MySQL Tables are setup properly
#---------------------------------------------------
if ( st_responder_mysql_table_exists($wpdb, $table_prefix."st_responder") ) {

	if ( isset($_POST['st_responder_submit']) AND $_GET['new'] == "true") 		
		add_action('init', 'st_responder_insert_input'); //New st_responder
		
	if ( isset($_POST['st_responder_submit']) AND $_GET['edit'] == "true") 		
		add_action('init', 'st_responder_update_input'); //Edit st_responder

	if ( isset($_GET['delete_st_responder']) ) 
		add_action('init', 'st_responder_request_delete'); //Delete st_responder
	

	// Load Options
	//$st_responder_config = get_option('st_responder_config');
	
	// Determine plugin filename
	$sts_scriptname = basename(__FILE__);

}
 
/* DATABASE INSTALLER */
function st_responder_mysql_install ( $wpdb, $table_prefix ) {

	require_once(ABSPATH . 'wp-admin/upgrade-functions.php');

	$table_name = $table_prefix . "st_responder";
	
	$sql = "CREATE TABLE ".$table_name." (
	st_id mediumint(8) unsigned NOT NULL auto_increment,
	st_cat mediumint(8) NOT NULL default '0',
	st_subject varchar(120) NOT NULL default '',
	st_message longtext NOT NULL default '',
	st_interval mediumint(8) NOT NULL default '0',
	PRIMARY KEY (st_id)
	);";
	
	dbDelta($sql);
	
	$table_name2 = $table_prefix . "st_responder_track";
	
	$sql2 = "CREATE TABLE ".$table_name." (
	st_id mediumint(8) unsigned NOT NULL auto_increment,
	st_userid mediumint(8) NOT NULL default '0',
	st_catid mediumint(8) NOT NULL default '0',
	st_msgid mediumint(8) NOT NULL default '0',
	st_sent varchar(120) NOT NULL default '',
	PRIMARY KEY (st_id)
	);";

	dbDelta($sql2);

	if ( !st_responder_mysql_table_exists( $wpdb, $table_name ) ) {

		add_action('admin_menu', 'st_responder_mysql_warning');

	}

}

function st_responder_mysql_table_exists( $wpdb, $table_name ) {
 global $wpdb; 
	if ( !$wpdb->get_results("SHOW TABLES LIKE '%$table_name%'") ) return FALSE;
	else return TRUE;

}

function st_responder_mysql_warning() {

	_e('<div class="updated"><h3>WARNING! The MySQL tables were not created! You cannot store Auto-Responder emails yet.</h3></div>','stnl');

}


/* ADMIN PANEL OPTIONS */

/*-------------------------------------------------------------
 Name:      st_responder_insert_input

 Purpose:   Prepare input form on advanced edit post page
 Receive:   -None-
-------------------------------------------------------------*/
function st_responder_insert_input() {

	global $wpdb, $table_prefix, $userdata, $user_level, $st_newsletter_config;

	$j = st_q();
		$n_cat = $_POST['stn_cat'];
		$n_subject = $_POST['stn_subject'];
		$n_message = $_POST['content'];
		$n_interval = $_POST['stn_interval'];
			
			/* Query */
			$postquery = "INSERT INTO 
			".$table_prefix."st_responder
			(st_cat, st_subject, st_message, st_interval)
			VALUES
			('$n_cat', '$n_subject', '$n_message', '$n_interval')
			";
		
			$wpdb->query($postquery); 

}

/*-------------------------------------------------------------
 Name:      st_responder_update_input

 Purpose:   Prepare input form on advanced edit post page
 Receive:   -None-
-------------------------------------------------------------*/
function st_responder_update_input() {

	global $wpdb,  $table_prefix, $userdata, $user_level, $st_newsletter_config;
	$j = st_q();
	if ( $user_level >= $st_newsletter_config['st_newsletter_minlevel'] ) {

		$n_id = $_POST['stn_id'];
		$n_cat = $_POST['stn_cat'];
		$n_subject = $_POST['stn_subject'];
		$n_message = $_POST['content'];
		$n_interval = $_POST['stn_interval'];
		

			/* Query */
			$postquery = "UPDATE
			".$table_prefix."st_responder SET st_cat='$n_cat', st_subject='$n_subject', st_message='$n_message', st_interval='$n_interval' WHERE st_id=$n_id";
		
			$wpdb->query($postquery);

		}
	
	$ref = $_SERVER['HTTP_REFERER'];
	$location = trim($ref, $j."edit_st_responder=".$n_id);
	header('Location: '.$location);

}

/*-------------------------------------------------------------
 Name:      st_responder_request_delete

 Purpose:   Remove st_responder requested in the URI
-------------------------------------------------------------*/
function st_responder_request_delete () {

	global $table_prefix, $wpdb, $st_newsletter_config;

	$st_responder_id = $_GET['delete_st_responder'];

	if ( $st_responder_id > 0 ) {

			st_responder_delete_st_responderid($st_responder_id);

	}
	$return = get_settings('siteurl').'/wp-admin/edit.php?page=st_newsletter'.$st_newsletter_config['newsletter_slashfix'].'shiftthis-responder.php';
	header('Location: '.$return);

}

/*-------------------------------------------------------------
 Name:      st_responder_delete_st_responderid

 Purpose:   Remove st_responder from database
 Receive:   st_responder id
 Return:    boolean
-------------------------------------------------------------*/
function st_responder_delete_st_responderid ($st_responder_id) {

	
	if ( $st_responder_id > 0 ) {

		global $wpdb, $table_prefix;

		// Delete Record from meta and data table
		$SQL = "DELETE FROM ".$table_prefix."st_responder WHERE st_id = '$st_responder_id'";
		if ( !$wpdb->query($SQL) ) {

			die("Failure to delete data from table");

		}
		
		return TRUE;

 	}

}

/*-------------------------------------------------------------
 Name:      st_responder_add_pages
 Purpose:   Add pages to admin menus
-------------------------------------------------------------
*/

function st_responder_manage_page() {

	global $table_prefix, $wpdb, $st_newsletter_config;

if ($_GET['st_responder'] == 'new'){
		echo '<div class="wrap">';
		echo '<h2>'.__('New Auto-Responder Message', 'stnl').'</h2>';
		echo '<p><a href="'.get_settings('siteurl').'/wp-admin/admin.php?page=responder-newsletter" class="edit" style="width:200px;float:left;">'.__('Manage Auto-Responders', 'stnl').'</a> <a href="'.get_settings('siteurl').'/wp-admin/admin.php?page=responder-newsletter&amp;manage=categories" class="edit" style="width:200px;float:left;">'.__('Manage Categories', 'stnl').'</a> </p>
	<br style="clear:both;" />';
		 st_responder_edit();
		echo '</div>';
	}
elseif (isset($_GET['edit_st_responder']) == true){
		$id = $_GET['edit_st_responder'];
		echo '<div class="wrap">';
		echo '<h2>'.__('Edit Auto-Responder Message','stnl').'</h2>';
		echo '<p><a href="'.get_settings('siteurl').'/wp-admin/admin.php?page=responder-newsletter" class="edit" style="width:200px;float:left;">'.__('Manage Auto-Responders', 'stnl').'</a> <a href="'.get_settings('siteurl').'/wp-admin/admin.php?page=responder-newsletter&amp;st_responder=new" class="edit" style="width:200px;float:left;">'.__('Create New Message', 'stnl').'</a> <a href="'.get_settings('siteurl').'/wp-admin/admin.php?page=responder-newsletter&amp;manage=categories" class="edit" style="width:200px;float:left;">'.__('Manage Categories','stnl').'</a> </p>
	<br style="clear:both;" />';
		
		 st_responder_edit($id);
		echo '</div>';
	}
elseif ($_GET['manage'] == 'categories'){
	st_categories_manage_page('ar');
	}
else {	
?>
 
<div class="wrap">
  	<h2><?php _e('Auto-Responder','stnl');?></h2>
	<p><a href="<?php echo get_settings('siteurl');?>/wp-admin/admin.php?page=responder-newsletter&amp;st_responder=new" class="edit" style="width:200px;float:left;"><?php _e('Create New Message','stnl');?></a> <a href="<?php echo get_settings('siteurl');?>/wp-admin/admin.php?page=responder-newsletter&amp;manage=categories" class="edit" style="width:200px;float:left;"><?php  _e('Manage Categories','stnl');?></a></p>
	<br style="clear:both;" />
	<?php if($_GET['run'] == 'cron'){
	
		wp_cron_send_responders();
	
	}?>
	
		<?php
		/* Fetch MailingList */
			$SQL = "SELECT * FROM ".$table_prefix."st_responder ORDER BY st_cat ASC, st_interval ASC";
		$st_responder = $wpdb->get_results($SQL);

		if ( count($st_responder) == 0 ) { ?>
		<p><?php _e('No Auto-Responder Messages Available','stnl');?></p>
		<?php } else{ ?>
			 
			<?php
		$i = 1;
		$max = count($st_responder);
			foreach ( $st_responder as $resp ) : 
				
				$prevcat = $cat;
				$cat = $resp->st_cat;
				if($cat != $prevcat){
					if ($i > 1){echo'</ol>';}
					if ($i <= $max){
					echo '<h3 style="font-weight:bold;font-size:1em;padding:0;margin-bottom:0;" >'.st_catname($cat).'</h3>';
					echo '<ol>';
					}
				}
				
				
				echo '<li style="border:solid 1px #ccc; width:375px; padding:5px;"><span style="display:block; width:200px; float:left;">'.$resp->st_subject.'</span> <span style="display:block; width: 75px; float:left;">['.$resp->st_interval.' days]</span> <span style="display:block; width: 100px; float:left;"><a class="edit" style="display:inline;" href="'.get_settings('siteurl').$_SERVER['REQUEST_URI'].'&amp;edit_st_responder='.$resp->st_id.'"><small>edit</small></a>';
				?>
				 <a class="edit" style="display:inline;" href="<?php echo get_settings('siteurl').$_SERVER['REQUEST_URI'].'&amp;delete_st_responder='.$resp->st_id;?>" onclick="return confirm('You are about to delete the message \'<?php echo $resp->st_subject?>\'\n  \'OK\' to delete, \'Cancel\' to stop.')"><small>delete</small></a>
				 <?php echo '</span><br style="clear:both;" /></li>';
				
				if($i == $max){echo '</ol>';}
				$i = $i+1;
				
			?>
		
			<?php
			endforeach; 
			}
		?>
	</div>
		
	<?php
	}
	
	
}
function st_responder_edit($edit=''){
global $table_prefix, $wpdb, $st_newsletter_config;
$sl = $st_newsletter_config['newsletter_slashfix'];
if ( $edit != '' ) {
	
	$e_sql = "SELECT * FROM " . $table_prefix . "st_responder WHERE st_id=". $edit;
	$e_resp = $wpdb->get_row($e_sql);
	
}	
	if (isset($_POST['Submit'])) {
echo "<div class='updated'><p><strong>".__('Responder Message Saved','stnl')."</strong></p></div>";
}
?><div id="post-body">
	<fieldset class="options">	
	<?php if ($edit != ''){ ?>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>&amp;edit=true">
	<?php } else { ?>
	  	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']?>&amp;new=true"> 
	<?php } ?>
	    	<input type="hidden" name="st_responder_submit" value="true" />
			<?php if ($edit != ''){ ?>
			<input name="stn_id" type="hidden" value="<?php echo $e_resp->st_id; ?>" />
			<?php } ?>
	    	<table width="100%" cellspacing="2" cellpadding="5" class="editform">
		      	 <tr>
			        <th width="20%" valign="top" scope="row"><?php _e('Category:','stnl');?></th>
			        <td><select name="stn_cat">
					<?php echo st_catoptions($e_resp->st_cat, 'ar'); ?>
					</select>
					</td>
		      	</tr>
				 <tr>
			        <th width="20%" valign="top" scope="row"><?php _e('Interval (days):','stnl');?></th>
			        <td><input name="stn_interval" type="text" size="2" value="<?php echo $e_resp->st_interval; ?>" /></td>
		      	</tr>
				 <tr>
			        <th width="20%" valign="top" scope="row"><?php _e('Subject:','stnl');?></th>
			        <td><input name="stn_subject" type="text" size="50" value="<?php echo $e_resp->st_subject; ?>" /></td>
		      	</tr>
				<tr>
			        <th width="20%" valign="top" scope="row"><?php _e('Message:','stnl');?></th>
			        <td><div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea">
<?php the_editor($e_resp->st_message, 'content'); ?>
</div><br />
<p><strong>Replacement Keys:</strong> <br />
<small>{email} = subscribers email address<br />
{code} = subscribers unique code<br />
{first} = subscribers first name<br />
{last} = subscribers last name<br />
{first_fix} = subscribers first name forced Title case<br />
{last_fix} = subscribers last name forced Title case</small></p></td>
		      	</tr>	
	    	</table>

	    	<p class="submit">
	      		<input type="submit" name="Submit" value="<?php _e('Save Responder Message','stnl');?> &raquo;" />
	    	</p>
	  	</form>
    	
  	</fieldset> 
    </div>
<?php 
}

function st_trackcheck($userid, $msgid){
	global $wpdb, $table_prefix;
	
	$checktrack = "SELECT * FROM ".$table_prefix."st_responder_track WHERE st_userid = '$userid' AND st_msgid = '$msgid'";
	$track = $wpdb->get_row($checktrack);
	$c = count($track);
	if($c != ''){
		return true;
	}else{
		return false;
	}
}

function st_categories_manage_page($type='nl'){
	global $table_prefix, $wpdb, $st_newsletter_config;
	$sl = $st_newsletter_config['newsletter_slashfix'];
	/* Fetch Categories */
			$SQL = "SELECT * FROM ".$table_prefix."st_categories WHERE st_type='$type' ORDER BY st_id";
			$category = $wpdb->get_results($SQL);
			
	if($type == 'nl'){
		$stpage="shiftthis-newsletter.php";
	}elseif($type == 'ar'){
		$stpage="shiftthis-responder.php";
	}
		
	
	?>
	<div class="wrap">
		<h2>Manage Categories</h2>
        <?php echo '<p><a href="'.get_settings('siteurl').'/wp-admin/admin.php?page=responder-newsletter" class="edit" style="width:200px;float:left;">'.__('Manage Auto-Responders', 'stnl').'</a> <a href="'.get_settings('siteurl').'/wp-admin/admin.php?page=responder-newsletter&amp;st_responder=new" class="edit" style="width:200px;float:left;">'.__('Create New Message', 'stnl').'</a></p>
	<br style="clear:both;" />';?>
		<table id="the-list-x" width="100%" cellpadding="3" cellspacing="3"> 
			  <tr> 
			    <th scope="col"><?php _e('ID','stnl');?></th> 
			    <th scope="col"><?php _e('Name','stnl');?></th>
				<th scope="col"></th> 
				<th scope="col"></th> 
			  </tr>
			  <?php
			foreach ( $category as $cat ) : 
				$default = $cat->st_default;
					if ($default == 0){
						$default=''; 
					}else{
						$default = "<small>(default)</small>";
					}
				$class = ('alternate' != $class) ? 'alternate' : ''; ?>
			  	<tr id='news-<?php echo $cat->st_id; ?>' class='<?php echo $class; ?>'> 
				    <th scope="row"><?php echo $cat->st_id; ?></th> 
					<td><?php echo $cat->st_name; ?> <?php echo $default; ?></td>
					<td><a href="<?php echo get_settings('siteurl');?>/wp-admin/admin.php?page=responder-newsletter&amp;manage=categories&amp;edit_cat=<?php echo $cat->st_id?>#edit" class="edit"><?php _e('Edit');?></a>
					<a href="<?php echo get_settings('siteurl');?>/wp-admin/admin.php?page=responder-newsletter&amp;manage=categories&amp;delete_cat=<?php echo $cat->st_id?>" class="delete" onclick="return confirm('You are about to delete this category \'<?php echo $cat->st_name?>\'\n Any Newsletters within this category will be moved to the default category\n  \'OK\' to delete, \'Cancel\' to stop.')"><?php _e('Delete','stnl');?></a></td>
			  	</tr>
			<?php
			endforeach; ?>
			</table> 
			<a href="<?php echo get_settings('siteurl');?>/wp-admin/admin.php?page=responder-newsletter&amp;manage=categories&amp;new_cat=<?php echo $cat->st_id?>" class="edit"><?php _e('Create New Category','stnl');?></a>
	
	</div>
	<?php if ( isset($_GET['edit_cat']) ) { ?>
	<div class="wrap">
	<a name="edit"></a><h2><?php _e('Edit Category');?></h2>
	<?php echo newsletter_cat_editing($_GET['edit_cat'], $type);?>
	</div>
<?php 	}
	if ( isset($_GET['new_cat']) ) { ?>
	<div class="wrap">
	<a name="edit"></a><h2><?php _e('New Category');?></h2>
	<?php echo newsletter_cat_editing('',$type);?>
	</div>
<?php }	
}
//Copyright: ©2006 Marcus Vanstone - ShiftThis.net
?>