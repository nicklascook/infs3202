<?php
    session_start();
    require "db.php";
    if(isset($_SESSION['loggedIn']) == true && $_SESSION['loggedIn'] == true){
        header("Location: account.php");
    } 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway" rel="stylesheet">
    
</head>
<body>
    <!-- Top Navigation Header -->
    

    <div class="loginModalContainer">
        <div class="loginModal">
            <h1>
                <a href="index.php">MarketHub
                    <span class="icon-shopping-cart"></span>
                </a>
            </h1>

            <h2><span class="icon-user"></span> Welcome back</h2>
            <form action="loginHandle.php" method="POST" class="loginForm">
                <p>Username:</p> 
                <input type="text" name="username" placeholder="" required>
                <p>Password:</p> 
                <input type="password" name="password" placeholder="" required>
                <button type="submit" class="btn">Login <span class="icon-arrow-right"></span></button>


                <?php
                    if (isset($_SESSION['message'])){
                        echo "<p class='registerLink' style='color:red;'>". $_SESSION["message"] ."<a href='signup.php'> Sign Up</a></p>";
                        unset($_SESSION['message']);
                    } else{
                        echo "<p class='registerLink'>Not a user? <a href='signup.php'>Sign Up</a></p>";
                    }
                    
                ?>
            </form>

        </div>


    </div>
    


</body>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="js/script.js"></script>
</html>