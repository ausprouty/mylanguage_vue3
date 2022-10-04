<?php



function validateParameters($p, $required, $source){
    foreach ($required as $key=>$value){
        if (!isset($p[$key])){
            $p[$key]= $value;
        }
        if ($p[$key] == ''){
            $p[$key]= $value;
        }
    }
    if ($p['hl_id'] != ''){
        $_SESSION['hl_id'] = $p['hl_id'];
        $p['hl_id_written'] =  $p['hl_id'];
    }
    if (isset($p['chapter_id'])){
        if ($p['chapter_id'] > 24){
            $p['chapter_id'] = 24;
        }
    }
    writeLogAppend('validateParameters', $p);
    return $p;
}