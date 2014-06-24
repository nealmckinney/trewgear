<div id="comments">  
    <?php if ( post_password_required() ) : ?>  
        <p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'twentyten' ); ?></p>  
        </div>  
        <?php return; ?>  
    <?php endif; ?>  
  
    <?php if ( comments_open() ) : ?>  
        <div id="fbcomments"><div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:comments href="<?php the_permalink(); ?>" width="580"></fb:comments></div>  
    <?php endif; ?>  
  
    <?php if ( ! comments_open() ) : ?>  
        <p><?php _e( 'Comments are closed.', 'twentyten' ); ?></p>  
    <?php endif; ?>  
</div>