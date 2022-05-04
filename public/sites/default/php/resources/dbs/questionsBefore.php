<?php
myRequireOnce('resources/dbs/questionMaker.php');

function questionsBefore($p){
    $output = '';

	$output .= '<p style = "text-align:right">'.translate('Discovering Spiritual Community') . '  #'. $p['session'] . '</p>';
	$output .= '<h2>'.translate('Caring for one another'). '</h2>';
	$output .= questionMaker(1,  $p['hl_id_written'], $p['dir']);
	$output .= questionMaker(2,  $p['hl_id_written'], $p['dir']);
	$output .= '<h2>'.translate('Accountability'). '</h2>';
	$output .= questionMaker(3,  $p['hl_id_written'], $p['dir']);
	$output .= questionMaker(4,  $p['hl_id_written'], $p['dir']);
	$output .= '<h2>'.translate('Discover'). '</h2>';
	$output .= questionMaker(5, $p['hl_id_written'], $p['dir']);
	$output .= questionMaker(6,  $p['hl_id_written'], $p['dir']);
	$output .= questionMaker(7,  $p['hl_id_written'], $p['dir']);
	$output .= questionMaker(8, $p['hl_id_written'], $p['dir']);

	return $output;

}