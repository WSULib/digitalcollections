<!DOCTYPE html>
<?php
	$objectPID = $_REQUEST['id'];
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Serials | Digital Collections | WSULS</title>
        <meta name="description" content="">
        <meta name="viewport" content="initial-scale=1">

        <link rel="stylesheet" href="css/main.css" type="text/css">
        <link rel="stylesheet" href="inc/sidr/stylesheets/jquery.sidr.dark.css">
        <link rel="stylesheet" href="css/glyphicons.css">
        
        <!-- Typography -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,900,100,100italic,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js" type="text/javascript"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>

        <!--Mustache-->
        <script src="inc/jquery-Mustache/jquery.mustache.js"></script>
        <script type="text/javascript" src="inc/mustache.js"></script>
        
        <!-- Local JS -->
        <script src="js/userData.js"></script>
        <script src="js/utilities.js"></script>        
        <script src="js/favorites.js"></script>        
        <script src="js/serial-volume.js"></script>
        
        <!--WSUDOR Translation Dictionary-->
        <script type="text/javascript" src="js/rosettaHash.js"></script>
        
        <!--Pagination-->
        <script type="text/javascript" src="inc/jquery.bootpag.min.js"></script> 
        
        <script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/main.js" type="text/javascript"></script>
        <script src="js/jquery.cookie.js" type="text/javascript"></script>  
        <script src="inc/sidr/jquery.sidr.min.js"></script>  

        <style>
            .toc > li {
                margin: 0;
            }
        </style>

        <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>

<script type="text/javascript" src="js/script.js"></script>

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