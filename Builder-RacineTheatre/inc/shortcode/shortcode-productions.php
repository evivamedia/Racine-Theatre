<?php


function upcomingproduction_func($atts){
	$arg = shortcode_atts( array(
        'limit' => ''
    ), $atts );

	$get_arg = array('start' => 'now' );
	$productions = new WPT_Productions();
	$target="_blank";

	$html ='';
	$html .='<section class="productions_row  vc_row wpb_row vc_row-fluid">';

		foreach ($productions -> get($get_arg) as $production) {
			$productionID = $production->ID;
			$thumbnailID = $production->thumbnail();
			$posterURL = wp_get_attachment_url($thumbnailID);	
			$postersmallURL = get_field('production_small_thumbnail',$productionID);
			$mainticketURL = get_field('main_ticket_url',$productionID);
			if(empty($mainticketURL)){$mainticketURL = $production->permalink(); $target="_self";}
			$mainticketLABEL = get_field('main_ticket_label',$productionID);
			if(empty($mainticketLABEL)){$mainticketLABEL = "Buy Ticket";}


			$html .='<div class="production_column wpb_column vc_column_container vc_col-md-3 vc_col-sm-6 vc_col-xs-12">';
				$html .='<div class="vc_column-inner">';
					$html .='<div class="production_wrapper">';
						$html .='<div class="p_image"><img src="'.$postersmallURL.'" /></div>';
						$html .='<div class="p_content">';
							$html .='<div class="p_content_meta">';
								$html .='<div class="p_title"><h4>'.$production->title().'</h4></div>';
								$html .='<div class="p_excerpt">'.$production->excerpt().'</div>';
							$html .='</div>';
							$html .='<div class="p_info_meta">';
								$html .='<div class="p_date">'.$production->dates().'</div>';
								$html .='<div class="p_mi"><a href="'.$production->permalink().'">More Info</a></div>';
								$html .='<div class="p_ticketbutton"><a href="'.$mainticketURL.'" target="'.$target.'">'.$mainticketLABEL.'</a></div>';
							$html .='</div>';
						$html .='</div>';
					$html .='</div>';	
				$html .='</div>';	
			$html .='</div>';
		}

	$html .='</section>';

	//print_r($production->get_events());
	return $html;

}

add_shortcode( 'upcomingproduction', 'upcomingproduction_func' );


