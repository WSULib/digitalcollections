<?php

if($_POST) {

    // $emailTo = "libwebmaster@wayne.edu";
    // $emailFrom = "libwebmaster@wayne.edu";

    $emailTo = "ej2929@wayne.edu";
    $emailFrom = "ej2929@wayne.edu";

    $clientName = trim($_POST['name']);
    $clientEmail = trim($_POST['email']);
    $subject = "Message about WSU Digital Collections";
    $message = "Sender:\n" . $clientName . "\n\nMessage:\n" . trim($_POST['message']);
    $recaptcha = trim($_POST["recaptcha_response_field"]);

    $array = array();
    $array['nameMessage'] = '';
    $array['emailMessage'] = '';
    $array['messageMessage'] = '';
    $array['recaptchaMessage'] = '';

    //Required fields
    if($message == '') {
        $array['messageMessage'] = "This is a required field.";
    }
    if ($recaptcha == '') {
        $array['recaptchaMessage'] = "The reCAPTCHA wasn't entered correctly. Try again.";        
    }

    if($message != '' && $recaptcha !== '') {

    // RECAPTCHA check before send
    // require_once($_SERVER['ST_ROOT'].'recaptcha-php-1.11/recaptchalib.php');
    // require_once($_SERVER['ST_ROOT'].'recaptcha-php-1.11/privatekey.php');

    require_once'recaptcha-php-1.11/recaptchalib.php';
    require_once'recaptcha-php-1.11/privatekey.php';

    $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

    if (!$resp->is_valid) {
        // What happens when the CAPTCHA was entered incorrectly
        $array['recaptchaMessage'] = "The reCAPTCHA wasn't entered correctly. Try again.";
    } 

    else {
    // Send email
    $headers = "From: <$emailFrom>" . "\r\n" . "Reply-To: " . $clientEmail;
    mail($emailTo, $subject, $message, $headers);
    }
    }

    echo json_encode($array);

}

?>
