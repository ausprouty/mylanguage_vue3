<?php

function getCollectionCode($p){
    $required= array(
        'hl_id_written' => 'eng00',
        'book_id' => NULL,
    );
	$p = validateParameters($p, $required, 'getCollectionCode');
    if (!$p){
        $return;
    }
}
