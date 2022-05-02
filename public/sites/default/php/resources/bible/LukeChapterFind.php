<?php
myRequireOnce('resources/bible/LukeChapterGet.php');

function LukeChapterFind($nt, $chapter_id, $hl_id){
	$data = sqlFetchObject('SELECT id, passage, times_accessed
		FROM my_luke_chapter
		WHERE bid = :bid AND chapter = :chapter',
		array(':bid' => $nt, ':chapter' => $chapter_id));
	if (isset($data->passage)){
		$times_accessed = $data->times_accessed + 1;
		sqlSafe('UPDATE my_luke_chapter
			SET last_access = :last_access,
			times_accessed = :times_accessed
			WHERE id = :id',
			array(':last_access'=> time(),
			':times_accessed'=>$times_accessed,
			':id'=>$data->id ));
	}
	else{
		$passage = LukeChapterGet($nt, $chapter_id, $hl_id);
	}
	return $passage;
}
