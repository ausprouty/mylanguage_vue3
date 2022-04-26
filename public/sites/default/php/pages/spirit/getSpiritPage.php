<?php
myRequireOnce('resources/language/translate.php');
myRequireOnce('validateParameters.php');

function getSpiritPage($p) {
    $required= array(
        'hl_id' => 'eng00',
        'page'=> 1
    );
    if (!validateParameters($p, $required, 'getSpiritPage')){
        $return;
    }


  //return "line 3000";
  $output .= '<h1>' .translate('Adventure') . '</h1>';
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
