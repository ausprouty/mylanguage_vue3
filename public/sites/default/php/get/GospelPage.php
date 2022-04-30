<?php

// will either return text or URL of site to visit
function GospelPage($p) {
    $output = new \stdClass;
    $required= array(
        'hl_id_written' => 'eng00'
    );
	$p = validateParameters($p, $required, 'GospelPage');
    if (!$p){
        $return;
    }
    writeLogDebug('GospelPage-13', $p);
    $data = sqlFetchObject('SELECT * from my_online_gospel
        WHERE hl_id = :hl_id  LIMIT 1',
        array(':hl_id' =>$p['hl_id_written']));
	if($data->tract){
		$webpage = 'gospel/'. $data->tract . '.html';
		$output->text=  file_get_contents(CONTENT_DIRECTORY . $webpage);
	}
	else{
		$output->link = $data->webpage;
	}
	return $output;
}