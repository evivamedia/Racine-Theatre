<?php

	/**
	 * A calendar with upcoming events.
	 * @since 0.8
	 */
	class PROD_Calendar {
	
		/**
		 * Add hooks to init the [wpt_calendar] shortcode and the Theater Calendar widget.
		 */
	
		function __construct() {
			add_shortcode('prod_calendar', array($this,'shortcode'));
		}
		
		/**
		 * Gets the HTML version for the calendar.
		 *
		 * @see WPT_Calendar::check_dependencies()	To check if all dependencies are set.
		 * @see WPT_Events::get_months()			To retrieve all months with upcoming events.
		 * @see WPT_Events::get()					To retrieve all upcoming events.
		 * @see WPT_Listing_Page::url()				To retrieve the URL of the listing page.
		 * @see WPT_Event::datetime()				To collect the dates for upcoming events.
		 * @see WPT_Production::permalink()			To get the permalink for an event.
		 *
		 * @since	 0.8
		 * @since 	0.10.6	Bugfix: calendar was showing months that have historic events.
		 *					See https://wordpress.org/support/topic/calendar-wrong-month-shown-again.
		 * @since 	0.10.15	Bugfix: now accounts for timezones.
		 *					Fixes #117.
		 * @since	0.13.3	Bugfix: weekdays were showing up as question marks when using 
		 *					a multibyte languege (eg. Russian).
		 * 					Fixes #174.
		 *
		 * @return string The HTML for the calendar.
		 */
		function html() {
			global $wp_locale;
			
			if (!$this->check_dependencies()) {
				return '';
			}
		
			global $wp_theatre;
			
			// Get all months from now to the month of the last event.
			$filters = array(
				'limit' => 'now',
			);
			$months = $wp_theatre->events->get_months($filters);
			$months = array_keys($months);			
						
			$start_of_week = get_option('start_of_week');
	
			$thead_html = '<thead><tr>';
			$sunday = strtotime('next Sunday');
			for($i=0;$i<7;$i++) {
				$thead_html.= '<th>';
				$thead_html.= $wp_locale->get_weekday_initial( date_i18n('l',$sunday + ($start_of_week * 60 * 60 * 24) + ($i * 60 * 60 * 24)) );
				$thead_html.= '</th>';
			}
			$thead_html.= '</tr></thead>';
	
			$html = '';
			
			for ($m=0;$m<count($months);$m++) {
				$month = $months[$m];
	
				$month_html = '';
	
				$first_day = strtotime($month.'-01');
				$no_of_days = date('t',$first_day);
				$last_day = strtotime($month.'-'.$no_of_days);
	
				// Month header
				$month_url = htmlentities($wp_theatre->listing_page->url(array('wpt_month'=>$month)));
				$month_html.= '<caption><h3><a href="'.$month_url.'">'.date_i18n('F Y',$first_day).'</a></h3></caption>';
				
				// Month footer
				$month_html.= '<tfoot>';
				$month_html.= '<td class="prev" colspan="3">';
				if (!empty($months[$m-1])) {
					$month_url = htmlentities($wp_theatre->listing_page->url(array('wpt_month'=>$months[$m-1])));
					$month_html.= '<a href="'.$month_url.'">&laquo; '.date_i18n('M',strtotime($months[$m-1].'-01')).'</a>';
				}
				$month_html.= '</td>';
				$month_html.= '<td class="pad"></td>';
				$month_html.= '<td class="next" colspan="3">';
				if (!empty($months[$m+1])) {
					$month_url = htmlentities($wp_theatre->listing_page->url(array('wpt_month'=>$months[$m+1])));
					$month_html.= '<a href="'.$month_url.'">'.date_i18n('M',strtotime($months[$m+1].'-01')).' &raquo;</a>';
				}
				$month_html.= '</td>';
				$month_html.= '</tfoot>';
				
				// Calculate leading days (of previous month)
				$first_day_pos = date('w',$first_day) - $start_of_week;
				if ($first_day_pos < 0) {
					$leading_days = 7 + $first_day_pos;
				} else {
					$leading_days = $first_day_pos;
				}
				
				// Calculate trailing days (of next month)
				$last_day_pos = date('w',$last_day) - $start_of_week;
				if ($last_day_pos < 0) {
					$trailing_days = -1 - $last_day_pos;
				} else {
					$trailing_days = 6 - $last_day_pos;
				}
				
				$first_day -= $leading_days * 60 * 60 * 24;
				$no_of_days += $leading_days + $trailing_days;
			
				$days = array();
				for($i=0;$i<$no_of_days;$i++) {
					$date = date('Y-m-d', $first_day + ($i * 60*60*24));
					$days[$date] = array();
				}

				$events_filters = array();

				/**
				 * Set the start-filter for the events.
				 * Start a first day of `$month` if `$month` is not the current month.
				 * Start today if `$month` is the current month.
				 */
				 
				$start_time = strtotime($month);
				if ($start_time < time()) {
					$events_filters['start'] = 'now';
				} else {
					$events_filters['start'] = date('Y-m-d', $start_time);					
				}

				/**
				 * Set the end-filter for the events.
				 * Use the first day of the next month for the end-filter.
				 */

				$events_filters['end'] = date('Y-m-d',strtotime($month.' + 1 month'));

				$events = $wp_theatre->events->get($events_filters);
				
				foreach ($events as $event) {
					$date = date('Y-m-d',$event->datetime() + get_option('gmt_offset') * HOUR_IN_SECONDS);
					$days[$date][] = $event;
				}
	
				$month_html.= '<tbody>';
				$month_html.= $thead_html;
				
				$day_index = 0;
				foreach($days as $day=>$events) {
					$day_html = '';
					
					if ($day_index % 7 == 0) {
						$month_html.= '<tr>';
					}
					
					$classes = array();
	
					$day_label = (int) substr($day,8,2);


	
					if (empty($events)) {
						$day_html.= $day_label;				
					} else {
					$eventstarttime = $events[0]->starttime();
					$eventTitle = $events[0]->title();
						if (count($events)==1) {
							$day_url = htmlentities($events[0]->production()->permalink());
						} else {
							//$day_url = htmlentities($wp_theatre->listing_page->url(array('wpt_day'=>$day)));
							$day_url = htmlentities($events[0]->production()->permalink());
						}
	
						$day_link = '<a href="'.$day_url.'">';
						$day_link.= $day_label;						
						$day_link.= '</a>';
						$day_link.= '<div class="cal-prod_starttime">'.$eventstarttime.'</div>';
						$day_link.= '<div class="cal-prod_title"><a href="'.$day_url.'">'.$eventTitle.'</a></div>';
						$day_link.= '<div class="cal-prod_moreinfo"><a href="'.$day_url.'">More Info</a></div>';
						/**
						 * Filter the HTML link for a day.
						 *
						 * @since 0.9.4
						 *
						 * @param string  $day_link 	The HTML for the link for the day.
						 * @param string  $day 			The day of the month being displayed in `yyyy-mm-dd` format.
						 * @param string  $day_url 		The URL to the production page or the listing page.
						 * @param string  $day_label 	The text being shown inside the link for the day.
						 * @param array   $events		An array of WTP_Event objects. 
						 * 								The events that take place on the day of the month being displayed.
						 */
						$day_html.= apply_filters('wpt_calendar_html_day_link',$day_link, $day, $day_url, $day_label, $events);
					}
	
					if (date('Y-m',strtotime($day)) != $month) {
						$classes[] = 'trailing';
					}
	
					if (!empty($classes)) {
						$day_html = '<td class="'.implode(' ',$classes).'">'.$day_html.'</td>';
					} else {
						$day_html = '<td>'.$day_html.'</td>';
					}
					
					/**
					 * Filter the HTML output for a day.
					 *
					 * @since 0.9.4
					 *
					 * @param string  $day_html The HTML for the day.
					 * @param string  $day 		The day of the month being displayed in `yyyy-mm-dd` format.
					 * @param array   $events	An array of WTP_Event objects. 
					 * 							The events that take place on the day of the month being displayed.
					 */
					$month_html.= apply_filters('wpt_calendar_html_day', $day_html, $day, $events);
	
					if (($day_index % 7) == 6) {
						$month_html.= '</tr>';
					}
		
					$day_index++;
				}
	
				$month_html.= '</tbody>';
				
				$month_html = '<table class="wpt_month">'.$month_html.'</table>';

				/**
				 * Filter the HTML output for the full month.
				 *
				 * @since 0.9.4
				 *
				 * @param string  $month_html The HTML for the full month.
				 * @param string  $month The month being displayed in yyyy-mm format.
				 */
 				$html.= apply_filters('wpt_calendar_html_month', $month_html, $month);
	
			}
			$html = '<div class="wpt_calendar">'.$html.'</div>';

			/**
			 * Filter the HTML output for entire calendar.
			 *
			 * @since 0.9.4
			 *
			 * @param string  $html The HTML for the calendar.
			 */
			$html = apply_filters('wpt_calendar_html', $html);
			
			return $html;
		}
		
		/**
		 * check_dependencies function.
		 *
		 * @since	0.? 
	     * @since	0.14.3	Bugfix: Avoid PHP errors when no listing page is set.
	     *					Fixes #181.
	     *
		 * @access public
		 * @return void
		 */
		function check_dependencies() {
			global $wp_theatre;

			$everything_ok = ($listing_page = $wp_theatre->listing_page->page()) && $listing_page instanceof WP_Post;
			
			if (!$everything_ok) {
				
			}
			return $everything_ok;
		}
		
		/**
		 * Handle the [wpt_calendar] shortcode.
		 * @see WPT_Calendar::check_dependencies()	To check if all dependencies are set.
		 * @see WPT_Calendar::html()				To generate the HTML output.
		 * @see WPT_Transients::get()				To retrieve a cached version of the output.
		 * @see WPT_Transients::set()				To store a cached version of the output.
		 * @since 0.8
		 */
		
		function shortcode() {
			$html = '';
			
			if ($this->check_dependencies()) {
				global $wp_theatre;
	
				if ( ! ( $html = $wp_theatre->transient->get('c', array()) ) ) {
					$html = $this->html();
					$wp_theatre->transient->set('c', array(), $html);
				}
			}
			
			return $html;
		}

		/**
		 * Register the Theater Calendar widget.
		 * @see WPT_Calendar::check_dependencies()	To check if all dependencies are set.
		 * @see WPT_Calendar_Widget					The Theater Calendar widget.
		 * @since 0.8
		 */
		
		function widgets_init() {
			if ($this->check_dependencies()) {
				register_widget( 'WPT_Calendar_Widget' );			
			}	
		}
		
	}

$calendar = new PROD_Calendar();