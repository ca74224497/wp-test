
<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Fino
 */ 
get_header(); ?>

<!-- ====== page 404 ====== -->
    <section class="page404">
        <div class="container">
            <h2><?php echo esc_html__( '404', 'fino' ); ?></h2>
            <h3><?php echo esc_html__('Page Not Found', 'fino' ); ?> </h3>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-fino">
                <?php echo esc_html__( 'Back to Home', 'fino' ); ?>
                <i class="fa fa-long-arrow-right"></i>
            </a>
        </div>
    </section>

    <?php get_footer(); ?>