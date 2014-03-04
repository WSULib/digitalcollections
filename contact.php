<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Contact</title>

	<link rel="stylesheet" href="css/main.css" type="text/css">
        <link rel="stylesheet" href="inc/sidr/stylesheets/jquery.sidr.dark.css">

        
        <!-- Typography -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,900,100,100italic,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js" type="text/javascript"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>

        <!--Mustache-->
        <script src="inc/jquery-Mustache/jquery.mustache.js"></script>
        <script type="text/javascript" src="inc/mustache.js"></script>
        
        <!-- Local JS -->
        <script src="js/main.js" type="text/javascript"></script>
        <script src="js/favorites.js"></script>
        <script src="js/userData.js"></script>             
        
        <script src="js/utilities.js"></script>
        <script src="js/collection.js"></script>
        
        <!--WSUDOR Translation Dictionary-->
        <script type="text/javascript" src="js/rosettaHash.js"></script>
        
        <!--Pagination-->
        <script type="text/javascript" src="inc/jquery.bootpag.min.js"></script> 
        
        <script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/jquery.cookie.js" type="text/javascript"></script> 
        <script src="inc/sidr/jquery.sidr.min.js"></script>
</head>
<body>

	<?php include('inc/header.php'); ?>

	<div class="container">
		<h2>Contact</h2>

                    <div class="row">
                        <div class="hidden-xs col-sm-6 col-md-6">
                           <p class="push">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Earum, illum, natus, id beatae voluptate perferendis vitae sequi consectetur incidunt quia dolorem eos exercitationem optio quibusdam veniam minus mollitia neque minima autem nulla adipisci suscipit sapiente. Laudantium, nostrum, amet excepturi ipsam molestiae illo commodi dolores et necessitatibus magni ut adipisci blanditiis?</p>
                        </div>
                        <div class="col-sm-6 col-md-6 contact-form">
                            <form method="post" action="inc/sendmail.php">
                                <label for="name" class="nameLabel">Name</label>
                                  <input id="name" type="text" name="name" placeholder="Enter your name">
                                <label for="email" class="emailLabel">Email</label>
                                  <input id="email" type="text" name="email" placeholder="Enter your email">
                                <label for="message" class="messageLabel">Message</label>
                                  <textarea id="message" name="message" placeholder="Your message"></textarea>
                                <button type="submit" class="btn">Submit</button>
                            </form>
                        </div>
                    </div>
	</div>
	
	<?php include('inc/footer.php'); ?>
	
</body>
</html>