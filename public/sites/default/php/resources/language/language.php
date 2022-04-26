<?php

function language($hl_id){
	db_set_active('default');
	global $language;
	$drupal = db_query('SELECT drupal FROM my_language
		WHERE hl_id = :hl_id LIMIT 1',
		array(':hl_id' =>$hl_id)
	) ->fetchField();
	if (empty($drupal)){
		$drupal = 'en';
	}
	$l = db_query('SELECT * FROM languages 
			WHERE language = :drupal',
			array(':drupal' => $drupal))->fetchAll();
	if (empty($l)){
		$l = db_query('SELECT * FROM languages 
			WHERE language = :drupal',
			array(':drupal' => 'en'))->fetchAll();
	}
	$language = $l[0];
	$_SESSION['mylanguage_ethnic_language'] = $language;
	$_SESSION['mylanguage_hl_id'] = $hl_id;
	mylanguage_chinese($hl_id);
	return $hl_id;
}
function language_autocomplete($string){
	if(empty($string)){return;}
  $matches = array();
	// if only ascii look in name
	if(!preg_match('/[^\x20-\x7f]/', $string)){
		$query = db_select('my_language', 'l');
		$return = $query
			->fields('l', array('name'))
			->condition('l.name', '%' . db_like($string) . '%', 'LIKE')
			->condition ('l.hl_id', '', '!=')
			->range(0, 10)
			->execute();
		// add matches to $matches  
		foreach ($return as $row) {
			$matches[$row->name] = check_plain($row->name);
		}
	}
	$query = db_select('my_language', 'l');
	$return = $query
    ->fields('l', array('ethnic_name'))
		->condition('l.ethnic_name', '%' . db_like($string) . '%', 'LIKE')
		->condition ('l.hl_id', '', '!=')
    ->range(0, 10)
    ->execute();
  // add matches to $matches  
  foreach ($return as $row) {
    $matches[$row->ethnic_name] = check_plain($row->ethnic_name);
  }
  // return for JS
  drupal_json_output($matches);
}
function language_iso($hl_id){
	$iso = db_query('SELECT language_iso FROM my_language
		WHERE hl_id = :hl_id',
		array(':hl_id' => $hl_id))
		->fetchField();
	if ($iso == NULL){
		$iso = db_query('SELECT language_iso FROM my_language
		WHERE hl_id = :hl_id',
		array(':hl_id' => 'eng'))
		->fetchField();
	}
	return $iso;
}
function language_from_browser(){
	global $language;
	$language_browser = mylanguage_find_browser_language();
	if ($language_browser){
		$language_browser = substr($language_browser, 0,2);
	}
	$hl_id = db_query('SELECT hl_id FROM my_language
		WHERE language_browser = :language_browser',
		array(':language_browser' => $language_browser))
		->fetchField();
	if ($hl_id == NULL){
		$hl_id =  'eng';
	}
	$_SESSION['mylanguage_browser_hl_id']= $hl_id;
	
	$drupal = db_query('SELECT drupal FROM my_language
		WHERE hl_id = :hl_id LIMIT 1',
		array(':hl_id' =>$hl_id)
	) ->fetchField();
	if (empty($drupal)){
		$drupal = 'en';
	}
	$l = db_query('SELECT * FROM languages 
			WHERE language = :drupal',
			array(':drupal' => $drupal))->fetchAll();
	if (empty($l)){
		$l = db_query('SELECT * FROM languages 
			WHERE language = :drupal',
			array(':drupal' => 'en'))->fetchAll();
	}
	$language = $l[0];
	$_SESSION['mylanguage_browser_language'] = $language;
	return $hl_id;
}
function language_select_form($form, &$form_state){
	// from https://timonweb.com/posts/how-to-create-an-ajax-autocomplete-textfield-in-drupal-7/
	$form ['language'] = array(
	  '#type' => 'textfield',
		'#title' =>translate('Other Languages'),
		'#size'=> 20,
		'#autocomplete_path' =>'language/autocomplete',
	);
	$form ['submit'] = array(
		'#type' => 'submit',
		'#value'=>translate('Find'),
		'#suffix' => '<br><br>'
	);
	return $form;
}
function language_select_form_submit($form, &$form_state){
	$hl_id = db_query ('SELECT hl_id FROM my_language
		WHERE name = :name OR ethnic_name = :ethnic',
		array(':name' => $form_state ['values']['language'],
			':ethnic' => $form_state ['values']['language']
		)) ->fetchField();
  if ($hl_id){
		$_SESSION['mylanguage_hl_id'] = $hl_id;
	  $form_state['redirect'] = '/intro/' . $hl_id ;
	}
  return;
}
function language_in_my_language($language_iso){
	$output = '';
	$language_number = db_query('SELECT bible_brain FROM my_language	
		WHERE language_iso = :language_iso LIMIT 1',
		array(':language_iso' => $language_iso))->fetchField();
	if ($language_number){
		$result = db_query('SELECT language_number, translation FROM my_language_translation	
			WHERE translation_language_number = :language_number 
			ORDER BY translation',
			array(':language_number' => $language_number));
		foreach ($result as $data){
			$hl_id = db_query('SELECT hl_id FROM my_language
				WHERE bible_brain = :bible_brain LIMIT 1',
				array(':bible_brain' => $data->language_number))->fetchField();
			if ($hl_id){
				$output .=  $hl_id . ' - '. $data->translation . '<br>';
			}
		}
	}
	return $output;
}
function language_translation_deduplicate(){
	$output = '';
	$result = db_query('SELECT distinct language_number  FROM my_language_translation');
	foreach ($result as $language_number){
		$result2 = db_query('SELECT distinct translation_language_number  FROM my_language_translation
			WHERE language_number = :language_number',
			array(':language_number' => $language_number->language_number));
		foreach ($result2 as $translation_language_number){
			$result3 = db_query('SELECT id FROM my_language_translation
				WHERE language_number = :language_number  AND  translation_language_number = :translation_language_number',
				array(':language_number' => $language_number->language_number, ':translation_language_number' => $translation_language_number->translation_language_number));
			$count = 1;
			foreach ($result3 as $found){
				if ($count != 1){
					$output .= $language_number->language_number .'-'. $translation_language_number->translation_language_number. '<br>';
					db_delete('my_language_translation')
					  ->condition('id', $found->id)
					  ->execute();
				}
				$count++;
			}
		}
	}
return $output;	
}
