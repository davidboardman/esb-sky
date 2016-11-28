<?php
//getImage.php

// cron job
/*
$page=$_SERVER['PHP_SELF'];
$minutes=10;
$minutes*=60;
header("Refresh: $minutes; url=$page");
*/

include_once('includes/functions.php');
include_once('includes/colorsofimage.class.php');
date_default_timezone_set("America/New_York"); 

// variables color images
$precision=5;
$maxColors=3;


// image source and storing folder
//$url="http://cam.westinnewyorktimessquareview.com/the-westin-new-york-at-times-square.jpg";
//$folder=" /Users/dboardman/Documents/git/esb-sky/images/";


$url="http://cam.sheratontribecaview.com/sheraton-tribeca-new-york-hotel.jpg";
$folder="/app/images/";

// get remote ESB image, crop it, and save it locally
if(url_exists($url)){
	//cropImage($url,200,0,315,315); // Times Square
	cropImage($url,411,152,209,209); // Tribeca 
}

?>

<h1>ESB - Get Image</h1>
<img src="images/esb.jpg"/>