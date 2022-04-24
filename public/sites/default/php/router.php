unction mylanguage_menu() {
	$items = array();
	 $items['language/autocomplete'] = array(
		'page callback' => 'mylanguage_language_autocomplete',
		'access callback' => TRUE,
		'page arguments' => array(2),
		'type' => MENU_CALLBACK
  );
	$items[''] = array(
		'page callback' => 'mylanguage_page_front',
		'page arguments' => array(1), // hl_id ,
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['ask'] = array(
		'page callback' => 'mylanguage_page_ask',
		'page arguments' => array(1), // hl_id ,
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['bible'] = array(
		'page callback' => 'mylanguage_page_bible',
		'page arguments' => array(1,2), // hl_id,   chapter
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
		
	);
	$items['bible_home'] = array(
		'page callback' => 'mylanguage_page_bible',
		'page arguments' => array(1,2), // hl_id,   chapter
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['chinese_change'] = array(
		'page callback' => 'mylanguage_chinese_change',
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['discuss/%'] = array(
		'page callback' => 'mylanguage_page_discuss',
		'page arguments' => array(1), // hl_id ,
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['debug'] = array(
		'page callback' => 'mylanguage_debug',
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['hereslife'] = array(
		'page callback' => 'mylanguage_hereslife',
		'page arguments' => array(1), // hl_id ,
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['injeel'] = array(
		'page callback' => 'drupal_get_form',
		'page arguments' => array('mylanguage_injeel_request_form'),
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['injeel/mylanguage_page_thank'] = array(
		'page callback' => 'mylanguage_injeel_request_mylanguage_page_thanks',
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	
	$items['intro'] = array(
		'page callback' => 'mylanguage_page_front',
		'page arguments' => array(1), // hl_id ,
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['languages'] = array(
		'page callback' => 'mylanguage_front_page',
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['links_online'] = array(
		'page callback' => 'mylanguage_menu_links_online',
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['listen_online'] = array(
		'page callback' => 'mylanguage_listen_online',
		'page arguments' => array(1,2,3,4), //$hl_id = 'eng00', $title = NULL, $listen_part = NULL,$listen_id = NULL
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['listen_program'] = array(
		'page callback' => 'mylanguage_listen_program',
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['more'] = array(
		'page callback' => 'mylanguage_more',
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['mylanguage_page_thank/%'] = array(
		'page callback' => 'mylanguage_page_thank',
		'page arguments' => array(1),
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['mylanguage_tracts_home'] = array(
			'page callback' => 'mylanguage_tracts_home',
			'access callback' => TRUE,
			'type' => MENU_CALLBACK,
	);
	$items['meet'] = array(
		'page callback' => 'meet',
		'page arguments' => array(1),
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['read_bilingual_booklet'] = array(
		'page callback' => 'mylanguage_read_bilingual_booklet',
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['read_bilingual_page'] = array(
		'page callback' => 'mylanguage_page_bilingual_read',
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	
	$items['select'] = array(
		'page callback' => 'mylanguage_select',
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['show'] = array(
		'page callback' => 'mylanguage_show',
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['spirit-filled'] = array(
		'page callback' => 'mylanguage_hspirit',
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['study_online'] = array(
		'page callback' => 'mylanguage_page_study',
		'page arguments' => array(1, 2), // hl_id, page
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
    $items['study_home'] = array(
		'page callback' => 'mylanguage_study_home',
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['tracts_home'] = array(
			'page callback' => 'mylanguage_tracts_home',
			'access callback' => TRUE,
			'type' => MENU_CALLBACK,
	);
	$items['tracts_online'] = array(
		'page callback' => 'meet',
		'page arguments' => array(1),
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	
	$items['jfilm'] = array(
		'page callback' => 'mylanguage_page_jfilm',
		'page arguments' => array(1, 2, 3),  // hl_id, movie, film_code
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
	$items['watch_video'] = array(
		'page callback' => 'mylanguage_page_jfilm_video',
		'access callback' => TRUE,
		'type' => MENU_CALLBACK,
	);
return $items;
}