<?php 
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
    <!--======  banner ====== -->
    <section class="<?php echo esc_attr($fino_overlay);?>" <?php if ( get_header_image() ){ ?> style="background-image:url('<?php header_image(); ?>')"  <?php } ?>>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="<?php echo esc_attr($fino_overlay);?>-heading">
                        <h2><?php the_archive_title(); ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </section> 

    <!-- ====== blogs ====== -->
    <div class="bg-w sp-80">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="row blog-isotope">
                        <?php if(have_posts()) : ?>
                            <?php while(have_posts()) : the_post(); ?>
                            <article class="col-md-12 blog-wrap blog-iso-item">
                                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                   <?php get_template_part('content-parts/content', get_post_format()); ?>
                                </div>
                            </article>
                            <?php endwhile; ?>
							<?php else : 
                            get_template_part( 'content-parts/content', 'none' );
                        endif; ?>
                    </div>
					 <div class="col-md-12">
                            <div class="fino-pagination">
                                <?php the_posts_pagination(
                                    array(
                                    'prev_text' => esc_html__('&lt;','fino'),
                                    'next_text' => esc_html__('&gt;','fino')
                                    )
                                ); 
                                ?>
                            </div>
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