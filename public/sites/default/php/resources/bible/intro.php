<?php
function intro($nt, $hl_id){
	//uses bid of NT.
	$ot = NULL;

	$dbt_array = array(
	  'entry' => 'Luke 1:1-4',
		'bookId' => 'Luke',
		'collection_code' => 'NT',
		'chapterId' =>  1,
		'verseStart' => 1,
		'verseEnd' => 4,
	);
	$output = dmm_bible_verses($ot, $nt, $dbt_array);
	return $output;
}