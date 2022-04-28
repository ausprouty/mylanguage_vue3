<?php



function validateParameters($p, $required, $source){
    foreach ($required as $key=>$value){
        if (!isset($p[$key])){
            $p[$key]= $value;
        }
    }
    if (isset($p['hl_id'])){
        $_SESSION['hl_id'] = $p['hl_id'];
    }
    writeLogDebug('validateParameters', $p);
    return $p;
}