<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact | Digital Collections | WSULS</title>
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
        <script src="js/contact_random.js"></script>
        
        <script src="js/vendor/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/jquery.cookie.js" type="text/javascript"></script> 
        <script src="inc/sidr/jquery.sidr.min.js"></script>
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
                    <form method="post" action="inc/sendmail.php">
                        <label for="name" class="nameLabel">Name</label>
                          <input id="name" type="text" name="name" placeholder="Enter your name">
                        <label for="email" class="emailLabel">Email</label>
                          <input id="email" type="text" name="email" placeholder="Enter your email">
                        <label for="message" class="messageLabel">Message</label>
                          <textarea id="message" name="message" placeholder="Your message"></textarea>

                    <!-- RECAPTCHA -->
                   <script type="text/javascript">
                         var RecaptchaOptions = {
                            theme : 'custom',
                            custom_theme_widget: 'recaptcha_widget'
                         };
                    </script>
                    <?php 
                    $recaptcha_url = "https://www.google.com/recaptcha/api/challenge?k=6LdFuuwSAAAAAIcVqmj_6IYCwN2OI_9rWzpyTqYI";
                    $recaptcha_noscript_url = "http://www.google.com/recaptcha/api/noscript?k=6LdFuuwSAAAAAIcVqmj_6IYCwN2OI_9rWzpyTqYI"; 
                    ?>

                            <label class="recaptchaLabel" alt="reCaptcha">reCAPTCHA</label>
                            <div class="controls">
                                <a id="recaptcha_image" href="#"></a>
                            </div>

                            <label class="recaptcha_only_if_image control-label">Enter the words above:</label>
                            <label class="recaptcha_only_if_audio control-label">Enter the numbers you hear:</label>

                            <div class="controls">
                                <div class="input-append">
                                    <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" class="input-recaptcha" />
                                    <a class="btn" href="javascript:Recaptcha.reload()"><i class="icon-refresh"></i></a>
                                    <a class="btn image" href="javascript:Recaptcha.switch_type('audio')"><i title="Get an audio CAPTCHA" class="icon-audio"></i></a>
                                    <a class="btn audio" href="javascript:Recaptcha.switch_type('image')"><i title="Get an image CAPTCHA" class="icon-image"></i></a>
                                    <a class="btn" href="javascript:Recaptcha.showhelp()"><i class="icon-question"></i></a>
                                </div>
                            </div>
     

                    <script type="text/javascript"
                       src="<?php echo $recaptcha_url; ?>">
                    </script>

                    <noscript>
                        <iframe src="<?php echo $recaptcha_noscript_url; ?>"
                           height="300" width="500" frameborder="0"></iframe><br>
                        <textarea name="recaptcha_challenge_field" rows="3" cols="40">
                        </textarea>
                        <input type="hidden" name="recaptcha_response_field"
                           value="manual_challenge">
                      </noscript>
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