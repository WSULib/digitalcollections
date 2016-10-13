<?php

if($_POST) {

    $emailTo = trim($_POST['to']);
    $clientName = trim($_POST['name']);
    $clientEmail = trim($_POST['email']);
    $message = trim($_POST['message']);
    $subject = trim($_POST['subject']);
    if (isset($_POST['url'])) {
        $url = "\n\nURL:\n$_POST[url]\n\n";
    }
    else {
        $url = "\n\nURL:\nitem URL unknown\n\n";
    }

    $array = array();
    $array['nameMessage'] = '';
    $array['emailMessage'] = '';
    $array['messageMessage'] = '';
    $array['recaptchaMessage'] = '';

    //Required fields
    if($message == '') {
        $array['messageMessage'] = "This is a required field.";
    }

    if(!isset($_POST['g-recaptcha-response']) && empty($_POST['g-recaptcha-response'])) {
        $array['recaptchaMessage'] = "Please click on the reCAPTCHA box.";        
    }

    if($message != '' && isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

    // RECAPTCHA check before send
    require_once'recaptcha/privatekey.php';

    //get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$privatekey.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);

    if (!$responseData->success) {
        // What happens when the CAPTCHA was entered incorrectly
        $array['recaptchaMessage'] = "Verification failed. Please try again.";
    } 

    else {
    // Send email
    $message = "Sender:\n" . $clientName . "\n\nEmail:\n" . $clientEmail . "\n\nMessage:\n" . $url . trim($_POST['message']);
    $headers = "From: <$clientEmail>" . "\r\n" . "Reply-To: " . $clientEmail;
    mail($emailTo, $subject, $message, $headers);
    }
    }

    echo json_encode($array);

}

?>
