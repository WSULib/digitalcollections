<!DOCTYPE html>
<?php
	$objectPID = $_REQUEST['id'];
?>
<html>
    <head>
        <!-- page rendered as Serial -->
        <meta charset="utf-8">
        <title>Serials | Digital Collections | WSULS</title>
        <meta name="description" content="">
        <meta name="viewport" content="initial-scale=1">

        <!-- load site-wide dependencies -->
        <?php include('inc/site_wide_depends.php'); ?>
          
        <!-- page specific dependencies -->
        <script src="js/serial.js"></script>
        
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
                <div id="serial-root-content"></div>
    		</div>
    	</div>

    	<?php include('inc/footer.php'); ?>	   
        <script type="text/javascript">
            launch("<?php echo $objectPID; ?>");
        </script>


    </body>
</html>