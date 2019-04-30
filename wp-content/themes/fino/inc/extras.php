<?php
/**
 * Functions hooked to core hooks.
 *
 */

if ( ! function_exists( 'fino_customize_search_form' ) ) :

	function fino_customize_search_form() {

		$form = '<form role="search" method="get" class="side-form" action="' . esc_url( home_url( '/' ) ) . '">
					<input type="search"  placeholder="' . esc_attr_x( ' search here', 'placeholder', 'fino' ) . '" value="' . get_search_query() . '" name="s" title="' . esc_attr_x( 'Search for:', 'label', 'fino' ) . '" />
					
					<button type="submit">
						<i class="fa fa-search"></i>
					</button>  
		        </form>';
		return $form;
	}
	
endif;

add_filter( 'get_search_form', 'fino_customize_search_form', 15 );
?>