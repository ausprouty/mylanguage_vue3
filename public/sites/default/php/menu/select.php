//langauge select options
function select(){
	$a = drupal_get_form('mylanguage_select_form');
    $output .= drupal_render($a);
return $output;
}
function select_form($form, &$form_state) {
  $results =  sqlFetchObject ('SELECT name, hl_id from my_language 
	WHERE jfilm = :jfilm ORDER BY name ',
	array(':jfilm' => 'Y'	));
  foreach($results as $data){
    $id = $data->hl_id;
    $name = $data->name;
    $languages[$id] = substr($name, 0, 20);
  }
  $default_langauge = isset($_SESSION['mylanguage_hl_id']) ? $_SESSION['mylanguage_hl_id']: 'eng00';
  $form['language']=array(
    '#type' => 'select',
    '#options' => $languages,
    '#default_value' => $default_langauge,
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' =>translate('View Resources'),
  );   
  return $form;
}
function select_form_submit($form, &$form_state){
  $_SESSION['mylanguage_hl_id'] = $form_state ['values']['language'] ;
  $form_state['redirect'] = 'intro/' . $form_state ['values']['language'] ;
  return;
}
function select_aboriginal_form($form, &$form_state) {
  $results =  sqlFetchObject ('SELECT name, hl_id from my_language_aboriginal 
	WHERE not_aboriginal IS NULL AND hl_id IS NOT NULL ORDER BY name');
  foreach ($results as $data){
    $id = $data->hl_id;
    $name = $data->name;
    if ($id) {$languages_aboriginal[$id] = $name;}
  }
  $default_language = isset($_SESSION['mylanguage_hl_id'])? $_SESSION['mylanguage_hl_id'] :'eng00';
  $form['language']=array(
    '#type' => 'select',
    '#options' => $languages_aboriginal,
    '#default_value' => $default_language,
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' =>translate('View Resources'),
  );   
  return $form;
}
function select_aboriginal_form_submit($form, &$form_state){
  $_SESSION['mylanguage_hl_id'] = $form_state ['values']['language'] ;
  $form_state['redirect'] = 'intro/' . $form_state ['values']['language'] ;
  return;
}
function select_country_form($form, &$form_state) {
  $sql = 
  $results =  sqlFetchObject ('SELECT name, hl_id from my_language_country 
	ORDER BY name');
  foreach($results as $data){
    $id = $data->hl_id;
    $name = $data->name;
    $languages_country[$id] = $name;
  }
  $default_language = isset($_SESSION['mylanguage_hl_id'])?$_SESSION['mylanguage_hl_id'] : 'eng00';
  $form['language']=array(
    '#type' => 'select',
    '#options' => $languages_country,
    '#default_value' => $default_language,
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' =>translate('View Resources'),
  );   
  return $form;
}
function select_country_form_submit($form, &$form_state){
  $_SESSION['mylanguage_hl_id'] = $form_state ['values']['language'] ;
  $form_state['redirect'] = 'intro/' . $form_state ['values']['language'] ;
  return;
}//show
<?php

function select_ethnic() {
	$output = '';
  $results =  sqlFetchObject ('SELECT ethnic_name, name,  hl_id from my_language 
	WHERE jfilm = :jfilm ORDER BY ethnic_name',
	array(':jfilm' => 'Y'	));
  foreach($results as $data){
    $id = $data->hl_id;
	if ($data->ethnic_name){
		$name = $data->ethnic_name;
	}
	else{
		$name = $data->name;
	}
    $link = link($name, '/intro/' . $id);
	$output .= $link . '&nbsp;&nbsp;&nbsp;&nbsp;';
  }
  return $output;
}
function select_translated_form($form, &$form_state) {
	// do not show if english
	if (!isset($_SESSION['mylanguage_browser_hl_id'])){
		return;
	}
	if ($_SESSION['mylanguage_browser_hl_id'] == 'eng00'){
	}
	$bible_brain = sqlFetchObject('SELECT bible_brain FROM my_language
		WHERE hl_id = :hl_id LIMIT 1',
		array(':hl_id'=> $_SESSION['mylanguage_browser_hl_id']))->fetchField();
	$query = db_select('my_language', 'l');
	$query->innerjoin('my_language_translation', 't', 'l.bible_brain = t.language_number');
	$query->fields('l', array('hl_id'))
		->fields ('t', array('translation'))
		->condition('jfilm', 'Y','=')
		->condition('translation_language_number', $bible_brain,'=')
		->isNotNull('bible_brain');
	$results = $query->execute();	
  foreach($results as $data){
    $id = $data->hl_id;
    $name = $data->translation;
    $languages[$id] = substr($name, 0, 20);
	asort($languages);
  }
  $default_langauge = isset($_SESSION['mylanguage_hl_id']) ? $_SESSION['mylanguage_hl_id']: 'eng00';
  $form['language']=array(
    '#type' => 'select',
    '#options' => $languages,
    '#default_value' => $default_langauge,
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' =>translate('View Translated Resources'),
  );   
  return $form;
}
function select_translated_form_submit($form, &$form_state){
  $_SESSION['mylanguage_hl_id'] = $form_state ['values']['language'] ;
  $form_state['redirect'] = 'intro/' . $form_state ['values']['language'] ;
  return;
}
