<?php
header("HTTP/1.0 404 Not Found");
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
		<h2>Page Not Found</h2>
		<p class="push">The page you were looking for does not exist. Please <a href="contact.php">contact us</a> with any questions.</p>
	</div>
	
	<?php include('inc/footer.php'); ?>
	
</body>
</html>