<?php
header("HTTP/1.0 503 Service Unavailable");
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Page Not Found | Digital Collections | WSULS</title>
        <meta name="viewport" content="initial-scale=1">

	<link rel="stylesheet" href="css/main.css" type="text/css">
        <link rel="stylesheet" href="inc/sidr/stylesheets/jquery.sidr.dark.css">
        <link rel="stylesheet" href="ico/style.css">
        
        <!-- Typography -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,900,100,100italic,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js" type="text/javascript"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>

        <!--Mustache-->
        <script src="inc/jquery-Mustache/jquery.mustache.js"></script>
        <script type="text/javascript" src="inc/mustache.js"></script>
        
        <!-- Local JS -->
        <script src="config/config.js" type="text/javascript"></script>
        <script src="js/main.js" type="text/javascript"></script>
        <script src="js/favorites.js"></script>
        <script src="js/userData.js"></script>             
        
        <script src="js/utilities.js"></script>        
        
        <script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/jquery.cookie.js" type="text/javascript"></script> 
        <script src="inc/sidr/jquery.sidr.min.js"></script>
</head>
<body>

	<?php include('inc/header.php'); ?>

	<div class="container">
		<h2>We're sorry, an error has occurred.</h2>
		<p class="push">We are doing our best to fix it.  In the meantime, please <a href="contact.php">contact us</a> with any questions.</p>
	</div>
	
	<?php include('inc/footer.php'); ?>
	
</body>
</html>