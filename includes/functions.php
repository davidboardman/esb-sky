<?php
//functions.php
date_default_timezone_set("America/New_York"); 


//paging vars
$offsetImages=100;

//css variables
$imgW=120;
$imgH=120;


function listAllImages(){
	$items = glob("../images/*.jpg", GLOB_NOSORT);
	//array_multisort(array_map('filemtime', $items), SORT_NUMERIC, SORT_DESC, $items);
	usort($items, function ($a, $b) {
	   return filemtime($a) < filemtime($b);
	});
	return $items;
}


function generateImages($items){
	$esbHtml="";
	$backgroundColor="";

	foreach($items as $filename){
		$filename=basename($filename);
		if($filename!="esb.jpg"){
			$colors=str_replace(".jpg","",$filename);
			$colors=explode("_",$colors);
			$colors=array_slice($colors, 1, -1);
			
			$paletteHtml=getESBColors($colors);
			$backgroundColor=getBackgroundColor($colors);
			$timeStamp=date ("F d, Y * h:ia", filemtime("../images/".$filename));
			$timeStamp='<p>'.str_replace("*","<br/>",$timeStamp).'</p>';

			$esbHtml.='<div class="esb" style="background-color:#'.$backgroundColor.'"><div class="esbImg">
			<img src="images/'.$filename.'" /><div class="info">'.$timeStamp.$paletteHtml.'</div></div></div>';
		}
	}
	return $esbHtml;
}




function getBackgroundColor($ar){
	$len=count($ar)-1;
	return $ar[$len];
}



function getESBColors($ar){
	global $backgroundColor;
	$html.='<p><br/>';
	foreach($ar as $sky){
		if(($sky!="")&&($sky!=$backgroundColor)) $html.='<span style="background-color:#'.$sky.'"></span>';
	}
	$html.='</p>';
	return $html;
}	





function url_exists($url) {
    if (!$fp = curl_init($url)) return false;
    return true;
}


function cropImage($url,$x,$y,$w,$h){
	global $folder;
	$img = @imagecreatetruecolor($w,$h) or die('Cannot Initialize new GD image stream');
	$esb=imagecreatefromjpeg($url);
	imagecopy($img,$esb,0,0,$x,$y,$w,$h);
	//$filenameTimestamp=$folder.'esb-'.date('mdY-His', time()).'.jpg';
	$filenameTmp=$folder.'esb.jpg';
	imagejpeg($img,$filenameTmp,90);
	$filenameColors=getColors($filenameTmp);
	imagejpeg($img,$filenameColors,90);
	imagedestroy($img);
}


function getColors($img){
	global $folder, $precision, $maxColors;
    $image=basename($img);
	$colors_of_image = new ColorsOfImage($folder.$image,$precision,$maxColors);
	$colors = $colors_of_image->getProminentColors();
	$bgColors=$colors_of_image->getBackgroundColor();
	array_push($colors,$bgColors);
	$colors=str_replace("#","",implode("_", $colors));
	$filename = $folder."esb_".$colors."_".time().".jpg";
	return $filename;
}


?>