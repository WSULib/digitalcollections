<!DOCTYPE html>
<?php
	$objectPID = $_REQUEST['id'];
?>
<html>
    <head>
        <!-- page rendered as Serial_Volume -->
        <meta charset="utf-8">
        <title>Serials | Digital Collections | WSULS</title>
        <meta name="description" content="">
        <meta name="viewport" content="initial-scale=1">

        <!-- load site-wide dependencies -->
        <?php include('inc/site_wide_depends.php'); ?>
          
        <!-- page specific dependencies -->
        <script src="js/serial-volume.js"></script>
        
        <!-- local styles -->
        <style>
            .toc > li {
                margin: 0;
            }
        </style>        

</head>
<body>

	<?php include('inc/struct_data.php'); ?>
    <?php include('inc/header.php'); ?>

	<div class="container">
		<div id="serial-nav" class="facets volume-view"></div>
		<div class="main-container">
            <div id="serial-volume-content"></div>
        </div>
	</div>

    <?php include('inc/footer.php'); ?>

        <!-- loading serials -->
        <script type="text/javascript"> 
            // var searchParams = <?php echo json_encode($_GET); ?>;
            // console.log(searchParams);
            // launch(searchParams);   

            launch("<?php echo $objectPID; ?>");              
        </script>        
	
</body>
</html>