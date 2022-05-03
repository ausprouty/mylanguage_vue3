<?php

/*requires $p as array:
        'entry' => 'Zephaniah 1:2-3'
        'bookId' => 'Zeph',
        'chapterId' => 1,
        'verseStart' => 2,
        'verseEnd' => 3,
        'bid' => '123' // this is bid being used.
        'collection_code' => 'OT' ,
        'version_ot' => '123', // this is bid
        'version_nt' => '134'
        )


    return aut as an array:
        debug:
       content: as an array with
		'passage_name' => 'Zephaniah 1:2-3'
		'bible' => 'bible verse text',
        'link' => 'https://biblegateway.com/passage/?search=John%201:1-14&version=LSG',
        'publisher' => 'Louis Segond (LSG) by Public Domain'

*/

function getBiblePassage($p){
    //writeLogDebug('getBiblePassage-27', $p);
    $required= array(
        'hl_id_written' => 'eng00',
		'chapter_id' => 1,
		'bid'=> NULL,
		'dbt_array'=> NULL
    );
	$p = validateParameters($p, $required, 'LukeChapterGet');
    if (!$p){
        $return;
    }
    //writeLogDebug('getBiblePassage-38', $p);
    if (!isset($p['bid'])){
        if (isset($p['dbt']['collection_code'])){
            if ($p['dbt']['collection_code'] == 'OT'){
                if (isset($p['dbt']['version_ot'])){
                    $p['bid'] = $p['dbt']['version_ot'];
                }
            }
            if ($p['dbt']['collection_code'] == 'NT'){
                if (isset($p['dbt']['version_nt'])){
                    $p['bid'] = $p['dbt']['version_nt'];
                }
            }
        }
        if (!isset($p['bid'])){
            writeLogAppendError ('bibleGetPassage-52', $p);
            return $out;
        }
    }
    $data = sqlFetchObject('SELECT * FROM my_bible WHERE bid = :bid LIMIT 1',
      array(':bid' =>$p['bid']));
    //writeLogDebug('getBiblePassage-58', $data);
    if ($data->right_to_left != 't'){
        $p['rldir'] = 'ltr';
    }
    else{
        $p['rldir'] = 'rtl';
    }
    if ($data->source == 'bible_gateway'){
        myRequireOnce ('resources/bible/getPassageBiblegateway.php');
        $p['version_code'] = $data->version_code;
        $out = getPassageBiblegateway($p);
         //writeLogDebug('getBiblePassage-72', $out);
        return $out['bible'];
    }
    if ($data->source  == 'dbt'){
        //writeLogDebug('getBiblePassage-79', $p);
        myRequireOnce ('resources/bible/getPassageDBT.php');
        $p['damId'] = $data->dam_id;
        $out = bibleGetPassageDBT($p);
        /* returns
            $out= [
                'reference' => $text['reference'],
                'text' => $text['text'],
                'link' => $link
            ];
        */
        //writeLogDebug('getBiblePassage-83', $out);
        return $out['text'];
    }
    return $out;
}