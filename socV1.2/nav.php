<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap');
</style>

<header class="header" id="header" style="position: fixed;">
        <!-- <div class="header_toggle"> <i class="fa fa-bars" id="header-toggle" style=""></i> </div> -->
        <?php
            $mail = $_SESSION["user_email"];
            $sql="SELECT  * FROM  profile_info where email='$mail' ";
            $query = mysqli_query($GLOBALS['conn'], $sql);
            while($user = mysqli_fetch_array($query)){
                $title=$user['title'];
                $userlogo=$user['userlogo'];
            }

        ?>
        <div class="soc">
            <h3 style = "font-family: 'Poppins', sans-serif;"><?php echo $title;?></h3>
        </div>
        <div class="header_img"><img src="images/logos/logo_f.png" alt=""> </div>
      <!--   <div class="header_img"><img src="images/profiletoons/<?php //echo $userlogo;?>.png" alt=""> </div -->

    </header>
<div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div> 
                <a class="nav_logo" >
<i class="fa fa-magic header_toggle" id="header-toggle" style="color: whitesmoke;"></i> <span class="nav_logo-name">Spell of
                        Cipher</span> </a>
                <div class="nav_list">
                    <a href="dashboard.php" class="nav_link" id="nav-link"> <i class="fa fa-columns"></i> <span
                            class="nav_name">Dashboard</span> </a>
                    <a href="#" class="nav_link"> <i class="fa fa-terminal"></i> <span class="nav_name">Hello
                            World</span> </a>
                    <a href="#" class="nav_link"> <i class="fa fa-exclamation-circle"></i><span class="nav_name">Runtime
                            Terror</span> </a>
                    <a href="#" class="nav_link"> <i class="fa fa-stack-overflow"></i> <span
                            class="nav_name">Hack-a-thon</span> </a>
                    <a href="profile.php" class="nav_link"><i class="fa fa-user-circle"></i> <span class="nav_name">Profile</span>
                    </a>
                    <a href="#" class="nav_link"><i class="fa fa-trophy"></i> <span class="nav_name">Leaderboard</span>
                    </a>
                    <form method="POST">
                        <button type="submit" name="submit" class="nav_link"
                            style="background-color: transparent;border:none;"><i class="fa fa-sign-out"></i> <span
                                class="nav_name">Sign Out</span> </button>
                    </form>
                </div>
            </div>
        </nav>
    </div>

<script src="js/dashboard.js"></script>
