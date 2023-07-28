<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

//Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);
if ( $_POST['submit'] == "Je participe"){
//check token
   if ( $_POST['token']== $_SESSION['token']){
        $name = strip_tags( $_POST['lastname']);
        $name = substr( $name,0,25);
        //clean out any potential hexadecimal characters
        $name = cleanHex( $name);
        if(!empty($name)&& strlen($name) <= 20){
    try {
        if(isset($_POST['send'])) {
            $name = $_POST['lastname'];
        }
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username = 'alvardsandz@gmail.com';
        $mail->Password = 'plqtuoicktgjowqi';                              //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('alvardsandz@gmail.com', $name);
        $mail->addAddress('alvardsandz@gmail.com', 'Denis Godec');     //Add a recipient
    
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Réservation Belle-ile-en-mer';
        $mail->Body    = '<b>Réservation : </b>'.$name.'</br>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
         header("Location: ./response.php");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}
   }
} else {
    header("Location: ./index.php");
}

$token =md5(uniqid(rand(), true));
$_SESSION['token']= $token;

function cleanHex( $input){
    $clean =preg_replace("![][xX]([A-Fa-f0–9]{1,3})!", "", $input);
    return $clean;
}

/*<?php echo $_SERVER['PHP_SELF'];?>*/
/*
$mail = new PHPMailer(true);
function valid_data($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = htmlentities($data);
        return $data;
    }
    $name = valid_data($_POST['lastname']);
    
if(!empty($name)&& strlen($name) <= 20){
    try {
        if(isset($_POST['send'])) {    
            $name = valid_data($_POST['lastname']);
        }
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username = 'alvardsandz@gmail.com';
            $mail->Password = 'plqtuoicktgjowqi';                              //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('alvardsandz@gmail.com', $name);
        $mail->addAddress('alvardsandz@gmail.com', 'Denis Godec');     //Add a recipient
    
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Réservation Belle-ile-en-mer';
        $mail->Body    = '<b>Réservation</b></br>'.$name.'</br>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
         header("Location: ./response.php");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}
*/


/*
session_start();
if ( $_POST['submit'] == "Je participe"){
   //check token
   if ( $_POST['token']== $_SESSION['token']){
      //strip_tags
      $name =strip_tags( $_POST['name']);
      $name =substr( $name,0,40);
      //clean out any potential hexadecimal characters
      $name =cleanHex( $name);
      //continue processing….
   }else{
      //stop all processing! remote form posting attempt!
   }
}
$token =md5(uniqid(rand(), true));
$_SESSION['token']= $token;
function cleanHex( $input){
    $clean =preg_replace("![][xX]([A-Fa-f0–9]{1,3})!", "", $input);
    return $clean;
}
*/
/*
<form action="<?php echo $_SERVER['PHP_SELF'];?>"method="post">
<p><labelfor="name">Name</label>
<input type="text"name="name" id="name" size="20"maxlength="40"/></p>
<input type="hidden"name="token" value="<?php echo $token;?>"/>
<p><input type="submit"name="submit" value="go"/></p>
</form>

*/



// if(isset($_POST['send'])) {
//         try{
//     $name = htmlentities($_POST['lastname'])


//         $mail->isSMTP();
//         $mail->Host = 'smtp.gmail.com';
//         $mail->SMTPAuth = true;
//         $mail->Username = 'alvardsandz@gmail.com';
//         $mail->Password = 'plqtuoicktgjowqi'
//         $mail->Port = 465;
//         $mail->SMTPSecure = 'ssl';
//         $mail->isHTML(true);
//         $mail->setFrom($email, $name)
//         $mail->addAddress('alvardsandz@gmail.com')
//         $mail->Subject = ("$email ($subject)");
//         $mail->$message
//         $mail->send();
// echo "Message Sent OK\n";
// header("Location: ./response.php");
//     }
//     catch (phpmailerException $e) {
//   echo $e->errorMessage(); //Pretty error messages from PHPMailer
// } catch (Exception $e) {
//   echo $e->getMessage(); //Boring error messages from anything else!
// }

// }