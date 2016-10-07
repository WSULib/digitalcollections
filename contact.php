<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact | Digital Collections | WSULS</title>
    <meta name="viewport" content="initial-scale=1">

    <!-- load site-wide dependencies -->
    <?php include('inc/site_wide_depends.php'); ?>
  
    <!-- page specific dependencies -->
    <script src="js/contact_random.js"></script>

    <!-- enable recaptcha -->
    <script src='https://www.google.com/recaptcha/api.js'></script>
                
</head>
<body>

    <?php include('inc/header.php'); ?>

    <div class="container">
        <h2>Contact</h2>
          <div class="row">
                <div class="hidden-xs col-sm-6 col-md-6 contact">
                    <img id="imagery" src="" alt="">
                    <p class="caption"></p>
                </div>
                <div class="col-sm-6 col-md-6 contact-form">
                    <form method="post" action="#">
                        <label for="name" class="nameLabel">Name</label>
                          <input id="name" type="text" name="name" placeholder="Enter your name">
                        <label for="email" class="emailLabel">Email</label>
                          <input id="email" type="text" name="email" placeholder="Enter your email">
                        <label for="message" class="messageLabel">Message</label>
                          <textarea id="message" name="message" placeholder="Your message"></textarea>
                        <input type="hidden" name="subject" value="Message about WSU Digital Collections" />
                        <input type="hidden" name="to" value="libwebmaster@wayne.edu" />
                        <!-- RECAPTCHA -->
                        <label></label>
                        <div class="g-recaptcha recaptchaLabel" data-sitekey="6LdHqggUAAAAADLHF6l8jV_zgcbf5PT-1O_qwrKA"></div>
                        <!-- /RECAPTCHA -->
                        <button type="submit" class="btn">Send Message</button>
                    </form>
                </div>
            </div>
    </div>
    
    <?php include('inc/footer.php'); ?>
<script type="text/javascript"> 
    getImage(array);              
</script>    
</body>
</html>