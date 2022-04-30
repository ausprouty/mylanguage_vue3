<?php
function dbt($bid, $chapterId, $hl_id){
	// see if this is in cache
	$a = drupal_get_form('mylanguage_page_bible_navigation_form', $hl_id, $chapterId);
	$output = drupal_render($a);

	$data = sqlFetchObject('SELECT * FROM hl_luke_passage
		WHERE bid = :bid AND reference = :chapter',
    array(':bid' => $bid, ':chapter' => $chapterId))
		;
	if (isset($data->passage)){
			sqlFetchObject('UPDATE hl_luke_passage SET
				last_access = :last_access, times_access = :times_access
				WHERE id = :id',
				array(':last_access' => time(), ':times_access' => $data->times_access + 1,
				':id' => $data->id));
		return $data->passage;
	}

	$bookId = 'Luke';
	if ($chapterId < 1) {$chapterId = 1;}

	$data = sqlFetchObject('SELECT dam_id, right_to_left, volume_name, language_name FROM dbm_bible
		WHERE bid = :bid',
		array(':bid' => $bid ));

	$damId = $data->dam_id;
	$rtl = $data->right_to_left;
	$dbt = new Dbt ($applicationKey);
	$v = $dbt->getTextVerse( $damId, $bookId, $chapterId , $verseStart = 1, $verseEnd = 999 , $markup = NULL );
	$verses = json_decode($v);
	$paragraph_number = 0;
	$bible = '';
	foreach ($verses as $verse){
	    if ($verse->paragraph_number != $paragraph_number){
			if ($paragraph_number != 0){
				$bible .= '<br><br>';
			}
			$paragraph_number = $verse->paragraph_number;
		}
		if (!isset($reference_begin)){
			$reference_begin = '<h3>'. $verse->book_name . ' '. $verse->chapter_id . '</h3>';
		}
		$bible .= '<span class="verse">' . $verse->verse_id . '</span>'. "\n";
		$bible .= '<span class="bible">' . $verse->verse_text . '</span>'. "\n";
	}
	if ($rtl == 't'){
		$div = '<span dir = "rtl">';
	}
	else{
		$div = '<span dir = "ltr">';
	}
	// Bible Text
	$output .=  $div . $reference_begin  .  $bible . '</span><br>';
	$output .= '<hr><br>' ."\n";

	$output .= '<a href = "https://listen.bible.is/'. substr($damId, 0,6) . '/Gen/1">'  .mylanguage_t_ethnic('Read the rest of the Bible') . '</a>';
	$output .= '<br><hr>';

	// insert into cache
	$nid = db_insert('hl_luke_passage')
		->fields(array(
			'bid' => $bid,
			'reference' => $chapterId,
			'passage' => $output,
			'last_access' => REQUEST_TIME,
			'times_access' => 1
		))
		->execute();
	return $output;
}