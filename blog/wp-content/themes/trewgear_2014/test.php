<?php get_header() ?>


	
	
 	<div id="outer">
	
		<div id="navLayer" style="margin:0 auto; position:absolute; z-index:2">
			<div id="flashNav">
			<h1>Alternative content</h1>
			<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
			</div>
		</div><!-- navLayer -->
	
	<div id="htmlLayer" style="padding-top:93px; z-index:1">
	<div class="content overflow-hidden" style="left:117px; top:40px">	
		<div id="content2">
			
			
			
<?php $i = 1; ?>
<?php while ( have_posts() ) : the_post() ?>
	<?php if ($i == 1) { 
		$flashTitle = get_the_title();
	?>
		
		
		
		
		<div class="entry-meta">
			
			<span class="entry-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php unset($previousday); printf( __( '%1$s &#8211; %2$s', 'sandbox' ), the_date( '', '', '', false ), get_the_time() ) ?></abbr></span>
			
			<span class="meta-sep"><img src="/trewgear/resources/images/blog/verticalDivider.gif"/></span>
			
			<span class="comments-link"><?php comments_popup_link( __( '0 Comments', 'sandbox' ), __( '1 Comments', 'sandbox' ), __( 'Comments (%)', 'sandbox' ) ) ?></span>
		</div>
		<div id="divider1"></div>
		
		
		<script type="text/javascript">

		var flashvars = {
			title: "<?php echo $flashTitle; ?>"
		};
		var params = {
		  wmode: "transparent",
		  scale: "noscale"
		};
		var attributes = {};
		
		
		swfobject.embedSWF("/trewgear/resources/swf/blogTitle.swf", "flashTitle", "925", "150", "9.0.0", "expressInstall.swf", flashvars, params, attributes);
		</script>

		<div id="titleLayer">
			<div id="flashTitle">
			<h1>Alternative content</h1>
			<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
			</div>
		</div><!-- titleLayer -->

		
		<div id="most_recent_content">
<?php the_content( __( 'Read More <span>&raquo;</span>', 'custom' ) ) ?>

		<?php wp_link_pages('before=<div>' . __( 'Pages:', 'custom' ) . '&after=</div>') ?>
		</div>
		<div id="divider1"></div>
	
		<div id="blogSubContent" style="display:inline; list-style:none">
			
		<li><div id="schedule" style="width:332px; float:left; margin:40px 20px 0px 0px">
			<?php get_sidebar() ?>
		</div></li>
	<li><div id="archivePosts" style="float:left">	
		
	<?php } else { ?>
		
		

			<div class="standardPost" style="margin:40px 0px 30px 0px; width:563px;">
				
				
				<div class="entry-meta-sm">

					<span class="entry-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php unset($previousday); printf( __( '%1$s &#8211; %2$s', 'sandbox' ), the_date( '', '', '', false ), get_the_time() ) ?></abbr></span>

					<span class="meta-sep"><img src="/trewgear/resources/images/blog/verticalDividerShort.gif"/></span>

					<span class="comments-link"><?php comments_popup_link( __( '0 Comments', 'sandbox' ), __( '1 Comments', 'sandbox' ), __( 'Comments (%)', 'sandbox' ) ) ?></span>
				</div>
				<div id="divider2"></div>
				
				
				<div id="header1"><a href="<?php the_permalink() ?>" title="<?php printf( __('Permalink to %s', 'sandbox'), the_title_attribute('echo=0') ) ?>" rel="bookmark"><?php the_title() ?></a></div>
				
				<div class="entry-content2">
<?php the_content( __( 'Read More <span class="meta-nav">&raquo;</span>', 'sandbox' ) ) ?>

				<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'sandbox' ) . '&after=</div>') ?>
				</div>
				
			</div><!-- .post -->

<?php comments_template() ?>

<?php } ?> <!-- end else -->
<?php $i++; ?>
<?php endwhile; ?>
		</div><!-- archivesList -->
		</li>
	
		</div><!-- blogSubContent -->
			

		</div><!-- #content -->
		
			
		
	</div><!-- #container -->
	
	</div><!-- #htmlLayer -->
	
	
	<?php get_footer(); ?>
	</div><!-- outer -->
</body>
</html>
	
