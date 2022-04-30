<?php
function find($nt, $chapter_id, $hl_id){
	//uses bid of NT.
	$ot = NULL;
	db_set_active('hl_online');
	$verses = sqlFetchObject('SELECT verses FROM hl_online_luke_verses
		WHERE chapter = :chapter',
		array(':chapter' => $chapter_id))-> fetchField();
	
	$dbt_array = array(
	  'entry' => 'Luke '. $chapter_id . ':1-'. $verses,
		'bookId' => 'Luke',
		'collection_code' => 'NT',
		'chapterId' =>  $chapter_id,
		'verseStart' => 1,
		'verseEnd' => $verses,
	);
	$output = dmm_bible_verses($ot, $nt, $dbt_array);
	return $output;
}
