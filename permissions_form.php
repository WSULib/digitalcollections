<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Permissions Request | Digital Collections | WSULS</title>
    <meta name="viewport" content="initial-scale=1">

    <!-- load site-wide dependencies -->
    <?php include('inc/site_wide_depends.php'); ?>
  <script src="https://unpkg.com/masonry-layout@4.1/dist/masonry.pkgd.min.js"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
    <!-- capture values from the preceding page -->
    <?php
        if(isset($_SERVER['HTTP_REFERER'])) {
            $url = $_SERVER['HTTP_REFERER']; // string
        }
        else {
            $url = '';
        }
    ?>
    <!-- image PID array -->
    <?php
    $image_array = array(
        "wayne:vmc10077"
    );

    ?>
</head>
<body>

    <?php include('inc/header.php'); ?>

    <div class="container">
        <h2>Permissions Request</h2>
          <div class="row">
                <div class="hidden-xs col-sm-6 col-md-6 contact">
                    <div class="grid" data-masonry='{ "itemSelector": ".grid-item"}'>
                    <?php
                    foreach ($image_array as $image_PID) {
                        $PID = explode(":", $image_PID)[1];
                        echo "<div class='grid-item'><img src='https://digital.library.wayne.edu/loris/fedora:".$image_PID."%7C".$PID."_JP2/full/full/0/default.jpg'></div>";
                    }
                    ?>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 contact-form">
                    <form method="post" action="#">
                        <label for="name" class="nameLabel">Name</label>
                          <input id="name" type="text" name="name" placeholder="Enter your name">
                        <label for="email" class="emailLabel">Email</label>
                          <input id="email" type="text" name="email" placeholder="Enter your email">
                        <label for="message" class="messageLabel">Message</label>
                          <textarea id="message" name="message" placeholder="Your message"></textarea>
                        <input type="hidden" id="url" name="url" value=<?php echo $url; ?> />
                        <input type="hidden" name="subject" value="Permissions Request" />
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
</body>
</html>