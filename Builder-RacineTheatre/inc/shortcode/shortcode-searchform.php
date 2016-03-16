<?php

//Search Production

function prod_searchForm($atts){
	$html ='';

	$html .='<form role="search" method="get" id="production_searchform" action="'.esc_url( home_url( "/" ) ).'">';
		$html .='<input type="text" value="" name="s" class="production_title" placeholder="ENTER TITLE OF SHOW">';
		$html .='<input type="text" value="" name="d" class="production_date" id="prod_datepicker" placeholder="Month Year">';
		$html .='<input type="submit" class="production_submit" value="Search">';
	$html .='</form>';
	return $html;
}
add_shortcode( 'productionsearchform', 'prod_searchForm' );


function searchForm_func($atts){
	$html ='';
	$html .='<form role="search" method="get" id="searchform" action="'.esc_url( home_url( "/" ) ).'">';
		$html .='<div>';
			$html .='<input type="text" value="" name="s" id="s" placeholder="What are you looking for?">';
			$html .='<input type="submit" id="searchsubmit" value="Search">';
		$html .='</div>';
	$html .='</form>';
	return $html;
}

add_shortcode( 'searchform', 'searchForm_func' );