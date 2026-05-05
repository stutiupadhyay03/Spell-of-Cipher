<?php
session_start();

include('dbconnect.php');
$GLOBALS['change']="";
if(!empty($_GET['user']) and !empty($_GET['position'])){
  $mail=$_SESSION["user_email"]=$_GET['user'];
  $type=$_SESSION["user_type"]=$_GET['position'];
  $_SESSION['login_status'] = 'login';
}
elseif(!empty($_GET['player']) and !empty($_GET['position']))
    {

    $GLOBALS['change']="innerchange";
    $mail=$_SESSION["user_email"]=$_GET['player'];
    $type=$_SESSION["user_type"]=$_GET['position'];
    $editsql = "SELECT * FROM profile_info  where email='$mail'";
    $editquery = mysqli_query($GLOBALS['conn'], $editsql);
    while($edit = mysqli_fetch_array($editquery))
    { 
        $GLOBALS['userlogo']=$edit['userlogo'];
        $GLOBALS['name']=$edit['name'];
        $GLOBALS['contact_no']=$edit['contact_no'];
        $GLOBALS['university']=$edit['university'];
        $GLOBALS['study_year']=$edit['study_year'];
        $GLOBALS['gender']=$edit['gender'];
        $GLOBALS['age']=$edit['age'];
        $GLOBALS['leaderboard_name']=$edit['leaderboard_name'];
        $GLOBALS['title']=$edit['title'];
        $GLOBALS['stream']=$edit['stream'];
    }
    
}
else{
    $mail=$_SESSION["user_email"];
    $type=$_SESSION["user_type"];
}


if ($_SESSION['login_status'] != 'login'){  
  header('Location: ./login.php');
} 


if($type=="team_leader" or $type="team_leader_inactive"  or $type=="team_leader_incomplete"){
    $updatedetail = "SELECT *  FROM  credentials_info where email='$mail' ";
    $updatedetailquery = mysqli_query($GLOBALS['conn'], $updatedetail);
    while($updatedetails=mysqli_fetch_array($updatedetailquery)){
        $leaderid=$updatedetails['id'];
    }
    $updateall="true";
    

}


$GLOBALS['team_member']="no";

 // for check user in come from login or dashboard method is flag method=========

$nameErr=$universityErr=$gendererr="";

// and type='team_member' or type='under_process'
// type<>'team_leader_inactive' and type<>'solo_inactive' and type<>'solo' and type<>'team_leader' and type<>'team_leader_incomplete'

// chek for team member and prefill leaderboard_name and userlogo as per leader
$sql2 = "SELECT * FROM credentials_info  where email='$mail' and (type='team_member' or type='under_process')";
$query2 = mysqli_query($GLOBALS['conn'], $sql2);
$count=mysqli_num_rows($query2);
if($count>0)
{
    $GLOBALS['team_member']="yes";
    while($member = mysqli_fetch_array($query2))
    { 
        $id=$member['id'];
      
        $sql = "SELECT email FROM credentials_info  where id='$id' and (type='team_leader' or type='team_leader_incomplete' or type='team_leader_inactive')";
        $query = mysqli_query($GLOBALS['conn'], $sql);
        if($query){

            while($mail = mysqli_fetch_array($query))
            {
                $leadermail=$mail['email'];
                $sql4 = "SELECT userlogo,leaderboard_name FROM profile_info  where email='$leadermail'";
                $query4 = mysqli_query($GLOBALS['conn'], $sql4);
                if($query4)
                {
                  while($fixed = mysqli_fetch_array($query4))
                {
                    $GLOBALS['userlogo']=$fixed['userlogo'];
                    $GLOBALS['leaderboard_name']=$fixed['leaderboard_name'];
                }
                }
            }
        }
       
    }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if(isset($_POST['prof_submit']))
{


    if (!preg_match("/^[a-zA-Z ]*$/",$_POST['name'])) {
      $nameErr = "Only letters and white space allowed in name";

    }else{
        $_POST['name'] = test_input($_POST['name']);
    }

    if (!preg_match("/^[a-zA-Z ]*$/",$_POST['univ'])) {
        $universityErr = "Only letters and white space allowed in university";
    

    }else{
        $_POST['univ'] = test_input($_POST['univ']);
    }

    if (empty($_POST['gender']))
    {
        $gendererr="Gender is not selected";
    }

    $mail=$_SESSION["user_email"];
   
if(empty($nameErr) && empty($universityErr) && empty($gendererr)){
    $sql1 = "SELECT *  FROM  profile_info where email='$mail' ";
    $query1 = mysqli_query($GLOBALS['conn'], $sql1);
    $data=mysqli_fetch_array($query1);
    if(empty($data))
    {
        if($updateall=="true"){
        $emailsql = "SELECT *  FROM  credentials_info where id='$leaderid' ";
        $emailquery = mysqli_query($GLOBALS['conn'], $emailsql);
        while($emaildetails=mysqli_fetch_array($emailquery)){
            $updateemail=$emaildetails['email'];
            $donedtail = "UPDATE  profile_info SET userlogo='".$_POST['userlogo']."',leaderboard_name='".$_POST['leaderboard_name']."' where email='$updateemail'";
            $donequery = mysqli_query($GLOBALS['conn'], $donedetail);
                }
        }
        $sql = "INSERT into profile_info values ('".$_POST['userlogo']."','".$_POST['name']."','".$_POST['contact']."','".$_POST['univ']."','".$_POST['yos']."','".$_POST['gender']."','".$_POST['Age']."','".$_POST['user_email']."','".$_POST['leaderboard_name']."','".$_POST['title']."','".$_POST['stream']."','null','null')";

    }else 
    {
        if($updateall=="true"){
        $emailsql = "SELECT *  FROM  credentials_info where id='$leaderid' ";
        $emailquery = mysqli_query($GLOBALS['conn'], $emailsql);
        while($emaildetails=mysqli_fetch_array($emailquery)){
            $updateemail=$emaildetails['email'];
            $donedetail = "UPDATE  profile_info SET userlogo='".$_POST['userlogo']."',leaderboard_name='".$_POST['leaderboard_name']."' where email='$updateemail'";
            $donequery = mysqli_query($GLOBALS['conn'], $donedetail);
                }
        }
        $sql = "UPDATE  profile_info SET userlogo='".$_POST['userlogo']."',name='".$_POST['name']."',contact_no='".$_POST['contact']."',university='".$_POST['univ']."',study_year='".$_POST['yos']."',gender='".$_POST['gender']."',age='".$_POST['Age']."',email='".$_POST['user_email']."',leaderboard_name='".$_POST['leaderboard_name']."',title='".$_POST['title']."',stream='".$_POST['stream']."' where email='$mail'";
    
    }
    $query = mysqli_query($GLOBALS['conn'], $sql);

    if($query) 
    {
        if($GLOBALS['team_member']=='yes'){
        $sql3 = "UPDATE credentials_info set  type='team_member' where email='$mail'";
        $query3 = mysqli_query($GLOBALS['conn'], $sql3);
        }
        
        if($_SESSION["user_type"]=='solo_inactive'){
        $sql3 = "UPDATE credentials_info set  type='solo' where email='$mail'";
        $query3 = mysqli_query($GLOBALS['conn'], $sql3);
        }
        if($_SESSION["user_type"]=='team_leader_inactive'){
        $sql3 = "UPDATE credentials_info set  type='team_leader_incomplete' where email='$mail'";
        $query3 = mysqli_query($GLOBALS['conn'], $sql3);
        }
        // echo "<script>alert('Sign UP Successfully '); </script>";
        if($GLOBALS['change']=="innerchange")
        {
            header('Location: ./profile.php');
        }elseif($_SESSION["user_type"]=="team_leader_inactive" and  $GLOBALS['change']!="innerchange")
        {
            header('Location: ./team_setup.php');
        
        }elseif($_SESSION["user_type"]=="team_leader" and  $GLOBALS['change']!="innerchange")
        {
            header('Location: ./profile.php');
        
        }elseif($_SESSION["user_type"]=="team_leader_incomplete")
        {
            header('Location: ./team_setup.php');
        
        }else{
            header('Location: ./dashboard.php');

        }
    } else
    {
            // echo "<script>alert('SOMthing went wrong!');</script>";
    }
  }
}

if(isset($_POST['logout'])){
    $_SESSION['login_status']="logout";
    session_destroy();

    header('Location:./login.php');
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Setup</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/profile_setup.css">
       <!-- <link rel="stylesheet" type="text/css" href="css/mobile_view.css"> -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
       <link rel="shortcut icon" type="image/png" href="images/logos/SOC_TL.png"/>

</head>
<body>
    <?php if($nameErr || $universityErr || $gendererr){ ?>
        <div class="pop container">
            <center>
            <button><?php echo $nameErr,$universityErr,$gendererr;?></button>
            <?php header("Refresh:3"); ?>
            </center>
        </div>
        <?php } ?>
<?php if($GLOBALS['change']=="innerchange"){ ?>
    <div class="row class" style="position: absolute;">
            <a href="profile.php" class="backbutton">
                <button type="button" style="border:none;outline:none;background:none;">
                    <i class="fa fa-arrow-left" style="font-size:22px;color: #CE2A86 ;"></i>
                </button>
            </a>
        </div>

<?php } ?>

<div class="row class" >
    <form class="backbutton" method="POST">
        <button type="submit" name="logout" style="border:none;outline:none;background:none;">
            <i class="fa fa-sign-out" aria-hidden="true" style="font-size:15px;color:#262262;">Sign Out</i>
        </button>
    </form>
</div>

<div class="container-fluid containr">
    <form method="POST">
    <div class=row>
        <div class="col-lg-5 col-md-12 col-xs-12 col-sm-12  content">
            <div class="row">
                <div class="col-lg-3"></div>        
                <div class="col-lg-6">
<?php if( $GLOBALS['team_member']=="yes"){ ?>                
            <input type="text" id="memberuserlogo" name='userlogo' value="<?php  echo $GLOBALS['userlogo'];?>" readonly hidden>
             <div class="row pics profile-pic">
             <center>
            <img src="<?php  echo "images/profiletoons/".$GLOBALS['userlogo'].".png";?>"  alt="Avatar" class='profile-pic  img col-lg-10 col-md-4 col-xs-4 col-sm-4'>
            <p style="font-size: 15px;margin-top:8%;">Selected by Leader</p>
             <center>
        </div>
 <?php }else{ ?>   
                        
            <input type="text" id="userlogo" name='userlogo' value="<?php if($GLOBALS['change']=='innerchange'){echo $GLOBALS['userlogo'];}else{
                echo 'avatoon1';
            }?>" hidden>
        <div class="row pics profile-pic">
            <center>
            <img src="images/profiletoons/<?php if($GLOBALS['change']=='innerchange'){echo $GLOBALS['userlogo'];}else{
                echo 'avatoon1';
            }?>.png" id="selected" alt="Avatar" class='profile-pic img col-lg-10 col-md-4 col-xs-4 col-sm-4'>
            
            <p style="font-size: 15px;margin-top:8%;">Choose Your Profile Photo</p>
            </center>
        </div>
<?php } ?>                      
             
         </div>
            </div>
             <div class="row pics">
                <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3 profile-pics" >
                 <img src="images/profiletoons/avatoon1.png" id="avatoon1" alt="Avatar" class='profile-pics img'  onclick="profile_pics(this.id)">
                </div>
                <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3  profile-pics">
                 <img src="images/profiletoons/avatoon2.png" id="avatoon2" alt="Avatar" class='profile-pics img'  onclick="profile_pics(this.id)">
                </div>
                <div class="col-lg-3  col-md-3 col-xs-3 col-sm-3  profile-pics"> 
                 <img src="images/profiletoons/avatoon3.png" id="avatoon3" alt="Avatar" class='profile-pics img'  onclick="profile_pics(this.id)">
                </div>
                <div class="col-lg-3  col-md-3 col-xs-3 col-sm-3  profile-pics"> 
                 <img src="images/profiletoons/avatoon4.png" id="avatoon4" alt="Avatar" class='profile-pics img'  onclick="profile_pics(this.id)">
                </div>
                <div class="col-lg-3  col-md-3 col-xs-3 col-sm-3 profile-pics">
                 <img src="images/profiletoons/avatoon5.png" id="avatoon5" alt="Avatar" class='profile-pics img'  onclick="profile_pics(this.id)">
                </div>
                <div class="col-lg-3  col-md-3 col-xs-3 col-sm-3  profile-pics">
                 <img src="images/profiletoons/avatoon6.png" id="avatoon6" alt="Avatar" class='profile-pics img'  onclick="profile_pics(this.id)">
                </div>
                <div class="col-lg-3  col-md-3 col-xs-3 col-sm-3 profile-pics">
                 <img src="images/profiletoons/avatoon7.png" id="avatoon7" alt="Avatar" class='profile-pics img'  onclick="profile_pics(this.id)">
                </div>
                <div class="col-lg-3  col-md-3 col-xs-3 col-sm-3  profile-pics">
                 <img src="images/profiletoons/avatoon8.png" id="avatoon8" alt="Avatar" class='profile-pics img'  onclick="profile_pics(this.id)">
                </div>
               
             </div>
             
        </div>
        <div class="col-lg-7 content1">
            <center><div class="title ">Profile Setup Form</div></center>
           
                <div class= "user-details">
                    <div class="row">
                        <div class="col-lg-6 input-box">
                            <span class="details">Full Name</span>
                            <input type="text" name='name' placeholder="Enter your name"  value="<?php if($GLOBALS['change']=='innerchange'){echo $GLOBALS['name'];}?>" required>
                        </div>
                        
    <?php if( $GLOBALS['team_member']=="yes"){ ?>                
                        <div class="col-lg-6  input-box">
                            <span class="details">Username/Team Name</span>
                            <input type="text" name='leaderboard_name' placeholder="<?php echo $GLOBALS['leaderboard_name']; ?>" value="<?php echo $GLOBALS['leaderboard_name']; ?>"  title="Already Set By Team Leader" style="cursor:none " readonly>
                        </div>
    <?php }else{ ?>   
             
                     <div class="col-lg-6  input-box">
                    <span class="details">Username/Team Name</span>
                    <input type="text" name='leaderboard_name' placeholder="Enter your username" value="<?php
                     if($GLOBALS['change']=='innerchange'){echo $GLOBALS['leaderboard_name'];}?>" required>
                        </div>
     <?php } ?>                                        
                    </div>
                    <div class="row">
                        <div class="col-lg-6 input-box">
                            <span class="details">Email</span>
                            <input type="email" name='user_email' value="<?php echo $_SESSION['user_email']; ?>" readonly >
                        </div>
                        <div class="col-lg-6 input-box">
                            <span class="details">Phone Number</span>
                            <input type="tel" name='contact' placeholder="Enter your number" pattern="[0-9]{10}"   value="<?php if($GLOBALS['change']=='innerchange'){echo $GLOBALS['contact_no'];}?>"  required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 input-box">
                            <span class="details">University / School</span>
                            <input type="text" name='univ' placeholder="University/School"  value="<?php if($GLOBALS['change']=='innerchange'){echo $GLOBALS['university'];}?>"  required>
                        </div >
                        <div class="col-lg-6 input-box">
                            <span class="details">Year Of Study</span>
                            <select name="yos" id="year" class='year' required>
                                <option value="1st year">1st year</option>
                                <option value="2nd year">2nd year</option>
                                <option value="3rd year">3rd year</option>
                                <option value="4thyear">4th year</option>
                                <option value="other">other</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 input-box">
                            <span class="details" >Title</span>
                            <select name="title" id="title" class='year' required>
                                <option value="Warlock">Warlock</option>
                                <option value="Dark Lord">Dark Lord</option>
                                <option value="Clara">Clara</option>
                                <option value="Supreme Sorcerer">Supreme Sorcerer</option>
                                <option value="Beast Master">Beast Master</option>
                                <option value="Divine Enchanter">Divine Enchanter</option>
                                <option value="Agatha">Agatha</option>
                                <option value="Zeus">Zeus</option>
                            </select>
                        </div>
                        <div class="col-lg-6 input-box">
                            <span class="details">Stream</span>
                            <select name="stream" id="stream" class='year' required>
                                <option value="B.Tech Computer Science & Engg.">B.Tech Computer Science & Engg</option>
                                <option value="B.Tech Computer Engg.">B.Tech Computer Engg</option>
                                <option value="B.Tech Information Technology">B.Tech Information Technology</option>
                                <option value="B.Tech Chemical Engg.">B.Tech Chemical Engg</option>
                                <option value="B.Tech Mechanical Engg.">B.Tech Mechanical Engg</option>
                                <option value="B.Tech Electrical Engg.">B.Tech Electrical Engg</option>
                                <option value="Bachelors of Computer Applications">Bachelors of Computer Applications</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                     <div class="row" style="margin-top: 2%;">

                        <input type="text" id = 'gender' name="gender" hidden>
                        <span class="col-sm-2 g-details">Gender</span>

                        <div class='col-lg-2 col-sm-3 col-xs-5 images input-box'>
                            <img src="images/profiletoons/img_avatar.png" alt="Avatar" class="avatar" id="male"  onclick="select_male()" value="Male">
                        </div>
                        <div class="col-lg-2 col-sm-3 col-xs-5 images input-box">
                            <img src="images/profiletoons/img_avatar2.png" alt="Avatar" class="avatar" id="female" onclick="select_female()" value="Female">
                        </div>
                        <div class="col-lg-6 col-sm-12 col-xs-12 input-box1 input-box">
                            <span class="col-lg-3 details" style="display:inline;">Age</span>
                            <input   type="number" class='co'name="Age" placeholder="12" min="12" max="30" step="1" value="<?php
                     if($GLOBALS['change']=='innerchange'){echo $GLOBALS['age'];}?>" required>
                        </div>
                    </div>
                </div>
              
                <div class="row">
                    <div class="col-lg-12 button">
                        <input type="submit" value="Save and Next" name="prof_submit">
                    </div>
                </div>
           
        </div>
    </div>
    </form>
</div>
<script src="js/profile_setup.js"></script>

</body>
</html>