<?php

//Search Production

function searchForm($atts){
	$html ='';

	$html .='<form role="search" method="get" id="production_searchform">';
		$html .='<input type="text" value="" name="s" class="production_title" placeholder="ENTER TITLE OF SHOW">';
		$html .='<input type="submit" class="production_submit" value="Search">';
	$html .='</form>';
	return $html;
}

add_shortcode( 'productionsearchform', 'searchForm' );

