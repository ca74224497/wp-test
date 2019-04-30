<?php   

/* For Single page Results
*/

?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="post-img">
            <?php if(has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('fino-page-thumbnail', array('class' => 'img-responsive')); ?>
            <?php endif; ?>
        </div>

        <div class="blog-detail-content">
          <h3><?php the_title(); ?></h3>
          <ul class="post-detail-meta">
              <li>
                 <i class="fa fa-calendar"></i><span><?php echo get_the_date(); ?></span>  
              </li>
              <li><?php echo esc_html__( 'By', 'fino' ); ?> <i>:</i>
                  <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                     <i class="fa fa-user"></i> <?php the_author(); ?>
                  </a>
              </li>
              <li>
                  <span>
                    <i class="fa fa-comment"></i><?php comments_number( __('0 Comment', 'fino'), __('1 Comment', 'fino'), __('% Comments', 'fino') ); ?>
                  </span>
              </li>
              <li>
                  <a>
                    <i class="fa fa-folder-open"></i><?php the_category(',&nbsp; &nbsp;'); ?>
                  </a>
              </li>

              <?php if (has_tag()) : ?>
              <li>
                <i class="fa fa-tag"></i>
                <?php echo esc_html__(' ', 'fino' ); ?><?php the_tags('&nbsp;'); ?>
              </li>     
              <?php endif; ?>
          </ul>
          <div class="para">
              <?php the_content(); ?>
                <?php
                    wp_link_pages( array(
                   'before' => '<div class="page-links">' . esc_html__('Pages: ', 'fino' ),
                    'after'  => '</div>',
                     ) );
                ?>
          </div>   

        
       </div> 

  <?php 
              if ( comments_open() || get_comments_number() ) :
                comments_template();
              endif; 
          ?> 	   
    </div>