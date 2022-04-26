<?php

myRequireOnce('writeLog.php');

function validateParameters($p, $required, $source){
    $valid = TRUE;
    foreach ($required as $key=>$value){
        if (!isset($p[$key])){
            $p[$key]= $value;
        }
    }
    return $valid;
}