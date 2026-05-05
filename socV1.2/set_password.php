<?php 
session_start();
if(!empty($_GET['fg_setemail'])){
  $fromlink=true;
 
}
else{
  $fromlink=false;
}

include('dbconnect.php');
$send=false;
$fromreset=false;
if(!empty($_SESSION['forforgot_email'])){
    $fromreset=true;

  }else{
    $fromreset=false;
  }

$otperr=$passerr=$passformat="";
if(isset($_POST['setpass_submit']))
{ 
   
    if ($_POST['fg_pass']!=$_POST['fg_repass'])
    { 
        $passerr="Password and Confirm password must be same";
        $samepass=false;
    }else
    {
        $samepass=true;
    }

    if($samepass=="true")
    {
      $mail=$_POST['fg_setemail'];
      $sql1 = "SELECT  pass FROM  credentials_info where email='$mail' ";
     
      $query1 = mysqli_query($GLOBALS['conn'], $sql1);
      
            
      if($query1)
      {
        while($page = mysqli_fetch_array($query1))
        {
          if($_POST['otp']==$page['pass'])
          {

            $err = "";
            $password = $_POST['fg_pass'];
            $length="false";
            $len=strlen($password);
            if($len<=16 and $len >=6){$length="true";}
            $number = preg_match('@[0-9]@', $password);
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $specialChars = preg_match("/[\'^£$%&*()}{@#~?><>,|=_+¬-]/", $password);

            if(!$number || !$uppercase || !$lowercase || !$specialChars || $length=="false")
            {
              $passformat="Password is not in a format";
                $err = "Password must be at least 6 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
                $passerror="false";
                // echo "<script>alert('".$err."')</script>";
            } else
            {
            
              $newpass=md5($_POST['fg_pass']);
              $sql3 = "UPDATE credentials_info set  pass='$newpass' where email='$mail'";
              $query3 = mysqli_query($GLOBALS['conn'], $sql3);
              $_SESSION['password_success']="done";
              $_SESSION['forforgot_email']='';
              header('Location: ./login.php');
            }  
          }else
          { 
              $otperr="The OTP entered is incorrect.";
          }
          
          
         
        }
      }else
      {
        echo "<script>alert('EMAIL not registerd')</script>";
      }
    }
}



?>


<!DOCTYPE html>
<!-- Created By CodingNepal -->
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
      <title>Set Password | SOC</title>
      
      <link rel="stylesheet" type="text/css" href="css/login.css">
      <link rel="stylesheet" type="text/css" href="css/mobile_view.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="shortcut icon" href="images/logos/SOC_TL.png" type="image/x-icon">


<style type="text/css">
    #forgot{
        display: none;
    }
    #login_signup{
        display: block;
    }
</style>
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
    

     <div class="container-fluid wrapper" id="login_signup" style="margin-top: 8%;">

        
            
          <div class=" title-text" id="heading" style="display: flex;">
            <div class="title login">
               SET YOUR PASSWORD
            </div>
         </div>
        <!--  <div class="title-text" id="pass_condition" style="display: none">
              <center> Atleast ONE UPERCASE,ONE LOWERCASE and ONE SPECIAL CHARATER</center> 
         </div> -->
        
         <div  class="error" >
          <center> <?php echo $passerr,$otperr,$passformat; ?></center>
         </div>
         <div class="form-container">
            <div class="form-inner" style="display: block;">
               <form  method="POST" >
                <?php
                if($fromreset=="true"){

                   echo "<div class='field'>
                     <input type='email' placeholder='". $_SESSION['forforgot_email']."' name='fg_setemail' value='". $_SESSION['forforgot_email']."' readonly>
                  </div>";
                 

              }elseif($fromlink=="true"){
                    echo "<div class='field'>
                     <input type='email' placeholder='". $_GET['fg_setemail']."' name='fg_setemail' value='". $_GET['fg_setemail']."' readonly>
                  </div>";
              }
              else{
                 echo "<div class='field'>
                     <input type='email' placeholder='Email Address'  name='fg_setemail' required>
                  </div>";

              }
                ?>
                 
                  <div class="field">
                     <input type="tel" placeholder="OTP" name="otp"  required>
                  </div>
                  <div class="field"  onclick="passcondition()"  onmouseleave="heading()" >
                     <input type="password" placeholder="Password" name="fg_pass"  required>
                  </div>
                   <div id="pass_condition" >
                     <div>**Password must contain - A uppercase letter, a lowercase letter, a number, a special character. </div>
                  </div>

                  <div class="field">
                     <input type="password" placeholder="Confirm Password" name="fg_repass"  required>
                  </div>
                   <div class="field btn">
                     <div class="btn-layer"></div>
                     <input type="submit" value="SET MY PASSWORD" name="setpass_submit">
                  </div>
                </form>
               
            </div>
         </div>
      </div>
<script src="js/main.js"></script>
</body>
</html>