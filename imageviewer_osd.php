<html>
<head>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
	<script src="js/utilities.js"></script>
	
	<link rel="stylesheet" type="text/css" href="css/imageviewer_osd.css" />
	<link rel="stylesheet" href="css/glyphicons.css">

	<title>Image Viewer | Digital Collections | WSULS</title>

<head>

<body>
	
	<div id="downloads">
		<p><a href="#" onclick="window.history.back(); return false;"><span style="margin-right:5px;">&laquo;</span> Go Back</a> / Download <a id="fullsize" href="#">Fullsize image</a> or <a id="mediumsize" href="#">Medium image</a></p>
	</div>
	
	<div id="openseadragon1"></div>
		
	
</body>

<!-- le scripts -->
<script src="js/imageviewer_osd.js"></script>
<script src="inc/osd/openseadragon.min.js"></script>	
<script type="text/javascript">
	var imageParams = <?php echo json_encode($_GET); ?>;
	$(document).ready(function(){        
		launch(imageParams);
	});    
</script>