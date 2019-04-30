<?php
/**
 * Template part - Service Section of FrontPage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fino
 */
    $fino_services_section = get_theme_mod( 'fino_services_section_hideshow','hide');
    $fino_services_title   =  get_theme_mod('fino_services_title');  
   
    $fino_services_no        = 6;
    $fino_services_pages      = array();
    $fino_services_icons     = array();
    
    for( $i = 1; $i <= $fino_services_no; $i++ ) {
        $fino_services_pages[]    =  get_theme_mod( "fino_service_page_$i", 1 );
        $fino_services_icons[]    = get_theme_mod( "fino_page_service_icon_$i", '' );
    }

    $fino_services_args  = array(
        'post_type' => 'page',
        'post__in' => array_map( 'absint', $fino_services_pages ),
        'posts_per_page' => absint($fino_services_no),
        'orderby' => 'post__in'
    ); 
    
    $fino_services_query = new wp_Query( $fino_services_args );
     
     if( $fino_services_section == "show") :
    
?>

    <section class="grow-business sp-80">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="all-title">
                        <div class="sec-title">
                            <?php if($fino_services_title != "")
                    {?>
                            <h3>
                                <span><?php echo esc_html(get_theme_mod('fino_services_title')); ?></span>
                            </h3>
                            <?php 
                    }?> 
                        </div>
                        <p><?php echo esc_html(get_theme_mod('fino_services_subtitle')); ?></p>
                    </div>
                </div>
            </div>

            <?php
              if($fino_services_query->have_posts() ) :
                ?>
            <div class="row">
                <div class="col-md-12">
                    <?php
                   $count = 0;
                while($fino_services_query->have_posts() && $count <= 5 ) :
                $fino_services_query->the_post();
                ?>
                <?php if($count%2==0){ ?>
                        <div class="col-lg-4 col-md-4">
                            <div class="features-inner even">
                                <i class="fa <?php echo esc_attr($fino_services_icons[$count]); ?> icon-circle" aria-hidden="true"></i>
                               <h5><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h5>
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                        <?php } 
                        else{
                            ?>
                        <div class="col-lg-4 col-md-4">
                            <div class="features-inner">
                                <i class="fa <?php echo esc_attr($fino_services_icons[$count]); ?> icon-circle" aria-hidden="true"></i>
                               <h5><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h5>
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    <?php } ?>
                        <?php
                $count = $count + 1;
                endwhile;
                wp_reset_postdata();
                ?>  
                </div>
            </div>
            <?php
    endif;
?>
        </div>
    </section>

 <?php
    endif;
?>