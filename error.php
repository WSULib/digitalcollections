<?php
header("HTTP/1.0 503 Service Unavailable");
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Page Not Found | Digital Collections | WSULS</title>
        <meta name="viewport" content="initial-scale=1">

        <!-- load site-wide dependencies -->
        <?php include('inc/site_wide_depends.php'); ?>
	
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