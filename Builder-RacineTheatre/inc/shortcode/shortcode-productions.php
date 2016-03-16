<?php

function productions_func($atts){
	$arg = shortcode_atts( array(
        'limit' => '',
        'date' => '',
        'productionIDsearch' =>''
    ), $atts );
    $limit = $arg['limit'];
    if (empty($limit)) {
    	$limit = -1;
    }
    $category = $_GET['category'];

    $filter = array('start' => 'now','category_name' =>$category );

    if(empty($category) || $category == 'all'):
		$filter = array('start' => 'now', 'limit'=> $limit );
	endif;

	//SEARCH
	if(!empty($arg['date']) && empty($arg['productionIDsearch'])):
		$filter = array('start' => $arg['date'], 'limit'=> $limit );
	endif;
	if(!empty($arg['productionIDsearch'])):
		$filter = array('post__in' => $arg['productionIDsearch']);
	endif;
	if(!empty($arg['productionIDsearch']) && !empty($arg['date'])):
		$filter = array('post__in' => $arg['productionIDsearch'], 'start' => $arg['date']);
	endif;
	//END SEARCH


	$productions = new WPT_Productions();
	$events = new WPT_Events();

	$target="_blank";
	$startDates = array();

	$html ='';

	$html .='<section class="productions_row sameheight vc_row wpb_row vc_row-fluid">';
	$count = 0;
		foreach ($productions -> get($filter) as $production) {
			$productionID = $production->ID;
			$thumbnailID = $production->thumbnail();
			$posterURL = wp_get_attachment_url($thumbnailID);	
			$postersmallURL = get_field('production_small_thumbnail',$productionID);
			$mainticketURL = get_field('main_ticket_url',$productionID);
			if(empty($mainticketURL)){$mainticketURL = $production->permalink(); $target="_self";}
			$mainticketLABEL = get_field('main_ticket_label',$productionID);
			if(empty($mainticketLABEL)){$mainticketLABEL = "Buy Ticket";}

			$event_filter = array('production' => $production->ID);
			foreach ($events -> get($event_filter) as $event) {
					$startDates[] = $event->startdate();			
			}

		if(!empty($arg['date'])):
			$startDate = new DateTime(end($startDates));
			$startDate = $startDate->format('mY');
			$dateSearch = new DateTime($arg['date']);
			$dateSearch = $dateSearch->format('mY');

			if($startDate <= $dateSearch ):	
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
									//$html .='<div class="p_ticketbutton"><a href="'.$mainticketURL.'" target="'.$target.'">'.$mainticketLABEL.'</a></div>';
									$html .= prod_ticketbutton($productionID);
								$html .='</div>';
							$html .='</div>';
						$html .='</div>';	
					$html .='</div>';	
				$html .='</div>';
			endif;
		else:
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
									//$html .='<div class="p_ticketbutton"><a href="'.$mainticketURL.'" target="'.$target.'">'.$mainticketLABEL.'</a></div>';
									$html .= prod_ticketbutton($productionID);
								$html .='</div>';
							$html .='</div>';
						$html .='</div>';	
					$html .='</div>';	
			$html .='</div>';
		endif;
		$count++;
		}

	$html .='</section>';

	if($count==0):
		$html="";
	endif;
	return $html;
	$count=0;
}

add_shortcode( 'productions', 'productions_func' );

function get_production_categories_func(){
	$productions = new WPT_Productions();
	$html='';
	//CATEGORY LIST
	$html .='<ul class="pro_cat-container">';
		$html.='<li class="prod_cat"><a href="?category=all">All Categories</a></li>';
		foreach ($productions -> get_categories('category_name') as $category) {
			$html.='<li class="prod_cat"><a href="?category='.$category.'">'.$category.'</a></li>';
		}
	$html .='</ul>';
	return $html;
}
add_shortcode( 'get_production_categories', 'get_production_categories_func' );

function upcomingproduction_func($atts){
	$arg = shortcode_atts( array(
        'limit' => ''
    ), $atts );
    $limit = $arg['limit'];
    if (empty($limit)) {
    	$limit = -1;
    }

	$filter = array('start' => 'now', 'limit'=> $limit );
	$productions = new WPT_Productions();
	$target="_blank";

	$html ='';
	$html .='<section class="productions_row sameheight vc_row wpb_row vc_row-fluid">';

		foreach ($productions -> get($filter) as $production) {
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
								//$html .='<div class="p_ticketbutton"><a href="'.$mainticketURL.'" target="'.$target.'">'.$mainticketLABEL.'</a></div>';
								$html .= prod_ticketbutton($productionID);
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


function pastproduction_func($atts){
	$arg = shortcode_atts( array(
        'limit' => ''
    ), $atts );
    $limit = $arg['limit'];
    if (empty($limit)) {
    	$limit = -1;
    }

	$productions = new WPT_Productions();
	$events = new WPT_Events();

	$filter = array('end' => 'now','limit'=> $limit );

	$target="_blank";
	$endDates = array();
	$endDate="";
	$html ='';
	$html .='<section class="past_production productions_row vc_row-o-equal-height vc_row-o-content-bottom vc_row-flex vc_row wpb_row vc_row-fluid">';

		foreach ($productions -> get($filter) as $production) {
			$productionID = $production->ID;
			$thumbnailID = $production->thumbnail();
			$posterURL = wp_get_attachment_url($thumbnailID);	
			$postersmallURL = get_field('production_small_thumbnail',$productionID);
			$mainticketURL = get_field('main_ticket_url',$productionID);
			if(empty($mainticketURL)){$mainticketURL = $production->permalink(); $target="_self";}
			$mainticketLABEL = get_field('main_ticket_label',$productionID);
			if(empty($mainticketLABEL)){$mainticketLABEL = "Buy Ticket";}

			$event_filter = array('production' => $production->ID);
			foreach ($events -> get($event_filter) as $event) {
				$endDates[] = $event->enddate();			
			}

			//if(prod_ended($production->ID)):
				$html .='<div class="production_column wpb_column vc_column_container vc_col-md-4 vc_col-sm-12 vc_col-xs-12" style="background:url('.$postersmallURL.');background-size:cover;">';
					$html .='<div class="vc_column-inner">';
						$html .='<div class="production_wrapper">';
							$html .='<div class="p_content white-scheme">';
								$html .='<div class="p_content_meta">';
									$html .='<div class="p_title"><h4>'.$production->title().'</h4></div>';
								$html .='</div>';
								$html .='<div class="p_info_meta">';
									if(!empty($endDates)){
											$endDate = new DateTime(end($endDates));
											$endDate = $endDate->format('F Y');
											$html .='<div class="p_date">'.$endDate.'</div>';
									}	
									$html .='<div class="p_mi"><a href="'.$production->permalink().'">More Info</a></div>';
								$html .='</div>';
							$html .='</div>';
						$html .='</div>';	
					$html .='</div>';	
				$html .='</div>';
			//endif;
		}

	$html .='</section>';

	return $html;

}

add_shortcode( 'pastproduction', 'pastproduction_func' );

function prod_ended($productionID){
	$events = new WPT_Events();
	$eventDate = array();
	$today = date('Ymd');

	$event_filter = array('production' => $productionID);
	foreach ($events -> get($event_filter) as $event) {
		$endDate = new DateTime($event->enddate());
		$eventDate[] = $endDate->format('Ymd');
	}

	if(end($eventDate) < $today):
		return true;
	elseif($eventDate[0] >= $today):
		return false;
	endif;
}

function prod_ticketbutton($productionID){
	$productions = new WPT_Productions();
	$productionIDs = array();
	$productionIDs[0] = $productionID;

	$html ="";
	$production_filter = array('post__in' => $productionIDs);

	if(!prod_ended($productionID)):
		foreach ($productions -> get($production_filter) as $production) {
			$mainticketURL = get_field('main_ticket_url',$productionID);
			$target = "_BLANK";
			if(!empty($mainticketURL)):
				//if(empty($mainticketURL)){$mainticketURL = $production->permalink(); $target = "_SELF";}
				$mainticketLABEL = get_field('main_ticket_label',$productionID);
				if(empty($mainticketLABEL)){$mainticketLABEL = "Buy Ticket";}
				$html .='<div class="p_ticketbutton"><a href="'.$mainticketURL.'" target="'.$target.'">'.$mainticketLABEL.'</a></div>';
			endif;
		}
	endif;

	return $html;
}


