<?php
//index.php
include_once('includes/functions.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="refresh" content="6c00">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Empire</title>
<meta name="author" content="David Boardman">
<meta name="description" content="A window on the Empire State Building, wherever you are.">
<meta name="keywords" content="Empire State Building, New York, New York City, NYC, ESB, Andy Warhol, Warhol">
<link href='https://fonts.googleapis.com/css?family=Oswald:300' rel='stylesheet' type='text/css'>
<link href='styles/main.css' rel='stylesheet' type='text/css'>
<style>

.esb{
	position: relative;
	display: inline-block;
	width: <?php echo $imgW;?>px;
	height: <?php echo $imgH;?>px;
}

</style>
</head>
<body>

<div id="container"></div>
<p id="loading"></p>

<script src="js/jquery-2.2.3.min.js"></script>
<script src="http://masonry.desandro.com/v2/jquery.masonry.min.js"></script>
<script src="js/jquery.infinitescroll.min.js"></script>
<script>

var $container = $('#container');
var win = $(window);
var step=<?php echo $offsetImages;?>;
var progress=0;
var max=<?php echo count(glob("images/*.jpg", GLOB_NOSORT));?>;



$container.imagesLoaded( function(){
  $container.masonry({
    itemSelector : '.esb',
    columnWidth: <?php echo $imgW;?>

  });
});


$(document).ready(function() {
	$.ajax({ // FIRST TIME LOAD
		url: 'includes/paging.php?r=0',
		dataType: 'html',
		success: function(html) {
			$('#container').append(html);
			$('#loading').hide();
			html="";
			progress+=step;
		}
	});


	// Each time the user scrolls
	win.scroll(function() {
		if ($(document).height() - win.height() == win.scrollTop()) {
			$('#loading').show();

			$.ajax({
				url: 'includes/paging.php?r='+progress+'',
				dataType: 'html',
				success: function(html) {
					//console.log("PROGRESS "+progress+" MAX "+max);
					if(progress<max){
						$('#container').append(html);
						$('#loading').hide();
						html="";
						progress+=step;
					}
					else{
						$('#loading').html('<img src="images/assets/esb-icon.png"/>');
					}
				}
			});
		}
	});
});

</script>



</body>
</html>