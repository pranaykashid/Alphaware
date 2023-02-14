<?php
// use PHPMailer\PHPMailer\PHPMailer;
include('connect.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';

$mail = new PHPMailer(true);



$alert = '';
if(isset($_POST)){// echo "<pre>"; print_r($_POST); exit;
            $name=$_POST['name'];
            $email=$_POST['email'];
            $mno=$_POST['mno'];
            $subject=$_POST['subject'];
            $message = $_POST['message'];
            
            $query = "INSERT INTO contact(name,email,mno,subject,message) VALUES ('$name','$email','$mno','$subject','$message')";

				if(mysqli_query($conn, $query))
				{
		  			mail_one($name,$email,$mno,$subject,$message);
		  			// mail_two($name,$email,$phone);	
				}


}

function mail_one($name,$email,$mno,$subject,$message)
{
    $mail = new PHPMailer(true);
	$mail->isSMTP();
    $mail->Host = 'md-101.webhostbox.net'; 
    $mail->SMTPAuth = 'yes';
    $mail->Username = 'contact@alphawarenext.com'; 
    $mail->Password = 'a$S8Jg=s%UZF';
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPSecure = 'ssl'; 
    $mail->Port = '465';
 
    $mail->setFrom('contact@alphawarenext.com'); // Gmail address which you used as SMTP server
    //$mail->addAddress('wagons.management@gmail.com');
    $mail->addAddress('vineet@alphaware.io'); 
    
    // Email address where you want to receive emails (you can use any of your gmail address including the gmail address which you used as SMTP server)

    $mail->isHTML(true);
    $mail->Subject = "Contact Details"; // 'Message Received (Contact Page)';
    // $mail->MsgHTML($msg);
    $mail->Body = "<h1>Contact Details: </h1><br> 
                  <h3>Name : ".ucfirst($name)."<br>Email Id: $email <br>Mob No.: $mno <br>Subject : $subject <br>Message : $message  </h3>";

    $mail->send();
}




/*
function mail_two($name,$email,$phone)
{
    $mail = new PHPMailer(true);
	$mail->isSMTP();
    $mail->Host = 'p3plmcpnl487206.prod.phx3.secureserver.net';
    $mail->SMTPAuth = 'yes';
    $mail->Username = 'test@wagonslearning.in'; // Gmail address which you want to use as SMTP server
    $mail->Password = 'mO3CVQ^9nGqj'; // Gmail address Password
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPSecure = 'ssl'; 
    $mail->Port = '465';

    $mail->setFrom('contact@wagonslearning.com'); // Gmail address which you used as SMTP server
    //$mail->addAddress('wagons.management@gmail.com');
    $mail->addAddress($email);
    // Email address where you want to receive emails (you can use any of your gmail address including the gmail address which you used as SMTP server)

    $mail->isHTML(true);
    $mail->Subject = "Welcome to Wagons Learning !"; // 'Message Received (Contact Page)';
    // $mail->MsgHTML($msg);
    $mail->Body = "<p>Dear ".ucfirst($name).",</p> 
                  <p>We just received your message. Thank you very much for writing to us.</p>
                  <p>We are working on your request and will get in touch as soon as possible.</p>
                  <p>If you have any urgent issues, please contact our staff by phone – +91 9535618971.<br>We are happy to be of your assistance.</p>
                  <p>Kind regards,<br>Wagons Learning</p>";

    $mail->send();
}
*/

echo "<script>
window.location.href='index.html?msg=success';
</script>";

?>
