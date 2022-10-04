<?php
myRequireOnce('resources/bible/getBid.php');
myRequireOnce('resources/bible/getBiblePassage.php');

function passage($p){
    writeLogDebug('passage-6', $p);
    $required= array(
        'hl_id_written' => 'eng00',
		'session'=> 1,
    );
	$p = validateParameters($p, $required, 'DBS');
    if (!$p){
        return;
    }
    $passage = sqlFetchObject('SELECT * FROM my_study_passage
        WHERE study = :study AND lesson = :session AND language = :language',
        array(':study' => 'ctc',
            ':session' =>  $p['session'],
            ':language' =>'eng')
        );
    if ($passage->dbt_array){
        $a = unserialize($passage->dbt_array);
        $p['dbt_array']  = array_pop($a);
        $p['collection_code']= $p['dbt_array']['collection_code'];
        $bid =getBid($p);
        $p['bid'] = $bid;
        $output = '<p>'. getBiblePassage($p).  "\n";
         return $output;
    }
    else{
        writeLogErrorAppend('passage-23', $p);
        return NULL;
    }

}