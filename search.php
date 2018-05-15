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
                    <input name="format" type="radio" value="Buy">
                    <p>Buy</p>
                </label>
                <label class="container">
                    <input name="format" type="radio" value="Bid">
                    <p>Bid</p>
                </label>
            </div>
            <hr>
            <div class="filter">
                <p>Condition:</p>
                <label class="container"> 
                    <input name="condition" type="radio" value="New">
                    <p>New</p>
                </label>
                <label class="container">
                    <input name="condition" type="radio" value="Used">
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
                    <input name="postageType" type="radio" value="LocalPickup">
                    <p>Local Pickup</p>
                </label>
                <label class="container">
                    <input name="postageType" type="radio" value="Postage">
                    <p>Postage</p>
                </label>
            </div>
            <hr>
            <div class="filterBtnContainer">
                <button id="clearFilterBtn" class="btn btn-clear">Clear</button>
                <button id="filterBtn" class="btn">Filter</button>
            </div>
        </div>

        <!-- ITEM COLUMN -->
        <div class="itemColumn">
            <div class="sort">
                <p>Sort:</p>
                <select id="searchSortSelect">
                    <option value="bestmatch">Best Match</option>
                    <option value="pricelow">Price (Low)</option>
                    <option value="pricehigh">Price (High)</option>
                    <option value="newest">Newest</option>
                </select>
            </div>

            <div class="itemWrap">
                    
            

            <?php
                // Construct a search query
                $searchQuery = "SELECT * FROM items WHERE ";
                $appendAnd = false; // Track whether to place AND between queries. 
                $searchCriteria = array();

                if(isset($_GET['name']) && !empty($_GET['name'])){
                    $name = $_GET['name'];
                    if ($appendAnd){
                        $searchQuery .= " AND ";
                    }
                    $appendAnd = true;
                    array_push($searchCriteria, "name");
                    $searchQuery .= "name LIKE '%$name%'";
                }
                if(isset($_GET['category']) && !empty($_GET['category'])){
                    $category = $_GET['category'];
                    if ($appendAnd){
                        $searchQuery .= " AND ";
                    }
                    $appendAnd = true;
                    array_push($searchCriteria, "category");
                    $searchQuery .= "category LIKE '%$category%'";
                }
                if(isset($_GET['format']) && !empty($_GET['format'])){
                    $format = $_GET['format'];
                    if ($appendAnd){
                        $searchQuery .= " AND ";
                    }
                    if($format == "Buy"){
                        $format = 0;
                    } else{
                        $format = 1;
                    }
                    $appendAnd = true;
                    $searchQuery .= "bidding LIKE '%$format%'";
                }
                if(isset($_GET['condition']) && !empty($_GET['condition'])){
                    $condition = $_GET['condition'];
                    if ($appendAnd){
                        $searchQuery .= " AND ";
                    }
                    if($condition == "New"){
                        $condition = 1;
                    } else{
                        $condition = 0;
                    }
                    $appendAnd = true;
                    $searchQuery .= "newCondition LIKE '%$condition%'";
                }
                if(isset($_GET['postageType']) && !empty($_GET['postageType'])){
                    $postageType = $_GET['postageType'];
                    if ($appendAnd){
                        $searchQuery .= " AND ";
                    }
                    $appendAnd = true;
                    $searchQuery .= "postageType LIKE '%$postageType%'";
                }
                if(isset($_GET['minPrice']) && !empty($_GET['minPrice'])){
                    $minPrice = $_GET['minPrice'];
                    if ($appendAnd){
                        $searchQuery .= " AND ";
                    }
                    $appendAnd = true;
                    $searchQuery .= "price > '$minPrice'";
                }
                if(isset($_GET['maxPrice']) && !empty($_GET['maxPrice'])){
                    $maxPrice = $_GET['maxPrice'];
                    if ($appendAnd){
                        $searchQuery .= " AND ";
                    }
                    $appendAnd = true;
                    $searchQuery .= "price < '$maxPrice'";
                }

                if(isset($_SESSION['username'])){ // Ensure user does not see his own items
                    $username = $_SESSION['username'];
                    $searchQuery .= " AND username != '$username'";
                }


                // If $appendAnd is false, then no additions were made to the original $searchQuery => terminate search
                if($appendAnd){
                    
                    // APPEND to the search query to sort by the GET parameter 'sort' 
                    if(isset($_GET['sort']) && $_GET['sort'] !== "bestmatch"){
                        if($_GET['sort'] === "pricelow"){
                            $searchQuery .= " ORDER BY price ASC";
                        } elseif($_GET['sort'] === "pricehigh"){
                            $searchQuery .= " ORDER BY price DESC";
                        } elseif($_GET['sort'] === "newest"){
                            $searchQuery .= " ORDER BY newCondition DESC";
                        } 
                    }
                    $result = mysqli_query($mysqli, $searchQuery);
                } else{
                    echo "<h2 style='text-align:center;'>No results were found.</h2><br>";
                    echo "<h3>Showing similar results:</h3>";
                    $result = mysqli_query($mysqli, "SELECT * FROM items");
                }

                if($result->num_rows == 0){ // NO results were found
                    echo "<h2 style='text-align:center;'>No results were found.</h2><br>"; 
                    echo "<h3>Showing similar results:</h3>";
                    if(count($searchCriteria) > 0){ // Find if any parameters were given
                        if(count($searchCriteria) == 1 && in_array("name", $searchCriteria)){ // if only name was given, but returned no correct results, show random items.
                            $result = mysqli_query($mysqli, "SELECT * FROM items");
                            echo "<h3>Showing similar results:</h3>";
                        } else if(count($searchCriteria) == 2 && in_array("name", $searchCriteria) && in_array("category", $searchCriteria)){ // if both name and category were given, show only from category
                            $result = mysqli_query($mysqli, "SELECT * FROM items WHERE category LIKE '%$category%'");
                            echo "<h3>Showing similar results from ".ucfirst($category) .":</h3>";
                        }
                    }
                }

                //Catch edge circumstances where still no results are found
                if($result->num_rows == 0){
                    $result = mysqli_query($mysqli, "SELECT * FROM items");
                }

                while ($row = $result->fetch_assoc()) {

                    list($arr, $firstImage) = explode("<;>", $row["imageLocation"]);

                    if($row['newCondition'] == 1){
                        $itemConditionStr = "New";
                    } else{
                        $itemConditionStr = "Used"; 
                    }
                    echo "<a href='item.php?id=".$row['id']."'><div class='item'><img class='itemImg' src=".$firstImage.">";
                    echo "<div class='itemInfo'><h3 class='itemTitle'>".$row['name']."</h3>
                        <h4 class='itemPrice'>$".$row['price']."</h4>
                        <h4 class='itemCondition'>".$itemConditionStr."</h4>
                        <h5 class='itemPostage'>Free Postage</h5>
                    </div>";
                    echo "</div></a>";
                }

                    
                

            ?>
            </div>
        </div>
    </div>


</body>


</html>