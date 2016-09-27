<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Permissions Request | Digital Collections | WSULS</title>
    <meta name="viewport" content="initial-scale=1">

    <!-- load site-wide dependencies -->
    <?php include('inc/site_wide_depends.php'); ?>
  <script src="https://unpkg.com/masonry-layout@4.1/dist/masonry.pkgd.min.js"></script>
    <!-- capture values from the preceding page -->
    <?php
        $url = $_SERVER['HTTP_REFERER']; // string
        $isreuther = $_POST['isreuther']; // boolean
        if ($isreuther) {
            $subject = "REUTHER | Permissions Request";
        }
        else {
            $subject = "WSULS | Permissions Request";
        }
    ?>
    <!-- image PID array -->
    <?php
    $image_array = array(
        "wayne:UniversityBuildings24902",
        "wayne:vmc18518",
        "wayne:UniversityBuildings25441",
        "wayne:vmc48406",
        "wayne:CFAIEB01c001",
        "wayne:UniversityBuildings25703",
        "wayne:vmc3186_5",
        "wayne:CFAIEB01a016",
        "wayne:vmc705",
        "wayne:CFAIEB01c673",
        "wayne:vmc26715",
        "wayne:CFAIEB01c100"
    );

    ?>
</head>
<body>

    <?php include('inc/header.php'); ?>

    <div class="container">
        <h2>Permissions Request</h2>
          <div class="row">
                <div class="hidden-xs col-sm-6 col-md-6 contact">
                    <div class="grid" data-masonry='{ "itemSelector": ".grid-item", "columnWidth": 200 }'>
                    <?php
                    foreach ($image_array as $image_PID) {
                        echo "<div class='grid-item'><img src='https://digital.library.wayne.edu/item/$image_PID/thumbnail/'></div>";
                    }
                    ?>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 contact-form">
                    <form method="post" action="inc/sendmail.php">
                        <label for="name" class="nameLabel">Name</label>
                          <input id="name" type="text" name="name" placeholder="Enter your name">
                        <label for="email" class="emailLabel">Email</label>
                          <input id="email" type="text" name="email" placeholder="Enter your email">
                        <label for="message" class="messageLabel">Message</label>
                          <textarea id="message" name="message" placeholder="Your message"></textarea>
                        <input type="hidden" name="url" value=<?php echo $url; ?> />
                        <input type="hidden" name="subject" value=<?php echo $subject; ?> />
                        <input type="hidden" name="to" value="reutherav@wayne.edu,libwebmaster@wayne.edu" />
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