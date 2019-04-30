<?php
/**
 * Info setup
 *
 * @package fino
 */

if ( ! function_exists( 'fino_details_setup' ) ) :

    /**
     * Info setup.
     *
     * @since 1.0.0
     */
    function fino_details_setup() {

        $config = array(

            // Welcome content.
            'welcome-texts' => sprintf( esc_html__( 'Howdy %1$s, we would like to thank you for installing and activating %2$s theme for your precious site. All of the features provided by the theme are now ready to use; Here, we have gathered all of the essential details and helpful links for you and your better experience with %2$s. Once again, Thanks for using our theme!', 'fino' ), get_bloginfo('name'), 'Fino' ),

            // Tabs.
            'tabs' => array(
                'getting-started' => esc_html__( 'Getting Started', 'fino' ),
                'support'         => esc_html__( 'Support', 'fino' ),
                'free-vs-pro'    => esc_html__( 'Free vs Pro', 'fino' ),
                'upgrade-to-pro'  => esc_html__( 'Upgrade to Pro', 'fino' ),
            ),

            // Quick links.
            'quick_links' => array(
                'theme_url' => array(
                    'text' => esc_html__( 'Theme Details', 'fino' ),
                    'url'  => 'http://freepsdworld.com/fino-free-wordpress-theme-722/',
                ),
                'demo_url' => array(
                    'text' => esc_html__( 'View Demo', 'fino' ),
                    'url'  => 'http://freepsdworld.com/demo/fino-free/',
                ),
                'documentation_url' => array(
                    'text' => esc_html__( 'View Documentation', 'fino' ),
                    'url'  => 'http://freepsdworld.com/docs/fino-free/index.html',
                ),
                'rating_url' => array(
                    'text' => esc_html__( 'Rate This Theme','fino' ),
                    'url'  => 'https://wordpress.org/support/theme/fino/reviews/#new-post',
                ),
            ),

            // Getting started.
            'getting_started' => array(
                'one' => array(
                    'title'       => esc_html__( 'Theme Documentation', 'fino' ),
                    'icon'        => 'dashicons dashicons-format-aside',
                    'description' => esc_html__( 'Please check our full documentation for detailed information on how to setup and customize the theme.', 'fino' ),
                    'button_text' => esc_html__( 'View Documentation', 'fino' ),
                    'button_url'  => 'http://freepsdworld.com/docs/fino-free/index.html',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
                'two' => array(
                    'title'       => esc_html__( 'Static Front Page', 'fino' ),
                    'icon'        => 'dashicons dashicons-admin-generic',
                    'description' => esc_html__( 'To achieve custom home page other than blog listing, you need to create and set static front page. Like Theme Home page Select Homepage Template.', 'fino' ),
                    'button_text' => esc_html__( 'Static Front Page', 'fino' ),
                    'button_url'  => admin_url( 'customize.php?autofocus[section]=static_front_page' ),
                    'button_type' => 'primary',
                ),
                'three' => array(
                    'title'       => esc_html__( 'Theme Options', 'fino' ),
                    'icon'        => 'dashicons dashicons-admin-customizer',
                    'description' => esc_html__( 'Theme uses Customizer API for theme options. Using the Customizer you can easily customize different aspects of the theme.', 'fino' ),
                    'button_text' => esc_html__( 'Customize', 'fino' ),
                    'button_url'  => wp_customize_url(),
                    'button_type' => 'primary',
                ),
                
                
                'four' => array(
                    'title'       => esc_html__( 'Theme Preview', 'fino' ),
                    'icon'        => 'dashicons dashicons-welcome-view-site',
                    'description' => esc_html__( 'You can check out the theme demos for reference to find out what you can achieve using the theme and how it can be customized.', 'fino' ),
                    'button_text' => esc_html__( 'View Demo', 'fino' ),
                    'button_url'  => 'http://freepsdworld.com/demo/fino-free/',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
            ),

            // Support.
            'support' => array(
                'one' => array(
                    'title'       => esc_html__( 'Contact Support', 'fino' ),
                    'icon'        => 'dashicons dashicons-sos',
                    'description' => esc_html__( 'Got theme support question or found bug or got some feedbacks? Feel free to ask any queries related to theme', 'fino' ),
                    'button_text' => esc_html__( 'Contact Support', 'fino' ),
                    'button_url'  => 'https://wordpress.org/support/theme/fino',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
                'two' => array(
                    'title'       => esc_html__( 'Theme Documentation', 'fino' ),
                    'icon'        => 'dashicons dashicons-format-aside',
                    'description' => esc_html__( 'Please check our full documentation for detailed information on how to setup and customize the theme.', 'fino' ),
                    'button_text' => esc_html__( 'View Documentation', 'fino' ),
                    'button_url'  => 'http://freepsdworld.com/docs/fino-free/index.html',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
                'three' => array(
                    'title'       => esc_html__( 'Child Theme', 'fino' ),
                    'icon'        => 'dashicons dashicons-admin-tools',
                    'description' => esc_html__( 'For advanced theme customization, it is recommended to use child theme rather than modifying the theme file itself. Using this approach, you wont lose the customization after theme update.', 'fino' ),
                    'button_text' => esc_html__( 'Learn More', 'fino' ),
                    'button_url'  => 'https://developer.wordpress.org/themes/advanced-topics/child-themes/',
                    'button_type' => 'link',
                    'is_new_tab'  => true,
                ),
            ),

            //Useful plugins.
            'useful_plugins' => array(
                'description' => esc_html__( 'Theme supports some helpful WordPress plugins to enhance your site. But, please enable only those plugins which you need in your site. For example, enable WooCommerce only if you are using e-commerce.', 'fino' ),
            ),

            

            //Free vs Pro.
            'free_vs_pro' => array(

                'features' => array(
                    'Live editing in Customizer' => array('Yes', 'Yes', 'dashicons-yes', 'dashicons-yes'),
					'Responsive Layout' => array('Yes', 'Yes', 'dashicons-yes', 'dashicons-yes'),
                    'Translations Ready' => array('Yes', 'Yes', 'dashicons-yes', 'dashicons-yes'),
                    'SEO' => array('Optimized', 'Optimized'),
                    'Preloader Option' => array('No', 'Yes','dashicons-yes', 'dashicons-yes'),
                    'Header Options' => array('Default', '2 Different Header Options'),
                    'Home Templates' => array('1', '2'),
                    'Slider' => array('3 Slides', 'Unlimited Slides'),
                    'Social Media Links' => array('4+', '15+'),
                    'Home Page Sections' => array('4', '10+'),
                    'Page Template' => array('2', '10+'),
                    'Team Page' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                    'Projects Page' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                    'Team Details' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                    'Projects Details' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                    'Service Page' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                    'Blog Layouts' => array('1', '6'),
                    'Shortcodes' => array('0', '20+'),
					'Advaned Option Panel(redux)' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
					'Box Layout' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
					'Unlimitd Color Scheme' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
					'Contact Form 7 Integrated' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
					'Advanced Typography' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
                    'Main Banner Options' => array('Page Slider', 'Page Slider, Product Slider'),
                    'Contact Options' => array('Yes', 'Yes', 'dashicons-yes', 'dashicons-yes'),
					'Google Fonts' => array('1', '500+'),                   
                    'Footer Widgets Section' => array('Yes', 'Yes', 'dashicons-yes', 'dashicons-yes'),
                    'Hide Theme Credit Link' => array('No', 'Yes', 'dashicons-no-alt', 'dashicons-yes'),
					'Support' => array('Yes', 'High Priority Dedicated Support')
                    
                ),
            ),

            // Upgrade content.
            'upgrade_to_pro' => array(
                'description' => esc_html__( 'If you want more advanced features then you can upgrade to the premium version of the theme.', 'fino' ),
                'button_text' => esc_html__( 'Upgrade Now', 'fino' ),
                'button_url'  => 'http://freepsdworld.com/themes/fino-pro/',
                'button_type' => 'primary',
                'is_new_tab'  => true,
            ),
        );

        Fino_Info::init( $config );
    }

endif;

add_action( 'after_setup_theme', 'fino_details_setup' );