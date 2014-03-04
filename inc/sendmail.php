<?php

if($_POST) {

    $emailTo = "axa.liauw@wayne.edu";
    $emailFrom = "donotreply@cgi.lib.wayne.edu";

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
        $array['messageMessage'] = "Please enter your message.";
    }
    if($message != '') {
        // Send email
    $headers = "From: <$emailFrom>" . "\r\n" . "Reply-To: " . $clientEmail;
    mail($emailTo, $subject, $message, $headers);
    }

    echo json_encode($array);

}

?>
