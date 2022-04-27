<?php
function mylanguage_chinese($hl_id){
	if (!isset($hl_id) || $hl_id == ''){
		$hl_id = 'eng00';
	}
	db_set_active('my');
	$data = sqlFetchObject('SELECT name, ethnic_name, requests, chinese FROM my_language 
		WHERE hl_id = :hl_id', 
		array(':hl_id' =>$hl_id)
	)-> fetchObject();
	db_set_active('default');
    $name = isset($data->name) ? $data->name : NULL;
	$chinese = isset($data->chinese)? $data->chinese : 0;
  // check to see if Chinese
	if ($chinese == 1) { 
		$_SESSION['mylanguage_chinese'] = 'Y';
		$_SESSION['mylanguage_chinese_written'] = 'chn-s';
		$_SESSION['mylanguage_written_hl_id'] = 'chn-s';
	}
	else{
		unset ($_SESSION['mylanguage_chinese']);
		unset ($_SESSION['mylanguage_chinese_written']);
		$_SESSION['mylanguage_written_hl_id'] = $hl_id;
	}
  $_SESSION['mylanguage_name'] = $name;
  $_SESSION['mylanguage_ethnic_name'] = isset($data->ethnic_name) ? $data->ethnic_name: NULL;
  if (!$_SESSION['mylanguage_ethnic_name']) { $_SESSION['mylanguage_ethnic_name'] = $name;}
  return $chinese;
}
function mylanguage_chinese_change( $chinese_written, $return_page){
  $_SESSION['mylanguage_chinese_written'] = $chinese_written;
  drupal_goto('https://mylanguage.net.au/'. $return_page . '/chn00');
  return;
}
function mylanguage_chinese_display($webpage){
	if (!isset($_SESSION ['mylanguage_chinese_written'])){
		$_SESSION ['mylanguage_chinese_written']= 'chn-s';
	}
  if ($_SESSION ['mylanguage_chinese_written'] == 'chn-s'){
    $output =  '<h4>' . link('中文 - 普通话 - Simplified Chinese', 'chinese_change/chn-s/'. $webpage ). '</h4> ';
    $output .=  '<br><p>('. t ('also available in ') . link('中文 – 華語/國語 - Traditional Chinese', 'chinese_change/chn-t/'. $webpage ) . '</p><br><br>'. "\n";
  }
  else {
   
    $output =   '<h4>' . link('中文 – 華語/國語 - Traditional Chinese', 'chinese_change/chn-t/'. $webpage) . '</h4> ';
    $output .=  '<br><p>('. t ('also available in ') .l('中文 - 普通话 - Simplified Chinese' , 'chinese_change/chn-s/' . $webpage) . '</p><br><br> '. "\n";
  }  
  return $output;
}
