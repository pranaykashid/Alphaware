

<?php
// use PHPMailer\PHPMailer\PHPMailer;
include('connect.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';

$mail = new PHPMailer(true); 

$target_dir = "resume/";
$target_file = $target_dir . basename($_FILES["resume"]["name"]);
$uploadOk = 1;
$pdfFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


$alert = '';
if(isset($_POST)){// echo "<pre>"; print_r($_POST); exit;

    // Check file size
    if ($_FILES["resume"]["size"] > 5000000) {

        echo "<script>
        window.location.href='index.html?msg=fail';
        </script>"; 

    // echo "<script>failure();</script>";
   // echo "Sorry, your file is too large.";
    $uploadOk = 0;
    }

    // Allow certain file formats
    if($pdfFileType != "pdf" ) {
     $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {

        echo "<script>
        window.location.href='index.html?msg=fail';
        </script>"; 

    }
     else {

        if (move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file)) {
            // echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";

            $fname=$_POST['first_name'];
            $lname=$_POST['last_name'];
            $email=$_POST['email'];
            $mno=$_POST['mno'];
            $position=$_POST['job_position'];
            $location = $_POST['location'];
            $filename = $_FILES["resume"]["name"];
            
            $query = "INSERT INTO job_application(first_name,last_name,email,mno,position,location,file_name) 
            VALUES ('$fname','$lname','$email','$mno','$position','$location','$filename')";

				if(mysqli_query($conn, $query))
				{
		  			mail_one($fname,$lname,$email,$mno,$position,$location,$filename);
		  			
				}

                echo "<script>
                window.location.href='index.html?msg=success'; 
                </script>"; 
        } 
        else 
        {
        //   echo "<script>alert('Failure 2');</script>";
        }
     }
    
           


}
 
function mail_one($fname,$lname,$email,$mno,$position,$location,$filename)
{
    $mail = new PHPMailer(true);
	$mail->isSMTP();
    //$mail->Host = 'mail.alphaware.io';
    $mail->Host = 'md-101.webhostbox.net'; 
    $mail->SMTPAuth = 'yes';
    $mail->Username = 'contact@alphawarenext.com'; 
    $mail->Password = 'a$S8Jg=s%UZF';
    
    $mail->SMTPSecure = 'ssl'; 
    $mail->Port = '465';

    $mail->setFrom('contact@alphawarenext.com');  

    $mail->addAddress('hr@alphaware.io');  
  
    $mail->isHTML(true);
    $mail->Subject = "Applicant Details"; 
   
    $mail->Body = "<h1>Applicant Details: </h1><br> 
                  <h3>First Name : ".ucfirst($fname)."<br>Last Name : ".ucfirst($lname)."<br>Email Id: $email <br>Mob No.: $mno <br>Applied For : $position <br>location : $location <br>Resume : https://alphaware.io/resume/$filename  </h3>";
    
    $mail->send();
}



?>
