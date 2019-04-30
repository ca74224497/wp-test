<?php
/**
 * The template for displaying all single posts.
 *
 * @package Fino
 */
 get_header(); 

 if(get_header_image()){
    $fino_overlay = "banner";
 }
 else{
    $fino_overlay = "nobanner";
 }
?>

 <section class="<?php echo esc_attr($fino_overlay);?>" <?php if ( get_header_image() ){ ?> style="background-image:url('<?php header_image(); ?>')"  <?php } ?>>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="<?php echo esc_attr($fino_overlay);?>-heading">
                        <h2><?php wp_title(''); ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== blogs ====== -->

  <div class="blog sp-80">
        <div class="container">
            <div class="row">
                <div class="col-md-9 ">
                    <div class="blog-detail">
                    <?php 
                       if(have_posts()) : 
                    ?>
                    <?php while(have_posts()) : the_post(); ?>
                    
                       <?php  get_template_part( 'content-parts/content', 'single' ); ?>
                    
                     <?php endwhile; ?>
                           <?php else : 
                  get_template_part( 'content-parts/content', 'none' );
                endif; ?>
                       
                    </div>
                </div>
                <div class="col-md-3">
                    <aside class="sidebar">
                      <?php get_sidebar(); ?>
                    </aside>
                </div>
            </div>
        </div>
    </div>
    
<?php get_footer(); ?>