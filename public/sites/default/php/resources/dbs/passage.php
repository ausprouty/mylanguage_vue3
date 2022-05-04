<?php
myRequireOnce('resources/bible/getBid.php');
myRequireOnce('resources/bible/getBiblePassage.php');

function passage($p){
    $passage = sqlFetchObject('SELECT * FROM my_studypassage
        WHERE study = :study AND lesson = :session AND language = :language',
        array(':study' => 'ctc',
            ':session' =>  $p['session'],
            ':language' =>'eng')
        );
	$a = unserialize($passage->dbt_array);
	$p['dbt_array']  = array_pop($a);
    $p['collection_code']= $p['dbt_array']['collection_code'];
    $bid =getBid($p);
    $p['bid'] = $bid;
	$output = '<p>'. getBiblePassage($p).  "\n";
    return $output;
}