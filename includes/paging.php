<?php
//paging.php
//header('Content-Type: text/html; charset=utf-8');
include_once('functions.php');




if((!isset($_GET['r']))||($_GET['r']=="")) $range=0;
else $range=$_GET['r'];

$allImages=listAllImages();	
$esbImages=array_slice($allImages,$range,$offsetImages,true);
$esbHtml=generateImages($esbImages);


echo $esbHtml;

?>


