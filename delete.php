<?php
session_start();
include('dbconnect.php');
$id = $_POST['delemail'];
$query= mysqli_query($GLOBALS['conn'],"DELETE FROM credentials_info where email='$id'");
$query= mysqli_query($GLOBALS['conn'],"DELETE FROM profile_info where email='$id'");
if($query){
	$_SESSION['login_status']='logout';
	session_destroy();
}

header( "refresh:10;url=index.php" );
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
	<link rel="shortcut icon" type="image/png" href="images/logos/SOC_TL.png" />



	<style>
		@import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

		* {
			font-family: 'Poppins', sans-serif;
		}

		body {
			/* justify-content: center; */
			/* display: flex; */
			align-items: center;
			background: linear-gradient(to left, #92278f, #262262);
		}


		.check {
			font-size: 90px;
			color: green;

		}

		h2 {
			color: red;
			font-weight: bold;
		}

		.jumbotron {
			/* margin: auto; */
			margin-top: 5%;
			width: 70vw;
			background: whitesmoke;
		}

		@media only screen and (max-width: 768px) {

			.jumbotron {
				/* margin: auto; */
				/* margin-top: 10%; */
				width: 90vw;
				background: whitesmoke;
			}
		}
	</style>
	<title>We Will Miss You!</title>
</head>

<body>
	<!-- Latest compiled and minified CSS -->

	<div class="container-fluid">
		<div class="row">
			<img src="images/logos/SOC_TL.png" style="height: 10rem; margin-left:auto; display:block ">

		</div>

		<center>
			<div class="jumbotron" style="box-shadow: 2px 2px 4px #000000;">
				<!-- <i class="fa fa-check check" aria-hidden="true"></i> -->
				<img style="height: 40vh; width:100%" src="images/others/delete.svg">
				<br>
				<h2 class="text-center">YOUR ACCOUNT HAS BEEN SUCESSFULLY DELETED</h2>
				<br>
				<p class="text-center"> It was our honour to host you, we hope your experience with us was wonderful.</p>
				<h3 class="text-center"> If you have any feedback related to our event you can write to us at <strong>'spellofcipher@gmail.com'</strong>. </h3>

			</div>

		</center>
	</div>

</body>

</html>