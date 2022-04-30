<?php

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
	
    $bid = sqlFetchObject('SELECT bid FROM dbm_bible
		WHERE hl_id = :hl_id AND (collection_code = :nt OR collection_code = :fu )
		AND text = :y1
		ORDER BY weight DESC LIMIT 1',
        array(':hl_id' =>$hl_id,
				':y1' => 'Y',
				':nt' => 'NT',
				':fu' => 'FU'))
		->fetchField();

	if (!empty($bid)){
		
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
