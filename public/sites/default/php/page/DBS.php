<?php

myRequireOnce('resources/dbs/introText.php');
myRequireOnce('resources/dbs/questionsBefore.php');
myRequireOnce('resources/dbs/passage.php');
myRequireOnce('resources/dbs/questionsAfter.php');

function DBS($p){
	$output = new \stdClass;
    $required= array(
        'hl_id_written' => 'eng00',
		'session'=> 1,
		'dir'=>'ltr'
    );
	$p = validateParameters($p, $required, 'DBS');
    if (!$p){
        return;
    }
	$output->title = translate('Discuss with your friends');
	$output->introText = introText($p);
	$output->questionsBefore = questionsBefore($p);
	$output->passage = passage($p);
	$output->questionsAfter = questionsAfter($p);
    return $output;
}
