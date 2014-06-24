

<?php get_header() ?>
<div id="outer">
	<?php require_once("../navigation.php"); ?>
	<div id="blogHeader">
		<div class="photoCredit-wrap">
			<p class="photoCredit about" style="top:410px;">Photo By Lance Koudele</p>
		</div>
	</div>
	<div id="container">
	<div id="mainContent">

	<?php while ( have_posts() ) : the_post() ?>
			<div class="standardPost">
				<div class="entry-meta-sm">
					<span class="entry-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php unset($previousday); printf( __( '%1$s &#8211; %2$s', 'sandbox' ), the_date( '', '', '', false ), get_the_time() ) ?></abbr></span>
					<span class="meta-sep"></span>
					<span>by <?php the_author(); ?></span>
					<span class="meta-sep"></span>
					<?php _e('Category', 'pyrmont_v2'); ?>:&nbsp;<span class="category"><?php the_category(', ') ?></span>
					<span class="meta-sep"></span>
					<span class="comments-link"><?php comments_popup_link( __( '0 Comments', 'sandbox' ), __( '1 Comments', 'sandbox' ), __( 'Comments (%)', 'sandbox' ) ) ?></span>
				</div>
				<div class="header1"><a href="<?php the_permalink() ?>" title="<?php printf( __('Permalink to %s', 'sandbox'), the_title_attribute('echo=0') ) ?>" rel="bookmark"><?php the_title() ?></a></div>
				<div class="entry-content">
					<?php the_content( __( 'Read More <span class="meta-nav">&raquo;</span>', 'sandbox' ) ) ?>
					<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'sandbox' ) . '&after=</div>') ?>
				</div>
			</div><!-- .standardPost -->
			<?php comments_template() ?>
	<?php endwhile; ?>

		<div id="nav-below" class="navigation">
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&laquo;</span> Older posts', 'sandbox' ) ) ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&raquo;</span>', 'sandbox' ) ) ?></div>
		</div>

		
	</div><!-- #mainContent -->
	<?php get_sidebar(); ?>
	</div><!-- #container -->
	<?php get_footer(); ?>
</div><!-- outer -->

	<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
	try {
	var pageTracker = _gat._getTracker("UA-8829428-1");
	pageTracker._trackPageview("blog");
	} catch(err) {}</script>

</body>
</html>

