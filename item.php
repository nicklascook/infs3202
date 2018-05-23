<?php

    session_start();
    require("db.php");
    if(isset($_COOKIE['viewedItems'])){
        $cookieData =  $_COOKIE['viewedItems'];
        $cookieData = explode("-", $cookieData); 

        if(!in_array($_GET['id'], $cookieData, true)){
            if(count($cookieData) > 6){
                array_shift($cookieData);
            }
            array_push($cookieData, $_GET['id']);

            $cookieString ="";
            $count = 0;
            foreach(array_reverse($cookieData) as $itemNr){
                if(empty($itemNr)){
                    continue;
                } else if($count < 5){
                    $cookieString .= "-" . $itemNr;
                }
                $count++;
            }

            setcookie('viewedItems', $cookieString, time() +3600*24*7);
        }
        
    } else{
        $cookieStr = $_GET['id'];
        setcookie('viewedItems', $cookieStr, time() +3600*24*7);
    }

    
?>

<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MarketHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/item.js"></script>

</head>

<body>
    <!-- Top Navigation Header -->
    <nav class="nav">
        <div class="logoContainer">
            <a href="index.php">
                <h1>MarketHub
                    <span class="icon-shopping-cart"></span>
                </h1>
            </a>


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

    <hr class="itemDivide">
    <?php
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $searchQuery = "SELECT * FROM items WHERE id='$id'";
            $result = mysqli_query($mysqli, $searchQuery);

            

            if($result->num_rows == 0){
                echo "<h2 style='text-align:center;'>Item not found.</h2>";
                exit();
            } else{
                $result = $result->fetch_assoc();

                $name = $result['name'];
                $seller = $result['username'];
                $description = $result['description'];
                $bidding = $result['bidding'];
                if($result['newCondition'] === 1){
                    $condition = "New";
                } else{
                    $condition = "Used";
                }
                $brand = $result['brand'];
                $price = $result['price'];
                $postageType = $result['postageType'];
                $category = $result['category'];

                $images = explode("<;>", $result["imageLocation"]);
            }
        } else{
            header("location: search.php");
        }
    ?>
    <div class="itemTopNav">
        <button class="itemBackBtn" type="button" onclick="javascript:history.back()"><span class="icon-arrow-left"></span> Back to Search</button>
    </div>
    

    <div class="itemImgColumn">
        <?php
            echo "<img src=$images[1] class='itemImgMain'>";
        ?>

        <div class="itemImgGallery-container">
            <?php
                foreach($images as $img){
                    if($img == ""){
                        continue;
                    }
                    if($img === $images[1]){
                        echo "<div class='itemImgGallery itemImg-selected'><img src='$img'></div>";
                    } else{
                        echo "<div class='itemImgGallery'><img src='$img'></div>";
                    }
                }
            ?>
        </div>
    </div>
    
    <div class="itemDetailsColumn">
        <h1><?php echo $name; ?></h1>
        <h2 class='itemDescription'><?php echo $description; ?></h2>
        <?php
            echo "<a class='itemSeller' href='account.php?username=$seller'><span>Seller: </span>$seller</a>";
        ?>
        <h3 class='itemAdditionalInfo'><span>Condition:</span> <?php echo $condition; ?></h3>
        <?php if($brand !== ""){
            echo "<h3 class='itemAdditionalInfo'><span>Brand: </span>$brand</h3>";
        }
        ?>

        <div class="itemPriceBox">
            <h2>$<?php echo $price; ?></h2>
            <?php if($bidding == 0){
                echo "<a class='itemBuyBtn' href='buy.php?id=$id'>Buy</a>";
            } else{
                echo "<a class='itemBuyBtn' href='bidHandle.php'>Bid</a>";
            }

                if(isset($_SESSION['loggedIn'])){
                    
                    $username = $_SESSION['username'];
                    $searchQuery = "SELECT bookmarks FROM users WHERE username='$username'";
                    $result = mysqli_query($mysqli, $searchQuery);
                    if($result->num_rows > 0){
                      
                        $result = $result->fetch_assoc();
                        $bookmarks = $result['bookmarks'];
                        $newId = $_GET['id'];

                        $bookmarks = explode("-", $bookmarks);
                        if(!in_array($newId, $bookmarks, true)){
                            echo "<button id='bookmarkBtn' class='itemBuyBtn itemCartBtn'><span class='icon-bookmark'> </span> Bookmark</button>";
                        } else{
                            echo "<button disabled class='itemBuyBtn itemCartBtn'><span class='icon-check'> </span> Bookmarked</button>";
                        }


                    } 

                }
            
            ?>
            
        </div>
        
        <div class="itemPostageWrap">
            <h3>Postage:</h4>
            <?php
                if($postageType === "localpickup"){
                    echo "<p>This item is only available for pickup from the seller.</p> <br> <p>Item Location: <span>41".  rand(3,8). rand(1, 9) . "</span></p>";
                } else if($postageType === "postage"){
                    echo "<p>Free Postage - anywhere in Australia.</p>";
                } else{
                     echo "<h4>Postage Cost: $" . rand(6, 13) . "</h4>";
                     echo "<p>This item can also be picked up from the seller.</p> <br> <p>Item Location: <span>41".  rand(3,8). rand(1, 9) . "</span></p>";
                }
            ?>

        </div>
    </div>


</body>


</html>