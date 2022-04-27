<?php

function link($text, $path, $options){
    $template ='<a href="{{ path }}">{{ text }}</a>';
    $placeholders = array(
        '{{ path }}',
        '{{ text }}'
    );
    $replace = array(
        $path ,
        $text
    );
    $output = str_ireplace ($placeholders, $replace, $template);
    return $output;
}