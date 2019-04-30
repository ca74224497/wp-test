<?php
/**
 * Template part - Features Section of FrontPage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package fino
 */

    $fino_slider_section     = get_theme_mod( 'fino_slider_section_hideshow','hide');
    
    $fino_slider_no        = 3;
    $fino_slider_pages      = array();
    for( $i = 1; $i <= $fino_slider_no; $i++ ) {
        $fino_slider_pages[]    =  get_theme_mod( "fino_slider_page_$i", 1 );
        $fino_slider_btntxt[]    =  get_theme_mod( "fino_slider_btntxt_$i", '' );
        $fino_slider_btnurl[]    =  get_theme_mod( "fino_slider_btnurl_$i", '' );
        

    }

    $fino_slider_args  = array(
        'post_type' => 'page',
        'post__in' => array_map( 'absint', $fino_slider_pages ),
        'posts_per_page' => absint($fino_slider_no),
        'orderby' => 'post__in'
    ); 
    
    $fino_slider_query = new wp_Query( $fino_slider_args );

    if ($fino_slider_section =='show' && $fino_slider_query->have_posts() ) { ?>
    <section class="top-slider">
        <div class="fino-slider main-slider owl-carousel owl-theme" data-items="1" data-loop="true" data-pause-on-hover="true" data-autoplay="true" data-dots="true" data-nav="true"
        data-r-x-small="1" data-r-x-small-nav="false" data-r-x-small-dots="true" data-r-x-medium="1" data-r-x-medium-nav="false"
        data-r-x-medium-dots="true" data-r-small="1" data-r-small-nav="false" data-r-small-dots="true" data-r-medium="1"
        data-r-medium-nav="true" data-r-medium-dots="true" data-r-large="1" data-r-large-nav="true" data-r-large-dots="true">
            <?php
               $count = 0;
               while($fino_slider_query->have_posts()) :
               $fino_slider_query->the_post();
            ?>
            <div class="item">
				<?php if(has_post_thumbnail()) : ?>
				   <?php the_post_thumbnail('full', array('class' => 'img-responsive')); ?>
				<?php endif; ?>
                <div class="slide-overlay">
                    <div class="slide-table">
                        <div class="slide-table-cell">
                            <div class="container">
                                <div class="slide-content">
                                    <h2><?php the_title(); ?></h2>
                                    <?php if (has_excerpt()) { ?>
                                    <h3><?php the_excerpt(); ?></h3> 
                                    <?php } ?>
                                    <p><?php the_content(); ?></p>
                                    <?php
                                     if (!empty($fino_slider_btntxt[$count])) {
                                    ?>
                                    <a href="<?php echo esc_url($fino_slider_btnurl[$count]); ?>" class="btn btn-fino"><?php echo esc_html($fino_slider_btntxt[$count]); ?></a>
                                <?php } ?>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
             <?php
                $count = $count + 1;
                endwhile;
                wp_reset_postdata();
            ?>  
        </div>
    </section>
    <?php } ?>