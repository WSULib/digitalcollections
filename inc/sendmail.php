<?php

if($_POST) {

    $emailTo = "libwebmaster@wayne.edu";
    $emailFrom = "libwebmaster@wayne.edu";

    $clientName = trim($_POST['name']);
    $clientEmail = trim($_POST['email']);
    $subject = "Message about WSU Digital Collections";
    $message = trim($_POST['message']);

    $array = array();
    $array['nameMessage'] = '';
    $array['emailMessage'] = '';
    $array['messageMessage'] = '';

    //Required fields
    if($message == '') {
        $array['messageMessage'] = "This is a required field.";
    }
    if($message != '') {
        // Send email
    $headers = "From: <$emailFrom>" . "\r\n" . "Reply-To: " . $clientEmail;
    mail($emailTo, $subject, $message, $headers);
    }

    echo json_encode($array);

}

?>
