<?php 

/**
 * fino functions and definitions
 * @package Fino
 */

if( ! function_exists( 'fino_theme_setup' ) ) {

	function fino_theme_setup() {
		
	    load_theme_textdomain( 'fino', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		
		// Add default title support
		add_theme_support( 'title-tag' ); 		

		// Add default logo support		
        add_theme_support( 'custom-logo' );	

        // To use additional css
 	    add_editor_style( 'css/editor-style.css' );		

		// Custom Backgrounds
		add_theme_support( 'custom-background', array(
			'default-color' => 'ffffff',
		) );
	    
		add_theme_support('post-thumbnails');
		
		add_image_size('fino-page-thumbnail', 738, 423, true);
		add_image_size('fino-photo-home', 360, 244, true);
		add_image_size('fino-photo-single', 847, 411, true);
		add_image_size('fino-photo-blog', 408, 244, true);
		add_image_size('fino-casestudy-thumbnail',555,286, true);
		add_image_size( 'fino_client_img', 170, 120, true );  


		
		$defaults = array(
			'default-image'          => get_template_directory_uri() .'/assets/img/about-ban.jpg',
			'width'                  => 1920,
			'height'                 => 540,
			'uploads'                => true,
			);
		add_theme_support( 'custom-header', $defaults );

		/**
		* Set the content width in pixels, based on the theme's design and stylesheet.
		*/
		$GLOBALS['content_width'] = apply_filters( 'fino_content_width', 980 );
		
		// Add theme support for Semantic Markup
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
		) );
		 
		 add_theme_support( 'customize-selective-refresh-widgets' );
		 
		// add excerpt support for pages
		add_post_type_support( 'page', 'excerpt' );
		
		if ( is_singular() && comments_open() ) {
			wp_enqueue_script( 'comment-reply' );
		}
	   
		// Menus
		//add_theme_support( 'menus' );

        register_nav_menus(array(
       'primary' => esc_html__('primary Menu', 'fino')
       ));		

	}
	add_action( 'after_setup_theme', 'fino_theme_setup' );
}


/**
 * Customizer additions.
 */
  // Register Nav Walker class_alias
require get_template_directory() . '/class-wp-bootstrap-navwalker.php';
require get_template_directory(). '/inc/customizer.php';
require get_template_directory(). '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/init.php';

/**
 * Enqueue CSS stylesheets
 */
  
if( ! function_exists( 'fino_enqueue_styles' ) ) {
	function fino_enqueue_styles() {
		
	// Bootstrap CSS 
	wp_enqueue_style('fino-font', 'https://fonts.googleapis.com/css?family=Open+Sans:400,500,600|Poppins:400,500,600,700');
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css');
	wp_enqueue_style('animate', get_template_directory_uri() . '/assets/css/animate.css');		
	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.css');	
	wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.css');
	wp_enqueue_style('fino-owl-theme-default', get_template_directory_uri() . '/assets/css/owl.theme.default.css');
	wp_enqueue_style('fino-responsive', get_template_directory_uri() . '/assets/css/responsive.css');
	wp_enqueue_style('fino-skin-red', get_template_directory_uri() . '/assets/css/skin-red.css');
	wp_enqueue_style('fino-style', get_stylesheet_uri() );
	
	}
	add_action( 'wp_enqueue_scripts', 'fino_enqueue_styles' );
}

/**
 * Enqueue JS scripts
 */

if( ! function_exists( 'fino_enqueue_scripts' ) ) {
	function fino_enqueue_scripts() {
   
	    wp_enqueue_script('jquery');		
	    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.js', array(), '', true);
	    wp_enqueue_script('imagesloaded', get_template_directory_uri() . '/assets/js/imagesloaded.js', array(), '', true);
		wp_enqueue_script('isotope',     get_template_directory_uri() . '/assets/js/isotope.js', array(), '', true);
		wp_enqueue_script('owlcarousel', get_template_directory_uri() . '/assets/js/owl.carousel.js', array(), '', true);	
		wp_enqueue_script('fino-custom-js', get_template_directory_uri() . '/assets/js/custom.js', array(), '', true);
		
	}
	add_action( 'wp_enqueue_scripts', 'fino_enqueue_scripts' );
}

/**
 * Register sidebars for fino
*/

function fino_sidebars() {

	// Blog Sidebar
	
	register_sidebar(array(
		'name' => esc_html__( 'Blog Sidebar', "fino"),
		'id' => 'blog-sidebar',
		'description' => esc_html__( 'Sidebar on the blog layout.', "fino"),
		'before_widget' => '<div id="%1$s" class="widget post-widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-heading">',
		'after_title' => '</h3>',
	));
  	

	// Footer Sidebar
	
	register_sidebar(array(
		'name' => esc_html__( 'Footer Widget Area 1', "fino"),
		'id' => 'fino-footer-widget-area-1',
		'description' => esc_html__( 'The footer widget area 1', "fino"),
		'before_widget' => '<div class="company-details %2$s">',
		'after_widget' => '</div>',
		'before_title' => ' <h4><span>',
		'after_title' => '</span></h4>',
	));	
	
	register_sidebar(array(
		'name' => esc_html__( 'Footer Widget Area 2', "fino"),
		'id' => 'fino-footer-widget-area-2',
		'description' => esc_html__( 'The footer widget area 2', "fino"),
		'before_widget' => ' <div class="soc-links %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));	
	
	register_sidebar(array(
		'name' => esc_html__( 'Footer Widget Area 3', "fino"),
		'id' => 'fino-footer-widget-area-3',
		'description' => esc_html__( 'The footer widget area 3', "fino"),
		'before_widget' => '<div class="repost %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));	


	register_sidebar(array(
		'name' => esc_html__( 'Footer Widget Area 4', "fino"),
		'id' => 'fino-footer-widget-area-4',
		'description' => esc_html__( 'The footer widget area 4', "fino"),
		'before_widget' => ' <div class="footbox %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));	
		
}

add_action( 'widgets_init', 'fino_sidebars' );




    /**
     * Comment layout
    */
    function fino_comments( $comment, $args, $depth ) { ?>
        <div id="comment-<?php comment_ID(); ?>" <?php comment_class('comment-box'); ?>>
		    <?php if ($comment->comment_approved == '0') : ?>
			<div class="alert alert-info">
			  <p><?php esc_html_e( 'Your comment is awaiting moderation.', 'fino' ) ?></p>
			</div>
		    <?php endif; ?>

		    <div class="comment-block">
			    <div class="user-img">
			    <a href="#"><?php echo get_avatar( $comment,60, null,'comments user', array( 'class' => array( 'media-object','' ) )); ?></a>
		        </div>	
                <div class="user-post-content">
                    <div class="reply"><i class="fa fa-reply"></i><?php comment_reply_link (array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                    </div>
                    <h4>
                        <?php 
					        /* translators: '%1$s %2$s: edit term */
					       printf(esc_html__( '%1$s %2$s', 'fino' ), get_comment_author_link(), edit_comment_link() ) ?>
                        <span> <?php echo esc_html__( 'Says :', 'fino' ); ?></span>
                    </h4>
				    <span><?php comment_date('F j, Y');?> <?php echo esc_html__( 'at', 'fino' ); ?> <?php comment_time('g:i a'); ?></span>
                    <p><?php comment_text() ?></p>
               </div>
            </div>
        </div>
<?php
  } 

?>