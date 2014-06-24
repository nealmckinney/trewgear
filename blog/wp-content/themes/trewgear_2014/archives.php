<?php
/*
Template Name: Archives Page
*/
?>
<?php get_header() ?>

<div id="outer">

	<div id="navLayer">
		<div id="flashNav">
		<h1>Alternative content</h1>
		<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
		</div><!-- flashNav -->
	</div><!-- navLayer -->
	
	<div id="container">
		<div id="content">

<?php the_post() ?>

			<div id="post-<?php the_ID() ?>" class="<?php sandbox_post_class() ?>">
				<h2 class="entry-title"><?php the_title() ?></h2>
				<div class="archives">
<?php the_content() ?>

					<ul id="archives-page" class="xoxo">
						<li id="category-archives">
							<div class="header1"><?php _e( 'Archives by Category', 'sandbox' ) ?></div>
							<ul>
								<?php wp_list_categories('optioncount=1&title_li=&show_count=1') ?> 
							</ul>
						</li>
						<li id="monthly-archives">
							<div class="header1"><?php _e( 'Archives by Month', 'sandbox' ) ?></div>
							<ul>
								<?php wp_get_archives('type=monthly&show_post_count=1') ?>
							</ul>
						</li>
					</ul>
<?php edit_post_link( __( 'Edit', 'sandbox' ), '<span class="edit-link">', '</span>' ) ?>

				</div>
			</div><!-- .post -->

<?php if ( get_post_custom_values('comments') ) comments_template() // Add a key/value of "comments" to enable comments on pages! ?>

		</div><!-- #content -->
	</div><!-- #container -->

<?php get_footer() ?>
</div><!-- outer -->
</body>
</html>