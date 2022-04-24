<?php
function page_jfilm($hl_id = 'eng00', $movie = 'JESUS', $video = NULL) {
	// error for chinese using old references
	if ($hl_id == 'chn00'){
		$hl_id = 'chn06';
	}
	$watch = array();

	$output = '';;
	drupal_add_js('
	function showForm() {
		document.getElementById(\'download\').style.display = \'block\';
	}
	function showEmailForm() {
		document.getElementById(\'email\').style.display = \'block\';
	} ', 'inline');
	global $language;
	mylanguage_meta('jfilm');
	if ($hl_id !='') {
		// make sure valid code (and not from mypage/chris giving value of chris)
		db_set_active('hl_online');
		$data = db_query('SELECT id FROM hl_online_jfilm
			WHERE hl_id = :hl_id LIMIT 1', 
			array(':hl_id' =>$hl_id)) ->fetchObject();
		db_set_active('default');
		if (!isset($data->id)) {
			$hl_id = 'eng00';
		}
	}
	else {
		$hl_id = 'eng00';
	}
	$_SESSION['mylanguage_hl_id'] = $hl_id;
	//return '3997';
	mylanguage_language($hl_id);
	//return '3999';
	if (empty($video)){
		$video = mylanguage_page_jfilm_options($hl_id);
	}
	//return '4003';
	db_set_active('hl_online');
	$data = db_query('SELECT * FROM hl_online_jfilm 
		WHERE film_code = :film_code LIMIT 1',
		array(':film_code' =>$video))
		->fetchObject();
	db_set_active('default');
	// what if they messed up the url?
	if (!isset($data->id)){
		db_set_active('hl_online');
		$data = db_query('SELECT * FROM hl_online_jfilm 
			WHERE hl_id = :hl_id AND title = :title LIMIT 1',
			array(':hl_id' =>$hl_id, ':title' => 'JESUS' ))
			->fetchObject();
		$movie = 'JESUS';
		$video = $data->film_code;
	}
	db_set_active('default');
	//return '4018';
	// title
	if (empty($movie)){
		$movie = 'JESUS';
	}
	$lang = empty($data->language_ethnic)? $data->language : $data->language_ethnic;
	$output .= '<h2>' . t($data->title) . ' ('. $lang . ')</h2>' ."\n";	
	if ($movie == 'JESUS' || $movie == 'Magdalena'){
		$a = drupal_get_form('mylanguage_page_jfilm_segments_form', $hl_id, $movie, $video);
		$output .= drupal_render($a);
	}
	// email a friend
	
	//$output .=  '<a class = "button" href="javascript:void(0)" onclick="showEmailForm()">'. mylanguage_t_browser('Click here to email to a friend') . '</a> </div>'."\n";
	//$output .= '<div id = "email" style = "display:none;margin-left:40px;">' ."\n";
	//$output .= drupal_render(drupal_get_form('mylanguage_tell_friend_form', $hl_id, $video));
	//$output .= '</div>';
	// show video & questions
	
	// show video
	$is_mobile = mylanguage_find_is_mobile();
	if ($is_mobile){
		$height = 300;
	}
	else{
		$height = 600;
	}
	$output .= '<div class="arc-cont">';
	$output .= '<iframe src="https://api.arclight.org/videoPlayerUrl?refId='. $video . '&apiSessionId=5820dc420e4bb0.85192489&playerStyle=default&player=bc.vanilla5" allowfullscreen webkitallowfullscreen mozallowfullscreen>
  </iframe>
   <style>
	.arc-cont{position:relative;display:block;margin:10px auto;width:100%}.arc-cont:after{padding-top:59%;display:block;content:""}.arc-cont>
	iframe{position:absolute;top:0;bottom:0;right:0;left:0;width:98%;height:98%;border:0}</style>
	</div>';
	// questions
	$output .= mylanguage_page_bible_questions();
	// downlod link
	//$output .= '<div id = "download_link" style = "display:inline;">'."\n";
	//$output .=  '<a href="javascript:void(0)" onclick="showForm()"><h1>'. mylanguage_t_browser('Download Video') . '</h1></a> </div>'."\n";
	//$output .= '<div id = "download" style = "display:none;">' ."\n";
	//$output .= '<iframe width="600" height="500" src="https://jesusfilmmedia.org/download/accept?refid=' . $video . '">Click to close window</iframe>'."\n";
	//$output .= '</div>';

	return $output;
}
function page_jfilm_segments_form ($form, &$form_state, $hl_id, $movie = 'JESUS', $film_code){
	$f = explode('-', $film_code); //1_10014-jf6128-0-0
	$film = $f[0] . '-'; //1-10014
	$segment = array();
  $segment[]= mylanguage_t_ethnic('SELECT SEGMENT');
	if ($movie == 'JESUS'){
		$luke = mylanguage_t_ethnic('Luke');
		db_set_active('hl_online');
		$results = db_query('SELECT * FROM hl_online_jfilm
			 WHERE film_code LIKE :film_code AND movie = :movie ORDER BY segment',
			 array(':film_code' => $film .'%', ':movie' => $movie));
		db_set_active('default');
	  foreach($results as $data){
			 if ($data->segment == 1 || $data->film_code == $film_code){
				 $default = $data->film_code;	
			 }
			 if ($data->segment ==2){
				  // see if ethnic word for Luke is added
				 if (!is_numeric(substr(trim($data->luke),0,1))){
					 $luke = '';
				 }
			 }
			 if ($data->segment == 1 || $data->segment == 61){
				 $segment[$data->film_code] = $data->segment. '. '. t("$data->title");
			 }
			 else{
				$segment[$data->film_code] = $data->segment. '. '. t("$data->title") . '  ('. $luke . ' '. $data->luke  .')';
			 }
			
		}
	}
	else{
		db_set_active('hl_online');
	   $results = db_query('SELECT * FROM hl_online_jfilm
			 WHERE film_code LIKE :film_code AND title LIKE :movie ORDER BY id',
			 array(':film_code' => $film .'%', ':movie' => 'Magdalena (7 clips)%'));
		db_set_active('default');
	    $i = 1;
		foreach($results as $data){
		   $segment[$data->film_code] = $i. '. '. substr($data->title, 32);
			 if ($data->segment == 1 || $data->film_code == $film_code){
				 $default = $data->film_code;
			 }
		   $i++;
	   }
    }
	if (count($segment) < 2){
		return $form;
	}
	db_set_active('hl_online');
	$data = db_query('SELECT * FROM hl_online_jfilm
			WHERE film_code = :film_code',
			array(':film_code' => $film_code))->fetchObject();
	$fc = substr($film_code, 0, -6) .'%';
	 db_set_active('default');
	$menu = mylanguage_menu_l(mylanguage_t_ethnic('Download Video'),
		$data->share_short_url,
		'download_blue_24x24.png'
	) . '&nbsp;&nbsp;&nbsp;&nbsp;'; 

	if ($data->segment > 1){
		db_set_active('hl_online');
		$watch = db_query ('SELECT film_code FROM hl_online_jfilm
			WHERE film_code LIKE :film_code AND segment = :segment',
		 array(':film_code' => $fc , ':segment' =>  $data->segment -1)) ->fetchField();
		 db_set_active('default');
		if (!empty($watch)){
			$menu .= mylanguage_menu_l(mylanguage_t_ethnic('Previous Segment'),
				'jfilm/'. $hl_id .'/' . $movie . '/'. $watch,
				'back_blue_24x24.png'
				)  . '&nbsp;&nbsp;&nbsp;&nbsp;'; 
		}
	}
	if ($data->segment > 0){
		db_set_active('hl_online');
		$watch = db_query ('SELECT film_code FROM hl_online_jfilm
				WHERE film_code LIKE :film_code AND segment = :segment',
       array(':film_code' => $fc , ':segment' => $data->segment +1)) ->fetchField();
		db_set_active('default');
		if (!empty($watch)){
			$menu .= mylanguage_menu_l(mylanguage_t_ethnic('Next Segment'),
				'jfilm/'. $hl_id .'/' . $movie . '/'. $watch,
				'forward_blue_24x24.png'
				); 
		}
	}
	$form['hl_id'] = array(
		'#type' => 'value',
		'#default_value' => $hl_id,
	);
	$form['movie'] = array(
		'#type' => 'value',
		'#default_value' => $movie,
	);
  if (mylanguage_find_is_mobile()){
		$class = 'form-select-mobile';
	}
	else{
		$class = 'form-select';
	}
	
    $form['video'] = array(
      '#type' => 'select',
			'#button' => $menu,
	    '#default_value' => $film_code,
			'#class' => $class,
      '#mytitle' => mylanguage_t_ethnic('Segment'),
			'#theme' => 'mylanguage_select_mobile',
      '#options'=> $segment,
			'#attributes' => array('onchange' => 'form.submit("mylanguage_page_jfilm_segments_form")'),
     );
		 

	$form['submit'] = array(
	  '#type' => 'image_button',
		'#src' => mylanguage_url_file() . 'icons/blank_1x1.png',
    '#value' => mylanguage_t_ethnic('Watch Segment'),
    );
	return $form;
}
function page_jfilm_segments_form_submit ($form, &$form_state){
	$form_state['redirect'] = 'jfilm/' . $form_state['values']['hl_id'] 
							 .'/'. $form_state['values']['movie']
	                        .'/'. $form_state['values']['video'];
	return;
}
function page_jfilm_options($hl_id = 'eng00'){
	db_set_active('default');
	$jesus_video = '';
	$mag_video = '';
	$child_video = '';
	db_set_active('hl_online');
	$results = db_query ('SELECT film_code, title, weight FROM hl_online_jfilm 
		WHERE hl_id = :hl_id  AND 
		(title = :title1 OR title = :title2 OR title  = :title3)', 
		array(':hl_id' =>$hl_id , 
			':title1'=> 'JESUS', 
			':title2'=>'The Story of JESUS for Children',
			':title3'=> 'Magdalena' )
	);
	db_set_active('default');
	$weight = -10;
	foreach ($results as $data){
		if (preg_match("/for Children/i", $data->title)) {
			$child_video = $data->film_code;
		}
		if (preg_match("/Magdalena/i", $data->title)) {
			$mag_video = $data->film_code;
		}
		if ( $data->title == 'JESUS') {
			if ($data->weight > $weight){
				$jesus_video =  $data->film_code;
				$weight = $data->weight;
			}
		}
	}
	if ($jesus_video) { 
	  // for mobile you want the 12th segment according to Vance,
	  // but for Chinese you definately want 1
		if (mylanguage_find_is_mobile()){
			$f = explode('-', $jesus_video); //1_10014-jf6128-0-0
			$film_code  = $f[0] . '-jf6'; //1-10014

			db_set_active('hl_online');
			$v = db_select('hl_online_jfilm', 'j')
				->fields('j', array('film_code'))
				->condition('film_code',  db_like($film_code) . '%', 'LIKE')
				->condition('segment', 1, '=')
				->range(0, 1)
				->execute()
				->fetchObject();
			db_set_active('default');
			
			$video = $v->film_code;
			
		}
		else{
			$video = $jesus_video;
		}
		
	}
	elseif ($child_video) { 
	 	$video = $child_video;
	}
	elseif ($mag_video) { 
	   if (mylanguage_find_is_mobile()){
			$f = explode('-', $mag_video); //1_10014-jf6128-0-0
	    $film_code  = $f[0] . '-%'; //1-10014
			db_set_active('hl_online');
			$video = db_query ('SELECT film_code  FROM hl_online_jfilm 
				WHERE film_code LIKE :film_code  AND segment = 1', 
				array(':film_code' =>$film_code))-> fetchField(); 
			db_set_active('default');
		}
		else{
			$video = $mag_video;
		}
	}
	return $video;
}
function page_study($hl_id = 'eng00', $page = 1) {
	mylanguage_meta('study_online');
	global $base_url;
	$root = mylanguage_shared_dir() ;
	
  if ($hl_id) {
    $_SESSION['mylanguage_hl_id'] = $hl_id;
  }
 
  $hl_id = mylanguage_hl_validate();
   
  $output = '';
  mylanguage_language($hl_id);
  //return "line 3000";
  $output .= '<h1>' . mylanguage_t_ethnic('Adventure') . '</h1>';
  if (isset($_SESSION['mylanguage_chinese']) || $hl_id == 'chn00'){
    $hl_id = 'chn-s';
	if (!isset($_SESSION['mylanguage_chinese_written'])){
		$_SESSION['mylanguage_chinese_written'] = 'chn-s';
	}
    if ($_SESSION['mylanguage_chinese_written'] == 'chn-t') {$hl_id = 'chn-t';}
    $output .= mylanguage_chinese_display('study_online'); 
  }
  $data = db_query('SELECT * from hl_spirit 
		WHERE hl_id = :hl_id LIMIT 1', 
		array(':hl_id' =>$hl_id))->fetchObject();
	if (!isset($data->webpage)){
		$data = db_query('SELECT * from hl_spirit 
			WHERE hl_id = :hl_id LIMIT 1', 
			array(':hl_id' =>'eng00'))->fetchObject();
	}
	$webpage = $data->webpage;
	$this_dir = str_replace('default.htm', '', $webpage); //does not work for html
	$image_dir =  mylanguage_shared_dir()  . $this_dir;
	$image_url =  mylanguage_getExternalSharedUrl(). $this_dir;
	// if page is not made of images
  if ($data->name && $data->images == 0){
		$p =  file_get_contents(mylanguage_shared_dir() . $webpage);
		$p = str_ireplace('src="images', 'src="'. $image_url . '/images', $p);
		$p = str_ireplace('src="/sites', 'src="'. $base_url . '/sites', $p);
		if (!$data->convert_this){ // some need conversion; others do not.  I put an 'N' for those that do not need conversion
			$p = iconv("ISO-8859-1", "UTF-8//TRANSLIT", $p);
		}
		$output .= $p;
  }
	// we are working with images
  elseif ($data->name && $data->images > 0){
	$output .= '<div align = "center">';
	$show_image = 'images/page'. $page .'-lg.gif';
	$width = 600;
	if( !file_exists ( $image_dir . $show_image)){
		$show_image =  'images/page'. $page .'.gif';
		$width = 300;
		if( !file_exists ( $image_dir . $show_image)){
		   $show_image = NULL;
		}
	}
	if (!empty($show_image)){
		$output .= '<img width="'. $width . '" src = "'.$image_url .  $show_image . '">'. "\n";
		$output .= '<br><br>';
	}
	$nextpage = $page + 1;
	$width = 600;
	$show_image =  'images/page'. $nextpage .'-lg.gif';
	if( !file_exists ( $image_dir . $show_image)){
		$width = 300;
		$show_image =   'images/page'. $nextpage .'.gif';
	}
	$output .= '<img width="'. $width . '" src = "'.$image_url . $show_image . '">'. "\n";
	$output .= '<br>';
	
	
	if ($page > 1){
		$image = '<img src = "'. $image_url . 'images/leftarrow.gif">';
		$path = 'study_online/'. $hl_id . '/'. ($page - 2); 
		$options['html'] = TRUE;
		$output .= l($image, $path, $options) .'&nbsp;&nbsp;&nbsp;&nbsp;' . "\n";
	}
	if ($page < $data->images - 1){
		$image = '<img src = "'. $image_url . 'images/rightarrow.gif">';
		$path = 'study_online/'. $hl_id . '/'. ($page + 2); 
		$options['html'] = TRUE;
		$output .= l($image, $path, $options) .'&nbsp;&nbsp;&nbsp;&nbsp;' . "\n";
	}
	$output .= '<br>';
	$output .= '</div>';
  }
  return $output;
}
