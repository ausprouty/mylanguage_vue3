<?php
function introLuke($hl_id){
    $required= array(
        'hl_id_written' => 'eng00'
    );
	$p = validateParameters($p, $required, 'introLuke');
    if (!$p){
        $return;
    }

	$p = array(
	    'entry' => 'Luke 1:1-4',
		'bookId' => 'Luke',
		'collection_code' => 'NT',
		'chapterId' =>  1,
		'verseStart' => 1,
		'verseEnd' => 4,
	);
	$output = getBiblePassage($p);
	return $output;
}