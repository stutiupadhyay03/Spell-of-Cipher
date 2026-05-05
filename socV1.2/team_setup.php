<?php
include('dbconnect.php');
session_start();


if ($_SESSION['login_status'] != 'login'){  
  header('Location: ./login.php');
} 

$GLOBALS['change']="";
if(!empty($_GET['manage'])){
	$GLOBALS['change']="innerchange";
}



$send=false;
$mail=  strtolower($_SESSION["user_email"]);//"19bt04039@gsfcuniversity.ac.in";
$sql = "SELECT *  FROM  credentials_info where email='$mail' ";
$query = mysqli_query($GLOBALS['conn'], $sql);
while($teamid = mysqli_fetch_array($query))
                    { 
    $_GLOABAL['id']=$teamid['id'];
    $type=$teamid['type'];
    if($type=="solo" or $type=="solo_inactive" or $type=="team_member"  or $type=="under_process"){
    	header("Location:./e-400.php");
    }
  }

$sql1 = "SELECT *  FROM  profile_info where email='$mail' ";
$query1 = mysqli_query($GLOBALS['conn'], $sql1);
while($user = mysqli_fetch_array($query1))
{
    $_GLOABAL['name']=$user['name'];
    $_GLOABAL['teamname']=$user['leaderboard_name'];
    $_GLOABAL['profile_pic']=$user['userlogo'];

}  
$pass=str_pad(rand(0,999999),6, "0", STR_PAD_LEFT);

$emailerror=$emailstatus="";
if(isset($_POST['submit'])){
	$_POST['email']=strtolower($_POST['email']);
        
         $sql2 = "INSERT into credentials_info values ('".$_POST['email']."','".$pass."','under_process','".$_GLOABAL['id']."','complete')";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
        $query2 = mysqli_query($GLOBALS['conn'], $sql2);
        if($query2){
        	$send=true;
        }
        else{
        	$emailerror="This Email has already been used for registration.";
        	// echo "<script>alert('already exist');</script>";
        }
}

if(isset($_POST['remove-mem'])){
	
	$rmemail = $_POST['rmemail'];
	$sql3 = "DELETE FROM credentials_info where email='$rmemail'";
	$query3 = mysqli_query($GLOBALS['conn'], $sql3);
	if(!$query3){
		echo "<script> alert('Error SOC-101 : Team Member not removed')";
	}
	$sql4 = "DELETE FROM profile_info where email='$rmemail'";
	$query4= mysqli_query($GLOBALS['conn'],$sql4);
	if(!$query3){
		echo "<script> alert('Error SOC-101 : Team Member not removed')";
	}
}

require 'PHPMailer/src/PHPMailer.php'; 
require 'PHPMailer/src/SMTP.php'; 
require 'PHPMailer/src/Exception.php';
			
use PHPMailer\PHPMailer\PHPMailer;

if($send=="true"){
	$email = $_POST['email'];
	
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
    $mail->addAddress($email);//(19bt04039@gsfcuniversity.ac.in);
    $mail->Subject = ("New Team Member Addition | Spell of Cipher");
    $mail->Body = "<h4> Hello Spell Caster,</h4>
	You have been added under the team <i>'".$_GLOABAL['teamname']."'</i> by <i>'".$_GLOABAL['name']."'</i>. Your account has been created with a tempopary password, we request you to change your password at the earliest using the One Time Password (OTP) given below.
	As soon as you change your password and complete your profile setup, your account status will change to active.<br>
    By clicking on <a href='spellofcipher.in/set_password.php?fg_setemail=".$_POST['email']."'>SET Password<a>, you will redirected to <i>'Set Your Password'</i> Page. 
	<br>
	Your One Time Password (OTP) is : <strong>'".$pass."'.</strong> 
	<br><br>
	Please do not share this OTP with anyone for security reasons.
	<br><br>
	If you do not the know person or team who added you. Kindly ignore this mail. 
	<br><br>
	For any queries,
	<br><br>
	<strong>Contact - <br> Kalp Vaidya, Marketing & Public Relations Manager ,8200324879 <br> Vrunal Patel, Quality Assurance Specialist, 9909415227 </strong>
      <br><br>
      Regards,
      <br>
      Support Team,
      <br>
      Spell Of Cipher.";


	    
   

    if($mail->send()){
        $status = "success";
        $response = "Email is sent!";
         $emailstatus="Email has been sent";
    }
    else
    {
        $status = "failed";
        $response = "Something is wrong: <br>" . $mail->ErrorInfo;
         $emailstatus="Something is wrong in sending Email";
    }

    
    $send=false;
}

if(isset($_POST['logout'])){
    $_SESSION['login_status']="logout";
    session_destroy();

    header('Location:./login.php');
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
	<title>Team Setup</title>
	<link rel="stylesheet" type="text/css" href="css/team_setup.css">
    <!-- <link rel="stylesheet" type="text/css" href="css/mobile_view.css"> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/png" href="images/logos/SOC_TL.png"/>
</head>
<body >

	<div class="pop-up" id="pop-up">
		<center>
			<div class="pop-up-card">
				<form  method="POST">
					<div class="warning">
						<i class="fa fa-exclamation-triangle" style="font-size:50px;color:white;"></i>
					</div>
					<div class="warning-ays">
						<h4>Are you sure?</h4>
						<p>If you proceed, your team member will no longer be a part of <i><?php echo $_GLOABAL['teamname'];?>!</i></p>

						<center>
						<input type="email" name="rmemail" id="remove-email" hidden>
						<button type="submit" class='remove-mem' name="remove-mem" onclick="closePopUp()" style="width:50px;background:none;border:none;outline:none;">
							<i class="fa fa-check" style="color:green;"></i>
						</button>	
						<button type="button" onclick="closePopUp()"  style="width:50px;background:none;border:none;outline:none;">
						<i class="fa fa-close" style="color:red;"></i></button>
						</center>
					</div>
				</form>	
			</div>	
		</center>
	</div>


<?php if($GLOBALS['change']=="innerchange"){ ?>
<div class="row class" style="position: absolute;">
    <a href="profile.php" class="backbutton">
        <button type="button" style="border:none;outline:none;background:none;">
            <i class="fa fa-arrow-left"  style="font-size:22px;color: #CE2A86 ;"></i>
        </button>
    </a>   
</div> 
<?php } ?>

<div class="row class" >
    <form class="backbutton" method="POST">
        <button type="submit" name="logout" style="border:none;outline:none;background:none;">
            <i class="fa fa-sign-out signout" aria-hidden="true" style="font-size:20px;color:#262262;"></i>Sign Out
        </button>
    </form>
</div>
	
	<div class="container-fluid">
			<img src="images/profiletoons/<?php echo $_GLOABAL['profile_pic']; ?>.png" class='team'>
		
    
	<div class="main" >
		
		<!-- <div class="row">
			<p class="heading">Team Setup Form</p>
		</div> -->

		<div class="row t_name">
	  		<p class="tname"><?php echo $_GLOABAL['teamname']; ?></p>
	    </div>
	    <?php if($emailerror || $emailstatus ){ ?>
		<div class="container ">
			<center>
				<button class="error">
			<?php echo $emailerror,$emailstatus;?>
			</button>
			<?php header("Refresh:5"); ?>
			</center>
		</div>
		<?php } ?>

		<main class="row cards" id="cards">

<?php 
  $checkid=$_GLOABAL['id'];
  $sql1 = "SELECT * FROM  credentials_info where id='$checkid' ORDER BY type ASC";
  $query1 = mysqli_query($GLOBALS['conn'], $sql1);
  $rowcount=mysqli_num_rows($query1);
  
  $no_of_member=0;
  $member_type="";
  while($member = mysqli_fetch_array($query1))
  { 
    $no_of_member = $no_of_member+1;
	$member_email = $member['email'];
	$sql5="SELECT * FROM credentials_info where email='$member_email'";
	$query5 = mysqli_query($GLOBALS['conn'],$sql5);
	
	while($member_type = mysqli_fetch_array($query5))
	{
		$member_type = $member_type['type'];
	
	
		
  if ($member_type == 'team_leader'  or  $member_type == 'team_leader_incomplete')
  {	
  	if($rowcount>1){
  	$sql10 = "UPDATE credentials_info SET type='team_leader' where email='$member_email'";
  	$query10 = mysqli_query($GLOBALS['conn'], $sql10);
  	}else{
  	$sql10 = "UPDATE credentials_info SET type='team_leader_incomplete' where email='$member_email'";
  	$query10 = mysqli_query($GLOBALS['conn'], $sql10);
  	}

	$sql6="SELECT * FROM profile_info where email='$member_email'";
	$query6 = mysqli_query($GLOBALS['conn'],$sql6);
	while($member_details = mysqli_fetch_array($query6))
	{
		$member_name = $member_details['name'];
		$member_num	= $member_details['contact_no'];
	
  
     
?>
		<div class="col-lg-6 ">
			<center>			
				<div class='card'>	
				<div class="row"  style="width:100%;z-index:2">
					<div class="col-lg-4 col-md-3 col-sm-3  col-xs-3">
						<div class="new row">
							<img src="images/elements/wind.png"  class="card-img" style="border-radius:50%;"/>
	                    </div>
					</div>
				 		<div class="col-lg-8 col-md-9 col-sm-9  col-xs-9" >
               				<p class="mem_name"><?php echo $member_name;?></p>
			   				<p class="mem_title"><?php echo$member_details['title'];?></p>
			   				<p class="mail"><span style="color:rgba(18, 5, 194,0.8)"><i class="fa fa-envelope" aria-hidden="true"></i></span>&nbsp;&nbsp;<?php echo $member_email;?></p>
							<p class="pnum"><span style="color:rgba(18, 5, 194,0.8)"><i class="fa fa-phone" aria-hidden="true"></i></span>&nbsp;&nbsp;<?php echo $member_num; ?></p>  			  				
           				</div>
       				</div>
				</div>
			</center>	
		</div>   

<?php
  }
}
   
  elseif ($member_type == 'team_member')
  {
	$sql6="SELECT * FROM profile_info where email='$member_email'";
	$query6 = mysqli_query($GLOBALS['conn'],$sql6);
	while($member_details = mysqli_fetch_array($query6))
	{
		$member_name = $member_details['name'];
		$member_num	= $member_details['contact_no'];
	  ?>
	  	<div class="col-lg-6">
		
					<button type="button" onclick="openPopUp('<?php  echo $member_email; ?>')" id="remove-btn">
						<i class="fa fa-close cross" style="font-size:30px"></i>
					</button>	
							
		
			<center>			
				<div class='card'>	
				<div class="row"  style="width:100%;z-index:2">
	
					<div class="col-lg-4 col-md-3 col-sm-3  col-xs-3">
						<div class="new row" id="img-row"><img src="images/elements/<?php echo $no_of_member-2;?>.png"  class="card-img" style="border-radius:50%;"/></div></div>
				 		<div class="col-lg-8 col-md-9 col-sm-9  col-xs-9" >
			
							<p class="mem_name"><?php echo $member_name;?></p>
							<p class="mem_title"><?php echo$member_details['title'];?></p>
							<p class="mail"><span style="color:rgba(18, 5, 194,1)"><i class="fa fa-envelope" aria-hidden="true"></i></span>&nbsp;&nbsp;<?php echo $member_email;?></p>
							<p class="pnum"><span style="color:rgba(18, 5, 194,1)"><i class="fa fa-phone" aria-hidden="true"></i></span>&nbsp;&nbsp;<?php echo $member_num; ?></p>
							<br>		
           				</div>
       				</div>
				</div>
			</center>	
		</div>   
<?php
  } }
  else{
	
?>
	  	<div class="col-lg-6 ">
		  <p onclick="openPopUp('<?php  echo $member_email; ?>')" id="remove-btn">
						<i class="fa fa-close cross" style="font-size:30px"></i>
					</p>
			<center>			
				<div class='card'>	
					<div class="row"  style="width:100%;z-index:2">
				
					<div class="col-lg-4 col-md-3 col-sm-3  col-xs-3">
						<div class="new row" id="img-row"><img src="images/elements/<?php echo $no_of_member-2;?>.png"  class="card-img" style="border-radius:50%;"/></div></div>
				 		<div class="col-lg-8 col-md-9 col-sm-9  col-xs-9" style="margin-top:5%;" >
						 <i class="fa fa-exclamation-circle" aria-hidden="true" style="font-size:60px;color:#f2b61a"></i>
						 <p class="profile-pending" >Profile Setup Pending!</p>
 
						 <!-- <p class="mem_name">This team member didn't set password</p>
						 <p class="mem_title">Master of Shaolin</p> -->
			   				<p class="mail">
								   <span style="color:#f2b61a">
								   		<i class="fa fa-envelope" aria-hidden="true"></i> 
									</span ><span style="color:#6463ac"><?php echo $member['email']?></span>
							</p>  
							<br>			  				
           				</div>
       				</div>
				</div>
			</center>	
		</div>   

<?php
	
   } }
}
?>
	
	<?php if($rowcount<4){ ?>
			<div class="col-lg-6">
				<center>
				<div class='card' id='tm<?php echo $no_of_member-1;?>'  >
				<div class="row"  style="width:100%;z-index:2">
				
					<div class="col-lg-4 col-md-3 col-sm-3  col-xs-3">
						<div class="new row" id="img-row" ><img src="images/elements/<?php echo $no_of_member-1;?>.png"  class="card-img" style="border-radius:50%;"/></div></div>
				 		<div class="col-lg-8  col-md-8 col-sm-8  col-xs-8" >
					<button class = 'btn-2' id ='btn<?php echo $no_of_member-1;?>' onclick="createCard()">
					<i class="fa fa-plus-circle plus" aria-hidden="true" style="font-size: 60px;">
					</i></button>
						</div>	
					</div>
				</div>
</center>
			</div>
	<?php } ?>
		
</main>
<?php 
if($rowcount>1){?>
	  <div class="row">
	  	
		 <a href="dashboard.php" class="done" style="text-decoration: none;color: white;cursor: pointer;">
		 <center>Done
		 </center></a>
		  
	  </div>
<?php }?>
	</div>
	</div>
   <script>
   	
	  	let count = <?php echo $no_of_member-1;?>;
		  let p_count = <?php echo $no_of_member-1;?>  

	   console.log(count);
	   let button = "btn";
  	   let n = count.toString();
	   let team = "tm";



	   function createCard()
	   { 
            
		   let id_button = button.concat(n);


		   x = document.getElementById(id_button);
		   x.style.display = 'none';


		   let id_team = team.concat(n);

		   tm = document.getElementById(id_team);
		   tm.innerHTML = `
		   <div class="row"  style="width:100%;z-index:2">
					<div class="col-lg-4 col-md-3 col-sm-3  col-xs-3">
					<div class="new row"><img src="images/elements/${p_count}.png" class="card-img" style="border-radius:50%;"/></div></div>
				 		<div class="col-lg-8 col-md-8 col-sm-8  col-xs-8" >
		   <form id = 'add_mem' method='POST'> 
		   		<center>
				    <p class="addtroop" >Add to your troop!</p>
			   		<input id="addemail" type='email' name='email'  placeholder='Email Address' required><br>
					<input class="addsubmit" type='submit' name = 'submit' value ="Add Member">
				</center>
			</form>	
			</div>
			</div>	
		   `;

		   count++;
		   p_count++;
		   console.log(p_count);
		   n = count.toString();
		   id_team = team.concat(n);
		   id_button = button.concat(n); 
		   p = p_count.toString();

		   if(count<3)
		   {

	     //    cards.innerHTML = '';

		   const new_card = document.createElement('div');
		   new_card.classList.add('col-lg-6');
		   new_card.innerHTML = `
		   <center>
				<div class='card' id='${id_team}'  >
				<div class="row"  style="width:100%;z-index:2">
					<div class="col-lg-4 col-md-3 col-sm-3  col-xs-3">
					<div class="new row"><img src="images/elements/${p_count}.png"  class="card-img" style="border-radius:50%;"/></div></div>
				 		<div class="col-lg-8 col-md-8 col-sm-8  col-xs-8" >
					<button class = 'btn-2' id ='${id_button}' onclick="createCard()">
					<i class="fa fa-plus-circle plus" aria-hidden="true" style="font-size: 60px;">
					</i></button>
						</div>	
					</div>
				</div>
</center>`;
		   cards.appendChild(new_card);
		
			}  
		   

	    }

		function openPopUp(id)
		{
			x = document.getElementById('pop-up');
		    x.style.display = 'block';
			email=document.getElementById('remove-email');
			email.value=id;
		}
				function closePopUp(){
					x = document.getElementById('pop-up');
		    		x.style.display = 'none';
				}			


// 			
// })

			
// 		}

   </script>
</body>
</html>