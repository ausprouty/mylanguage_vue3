<?php

function getBid($p){
    $required= array(
        'hl_id_written' => 'eng00',
        $p['collection_code']=> NULL,
    );
	$p = validateParameters($p, $required, 'getBid');
    if (!$p){
        $return;
    }
    $bid = sqlFetchField('SELECT bid FROM my_bible
			WHERE hl_id = :hl_id AND (collection_code = :collection_code OR collection_code = :fu )
			AND text = :y1
			ORDER BY weight DESC LIMIT 1',
			array(':hl_id' => $p['hl_id_written'],
					':y1' => 'Y',
					':nt' => $p['collection_code'],
					':fu' => 'FU'))
			->fetchField();
    return $bid;

}