<?php
myRequireOnce('resources/bible/questions.php');
myRequireOnce('resources/bible/getBid.php');
myRequireOnce('resources/bible/LukeChapterFind.php');
// displays Luke
function BiblePage($p){
   $output = new \stdClass;
    $required= array(
        'hl_id_written' => 'eng00',
		'chapter_id'=> 1
    );
	$p = validateParameters($p, $required, 'GospelPage');
    if (!$p){
        return;
    }
    if ($p['chapter_id'] > 24){
		$p['chapter_id'] = 24;
	}
	$output->title = translate('Read God\'s Word: the Bible');
	$output->questions = questions($p['hl_id_written']);
    $p['collection_code'] = 'nt';
    $p['bid'] = getBid($p);
	if (!$p['bid']){
	   writeLogErrorAppend('BiblePage25', $p);
       return;
	}
	writeLogDebug('BiblePage-28', $p);
    $output->text = LukeChapterFind($p);
	writeLogDebug('BiblePage-40', $output);
	return $output;

}
