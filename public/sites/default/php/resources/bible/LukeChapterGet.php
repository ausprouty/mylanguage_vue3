<?php
myRequireOnce('resources/bible/getBiblePassage.php');

function LukeChapterGet($nt, $chapter_id, $hl_id){
	$end_verse = sqlFetchObject('SELECT verses FROM my_luke_verse_count
        WHERE chapter = :chapter',
		array(':chapter' => $chapter_id));
    writeLogDebug('LukeChapterGet-10', $end_verse);
	$dbt_array = array(
	    'entry' => 'Luke '. $chapter_id . ':1-'. $verses,
		'bookId' => 'Luke',
		'collection_code' => 'NT',
		'chapterId' =>  $chapter_id,
		'verseStart' => 1,
		'verseEnd' => $end_verse,
	);
    $ot = NULL;
	$passage = getBiblePassage($ot, $nt, $dbt_array);
    LukeChapterSave($nt, $chapter_id, $passage);
	return $passage;
}

function LukeChapterSave($nt, $chapter_id, $passage){
    sqlSafe('INSERT INTO my_luke_chapter (bid, chapter,passage)
        VALUES (:bid, :chapter, :passage)',
        array(':bid' => $nt, ':chapter'=>$chapter_id, ':passage'=> $passage));
    return;
}
