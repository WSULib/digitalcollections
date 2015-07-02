<html>
<head>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
	<script src="config/config.js" type="text/javascript"></script>
	
	<!-- site wide -->
	<script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="css/main.css" type="text/css">
	<link rel="stylesheet" href="inc/sidr/stylesheets/jquery.sidr.dark.css">
	<link rel="stylesheet" href="ico/style.css">

	<link rel="stylesheet" type="text/css" href="css/imageviewer_osd.css" />
	<link rel="stylesheet" href="ico/style.css">

	<meta name="viewport" content="initial-scale=1">
	<script src="js/utilities.js"></script>	



	<title>Image Viewer | Digital Collections | WSULS</title>

<head>

<body>

	<div id="openseadragon_container" class="container">

		<div id="loading_row" class="row">
			<div class="col-md-12">	
				<div id="loading">
					<h1>Loading...</h1>
				</div>
			</div>
		</div>	

		<div id="osd_row" class="row">
			<div class="col-md-12">	
				<div id="openseadragon">

					<div id="toolbar_row" class="row">
			
						<div id="toolbar" class="col-sm-12">
							<a id="item_record_link" href="#"><i class="icon-exit2"></i></a>
							<!--<span class="spacer"></span>-->
							<!--general-->
							<i id="homeButton" class="icon-home4"></i>
							<i id="fullPageButton" class="icon-expand2"></i>
							<!-- <span class="spacer"></span> -->
							<!--rotate-->
							<i id="rotateLeftButton" class="icon-undo"></i>
							<i id="rotateRightButton" class="icon-redo"></i>
							<!-- <span class="spacer"></span> -->
							<!--zoom-->
							<i id="zoomOutButton" class="icon-zoom-out"></i>
							<i id="zoomInButton" class="icon-zoom-in"></i>
							
							<span id="mult_toolbar">
								<span class="spacer"></span>
								<!--navigation-->
								<!-- <span>Image:<span id="currentpage"></span></span> -->
								<i id="previousButton" class="icon-arrow-left2"></i>
								<i id="nextButton" class="icon-arrow-right2"></i>
							</span>
						</div>

					</div>

				<div>
			</div>
		</div>

	</div>
		
	
</body>


<!-- osd v2 -->
<script src="js/imageviewer_osd_v2.js"></script>
<script src="inc/osd2/openseadragon.min.js"></script>

<script type="text/javascript">
	var imageParams = <?php echo json_encode($_GET); ?>;
	$(document).ready(function(){        
		launch(imageParams);
	});    
</script>
