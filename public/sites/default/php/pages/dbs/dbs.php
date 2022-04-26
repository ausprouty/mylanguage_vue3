<?php

function page_discuss($hl_id = 'eng00', $session = 1){
	if (isset($_SESSION['mylanguage_chinese'])){
		$hl_id = 'chn-s';
		$drupal = 'zh-hans';
		if ($_SESSION['mylanguage_chinese_written'] == 'chn-t') {
			$hl_id = 'chn-t';
			$drupal = 'zh-hant';
		}
	}
	// for when not set right
	else{
		if ($hl_id == 'chn06'){
			$hl_id = 'chn-s';
			$drupal = 'zh-hans';
		}
	}
	global $language;
	// find passage
	db_set_active('common');
	$passage = db_query('SELECT * FROM dbm_study_passage
			WHERE study = :study AND lesson = :session AND language = :language', 
			array(':study' => 'ctc',
				':session' =>  $session, 
				':language' =>'eng')
			)->fetchObject();
	
	db_set_active('default');
	$a = unserialize($passage->dbt_array);
	$dbt_array = array_pop($a);
	// select bible
	db_set_active('common');
	$ot = '';
	$nt = '';
	$dir = "ltr";
	if ($dbt_array['collection_code'] == 'OT'){
		$bible = db_query('SELECT bid, right_to_left FROM dbm_bible
			WHERE hl_id = :hl_id AND (collection_code = :testament OR collection_code = :fu )
			AND text = :y1 
			ORDER BY weight DESC LIMIT 1',
			array(':hl_id' =>$hl_id, 
					':y1' => 'Y', 
					':testament' => 'OT', 
					':fu' => 'FU'))
			->fetchObject();
			// in case looking for Bible that does not exist
			if (!isset($bible->bid)){
				watchdog ('mylanguage', $hl_id .' does not have OT');
				$bible = db_query('SELECT bid, right_to_left FROM dbm_bible
				WHERE hl_id = :hl_id AND (collection_code = :testament OR collection_code = :fu )
				AND text = :y1 
				ORDER BY weight DESC LIMIT 1',
				array(':hl_id' =>'eng00', 
						':y1' => 'Y', 
						':testament' => 'OT', 
						':fu' => 'FU'))
				->fetchObject();
			}
		$ot = $bible->bid;
		if ($bible->right_to_left =='t'){
			$dir = "rtl";
		}
		
	}
	else{
		$bible = db_query('SELECT bid, right_to_left FROM dbm_bible
			WHERE hl_id = :hl_id AND (collection_code = :testament OR collection_code = :fu )
			AND text = :y1 
			ORDER BY weight DESC LIMIT 1',
			array(':hl_id' =>$hl_id, 
					':y1' => 'Y', 
					':testament' => 'NT', 
					':fu' => 'FU'))
			->fetchObject();
		if (!isset($bible->bid)){
			watchdog ('mylanguage', $hl_id .' does not have OT');
			$bible = db_query('SELECT bid, right_to_left FROM dbm_bible
				WHERE hl_id = :hl_id AND (collection_code = :testament OR collection_code = :fu )
				AND text = :y1 
				ORDER BY weight DESC LIMIT 1',
				array(':hl_id' =>'eng00', 
						':y1' => 'Y', 
						':testament' => 'NT', 
						':fu' => 'FU'))
				->fetchObject();
		}
		$nt = $bible->bid;
		if ($bible->right_to_left =='t'){
			$dir = "rtl";
		}
	}
	db_set_active('default');
	$output = '';
	mylanguage_language($hl_id);
	$output .= '<p style = "text-align:right">'.translate('Discovering Spiritual Community') . '  #'. $session . '</p>';
	$output .= '<h2>'.translate('Caring for one another'). '</h2>';
	$output .= mylanguage_page_discuss_q(1,  $hl_id, $dir);
	$output .= mylanguage_page_discuss_q(2,  $hl_id, $dir);
	$output .= '<h2>'.translate('Accountability'). '</h2>';
	$output .= mylanguage_page_discuss_q(3,  $hl_id, $dir);
	$output .= mylanguage_page_discuss_q(4,  $hl_id, $dir);
	$output .= '<h2>'.translate('Discover'). '</h2>';
	$output .= mylanguage_page_discuss_q(5, $hl_id, $dir);
	$output .= mylanguage_page_discuss_q(6,  $hl_id, $dir);
	$output .= mylanguage_page_discuss_q(7,  $hl_id, $dir);
	$output .= mylanguage_page_discuss_q(8, $hl_id, $dir);
	
	// print passage
	
	
	$output .= '<p>'. dmm_bible_verses($ot, $nt, $dbt_array).  "\n";
	// continue with questions
	$output .= '<h2>'.translate('Application'). '</h2>';
	$output .= mylanguage_page_discuss_q(9, $hl_id, $dir);
	$output .= mylanguage_page_discuss_q(10, $hl_id, $dir);
	$output .= mylanguage_page_discuss_q(11, $hl_id, $dir);
	$output .= '<h2>'.translate('Planning'). '</h2>';
	$output .= mylanguage_page_discuss_q(12,  $hl_id, $dir);
	$output .= mylanguage_page_discuss_q(13,  $hl_id, $dir);
	$output .= mylanguage_page_discuss_q(14,  $hl_id, $dir);
	$output .= '<br><br>';
	return $output;
}
function page_discuss_design_form($form_values = NULL){
    $results3 = db_query('SELECT * FROM hl_online_passage 
		WHERE study = :study AND language = :language ORDER BY session',
		array(':study' =>'dbs', ':language' =>'en')
	);
	$passage[''] =translate('SELECT VALUE');
	foreach($results3 as $data3){
	   $passage[$data3->session] = $data3->session . '. '. $data3->reference;
	}
	$form['session']=array(
    '#title' =>translate('Bible Passage'),
    '#type' => 'select',
    '#options' => $passage,
    '#default_value' => $_SESSION['mylanguage_page_discuss_session'],
  );
    $results2 = db_query('SELECT distinct(language) FROM hl_online_passage  ORDER BY language');
	 $lang[''] =translate('SELECT VALUE');
    foreach($results2 as $data2){
        $data3 = db_query('SELECT name, native FROM {languages} WHERE language= :language', 
			array('language' =>$data2->language)
		)->fetchObject();
	    $lang[$data2->language] = $data3->name . '  ('. $data3->native. ')';
    }
    $form ['language']=array(
		'#title' =>translate('Language') . ' #1',
		'#type' => 'select',
		'#options' => $lang,
		'#default_value' => $_SESSION['mylanguage_page_discuss_language'],
	 );
	// set default value for language2
    $form ['language2']=array(
		'#title' =>translate('Language') . ' #2',
		'#type' => 'select',
		'#options' => $lang,
		'#default_value' => $_SESSION['mylanguage_page_discuss_language2'],
	 );
    $form ['language3']=array(
		'#title' =>translate('Language') . ' #3',
		'#type' => 'select',
		'#options' => $lang,
		'#default_value' => $_SESSION['mylanguage_page_discuss_language3'],
	 );
	$form['submit'] = array(
		'#type' => 'submit',
		'#value' =>translate('Show Passage and Questions'),
	);
    return $form;
}
function page_discuss_design_form_submit($form_id, $form_values){
	$study = 'dbs';
	$session = $form_values['session'];
	$language[] = $form_values['language'];
	$_SESSION['mylanguage_page_discuss_language'] = $form_values['language'];
	$_SESSION['mylanguage_page_discuss_language2'] = $form_values['language2'];
	$_SESSION['mylanguage_page_discuss_language3'] = $form_values['language3'];
	$_SESSION['mylanguage_page_discuss_session'] = $form_values['session'];
	if ($form_values['language2']) { $language[] = $form_values['language2'];}
	if ($form_values['language3']) { $language[] = $form_values['language3'];}
	$_SESSION['hl_online_color_1'] = '#000';
	$_SESSION['hl_online_color_2'] = '#0b9ccb';
	$_SESSION['hl_online_color_3'] = '#F5AF13';
	return;
	
}
function page_discuss_header($nmbr = 1, $hl_id = 'eng00'){
	//foreach ($language as $lang){
		$data = db_query('SELECT topic FROM hl_online_topics
			WHERE nmbr = :nmbr AND hl_id = :hl_id LIMIT 1', 
			array(':nmbr' =>$nmbr,':hl_id' => $hl_id)) ->fetchObject();
		$topic .= $data->topic . ' -- ';
	//}
	if (!$topic){
			$data = db_query('SELECT topic FROM hl_online_topics
				WHERE nmbr = :nmbr AND hl_id = :hl_id LIMIT 1', 
				array(':nmbr' =>$nmbr, ':hl_id' =>'eng00')
			)->fetchObject();
	}
    $output = '<h3>'. substr($topic, 0 , -2) .'</h3><br>' . "\n";
    return $output;
}
function page_discuss_select_form($form, &$form_state, $session){
	global $language;
	if (isset($_SESSION['mylanguage_chinese'])){
		$hl_id = 'chn-s';
		if ($_SESSION['mylanguage_chinese_written'] == 'chn-t') {
			$hl_id = 'chn-t';
		}
	}
	$hl_id = mylanguage_hl_validate();
	$language_iso = mylanguage_language_iso($hl_id);
	// which testaments do we have for this language?
	$nt = NULL;
	$ot = NULL;
	db_set_active('common');
	$nt = db_query('SELECT bid FROM dbm_bible
		WHERE hl_id = :hl_id AND text = :text AND
		(collection_code = :collection_code1 or collection_code = :collection_code2)',
		array(':hl_id' => $hl_id, ':text' => 'Y', ':collection_code1' => 'FU', ':collection_code2' => 'NT'))
		->fetchField();
	$ot = db_query('SELECT bid FROM dbm_bible
		WHERE hl_id = :hl_id  AND text = :text AND
		(collection_code = :collection_code1 or collection_code = :collection_code2)',
		array(':hl_id' => $hl_id, ':text' => 'Y', ':collection_code1' => 'FU', ':collection_code2' => 'OT'))
		->fetchField();
		// if we have nothing in their language, give them everything in English
	if (!$ot && !$nt){
		$nt = db_query('SELECT bid FROM dbm_bible
			WHERE hl_id = :hl_id AND text = :text AND
			(collection_code = :collection_code1 or collection_code = :collection_code2)',
			array(':hl_id' => 'eng00', ':text' => 'Y', ':collection_code1' => 'FU', ':collection_code2' => 'NT'))
			->fetchField();
		$ot = db_query('SELECT bid FROM dbm_bible
			WHERE hl_id = :hl_id  AND text = :text AND
			(collection_code = :collection_code1 or collection_code = :collection_code2)',
			array(':hl_id' => 'eng00', ':text' => 'Y', ':collection_code1' => 'FU', ':collection_code2' => 'OT'))
			->fetchField();
		
	}
	db_set_active('default');
	db_set_active('common');
	$results = db_query('SELECT lesson, dbt_array FROM dbm_study_passage 
		WHERE study = :study AND language = :language ORDER BY lesson',
		array(':study' => 'ctc', ':language' => 'eng'));
	db_set_active('default');
	$conversations = array();
	foreach($results as $data){
		$a = unserialize($data->dbt_array);
		$dbt_array = array_pop($a);
		if (($dbt_array['collection_code'] == 'NT' AND $nt ) OR ($dbt_array['collection_code'] == 'OT' AND $ot )){
			$passage = dmm_bible_dbt_passage_name($dbt_array, $language_iso);
			$conversations[$data->lesson ]= $data->lesson . '. '. $passage;
		}
		
	}
	
  if (mylanguage_find_is_mobile()){
		$class = 'form-select-mobile';
	}
	else{
		$class = 'form-select';
	}
	$menu = '';
	if ($session > 1){
			$menu .= mylanguage_menu_l(mylanguage_t_ethnic('Previous'),
				'discuss/'. $hl_id .'/' . ($session -1),
				'back_blue_24x24.png'
				)  . '&nbsp;&nbsp;&nbsp;&nbsp;'; 
	}
	if ($session < 20){
			$menu .= mylanguage_menu_l(mylanguage_t_ethnic('Next'),
				'discuss/'. $hl_id .'/' . ($session + 1),
				'forward_blue_24x24.png'
				); 
	}
	$form['conversation'] = array(
		'#type' => 'select',
		'#button' => $menu,
		'#default_value' => $session,
		'#class' => $class,
		'#mytitle' =>translate('Conversation'),
		'#theme' => 'mylanguage_select_mobile',
		'#options'=> $conversations,
		'#attributes' => array('onchange' => 'form.submit("mylanguage_page_discuss_select_form")'),
	 );
	 

	$form['submit'] = array(
	  '#type' => 'image_button',
		'#src' => mylanguage_url_file() . 'icons/blank_1x1.png',
    '#value' =>translate('Watch Segment'),
    );
	return $form;
}
function page_discuss_select_form_submit ($form, &$form_state){
	$form_state['redirect'] = 'discuss/'. $_SESSION['mylanguage_hl_id'] . '/'. $form_state['values']['conversation'];
	return;
}
function page_discuss_q ($nmbr, $hl_id = 'eng00', $dir = 'ltr'){
	$question = '';
	db_set_active('common');
	$data = db_query('SELECT question FROM dbm_questions 
		WHERE nmbr = :nmbr AND hl_id = :hl_id',
		array( ':nmbr' => $nmbr,':hl_id' => $hl_id)) ->fetchObject();
	db_set_active('default');
	if (isset($data->question)){
		$question .=  $nmbr . '.'. $data->question . "\n";
	}
	else{
		db_set_active('common');
		$data = db_query('SELECT question FROM dbm_questions 
			WHERE nmbr = :nmbr AND hl_id = :hl_id',
			array( ':nmbr' => $nmbr,':hl_id' => 'eng00')) ->fetchObject();
		db_set_active('default');
		if (isset($data->question)){
			$question .=  $nmbr . '.'. $data->question  . "\n";
		}
		$dir = "ltr";
	}
	db_set_active('default');
	$output = '<p> <span dir="'. $dir . '">' . $question . '</span></p>' . "\n";
	return $output;
}
