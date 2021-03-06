<?php

// Tell the main theme that a child theme is running. Do not remove this.
$GLOBALS['builder_child_theme_loaded'] = true;

// Load translations
load_theme_textdomain( 'it-l10n-Builder', get_stylesheet_directory() . '/lang' );

// Add Builder 3.0+ support
add_theme_support( 'builder-3.0' );

// Add support for responsive features
add_theme_support( 'builder-responsive' );


$siteChild = 'RacineTheatre';

/**
 * Enqueue scripts and styles
 */
function enqeue_theme() {
	$siteChild = 'RacineTheatre';

	wp_enqueue_script( 'datepicker', get_template_directory_uri() .'-'.$siteChild.'/js/jquery-ui.min.js', array(), 1.11, true );
	wp_enqueue_script( 'site-js', get_template_directory_uri() .'-'.$siteChild.'/js/site-script.js', array(), 1.0, true );
	wp_enqueue_script( 'addthis', '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-56e0dffe8d10da87', array(), 1.0, true );
	wp_enqueue_style( 'bootstrap_more_icons', '//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css' );
	wp_enqueue_style( 'visualcomposer_css', ''.get_site_url().'/wp-content/plugins/js_composer/assets/css/js_composer.min.css' );


	wp_enqueue_style( 'theme_font', get_template_directory_uri() .'-'.$siteChild.'/style-font.css');
	wp_enqueue_style( 'theme_css', get_template_directory_uri() .'-'.$siteChild.'/style-custom.css');

}
add_action( 'wp_enqueue_scripts', 'enqeue_theme' );


/**
 * Admin Enqueue scripts and styles
 */      
function load_admin_style() {
	$siteChild = 'RacineTheatre';
	wp_register_style( 'admin_css', get_template_directory_uri().'-'.$siteChild.'/style-admin.css', false, '1.0.0' );
	wp_enqueue_style( 'admin_css' );
}
add_action( 'admin_enqueue_scripts', 'load_admin_style' );

/*ENABLE VC in Custom post widget*/
function demomentsomtres_filter_content_block_init() {
	$content_block_public = true;
	return $content_block_public;
}
add_filter('content_block_post_type','demomentsomtres_filter_content_block_init');



/**
 * Widget Naming
 */

if ( ! function_exists( 'it_builder_loaded' ) ) {
	function it_builder_loaded() {
		builder_register_module_style( 'widget-bar', 'Top Bar', 'topbar' );
		builder_register_module_style( 'widget-bar', 'Header', 'header' );
		builder_register_module_style( 'widget-bar', 'Navigation', 'navigation' );
		builder_register_module_style( 'widget-bar', 'Sub Footer Widget', 'sub_footer_widget' );
		builder_register_module_style( 'widget-bar', 'Footer Widget', 'footer_widget' );
	}
	add_action( 'it_libraries_loaded', 'it_builder_loaded' );
}

/*FULLWIDTH*/
function it_set_full_width_container( $width ) {
	remove_filter( 'builder_get_container_width', 'it_set_full_width_container' );
	
	return '';
}
add_filter( 'builder_get_container_width', 'it_set_full_width_container' );

function it_set_full_width_module( $fields ) {

	global $it_original_module_width;
	
	$it_original_module_width = '';
	
	foreach ( (array) $fields['attributes']['style'] as $index => $value ) {
		if ( preg_match( '/^(width:.+)/i', $value, $matches ) ) {
			$it_original_module_width = $matches[1];
			unset( $fields['attributes']['style'][$index] );
		}
		if ( preg_match( '/^overflow:/', $value ) ) {
			unset( $fields['attributes']['style'][$index] );
			$fields['attributes']['style'][] = 'overflow:visible;';
		}
	}
	add_filter( 'builder_module_filter_inner_wrapper_attributes', 'it_constrain_full_width_module_inner_wrapper' );
	
	return $fields;
}
add_filter( 'builder_module_filter_outer_wrapper_attributes', 'it_set_full_width_module' );

function it_constrain_full_width_module_inner_wrapper( $fields ) {
	global $it_original_module_width;
	
	remove_filter( 'builder_module_filter_inner_wrapper_attributes', 'it_constrain_full_width_module_inner_wrapper' );
	
	$fields['attributes']['style'][] = $it_original_module_width;
	$fields['attributes']['style'][] = 'margin:0 auto;';
	
	$it_original_module_width = ''; 
	
	return $fields;
}

function currentDate(){
	return date('Y');
}

add_shortcode('currentdate', 'currentDate');

//ADD SHORTCODE [productionsearchform]
include( get_template_directory().'-'.$siteChild.'/inc/shortcode/shortcode-searchform.php' );

//ADD LIST oFSHORTCODE for PRODUCTION eg [upcomingproduction]
include( get_template_directory().'-'.$siteChild.'/inc/shortcode/shortcode-productions.php' );

//ADD LIST oF SHORTCODE for audition eg [nextaudition]
include( get_template_directory().'-'.$siteChild.'/inc/shortcode/shortcode-auditions.php' );

//ADD LIST oF SHORTCODE for spotlight eg [spotlight]
include( get_template_directory().'-'.$siteChild.'/inc/shortcode/shortcode-spotlight.php' );

//ADD LIST oF SHORTCODE for classes eg [classes_list]
include( get_template_directory().'-'.$siteChild.'/inc/shortcode/shortcode-class.php' );

//ADD LIST oF SHORTCODE for socialicons eg [socialicons]
include( get_template_directory().'-'.$siteChild.'/inc/shortcode/shortcode-socialicons.php' );

//ADD LIST oF SHORTCODE for socialicons eg [events_table]
include( get_template_directory().'-'.$siteChild.'/inc/shortcode/shortcode-events.php' );

//ADD LIST oF SHORTCODE for calendar eg [prod_calendar]
include( get_template_directory().'-'.$siteChild.'/inc/shortcode/shortcode-calendar.php' );

