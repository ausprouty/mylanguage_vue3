<?php
myRequireOnce('bible/questions.php');

function BiblePage($p){
 $output = new \stdClass;
    $required= array(
        'hl_id_written' => 'eng00'
    );
	$p = validateParameters($p, $required, 'GospelPage');
    if (!$p){
        $return;
    }
	$is_mobile = isMobile();
	if ($is_mobile){
		$margin = 0;
	}
	else{
		$margin = 20;

	}
	if ($chapter_id == ''){
		$chapter_id = 1;
	}
	elseif ($chapter_id > 24){
		$chapter_id = 24;
	}
	$output .= '<div style = "margin-left:' . $margin . '%">';
	$output .= '<h1>' .translate('Read God\'s Word: the Bible') . '</h1>';
	$output .= bible_questions($p['hl_id_written']);
	$output .= '</div>';
	$output .= '<hr>' ."\n";

    $bid = sqlFetchField('SELECT bid FROM my_bible
		WHERE hl_id = :hl_id AND (collection_code = :nt OR collection_code = :fu )
		AND text = :y1
		ORDER BY weight DESC LIMIT 1',
        array(':hl_id' =>$hl_id,
				':y1' => 'Y',
				':nt' => 'NT',
				':fu' => 'FU'));
    writeLogDebug('BiblePage-40', $bid);

	if (!empty($bid)){
	    $a = drupal_get_form('mylanguage_page_bible_navigation_form', $hl_id, $chapter_id);
		$output .= drupal_render($a);
		$passage = mylanguage_page_bible($bid, $chapter_id, $hl_id);
		if (substr ($passage, 0, 16) == 'Bible not found.'){
			drupal_goto('/listen_online/'. $hl_id);
		}
		$output .= $passage;
		$a = drupal_get_form('mylanguage_page_bible_navigation_form', $hl_id, $chapter_id);
		$output .= drupal_render($a);
		return $output;
	}
	// default to listen
	drupal_goto('/listen_online/'. $hl_id);
	return $output;
}
