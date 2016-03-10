<?php

function nextaudition_func(){
	$html ="";
	global $paged;
	// args
		$args = array(
			'posts_per_page'	=> 1,
			'post_type'		=> 'audition',
			'meta_query'	=> array(
				array(
					'key'		=> 'audition_start_date',
					'value'		=> date('Ymd'),
					'compare'	=> '<='
				)
			)
		);

		$query = new WP_Query( $args );
		if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); 
			$startDate = get_field('audition_start_date',$post->ID);
			$startDate = new DateTime($startDate);
			$endDate = get_field('audition_end_date',$post->ID);
			$endDate = new DateTime($endDate);

			$html .='<div>'.get_the_title().'</div>';
			$html .='<span>'.$startDate->format('M. d').'</span> - ';
			$html .='<span>'.$endDate->format('M. d, Y').'</span> at ';
			$html .='<span>'.$endDate->format('g a').'</span>';
			$html .='<div>'.get_the_excerpt().'</div>';
		endwhile; 
		else :
			$html .="no query";
		endif;
		 wp_reset_query();	 // Restore global post data stomped by the_post(). 

		 return $html;
}

add_shortcode( 'nextaudition', 'nextaudition_func' );