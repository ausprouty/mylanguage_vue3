<?php
function questionMaker($nmbr, $hl_id_written = 'eng00', $dir = 'ltr'){
	$question = '';
	$data = sqlFetchObject('SELECT question FROM my_dbs_questions
		WHERE nmbr = :nmbr AND hl_id = :hl_id',
		array( ':nmbr' => $nmbr,':hl_id' => $hl_id_written)) ;

	if (isset($data->question)){
		$question .=  $nmbr . '.'. $data->question . "\n";
	}
	else{
		$data = sqlFetchObject('SELECT question FROM my_dbs_questions
			WHERE nmbr = :nmbr AND hl_id = :hl_id',
			array( ':nmbr' => $nmbr,':hl_id' => 'eng00')) ;

		if (isset($data->question)){
			$question .=  $nmbr . '.'. $data->question  . "\n";
		}
		$dir = "ltr";
	}

	$output = '<p> <span dir="'. $dir . '">' . $question . '</span></p>' . "\n";
	return $output;
}
