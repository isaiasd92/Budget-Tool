<?php
    $thisEmailMonth = $_POST["thisMonth"];

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/PHPMailer.php';
    require 'phpmailer/Exception.php';
    require 'phpmailer/SMTP.php';

    $mail = new PHPMailer();                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'isaandvalbudgettool@gmail.com';    // SMTP username
        $mail->Password = 'C@nela2018';                       // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
    
        //Recipients
        $mail->setFrom('isaandvalbudgettool@gmail.com', 'Isa and Val Budget Tool');
        $mail->addAddress('isaiasdelgado03@gmail.com', 'Isaias Delgado');     // Add a recipient
        $mail->addReplyTo('isaandvalbudgettool@gmail.com', 'Isa and Val Budget Tool');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
    
        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Budget Summary for '.$thisEmailMonth.'';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
      }





    /*
    $to = "isaiasdelgado03@gmail.com";
    $subject = "Budget Tool - ".$thisEmailMonth." Summary";
    
    $message = "<b>This is HTML message.</b>";
    $message .= "<h1>This is headline.</h1>";
    
    $header = "From: isaiasdelgado03@gmail.com \r\n";
    //$header .= "Cc: valeriagonzalez1990@gmail.com  \r\n";
    $header .= "Reply-To: isaiasdelgado03@gmail.com \r\n";
    $header .= "MIME-Version: 1.0\r\n"; 
    $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
    $header .= "X-Priority: 1\r\n"; 

    if(mail ($to, $subject, $message, $header)){
        $result = "sent";
    }
    else{
        $result = "fail";
    }
    echo $result;
    */
?>