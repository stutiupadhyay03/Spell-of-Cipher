<?php
session_start();
include('dbconnect.php');
if ($_SESSION['login_status'] != 'login'){  
  header('Location: ./login.php');
} 

$mail = $_SESSION["user_email"]; 
$type=$_SESSION["user_type"];
$team_members=array();

$sql = "SELECT  * FROM  profile_info where email='$mail' ";
$query = mysqli_query($GLOBALS['conn'], $sql);
while ($user = mysqli_fetch_array($query))
 {
    $u_univ = $user['university'] ;
    $u_num = $user['contact_no'];
    $u_name = $user['name'];   
    $u_age = $user['age'];
    $u_title=$user['title'];
    $username = $user['leaderboard_name'];
    $u_profile = $user['userlogo'];
    $u_hw_score = $user['hw_score'];
    $u_rt_score= $user['rt_score'];
    $u_stream= $user['stream']; 


        
    $sql4 = "SELECT  * FROM  credentials_info where email='$mail' ";
    $query4 = mysqli_query($GLOBALS['conn'], $sql4);
    while ($u = mysqli_fetch_array($query4))
    {
        $id=$u['id'];
       $GLOBALS['acc_type'] = $u['type'];
    }          
        


}


if (isset($_POST['submit'])) {
  $_SESSION['login_status'] = 'Logout';
  header('Location: ./index.php');
}

if(isset($_POST['passsubmit'])) {
  $passleadremail=$_POST['passemail'];
  $passsql = "SELECT  type FROM  credentials_info where email='$passleadremail' ";
    $passquery = @mysqli_query($GLOBALS['conn'], $passsql);
    $no=@mysqli_num_rows($passquery);
    if($no>0){
    while($passtype = @mysqli_fetch_array($passquery))
    {
        $membertype=$passtype['type'];
       if($membertype=="team_member"){
            $passsql = "UPDATE  credentials_info set type='team_leader' where email='$passleadremail' ";
            $passquery = mysqli_query($GLOBALS['conn'], $passsql);
            $passleadersql = "UPDATE  credentials_info set type='team_member' where email='$mail' ";
            $passleaderquery = mysqli_query($GLOBALS['conn'], $passleadersql);
       }
       if($membertype=="under_process"){
            $passsql = "UPDATE  credentials_info set type='team_leader_inactive' where email='$passleadremail' ";
            $passquery = mysqli_query($GLOBALS['conn'], $passsql);
            $passleadersql = "UPDATE  credentials_info set type='team_member' where email='$mail' ";
            $passleaderquery = mysqli_query($GLOBALS['conn'], $passleadersql);
       }
    } 
}
    header("Refresh:0");
}
?>


<!DOCTYPE html>
<html>

<head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">


    
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/profile.css">
	   <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   
    <link rel="stylesheet" href="sweetalert2.min.css">
<link rel="shortcut icon" type="image/png" href="images/logos/SOC_TL.png"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title><?php echo $GLOBALS['u_name']."'s";?> Profile</title>
   

</head>
 <body id="body-pd">
    
    <?php include('nav.php');?>

    <header>
        <center>
		
		 <div class="main-content" style="margin-top:150px;margin-bottom:2%;">
            <div class="container-fluid mt--7">
                <div class="row">
            <?php  if($type!="solo") {   ?>
           <p class="profile-heading" style="">Team Profile</p>
       <?php } ?>
            <?php
                  $id = $GLOBALS['id'];
                  $sql2 = "SELECT * FROM credentials_info where id='$id'";
                  $query2= mysqli_query($GLOBALS['conn'],$sql2);
                  while($user_details=mysqli_fetch_array($query2))
                  {
                    $mem_mail = $user_details['email'];
                    // echo $mem_mail; 
                  if ($user_details['email']!= $mail)
                   {
                    $sql3 = "SELECT * FROM profile_info where email='$mem_mail'";
                    $query3 = mysqli_query($GLOBALS['conn'],$sql3);
                    while($team_mem=mysqli_fetch_array($query3))
                    {          
                    array_push($team_members,$team_mem['email']);                                  
                    $name = $team_mem['name'];
                    // echo $name;
                    $univ = $team_mem['university'];    
                    $age = $team_mem['age'];
                    $num = $team_mem['contact_no']
                    ?>
               
					<div class="main-card col-xl-4 col-lg-3 col-md-8 col-sm-6 col-xs-6 order-xl-2 mb-5 mb-xl-0 offset-md-2 offset-lg-0" style="">
                        <div class="card card-profile shadow">
                            <div class="row justify-content-center">
                                <div class="col-lg-3 order-lg-2">
                                    <div class="card-profile-image">
                                        <a href="#">
                                            <img src="images/profiletoons/<?php echo $team_mem['userlogo']; ?>.png" class="rounded-circle">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                            </div>
                            <div class="card-body pt-0 pt-md-4">
                                <div class="row">
                                    <div class="col">
                                        <div class="card-profile-stats d-flex justify-content-center mt-md-5 ">
                                            <div >
                                                <span class="heading"><?php echo $team_mem['hw_score'];?></span>
                                                <span class="description">Hello World Score</span>
                                            </div>
                                            <div>
                                                <span class="heading"><?php echo $team_mem['rt_score'];?></span>
                                               <span class="description">Runtime Terror Score</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h3>
                                    <?php echo $team_mem['name'] ;?> <span class="font-weight-light">, <?php echo $team_mem['age'];?></span>
                                    </h3>
                                    <div class="h5 font-weight-300" id="title_name" style="font-size: 30px;">
                                       <?php echo $team_mem['title'];?>
                                    </div>
                                    <div class="h5 mt-4">
                                        <i class="ni business_briefcase-24 mr-2"></i><?php echo $team_mem['stream'].",".$team_mem['study_year'];?>
                                    </div>
                                    <div>
                                        <i class="ni education_hat mr-2" style="color:rgba(219, 83, 215,1.0);font-size: 25px;"><?php echo $team_mem['university'];?></i>
                                    </div>
                                    <hr class="my-4" style="height:2px;border-width:2;color:#6463ac;background-color:#6463ac;">
                                    <div style="letter-spacing:1px;color:#00a3bd">
                                        <?php echo $team_mem['email']."<br>".$team_mem['contact_no'];?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<?php }}} ?>
</div></div></div>
        </center>
         <?php  if($type!="solo") {   ?>
        <center><p class="your-heading" style="">Your Profile</p></center>
         <?php } ?>
        <div class="main-content" >
            <div class="container-fluid mt--7">
                <div class="row">
                    <div class="col-xl-4 col-lg-3 col-md-8 col-sm-6 col-xs-6 order-xl-2 mb-5 mb-xl-0 offset-md-2 offset-lg-0" style="margin-top:55px;">
                        <div class="card card-profile shadow">
                            <div class="row justify-content-center">
                                <div class="col-lg-3 order-lg-2">
                                    <div class="card-profile-image">
                                        <a href="#">
                                            <img src="images/profiletoons/<?php echo $u_profile;?>.png" class="rounded-circle">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                               
                            </div>
                            <div class="card-body pt-0 pt-md-4">
                                <div class="row">
                                    <div class="col">
                                        <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                            <div>
                                                <span class="heading"><?php echo  $u_hw_score; ?></span>
                                                <span class="description">Hello World Score</span>
                                            </div>                                     <div>
                                                <span class="heading"><?php echo  $u_rt_score; ?></span>
                                                <span class="description">Runtime Terror Score</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h3>
                                    <?php echo $u_name;?> <span class="font-weight-light">, <?php echo $u_age;?></span>
                                    </h3>
                                    <div class="h5 font-weight-300" id="title_name" style="font-size: 30px;">
                                        <?php echo $u_title;?>
                                    </div>
                                    <div class="h5 mt-4">
                                        <i class="ni business_briefcase-24 mr-2"></i>Computer and Science Engg, 3rd Year
                                    </div>
                                    <div>
                                        <i class="ni education_hat mr-2" style="color:rgba(219, 83, 215,1.0);font-size: 25px;"><?php echo $GLOBALS['u_univ'];?></i>
                                    </div>
                                    <hr class="my-4" style="height:2px;border-width:2;color:#6463ac;background-color:#6463ac;">
                                    <div style="letter-spacing:1px;color:#00a3bd">
                                        <?php echo $GLOBALS['mail']."<br>".$GLOBALS['u_num'];?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- col-md-8 col-sm-6 col-xs-6 order-xl-2 mb-5 mb-xl-0  -->
                    <div class="col-xl-8  col-lg-8 col-md-12 col-sm-8 col-xs-8 order-xl-1 offset-md-0 offset-lg-0" style="margin-top: 32px;margin-bottom: 20%;">
                        <div class="card bg-secondary shadow">
                            <div class="card-header bg-white border-0">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">My Account</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                        <a href="profile_setup.php?player=<?php echo $mail;?>&position=<?php echo $type;?>" class="btn btn-md btn-primary">Edit</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form>
                                    <h6 class="heading-small text-muted mb-4">User information</h6>
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group focused">
                                                    <label class="form-control-label"
                                                        for="input-username">Username / Team Name</label>
                                                    <input id="input-username"
                                                        class="form-control form-control-alternative" placeholder="M.S.D" value="<?php echo $username?>" readonly>
                                                        
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="input-email">Account Type
                                                        </label>
                                                        <?php 
                                                            if ($GLOBALS['acc_type'] == 'team_leader')
                                                                {
                                                        ?>

                                            <a href="team_setup.php?manage=yes" class="btn btn-sm btn-primary delpass" style="margin-left:10%">Manage Team</a>
                                            <?php } ?>
                            
                                    

                                                    <input type="text" id="input-email"
                                                        class="form-control form-control-alternative"
                                                        placeholder="" value=<?php echo $GLOBALS['acc_type']; ?> readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="input-first-name">Full Name
                                                        </label>
                                                    <input type="text" id="input-first-name"
                                                        class="form-control form-control-alternative"
                                                    placeholder="First name" value="<?php echo $GLOBALS['u_name'];?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="input-last-name">Title</label>
                                                    <input type="text" id="input-last-name"
                                                        class="form-control form-control-alternative"
                                                        placeholder="Last name" value="<?php echo $GLOBALS['u_title'];?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-4" style="height:2px;border-width:2;color:#6463ac;background-color:#6463ac;">
                                    <!-- Description -->
                                    <h6 class="heading-small text-muted mb-4">Academic Information</h6>

                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="input-city">University</label>
                                                    <input type="email" id="input-city"
                                                        class="form-control form-control-alternative" placeholder="coder100@spellofcipher.in"
                                                        value="<?php echo $GLOBALS['u_univ'];?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="input-city">Course / Program</label>
                                                    <input type="email" id="input-city"
                                                        class="form-control form-control-alternative" placeholder="coder100@spellofcipher.in"
                                                        value="<?php echo $GLOBALS['u_stream'];?>" readonly>
                                                </div>
                                            </div>
                                         </div>
                                    </div>   
                                            

                                    <hr class="my-4" style="height:2px;border-width:2;color:#6463ac;background-color:#6463ac;">
                                    <!-- Address -->
                                    <h6 class="heading-small text-muted mb-4">Contact information</h6>
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="input-city">Email Address</label>
                                                    <input type="email" id="input-city"
                                                        class="form-control form-control-alternative" placeholder="coder100@spellofcipher.in"
                                                        value="<?php echo $GLOBALS['mail'];?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group focused">
                                                    <label class="form-control-label" for="input-country">Contact Number
                                                        </label>
                                                    <input type="number" id="input-postal-code"
                                                        style ="letter-spacing: 1px;"class="form-control form-control-alternative"
                                                        placeholder="Eg. 0226400895" value="<?php echo $GLOBALS['u_num'] ;?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4" style="height:2px;border-width:2;color:#6463ac;background-color:#6463ac;">
                                    <!-- Description -->
                                    <h6 class="heading-small text-muted mb-4">Manage Account</h6>
                                    <div class="pl-lg-4">
                                        <div class="form-group focused">
                                            <center>
                                            <a href="recovery.php" class="btn btn-lg btn-secondary delpass" style="background-color: #92278F;">Change Password</a>
                                            <?php
                                            if( $GLOBALS['acc_type']=="team_leader" ){
                                            ?>
                                           <div class="btn btn-lg btn-secondary delpass" onclick="leadership()"  style="margin-left:10%;background-color:orangered;">Pass Leadership</div>
                                       <?php }else { ?>
                                            <div class="btn btn-lg btn-secondary delpass" onclick="popUp()"  style="margin-left:10%;background-color:orangered;">Delete Account</div>
                                       <?php } ?>
                                       </center>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <script src="jquery-3.4.1.min.js"></script>
 <script src="sweetalert2.all.min.js"></script>

<form method="POST" style="display:none;" action="delete.php">
    <input type="email" name="delemail" id="delemail" value="<?php echo $GLOBALS['mail'];?>">
    <button type="submit" name="passsubmit" id="delsubmit"></button>
</form>
<form method="POST" style="display: none">
    <input type="email" name="passemail" id="passemail">
    <button type="submit" name="passsubmit" id="passsubmit"></button>
</form>
<script>

 function popUp()
 {
    
     Swal.fire({
         title:"Are you Sure?",
         text:"You cannot revert this action",
         type:"warning",
         showCancelButton: true,
         confirmButtonColor:'red',
         cancelButtonColor:'blue',
         confirmButtonText:'Delete Record',
     }).then((result) => {
         if (result.value){

            document.getElementById("delsubmit").click();
        }
    });
 }

 function leadership()
 {

var html_text = `<select name="email" id="email"><?php 
for($i=0;$i<count($team_members);$i++){
    echo "<option value='".$team_members[$i]."' selected> $team_members[$i]</option>";
}
?> </select>`;


 Swal.fire({
  title: 'Pass Leadership',
  html: html_text,
  confirmButtonText: 'Confirm',
  focusConfirm: false,
}).then((result) => {
  var x=document.getElementById("email").value;
  document.getElementById("passemail").value=x;
  document.getElementById("passsubmit").click();
})   
 
 } 


    
    </script>

    
</body>

</html>