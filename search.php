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
            <span class="icon-user"></span>
            <a href="signup.php">Sign Up</a>
            /
            <a href="login.php">Login</a>
        </div>
    </nav>

    <div class="searchContainer row">
        <div class="searchBar">
            <input type="text" name="" id="" placeholder="Search">
            <button>
                <span class="icon-search"></span>
            </button>
        </div>

    </div>
    

    <div class="searchContainer">
        <!-- REFINE SEARCH COLUMN -->
        <div class="categoryColumn">
            <h2>Refine Search</h2>
            <div class="categoryPicker">
                <p>Explore Category:</p>
                <ul>
                    <li><a href="#">Fashion</a></li>
                    <li><a href="#">Motors</a></li>
                    <li><a href="#">Garden</a></li>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Electronics</a></li>
                    <li><a href="#">Toys</a></li>
                    <li><a href="#">Health</a></li>
                    <li><a href="#">Collectables</a></li>
                </ul>
            </div>
            <hr>
            <div class="filter">
                <p>Format:</p>
                <label class="container"> 
                    <input type="checkbox">
                    <span class="checkmark"></span>
                    <p>Buy</p>
                </label>
                <label class="container">
                    <input type="checkbox">
                    <span class="checkmark"></span>
                    <p>Bid</p>
                </label>
            </div>
            <hr>
            <div class="filter">
                <p>Condition:</p>
                <label class="container"> 
                    <input type="checkbox" >
                    <span class="checkmark"></span>
                    <p>New</p>
                </label>
                <label class="container">
                    <input type="checkbox">
                    <span class="checkmark"></span>
                    <p>Used</p>
                </label>
            </div>
            <hr>
            <div class="filter price">
                <p>Price:</p>
                $ <input type="text" name="" id="" placeholder="">
                to $ 
                <input type="text" name="" id="" placeholder="">

            </div>
            <hr>
            <div class="filter">
                <p>Postage Type:</p>
                <label class="container">
                    <input type="checkbox">
                    <span class="checkmark"></span>
                    <p>Local Pickup</p>
                </label>
                <label class="container">
                    <input type="checkbox">
                    <span class="checkmark"></span>
                    <p>Mail</p>
                </label>
            </div>
            <hr>
            <button class="btn">Filter Results</button>
        </div>

        <!-- ITEM COLUMN -->
        <div class="itemColumn">
            <div class="sort">
                <p>Sort by:</p>
                <button class="btn">Best Match</button>
            </div>
            <div class="item">
                <img class="itemImg" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTs0tBB-7eKFOdvaepZJIWHyHFplhg3gahwzk-1ZbC04Qa3btnE" alt="">
                <div class="itemInfo">
                    <a href="#"><h3 class="itemTitle">Amazing Men's Tshirt Multiple Colours</h3></a>
                    <h4 class="itemPrice">$9.99</h4>
                    <h4 class="itemCondition">New</h4>
                    <h5 class="itemPostage">Free Postage</h5>
                </div>

            </div>
        </div>
    </div>


</body>

<script src="js/script.js"></script>

</html>