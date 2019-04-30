<?php 
/**
 * The header for our theme.
 *
 * Displays all of the <head> section 
 *
 * @package Fino
 */
 ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
 <?php endif; ?>

  <?php wp_head(); ?>
</head> 
<body <?php body_class(); ?>>

  <!-- ====== scroll to top ====== -->

    <a href="javascript:void(0)" id="finoScroll" title="<?php esc_html__( 'Go to top', 'fino' ); ?>" ><?php esc_html__( 'Top', 'fino' ); ?></a>

    <!-- ====== header ====== -->
    <?php  
        $fino_header_section = get_theme_mod('fino_header_section_hideshow' ,'show');
        if ($fino_header_section =='show') { 
        $fino_phone_value = get_theme_mod('fino_header_phone_value');
        $fino_header_phone_label = get_theme_mod('fino_header_phone_label');
        $fino_time_value = get_theme_mod('fino_header_time_value');
        $fino_header_time_label = get_theme_mod('fino_header_time_label');
        $fino_ctah_btn_text = get_theme_mod('fino_ctah_btn_text');
        $fino_ctah_btn_url = get_theme_mod('fino_ctah_btn_url');
    ?>

    <header class="header">
        <div class="fino-mobile-menu d-lg-none">
            <?php if (has_custom_logo()) : ?> 
                <div class="mobile-logo">
                    <h1> <?php the_custom_logo(); ?></h1>
                </div>
                    <?php  else : ?>
                <div class="logo-text">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title">
                        <h1 class="logo-area"><?php bloginfo( 'title' ); ?></h1>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="tagc">
                        <span class="site-description"><?php bloginfo( 'description' ); ?></span>
                    </a> 
                </div>
            <?php endif; ?>
                <div class="menu-toggle hamburger-menu">
                  <div class="top-bun"></div>
                  <div class="meat"></div>
                  <div class="bottom-bun"></div>
                </div>
                <div id="mobile-m" class="mobile-menu">
                    <span class="close-menu">
                       <i class="fa fa-times"></i>
                    </span>
                </div>
        </div>
        <div class="top-head d-none d-lg-block">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                      <div class="logo logo-header ">
                        <?php if (has_custom_logo()) : ?> 
                              <h2> <?php the_custom_logo(); ?></h2>
                        <?php else : ?>
                                <h2 class="logo-area">
                                  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title">
                                    <?php bloginfo( 'title' ); ?>
                                  </a>
                                </h2>
                        <?php endif; ?>
                      </div>
                    </div>
                    <div class="col-md-9">
                        <div class="head-detail">
                            <ul class="clearfix">
                              <?php
                                     if (!empty($fino_time_value)) {
                                    ?>
                                <li>
                                   
                                    <span>
                                        <?php echo esc_html($fino_header_time_label); ?>
                                    </span>
                                   
                                    <p><?php echo esc_html($fino_time_value); ?></p>
                                  
                                </li>
                                <?php } ?>
                              
                                
                                  <?php
                                      if (!empty($fino_phone_value)) {
                                    ?>
                                    <li> 
                                    <span>
                                      <?php echo esc_html($fino_header_phone_label); ?>
                                    </span>
                                    
                                    <p><?php echo esc_html($fino_phone_value); ?></p>
                                    </li>
                                    <?php }
                                    ?>
									<?php
                                    if (!empty($fino_ctah_btn_url)) {
                                  ?> 
									<li>
										<a href="<?php echo esc_url($fino_ctah_btn_url); ?>" class="btn btn-fino"><?php echo esc_html($fino_ctah_btn_text); ?></a>
                                    </li>
                                  <?php }
                                    ?>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="bottom-head d-none d-lg-block">
            <div class="container clearfix">
                <div class="fino-menu">
                    <nav class="menubar">
                        <?php wp_nav_menu( 
                            array(
                               'container'        => 'ul', 
                               'theme_location'    => 'primary', 
                               'menu_class'        => 'menu', 
                               'items_wrap'        => '<ul class="menu-wrap clearfix">%3$s</ul>',
                               'fallback_cb'       => 'fino_wp_bootstrap_navwalker::fallback',
                                'walker'            => new fino_wp_bootstrap_navwalker()
                            )
                          ); 
                        ?>
                    </nav>
                </div>
            </div>
        </div>
    </header>