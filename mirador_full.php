<html>
<head>
	<!-- mirador -->
    <link rel="stylesheet" type="text/css" href="inc/mirador/css/mirador-combined.css">
    <link rel="stylesheet" type="text/css" href="css/mirador_local.css">
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
	<script src="config/config.js" type="text/javascript"></script>
	
	<script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>
	<meta name="viewport" content="initial-scale=1">

	<title>Wayne State Digital Library - Mirador Viewer</title>

<head>

<body>

		<div class="standalone">
			<!-- all_image type template -->
			<div id="LargeView">			

				<!-- downloads -->
				<div id="downloads">
					<p onclick="$('#downloads ul').slideToggle(250);"><i class="fa fa-download fa-lg fa-fw"></i></p>
					<div class="fullsize_download"><ul></ul></div>					
				</div>

				<div id="viewer"></div>

				<script type="text/javascript">
					$(function() {					
						var anno_token;
						Mirador({
							"id": "viewer",
							"saveSession": false,
							"layout":"1x1",
							"mainMenuSettings" : {
								'show' : false
							},
							"data": [
								{
									"manifestUri": "http://digital.library.wayne.edu/iiif_manifest/<?php echo $_REQUEST['id']; ?>",
									"location": "Wayne State University Library Digital Collections"}              
								],
							"windowObjects": [                 
								{
									"loadedManifest" : "http://digital.library.wayne.edu/iiif_manifest/<?php echo $_REQUEST['id']; ?>", 
									"viewType" : "<?php echo $_REQUEST['type']; ?>",
									"layoutOptions": 
										{
											"close": false,
											"slotRight": false,
											"slotLeft": false,
											"slotAbove": false,
											"slotBelow": false
										},
								"annotationLayer": false
								}			                     
							]
						});
					});
				</script>

			</div>
		</div>

</body>

<!-- le js -->
<script src="inc/mirador/mirador.js"></script>
<script src="js/mirador_full.js"></script>

</html>
