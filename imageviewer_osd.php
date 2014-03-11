<html>
<head>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
	<script src="js/utilities.js"></script>
	<script src="js/imageviewer_osd.js"></script>
	<script src="inc/osd/openseadragon.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/imageviewer_osd.css" />

	<title>placeholder</title>

<head>

<body>
	
	<div id="downloads">
		<p>Download <a id="fullsize" href="#">fullsize</a> / <a id="mediumsize" href="#">medium</a></p>
	</div>
	
	<div id="openseadragon1"></div>
		
	<script type="text/javascript">
		var imageParams = <?php echo json_encode($_GET); ?>;
		$(document).ready(function(){        
			launch(imageParams);
		});    
	</script>
</body>