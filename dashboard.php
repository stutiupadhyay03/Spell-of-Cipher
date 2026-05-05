
<?php
session_start();

if ($_SESSION['login_status'] != 'login'){  
  header('Location: ./login.php');
} 

$mail = $_SESSION["user_email"]; //"patelvrunal1829@gmail.com"; 

include('dbconnect.php');

$sql="SELECT  * FROM  credentials_info where email='$mail' ";
$query = mysqli_query($GLOBALS['conn'], $sql);
while($user = mysqli_fetch_array($query)){

}


if(isset($_POST['submit']))
{
    $_SESSION['login_status'] = 'Logout';
    header('Location: ./index.php');
}
?>


<!DOCTYPE html>
<html>
<head>

<!-- <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css"> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
 

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/dashboard.css">
  <link rel="shortcut icon" type="image/png" href="images/logos/SOC_TL.png"/>
  

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

    </script>

<style type="text/css">
@import url('https://fonts.googleapis.com/css2?family=Lobster&display=swap');
  .countdown-container {
   position: relative;
   margin-top: 15%;
   -webkit-transform: translateY(-50%);
   -moz-transform: translateY(-50%);
   transform: translateY(-50%);
}
.clock-item .inner {
   height: 0px;
   padding-bottom: 100%;
   position: relative;
   width: 100%;
}
.clock-canvas {
   background-color: rgba(255, 255, 255, 0.1);
   border-radius: 50%;
   height: 0px;
   padding-bottom: 100%;
}
.text {
   color: #f6bc1a;
   font-size: 30px;
   font-weight: bold;
   margin-top: -50px;
   position: absolute;
   top: 50%;
   text-align: center;
   text-shadow: 1px 1px 1px rgba(0, 0, 0, 1);
   width: 100%;
}
.text .val {
   font-size: 50px;
}
.text .type-time {
   font-size: 20px;
}
.timer{
  margin-top: 10%;
}

.timer h1{
  font-size: 40px;
  color: whitesmoke;
  font-family: 'Lobster', cursive;

}

.timer h2{
  font-size: 40px;
  color: whitesmoke;
  font-family: 'Lobster', cursive;

}


@media (min-width: 768px) and (max-width: 991px) {
   .clock-item {
      margin-bottom: 30px;
   }
}
@media (max-width: 1200px) {
   .clock-item {
    margin-bottom: 30%;
    margin-left: 13%;
      /*margin: 0px 30px 30px 30px;*/
   }
 .countdown-container {
   position: relative;
   margin-top: 50%;
   -webkit-transform: translateY(-50%);
   -moz-transform: translateY(-50%);
   transform: translateY(-50%);

}
.clock-item .inner {
   height: 0px;
   padding-bottom: 100%;
   /*position: relative;*/
   width: 150%;
}

.timer{
  margin-top: 35%;
  padding: 10px;
}

.timer h1{
  font-size: 40px;
  color: whitesmoke;
  font-family: 'Lobster', cursive;

}

.timer h2{
  font-size: 40px;
  color: whitesmoke;
  font-family: 'Lobster', cursive;
  margin-bottom: 60%;

}
.text {
   color: #f6bc1a;
   font-size: 30px;
   font-weight: bold;
   margin-top: -30px;
   position: absolute;
   top: 50%;
   text-align: center;
   text-shadow: 1px 1px 1px rgba(0, 0, 0, 1);
   width: 100%;
}
}

</style>
</head>
<body id="body-pd" style=" background-color: rgba(44, 62, 80, 1); font-family: 'Raleway', 'Arial', sans-serif;">
    
    <?php include('nav.php');?>
<header class="timer">
<center><h1>Mark Your Calenders <i class="fa fa-calendar" aria-hidden="true"></i>
</h1></center>
<center><h2>The Competition goes live at 10:00 AM, 30th Ocotber, 2021</h2></center>
<div class="countdown-container container">
<div class="clock row">

<!-- days --> 
<div class="clock-item clock-days countdown-time-value col-sm-6 col-md-3">
<div class="wrap">
<div class="inner">
<div id="canvas_days" class="clock-canvas"></div>
<div class="text">
<p class="val">0</p>
<p class="type-days type-time">DAYS</p>
</div>
</div>
</div>
</div>

<!-- hours --> 

<div class="clock-item clock-hours countdown-time-value col-sm-6 col-md-3">
<div class="wrap">
<div class="inner">
<div id="canvas_hours" class="clock-canvas"></div>
<div class="text">
<p class="val">0</p>
<p class="type-hours type-time">HOURS</p>
</div>
</div>
</div>
</div>

<!-- minutes --> 
<div class="clock-item clock-minutes countdown-time-value col-sm-6 col-md-3">
<div class="wrap">
<div class="inner">
<div id="canvas_minutes" class="clock-canvas"></div>
<div class="text">
<p class="val">0</p>
<p class="type-minutes type-time">MINUTES</p>
</div>
</div>
</div>
</div>

<!-- seconds --> 
<div class="clock-item clock-seconds countdown-time-value col-sm-6 col-md-3">
<div class="wrap">
<div class="inner">
<div id="canvas_seconds" class="clock-canvas"></div>
<div class="text">
<p class="val">0</p>
<p class="type-seconds type-time">SECONDS</p>
</div>
</div>
</div>

</header>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script> 
<script type="text/javascript" src="https://www.jqueryscript.net/demo/Modern-Circular-jQuery-Countdown-Timer-Plugin-Final-Countdown/js/kinetic.js"></script> 
<script type="text/javascript" src="https://www.jqueryscript.net/demo/Modern-Circular-jQuery-Countdown-Timer-Plugin-Final-Countdown/jquery.final-countdown.js"></script> 
<script src="js/timer.js"></script>

<script type="text/javascript">
  function show($x){
    document.getElementById($x).style.display="block";
  }
</script>
</body>
</html>
