<?php 

function events_table_func($atts){
	$arg = shortcode_atts( array(
        'limit' => '',
        'production' => ''
    ), $atts );
    $limit = $arg['limit'];
    if (empty($limit)) {
    	$limit = 4;
    }
  	 
    if(prod_ended($arg['production'])):
    	$get_arg = array('production' => $arg['production']);
    else:
    	$get_arg = array('production' => $arg['production'], 'start'=> 'now');
   	endif;

	
	$events = new WPT_Events();
	$target="_blank";

	$html ='';
	if(count($events -> get($get_arg)) > 4):
	$html .='<a class="table-e-button-nav" id="previous-column" href="#">Previous</a>';
  	$html .='<a class="table-e-button-nav" id="next-column" href="#">Next</a>';
  	endif;
	$html .='<div class="events_table-container">';
	$html .='<table class="events_table" id="prod_e_table">';

		$html.=' <thead><tr class="e_days">';
			foreach ($events -> get($get_arg) as $event) {
				$startDate = new DateTime($event->startdate());
					$html.='<th>';
						$html.='<div class="e_day">'.$startDate->format('D').'</div>';
						$html.='<div class="e_months">'.$startDate->format('M j').'</div>';
					$html.='</th>';
			}
		$html.='</tr> </thead>';

		$html.=' <tbody><tr class="e_times text-center">';
			foreach ($events -> get($get_arg) as $event) {
				$ticketURL = $event->tickets();
				$startTIME = new DateTime($event->starttime());
				$endTIME = new DateTime($event->endtime());
					$html.='<td>';
						$html.='<div class="e_starttime">'.$startTIME->format('g:i A').'</div>';
						$html.='<div class="e_remark">'.$event->remark().'</div>';
						//if(!empty($ticketURL) && !prod_ended($arg['production'])): $html.='<div class="e_ticket"><a href="'.$ticketURL.'" class="wp_theatre_integrationtype_lightbox" target="_BLANK">Buy Ticket</a></div>'; endif;
						if(!prod_ended($arg['production'])):
							$html.='<div class="e_ticket">';
								$html.=$event->tickets_html();
							$html .='</div>';
						endif;
					$html.='</td>';	
			}
		$html.='</tr> </tbody>';

	$html .='</table>';
	$html .='</div>';
	//print_r($events);
	return $html;

}

add_shortcode( 'events_table', 'events_table_func' );


function event_startDate($production){
	$events = new WPT_Events();
	$eventDate = array();
	$get_arg = array('production' => $production);
	foreach ($events -> get($get_arg) as $event) {
		$eventDate[] =  $event->startdate();
	}

	return $eventDate[0];
}

function tickets_button_filter($tickets_button, $this){
	if ( $tickets_button =="Tickets"  ) {
			$tickets_button = __( 'Buy Tickets', 'theatre' );
	}
	return ($tickets_button);
}

add_filter( 'wpt/event/tickets/button', 'tickets_button_filter',10,2);