<?php get_header() ?>

	
 	<div id="outer">
	
		<?php 
		require_once("../navigation.php");
		?>
	<div id="blogHeader"></div>
	<div id="container">	
		<div id="mainContent">

<?php the_post() ?>

			

			
				
				<div class="entry-meta-sm">
					<span class="entry-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php unset($previousday); printf( __( '%1$s &#8211; %2$s', 'sandbox' ), the_date( '', '', '', false ), get_the_time() ) ?></abbr></span>
					<span class="meta-sep"></span>
					<span>by <?php the_author(); ?></span>
					<span class="meta-sep"></span>
					<?php _e('Category', 'pyrmont_v2'); ?>:&nbsp;<span class="category"><?php the_category(', ') ?></span>
					<span class="meta-sep"></span>
					<span class="comments-link"><?php comments_popup_link( __( '0 Comments', 'sandbox' ), __( '1 Comments', 'sandbox' ), __( 'Comments (%)', 'sandbox' ) ) ?></span>
				</div>
				
				<div id="titleLayer">
					<h2><?php echo get_the_title(); ?></h2>
				</div><!-- titleLayer -->
				<div id="most_recent_content">
				
<?php the_content() ?>
				
			</div><!-- most_recent_content -->

			

<?php comments_template() ?>

		</div><!-- #content -->
		<?php get_sidebar(); ?>
	</div><!-- #container -->
	
	<?php get_footer(); ?>
	</div><!-- #outer -->
	
	</body>
	</html>


