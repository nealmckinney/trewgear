<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
<head profile="http://gmpg.org/xfn/11">
	<title><?php wp_title( '-', true, 'right' ); echo wp_specialchars( get_bloginfo('name'), 1 ) ?></title>
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	<meta name="viewport" content="width=device-width" id="viewport-meta">
	<link rel="stylesheet" type="text/css" href="../resources/css/styles_2013.css" />
	<link rel="stylesheet" type="text/css" href="../resources/css/styles-responsive.css" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url') ?>" />
<?php wp_head() // For plugins ?>
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php printf( __( '%s latest posts', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
	
	<script type="text/javascript" src="../resources/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="../resources/js/jquery-more.js"></script>
	<script type="text/javascript" src="../resources/js/modernizr-2.5.3.min.js"></script>
	<script type="text/javascript" src="../resources/js/core/events/EventDispatcher.js"></script>
	<script type="text/javascript" src="../resources/js/ui/SelectSkin.js"></script>
	
	<!-- <script type="text/javascript" src="../resources/js/json2.js"></script>
	<script src="//api.emeraldcode.com/js/cartgui.js"></script>
	<script src="//api.emeraldcode.com/js/api.js"></script>
	<script src="//api.emeraldcode.com/js/plugins/ejs.js"></script>
	<script type="text/javascript" src="../resources/js/main.js"></script> -->
	
</head>
<body>

