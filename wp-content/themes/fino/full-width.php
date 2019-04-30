<?php
/**
 * Template Name: Full-width Page Template, No Sidebar
 *
 * Description: Use this page template to remove the sidebar from any page.
 * @package Fino
 */
?>

<?php get_header(); 

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
                        <?php if (is_home() || is_front_page()) { ?>						
							<h2><?php the_title(); ?></h2>
						<?php } else { ?>
							<h2><?php wp_title(''); ?></h2>							
						<?php } ?>	
                    </div>
                </div>
            </div>
        </div>
    </section>


<div class="blog blog-2 sp-80 page-wrapper">
        <div class="container">
            <div class="row">
                <article class="col-md-12 blog-wrap">
                    <div class="verti">
						<?php if(has_post_thumbnail()) : ?>
						<div class="blog-img pb-20">                            
							<?php the_post_thumbnail('fino-page-thumbnail', array('class' => 'img-responsive')); ?>                           
						</div>
						<?php endif;  
						if(have_posts()) :						 
							while(have_posts()) : the_post();  
								the_content(); 
								wp_link_pages( array(
									'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fino' ),
									'after'  => '</div>',
								) );
							endwhile;                       
						else : ?>
							<p><?php esc_html__('No Posts Found', 'fino'); ?></p>
						<?php endif; ?>
					</div>	
                    <div class="row">
                        <div class="col-md-12">
                            <?php if ( comments_open() || get_comments_number() ) :
                            comments_template();
                            endif; ?> 
                        </div>
                    </div>
               </article>
                
            </div>
        </div>
    </div>


<?php get_footer(); ?>