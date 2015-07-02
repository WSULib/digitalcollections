<html>
<head>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
	<script src="config/config.js" type="text/javascript"></script>
	
	<link rel="stylesheet" type="text/css" href="css/imageviewer_osd.css" />
	<link rel="stylesheet" href="ico/style.css">

	<meta name="viewport" content="initial-scale=1">
	<script src="js/utilities.js"></script>	

	<title>Image Viewer | Digital Collections | WSULS</title>

<head>

<body>
	
		<div class="row">
			<div id="toolbarDiv" class="col-sm-6"></div>
			<div id="downloads" class="col-sm-6">
				<p>
					<a id="item_record_link" href="#"><span style="margin-right:5px;">&laquo;</span> Item Record</a> / Download
					<a id="fullsize" href="#">Fullsize </a> or 
					<a id="mediumsize" href="#">Medium</a>
				</p>
		</div>
		</div>

		
	
	<div id="openseadragon1"></div>
		
	
</body>

<!-- le scripts -->
<!-- <script src="js/imageviewer_osd.js"></script>
<script src="inc/osd/openseadragon.min.js"></script>	 -->

<!-- osd v2 -->
<script src="js/imageviewer_osd_v2.js"></script>
<script src="inc/osd2/openseadragon.min.js"></script>

<script type="text/javascript">
	var imageParams = <?php echo json_encode($_GET); ?>;
	$(document).ready(function(){        
		launch(imageParams);
	});    
</script>