<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

//Load Composer's autoloader
require 'vendor/autoload.php';

if ( $_POST['submit'] == "Je participe"){
    $mail = new PHPMailer(true);
    $pattern = "/^[\p{L}._-]{2,100}$/u";
    $pattern2 = "/^[a-zA-Z]+$/";

    //check token

        if(isset($_POST['name'])){
            $name = $_POST['lastname'];
        }
        $name = strip_tags( $_POST['lastname']);
        $name = substr( $name,0,25);
        //clean out any potential hexadecimal characters
        $name = cleanHex( $name);

        if(isset($_POST['day']) && !empty($_POST["day"])) {
            $days = $_POST['day'];
            foreach($days as $day) {
                $choice .= $day . ' ';
            }
        }



        if(!empty($name)){
            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();
                $mail->setLanguage('fr');
                $mail->CharSet = 'UTF-8';                                          //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username = 'alvardsandz@gmail.com';
                $mail->Password = 'plqtuoicktgjowqi';                       //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('alvardsandz@gmail.com', $name);
                $mail->addAddress('alvardsandz@gmail.com', 'Denis Godec');     //Add a recipient    
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Réservation Belle-ile-en-mer';
                $mail->Body    = '<b>Réservation : </b>'.$name.' '.$choice.'';
            
                $mail->send();
                header("Location: ./response.php");
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        
        }
    
}
$token = md5(uniqid(rand(), true));
$_SESSION['token'] = $token;
function cleanHex( $input){
    $clean = preg_replace("![][xX]([A-Fa-f0–9]{1,3})!", "", $input);
    return $clean;
}
?>