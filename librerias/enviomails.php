<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

require '../vendor/autoload.php';

class envioEmail {

    function send($header,$body,$email) {

        $today = date('ydmHis');
        $exist = 0;
        //Create a new PHPMailer instance
        $mail = new PHPMailer(true); 
        try {
            //Tell PHPMailer to use SMTP
            $mail->isSMTP(true);
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'html';
            $mail->IsHTML(true);
            $mail->Host = "in-v3.mailjet.com"; //"sinttecom.com";
            $mail->SMTPSecure = 'tsl';
            //Set the SMTP port number - likely to be 25, 465 or 587
            $mail->Port = 587;
            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;
  
            //Username to use for SMTP authentication
            $mail->Username = "b47558f60e74e7a5309eb9bc5341b5c5";
            //Password to use for SMTP authentication
            $mail->Password = "7dcef91a8ed30d3f7d9a831126bf60c5";
            //Set who the message is to be sent from
            $mail->setFrom('sistemasae@sinttecom.com', 'Sistema SAE');
            //Set an alternative reply-to address
            //$mail->addReplyTo('pruebas@ventaruta.com', 'DSD');
            //Set who the message is to be sent to 
            //$mail->addAddress('acuan@integraconsultoria.com.mx', 'Antonio Cuan');
            //$mail->addAddress('fzambrano@integraconsultoria.com.mx', 'Fernando Zambrano');
            $mail->addAddress($email);
           // $mail->addAddress($email);
            //$mail->addAddress('jeferhgomez@gcuetara.com.mx', 'Ixel Rodriguez');
            //Set the subject line
            $mail->Subject = $header;
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
            //Replace the plain text body with one created manually
            $mail->Body = $body;
            //Attach an image file
            //$mail->AddStringAttachment($texto,'alertas_'.date('Ymd').'.txt');
            //send the message, check for errors
            if (!$mail->send()) {
            $exist =  0; //"Error Envio de Asistencias por Correo: " . $mail->ErrorInfo;
            } else {
                $exist = "SE Envio correctamente";
            }
        } catch (Exception $e) {
            $exist =  'El Mensaje no pudo ser enviado.  Error: '. $mail->ErrorInfo;
        }    
            return $exist;
    }

}

?>
