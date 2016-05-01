<?php
//getImage.php

include_once('includes/colorsofimage.class.php');
ini_set('memory_limit', '128M');
date_default_timezone_set("America/New_York"); 

// variables color images
$precision=50;
$maxColors=10;


// image source and storing folder
$url="http://cam.westinnewyorktimessquareview.com/the-westin-new-york-at-times-square.jpg";
$folder=$_SERVER['DOCUMENT_ROOT']."/images/";



// get remote ESB image, crop it, and save it locally
if(url_exists($url)){
	cropImage($url,200,0,315,315);
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

function renameFile(){

}
?>