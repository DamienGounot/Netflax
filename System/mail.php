<?php
    function sendMail($username,$email,$hash,$domain,$from){
        $subject = 'the subject';
        $message = 'hello';
        $headers = 'From: webmaster@example.com' . "\r\n" .
            'Reply-To: webmaster@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

            mail($email, $subject, $message, $headers);
    }
?>