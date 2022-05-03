<?php
myRequireOnce('resources/bible/getBiblePassage.php');

function LukeChapterGet($p){
	writeLogDebug('LukeChapterGet-5', $p);
	$required= array(
        'hl_id_written' => 'eng00',
		'chapter_id' => 1,
		'bid'=> NULL,
		'dbt_array'=> NULL
    );
	$p = validateParameters($p, $required, 'LukeChapterGet');
    if (!$p){
        $return;
    }
    writeLogDebug('LukeChapterGet-15', $p);
	$end_verse = sqlFetchField('SELECT verses FROM my_luke_verse_count
        WHERE chapter = :chapter',
		array(':chapter' => $p['chapter_id']));
    writeLogDebug('LukeChapterGet-10', $end_verse);
	$p['dbt_array'] = array(
	    'entry' => 'Luke '. $p['chapter_id'] . ':1-'. $end_verse,
		'bookId' => 'Luke',
		'collection_code' => 'NT',
		'chapterId' => $p['chapter_id'],
		'verseStart' => 1,
		'verseEnd' => $end_verse,
	);
    writeLogDebug('LukeChapterGet-28', $p);
	$passage = getBiblePassage($p);
	writeLogDebug('LukeChapterGet-30', $p);
    LukeChapterSave($p, $passage);
	return $passage;
}

function LukeChapterSave($p, $passage){
    sql('INSERT INTO my_luke_chapter (bid, chapter,passage)
        VALUES (:bid, :chapter, :passage)',
        array(':bid' => $p['bid'], ':chapter'=>$p['chapter_id'], ':passage'=> $passage));
    return;
}
