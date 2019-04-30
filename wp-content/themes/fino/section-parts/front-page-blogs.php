 <?php 
// To display Blog Post section on front page
?>


<?php  
    $fino_blog_title =  get_theme_mod('fino_blog_title');  
    $fino_blog_section = get_theme_mod('fino_blog_section_hideshow','show');
    if ($fino_blog_section =='show') { 
?>

<!-- Blog Section -->
<section class="blog sp-80">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="all-title">
                    <div class="sec-title">
                        <?php if($fino_blog_title !="") { ?>
                            <h3>
                                <span><?php echo esc_html(get_theme_mod('fino_blog_title')); ?></span>
                            </h3>
                        <?php } ?>
                    </div>
                        <p>
                           <?php echo esc_html(get_theme_mod('fino_blog_subtitle')); ?> 
                        </p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php 
               $fino_latest_blog_posts = new WP_Query( array( 'posts_per_page' => 3 ) );
               if ( $fino_latest_blog_posts->have_posts() ) : 
                    while ( $fino_latest_blog_posts->have_posts() ) : $fino_latest_blog_posts->the_post(); 
            ?>
            <article class="col-md-4 blog-wrap">
                <div class="blog-item verti">
                    <?php
                    if(has_post_thumbnail()){ ?>
                    <div class="blog-img">
                        <a href="<?php the_permalink() ?>">
							<?php the_post_thumbnail('fino-photo-homel', array('class' => 'img-responsive')); ?>						
                        </a>
                    </div>
                    <?php }  ?>

                    <div class="blog-content">
                        <h4>
                           <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                        </h4>
                        <ul class="post-meta">
                            <li>
                                <i class="fa fa-calendar"></i>
                                <?php echo get_the_date(); ?>
                            </li>
                            <li> <?php echo esc_html__( 'By', 'fino' ); ?> : 
                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author();?></a>
                            </li>
                        </ul>
                            <?php the_excerpt() ?>
                            <a href="<?php the_permalink(); ?>" class="btn-blog-h">
								<?php echo esc_html__('Read More', 'fino'); ?> 
								<i class="fa fa-arrow-right"></i>
							</a>
                    </div>
                
                </div>
            </article>
            <?php 
                    endwhile; 
                endif;
            ?>
        </div>
    </div>
</section>

 <!-- End Blog Section -->
    <?php } ?>