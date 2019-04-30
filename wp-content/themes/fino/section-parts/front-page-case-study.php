    <?php
/**
 * Template part - Features Section of FrontPage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fino
*/

    $fino_casestudy_section  = get_theme_mod( 'fino_casestudy_section_hideshow','hide');
    $fino_casestudy_title    =  get_theme_mod('fino_casestudy_title');  

   
    $fino_casestudy_no        = 6;
    $fino_casestudy_pages     = array();
    $fino_casestudy_icons     = array();
    
    for( $i = 1; $i <= $fino_casestudy_no ; $i++ ) {
        $fino_casestudy_pages[]    =  get_theme_mod( "fino_casestudy_page_$i", 1 );
       $fino_casestudy_icons[]    = get_theme_mod( "fino_page_casestudy_icon_$i", '' );
    }

    $fino_casestudy_args  = array(
        'post_type' => 'page',
        'post__in' => array_map( 'absint', $fino_casestudy_pages ),
        'posts_per_page' => absint($fino_casestudy_no),
        'orderby' => 'post__in'
       
    ); 
    
    $fino_casestudy_query = new wp_Query( $fino_casestudy_args );

    if($fino_casestudy_section == "show") :

   ?>

    <section class="case-study">
        <div class="container">
            <div class="row"> 
                <div class="col-sm-12">
                    <div class="all-title">
                        <div class="sec-title">
                            <?php if($fino_casestudy_title != "")
                            {?>
                                <h3>
                                    <span><?php echo esc_html(get_theme_mod('fino_casestudy_title')); ?></span>
                                </h3>
                            <?php 
                            }?> 
                        </div>
                                <p>
                                    <?php echo  esc_html(get_theme_mod('fino_casestudy_subtitle')); ?>
                                </p>
                    </div>
                </div>
            </div>
        </div>
         <?php
          if($fino_casestudy_query->have_posts() ) :
    ?>


        <div class="case-tab-panel">
            <?php
                if( $fino_casestudy_query ->have_posts() )
                { 
            ?>
                <ul class="case-study-tabs clearfix">
                    <?php 
                        $i=0;
                        while($fino_casestudy_query->have_posts()) :
                            $fino_casestudy_query->the_post();
                    ?>
                            <li class="case-tab <?php if($i==0){ echo "active"; }?>" data-tab="case<?php echo $i;?>">
                                <i class="fa <?php echo esc_attr($fino_casestudy_icons[$i]); ?> icon-circle" aria-hidden="true"></i>
                                <span><?php the_title();  ?></span>
                            </li>
                    <?php 
                        $i++;
                        endwhile;
                    ?>
                </ul> 
                    <?php
                        }
                    ?>
              
            <div class="case-panel-wrap" <?php if ( get_header_image() ){ ?> style="background-image:url('<?php header_image(); ?>')"  <?php } ?>>
                <div class="container">
                    <?php
                        if( $fino_casestudy_query ->have_posts() )
                        { 
                            $i=0;
                            while($fino_casestudy_query->have_posts()) :
                                $fino_casestudy_query->the_post();
                                $fino_casestudy_icons = get_post_meta( get_the_ID(), '$fino_casestudy_icons', true );  
                                ?>
                                <div class="case-content <?php if($i==0){echo "active"; } ?>" id="case<?php echo $i;?>">
                                    <div class="row">
                                        <div class="col-md-6 casepara">
                                            <h2 class="h-border"><?php the_title();  ?></h2>
                                            <?php the_content(); ?>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="case-img">
                                                <?php if(has_post_thumbnail()){  
                                                    the_post_thumbnail('fino-casestudy-thumbnail', array('class' => 'img-responsive'));
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++;
                            endwhile;
                            wp_reset_postdata();
                        }   
                            ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </section>
    <?php endif; ?>