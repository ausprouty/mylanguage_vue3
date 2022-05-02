<?php
 /* requires $p['language_iso']
 and $p['entry'] in form of 'Zephaniah 1:2-3'

 returns array:
     $dbt = array(
         'entry' => 'Zephaniah 1:2-3'
          'bookId' => 'Zeph',
          'chapterId' => 1,
          'verseStart' => 2,
          'verseEnd' => 3,
         'collection_code' => 'OT' ,
     );
 */
myRequireOnce ('writeLog.php');

function getDbtArrayFromEntry($p){
    $out = [];
    $passages = explode(';',$p['entry'] );
    foreach ($passages as $passage){
        $p['passage']= trim($passage);
        $out[] = getDbtArray($p);
    }
    return $out;
}
function getDbtArray($p){
    $language_iso = $p['language_iso'];
    $passage = $p['passage'];
    $passage = trim($passage);
    $parts = [];
    // chinese does not use a space before reference
    if (strpos($passage, ' ') === FALSE){
        $first_number= mb_strlen($passage);
        for ($i = 0; $i<=9; $i++){
            $pos = mb_strpos( $passage,$i);
            if ($pos){
                if($pos < $first_number){
                    $first_number = $pos;
                }
            }
        }
        $parts[0]= mb_substr($passage, 0, $first_number);
        $parts[1] = mb_substr($passage,$first_number);
    }
    else{
        $parts = explode(' ', $passage);
    }
    $book = $parts[0];
    if ($book == 1 || $book == 2 || $book == 3){
        $book .= ' '. $parts[1];
    }
    $book_lookup = $book;
    if ($book_lookup == 'Psalm'){
        $book_lookup = 'Psalms';
    }
    $book_details= [];
     writeLogAppend('getDbtArray-53', $book_lookup);
    $book_details = getDbtArrayNameFromDBM($language_iso,  $book_lookup);
    if (!isset($book_details['testament'])){
          $book_details = getDbtArrayNameFromHL($language_iso,  $book_lookup);
    }
    if (!isset($book_details['testament'])){
          $book_details = getDbtArrayNameFromHL('eng',  $book_lookup);
    }
    if (!isset($book_details['testament'])){
        $message ="Could not find $book_lookup in $language_iso";
        writeLogError('getDbtArray-50', $message );
        return NULL;
    }
    // pull apart chapter
    $pass = str_replace($book, '', $passage);
    $pass = str_replace(' ' , '', $pass);
    $i = strpos($pass, ':');
    if ($i !== FALSE){
        $chapterId = substr($pass, 0, $i);
        $verses = substr($pass, $i+1);
        $i = strpos ($verses, '-');
        if ($i !== FALSE){
            $verseStart = substr($verses, 0, $i);
            $verseEnd = substr($verses, $i+1);
        }
        else{
            $verseStart = $verses;
            $verseEnd = $verses;
        }
    }
    else{
        $chapterId = $p;
        $verseStart = 1;
        $verseEnd = 200;
    }
    $dbt_array = array(
        'entry' => $passage,
        'bookId' => $book_details['book_id'],
        'bookLookup'=> $book_lookup,
        'chapterId' => $chapterId,
        'verseStart' => $verseStart,
        'verseEnd' => $verseEnd,
        'collection_code' => $book_details['testament'],
    );
    $out = $dbt_array;
    return $out;
}


function getDbtArrayNameFromDBM($language_iso,  $book_lookup){
    $book_details= [];
    $book_details['lookup'] = $book_lookup;
    $conn = new mysqli(HOST, USER, PASS, DATABASE_BIBLE);
    $conn->set_charset("utf8");
    $data=sqlFetchObject('SELECT book_id FROM my_bible_book_names
        WHERE language_iso = :language_iso AND name = :book_lookup',
        array(':language_iso'=> $language_iso, ':book_lookup'=> $book_lookup));
    if (!isset($data->book_id)){
        writeLogAppend('ERROR-getDbtArrayNameFromDBM', $sql);
    }
    if (isset($data->book_id)){
        $book_details['book_id'] = $data->book_id;
        $book_id = $book_details['book_id'];
        $testament = sqlFetchField('SELECT testament FROM my_bible_book
          WHERE book_id = :book_id',
          array(':book_id' => $book_id));
        if (isset($testament)){
            $book_details['testament']=$testament;
        }
    }
    return $book_details;
}

function getDbtArrayNameFromHL($language_iso,  $book_lookup){
    $book_details= [];
    $book_details['lookup'] = $book_lookup;
    $data = sqlFetchArray("SELECT book_id, testament FROM hl_online_bible_book
        WHERE  $language_iso  = :book_lookup LIMIT 1",
        array (':book_lookup'=> $book_lookup));
    if (isset($data['book_id'])){
        $book_details['testament']=$data['testament'];
        $book_details['book_id'] = $data['book_id'];
    }
    return $book_details;
}
