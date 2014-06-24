<?php 
global $wpdb, $table_prefix;
#---------------------------------------------------
# Install MySQL Tables
#---------------------------------------------------
if ( !newsletter_mysql_table_exists($wpdb, $table_prefix."st_newsletter") ) newsletter_mysql_install($wpdb, $table_prefix);
#---------------------------------------------------
# Only proceed with the plugin if MySQL Tables are setup properly
#---------------------------------------------------
if ( newsletter_mysql_table_exists($wpdb, $table_prefix."st_newsletter") ) {
	stnl_check_config(); //Initialize Configuration Variables
	stnl_check_textconfig();
	stnl_check_testconfig();
	//add_action('admin_menu', 'newsletter_add_pages'); //Add page menu links
	//add_action('admin_head', 'newsletter_javascript'); //Add JS to admin head
	if ( isset($_POST['newsletter_submit']) AND $_GET['new'] == "true") 		
		add_action('init', 'newsletter_insert_input'); //New newsletter
		
	if ( isset($_POST['newsletter_submit']) AND $_GET['edit'] == "true") 		
		add_action('init', 'newsletter_update_input'); //Edit newsletter

	if ( isset($_GET['delete_newsletter']) ) 
		add_action('init', 'newsletter_request_delete'); //Delete newsletter
	
	if ( isset($_POST['category_submit']) AND $_GET['new'] == "true") 		
		add_action('init', 'category_insert_input'); //New category
		
	if ( isset($_POST['category_submit']) AND $_GET['edit'] == "true") 		
		add_action('init', 'category_update_input'); //Edit category

	if ( isset($_GET['delete_cat']) ) 
		add_action('init', 'category_request_delete'); //Delete category
		
	if ( isset($_POST['newsletter_submit_options']) ) 
		add_action('init', 'newsletter_options_submit'); //Update Options 
	
	if ( isset($_POST['newsletter_submit_textoptions']) ) 
		add_action('init', 'newsletter_textoptions_submit'); //Update Options
	
	if ( isset($_POST['newsletter_submit_testoptions']) ) 
		add_action('init', 'newsletter_testoptions_submit'); //Update Options 

	if ( isset($_POST['newsletter_uninstall']) ) 
		add_action('init', 'newsletter_plugin_uninstall'); //Uninstall

	// Load Options
	$stnl_config = get_option('stnl_config');
}

/* DATABASE INSTALLER */
function newsletter_mysql_install ( $wpdb, $table_prefix ) {

	require_once(ABSPATH . 'wp-admin/upgrade-functions.php');

	$table_name = $table_prefix . "st_newsletter";
	$sql = "CREATE TABLE ".$table_name." (
		st_id mediumint(8) unsigned NOT NULL auto_increment,
		st_title varchar(120) NOT NULL default '',
		st_date varchar(120) NOT NULL default '',
		st_content longtext NOT NULL,
		st_header varchar(255) NOT NULL default '',
		st_posts longtext NOT NULL,
		st_postorder varchar(255) NOT NULL default '',
		st_box1 longtext NOT NULL,
		st_box2 longtext NOT NULL,
		st_box3 longtext NOT NULL,
		st_box4 longtext NOT NULL,
		st_box5 longtext NOT NULL,
		st_box6 longtext NOT NULL,
		st_box7 longtext NOT NULL,
		st_box8 longtext NOT NULL,
		st_box9 longtext NOT NULL,
		st_box10 longtext NOT NULL,
		st_metabox1 longtext NOT NULL,
		st_status tinyint(4) NOT NULL default '0',
		st_cat varchar(120) NOT NULL default '0',
		st_mime varchar(120) NOT NULL default '0',
		st_template varchar(120) NOT NULL default '',
		PRIMARY KEY (st_id)
		);";

	dbDelta($sql);

	if ( !newsletter_mysql_table_exists( $wpdb, $table_name ) ) {

		add_action('admin_menu', 'newsletter_mysql_warning');

	}

}

function newsletter_mysql_table_exists( $wpdb, $table_name ) {

	if ( !$wpdb->get_results("SHOW TABLES LIKE '%$table_name%'") ) return FALSE;
	else return TRUE;

}

function newsletter_mysql_warning() {

	echo '<div class="updated"><h3>'.__('WARNING! The MySQL database tables were not created! You cannot store  any newsletters yet.', 'stnl').'</h3></div>';

}

if ( !st_categories_mysql_table_exists($wpdb, $table_prefix."st_categories") ) st_categories_mysql_install($wpdb, $table_prefix);

function st_categories_mysql_install ( $wpdb, $table_prefix ) {
global $wpdb, $table_prefix;
	require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
	$table_name = $table_prefix . "st_categories";

	$csql = "CREATE TABLE ".$table_name." (
		st_id mediumint(8) unsigned NOT NULL auto_increment,
		st_name varchar(120) NOT NULL default '',
		st_default mediumint(8) NOT NULL default '0',
		st_type varchar(120) NOT NULL default 'nl',
		PRIMARY KEY (st_id)
		);";

	dbDelta($csql);
	if ( !st_categories_mysql_table_exists( $wpdb, $table_name ) ) {

		add_action('admin_menu', 'st_categories_mysql_warning');

	}
		$postquery = "INSERT INTO ".$table_prefix."st_categories (st_name, st_default) VALUES ('General', '1')";
		$wpdb->query($postquery);
}
function st_categories_mysql_table_exists( $wpdb, $table_name ) {
 global $wpdb; 
	if ( !$wpdb->get_results("SHOW TABLES LIKE '%$table_name%'") ) return FALSE;
	else return TRUE;
}

function st_categories_mysql_warning() {
	echo '<div class="updated"><h3>'.__('WARNING! The MySQL databases were not created! You cannot store emails yet.', 'stnl').'</h3></div>';
}

/*-------------------------------------------------------------
 Name:      newsletter_insert_input
 Purpose:   Prepare input form on advanced edit post page
-------------------------------------------------------------*/
function newsletter_insert_input() {
	global $wpdb, $table_prefix, $userdata, $stnl_config;
$showme = $stnl_config['minlevel'];
	if($showme == ''){
		$showme = 10;
	}
	if ( current_user_can('level_'.$showme) ) {

		$n_title = $_POST['stn_title'];

		$n_month = $_POST['stn_month'];
		
		if ($_POST['stn_day'] == "1" || $_POST['stn_day'] == "2" || $_POST['stn_day'] == "3" || $_POST['stn_day'] == "4" || $_POST['stn_day'] == "5" || $_POST['stn_day'] == "6" || $_POST['stn_day'] == "7" || $_POST['stn_day'] == "8" || $_POST['stn_day'] == "9"){
		$narr = array ('0','01','02','03','04','05','06','07','08','09');
		$nstr = ltrim($_POST['stn_day'], "0");
		$n_day = $narr[$nstr];
		}else {
		$n_day = $_POST['stn_day'];
		}
		$n_year = $_POST['stn_year'];
		
		$n_date = $n_year.$n_month.$n_day;
		if ($_POST['stn_posts'] != ''){
			$n_posts = implode(",",$_POST['stn_posts']);
		}
		$n_postorder = $_POST['stn_postorder'];
		//FIX PHOTO LOCATIONS FROM RELATIVE TO ABSOLUTE
		$n_con = $_POST['content'];
		$n_content = rel2ab($n_con);
		
		$dir = ABSPATH.'/'.get_option('upload_path').'/';
		if ($_FILES['headimg']['type'] == "image/jpeg" || $_FILES['headimg']['type'] == "image/jpg" || $_FILES['headimg']['type'] == "image/gif" || $_FILES['headimg']['type'] == "image/png"){
			copy ($_FILES['headimg']['tmp_name'], $dir.$_FILES['headimg']['name']);
 			$n_header = get_option('home').'/'.get_option('upload_path').'/'.$_FILES['headimg']['name'];
		}
		
		$n_b1 = $_POST['stn_box1'];
		$n_box1 = rel2ab($n_b1);
		$n_b2 = $_POST['stn_box2'];
		$n_box2 = rel2ab($n_b2);
		$n_b3 = $_POST['stn_box3'];
		$n_box3 = rel2ab($n_b3);
		$n_b4 = $_POST['stn_box4'];
		$n_box4 = rel2ab($n_b4);
		$n_b5 = $_POST['stn_box5'];
		$n_box5 = rel2ab($n_b5);
		$n_b6 = $_POST['stn_box6'];
		$n_box6 = rel2ab($n_b6);
		$n_b7 = $_POST['stn_box7'];
		$n_box7 = rel2ab($n_b7);
		$n_b8 = $_POST['stn_box8'];
		$n_box8 = rel2ab($n_b8);
		$n_b9 = $_POST['stn_box9'];
		$n_box9 = rel2ab($n_b9);
		$n_b10 = $_POST['stn_box10'];
		$n_box10 = rel2ab($n_b10);
		$n_meta = $_POST['stn_metabox'];
		$n_metabox = rel2ab($n_meta); 
		
		$n_status = $_POST['stn_status'];
		$n_cat = $_POST['stn_category'];
		$n_mime = $_POST['stn_mime'];
		$n_template = $_POST['stn_template'];
	
			/* Query */
			$postquery = "INSERT INTO 
			".$table_prefix."st_newsletter
			(st_title, st_date, st_posts, st_postorder, st_content, st_header, st_box1, st_box2, st_box3, st_box4, st_box5, st_box6, st_box7, st_box8, st_box9, st_box10, st_metabox1, st_status, st_cat, st_mime, st_template)
			VALUES
			('$n_title', '$n_date', '$n_posts', '$n_postorder', '$n_content', '$n_header', '$n_box1', '$n_box2', '$n_box3', '$n_box4', '$n_box5', '$n_box6', '$n_box7', '$n_box8', '$n_box9', '$n_box10', '$n_metabox', '$n_status', '$n_cat', '$n_mime', '$n_template')
			";
			$wpdb->query($postquery);
		}

	header('Location: '.$_SERVER['HTTP_REFERER']);
}

/*-------------------------------------------------------------
 Name:      newsletter_update_input
 Purpose:   Prepare input form on advanced edit post page
 Receive:   -None-
-------------------------------------------------------------*/

function newsletter_update_input() {
	global $wpdb, $table_prefix, $userdata, $stnl_config;
$showme = $stnl_config['minlevel'];
	if($showme == ''){
		$showme = 10;
	}

	if ( current_user_can('level_'.$showme) ) {
		$n_id = $_POST['stn_id'];
		$n_title = $_POST['stn_title'];
		$n_month = $_POST['stn_month'];

		if ($_POST['stn_day'] == "1" || $_POST['stn_day'] == "2" || $_POST['stn_day'] == "3" || $_POST['stn_day'] == "4" || $_POST['stn_day'] == "5" || $_POST['stn_day'] == "6" || $_POST['stn_day'] == "7" || $_POST['stn_day'] == "8" || $_POST['stn_day'] == "9"){
		$narr = array ('0','01','02','03','04','05','06','07','08','09');
		$nstr = ltrim($_POST['stn_day'], "0");
		$n_day = $narr[$nstr];
		}else {
		$n_day = $_POST['stn_day'];
		}
		$n_year = $_POST['stn_year'];
		
		$n_date = $n_year.$n_month.$n_day;
		if ($_POST['stn_posts'] != ''){
			$n_posts = implode(",",$_POST['stn_posts']);
		}
		$n_postorder = $_POST['stn_postorder'];

		//FIX PHOTO LOCATIONS FROM RELATIVE TO ABSOLUTE
		$n_con = $_POST['content'];
		$n_content = rel2ab($n_con);
		
		$dir = ABSPATH.'/'.get_option('upload_path').'/';
		if ($_FILES['headimg']['type'] == "image/jpeg" || $_FILES['headimg']['type'] == "image/jpg" || $_FILES['headimg']['type'] == "image/gif" || $_FILES['headimg']['type'] == "image/png"){
			copy ($_FILES['headimg']['tmp_name'], $dir.$_FILES['headimg']['name']);
 			$n_header = get_option('home').'/'.get_option('upload_path').'/'.$_FILES['headimg']['name'];
			$updateheader = "st_header='$n_header', ";
		}
		

		$n_b1 = $_POST['stn_box1'];
		$n_box1 = rel2ab($n_b1);
		$n_b2 = $_POST['stn_box2'];
		$n_box2 = rel2ab($n_b2);
		$n_b3 = $_POST['stn_box3'];
		$n_box3 = rel2ab($n_b3);
		$n_b4 = $_POST['stn_box4'];
		$n_box4 = rel2ab($n_b4);
		$n_b5 = $_POST['stn_box5'];
		$n_box5 = rel2ab($n_b5);
		$n_b6 = $_POST['stn_box6'];
		$n_box6 = rel2ab($n_b6);
		$n_b7 = $_POST['stn_box7'];
		$n_box7 = rel2ab($n_b7);
		$n_b8 = $_POST['stn_box8'];
		$n_box8 = rel2ab($n_b8);
		$n_b9 = $_POST['stn_box9'];
		$n_box9 = rel2ab($n_b9);
		$n_b10 = $_POST['stn_box10'];
		$n_box10 = rel2ab($n_b10);
		$n_meta = $_POST['stn_metabox'];
		$n_metabox = rel2ab($n_meta);
		
		$n_status = $_POST['stn_status'];
		$n_cat = $_POST['stn_category'];
		$n_mime = $_POST['stn_mime'];
		$n_template = $_POST['stn_template'];
	
			/* Query */
			$postquery = "UPDATE
			".$table_prefix."st_newsletter SET st_title='$n_title', st_date='$n_date', st_posts='$n_posts', st_postorder='$n_postorder', st_content='$n_content', $updateheader st_box1='$n_box1', st_box2='$n_box2', st_box3='$n_box3', st_box4='$n_box4', st_box5='$n_box5', st_box6='$n_box6', st_box7='$n_box7', st_box8='$n_box8', st_box9='$n_box9', st_box10='$n_box10', st_metabox1='$n_metabox', st_status='$n_status', st_cat='$n_cat', st_mime='$n_mime', st_template='$n_template' WHERE st_id='$n_id'";		
			$wpdb->query($postquery);

		}
	
	$ref = $_SERVER['HTTP_REFERER'];
	$location = trim($ref, "&edit_newsletter=".$n_id);
	//header('Location: '.$location);
}

/*-------------------------------------------------------------
 Name:      newsletter_request_delete
 Purpose:   Remove newsletter requested in the URI
-------------------------------------------------------------*/
function newsletter_request_delete () {
	global $table_prefix, $wpdb, $st_newsletter_config;
	$newsletter_id = $_GET['delete_newsletter'];
	if ( $newsletter_id > 0 ) {
			newsletter_delete_newsletterid($newsletter_id);
	}
}
/*-------------------------------------------------------------
 Name:      newsletter_delete_newsletterid
 Purpose:   Remove newsletter from database
-------------------------------------------------------------*/
function newsletter_delete_newsletterid ($newsletter_id) {
	if ( $newsletter_id > 0 ) {
		global $wpdb, $table_prefix;
		// Delete Record from meta and data table
		$SQL = "DELETE FROM ".$table_prefix."st_newsletter WHERE st_id = '$newsletter_id'";
		if ( !$wpdb->query($SQL) ) {
			die("Failure to delete data from table");
		}
		return TRUE;
 	}
}

/*-------------------------------------------------------------
 Name:      category_insert_input
 Purpose:   Prepare input form on advanced edit post page
-------------------------------------------------------------*/
function category_insert_input() {
	global $wpdb, $table_prefix, $userdata, $stnl_config;
$showme = $stnl_config['minlevel'];
	if($showme == ''){
		$showme = 10;
	}
	if ( current_user_can('level_'.$showme) ) {
		$n_name = $_POST['stn_name'];
		$n_default = $_POST['stn_default'];
		$n_type = $_POST['stn_type'];
			
			if ($n_default == 1){
				$off = "UPDATE ".$table_prefix."st_categories SET st_default='0' WHERE st_default='1' AND st_type='$n_type'";
				$wpdb->query($off);
			}

			/* Query */
			$postquery = "INSERT INTO 
			".$table_prefix."st_categories
			(st_name, st_default, st_type)
			VALUES
			('$n_name', '$n_default', '$n_type')
			";
			$wpdb->query($postquery);
		}
	header('Location: '.$_SERVER['HTTP_REFERER']);
}
/*-------------------------------------------------------------
 Name:      category_update_input
 Purpose:   Prepare input form on advanced edit post page
 Receive:   -None-
-------------------------------------------------------------*/
function category_update_input() {
	global $wpdb, $table_prefix, $userdata, $stnl_config;
$showme = $stnl_config['minlevel'];
	if($showme == ''){
		$showme = 10;
	}
	if ( current_user_can('level_'.$showme) ) {
		$n_id = $_POST['stn_id'];
		$n_name = $_POST['stn_name'];
		$n_default = $_POST['stn_default'];
		$n_type = $_POST['stn_type'];
		
			if ($n_default == 1){
				$off = "UPDATE ".$table_prefix."st_categories SET st_default='0' WHERE st_default='1' AND st_type='$n_type'";
				$wpdb->query($off);
			}

			/* Query */
			$postquery = "UPDATE
			".$table_prefix."st_categories SET st_name='$n_name', st_default='$n_default' WHERE st_id='$n_id' AND st_type='$n_type'";

			$wpdb->query($postquery);

		}

	$ref = $_SERVER['HTTP_REFERER'];
	$location = trim($ref, "&edit_cat=".$n_id);
	//header('Location: '.$location);
}

/*-------------------------------------------------------------
 Name:      category_request_delete
 Purpose:   Remove newsletter requested in the URI
-------------------------------------------------------------*/
function category_request_delete () {
	global $table_prefix, $wpdb, $stnl_config;
	$category_id = $_GET['delete_cat'];
	if ( $category_id > 0 ) {
			category_delete_categoryid($category_id);
	}
}
/*-------------------------------------------------------------
 Name:      category_delete_categoryid
 Purpose:   Remove newsletter from database
-------------------------------------------------------------*/
function category_delete_categoryid ($category_id) {
	if ( $category_id > 0 ) {
		global $wpdb, $table_prefix;
		// Delete Record from meta and data table
		$SQL = "DELETE FROM ".$table_prefix."st_categories WHERE st_id = '$category_id'";
		if ( !$wpdb->query($SQL) ) {
			die("Failure to delete data from table");
		}
		return TRUE;
 	}
}

#---------------------------------------------------
# Install MySQL Tables
#---------------------------------------------------
if ( !st_mailinglist_mysql_table_exists($wpdb, $table_prefix."st_mailinglist") ) st_mailinglist_mysql_install($wpdb, $table_prefix);
#---------------------------------------------------
# Only proceed with the plugin if MySQL Tables are setup properly
#---------------------------------------------------
if ( st_mailinglist_mysql_table_exists($wpdb, $table_prefix."st_mailinglist") ) {
	if ( isset($_POST['st_mailinglist_submit']) AND $_GET['new'] == "true") 		
		add_action('init', 'st_mailinglist_insert_input'); //New st_mailinglist
	
	if ( isset($_POST['st_mailinglist_submit']) AND $_GET['edit'] == "true") 		
		add_action('init', 'st_mailinglist_update_input'); //Edit st_mailinglist

	if ( isset($_GET['delete_st_email']) ) 
		add_action('init', 'st_mailinglist_request_delete'); //Delete st_mailinglist
	

	if ( isset($_POST['st_mailinglist_submit_options']) ) 
		add_action('init', 'st_mailinglist_options_submit'); //Update Options 

	if ( isset($_POST['st_mailinglist_uninstall']) ) 
		add_action('init', 'st_mailinglist_plugin_uninstall'); //Uninstall
}
/* DATABASE INSTALLER */
function st_mailinglist_mysql_install ( $wpdb, $table_prefix ) {
	require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
	$table_name = $table_prefix . "st_mailinglist";
	$sql = "CREATE TABLE ".$table_name." (
		st_id mediumint(8) unsigned NOT NULL auto_increment,
		st_email varchar(120) NOT NULL default '',
		st_status varchar(120) NOT NULL default '',
		st_code varchar(120) NOT NULL default '',
		st_extras longtext NOT NULL,
		st_subip varchar(120) NOT NULL default '',
		st_confip varchar(120) NOT NULL default '',
		st_subdate varchar(120) NOT NULL default '',
		st_confdate varchar(120) NOT NULL default '',
		st_cat varchar(120) NOT NULL default '',
		st_responder varchar(120) NOT NULL default '',
		PRIMARY KEY (st_id)
		);";

	dbDelta($sql);

	if ( !st_mailinglist_mysql_table_exists( $wpdb, $table_name ) ) {
		add_action('admin_menu', 'st_mailinglist_mysql_warning');
	}
}

function st_mailinglist_mysql_table_exists( $wpdb, $table_name ) {
 global $wpdb; 
	if ( !$wpdb->get_results("SHOW TABLES LIKE '%$table_name%'") ) return FALSE;
	else return TRUE;
}
function st_mailinglist_mysql_warning() {
	echo '<div class="updated"><h3>'.__('WARNING! The MySQL databases were not created! You cannot store emails yet.', 'stnl').'</h3></div>';
}

function stnl_add_subscriber(){
	global $wpdb, $table_prefix;

	$email = $_POST['stnl_email'];
	$status = 1;
	$code = genunique(20);
	//$extras = '';
	$cat = $_POST['stnl_cats'];
	foreach($cat as $c){
		$category .= $c.'[|]';
	}
	$ncat = rtrim($category, '[|]');
	$responder = '';
	$ip = 'Added by Admin';
	$date = date('g:ia d/m/Y');

	foreach($_POST as $key => $val){
		if($key != 'stnl_email' && $key != 'stnl_cats' && $key != 'st_mailinglist_submit' && $key != 'Submit'){
			$extras .= $key.'[:]'.$val.'[*]';
		}
	}
	//echo $extras;
	$extras = rtrim($extras, '[*]');
	$addnew = "INSERT INTO ".$table_prefix."st_mailinglist (st_email, st_status, st_code, st_extras, st_confip, st_confdate, st_cat, st_responder) VALUES ('$email', '$status', '$code', '$extras', '$ip', '$date', '$ncat', '$responder')";

			$wpdb->query($addnew);
		//header('Location: '.stnl_uri('subscribers-newsletter'));
}

/*-------------------------------------------------------------
 Name:      stnl_update_subscriber
 Purpose:   Update st_mailinglist from database
 Receive:   st_mailinglist id
 Return:    boolean
-------------------------------------------------------------*/
function stnl_update_subscriber(){
	global $wpdb, $table_prefix;
	
	$id = $_POST['stnl_id'];
	$email = $_POST['stnl_email'];
	$status = 1;
	//$extras = '';
	$cat = $_POST['stnl_cats'];
	$responder = '';
	foreach($cat as $c){
		$category .= $c.'[|]';
	}
	$ncat = rtrim($category, '[|]');
	//echo $ncat;
	foreach($_POST as $key => $val){
	//echo $key.' => '.$val.' <br />';
		if($key != 'stnl_id' && $key != 'stnl_email' && $key != 'stnl_cats' && $key != 'st_mailinglist_submit' && $key != 'Submit'){
			$extras .= $key.'[:]'.$val.'[*]';
		}
	}
//	echo $extras;
	$extras = rtrim($extras, '[*]');
	
	$update =  "UPDATE ".$table_prefix."st_mailinglist SET st_email='$email', st_status='$status', st_extras='$extras', st_cat='$ncat', st_responder='$responder' WHERE st_id='$id'";
	
			$wpdb->query($update);
		//header('Location: '.stnl_uri('subscribers-newsletter'));
}
/*-------------------------------------------------------------
 Name:      st_mailinglist_request_delete
 Purpose:   Remove st_mailinglist requested in the URI
-------------------------------------------------------------*/
function st_mailinglist_request_delete () {
	global $table_prefix, $wpdb, $st_newsletter_config;
	$st_mailinglist_id = $_GET['delete_st_email'];
	if ( $st_mailinglist_id > 0 ) {
			st_mailinglist_delete_st_mailinglistid($st_mailinglist_id);
	}
	//$return = get_option('home').'/wp-admin/edit.php?page=st_newsletter'.$st_newsletter_config['newsletter_slashfix'].'shiftthis-newsletter.php&manage=subscribers';
	header('Location: '.stnl_uri('subscribers-newsletter'));
}

/*-------------------------------------------------------------
 Name:      st_mailinglist_delete_st_mailinglistid
 Purpose:   Remove st_mailinglist from database
 Receive:   st_mailinglist id
 Return:    boolean
-------------------------------------------------------------*/
function st_mailinglist_delete_st_mailinglistid ($st_mailinglist_id) {
	if ( $st_mailinglist_id > 0 ) {
		global $wpdb, $table_prefix;
		// Delete Record from meta and data table
		$SQL = "DELETE FROM ".$table_prefix."st_mailinglist WHERE st_id = '$st_mailinglist_id'";
		if ( !$wpdb->query($SQL) ) {
			die(__("Failure to delete data from table", 'stnl'));
		}
		return TRUE;
 	}
}
function stnl_publishnewsletter($nid){
	global $wpdb, $table_prefix;
	$publish = "UPDATE ".$table_prefix."st_newsletter SET st_status='2' WHERE st_id='$nid'";
	$wpdb->query($publish);
}
?>