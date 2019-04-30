<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Fino
 */
   
$fino_footer_section = get_theme_mod('fino_footer_section_hideshow','show');
$fino_column_layout       = get_theme_mod( 'fino_column_layout', '4' );

if ($fino_footer_section =='show') { ?>

   <section class="footer">
            <div class="container">
                <div class="footer-top">
                    <div class="row">
                        <div class="mb-60 col-lg-<?php echo esc_attr($fino_column_layout); ?> col-md-<?php echo esc_attr($fino_column_layout); ?>">
                            <div class="f-content">
                                <?php dynamic_sidebar('fino-footer-widget-area-1'); ?>
                            </div>
                        </div>
                        <div class="mb-60 col-lg-<?php echo esc_attr($fino_column_layout); ?> col-md-<?php echo esc_attr($fino_column_layout); ?>">
                            <?php dynamic_sidebar('fino-footer-widget-area-2'); ?>
                        </div>
                        <?php if($fino_column_layout ==4 ){?>
                        <div class="mb-60 col-lg-<?php echo esc_attr($fino_column_layout); ?> col-md-<?php echo esc_attr($fino_column_layout); ?>">
                            <?php dynamic_sidebar('fino-footer-widget-area-3'); ?>
                        </div>
                        <?php   } ?>
                        <?php if($fino_column_layout ==3 ){?>
                             <div class="mb-60 col-lg-<?php echo esc_attr($fino_column_layout); ?> col-md-<?php echo esc_attr($fino_column_layout); ?>">
                            <?php dynamic_sidebar('fino-footer-widget-area-3'); ?>
                        </div>

                            <div class="mb-60 col-lg-<?php echo esc_attr($fino_column_layout); ?> col-md-<?php echo esc_attr($fino_column_layout); ?>">
                            <?php dynamic_sidebar('fino-footer-widget-area-4'); ?>
                            </div>
                     <?php   } ?>
                        
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>
                       <?php if( get_theme_mod('fino_footer_text') ) : ?>
                           <span><?php echo wp_kses_post( html_entity_decode(get_theme_mod('fino_footer_text'))); ?></span>
                    <?php else : 
                           /* translators: 1: poweredby, 2: link, 3: span tag closed  */
                           printf( esc_html__( ' %1$sPowered by %2$s%3$s', 'fino' ), '<span>', '<a href="'. esc_url( __( 'https://wordpress.org/', 'fino' ) ) .'" target="_blank">WordPress.</a>', '</span>' );
                           /* translators: 1: poweredby, 2: link, 3: span tag closed  */
                           printf( esc_html__( ' Theme: Fino by: %1$sDesign By %2$s%3$s', 'fino' ), '<span>', '<a href="'. esc_url( __( 'http://freepsdworld.com/', 'fino' ) ) .'" target="_blank">freepsdworld.</a>', '</span>' );
                        endif;  ?>
                    </p>
                </div>
            </div>
    </section>
    <?php } ?>
    <?php wp_footer(); ?>
</body>
</html>