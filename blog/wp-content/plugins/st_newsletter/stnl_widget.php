<?php
/*
Adds Suscribe Panel to Widgets
*/

// Put functions into one big function we'll call at the plugins_loaded
// action. This ensures that all required plugin functions are defined.
function widget_stnl_init() {

	// Check for the required plugin functions. This will prevent fatal
	// errors occurring when you deactivate the dynamic-sidebar plugin.
	if ( !function_exists('register_sidebar_widget') )
		return;

	// This is the function that outputs our little Google search form.
	function widget_stnl($args) {
		
		// $args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys. Default tags: li and h2.
		extract($args);

		// Each widget can store its own options. We keep strings here.
		$options = get_option('widget_stnl');
		$title = $options['title'];
		$buttontext = $options['buttontext'];

		// These lines generate our output. Widgets can be very complex
		// but as you can see here, they can also be very, very simple.
		echo $before_widget . $before_title . $title . $after_title;
		$url_parts = parse_url(get_bloginfo('home'));
		echo '<div style="margin-top:5px;">'.stnl_subscribe($buttontext).'</div>';
		echo $after_widget;
	}

	// This is the function that outputs the form to let the users edit
	// the widget's title. It's an optional feature that users cry for.
	function widget_stnl_control() {

		// Get our options and see if we're handling a form submission.
		$options = get_option('widget_stnl');
		if ( !is_array($options) )
			$options = array('title'=>__('Subscribe to Newsletter', 'widgets'), 'buttontext'=>__('Subscribe', 'widgets'));
		if ( $_POST['stnl-submit'] ) {

			// Remember to sanitize and format use input appropriately.
			$options['title'] = strip_tags(stripslashes($_POST['stnl-title']));
			$options['buttontext'] = strip_tags(stripslashes($_POST['stnl-buttontext']));
			update_option('widget_stnl', $options);
		}

		// Be sure you format your options to be valid HTML attributes.
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$buttontext = htmlspecialchars($options['buttontext'], ENT_QUOTES);
		
		// Here is our little form segment. Notice that we don't need a
		// complete form. This will be embedded into the existing form.
		echo '<p style="text-align:right;"><label for="stnl-title">' . __('Title:', 'stnl') . ' <input style="width: 200px;" id="stnl-title" name="stnl-title" type="text" value="'.$title.'" /></label></p>';
		echo '<p style="text-align:right;"><label for="stnl-buttontext">' . __('Button Text:', 'stnl') . ' <input style="width: 200px;" id="stnl-buttontext" name="stnl-buttontext" type="text" value="'.$buttontext.'" /></label></p>';
		echo '<input type="hidden" id="stnl-submit" name="stnl-submit" value="1" />';
	}
	
	// This registers our widget so it appears with the other available
	// widgets and can be dragged and dropped into any active sidebars.
	register_sidebar_widget(array('ShiftThis Subscribe', 'widgets'), 'widget_stnl');

	// This registers our optional widget control form. Because of this
	// our widget will have a button that reveals a 300x100 pixel form.
	register_widget_control(array('ShiftThis Subscribe', 'widgets'), 'widget_stnl_control', 300, 100);
}

// Run our code later in case this loads prior to any required plugins.
add_action('widgets_init', 'widget_stnl_init');

?>