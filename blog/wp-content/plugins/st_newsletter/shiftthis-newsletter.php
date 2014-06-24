<?php
/*
Plugin Name: ShiftThis | Newsletter PHP5
Plugin URI: http://www.shiftthis.net/wordpress-newsletter-plugin/
Description: Customized Newsletter Creation & Mailing List Management
Author: ShiftThis.net
Version: 2.3.1
Author URI: http://www.shiftthis.net
License: Please view the included 'License-Agreement.txt' file for full details, but basically, you can customize this plugin any way you please, but you are not allowed to sell or redistribute.  This plugin requires a valid license for every domain it is used on.  
Copyright: ©2008 ShiftThis.net
*/

$stnl_version = '2.3.1';
$stnl_php = '5';
load_plugin_textdomain('stnl', 'wp-content/plugins/st_newsletter/locale/');

include('stnl_license.php');

$stnl_config = get_option('stnl_config');
$stnl_textconfig = get_option('stnl_textconfig');

//if(FE9A4A180731629B83439659FF02237A8($stnl_config['license']) == true){
$include = array( 
					'stnl_mysqloptions.php',
					'stnl_mysqltextoptions.php',
					'stnl_mysqltestoptions.php',
					'stnl_mysqlsubscribe.php',
					'stnl_upgrade.php',
					'stnl_mysql.php',
					'stnl_sharedfunctions.php',
					'stnl_subscriber_functions.php',
					'stnl_swift_functions.php',
					'stnl_editors.php',
					'stnl_subscribe.php',
					'stnl_show_iframe.php',
					'stnl_sending.php',
					'stnl_news.php',
					'stnl_create.php',
					'stnl_manage.php',
					'stnl_categories.php',
					'stnl_preview.php',
					'stnl_subscribers.php',
					'stnl_options.php',
					'stnl_swifttest.php',
					'stnl_subtext.php',
					'stnl_inout.php',
					'stnl_archive.php',
					'stnl_widget.php',
					'stnl_themes.php'
				);
foreach( $include as $inc ){
	include_once( $inc );
}
$responder = ABSPATH."/wp-content/plugins/st_newsletter/stnl-responder.php";
if (file_exists($responder)):
	include('stnl-responder.php');
	include('stnl-responder-cron.php');
endif;
//}

// Determine plugin filename
	$stn_scriptname = basename(__FILE__);

/*-------------------------------------------------------------
 Name:      newsletter_add_pages
 Purpose:   Add pages to admin menus
-------------------------------------------------------------*/
function stnl_add_pages() {
	//Add TopLevel Page to Admin Menu - defaults to Create Page.
	add_menu_page('Newsletter', 'Newsletter', 10, __FILE__, 'FB92767D6B64C7902A91039608913F0B6'); 
}
function stnl_add_subpages(){	
	global $stnl_config;
	//Add SubMenu Create Page
	$showme = $stnl_config['minlevel'];
	if($showme == '') $showme = 10;
	add_menu_page(__('Newsletter', 'stnl'), __('Newsletter', 'stnl'), $showme, __FILE__, 'stnl_news');
	add_submenu_page(__FILE__, __('Create', 'stnl'), __('Create', 'stnl'), $showme, 'create-newsletter', 'stnl_create'); 
	//Add SubMenu Manage Page
	add_submenu_page(__FILE__, __('Manage', 'stnl'), __('Manage', 'stnl'), $showme, 'manage-newsletter', 'stnl_manage'); 
	//Add SubMenu Categories Page
	add_submenu_page(__FILE__, __('Categories', 'stnl'), __('Categories', 'stnl'), $showme, 'cat-newsletter', 'stnl_categories'); 
	//Add SubMenu Preview/Send Page
	add_submenu_page(__FILE__, __('Preview/Send', 'stnl'), __('Preview/Send', 'stnl'), $showme, 'preview-newsletter', 'stnl_preview'); 
	//Add SubMenu AutoResponder Page
	if (function_exists('st_responder_manage_page'))
		add_submenu_page(__FILE__, __('Auto-Responder', 'stnl'), __('Auto-Responder', 'stnl'), $showme, 'responder-newsletter', 'st_responder_manage_page'); 
	//Add SubMenu Options Page
	add_submenu_page(__FILE__, __('Options', 'stnl'), __('Options', 'stnl'), 10, 'options-newsletter', 'stnl_options');
	//Add SubMenu Subscription Text Page
	add_submenu_page(__FILE__, __('Subscription Text', 'stnl'), __('Subscription Text', 'stnl'), 10, 'subtext-newsletter', 'stnl_subtext'); 
	//Add SubMenu Subscribers Page
	add_submenu_page(__FILE__, __('Subscribers', 'stnl'), __('Subscribers', 'stnl'), $showme, 'subscribers-newsletter', 'stnl_subscribers');
	//Add SubMenu Import/Export Page
	add_submenu_page(__FILE__, __('Import/Export', 'stnl'), __('Import/Export', 'stnl'), 10, 'inout-newsletter', 'stnl_inout'); 
	//Add SubMenu Options Page
	add_submenu_page(__FILE__, __('Swift Test', 'stnl'), __('Swift Test', 'stnl'), 10, 'swift-newsletter', 'stnl_swifttest');  
	//Add SubMenu Help Page
	add_submenu_page(__FILE__, __('Help', 'stnl'), __('Help', 'stnl'), 10, 'help-newsletter', 'stnl_help');
	//Add SubMenu Logs Page
	//add_submenu_page(__FILE__, __('Logs', 'stnl'), __('Logs', 'stnl'), $showme, 'logs-newsletter', 'stnl_logs'); 	
}
//if(FE9A4A180731629B83439659FF02237A8($stnl_config['license']) == true){
	add_action('admin_menu', 'stnl_add_subpages');
	add_action('admin_head', 'stnl_subfieldsjs');
	add_action('admin_head', 'stnl_checkbox_js');
	add_action('admin_head', 'stnl_swiftlog_js');
	if($_GET['page'] == "create-newsletter" || $_GET['page'] == "manage-newsletter" || $_GET['st_responder'] || $_GET['edit_st_responder'] ){
		if($stnl_config['editor'] != "quicktags"){
			
			if( $wp_version >= 2.5 ){
				wp_enqueue_script('post');
			   if ( user_can_richedit() )
					wp_enqueue_script('editor');
				 if ( user_can_richedit() )
					wp_enqueue_script( 'wp_tiny_mce' );
				
				
				wp_enqueue_script('media-upload');
				wp_enqueue_script('thickbox');
				
			}else{
				add_action('admin_head', 'stnl_editor_js');
			}
		}
	}
//}else{
	//add_action('admin_menu', 'stnl_add_pages');
//}

function stnl_help(){
	?>
    <div class="wrap">
    	<h2> <?php _e("Documentation &amp; Support", 'stnl');?></h2>
    	<p> <a href="http://shiftthis.net/docs/wordpress_newsletter_plugin_v2"><?php _e("Online Documentation", 'stnl');?></a></p>
    </div>
    <?php
}
//Copyright: ©2008 Marcus Vanstone - ShiftThis.net
?>