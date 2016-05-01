<?php
//index.php
date_default_timezone_set("America/New_York"); 
$esbHtml="";

$items = glob("images/*.jpg", GLOB_NOSORT);
array_multisort(array_map('filemtime', $items), SORT_NUMERIC, SORT_DESC, $items);

foreach($items as $filename){
	$filename=basename($filename);
	if($filename!="esb.jpg"){
		$colors=str_replace(".jpg","",$filename);
		$colors=explode("_",$colors);
		$colors=array_slice($colors, 1, -1);
		$spanHtml="<br/>".getESBColors($colors);
		$backgroundColor=getBackgroundColor($colors);
		//print_r($colors);

		$timeStamp=date ("F d Y h:i:sa", filemtime('images/'.$filename));
		$esbHtml.='<div class="esb"><div class="bg" style="background-color:#999">'.$timeStamp.$spanHtml.'</div><div class="esbImg"><img src="images/'.$filename.'" /></div></div>';
	}
}


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>title</title>
  <meta name="author" content="name">
  <meta name="description" content="description here">
  <meta name="keywords" content="keywords,here">
  <link href='https://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css'>
	<style>
	body{
		margin: 0;
		padding: 0;
		font-family: 'Playfair Display', serif;
	}

	.esb{
		position: relative;
		float: left;
		width: 200px;
		height: 200px;
	}

	.esb img{
		width: 200px;
		height: 200px;	
	}

	.bg{
		position: absolute;
		left:0;top:0;right:0;bottom:0;
		z-index:-1;
	}

	.esbImg{
		position: absolute;
		left:0;top:0;right:0;bottom:0;
		z-index:99;
	}

	.esbColors{
		display: block;
		width: 20px;
		height: 20px;
		border: 1px solid #fff;
		float: left;
	}

	</style>

  </head>
  <body>
  
<?php echo $esbHtml;?>

<script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>

<script>

$(".esb").hover(function() {
	$(this).children('.esbImg').fadeToggle(200, "linear" )
	//$(this).children('.bg').fadeToggle(200, "linear" );
});

</script>

</body>
</html>
<?php

function getBackgroundColor($ar){
	$len=count($ar)-1;
	return $ar[$len];
}

function getESBColors($ar){
	$html="";
	foreach($ar as $sky){
		$html.='<span class="esbColors" style="background-color:#'.$sky.'"></span>';
	}
	return $html;
}	

?>