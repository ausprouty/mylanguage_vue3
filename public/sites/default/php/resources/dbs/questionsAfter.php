<?php
myRequireOnce('resources/dbs/questionMaker.php');

function questionsAfter($p){
    $output = '';
    $output .= '<h2>'.translate('Application'). '</h2>';
	$output .= questionMaker(9, $p['hl_id_written'], $p['dir']);
	$output .= questionMaker(10, $p['hl_id_written'], $p['dir']);
	$output .= questionMaker(11, $p['hl_id_written'], $p['dir']);
	$output .= '<h2>'. translate('Planning'). '</h2>';
	$output .= questionMaker(12,  $p['hl_id_written'], $p['dir']);
	$output .= questionMaker(13,  $p['hl_id_written'], $p['dir']);
	$output .= questionMaker(14,  $p['hl_id_written'], $p['dir']);
	$output .= '<br><br>';
	return $output;

}