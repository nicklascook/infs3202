<?php
session_start();

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
                if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']){
                    echo "<span class='accountName'><span class='icon-user'></span> ".$_SESSION['username']." <span class='accountArrow icon-chevron-down'></span></span>";
                    echo "<div class='accountDropdown'>
                        <a href='account.php'>Account</a>
                        <hr>
                        <a href='sell.php'>Sell</a>
                        <hr>
                        <a href='logoutHandle.php'>Sign out</a>

                    </div>";
                } else{
                    echo "<a href='signup.php' >Sign Up</a>
                    /
                    <a href='login.php' >Login</a>";
                }
            ?>
            
        </div>
    </nav>

    <div class="searchContainer row">
        <div class="searchBar">
            <form action="search.php" method="GET">
                <input type="text" name="name" id="" placeholder="Search">
                <button type="submit"><span class="icon-search"></span></button>
            </form>
        </div>

    </div>
    <div class="categoryPanelContainer row">
        <div class="categoryPanel">
            <button class="categoryButton">Fashion</button>
            <button class="categoryButton">Motors</button>
            <button class="categoryButton">Garden</button>
            <button class="categoryButton">Home</button>
            <button class="categoryButton">Electronics</button>
            <button class="categoryButton">Toys</button>
            <button class="categoryButton">Health</button>
            <button class="categoryButton">Collectables</button>
        </div>
    </div>

    <div class="itemDisplay itemDisplay_One" id="itemDisplay">
        <div class="itemDisplay_One" >
            <div class="itemDisplay_textContainer">
                <h2></h2>
                <h3></h3>
                <button>Explore</button>
            </div>
            <img src="" alt="">

        </div>
    </div>

    <div class="recentlyViewed ">
        <h2>Your Recently Viewed Items:</h2>
        <div class="recentlyViewedItem_row">
            <div class="recentlyViewedItem">
                <img src="data:image/jpeg;base64,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" alt="">
                <h3>T-shirt Men's</h3>
                <h4>$20.99</h4>
            </div>
            <div class="recentlyViewedItem">
                <img src="data:image/jpeg;base64,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" alt="">
                <h3>Nike Cap</h3>
                <h4>$9.99</h4>
            </div>
        </div>
    </div>


</body>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="js/script.js"></script>
</html>