<?php 
function classes_list_func($atts){
	$s_arg = shortcode_atts( array(
        'count' => ''
    ), $atts );
	$html ="";

	$posts_per_page = $s_arg['count'];

	if (empty($posts_per_page)) {
		$posts_per_page = 1;
	}

	global $paged;
	// args
		$args = array(
			'posts_per_page'	=> $posts_per_page,
			'post_type'		=> 'class'
		);

		$query = new WP_Query( $args );
		$html .='<div class="class-list_wrapper table">';
			$html .='<ul class="class-list">';
			if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); 
				$html .='<li>';
					$html .='<a href="'.get_the_permalink().'">'.get_the_title().'</a>';
				$html .='</li>';
			endwhile; 
			$html .='</ul>';
		$html .='</div>';
		else :
			$html .="No spotlight available";
		endif;
		 wp_reset_query();	 // Restore global post data stomped by the_post(). 

		 return $html;
}

add_shortcode( 'classes_list', 'classes_list_func' );