<?php
function page_bible_intro($nt, $hl_id){
	//uses bid of NT.
	$ot = NULL;
	
	$dbt_array = array(
	  'entry' => 'Luke 1:1-4',
		'bookId' => 'Luke',
		'collection_code' => 'NT',
		'chapterId' =>  1, 
		'verseStart' => 1,
		'verseEnd' => 4,  
	);
	$output = dmm_bible_verses($ot, $nt, $dbt_array);
	return $output;
}
function page_bible($hl_id = 'eng00', $chapter_id = 1) {
	mylanguage_meta('bible');
	$output = '';
	mylanguage_chinese($hl_id);
	if (isset($_SESSION['mylanguage_chinese'])){
		$hl_id = 'chn-s';
		$drupal = 'zh-hans';
		if ($_SESSION['mylanguage_chinese_written'] == 'chn-t') {
			$hl_id = 'chn-t';
			$drupal = 'zh-hant';
		}
	}
	if ($hl_id) {
       $_SESSION['mylanguage_hl_id'] = $hl_id;
	}
	$hl_id = mylanguage_hl_validate();
	mylanguage_language($hl_id);
	$is_mobile = mylanguage_find_is_mobile();
	if ($is_mobile){
		$margin = 0;
	}
	else{
		$margin = 20;
		
	}
	if ($chapter_id == ''){
		$chapter_id = 1;
	}
	elseif ($chapter_id > 24){
		$chapter_id = 24;
	}
	$output .= '<div style = "margin-left:' . $margin . '%">';
	$output .= '<h1>' .translate('Read God\'s Word: the Bible') . '</h1>';
	$output .= mylanguage_page_bible_questions();
	$output .= '</div>';
	$output .= '<hr>' ."\n";
	db_set_active('common');
    $bid = db_query('SELECT bid FROM dbm_bible
		WHERE hl_id = :hl_id AND (collection_code = :nt OR collection_code = :fu )
		AND text = :y1 
		ORDER BY weight DESC LIMIT 1',
        array(':hl_id' =>$hl_id, 
				':y1' => 'Y', 
				':nt' => 'NT', 
				':fu' => 'FU'))
		->fetchField();
	
	if (!empty($bid)){
		db_set_active('default');
	    $a = drupal_get_form('mylanguage_page_bible_navigation_form', $hl_id, $chapter_id);
		$output .= drupal_render($a);
		$passage = mylanguage_page_bible($bid, $chapter_id, $hl_id);
		if (substr ($passage, 0, 16) == 'Bible not found.'){
			drupal_goto('/listen_online/'. $hl_id);
		}
		$output .= $passage;
		$a = drupal_get_form('mylanguage_page_bible_navigation_form', $hl_id, $chapter_id);
		$output .= drupal_render($a);
		return $output;
	}
	// default to listen
	drupal_goto('/listen_online/'. $hl_id);
	return $output;
}
function page_bible_dbt($bid, $chapterId, $hl_id){
	// see if this is in cache
	$a = drupal_get_form('mylanguage_page_bible_navigation_form', $hl_id, $chapterId);
	$output = drupal_render($a);
		
	$data = db_query('SELECT * FROM hl_luke_passage
		WHERE bid = :bid AND reference = :chapter',
    array(':bid' => $bid, ':chapter' => $chapterId))
		->fetchObject();
	if (isset($data->passage)){
			db_query('UPDATE hl_luke_passage SET
				last_access = :last_access, times_access = :times_access
				WHERE id = :id',
				array(':last_access' => time(), ':times_access' => $data->times_access + 1,
				':id' => $data->id));
		return $data->passage;
	}
	require_once libraries_get_path('bibles') . '/dbt.inc';
	$applicationKey = '1c1c206cc9a9d8d3ab335eb6a3ed61cd';
	$bookId = 'Luke';
	if ($chapterId < 1) {$chapterId = 1;}
	db_set_active('common');
	$data = db_query('SELECT dam_id, right_to_left, volume_name, language_name FROM dbm_bible
		WHERE bid = :bid', 
		array(':bid' => $bid ))->fetchObject();
	db_set_active('default');
	$damId = $data->dam_id;
	$rtl = $data->right_to_left;
	$dbt = new Dbt ($applicationKey);
	$v = $dbt->getTextVerse( $damId, $bookId, $chapterId , $verseStart = 1, $verseEnd = 999 , $markup = NULL );
	$verses = json_decode($v);
	$paragraph_number = 0;
	$bible = '';
	foreach ($verses as $verse){
	    if ($verse->paragraph_number != $paragraph_number){
			if ($paragraph_number != 0){
				$bible .= '<br><br>';
			}
			$paragraph_number = $verse->paragraph_number; 
		}
		if (!isset($reference_begin)){
			$reference_begin = '<h3>'. $verse->book_name . ' '. $verse->chapter_id . '</h3>';
		}
		$bible .= '<span class="verse">' . $verse->verse_id . '</span>'. "\n";
		$bible .= '<span class="bible">' . $verse->verse_text . '</span>'. "\n";
	}
	if ($rtl == 't'){
		$div = '<span dir = "rtl">';
	}
	else{
		$div = '<span dir = "ltr">';
	}
	// Bible Text
	$output .=  $div . $reference_begin  .  $bible . '</span><br>';
	$output .= '<hr><br>' ."\n";
	
	$output .= '<a href = "https://listen.bible.is/'. substr($damId, 0,6) . '/Gen/1">'  .mylanguage_t_ethnic('Read the rest of the Bible') . '</a>';
	$output .= '<br><hr>';
	
	// insert into cache
	$nid = db_insert('hl_luke_passage') 
		->fields(array(
			'bid' => $bid,
			'reference' => $chapterId,
			'passage' => $output,
			'last_access' => REQUEST_TIME,
			'times_access' => 1
		))
		->execute();
	return $output;
}

function page_bible_find($nt, $chapter_id, $hl_id){
	//uses bid of NT.
	$ot = NULL;
	db_set_active('hl_online');
	$verses = db_query('SELECT verses FROM hl_online_luke_verses
		WHERE chapter = :chapter',
		array(':chapter' => $chapter_id))-> fetchField();
	db_set_active('default');
	$dbt_array = array(
	  'entry' => 'Luke '. $chapter_id . ':1-'. $verses,
		'bookId' => 'Luke',
		'collection_code' => 'NT',
		'chapterId' =>  $chapter_id, 
		'verseStart' => 1,
		'verseEnd' => $verses,  
	);
	$output = dmm_bible_verses($ot, $nt, $dbt_array);
	return $output;
}

function page_bible_navigation_form($form, &$form_state, $hl_id, $chapter = 1){
	$menu = NULL;
	if ($chapter < 1){
		 $chapter = 1;
	}
	if ($chapter > 1){
		$menu .= mylanguage_menu_l(mylanguage_t_ethnic('Previous Chapter'),
				'bible/'. $hl_id . '/'. ($chapter - 1),
				'back_blue_24x24.png'
				); 
	}
	if ($chapter < 24){
		$menu .= mylanguage_menu_l(mylanguage_t_ethnic('Next Chapter'),
				'bible/'. $hl_id . '/'. ($chapter + 1),
				'forward_blue_24x24.png'
				); 
	}
	$options = array();
	for ($i = 1; $i < 25; $i++){
		$options[$i] = $i; 
	}
	$form['chapter'] = array(
		'#type' => 'select',
		'#button2' => $menu,
		'#size' => 4,
		'#default_value' => $chapter,
		'#class' => 'form-select-mobile',
		'#title' =>translate('Chapter'),
		'#theme' => 'mylanguage_select_mobile',
		'#options'=> $options,
		'#attributes' => array('onchange' => 'form.submit("mylanguage_page_bible_navigation_form")'),
	 );
		 
  $form['hl_id'] = array(
		'#type' => 'value',
		'#default_value' => $hl_id,
	);
	$form['submit'] = array(
	  '#type' => 'image_button',
		'#src' => mylanguage_url_file() . '/icons/blank_1x1.png',
    '#value' =>translate('Read Chapter'),
    );		
		return $form;
}
function page_bible_navigation_form_submit($form, &$form_state){
	$form_state['redirect'] =  'bible/'. $form_state ['values']['hl_id'] . '/'. $form_state ['values']['chapter'];
	return;
}
function page_bible_questions(){
	$output = '<ul>';
	$output .= '<li>'.translate('What does this tell you about God?') . '</li>' . "\n";
	$output .= '<li>'.translate('What does this tell you about Jesus?') . '</li>' . "\n";
	$output .= '<li>'.translate('What does this tell you about people?') . '</li>' . "\n";
	$output .= '<li>'.translate('If this is true, what difference would it make in your life?') . '</li>' . "\n";
	$output .= '<li>'.translate('Who are five people who you can share your discoveries with?') . '</li>' . "\n";
	$output .= '</ul>' . "\n";
	return $output;
}
