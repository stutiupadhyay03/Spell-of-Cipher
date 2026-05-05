<?php
session_start();
include('dbconnect.php');
 
// ===================print error on sign up problem=========================
$_SESSION['signuperr']="false";

// ==============chek that===is this from set password or not or if from set password than print "Password SET successfully"=======================================
$byforgot="";
if(!empty($_SESSION['password_success'])){
    $byforgot="Password SET successfully";
}
$_SESSION['password_success']="";


// ============================signin  start=============================
$wrongpass=$passformatinlogin=$paymenterr="";
if(isset($_POST['signin_submit']))
{
  $mail=$_POST['si_email'];
  $sql1 = "SELECT  * FROM  credentials_info where email='$mail' ";
  //$sql2 = "SELECT  type FROM  credentials_info where email='$mail' ";
  
  $query1 = mysqli_query($GLOBALS['conn'], $sql1);
  // $query2 = mysqli_query($GLOBALS['conn'], $sql2);
        
       

  while($user = mysqli_fetch_array($query1))
  {
    if($user['paisa']!="complete"){
      $paymenterr="Payment is Pending";
    }else
    {
       // ===================== chek password================
      if(md5($_POST['si_pass'])!=$user['pass'])
      {
        $wrongpass="Password is incorrect";
      }else
      { 
        // ==================chek password validation====================
        $password = $_POST['si_pass'];
        $length="false";
        $len=strlen($password);
        if($len<=16 and $len >=6){$length="true";}
        $number = preg_match('@[0-9]@', $password);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $specialChars = preg_match("/[\'^£$%&*()}{@#~?><>,|=_+¬-]/", $password);

        if(!$number || !$uppercase || !$lowercase || !$specialChars || $length=="false")
        {
          $passformatinlogin="Reset your password via Forgot Password feature as an attempt to change password was made.";
        }else
        {
          $_SESSION['user_email'] = $mail;
          $_SESSION['user_type'] = $user['type'];
          $_SESSION['login_status']="login";
         // =============if this is a team member who not filled profil than========
          if($user['type']=="under_process" or  $user['type']=="solo_inactive" or  $user['type']=="team_leader_inactive")
            {
              header('Location: ./profile_setup.php');
            }elseif($user['type']=="team_leader_incomplete")
            {
               header('Location: ./team_setup.php');
            }else
            {
              header('Location: ./dashboard.php');
            }
        }
      }
    }  
  }
}
// ============================signin  end=============================

// =================variable for don't send email before successfully sign up=====
 $send="false";

// ============================signUP  start=============================
 $repeatemailerr=$passformaterr=$typeerr=$matchpasserr=$emailerr="";
if(isset($_POST['signup_submit']))
{
    $send="false";
    $mail=$_POST['su_email'];
    $type=$_POST['su_type'];

    // ===============chek email is not empty or proper================

    if(!empty($_POST['su_email']))
    { 
        if (!filter_var($_POST["su_email"], FILTER_VALIDATE_EMAIL))
      {
        $emailerr = "Fill Proper Email";
        $fillemail=false;
         $_SESSION['signuperr']="true";
      }else{
        $fillemail=true;
      }
    }else
    {
        $emailerr="Fill The Email Field";
        $fillemail=false;
        $_SESSION['signuperr']="true";
    }

    

  // ===============chek password and Retype password same or not==============
    if ($_POST['su_pass']!=$_POST['su_repass'])
    { 
      $_SESSION['signuperr']="true";
      $matchpasserr="Password and Confirm password must be same.";
      $pass=false;
    }else
    {
        $pass=true;
    }

 // ===============chek type empty or not==============
    if (!empty($_POST['su_type']))
    {
        $su_type=true;
    }else
    {
        $su_type=false;
        $_SESSION['signuperr']="true";
        $typeerr="Select Solo or Team";
    }

    //make id for differenciate and collabrate team
    $id="SOC-".str_pad(rand(0,999),3, "0", STR_PAD_LEFT);

    if(isset($_POST['signup_submit']) and  $su_type=="true" and $pass=="true" and    $fillemail=="true")
    {
      $password = $_POST['su_pass'];
      $length="false";
      $len=strlen($password);
      if($len<=16 and $len >=6){$length="true";}
      $number = preg_match('@[0-9]@', $password);
      $uppercase = preg_match('@[A-Z]@', $password);
      $lowercase = preg_match('@[a-z]@', $password);
      $specialChars = preg_match("/[\'^£$%&*()}{@#~?><>,|=_+¬-]/", $password);

      if(!$number || !$uppercase || !$lowercase || !$specialChars || $length=="false")
      {
        $_SESSION['signuperr']="true";
        $passformaterr="Password is not in the requested format.";
      }else
      {
       $_POST['su_email']=strtolower($_POST['su_email']);

       $rank="SOC-".str_pad(uniqid(),8);
       
       $_POST['su_pass']=md5($_POST['su_pass']);
        $sql = "INSERT into credentials_info values ('".$_POST['su_email']."','".$_POST['su_pass']."','".$_POST['su_type']."','".$id."','".$rank."')";
                                                                                                                                                                                                                                                                                                                                
        $query = mysqli_query($GLOBALS['conn'], $sql);

      
        if($query) 
        {

        $insertsql = "INSERT into test values ('".$id."','".$_POST['su_email']."','NA','NA')";
        $insertquery = mysqli_query($GLOBALS['conn'], $insertsql);


            $send="true";
            $_SESSION['user_email'] = $mail;
            $_SESSION['user_type'] = $type;
            header('Location: ./after_reg.php');

        }else
        {
              $_SESSION['signuperr']="true";
              $repeatemailerr="This Email has already been used for registration.";
             
        }
      }

    }
        
}

// ============================signUP  end=============================

//======================FOR EMAIL start=======================
 $_SESSION['$response']="Trial Test";
 
 require 'PHPMailer/src/PHPMailer.php'; 
 require 'PHPMailer/src/SMTP.php'; 
 require 'PHPMailer/src/Exception.php';
          
 use PHPMailer\PHPMailer\PHPMailer;

if($send=="true"){

    $email = $_SESSION['user_email'];

    $mail = new PHPMailer();

    //smtp settings
    $mail->isSMTP();
    // $mail->SMTPDebug=1;
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
 
    
    // echo "<h1></h1>";

    if($mail->send()){
        $status = "success";
      $_SESSION['response'] = "A Verification Email is sent on <span style='color:#f2b61a!important;'> <i>'".$email."'</i></span> <br>
        Please check your email and complete the payment procedure to activate your account.The payment link will be active for 10 minutes.";
    }
    else
    {
        $status = "failed";
        $_SESSION['response'] =  "Something is wrong in send email.please verify a email.<br>If you write correct then contact us we will solve your problem";
    }

    exit();
    $send=false;
   
}

//======================FOR EMAIL end=======================


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
      <title>Login | SOC</title>
      
      <link rel="stylesheet" type="text/css" href="css/login.css">
      <link rel="stylesheet" type="text/css" href="css/mobile_view.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="shortcut icon" type="image/png" href="images/logos/SOC_TL.png"/>


   </head>
   <body>
    <a href="index.php" class="backbutton" style="">
     <i class="fa fa-home"  id="homeicon" style=" "></i>
    </a>
    <div id="signupstatus" hidden=""><?php echo  $_SESSION['signuperr'];?></div>
      <center><img class="image" style="height:27vh;" src="images/background/mobile.png" >
      </center>
      <div class="container-fluid wrapper" id="login_signup">

         <div class=" title-text" id="heading" style="display: flex;">
            <div class="title login">
               Login Form
            </div>
            <div class="title signup">
               Signup Form
            </div>
         </div>
         
         <div class="error" >
          <center> <?php echo $repeatemailerr,$passformaterr,$typeerr,$matchpasserr,$emailerr,$wrongpass,$passformatinlogin,$paymenterr; ?></center>
         </div>
         <div class="form-container">
            <div class="slide-controls">
               <input type="radio" name="slide" id="login" >
               <input type="radio" name="slide" id="signup">
               <label for="login" class="slide login">Login</label>
               <label for="signup" class="slide signup">Signup</label>
               <div class="slider-tab"></div>
            </div>
            <div class="form-inner">
               <form  class="login"  method="POST">
                <div  class="error" style="color: #222240 ;background-color: #C8F19C" >
                  <center>
                    <?php echo  $byforgot; ?>
                  </center>
                </div>
                  <div class="field">
                     <input type="email" placeholder="Email Address" name="si_email"  required>
                  </div>
                  <div class="field">
                     <input type="password" placeholder="Password" name="si_pass"   required>
                  </div>

                  <div class="pass-link"  onclick="forgot()">
                     <a href="recovery.php">Forgot password?</a>
                 </div>
                  <div class="field btn">
                     <div class="btn-layer"></div>
                     <input type="submit" value="Login" name="signin_submit">
                  </div>
                  <div class="signup-link">
                     Not a member? <a href="">Signup Now</a>
                  </div>
               </form>

               <form  class="signup" method="POST">
               
                  <div class="field"  >
                     <input type="email" placeholder="Email Address" name="su_email"  required>
                  </div>

                  
                  <div class="field" onclick="passcondition()"  onmouseleave="heading()" >
                     <input type="password" minlength="6" maxlength="16" placeholder="Password" name="su_pass" id="pass" title="Password must contain - A uppercase letter, a lowercase letter, a number, a special character." required>
                  </div>
                  <div id="pass_condition" style="">
                     <div>**Password must contain - A uppercase letter, a lowercase letter, a number, a special character. </div>
                  </div>


                  <div class="field">
                     <input type="password" minlength="6" maxlength="16" placeholder="Confirm Password" name="su_repass"   required>
                  </div>
                  <div class="field">
                     <input id="type" name="su_type" hidden>
                     <center>   
                     <button type="button" class="btn type" id="solo" onclick="select_solo()" style="width: 49.5%;">SOLO</button>
                     <button type="button" class="btn type" id="team" onclick="select_team()"  style="width: 49.5%;">TEAM</button>
                     </center>
                  </div>
                  <div class="field btn">
                     <div class="btn-layer"></div>
                     <input type="submit" value="Signup" name="signup_submit">
                  </div>
                  <div class="privacy_text" style="">
                  By clicking 'Signup' you agree to our <a href="soc-docs/Spell of Cipher Terms of Use.pdf">Terms of Use</a> and <a href="soc-docs/Spell of Cipher Privacy Policy.pdf">Privacy Policy</a>.</div>
               </form>
            </div>
         </div>
      </div>
      <script>
</script>


<!-- <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script> -->

<script src="js/main.js"></script>

<script type="text/javascript">
    loginpage();
</script>
   </body>
</html>
