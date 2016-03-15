<?php 

function socialicons_func($atts){
	$link = shortcode_atts( array(
        'facebook' => '',
        'googleplus' => '',
        'twitter' => '',
        'youtube' => '',
        'linkedin' => '',
        'pinterest' => '',
        'yelp' => '',
    ), $atts );


	$html='';
	$html.='<ul class="social-list">';
		$html.='<li><a href="'.$link['facebook'].'" target="_BLANK"><i class="fa fa-facebook"></i></a></li>';
		$html.='<li><a href="'.$link['googleplus'].'" target="_BLANK"><i class="fa fa-google-plus"></i></a></li>';
		$html.='<li><a href="'.$link['twitter'].'" target="_BLANK"><i class="fa fa-twitter"></i></a></li>';
		$html.='<li><a href="'.$link['youtube'].'" target="_BLANK"><i class="fa fa-youtube-play"></i></a></li>';
		$html.='<li><a href="'.$link['linkedin'].'" target="_BLANK"><i class="fa fa-linkedin"></i></a></li>';
		$html.='<li><a href="'.$link['pinterest'].'" target="_BLANK"><i class="fa fa-pinterest"></i></a></li>';
		$html.='<li><a href="'.$link['yelp'].'" target="_BLANK"><i class="fa fa-yelp"></i></a></li>';
	$html.='</ul>';

	return $html;
}

add_shortcode( 'socialicons', 'socialicons_func' );

