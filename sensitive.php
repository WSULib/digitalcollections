<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sensitive Materials | Digital Collections | WSULS</title>
    <meta name="viewport" content="initial-scale=1">

    <!-- load site-wide dependencies -->
    <?php include('inc/site_wide_depends.php'); ?>
  
    <!-- page specific dependencies -->
    <script src="js/contact_random.js"></script>

    <style type="text/css">
        ul {
            list-style:circle;
            padding-left:40px;
            margin-bottom:20px;
        }
        li {
            margin-bottom:5px;
            font-weight:300;
        }
    </style>
                
</head>
<body>

    <?php include('inc/header.php'); ?>

    <div class="container">

          <div class="row">
                <div class="col-md-12">
                    
                    <h2>I have a serious problem with this thing I just saw / heard / read!</h2>
                    
                    <br>

                    <p>We collect, describe and offer digital collections for many reasons: to support research and teaching, to preserve and promote the historical record, to tell a particular story, to celebrate our locality and culture. We never intend to needlessly shock or offend you, the reader.</p>

                    <p>Digital collections often contain materials that are controversial, offensive or uncomfortable to modern sensibilities, but that remain important for historical, contextual or thematic reasons. As curators, we regularly face the question: should we provide access to problematic material, or should we censor the digital objects we curate in order to protect and, in some cases, respect the sensitivities of our potential audiences? In the case of the materials we present here, we decided to provide access.</p>

                    <p>We empathize with your experience in relating to problematic material—we often have the same reaction to items in the collections we work with! If you’ve come across an item in our collections that gives you pause, offends you, shocks you or makes you question our motives, we ask you to consider the following:</p>

                    <ul>
                        <li>Does this image, text, or audio come from a historical period where the words or images would have elicited a different reaction than the one I’m experiencing?</li>
                        <li>Would sanitizing this image, text, or audio erase a testimony to a fact of nature or history that might otherwise be useful in describing, documenting, challenging or changing the world?</li>
                        <li>Did the original author of, or audience for, this image, text, or audio differ significantly from me in some way, and is that the root of my problem with this material?</li>
                        <li>Does my discomfort mean this image, text, or audio shouldn’t be available, or should be available in a different form?</li>
                    </ul>

                    <p>If you feel strongly that we’ve erred in judgment, please contact us and talk about it! We welcome dialog about the collections we present here, including challenges to their form or content. Again, our intention is not to offend or provoke, but to faithfully curate materials that support our mission and add to the public and academic discourse.</p>

                    <p>Yours,<br>
                    The Wayne State University Library System</p>

                </div>
        </div>

        <div class="row">
                <div class="col-md-6 contact-form">
                    <h2>Contact Us</h2>
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