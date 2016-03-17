<?php 

//CALENDAR APPLY FILTER

function wpt_calendar_html_day_link_filter($day_link, $day, $day_url, $day_label, $events){
	$eventstarttime = $events[0]->starttime();
	$eventTitle = $events[0]->title();
	$day_url = $events[0]->production()->permalink();

	$html = '<a href="'.$day_url.'">';
	$html.= $day_label;						
	$html.= '</a>';
	$html.= '<div class="cal-prod_starttime">'.$eventstarttime.'</div>';
	$html.= '<div class="cal-prod_title"><a href="'.$day_url.'">'.$eventTitle.'</a></div>';
	$html.= '<div class="cal-prod_moreinfo"><a href="'.$day_url.'">More Info</a></div>';
	return $html;
}

add_filter( 'wpt_calendar_html_day_link', 'wpt_calendar_html_day_link_filter',10,5);