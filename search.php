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
            <a href="index.php">
                <h1>MarketHub
                    <span class="icon-shopping-cart"></span>
                </h1>
            </a>


        </div>
        <div class="loginContainer">
            <?php
                if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']){
                    echo "<a href='account.php'><span class='icon-user'></span>".$_SESSION['username'] . "</a>";
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
    

    <div class="searchContainer">
        <!-- REFINE SEARCH COLUMN -->
        <div class="categoryColumn">
            <h2>Refine Search</h2>
            <div class="categoryPicker">
                <p>Explore Category:</p>
                <select name="category" id="categoryFilterSelect" required>
                    <option selected disabled> </option>
                    <option value="fashion">Fashion</option>
                    <option value="motors">Motors</option>
                    <option value="garden">Garden</option>
                    <option value="home">Home</option>
                    <option value="electronics">Electronics</option>
                    <option value="toys">Toys</option>
                    <option value="health">Health</option>
                    <option value="collectables">Collectables</option>
                    <option value="other">Other</option>
                </select>
               
            </div>
            <hr>
            <div class="filter">
                <p>Format:</p>
                <label class="container"> 
                    <input name="format" type="radio">
                    <p>Buy</p>
                </label>
                <label class="container">
                    <input name="format" type="radio">
                    <p>Bid</p>
                </label>
            </div>
            <hr>
            <div class="filter">
                <p>Condition:</p>
                <label class="container"> 
                    <input name="condition" type="radio" >
                    <p>New</p>
                </label>
                <label class="container">
                    <input name="condition" type="radio">
                    <p>Used</p>
                </label>
            </div>
            <hr>
            <div class=" price">
                <p>Price:</p>
                $ <input type="number" min="0" name="" id="minPriceFilter" placeholder="">
                to $ 
                <input type="number" min="0" name="" id="maxPriceFilter" placeholder="">

            </div>
            <hr>
            <div class="filter">
                <p>Postage Type:</p>
                <label class="container">
                    <input name="postageType" type="radio">
                    <p>Local Pickup</p>
                </label>
                <label class="container">
                    <input name="postageType" type="radio">
                    <p>Mail</p>
                </label>
            </div>
            <hr>
            <button id="filterBtn" class="btn">Filter Results</button>
        </div>

        <!-- ITEM COLUMN -->
        <div class="itemColumn">
            <div class="sort">
                <p>Sort by:</p>
                <button class="btn">Best Match</button>
            </div>

            <!-- <div class="item">
                <img class="itemImg" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTs0tBB-7eKFOdvaepZJIWHyHFplhg3gahwzk-1ZbC04Qa3btnE" alt="">
                <div class="itemInfo">
                    <a href="#"><h3 class="itemTitle">Amazing Men's Tshirt Multiple Colours</h3></a>
                    <h4 class="itemPrice">$9.99</h4>
                    <h4 class="itemCondition">New</h4>
                    <h5 class="itemPostage">Free Postage</h5>
                </div>
            </div> -->

            <?php
                // Construct a search query
                $searchQuery = "SELECT * FROM items WHERE ";
                $appendAnd = false; // Track whether to place AND between queries. 

                if(isset($_GET['name']) && !empty($_GET['name'])){
                    $name = $_GET['name'];
                    if ($appendAnd){
                        $searchQuery .= " AND ";
                    }
                    $appendAnd = true;
                    $searchQuery .= "name LIKE '%$name%'";
                }
                if(isset($_GET['category']) && !empty($_GET['category'])){
                    $category = $_GET['category'];
                    if ($appendAnd){
                        $searchQuery .= " AND ";
                    }
                    $appendAnd = true;
                    $searchQuery .= "category LIKE '%$category%'";
                }

                // If $appendAnd is false, then no additions were made to the original $searchQuery => terminate search
                if($appendAnd){
                    $result = mysqli_query($mysqli, $searchQuery);
                }
                // $result = mysqli_query($mysqli, "SELECT * FROM items WHERE name LIKE '%$name%'");
                if($result->num_rows == 0){
                    echo "aint none here";
                } else{
                    $result = $result->fetch_assoc();
                    echo $result['name'];
                    // echo $result['description'];
                    // list($firstImage) = explode("<;>", $result["imageLocation"]);
                    // print_r($firstImage);
                    // echo $result["imageLocation"];
                    // print_r(explode("<;>", $result["imageLocation"]));

                    // list($bleh, $firstImage) = explode("<;>", $result["imageLocation"]);
                    // echo $firstImage;
                    // echo "<img src='". $firstImage ."'>";
                }

            ?>
        </div>
    </div>


</body>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="js/script.js"></script>
</html>