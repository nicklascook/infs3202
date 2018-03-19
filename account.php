<?php
    session_start();
    if($_SESSION['loggedIn'] = false){
        header("Location: login.php");
    }
    echo $_SESSION['loggedIn'];
 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MarketHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway" rel="stylesheet">
    
    
</head>
<body>
    <!-- Top Navigation Header -->
    <nav class="nav">
        <div class="logoContainer">
           <a href="index.php"> <h1>MarketHub<span class="icon-shopping-cart"></span></h1></a>
      

        </div>
        <div class="loginContainer">
            <?php
                $username = $_SESSION['username'];
                echo "<a href='account.php'><span class='icon-user'></span> $username </a>";

            ?>

            
        </div>
    </nav>

    <a href="logoutHandle.php">
        <button class=""> Log Out</button>
    </a>

</body>

<script src="js/script.js"></script>
</html>