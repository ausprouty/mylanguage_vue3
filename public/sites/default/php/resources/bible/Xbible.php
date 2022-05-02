<?php




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
