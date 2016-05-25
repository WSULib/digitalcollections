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
                
</head>
<body>

    <?php include('inc/header.php'); ?>

    <div class="container">

          <div class="row">
                <div class="col-md-12">
                    
                    <h2>I have a serious problem with this thing I just saw / heard / read!</h2>
                    
                    <br>

                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eget auctor eros, id mollis dui. Cras iaculis, odio et posuere molestie, orci ex vehicula sem, in sodales dolor elit ac tellus. Nullam mollis commodo nisi ac scelerisque. Morbi id est mauris. Nam semper mattis purus, ac placerat erat varius quis. Nunc maximus et enim dignissim congue. Vivamus aliquet commodo nisi id lobortis. Mauris vitae ex non lectus laoreet tempor a sed elit. Maecenas dolor magna, tempor nec massa eu, consectetur efficitur diam. Vivamus a ultricies dolor. Curabitur auctor pellentesque interdum. Suspendisse potenti. Proin tincidunt dapibus magna, vel maximus lorem hendrerit eu. Nunc ut diam metus. Praesent volutpat ut diam vel consequat.</p>

                    <p>Aliquam tristique bibendum rhoncus. Proin nec mi sit amet orci maximus egestas. Aenean eget felis id ex molestie volutpat sit amet sit amet massa. Nam odio neque, mollis ac lacus quis, pretium ornare ante. Nulla quis dignissim justo. In molestie pellentesque malesuada. Vivamus nulla massa, euismod ac quam at, blandit ornare risus. Nulla quis ullamcorper orci. Proin vestibulum fringilla tincidunt.</p>

                    <p>Quisque vitae libero eros. Ut vestibulum ultricies justo pellentesque bibendum. Suspendisse nunc nisi, pharetra sit amet convallis at, malesuada in lacus. Phasellus mattis at turpis tincidunt blandit. Morbi hendrerit lectus sit amet sapien condimentum cursus. Morbi at ligula nec felis sodales condimentum. Aenean mollis semper erat, vitae placerat augue. Etiam vulputate pulvinar sapien eget porta. Duis congue odio ut tristique accumsan. Donec pretium finibus efficitur. In non mauris sit amet felis finibus tristique sed vestibulum lectus. Curabitur ut diam eu enim lacinia cursus. Pellentesque nec blandit dolor.</p>

                    <p>Cras condimentum congue lectus, vel tempus neque feugiat vitae. Donec egestas nunc eu blandit malesuada. Aenean vel justo eu dui mollis sodales. Nulla sed lorem accumsan, consectetur nulla sed, ultrices risus. Cras vitae euismod dui, quis dictum justo. In venenatis eros vel scelerisque mollis. Maecenas placerat tellus eu pretium faucibus. Cras molestie erat placerat massa efficitur gravida. Quisque congue purus mauris, in mollis tellus pharetra quis. Sed consectetur, mauris ut ornare cursus, ante mauris imperdiet arcu, ut luctus est augue a velit. Nulla sodales luctus lectus at auctor. Curabitur id sem et urna vestibulum laoreet.</p>

                    <p>Etiam ac arcu lorem. Etiam eu porttitor leo. Curabitur magna neque, sollicitudin vel diam ac, dignissim rutrum lorem. Duis lobortis elit nec lorem lobortis, eu semper sem condimentum. Donec sed semper dolor. Maecenas quis tellus eget ante congue ornare. Nunc fringilla pretium nunc, et blandit felis ultricies a. In odio eros, feugiat eget tincidunt nec, euismod et enim. Mauris fermentum metus nisi, sed posuere ipsum ultricies a. In tempor massa at elit semper consectetur. Maecenas id laoreet ligula. Sed varius accumsan tortor, vitae elementum odio feugiat placerat. Integer rutrum ac nisi porta tincidunt. Nulla scelerisque odio quis lorem rutrum, sit amet semper odio euismod. Vestibulum viverra rhoncus mauris. Curabitur ac luctus leo.</p>

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