<?php get_header() ?>

<div id="outer">
	<?php require_once("../navigation.php"); ?>
	<div id="blogHeader"></div>
	
	<div id="container">
		<div id="mainContent">
			
			

			<h2 class="page-title"><?php _e( 'Category Archives:', 'sandbox' ) ?> <span><?php single_cat_title() ?></span></h2>
			<?php $categorydesc = category_description(); if ( !empty($categorydesc) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>


			

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
				<div class="header1"><a href="<?php the_permalink() ?>" title="<?php printf( __( 'Permalink to %s', 'sandbox' ), the_title_attribute('echo=0') ) ?>" rel="bookmark"><?php the_title() ?></a></div>
				
				<div class="entry-content">
<?php the_excerpt(__( 'Read More <span class="meta-nav">&raquo;</span>', 'sandbox' )) ?>

				</div>
				
			</div><!-- .post -->

<?php endwhile; ?>

			<div id="nav-below" class="navigation" style="width:200px;">
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&laquo;</span> Older posts', 'sandbox' ) ) ?></div>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&raquo;</span>', 'sandbox' ) ) ?></div>
			</div>

		</div><!-- #content -->
		<?php get_sidebar(); ?>
	</div><!-- #container -->

<?php get_footer() ?>
</div><!-- outer -->
</body>
</html>