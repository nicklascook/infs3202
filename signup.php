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
    <title>Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway" rel="stylesheet">
    
</head>
<body>
    <div class="registerModalContainer">
        <div class="loginModal">
            <h1><a href="index.php">MarketHub<span class="icon-shopping-cart"></span></a>
                
            </h1>

            <h2 class="signupTitle"><span class="icon-user"></span> Sign Up</h2>
            <form action="signupHandle.php" method="POST" class="loginForm signupForm">
                <p>Email:</p> 
                <input type="text" name="email" placeholder="">
                <p>Username:</p> 
                <input type="text" name="username" placeholder="">
                <p>Password:</p> 
                <input type="password" name="password" placeholder="">
                <button type="submit" class="btn btn-secondary">Sign Up <span class="icon-check"></span></button>

                <?php
                    if (isset($_SESSION['message'])){
                        echo "<p class='registerLink' style='color:red;'>Error: User with this email/username already exists! <a href='login.php'>Login</a></p>";
                    } else{
                        echo "<p class='registerLink'>Already a user? <a href='login.php'>Login</a></p>";
                    }
                    unset($_SESSION['message']);
                ?>
                
            </form>

        </div>


    </div>
    


</body>
<script src="js/script.js"></script>
</html>