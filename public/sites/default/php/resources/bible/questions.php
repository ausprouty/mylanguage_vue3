<?php

function questions($hl_id_written){
	$output = '<ul>';
	$output .= '<li>'.translate('What does this tell you about God?') . '</li>' . "\n";
	$output .= '<li>'.translate('What does this tell you about Jesus?') . '</li>' . "\n";
	$output .= '<li>'.translate('What does this tell you about people?') . '</li>' . "\n";
	$output .= '<li>'.translate('If this is true, what difference would it make in your life?') . '</li>' . "\n";
	$output .= '<li>'.translate('Who are five people who you can share your discoveries with?') . '</li>' . "\n";
	$output .= '</ul>' . "\n";
	return $output;
}
