<?php

// Tell the main theme that a child theme is running. Do not remove this.
$GLOBALS['builder_child_theme_loaded'] = true;

// Load translations
load_theme_textdomain( 'it-l10n-Builder', get_stylesheet_directory() . '/lang' );

// Add Builder 3.0+ support
add_theme_support( 'builder-3.0' );

// Add support for responsive features
add_theme_support( 'builder-responsive' );


/**
 * Enqueue scripts and styles
 */
function enqeue_theme() {
	
	$bootstrap_version = '3.3.6';
	$fontawesome_version = '4.5.0';

	wp_enqueue_script( 'bootstrap-min-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/'.$bootstrap_version.'/js/bootstrap.min.js', array(), $bootstrap_version, true );
	wp_enqueue_style( 'bootstrap_css', 'https://maxcdn.bootstrapcdn.com/bootstrap/'.$bootstrap_version.'/css/bootstrap.min.css' );
	wp_enqueue_style( 'bootstrap_more_icons', '//netdna.bootstrapcdn.com/font-awesome/'.$fontawesome_version.'/css/font-awesome.css' );
	
	wp_enqueue_style( 'theme_css', get_template_directory_uri() .'-RacineTheatre/style-font.css');
	wp_enqueue_style( 'theme_css', get_template_directory_uri() .'-RacineTheatre/style-custom.css');
	wp_enqueue_style( 'theme_css', get_template_directory_uri() .'-RacineTheatre/style-admin.css');

}
add_action( 'wp_enqueue_scripts', 'enqeue_theme' );
