<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if(isset($_POST['registerUser']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    //Load Composer's autoloader
    require 'composer/vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication

        $mail->Username   = 'learninggeeks48@gmail.com';                     //SMTP username
        $mail->Password   = 'qxgsutpqjrfrneox';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('learninggeeks48@gmail.com');
        $mail->addAddress($email);     //Add a recipient
        
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Thank you for registering';
        $mail->Body    = 'Hello '.$name.',<br><br>Thank you for registering with us.<br><br>Best regards,<br> Infotech';
        
        if ($mail->send()) {
            $_SESSION['status'] = "Thank you for registering. Confirmation email sent.";
            header("Location: {$_SERVER["HTTP_REFERER"]}");
            exit;
        }
        else {
            $_SESSION['status'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            exit;
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        exit;
    }
}
else {
    header("Location: {$_SERVER["HTTP_REFERER"]}");
    exit;
}

?>