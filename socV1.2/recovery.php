<?php 

include('dbconnect.php');
$otp=str_pad(rand(0,999999),6, "0", STR_PAD_LEFT);
$send=false;
 $err="";
if(isset($_POST['send_submit']))
{
  $GLOBALS['register']="false";
  $email=$_POST['fg_email'];
  $sql1 = "SELECT  email FROM  credentials_info where email='$email' ";
  
  
  $query1 = mysqli_query($GLOBALS['conn'], $sql1);
  
  while ( $page = mysqli_fetch_array($query1)) {
 
  
       
      
  if(!empty($page))
    {
      session_start();
      $_SESSION['forforgot_email'] = $email;
      $GLOBALS['register']="true";
      $send=true;
      echo  $_SESSION['forforgot_email'];
      $sql3 = "UPDATE credentials_info set  pass='$otp' where email='$email'";
       $query3 = mysqli_query($GLOBALS['conn'], $sql3);
       header('Location: ./set_password.php');
    }
    
    
    }
    if($GLOBALS['register']="false"){
        $err="Email is not registered";
        
    }
   
}


require 'PHPMailer/src/PHPMailer.php'; 
require 'PHPMailer/src/SMTP.php'; 
require 'PHPMailer/src/Exception.php';
			
use PHPMailer\PHPMailer\PHPMailer;

if($send=="true"){
   
    // $password = $_POST['pass'];
    // $leader = $_POST['leader'];

    
    $mail = new PHPMailer();

    //smtp settings
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "spellofcipher@gmail.com";//"tanmaysinh04@gmail.com";//
    $mail->Password = 'Tmkocis<3';//'khant5108';//
    $mail->Port = 587;
    $mail->SMTPSecure = "tls";

   
    $mail->isHTML(true);
    $mail->setFrom($email, "Support Team");
    $mail->addAddress($email);//("19bt04018@gsfcuniversity.ac.in")
    $mail->Subject = (" One Time Password (OTP) for your SOC Account");
    $mail->Body = "<h4> Hello Spell Caster,</h4>
    Use <b>'".$GLOBALS['otp']."'</b> as One Time Password (OTP) to reset your password for your Spell Of Cipher Account. 
    <br><br>
    Please do not share this OTP with anyone for security reasons.
    <br><br>
      If this wasn't you:
      <br><br>

      <strong>Contact - <br> Kalp Vaidya, Marketing & Public Relations Manager,8200324879 <br> Vrunal Patel, Quality Assurance Specialist, 9909415227 </strong>
      <br><br>
      Regards,
      <br>
      Support Team,
      <br>
      Spell Of Cipher.";
   

   

    if($mail->send()){
        $status = "success";
        $response = "Email is sent!";
    }
    else
    {
        $status = "failed";
        $response = "Something is wrong: <br>" . $mail->ErrorInfo;
    }

    exit(json_encode(array("status" => $status, "response" => $response)));
    $send=false;
}

?>


<!DOCTYPE html>
<html>
   <head>
           <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3MCNHDMT1D"></script>
    <script>
         window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-3MCNHDMT1D');
    </script>
      <meta charset="utf-8">
      <title>Recovery Page | SOC</title>
      
      <link rel="stylesheet" type="text/css" href="css/login.css">
      <link rel="stylesheet" type="text/css" href="css/mobile_view.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="shortcut icon" href="images/logos/SOC_TL.png" type="image/x-icon">



   </head>
   <body>

   <div class="backbutton" style="" onclick="goBack()">
     <i class="fa fa-arrow-left"  id="homeicon" style=" "></i>
    </div>
<script>
function goBack() {
  window.history.back();
}
</script>
    <img class="image"   src="images/background/logo_mobileview2.png" >
     
    <div class="container-fluid wrapper" id="login_signup" style="margin-top: 15%;">

         <div class=" title-text">
            <div class="title login">
               RESET PASSWORD
            </div>
           
         </div>
         <div class="error">
          <center> <?php echo $err; ?></center>
         </div>
         <div class="form-container">
            <div class="form-inner" style="display: block;">
               <form  method="POST">
                  <div class="field">
                     <input type="email" placeholder="Email Address" name="fg_email"  required>
                  </div>
                   <div class="field btn">
                     <div class="btn-layer"></div>
                     <input type="submit" value="SEND OTP" name="send_submit">
                  </div>
                </form>
               
            </div>
         </div>
      </div>

</body>
</html>