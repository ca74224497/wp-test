<?php
/**
 * Fino Theme Customizer
 *
 * @package Fino
 */


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */


function fino_customize_register( $wp_customize ) {
	
	// Fino theme choice options
    if (!function_exists('fino_section_choice_option')) :
        function fino_section_choice_option()
        {
            $fino_section_choice_option = array(
                'show' => esc_html__('Show', 'fino'),
                'hide' => esc_html__('Hide', 'fino')
            );
            return apply_filters('fino_section_choice_option', $fino_section_choice_option);
        }
    endif;


    if (!function_exists('fino_column_layout_option')) :
        function fino_column_layout_option()
        {
            $fino_column_layout_option = array(
                '6' => esc_html__('2 Column Layout', 'fino'),
                '4' => esc_html__('3 Column Layout', 'fino'),
                '3' => esc_html__('4 Column Layout', 'fino'),
            );
            return apply_filters('fino_column_layout_option', $fino_column_layout_option);
        }
    endif;



    /**
     * Sanitizing the select callback example
     *
    */
    if ( !function_exists('fino_sanitize_select') ) :
        function fino_sanitize_select( $input, $setting ) {

            // Ensure input is a slug.
            $input = sanitize_text_field( $input );

            // Get list of choices from the control associated with the setting.
            $choices = $setting->manager->get_control( $setting->id )->choices;

                // If the input is a valid key, return it; otherwise, return the default.
            return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
        }
    endif;


    if ( !function_exists('fino_column_layout_sanitize_select') ) :
        function fino_column_layout_sanitize_select( $input, $setting ) {

            // Ensure input is a slug.
            $input = sanitize_text_field( $input );

            // Get list of choices from the control associated with the setting.
            $choices = $setting->manager->get_control( $setting->id )->choices;

            // If the input is a valid key, return it; otherwise, return the default.
            return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
        }
    endif;
    
    /**
     * Drop-down Pages sanitization callback example.
     *
     * - Sanitization: dropdown-pages
     * - Control: dropdown-pages
     * 
     * Sanitization callback for 'dropdown-pages' type controls. This callback sanitizes `$page_id`
     * as an absolute integer, and then validates that $input is the ID of a published page.
     * 
     * @see absint() https://developer.wordpress.org/reference/functions/absint/
     * @see get_post_status() https://developer.wordpress.org/reference/functions/get_post_status/
     *
     * @param int                  $page    Page ID.
     * @param WP_Customize_Setting $setting Setting instance.
     * @return int|string Page ID if the page is published; otherwise, the setting default.
     */

    function fino_sanitize_dropdown_pages( $page_id, $setting ) {
        // Ensure $input is an absolute integer.
        $page_id = absint( $page_id );
    
        // If $page_id is an ID of a published page, return it; otherwise, return the default.
        return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
    }


	
    /** Front Page Section Settings starts **/	

    $wp_customize->add_panel('fino_frontpage', 
        array(
            'title'       => esc_html__('Fino Options', 'fino'),        
		    'description' => '',                                        
		     'priority'   => 3,
        )
    );
	

    /** Header Section Settings Start **/

    $wp_customize->add_section('fino_header_info', 
        array(
            'title'       => esc_html__('Header Section', 'fino'),
            'description' => '',
            'panel'       => 'fino_frontpage',
            'priority'    => 100
        )
    );
  
    $wp_customize->add_setting(
    'fino_header_section_hideshow',
    array(
        'default'           => 'show',
        'sanitize_callback' => 'fino_sanitize_select',
    )
    );

    $fino_header_section_hide_show_option = fino_section_choice_option();

    $wp_customize->add_control('fino_header_section_hideshow',
        array(
            'type'        => 'radio',
            'label'       => esc_html__('Header Option', 'fino'),
            'description' => esc_html__('Show/hide option for Header Section.', 'fino'),
            'section'     => 'fino_header_info',
            'choices'     => $fino_header_section_hide_show_option,
            'priority'    => 1
        )
    );
  
	
	 $wp_customize->add_setting('fino_header_time_label', 
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control('fino_header_time_label',
        array(
            'label'    => esc_html__('Office Timing Label Text', 'fino'),
            'section'  => 'fino_header_info',
            'priority' => 1
        )
    );
	
    $wp_customize->add_setting('fino_header_time_value', 
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control('fino_header_time_value',
        array(
            'label'    => esc_html__('Office Timing', 'fino'),
            'section'  => 'fino_header_info',
            'priority' => 1
        )
    );
	
	  $wp_customize->add_setting('fino_header_phone_label', 
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control('fino_header_phone_label',
         array(
            'label'     => esc_html__('Toll Free Label Title', 'fino'),
            'section'   => 'fino_header_info',
            'priority'  => 2
        )
     );
  
    $wp_customize->add_setting('fino_header_phone_value', 
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control('fino_header_phone_value',
         array(
            'label'     => esc_html__('Toll Free', 'fino'),
            'section'   => 'fino_header_info',
            'priority'  => 2
        )
     );
  
  
    $wp_customize->add_setting('fino_ctah_btn_url', 
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'esc_url_raw'
        )
    );


    $wp_customize->add_control('fino_ctah_btn_url', 
        array(
            'label'    => esc_html__('Quote Button URL', 'fino'),
            'section'  => 'fino_header_info',
            'priority' => 3
        )
    );

    $wp_customize->add_setting('fino_ctah_btn_text',
         array(
            'default'           => '',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control('fino_ctah_btn_text',
        array(
            'label'    => esc_html__('Quote Button Text', 'fino'),
            'section'  => 'fino_header_info',
            'priority' => 4
        )
    );	

 /** Header Section Settings end **/

 /** Slider Section Settings Start **/

    // Panel - Slider Section 1
    $wp_customize->add_section('fino_sliderinfo', 
        array(
            'title'       => esc_html__('Home Slider Section', 'fino'),
            'description' => '',
            'panel'       => 'fino_frontpage',
             'priority'   => 130
        )
    );

    // hide show
    
    $wp_customize->add_setting('fino_slider_section_hideshow',
        array(
            'default'           => 'hide',
            'sanitize_callback' => 'fino_sanitize_select',
        )
    );

    $fino_slider_section_hide_show_option = fino_section_choice_option();

    $wp_customize->add_control('fino_slider_section_hideshow',
        array(
            'type'        => 'radio',
            'label'       => esc_html__('Slider Option', 'fino'),
            'description' => esc_html__('Show/hide option for Slider Section.', 'fino'),
            'section'     => 'fino_sliderinfo',
            'choices'     => $fino_slider_section_hide_show_option,
            'priority'    => 1
        )
    );
  
    $slider_no = 3;
        for( $i = 1; $i <= $slider_no; $i++ ) {
            $fino_slider_page   = 'fino_slider_page_' .$i;
            $fino_slider_btntxt = 'fino_slider_btntxt_' . $i;
            $fino_slider_btnurl = 'fino_slider_btnurl_' .$i;
        

    $wp_customize->add_setting( $fino_slider_page,
        array(
            'default'           => 1,
            'sanitize_callback' => 'fino_sanitize_dropdown_pages',
        )
    );

    $wp_customize->add_control( $fino_slider_page,
        array(
            'label'     => esc_html__( 'Slider Page ', 'fino' ) .$i,
            'section'   => 'fino_sliderinfo',
            'type'      => 'dropdown-pages',
            'priority'  => 100,
        )
    );


    $wp_customize->add_setting( $fino_slider_btntxt,
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control( $fino_slider_btntxt,
        array(
            'label'        => esc_html__( 'Button - Text','fino' ),
            'section'      => 'fino_sliderinfo',
            'type'         => 'text',
            'priority'     => 100,
        )
    );
        
    $wp_customize->add_setting( $fino_slider_btnurl,
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control( $fino_slider_btnurl,
        array(
            'label'       => esc_html__( 'Button - URL', 'fino' ),
            'section'     => 'fino_sliderinfo',
            'type'        => 'text',
            'priority'    => 100,
        )
    );

                
    }	
    /** Slider Section Settings End **/

    /** Service Section Settings Start **/

	$wp_customize->add_section('fino_services',              
        array(
            'title'       => esc_html__('Home Service Section', 'fino'),          
            'description' => '',             
            'panel'       => 'fino_frontpage',      
            'priority'    => 140,
        )
    );
    
    $wp_customize->add_setting('fino_services_section_hideshow',
        array(
            'default'           => 'hide',
            'sanitize_callback' => 'fino_sanitize_select',
        )
    );

    $fino_services_section_hide_show_option = fino_section_choice_option();

    $wp_customize->add_control(
        'fino_services_section_hideshow',
        array(
            'type'        => 'radio',
            'label'       => esc_html__('Services Option', 'fino'),
            'description' => esc_html__('Show/hide option Section.', 'fino'),
            'section'     => 'fino_services',
            'choices'     => $fino_services_section_hide_show_option,
            'priority'    => 1
        )
    );


    // Services title
    $wp_customize->add_setting('fino_services_title', 
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field'
        )
    );


    $wp_customize->add_control('fino_services_title',
        array(
           'label'    => esc_html__('service Title', 'fino'),
           'section'  => 'fino_services',
           'priority' => 1
        )
    );

  
    $wp_customize->add_setting('fino_services_subtitle',
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field'
        )
    );


    $wp_customize->add_control('fino_services_subtitle', 
        array(
           'label'    => esc_html__('service description', 'fino'),
           'section'  => 'fino_services', 
           'priority' => 4
        )
    );


    // Services 
   
    $service_no = 6;
        for( $i = 1; $i <= $service_no; $i++ ) {
            $fino_servicepage = 'fino_service_page_' . $i;
            $fino_serviceicon = 'fino_page_service_icon_' . $i;
        
    // Setting - Feature Icon
    $wp_customize->add_setting( $fino_serviceicon,
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control( $fino_serviceicon,
        array(
            'label'         => esc_html__( 'Service Icon ', 'fino' ).$i,
            'description'   =>  __('Select a icon in this list <a target="_blank" href="https://fontawesome.com/v4.7.0/icons/">Font Awesome icons</a> and enter the class name','fino'),
            'section'       => 'fino_services',
            'type'          => 'text',
            'priority'      => 100,
        )
    );
        
    $wp_customize->add_setting( $fino_servicepage,
        array(
            'default'           => 1,
            'sanitize_callback' => 'fino_sanitize_dropdown_pages',
        )
    );

    $wp_customize->add_control( $fino_servicepage,
        array(
            'label'        => esc_html__( 'Service Page ', 'fino' ) .$i,
            'section'      => 'fino_services',
            'type'         => 'dropdown-pages',
            'priority'     => 100,
        )
    );
    }
    /** Service Section Settings End **/

    /** Case Study Section Settings Start **/

	$wp_customize->add_section('fino_case_study',              
        array(
            'title'       => esc_html__('Case Study Section', 'fino'),          
            'description' => '',             
            'panel'       => 'fino_frontpage',      
            'priority'    => 140,
        )
    );
    
    $wp_customize->add_setting('fino_casestudy_section_hideshow',
        array(
            'default'           => 'hide',
            'sanitize_callback' => 'fino_sanitize_select',
        )
    );

    $fino_casestudy_section_hide_show_option = fino_section_choice_option();

    $wp_customize->add_control('fino_casestudy_section_hideshow',
        array(
            'type'        => 'radio',
            'label'       => esc_html__('Case Study Option', 'fino'),
            'description' => esc_html__('Show/hide option Section.', 'fino'),
            'section'     => 'fino_case_study',
            'choices'     => $fino_casestudy_section_hide_show_option,
            'priority'    => 1
        )
    );


    // Case Study title
    $wp_customize->add_setting('fino_casestudy_title',
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field'
        )
     );

    $wp_customize->add_control('fino_casestudy_title', 
        array(
            'label'    => esc_html__('Case Study Title', 'fino'),
            'section'  => 'fino_case_study',
            'priority' => 1
        )
    );
  
    $wp_customize->add_setting('fino_casestudy_subtitle', 
        array(
            'default'           => '',
            'type'              => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control('fino_casestudy_subtitle',
        array(
            'label'    => esc_html__('Case Study Description', 'fino'),
            'section'  => 'fino_case_study', 
            'priority' => 4
        )
     );


    // Case Study 
   
    $casestudy_no = 6;
        for( $i = 1; $i <= $casestudy_no; $i++ ) {
            $fino_casestudypage = 'fino_casestudy_page_' . $i;
            $fino_casestudyicon = 'fino_page_casestudy_icon_' . $i;
        
    // Setting - Feature Icon
    $wp_customize->add_setting( $fino_casestudyicon,
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control( $fino_casestudyicon,
         array(
            'label'        => esc_html__( 'Case Study Icon ', 'fino' ).$i,
            'description'  =>  __('Select a icon in this list <a target="_blank" href="https://fontawesome.com/v4.7.0/icons/">Font Awesome icons</a> and enter the class name','fino'),
            'section'      => 'fino_case_study',
            'type'         => 'text',
            'priority'     => 100,
        )
    );
        
    $wp_customize->add_setting( $fino_casestudypage,
        array(
            'default'           => 1,
            'sanitize_callback' => 'fino_sanitize_dropdown_pages',
        )
    );

    $wp_customize->add_control( $fino_casestudypage,
        array(
            'label'        => esc_html__( 'Case Study Page ', 'fino' ) .$i,
            'section'      => 'fino_case_study',
            'type'         => 'dropdown-pages',
            'priority'     => 100,
        )
    );
    }
    /** Case Studyr Section Settings End **/

    /** Blog Section Settings Start **/

    $wp_customize->add_section('fino_blog_info', 
        array(
            'title'       => esc_html__('Home Blog Section', 'fino'),
            'description' => '',
            'panel'       => 'fino_frontpage',
            'priority'    => 160
        )
     );
    
    $wp_customize->add_setting('fino_blog_section_hideshow',
        array(
            'default'           => 'show',
            'sanitize_callback' => 'fino_sanitize_select',
        )
    );

    $fino_blog_section_hide_show_option = fino_section_choice_option();

    $wp_customize->add_control('fino_blog_section_hideshow',
        array(
            'type'        => 'radio',
            'label'       => esc_html__('Blog Option', 'fino'),
            'description' => esc_html__('Show/hide option for Blog Section.', 'fino'),
            'section'     => 'fino_blog_info',
            'choices'     => $fino_blog_section_hide_show_option,
            'priority'    => 1
        )
    );
    
    $wp_customize->add_setting('fino_blog_title', 
         array(
            'default'            => '',
            'type'               => 'theme_mod',
            'sanitize_callback'  => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control('fino_blog_title', 
        array(
            'label'    => esc_html__('Blog Title', 'fino'),
            'section'  => 'fino_blog_info',
            'priority' => 1
        )
    );
    
    $wp_customize->add_setting('fino_blog_subtitle', 
        array(
            'default'             => '',
            'type'                => 'theme_mod',
            'sanitize_callback'   => 'sanitize_text_field'
        )
    );

    $wp_customize->add_control('fino_blog_subtitle', 
        array(
            'label'    => esc_html__('Blog Subheading', 'fino'),
            'section'  => 'fino_blog_info', 
            'priority' => 4
        )
    );
    /** Blog Section Settings End **/

    /** Client Section Settings Start **/

    $wp_customize->add_section('fino_clients_logo', 
        array(
            'title'       => esc_html__('Clients logo Section', 'fino'),
            'description' => '',
            'panel'       => 'fino_frontpage', 
            'priority'    => 170
        )
    );

    $wp_customize->add_setting('fino_clients_section_hideshow',
        array(
            'default'          => 'hide',
           'sanitize_callback' => 'fino_sanitize_select',
        )
    );

  $fino_section_choice_option = fino_section_choice_option();

    $wp_customize->add_control('fino_clients_section_hideshow',
        array(
            'type'        => 'radio',
            'label'       => esc_html__('Clients-logo', 'fino'),
            'description' => esc_html__('Show/hide option for Clients-logo Section.', 'fino'),
            'section'     => 'fino_clients_logo',
            'choices'     => $fino_section_choice_option,
            'priority'    => 5
        )
    );

    // Clientss title

    $client_no = 5;
        for( $i = 1; $i <= $client_no; $i++ ) {
    $fino_client_logo = 'fino_client_logo_' . $i;   

    $wp_customize->add_setting( $fino_client_logo,
        array(
            'default'           => 1,
            'sanitize_callback' => 'fino_sanitize_dropdown_pages',
        )
    );

    $wp_customize->add_control( $fino_client_logo,
        array(
            'label'      => esc_html__( 'Client Page ', 'fino' ) .$i,
            'section'    => 'fino_clients_logo',
            'type'       => 'dropdown-pages',
            'priority'   => 100,
        )
    );

    }
    /** Client Section Settings End **/

    /** Footer Section Settings Start **/

	$wp_customize->add_section('fino_footer_info',
        array(
            'title'       => esc_html__('Footer Section', 'fino'),
            'description' => '',
            'panel'       => 'fino_frontpage',
            'priority'    => 180
        )
    );

    $wp_customize->add_setting('fino_footer_section_hideshow',
        array(
            'default'           => 'show',
            'sanitize_callback' => 'fino_sanitize_select',
        )
    );

    $fino_footer_section_hide_show_option = fino_section_choice_option();

    $wp_customize->add_control('fino_footer_section_hideshow',
        array(
            'type'        => 'radio',
            'label'       => esc_html__('Footer Option', 'fino'),
            'description' => esc_html__('Show/hide option for Footer Section.', 'fino'),
            'section'     => 'fino_footer_info',
            'choices'     => $fino_footer_section_hide_show_option,
            'priority'    => 1
        ) 
    );


      // column layout
    $wp_customize->add_setting('fino_column_layout',
        array(
            'default'           => '4',
            'sanitize_callback' => 'fino_column_layout_sanitize_select',
        )
    );

    $fino_footer_column_layout = fino_column_layout_option();

    $wp_customize->add_control('fino_column_layout',
        array(
            'type'        => 'radio',
            'label'       => esc_html__('Column Layout option ', 'fino'),
            'description' => '',
            'section'     => 'fino_footer_info',
            'choices'     => $fino_footer_column_layout,
            'priority'    => 2
            )
    );


    $wp_customize->add_setting('fino_footer_text',
         array(
            'default'             => '',
            'type'                => 'theme_mod',
            'sanitize_callback'   => 'wp_kses_post'
        )
    );

    $wp_customize->add_control('fino_footer_text',
         array(
            'label'    => esc_html__('Copyright', 'fino'),
            'section'  => 'fino_footer_info',
            'type'     => 'textarea',
            'priority' => 2
    ));

    /** Footer Section Settings End **/

}
add_action( 'customize_register', 'fino_customize_register' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class fino_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'fino_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new fino_Customize_Section_Pro(
				$manager,
				'example_1',
				array(
					'priority'   => 1,
					'title'    => esc_html__( 'Fino Pro Theme', 'fino' ),
					'pro_text' => esc_html__( 'Upgrade Pro', 'fino' ),
					'pro_url'  => esc_url('http://freepsdworld.com/themes/fino-pro/'),
				)
			)
		);
		// Register sections.
		$manager->add_section(
			new fino_Customize_Section_Pro(
				$manager,
				'example_2',
				array(
					'priority'   => 2,
					'title'    => esc_html__( 'Fino Doc', 'fino' ),
					'pro_text' => esc_html__( 'Documentation', 'fino' ),
					'pro_url'  => esc_url('http://freepsdworld.com/fino-free-wordpress-theme-722/'),
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {
		wp_enqueue_script( 'fino-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );
		
		wp_enqueue_style( 'fino-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
fino_Customize::get_instance();