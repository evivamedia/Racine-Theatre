<?php


function prod_template($filter){
global $wp_theatre;
$html .='<section class="upcoming_productions_row productions_row sameheight vc_row wpb_row vc_row-fluid">';
$count = 0;

foreach ($wp_theatre->productions -> get($filter) as $production) {
	$productionID = $production->ID;
	$thumbnailID = $production->thumbnail();
	$posterURL = wp_get_attachment_url($thumbnailID);	
	$postersmallURL = get_field('production_small_thumbnail',$productionID);
	$title  = $production->title();
	$excerpt = $production->excerpt(array('words' => 20));
	$dates = get_startDate($productionID,'F d').' - '.get_endDate($productionID,'F d');
	$permalink = $production->permalink();
	$mainticketURL = get_field('main_ticket_url',$productionID);
	if(empty($mainticketURL)){$mainticketURL = $production->permalink(); $target="_self";}
	$mainticketLABEL = get_field('main_ticket_label',$productionID);
	if(empty($mainticketLABEL)){$mainticketLABEL = "Buy Ticket";}

	$html .='<div class=" production_column wpb_column vc_column_container vc_col-md-3 vc_col-sm-6 vc_col-xs-12">';
					$html .='<div class="vc_column-inner">';
						$html .='<div class="production_wrapper">';
							$html .='<div class="p_image"><img src="'.$postersmallURL.'" /></div>';
							$html .='<div class="p_content">';
								$html .='<div class="p_content_meta">';
									$html .='<div class="p_title"><h4>'.$title.'</h4></div>';
									$html .='<div class="p_excerpt">'.$excerpt.'</div>';
								$html .='</div>';
								$html .='<div class="p_info_meta">';
									$html .='<div class="p_date">'.$dates.'</div>';
									$html .='<div class="p_mi"><a href="'.$permalink.'">More Info</a></div>';
									//$html .='<div class="p_ticketbutton"><a href="'.$mainticketURL.'" target="'.$target.'">'.$mainticketLABEL.'</a></div>';
									$html .= prod_ticketbutton($productionID);
								$html .='</div>';
							$html .='</div>';
						$html .='</div>';	
					$html .='</div>';	
	$html .='</div>';

	$count++;
	if($count %4 == 0):
		$html .='<section class="upcoming_productions_row productions_row sameheight vc_row wpb_row vc_row-fluid">';
	endif;
}
	$html .='</section>';
	return $html;

}

function productions_func($atts){
	$arg = shortcode_atts( array(
        'limit' => '',
        'date' => '',
        'productionIDsearch' =>'',
        'type' => ''
    ), $atts );
    $limit = $arg['limit'];
    if (empty($limit)) {
    	$limit = -1;
    }

    //Search by Month
    $search_startDate = date('Y-m-d', strtotime($arg['date']));
	$search_endDate = date('Y-m-d', strtotime($arg['date'].' + 1 month'));
	$filter = array('start' => 'now', 'limit'=> $limit );

	if($arg['type']=="season"):
		$season = $_GET['season'];
		$filter = array('season' => $season );
		if(!empty($season)):
	   		$filter = array('season' => $season );
	   	else:
	    	$filter = array('season' => get_currentseason() );
		endif;
	endif;

	if($arg['type']==""):
		$category = $_GET['category'];
		if(!empty($category)):
	   	 $filter = array('start' => 'now','category_name' =>$category );
		endif;

	    if( $category == 'all' ):
			$filter = array('start' => 'now', 'limit'=> $limit );
		endif;
	endif;

	//SEARCH
	if($arg['type']=="search"):
		if(!empty($arg['date']) && empty($arg['productionIDsearch'])):
			$filter = array('start' =>$search_startDate,'end' =>$search_endDate, 'limit'=> $limit );
		endif;
		if(!empty($arg['productionIDsearch'])):
			$filter = array('post__in' => $arg['productionIDsearch']);
		endif;
		if(!empty($arg['productionIDsearch']) && !empty($arg['date'])):
			$filter = array('post__in' => $arg['productionIDsearch'], 'start' =>$search_startDate,'end' =>$search_endDate);
		endif;
	endif;
	//END SEARCH


	$html = prod_template($filter);
	return $html;

}

add_shortcode( 'productions', 'productions_func' );

function upcomingproduction_func($atts){
	$arg = shortcode_atts( array(
        'limit' => ''
    ), $atts );
    $limit = $arg['limit'];
    if (empty($limit)) {
    	$limit = -1;
    }

	$filter = array('start' => 'now', 'limit'=> $limit );

	$html = prod_template($filter);
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
			$production_banner = get_field('production_banner',$productionID);
			if(!empty($production_banner)):
				$postersmallURL = $production_banner;
			else:
				$postersmallURL = get_field('production_small_thumbnail',$productionID);
			endif;

			$mainticketURL = get_field('main_ticket_url',$productionID);
			if(empty($mainticketURL)){$mainticketURL = $production->permalink(); $target="_self";}
			$mainticketLABEL = get_field('main_ticket_label',$productionID);
			if(empty($mainticketLABEL)){$mainticketLABEL = "Buy Ticket";}



			//if(prod_ended($production->ID)):
				$html .='<div class="production_column wpb_column vc_column_container vc_col-md-4 vc_col-sm-12 vc_col-xs-12" style="background:url('.$postersmallURL.') 50%;	;background-size:cover;">';
					$html .='<div class="vc_column-inner">';
						$html .='<div class="production_wrapper">';
							$html .='<div class="p_content white-scheme">';
								$html .='<div class="p_content_meta">';
									$html .='<div class="p_title"><h4>'.$production->title().'</h4></div>';
								$html .='</div>';
								$html .='<div class="p_info_meta">';
								$endDate = get_endDate($productionID,'F Y');
									if(!empty($endDate)){
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

function get_season_categories_func(){
	global $wp_theatre;
	$seasons = $wp_theatre->productions->get_seasons();
	$html='';
	//CATEGORY LIST
	$html .='<ul class="pro_cat-container">';
		while ($seasons_name = current($seasons)) {
			$html.='<li class="prod_cat"><a href="?season='.key($seasons).'">'.$seasons_name.'</a></li>';
		    next($seasons);
		}
	$html .='</ul>';
	return $html;
}
add_shortcode( 'get_season_categories', 'get_season_categories_func' );

function get_currentseason(){
	global $wp_theatre;
	$current_seasonID = "";
	$seasons = $wp_theatre->productions->get_seasons();
	//reset($seasons);
//	return $current_seasonID = key($seasons);

	while ($seasons_name = current($seasons)) {
		$currentyear = date('Y');

		if(strpos($seasons_name,$currentyear) !== false) {
            return key($seasons);
        } 
		next($seasons);
	}
}



add_shortcode( 'pastproduction', 'pastproduction_func' );

function get_endDate($ID,$format){
	global $wp_theatre;
	$filter = array( 'production' => $ID );
	$endDate = "";
	foreach ($wp_theatre->productions->get($filter) as $production) {
		$event_filter = array('production' => $ID);
		foreach ($wp_theatre->events-> get($event_filter) as $event) {
			$endDates[] = $event->enddate();	
		}
		$endDate = new DateTime(end($endDates));
		$endDate = $endDate->format($format);		
	}
	return $endDate;
}

function get_startDate($ID,$format){
	global $wp_theatre;
	$filter = array( 'production' => $ID );
	$startDate = "";
	foreach ($wp_theatre->productions->get($filter) as $production) {
		$event_filter = array('production' => $ID);
		foreach ($wp_theatre->events-> get($event_filter) as $event) {
			$startDates[] = $event->startdate();	
		}
		$startDate = new DateTime($startDates[0]);
		$startDate = $startDate->format($format);		
	}

	return $startDate;
}

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
			$isShow = get_field('shows_flag',$productionID);
			$target = "_BLANK";
			$mainticketLABEL = get_field('main_ticket_label',$productionID);
			if(empty($mainticketLABEL)){$mainticketLABEL = "Buy Ticket";}
			if(!$isShow):
				$html .='<div class="p_ticketbutton"><a href="'.$production->permalink().'">Buy Ticket</a></div>';
			else:
				$html .='<div class="p_ticketbutton"><a href="'.$production->permalink().'">See Shows</a></div>';
			endif;
		}
	endif;

	return $html;
}


