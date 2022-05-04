<?php
function sessionsIndex($p){

    $passage = sqlFetchObject('SELECT * FROM my_studypassage
			WHERE study = :study AND lesson = :session AND language = :language',
			array(':study' => 'ctc',
				':session' =>  $session,
				':language' =>'eng')
			);


	$a = unserialize($passage->dbt_array);
	$dbt_array = array_pop($a);
	// select bible

	$ot = '';
	$nt = '';
	$dir = "ltr";
	if ($dbt_array['collection_code'] == 'OT'){
		$bible = sqlFetchObject('SELECT bid, right_to_left FROM my_bible
			WHERE hl_id = :hl_id AND (collection_code = :testament OR collection_code = :fu )
			AND text = :y1
			ORDER BY weight DESC LIMIT 1',
			array(':hl_id' =>$hl_id,
					':y1' => 'Y',
					':testament' => 'OT',
					':fu' => 'FU'))
			;
			// in case looking for Bible that does not exist
			if (!isset($bible->bid)){
				watchdog ('mylanguage', $hl_id .' does not have OT');
				$bible = sqlFetchObject('SELECT bid, right_to_left FROM my_bible
				WHERE hl_id = :hl_id AND (collection_code = :testament OR collection_code = :fu )
				AND text = :y1
				ORDER BY weight DESC LIMIT 1',
				array(':hl_id' =>'eng00',
						':y1' => 'Y',
						':testament' => 'OT',
						':fu' => 'FU'))
				;
			}
		$ot = $bible->bid;
		if ($bible->right_to_left =='t'){
			$dir = "rtl";
		}

	}
	else{
		$bible = sqlFetchObject('SELECT bid, right_to_left FROM my_bible
			WHERE hl_id = :hl_id AND (collection_code = :testament OR collection_code = :fu )
			AND text = :y1
			ORDER BY weight DESC LIMIT 1',
			array(':hl_id' =>$hl_id,
					':y1' => 'Y',
					':testament' => 'NT',
					':fu' => 'FU'))
			;
		if (!isset($bible->bid)){
			watchdog ('mylanguage', $hl_id .' does not have OT');
			$bible = sqlFetchObject('SELECT bid, right_to_left FROM my_bible
				WHERE hl_id = :hl_id AND (collection_code = :testament OR collection_code = :fu )
				AND text = :y1
				ORDER BY weight DESC LIMIT 1',
				array(':hl_id' =>'eng00',
						':y1' => 'Y',
						':testament' => 'NT',
						':fu' => 'FU'))
				;
		}
		$nt = $bible->bid;
		if ($bible->right_to_left =='t'){
			$dir = "rtl";
		}
	}
	$output .= '<p>'. dmm_bible_verses($ot, $nt, $dbt_array).  "\n";
    return $output;
}