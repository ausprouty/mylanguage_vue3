<?php
function BiblePage($p){
 $output = new \stdClass;
    $required= array(
        'hl_id_written' => 'eng00'
    );
	$p = validateParameters($p, $required, 'GospelPage');
    if (!$p){
        $return;
    }
    writeLogDebug('BiblePage-13', $p);
})