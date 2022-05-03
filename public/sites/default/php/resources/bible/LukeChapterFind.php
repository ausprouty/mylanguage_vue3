<?php
myRequireOnce('resources/bible/LukeChapterGet.php');

function LukeChapterFind($p){
	writeLogDebug('LukeChapterFind-5', $p);
	$required= array(
        'hl_id_written' => 'eng00',
		'chapter_id' => 1,
		'bid'=> NULL
    );
	$p = validateParameters($p, $required, 'LukeChapterFind');
    if (!$p){
        $return;
    }
	writeLogDebug('LukeChapterFind-15', $p);
	$data = sqlFetchObject('SELECT id, passage, times_accessed
		FROM my_luke_chapter
		WHERE bid = :bid AND chapter = :chapter',
		array(':bid' => $p['bid'], ':chapter' => $p['chapter_id']));
	writeLogDebug('LukeChapterFind-18', $data);
	if (isset($data->passage)){
		$times_accessed = $data->times_accessed + 1;
		sql('UPDATE my_luke_chapter
			SET last_access = :last_access,
			times_accessed = :times_accessed
			WHERE id = :id',
			array(':last_access'=> time(),
			':times_accessed'=>$times_accessed,
			':id'=>$data->id ));
        return $data->passage;
	}
	else{
		writeLogDebug('LukeChapterFind-30', $p);
		$passage = LukeChapterGet($p);
		//
		writeLogDebug('LukeChapterFind-32', $passage);
	}
	return $passage;
}
