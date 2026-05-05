<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

if(isset($_POST)){
	$response = $_POST;
	
	/* It is very important to calculate the hash using the returned value and compare it against the hash that was sent while payment request, to make sure the response is legitimate */
	$salt = "822e882a016e7b50c3a67c5dfd16861e62a9d80e"; /* put your salt provided by aggrepay here */
	if(isset($salt) && !empty($salt)){
		$response['calculated_hash']=hashCalculate($salt, $response);
		$response['valid_hash'] = ($response['hash']==$response['calculated_hash'])?'Yes':'No';
	} else {
		$response['valid_hash']='Set your salt in return_page.php to do a hash check on receiving response from Aggrepay';
	}
}

function hashCalculate($salt,$input){
	/* Remove hash key if it is present */
	unset($input['hash']);
	/*Sort the array before hashing*/
	ksort($input);
	
	/*first value of hash data will be salt*/
	$hash_data = $salt;
	
	/*Create a | (pipe) separated string of all the $input values which are available in $hash_columns*/
	foreach ($input as $key=>$value) {
		if (strlen($value) > 0) {
			$hash_data .= '|' . $value;
		}
	}

	$hash = null;
	if (strlen($hash_data) > 0) {
		$hash = strtoupper(hash("sha512", $hash_data));
	}
		
	return $hash;
}
include('dbconnect.php');
$email=$response['email'];
$response['response_message'];
if($response['response_message']=="Transaction successful"){
	echo $id=$response['order_id'];
	$sql = "SELECT * FROM credentials_info  where email='$email'";
	$query = mysqli_query($GLOBALS['conn'], $sql);
	$rowcount=mysqli_num_rows($query);
	if($rowcount>0){
		while($member = mysqli_fetch_array($query))
	    { 
	    	echo $email=$member['email'];
	    	$position=$member['type'];
	    	$sql1 = "UPDATE credentials_info SET paisa='complete' where email='$email'";
	  		$query1 = mysqli_query($GLOBALS['conn'], $sql1);
	  		echo $path='./profile_setup.php?user='.$email.'&position='.$position;
	  		 header("Location:$path");
	    }
	}
	else{
	header("Location:./e-400.php");
	}

	
}
else {
	$newid="SOC-".str_pad(uniqid(),10);
	$failsql = "UPDATE credentials_info SET paisa='$newid' where email='$email'";
	$failquery = mysqli_query($GLOBALS['conn'], $failsql);
	$send="true";
	
}
require 'PHPMailer/src/PHPMailer.php'; 
require 'PHPMailer/src/SMTP.php'; 
require 'PHPMailer/src/Exception.php';
			
use PHPMailer\PHPMailer\PHPMailer; 

if($send=="true"){

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
    $mail->Subject = ("Payment Link | Spell of Cipher");
    $mail->Body = "<h4>Hello Spell Caster,</h4>
      This is your new payment  link for <strong> Spell of Cipher</strong>. Please 
      <a href='https://spellofcipher.in/paymentrequest.php?participant=".$email."&rank=".$newid."'>Click Here</a>  to activate your account and complete the payment procedure. You have received this mail as your previous transaction could not be completed.If you want to continue with your participation, please pay from the above mentioned link. If already paid, please ignore this mail. <br><br>
      For any queries,
      <br><br>

      <strong>Contact - <br> Kalp Vaidya, Director of Marketing & Public Relations,8200324879 <br> Vrunal Patel, Quality Assurance Specialist, 9909415227 </strong>
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

    // exit();
    $send=false;
   	header("Location:./e-400.php");
}

?>
<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">

</HEAD>
<BODY LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0 bgcolor="#ECF1F7">


</body>
</html>



