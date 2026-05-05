<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3MCNHDMT1D"></script>
    <script>
         window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-3MCNHDMT1D');
    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Spell of Cipher</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" type="image/png" href="images/logos/SOC_TL.png" />
</head>

<body style='background:linear-gradient(to left, #92278f, #262262); color:whitesmoke;'>
    <div class="container-fluid" class="overflow=scroll">
        <img src="images/logos/logo_f.png" style="float:right; height:5rem;  ">
        <center>
            <img src="images/others/r_s.svg" style="height:20rem; margin-top:3%">
            <h2> Your Registration was Successful! </h2>
             <!-- A Verification Email is sent on <span style='color:#f2b61a;'> <i>'".$email."'</i></span> -->
              <!-- Please check your email and complete the payment procedure to activate your account. -->
            <p style="font-size:20px"><?php echo $_SESSION['response'];?><br>Happy Coding, Cheers! </p>
            
            <form method="POST">
                <input type="submit" class="btn btn-light" name="resend" value="Resend Email">
                <a href="login.php"  class="btn btn-primary"> Go To Login</a>
               

            </form>
        </center>
    </div>

</body>

</html>

<?php
$rank="SOC-".str_pad(uniqid(),9);


require 'PHPMailer/src/PHPMailer.php'; 
require 'PHPMailer/src/SMTP.php'; 
require 'PHPMailer/src/Exception.php';
			
use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST['resend'])){

    $email = $_SESSION['user_email'];
    
    $mail = new PHPMailer();

    //smtp settings
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "spellofcipher@gmail.com";
    $mail->Password = 'Tmkocis<3';
    $mail->Port = 587;
    $mail->SMTPSecure = "tls";

    //email settings
    
    $mail->isHTML(true);
    $mail->setFrom($email, "Support Team");
    $mail->addAddress($email);
    $mail->Subject = ("Account Activation | Spell of Cipher");
    $mail->Body = "<h4>Greetings Spell Caster,</h4>
      You have successfully registered for the <strong> Spell of Cipher</strong>. Please 
      <a href='http://spellofcipher.in/paymentrequest.php?participant=".$email."&rank=".$rank."'>Click Here</a>  to activate your account and complete the payment procedure. Hope you have hassle-free experience and an even better coding experience in this competition.<br><br>
      For any queries,
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
      $_SESSION['response'] = "A Verification Email is sent on <span style='color:#262262;'> <i>'".$email."'</i></span> <br>
        Please check your email and complete the payment procedure to activate your account.";
    }
    else
    {
        $status = "failed";
        $_SESSION['response'] =  "Something is wrong in send email.please verify a email.<br>If you write correct then contact us we will solve your problem";
    }

    exit();
    $send=false;
   
}

?>