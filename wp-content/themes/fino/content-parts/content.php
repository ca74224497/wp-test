<?php
/**
 * @package Fino
 */
?>
    <div class="blog-detail">

        <div class="post-img">
            <?php if(has_post_thumbnail()) : ?>
               <?php the_post_thumbnail('fino-page-thumbnail', array('class' => 'img-responsive')); ?>
            <?php endif; ?>
        </div>
        <div class="blog-detail-content">
            <h3><a class="h3" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <ul class="post-detail-meta">
                    <li>
                        <i class="fa fa-calendar"></i> <span><?php echo get_the_date(); ?></span> 
                    </li>
                    <li><?php echo esc_html__( 'By', 'fino' ); ?><i>:</i>
                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                        <i class="fa fa-user"></i><?php the_author(); ?>
                        </a>
                    </li>
                    <li>
                        <span>
                            <i class="fa fa-comment"></i><?php comments_number( __('0 Comment', 'fino'), 
                            __('1 Comment', 'fino'), __('% Comments', 'fino') ); ?> 
                         </span>
                    </li>
                    <li>
                        <a>
                           <i class="fa fa-folder-open"></i><?php the_category(',&nbsp; &nbsp;'); ?>
                        </a>
                    </li>
                </ul>
            <div class="para">
            <?php the_excerpt(); ?>
            </div>
        </div>
    </div>
                