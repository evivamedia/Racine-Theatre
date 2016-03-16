<?php 

function spotlight_func($atts){
	$s_arg = shortcode_atts( array(
        'limit' => '',
        'link' =>''
    ), $atts );
	$html ="";

	$posts_per_page = $s_arg['limit'];

	if (empty($posts_per_page)) {
		$posts_per_page = 1;
	}

	global $paged;
	// args
		$args = array(
			'posts_per_page'	=> $posts_per_page,
			'post_type'		=> 'spotlight'
		);

		$query = new WP_Query( $args );
		$html .='<div class="spotlight_wrapper table">';

			if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); 
				$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

				$html .='<div class="spotlight table-row">';
					$html .='<div class="s_image  table-cell"><img src="'.$feat_image.'" /></div>';
					$html .='<div class="s_content_wrapper table-cell">';
						$html .='<div class="s_content white-scheme">';
							$html .='<div class="s_title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></div>';
							$html .='<div class="s_excerpt">'.get_the_excerpt().' <a href="'.get_the_permalink().'">Read more</a></div>';
							$html .='<div class="vc_btn3-container vc_btn3-center s_button"><a class="vc_general  vc_btn3 vc_btn3-size-xs vc_btn3-shape-square vc_btn3-style-outline vc_btn3-block vc_btn3-color-white" href="'.$s_arg['link'].'" title="" target="_self">Click here to Volunteer</a></div>';
						$html .='</div>';
					$html .='</div>';
				$html .='</div>';
			endwhile; 
		$html .='</div>';
		else :
			$html .="No spotlight available";
		endif;
		 wp_reset_query();	 // Restore global post data stomped by the_post(). 

		 return $html;
}

add_shortcode( 'spotlight', 'spotlight_func' );

