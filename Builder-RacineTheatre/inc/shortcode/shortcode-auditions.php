<?php

function auditionlist_func($atts){
	$s_arg = shortcode_atts( array(
        'limit' => '',
        'type' => ''
    ), $atts );
	$html ="";

	$posts_per_page = $s_arg['limit'];
	$type = $s_arg['type'];
	$header = "";

	if (empty($type)) {
		$type = '<=';
		$header = 'PRESENT AUDITIONS';
	} elseif($type=='next'){
		$type = '<=';
		$header = 'PRESENT AUDITIONS';
	} elseif($type=='future'){
		$type = '>';
		$header = 'FUTURE AUDITIONS';
	}

	if (empty($posts_per_page)) {
		$posts_per_page = 1;
	}
	global $paged;
	// args
		$args = array(
			'posts_per_page'	=> $posts_per_page,
			'post_type'		=> 'audition',
			'meta_query'	=> array(
				'relation'  =>   'AND',
				array(
					'key'		=> 'audition_start_date',
					'value'		=> date('Ymd'),
					'compare'	=> $type
				)
			),
			'order'=>'ASC',
        	'paged' =>$paged
		);

		$query = new WP_Query( $args );
		$html .='<div class="audition_wrapper">';
			$html .='<div class="a_header"><u>'.$header.':</u></div>';
			if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); 
			
				$remark = get_field('remark',get_the_ID());
				$startDate = get_field('audition_start_date',get_the_ID());
				$startDate = new DateTime($startDate);
				$endDate = get_field('audition_end_date',get_the_ID());
				$endDate = new DateTime($endDate);

				$html .='<div class="audition_list_wrap">';
					$html .='<div class="a_title"><strong>'.get_the_title().'</strong></div>';
					$html .='<span>'.$startDate->format('M. d').'</span> - ';
					$html .='<span>'.$endDate->format('M. d, Y').'</span> at ';
					$html .='<span>'.$endDate->format('g a').'</span>';
					$html .='<div class="a_excerpt">'.$remark.'</div>';
					$html .='<div class="vc_btn3-container vc_btn3-center a_button"><a class="vc_general  vc_btn3 vc_btn3-size-xs vc_btn3-shape-square vc_btn3-style-outline vc_btn3-block vc_btn3-icon-left vc_btn3-color-black" href="'.get_the_permalink().'" title="" target="_self"><i class="vc_btn3-icon fa fa-plus"></i> AUDITION DETAILS</a></div>';
				$html .='</div>';
			endwhile; 
		else :
			$html .="No available audition";
		endif;
		
		wp_reset_query();	 // Restore global post data stomped by the_post(). 
		$html .='</div>';
		 return $html;

}

add_shortcode( 'auditionlist', 'auditionlist_func' );


function audition_dates($ID){
	$html ="";

	$startDate = get_field('audition_start_date',$ID);
	$startDate = new DateTime($startDate);
	$endDate = get_field('audition_end_date',$ID);
	$endDate = new DateTime($endDate);

	$html .='<span>'.$startDate->format('M. d').'</span> - ';
	$html .='<span>'.$endDate->format('M. d, Y').'</span> at ';
	$html .='<span>'.$endDate->format('g a').'</span>';

	return $html;

}
