<?php


function menu_block_format_191($image, $alt, $content){

	$output = '<div class="block-191">';
	$output .= '<p class = "title"><img  src = "'. ROOT_URL . '/' . file_stream_wrapper_get_instance_by_uri('public://')->getDirectoryPath()  .'/img/' . $image . '" alt = "'. $alt. '">';
	$output .= $content;
	$output .='<div class="block-bottom-191"></p></div>';
    $output .= '</div>';
  return $output;
}
function menu_block_format_541($image, $alt, $content){
  $output = '<div class="block-541">';
  $output .= '<p class = "title"><img  src = "sites/mylanguage.net.au/themes/twentyten/img/' . $image . '" alt = "'. $alt .'"></p>';
  $output .= '<p align = "center">' . $content .  '</p>';
  $output .= '</div><div class="block-bottom-541"></div>';
  return $output;
}
function menu_button_load($hl_id, $image_name, $source, $text){
  $_SESSION['debug'] .= 'from button load <br>';
  // for button 125x164
  // get font
  $font_dir = mylanguage_realpath_files() .'/fonts/';
  $result = sqlFetchObject('SELECT font, direction, chinese from my_language WHERE hl_id = :hl_id', array(':hl_id' => $hl_id)) ->fetchObject();
  $data = db_fetch_object($result);
  $font = $data->font;
  $data_direction = $data->direction;
  if ($hl_id == 'urd00') {$data_direction = 'ltr';}
  if (!$font) {$font = 'tahoma.ttf';}
  $font = $font_dir . $font;
  $chinese = $data->chinese;

   //get image
  $image_dir = mylanguage_realpath_files() .'/options/';
  $photo = $image_dir . $source;
  $image= ImageCreateFromJPEG($photo) or die ("failed to create");
  $background = ImageColorAllocate($image,255, 255, 255);
  $white = ImageColorAllocate($image,255, 255, 255);

  if ($data_direction == 'rtl'){
    $text = mylanguage_rtl($text);
  }

  // decide if one line or two
  //$_SESSION['debug'] .= '<br> text:' . $text;
  $limit = 18;

  $line1 = '';
  $line2 = '';
  if (strlen($text) > $limit) {
    $line = 1;
    if ($hl_id != 'jpn00' && $hl_id != 'kkn00' && !$chinese) {
      $words = explode(' ', $text);
      $space = ' ';
    }
    else {
      $words = $a = preg_split("//u", $text);
      $limit = 9;
      $space = '';
    }
    foreach ($words as $word){
   //   $_SESSION['debug'] .= '<br><br> word:' . $word;
   //   $_SESSION['debug'] .= '<br> line1:' . $line1;
   //   $_SESSION['debug'] .= '<br> line2:' . $line2;
      $len_this = strlen(utf8_decode($word));
      if ($line == 1){
        $len_curr = strlen(utf8_decode($line1));
        if ($len_this + $len_curr < $limit || !$line1){
          $line1 .= $space . $word;
        }
        else{
          $line = 2;
        }
      }
      if ($line == 2){
        $line2 .= ' ' . $word;
      }
    }
    if ($data_direction == 'rtl'){
       $temp = $line1;
       $line1 = $line2;
       $line2 = $temp;
    }
  }
  else {
     $line1 = $text;
     $line2 = '';
  }
  $text_size1 = 10;
  $text_size2 = 10;
  $line1 = trim($line1);
  $line2 = trim($line2);
  $len_line1 = strlen(utf8_decode($line1));
  $len_line2 = strlen(utf8_decode($line2));
  if ($len_line2 > $limit) {
     $text_size2 = 8;
  }

  $pad = (($limit - $len_line1)/2);
  if ($chinese) {$pad = 0;}
  for( $i=1; $i<$pad; $i++){
     $line1 = ' '. $line1;
  }
  $pad = (($limit - $len_line2)/2);
   if ($chinese) {$pad = 0;}
  for( $i=1; $i<$pad; $i++){
     $line2 = ' '. $line2;
  }
 // $_SESSION['debug'] .= '<br><br>'. $hl_id ;
 // $_SESSION['debug'] .= '<br>' . $line1 . '--' . $len_line1;
 // $_SESSION['debug'] .= '<br>' . $line2 . '--' . $len_line2 .'<br>';
  $start_x = 4;
  ImageTTFText($image,$text_size1 ,0 ,$start_x ,132 ,$white,$font,$line1);
  ImageTTFText($image,$text_size2 ,0,$start_x ,150 ,$white,$font,$line2);
   $real_image_name = mylanguage_realpath_files(). '/'.  $image_name;
  ImageJPEG($image,$real_image_name, 100);
  return ;
}
function menu_button_load_175($hl_id, $image_name, $source, $text){
  $_SESSION['debug'] .= 'from button load <br>';
  // get font
  $font_dir = mylanguage_realpath_files() .'/fonts/';
  $data = sqlFetchObject('SELECT font, direction, chinese from my_language
	WHERE hl_id = :hl_id',
	array(':hl_id' => $hl_id))
	->fetchObject();
  $font = $data->font;
  if (!$font) {$font = 'tahoma.ttf';}
  $font = $font_dir . $font;
  $chinese = $data->chinese;

   //get image
  $image_dir = mylanguage_realpath_files() .'/options/';
  $photo = $image_dir . $source;
  $image= ImageCreateFromJPEG($photo) or die ("failed to create");
  $background = ImageColorAllocate($image,255, 255, 255);
  $white = ImageColorAllocate($image,255, 255, 255);

  if ($data->direction == 'rtl'){
    $text = mylanguage_rtl($text);
  }

  // decide if one line or two
  //$_SESSION['debug'] .= '<br> text:' . $text;
  $limit = 18;

  $line1 = '';
  $line2 = '';
  if (strlen($text) > $limit) {
    $line = 1;
    if ($hl_id != 'jpn00' && $hl_id != 'kkn00' && !$chinese) {
      $words = explode(' ', $text);
      $space = ' ';
    }
    else {
      $words = $a = preg_split("//u", $text);
      $limit = 9;
      $space = '';
    }
    foreach ($words as $word){
      $_SESSION['debug'] .= '<br><br> word:' . $word;
      $_SESSION['debug'] .= '<br> line1:' . $line1;
      $_SESSION['debug'] .= '<br> line2:' . $line2;
      $len_this = strlen(utf8_decode($word));
      if ($line == 1){
        $len_curr = strlen(utf8_decode($line1));
        if ($len_this + $len_curr < $limit || !$line1){
          $line1 .= $space . $word;
        }
        else{
          $line = 2;
        }
      }
      if ($line == 2){
        $line2 .= ' ' . $word;
      }
    }
    if ($data->direction == 'rtl'){
       $temp = $line1;
       $line1 = $line2;
       $line2 = $temp;
    }
  }
  else {
     $line1 = $text;
     $line2 = '';
  }
  $line1 = trim($line1);
  $line2 = trim($line2);
  $len_line1 = strlen(utf8_decode($line1));
  $len_line2 = strlen(utf8_decode($line2));
  $text_size = 14;
  $pad = (($limit - $len_line1)/2);
  for( $i=1; $i<$pad; $i++){
     $line1 = ' '. $line1;
  }
  $pad = (($limit - $len_line2)/2);
  for( $i=1; $i<$pad; $i++){
     $line2 = ' '. $line2;
  }
  $start_x = 5;
  ImageTTFText($image,$text_size ,0 ,$start_x ,185 ,$white,$font,$line1);
  ImageTTFText($image,$text_size ,0,$start_x ,210 ,$white,$font,$line2);
  $real_image_name = mylanguage_path_real($image_name);
  ImageJPEG($image,$real_image_name, 75);
  return ;
}
function menu_button_load_171($hl_id, $image_name, $source, $text){
  $_SESSION['debug'] .= 'from button load <br>';
  // for button 125x164
  // get font
  $font_dir = mylanguage_realpath_files() .'/fonts/';
  $result = sqlFetchObject('SELECT font, direction, chinese from my_language WHERE hl_id = :hl_id', array(':hl_id' => $hl_id)) ->fetchObject();
  $data = db_fetch_object($result);
  $font = $data->font;
  $data_direction = $data->direction;
  if ($hl_id == 'urd00') {$data_direction = 'ltr';}
  if (!$font) {$font = 'tahoma.ttf';}
  $font = $font_dir . $font;
  $chinese = $data->chinese;

   //get image
  $image_dir = mylanguage_realpath_files() .'/options/';
  $photo = $image_dir . $source;
  $image= ImageCreateFromJPEG($photo) or die ("failed to create");
  $background = ImageColorAllocate($image,255, 255, 255);
  $white = ImageColorAllocate($image,255, 255, 255);

  if ($data_direction == 'rtl'){
    $text = mylanguage_rtl($text);
  }

  // decide if one line or two
  //$_SESSION['debug'] .= '<br> text:' . $text;
  $limit = 18;

  $line1 = '';
  $line2 = '';
  if (strlen($text) > $limit) {
    $line = 1;
    if ($hl_id != 'jpn00' && $hl_id != 'kkn00' && !$chinese) {
      $words = explode(' ', $text);
      $space = ' ';
    }
    else {
      $words = $a = preg_split("//u", $text);
      $limit = 9;
      $space = '';
    }
    foreach ($words as $word){
      $line2 = '';
      $len_this = strlen(utf8_decode($word));
      if ($line == 1){
        $len_curr = strlen(utf8_decode($line1));
        if ($len_this + $len_curr < $limit || !$line1){
          $line1 .= $space . $word;
        }
        else{
          $line = 2;
        }
      }
      if ($line == 2){
        $line2 .= ' ' . $word;
      }
    }
    if ($data_direction == 'rtl'){
       $temp = $line1;
       $line1 = $line2;
       $line2 = $temp;
    }
  }
  else {
     $line1 = $text;
     $line2 = '';
  }
  $text_size1 = 10;
  $text_size2 = 10;
  $line1 = trim($line1);
  $line2 = trim($line2);
  $len_line1 = strlen(utf8_decode($line1));
  $len_line2 = strlen(utf8_decode($line2));
  if ($len_line2 > $limit) {
     $text_size2 = 8;
  }

  $pad = (($limit - $len_line1)/2);
  if ($chinese) {$pad = 0;}
  for( $i=1; $i<$pad; $i++){
     $line1 = ' '. $line1;
  }
  $pad = (($limit - $len_line2)/2);
   if ($chinese) {$pad = 0;}
  for( $i=1; $i<$pad; $i++){
     $line2 = ' '. $line2;
  }
 // $_SESSION['debug'] .= '<br><br>'. $hl_id ;
 // $_SESSION['debug'] .= '<br>' . $line1 . '--' . $len_line1;
 // $_SESSION['debug'] .= '<br>' . $line2 . '--' . $len_line2 .'<br>';
  $start_x = 9;
  ImageTTFText($image,$text_size1 ,0 ,$start_x ,140 ,$white,$font,$line1);
  ImageTTFText($image,$text_size2 ,0,$start_x ,158 ,$white,$font,$line2);
   $real_image_name = mylanguage_realpath_files(). '/'.  $image_name;
  ImageJPEG($image,$real_image_name, 100);
  return ;
}
function menu_button_load_205($hl_id, $image_name, $source, $text){
  // for button 125x164
  // get font
  if ($hl_id == 'chn-s' || $hl_id == 'chn-t'){
	$hl_id = 'chn06';
  }
  $font_dir = mylanguage_realpath_files() .'/fonts/';
  $data = sqlFetchObject('SELECT font, direction, chinese from my_language
	WHERE hl_id = :hl_id', array(':hl_id' => $hl_id)) ->fetchObject();
	// in case url is messed up
  if (!isset($data->font)){
	$hl_id = 'eng00';
	$data = sqlFetchObject('SELECT font, direction, chinese from my_language
		WHERE hl_id = :hl_id',
		array(':hl_id' => $hl_id)) ->fetchObject();

  }
  $font = $data->font;
  $data_direction = $data->direction;
  if ($hl_id == 'urd00') {$data_direction = 'ltr';}
  if (!$font) {$font = 'tahoma.ttf';}
  if (!$font) {$font = 'ARIALUNI.TTF';}
  $font = $font_dir . $font;
  $chinese = $data->chinese;

   //get image
  $image_dir = mylanguage_realpath_files() .'/options/';

  $photo = $image_dir . $source;
  $image= ImageCreateFromJPEG($photo) or die ("failed to create in button_load_205 using $image_dir");
  $background = ImageColorAllocate($image,255, 255, 255);
  $white = ImageColorAllocate($image,255, 255, 255);

  if ($data_direction == 'rtl'){
    $text = mylanguage_rtl($text);
  }

  // decide if one line or two
  //$_SESSION['debug'] .= '<br> text:' . $text;
  $limit = 18;

  $line1 = '';
  $line2 = '';
  if (strlen($text) > $limit) {
    $line = 1;
    if ($hl_id != 'jpn00' && $hl_id != 'kkn00' && !$chinese) {
      $words = explode(' ', $text);
      $space = ' ';
    }
    else {
      $words = $a = preg_split("//u", $text);
      $limit = 9;
      $space = '';
    }
    foreach ($words as $word){
      $len_this = strlen(utf8_decode($word));
      if ($line == 1){
        $len_curr = strlen(utf8_decode($line1));
        if ($len_this + $len_curr < $limit || !$line1){
          $line1 .= $space . $word;
        }
        else{
          $line = 2;
        }
      }
      if ($line == 2){
        $line2 .= ' ' . $word;
      }
    }
    if ($data_direction == 'rtl'){
       $temp = $line1;
       $line1 = $line2;
       $line2 = $temp;
    }
  }
  else {
     $line1 = $text;
     $line2 = '';
  }
  $text_size1 = 10;
  $text_size2 = 10;
  $line1 = trim($line1);
  $line2 = trim($line2);
  $len_line1 = strlen(utf8_decode($line1));
  $len_line2 = strlen(utf8_decode($line2));
  if ($len_line2 > $limit) {
     $text_size2 = 8;
  }

  $pad = (($limit - $len_line1)/2);
  if ($chinese) {$pad = 0;}
  for( $i=1; $i<$pad; $i++){
     $line1 = ' '. $line1;
  }
  $pad = (($limit - $len_line2)/2);
   if ($chinese) {$pad = 0;}
  for( $i=1; $i<$pad; $i++){
     $line2 = ' '. $line2;
  }
  $start_x = 9;
  ImageTTFText($image,$text_size1 ,0 ,$start_x ,170 ,$white,$font,$line1);
  ImageTTFText($image,$text_size2 ,0,$start_x ,188 ,$white,$font,$line2);
  $real_image_name = mylanguage_path_real($image_name);
  ImageJPEG($image,$real_image_name, 100);
  return ;
}
function menu_cache($hl_id){
	if (!isset($_SESSION['mylanguage_browser_language'])){
		mylanguage_language_from_browser();
	}
	$browser_language = $_SESSION['mylanguage_browser_language'];
	$id = $hl_id . '-'. $browser_language->language;
	$cache = sqlFetchObject('SELECT * FROM hl_cache
		WHERE id = :id',
		array('id' => $id))->fetchObject();
	if (isset($cache->laptop_menu)){
		$is_mobile = mylanguage_find_is_mobile();
		if ($is_mobile){
			return $cache->mobile_menu;
		}
		else{
			return $cache->laptop_menu;
		}
	}
}
function menu_image_make($hl_id, $link){
	// if (!file_exists($image)) {
		mylanguage_menu_button_load_205($hl_id, $link['image'], $link['image_blank'], $link['title']);
	//}
}
function menu_image_another_language($hl_id, $i){
  if ($hl_id == 'chn-s' || $hl_id == 'chn-t'){
	$hl_id = 'chn06';
  }
  $font_dir = mylanguage_realpath_files() .'/fonts/';
  $image_dir = mylanguage_realpath_files() .'/images/';
  // main logo
  $photo_dir = mylanguage_realpath_files() .'/options/';
  if ($i == 8) {$photo = $photo_dir . 'logo150.jpg';}
  if ($i == 7) {$photo = $photo_dir . 'logo150.jpg';}
  if ($i == 6) {$photo = $photo_dir . 'logo300.jpg';}
  if ($i == 5) {$photo = $photo_dir . 'logo450.jpg';}
  if ($i == 4) {$photo = $photo_dir . 'logo600.jpg';}
  if ($i == 3) {$photo = $photo_dir . 'logo750.jpg';}
  if ($i == 2) {$photo = $photo_dir . 'logo900.jpg';}
  if ($i == 1) {$photo = $photo_dir . 'logo900.jpg';}
  if ($i == 0) {$photo = $photo_dir . 'logo900.jpg';}
  $text_size = 14;
  $start_x = 10;
  $start_y = 40;

  $image= ImageCreateFromJPEG($photo) or die ("failed to create $photo for $i in logo load 150");
  $fgcolour=ImageColorAllocate($image,255, 255, 255);
  $debugcolour=ImageColorAllocate($image,0, 0, 0);
  $data = sqlFetchObject('SELECT mylanguage, name , font, direction FROM my_language
	WHERE hl_id = :hl_id',
	array(':hl_id' => $hl_id))
	->fetchObject();
	// in case url messed up
  if (!isset($data->name)){
	$data = sqlFetchObject('SELECT mylanguage, name , font, direction FROM my_language
		WHERE hl_id = :hl_id',
		array(':hl_id' => 'eng00'))
		->fetchObject();

  }
  $data_direction = $data->direction;
 // if ($hl_id == 'urd00') {$data->direction = 'ltr';}  //labels still in English
  $font = $data->font;
  if (!$font) {$font = 'tahoma.ttf';}
  $font = $font_dir . $font;
  $name = $data->name;
  $text = $data->mylanguage;
  $row2 = mylanguage_find_ethnic_name_browser_language($hl_id);
  if (!$text){
	  $text = $row2;
	  $row2 = '';
  }
  if ($hl_id == 'eng00'){
	  $row2 = '';
  }
  // split long titles
  if (strlen($text)> 8){
	  $i = strpos($text, ' ', 8);
	  if ($i > 1){
		  $n = $i +1;
		  $text = substr($text, 0, $i) . "\n". substr($text, $n);
	  }

  }
  if ($data_direction == 'rtl'){
    $text = mylanguage_rtl($text);
  }
  // this is top text
  ImageTTFText($image,$text_size ,0 ,$start_x ,$start_y ,$fgcolour,$font,$text);
   // God speaks Language bottom row
  if ($row2)  {
		ImageTTFText($image, 10 ,0 ,10 ,100,$fgcolour, $font_dir . 'tahoma.ttf' , $row2);
	}
  // Choose another langauge
  $text_size = 10;
  $text =translate('Another language');
  if ($data_direction == 'rtl'){
    $text = mylanguage_rtl($text);
  }
  $start_x = 20;

  ImageTTFText($image,$text_size ,0 ,$start_x ,170 ,$fgcolour, $font, $text);
  if ($_SESSION['mylanguage_ethnic_language'] != $_SESSION['mylanguage_browser_language']){
    $text = mylanguage_t_browser('Another language');
    ImageTTFText($image,$text_size ,0,$start_x ,188 ,$fgcolour,$font_dir . 'tahoma.ttf',$text);
  }
  $logo_name =  $hl_id . '_logo.jpg';
  $real_image_name = mylanguage_path_real('logo/'.$logo_name);
  ImageJPEG($image,$real_image_name, 75);
  $logo_name = file_stream_wrapper_get_instance_by_uri('public://')->getExternalUrl() . 'logo/'. $logo_name;
  return $logo_name;
}
function menu_l($text, $path, $image) {
	
	$t = '<img  title = "'. $text . '"';
	$t .= ' src="' . mylanguage_url_file() . 'icons/' . $image .'"> ';
	$options['html'] = TRUE;
	$options['language'] = $language;
	$output =  myLink($t, $path, $options)  . "\n";
	return $output;
}
function menu_links_5fish($hl_id) {
	$link = null;
	$result = sqlFetchObject('SELECT * FROM hl_5fish
		WHERE hl_id = :hl_id LIMIT 1',
		array(':hl_id' => $hl_id))->fetchObject();
	if ($result){
		$link = array(
		 'title'=>translate('Watch'),
		 'image' => $hl_id . '_goodnews.jpg',
		 'link' => $result->url,
		 'image_blank'=> 'goodnews_blank.jpg',
		 'mobile_image' => 'conversation_black.png'
		);
		mylanguage_menu_image_make($hl_id, $link);

	}
	return $link;
}
function menu_links_adventure($hl_id) {
	$link = null;
	if (isset($_SESSION['mylanguage_chinese']) ){
		$result = sqlFetchObject('SELECT hl_id FROM hl_spirit
			WHERE hl_id = :hl_id1 OR hl_id = :hl_id2 LIMIT 1',
			array(':hl_id1' => 'chn-s', ':hl_id2' => 'chn-t')
			) ->fetchField();
	}
	else{
		$result = sqlFetchObject('SELECT hl_id FROM hl_spirit
			WHERE hl_id = :hl_id',
			array(':hl_id' => $hl_id))->fetchField();
	}
	if ($result){
		$link = array(
			'title'=>translate('Adventure'),
			'image' => $hl_id . '_study.jpg',
			'link' => 'study_online/'. $hl_id,
			'image_blank' => 'study_blank.jpg',
			'mobile_image' => 'dove_black.png',
		);
		mylanguage_menu_image_make($hl_id, $link);
	}
	return $link;
}
function menu_links_ask($hl_id){
	$link = null;
	db_set_active('hl_online');
	if (isset($_SESSION['mylanguage_chinese']) ){
		$contact = sqlFetchObject('SELECT contact FROM hl_online_everystudent
			WHERE hl_id = :hl_id1 OR hl_id = :hl_id2 LIMIT 1',
			array(':hl_id1' => 'chn-s', ':hl_id2' => 'chn-t')
			) ->fetchField();
	}
	else{
		$contact = sqlFetchObject('SELECT contact FROM hl_online_everystudent
			WHERE hl_id = :hl_id LIMIT 1',
			array(':hl_id' => $hl_id))->fetchField();
	}
	db_set_active('default');
	if ($contact){
		$contact_link = $contact->contact;
	}
	else{
		$contact_link = 'ask/'. $hl_id;
	}
	$link = array(
		'title'=>translate('Ask a question'),
		'image' => $hl_id . '_ask.jpg',
		'link' => $contact_link,
		'image_blank'=> 'ask_blank.jpg',
		'mobile_image' => 'email_black.png',
	);
	mylanguage_menu_image_make($hl_id, $link);
    return $link;
}
function menu_links_audio_bible($hl_id) {
	$link = null;
	db_set_active('common');
	$dam_id = sqlFetchObject('SELECT dam_id FROM dbm_bible
		WHERE hl_id = :hl_id AND audio = :y1 AND (collection_code = :full OR collection_code = :nt)
		LIMIT 1',
		array(':hl_id' =>$hl_id, ':y1' => 'Y', ':full' => 'FU', ':nt' =>'NT')) -> fetchField();
	db_set_active('default');
	if ($dam_id){
		$bible = substr($dam_id,0,6);
		$link= array(
			'title'=>translate('Listen'),
			'image' => $hl_id . '_listen.jpg',
			'link' => 'https://live.bible.is/bible/' . $bible . '/LUK/1',
			'image_blank' => 'listen_blank.jpg',
			'mobile_image' => 'music_black.png'
		);
		mylanguage_menu_image_make($hl_id, $link);
	}
    return $link;

}
function menu_links_discuss($hl_id) {
	$link = null;
	if (isset($_SESSION['mylanguage_chinese']) ){
		$result = sqlFetchObject('SELECT hl_id FROM hl_dbm_questions
			WHERE hl_id = :hl_id1 OR hl_id = :hl_id2 LIMIT 1',
			array(':hl_id1' => 'chn-s', ':hl_id2' => 'chn-t')
			) ->fetchField();
	}
	else{
		$result = sqlFetchObject('SELECT hl_id FROM hl_dbm_questions
			WHERE hl_id = :hl_id',
			array(':hl_id' => $hl_id))->fetchField();
	}
	if ($result){
		$link = array(
		 'title'=>translate('Discuss'),
		 'image' => $hl_id . '_discuss.jpg',
		 'link' => 'discuss/'. $hl_id,
		 'image_blank'=> 'discuss_blank.jpg',
		 'mobile_image' => 'conversation_black.png'
		);
		mylanguage_menu_image_make($hl_id, $link);
	}
	return $link;

}
function menu_links_jfilm( $hl_id) {
	$link = null;
	db_set_active('hl_online');
	$result = sqlFetchObject('SELECT hl_id FROM hl_online_jfilm
		WHERE hl_id = :hl_id LIMIT 1',
		array(':hl_id' => $hl_id))->fetchField();
	db_set_active('default');
	if ($result){
		$link = array(
			'title'=>translate('Watch the JESUS film'),
			'image' => $hl_id . '_watch.jpg',
			'link' => 'jfilm/' . $hl_id,
			'image_blank'=> 'watch_blank.jpg',
			'mobile_image' => 'movie_black.png'
		);
		mylanguage_menu_image_make($hl_id, $link);
	}
    return $link;

}
function menu_links_change_language($hl_id, $links) {
	$output = '';
	$count_links = 0;
	foreach ($links as $link){
		if (isset($link['title'])){
			$count_links++;
		}
	}
	$image_name = mylanguage_menu_image_another_language($hl_id, $count_links);
	$link = array(
		'title'=>translate('Another Language'),
		'image' =>	$image_name,
		'link' => 	 '/'. $hl_id,
		'image_blank'=> '',
		'mobile_image' => 'translate_black.png'
	);
	return $link;
}
function menu_links_meet_god($hl_id) {
	$link = null;
	if (isset($_SESSION['mylanguage_chinese']) ){
		$result = sqlFetchObject('SELECT hl_id FROM my_online_kgp
			WHERE hl_id = :hl_id1 OR hl_id = :hl_id2 LIMIT 1',
			array(':hl_id1' => 'chn-s', ':hl_id2' => 'chn-t')
			) ->fetchField();
	}
	else{
		$result = sqlFetchObject('SELECT hl_id FROM my_online_kgp
			WHERE hl_id = :hl_id',
			array(':hl_id' => $hl_id))->fetchField();
	}
	if ($result){
		$link = array(
			'title'=>translate('Meet God'),
			'image' =>	$hl_id . '_tracts.jpg',
			'link' => 	 $hl_id .'meet/'. $hl_id,
			'image_blank'=> 'tracts_blank.jpg',
			'mobile_image' => 'strategy_black.png'
		);
		mylanguage_menu_image_make($hl_id, $link);
	}
	return $link;

}
function menu_links_read_bible($hl_id) {
	$link = null;
	db_set_active('hl_online');
	if (isset($_SESSION['mylanguage_chinese']) ){
		$h = sqlFetchObject('SELECT hl_id FROM dbm_bible
			WHERE hl_id = :hl_id1 OR hl_id = :hl_id2  AND (collection_code = :nt OR collection_code = :fu )
			AND text = :y1
			ORDER BY weight DESC LIMIT 1',
			array(  ':hl_id1' => 'chn-s',
					':hl_id2' => 'chn-t',
					':y1' => 'Y',
					':nt' => 'NT',
					':fu' => 'FU'))
		->fetchField();
	}
	else{
		$h = sqlFetchObject('SELECT hl_id FROM dbm_bible
			WHERE hl_id = :hl_id AND (collection_code = :nt OR collection_code = :fu )
			AND text = :y1
			ORDER BY weight DESC LIMIT 1',
			array(':hl_id' =>$hl_id,
					':y1' => 'Y',
					':nt' => 'NT',
					':fu' => 'FU'))
			->fetchField();
	}
	db_set_active('default');
	if ($h){
		$link = array(
			'title'=>translate('Read the Bible'),
			'image' => $hl_id . '_read.jpg',
			'link' => 'bible/'. $hl_id . '/1',
			'image_blank' => 'read_blank.jpg',
			'mobile_image' => 'bible_black.png'
		);
		mylanguage_menu_image_make($hl_id, $link);
	}
	return $link;
}
function menu_links_website($hl_id){
	$link = null;
	db_set_active('hl_online');
	if (isset($_SESSION['mylanguage_chinese']) ){
		$result = sqlFetchObject('SELECT * FROM hl_online_everystudent
			WHERE hl_id = :hl_id1 OR hl_id = :hl_id2 LIMIT 1',
			array(':hl_id1' => 'chn-s', ':hl_id2' => 'chn-t')
			) ->fetchObject();
	}
	else{
		$result = sqlFetchObject('SELECT * FROM hl_online_everystudent
			WHERE hl_id = :hl_id LIMIT 1',
			array(':hl_id' => $hl_id))->fetchObject();
	}
	db_set_active('default');
    if ($result){
		$title = str_ireplace('www.', '', $result->url);
		$link = array(
			'title'=> $title,
			'image' => $hl_id . '_everyone.jpg',
			'link' => $result->url,
			'image_blank'=> 'everyone_blank.jpg',
			'mobile_image' => 'search_black.png'
		);
		mylanguage_menu_image_make($hl_id, $link);
	}
	return $link;

}
function menu_maker($hl_id){
  // set langauge for translation
  mylanguage_language($hl_id);
  mylanguage_chinese($hl_id);

  $links = array();
  $links[] = mylanguage_menu_links_audio_bible($hl_id) ;
  $links[] = mylanguage_menu_links_jfilm( $hl_id) ;
  $links[] = mylanguage_menu_links_5fish($hl_id) ;
  $links[] = mylanguage_menu_links_discuss($hl_id) ;
  $links[] = mylanguage_menu_links_meet_god($hl_id) ;
  $links[] = mylanguage_menu_links_read_bible($hl_id) ;
  $links[] = mylanguage_menu_links_adventure($hl_id) ;
  $links[] = mylanguage_menu_links_ask($hl_id);
  $links[] = mylanguage_menu_links_website($hl_id);
  $links[] = mylanguage_menu_links_change_language($hl_id, $links);

  $laptop_block = mylanguage_menu_maker_laptop($links);
  $mobile_block = mylanguage_menu_maker_mobile($links);
  mylanguage_cache_update($hl_id, $laptop_menu,$mobile_menu);
  $is_mobile = mylanguage_find_is_mobile();
  if ($is_mobile){
	return $mobile_menu;
  }
  else{
	return $laptop_menu;
  }
}
function menu_maker_laptop($links){
	
	$hl_id =  mylanguage_hl_validate();
	mylanguage_language($hl_id);
	$image_directory = 'images/';

	$output = '<table align = "center" width = "100%" cellpadding="5" CELLSPACING = "0">' ."\n";
	$block_count = 0;
	$options = array();
	$options['html'] = TRUE;
	foreach ($links as $link){
		if (isset($link['title'])){
			$output .= '<th><p align = "center">'."\n";
			$image = $image_directory . $link['image'];
			$block_count++;


			if (strpos($link['link'], '.') !== false){
				$url = trim('https://mylanguage.net.au/' . $link['link']);
				$options['external'] = FALSE;
			}
			else{
				$url = trim($link['link']);
				$options['external']  = TRUE;
			}

			$img = '<img align = "center"  style="menu_images"';
			$img .= ' src = "' . mylanguage_url_file() .$link['image'] . '"';
			$img .= ' alt = "'. $link['title'] . '">';
			$output .= myLink($img, $url, $options);
			$output .=  '</p></th>'."\n";
		}
	}
	$output .= '</table>'."\n";
}
function menu_maker_mobile($links){
	
	$hl_id =  mylanguage_hl_validate();
	mylanguage_language($hl_id);
	$output = '<!-- Start css3menu.com BODY section -->
	 <ul id="css3menu1" class="topmenu">
	   <li class="topfirst">
			  <img  title = "Home" src = "https://mylanguage.net.au/sites/mylanguage.net.au/files/img/menu60.png">
		<ul>  ';

	foreach ($links as $link){
		if (isset($link['title'])){
			$output .= '<li class = "css3_menuitem">'."\n";
			if (strpos($link['link'], '.') !== false){
				$url = trim('https://mylanguage.net.au/' . $link['link']);
				$options['external'] = FALSE;
			}
			else{
				$url = trim($link['link']);
				$options['external']  = TRUE;
			}
			$output .= '<a href="'.  $url . '">';
			$output .= '<img  title = "' . $link['title'] . '"';
			$output .= ' width = "36" src="' . mylanguage_url_file() . 'icons/' . $link['mobile_image'] . '">';
			$output .= '&nbsp;&nbsp;'. $link['title'] . '</a></li>' ."\n";
		}
	}
	$output .= '</ul>
	   </li>

	   </ul>
	 <!-- End css3menu.com BODY section -->
	 ';
	 return $output;
}
function menu_show() {
	
	$laptop_menu = '';
	$hl_id = mylanguage_hl_validate();
	mylanguage_stats_update($hl_id);
	$cache = mylanguage_cache($hl_id);
	if ($cache){
		return $cache;
	}
	else{
	  return mylanguage_menu_maker($hl_id);
	}
}
