<?php

function footer(){
	return;
	// these links no longer work
	
	$hl_id = mylanguage_hl_validate();
	if ($hl_id == 'eng00'){
		return;
	}
	$data = sqlFetchObject('SELECT google, language_bing FROM my_language
		WHERE hl_id = :hl_id',
		array(':hl_id' => $hl_id))->fetchObject();
	if (!empty($data->language_bing)){
		$output = mylanguage_menu_l($text = NULL, $path = 'https://www.microsoft.com/en-us/translator/apps.aspx?WT.mc_id=Attribution', $image = 'microsoft_translate.png');
		return  $output;
	}
	if (!empty($data->google)){
		$output =  mylanguage_menu_l($text = NULL, $path = 'translate.google.com', $image = 'google_translate.png');
		return  $output;
	}
	return;
	
}
function page_footer(){
	return;
	// these links no longer work
	
	$hl_id = mylanguage_hl_validate();
	if ($hl_id == 'eng00'){
		return;
	}
	$data = sqlFetchObject('SELECT google, language_bing FROM my_language
		WHERE hl_id = :hl_id',
		array(':hl_id' => $hl_id))->fetchObject();
	if (!empty($data->language_bing)){
		$output = mylanguage_menu_l($text = NULL, $path = 'https://www.microsoft.com/en-us/translator/apps.aspx?WT.mc_id=Attribution', $image = 'microsoft_translate.png');
		return  $output;
	}
	if (!empty($data->google)){
		$output =  mylanguage_menu_l($text = NULL, $path = 'translate.google.com', $image = 'google_translate.png');
		return  $output;
	}
	return;
	
}