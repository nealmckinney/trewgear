<div id="sidebar">
	<ul>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
		<?php endif; ?>
	</ul>
</div>

<script>
	$('#cat').wrap('<div id="catSelect" class="select-skin categories" />');
	var catSelect = new SelectSkin($("#catSelect"));
</script>