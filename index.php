<?php
session_start();
require("db.php");
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

    <?php 
        if (isset($_SESSION['message'])){
            echo "<p class='indexMessage'>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']);
        }

    ?>

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
            <a href="search.php?category=fashion"><button class="categoryButton">Fashion</button></a>
            <a href="search.php?category=motors"><button class="categoryButton">Motors</button></a>
            <a href="search.php?category=garden"><button class="categoryButton">Garden</button></a>
            <a href="search.php?category=home"><button class="categoryButton">Home</button></a>
            <a href="search.php?category=electronics"><button class="categoryButton">Electronics</button></a>
            <a href="search.php?category=toys"><button class="categoryButton">Toys</button></a>
            <a href="search.php?category=health"><button class="categoryButton">Health</button></a>
            <a href="search.php?category=collectables"><button class="categoryButton">Collectables</button></a>
        </div>
    </div>

    <div class="itemDisplay itemDisplay_One" id="itemDisplay">
        <button class="carouselButton"><span class="icon-arrow-right"></span></button>
        <div class="itemDisplay_One" >
            <div class="itemDisplay_textContainer">
                <h2></h2>
                <h3></h3>
                <a href=""><button>Explore</button></a>
            </div>
            <img src="" alt="">

        </div>
    </div>

    <?php
        if(isset($_COOKIE['viewedItems'])){
            echo "<div class='recentlyViewed'>";
            echo "<h2>Your Recently Viewed Items:</h2>";
            echo "<div class='recentlyViewedItem_row'>";

            $cookieData = explode("-", $_COOKIE['viewedItems']);
            foreach($cookieData as $itemNr){
                if(empty($itemNr)){
                    continue;
                }

                $searchQuery = "SELECT * FROM items WHERE id='$itemNr'";
                $result = mysqli_query($mysqli, $searchQuery);

                if($result->num_rows == 0){
                    continue;

                } else{

                    $result = $result->fetch_assoc();
                    $images = explode("<;>", $result["imageLocation"]);

                    echo "<div class='recentlyViewedItem'>";
                    echo "<a href='item.php?id=".$result['id']."'>";
                    echo "<img src='$images[1]'>";
                    echo "<h3>". $result['name'] . "</h3>";
                    echo "<h4>$".$result['price']."</h4>";
                    echo "</a>";
                    echo "</div>";
                    

                }

            }

            echo "</div></div>";
        }          

    ?>


</body>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="js/script.js"></script>
</html>