<?php

myRequireOnce('resources/dbs/introText.php');
myRequireOnce('resources/dbs/questionsBefore.php');
myRequireOnce('resources/dbs/passage.php');
myRequireOnce('resources/dbs/questionsAfter.php');

function DBSPage($p){
	$output = new \stdClass;
    $required= array(
        'hl_id_written' => 'eng00',
		'session'=> 1,
		'dir'=>'ltr'
    );
	writeLogDebug(DBSPage-15, $p);
	$p = validateParameters($p, $required, 'GospelPage');
		writeLogDebug(DBSPage-17, $p);
    if (!$p){
        return;
    }
	writeLogDebug(DBSPage-19, $p);
	$output->title = translate('Discuss with your friends');
		writeLogDebug(DBSPage-21, $output);
	$output->introText = introText($p);
		writeLogDebug(DBSPage-23, $output);
	$output->questionsBefore = questionsBefore($p);
		writeLogDebug(DBSPage-25, $output);
	$output->passage = passage($p);
		writeLogDebug(DBSPage-27, $output);
	$output->questionsAfter = questionsAfter($p);
		writeLogDebug(DBSPage-29, $output);
    return $output;
}
