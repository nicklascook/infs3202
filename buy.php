<?php

    session_start();
    require("db.php");

     if(isset($_SESSION['loggedIn']) != 1 || $_SESSION['loggedIn'] === 0){
        header("Location: login.php");
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
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/buy.js"></script>

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

                if($seller === $_SESSION['username']){
                    header("location:index.php");
                }

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
    
    <div class="buyBlockWrap">
        <h3>Review Item and Postage:</h3>
        <div class="buyBlock buyReviewItem">
            <div class="buyItemTop">
                <p>Seller:</p> <?php echo "<a href='account.php?username=$seller'>$seller</a>"; ?>
            </div>

            <div class="buyItemImgCol">
                <?php
                    echo "<img src=$images[1] class=''>";
                ?>
            </div>

            <div class="buyItemTextCol">

                <?php
                    echo "<h3>$name</h3>";
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


            <div class="buyItemPriceCol">
                <?php
                    echo "<h4 class='buyItemPrice'>$$price</h4>";
                ?>
            </div>
        </div>
    </div>


    <div class="buyBlockWrap buyPostageBlockWrap <?php if($postageType === "localpickup"){echo "hide";}?>">
        <h3>Post to:</h3>
        <div class="buyBlock buyPostageBlock">
            <div class="buyPostageRow">
                <input type="text" placeholder="First Name">
                <input type="text" placeholder="Last Name">
            </div>
            <div class="buyPostageRow">
                <input type="text" placeholder="Street Address">
                <input type="text" placeholder="Street Address 2 (optional)">
            </div>
            <div class="buyPostageRow">
                <input type="text" placeholder="City">
                <input type="text" placeholder="State">
                <input type="text" placeholder="Postcode">
            </div>
        </div>
    </div>

    <div class="buyBlockWrap">
        <h3>Purchase:</h3>
        <div class="buyBlock buyPurchase">
            <div id="paypal-button"></div>
        </div>
    </div>

    
    
        
        


</body>


</html>