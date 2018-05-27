<?php
    session_start();
    require("db.php");


    if(isset($_SESSION['loggedIn']) != 1 || $_SESSION['loggedIn'] === 0){
        header("Location: login.php");
    }
    

    // IF NO USERNAME IS GIVEN SEND TO OWN ACCOUNT
    if(!isset($_GET['username'])){
        header('location: account.php?username=' . $_SESSION['username']);
    }

    $unlockAccountInfo = false;
    //if the account belongs to the user:
    if($_GET['username'] === $_SESSION['username']){
        $unlockAccountInfo = true;
    }

    $searchQuery = "SELECT * FROM users WHERE username='" .$_GET['username'] ."'";
    $result = mysqli_query($mysqli, $searchQuery);

    if($result->num_rows == 0){
                echo "<h2 style='text-align:center;'>User not found.</h2>";
                exit();
    } else{
        $result = $result->fetch_assoc();

        $email = $result['email'];
        $username = $result['username'];
        $bookmarks = $result['bookmarks'];
        $accountImage = $result['accountImage'];


    }
 
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
    <div class="loading " id="loading">
        <span class="icon-spinner spin"></span>
    </div>
    <div class="accountInfo">
        <div class="accountDetails">
            <?php
            if (isset($_SESSION['message'])){
                echo "<p class='indexMessage'>" . $_SESSION['message'] . "</p>";
                unset($_SESSION['message']);
            }


            $customAccountImage = false;
                if($accountImage != ""){
                    echo "<img src='uploads/$accountImage' class='accountImage accountImage-custom'>";
                    $customAccountImage = true;
                } else{
                        echo "<img src='img/account_img.png' class='accountImage'>";
                }
            ?>
            <h1><?php echo $username; ?></h1>
            <?php
                if($unlockAccountInfo){
                    echo "<h2>$email</h2>";
                }
                ?>
           
           
        </div>
         
        <div class="accountStats">
            <h3>Items Sold:</h3>
            <?php
                $sqlQuery = "SELECT * FROM orders WHERE seller = '$username'";
                $result = mysqli_query($mysqli, $sqlQuery);
                $countSold = 0;
                if($result->num_rows > 0){
                    while ($row = $result->fetch_assoc()) {
                        $countSold++;
                    }

                } 
                echo "<h3>$countSold</h3>";

                echo "<h3>Items Purchased:</h3>";
                $sqlQuery = "SELECT * FROM orders WHERE username = '$username'";
                $result = mysqli_query($mysqli, $sqlQuery);
                $countBought = 0;
                if($result->num_rows > 0){
                    while ($row = $result->fetch_assoc()) {
                        $countBought++;
                    }

                } 
                 echo "<h3>$countBought</h3>";
            ?>
        </div>
        <?php
            if(!isset($_SESSION['loggedIn']) || !$unlockAccountInfo){
                  exit();
            }
        ?>
       

        
        
    </div>

    
    <div class="accountTabsContainer">
        <div class="accountTabsWrap">
            <h2 class="accountTab accountTab-active">Bookmarks</h2>
            <h2 class="accountTab">Items For Sale</h2>
            <h2 class="accountTab">Settings</h2>
        </div>

        <div id="bookmarksTab" class="bookmarksTab accountTabContent">
            <?php
                // Get the 
                $bookmarks = explode("-", $bookmarks);

                foreach($bookmarks as $itemNr){
                    if($itemNr == null){
                        continue;
                    }
                    $searchQuery = "SELECT * FROM items WHERE id = $itemNr";
                    $result = mysqli_query($mysqli, $searchQuery);
                    if($result->num_rows > 0){
                        $result = $result->fetch_assoc();

                        list($arr, $firstImage) = explode("<;>", $result["imageLocation"]);
      
                        if($result['newCondition'] === 1){
                            $itemConditionStr = "New";
                        } else{
                            $itemConditionStr = "Used"; 
                        }
                        echo "<div class='accountItem'><img class='accountItemImg' src=".$firstImage.">";
                        echo "<div class='accountItemInfo'><a href='item.php?id=".$result['id']."'><h3 class='accountItemTitle'>".$result['name']."</h3></a>
                            <h4 class='accountItemPrice'>$".$result['price']."</h4>
                            <h4 class='accountItemCondition'>".$itemConditionStr."</h4>
                            <h5 class='accountItemPostage'>Free Postage</h5>
                        </div>";
                        echo "</div>";
                    }
                }
            ?>
        </div>

        <div id="itemsForSaleTab" class="itemsForSaleTab accountTabContent">
            <?php
                $searchQuery = "SELECT * FROM items WHERE username ='$username'";
                $result = mysqli_query($mysqli, $searchQuery);
                if($result->num_rows > 0){
                    while ($row = $result->fetch_assoc()) {
                        list($arr, $firstImage) = explode("<;>", $row["imageLocation"]);

                        if($row['newCondition'] === 1){
                            $itemConditionStr = "New";
                        } else{
                            $itemConditionStr = "Used"; 
                        }
                        echo "<div class='accountItem' itemId='".$row['id']."'><img class='accountItemImg' src=".$firstImage.">";
                        echo "<div class='accountItemInfo'><a href='item.php?id=".$row['id']."'><h3 class='accountItemTitle'>".$row['name']."</h3></a>
                            <h4 class='accountItemPrice'>$".$row['price']."</h4>
                            <h4 class='accountItemCondition'>".$itemConditionStr."</h4>
                            <h5 class='accountItemPostage'>Free Postage</h5>
                        </div>";
                        echo "<span class='deleteItem'><span class='icon-trash-2'></span><p> Delete</p></span>";
                        echo "</div>";
                    }
                }
            ?>
        </div>
        <div id="orderHistoryTab" class="orderHistoryTab accountTabContent">
                <div class="accountImgUploadWrapper <?php if(!$unlockAccountInfo){echo "hide";} ?>">
                    <h2>Edit Account Image:</h2>
                    <p>Upload account image:</p>
                    <!-- <input type="file" name="accountImg" id="accountImgUpload"> -->
                    <div class="upload-btn-wrapper">
                        <button class="uploadBtn"><span class="icon-upload-cloud"></span> Upload</button>
                        <input id="accountImgUpload" type="file" name="myfile" />
                    </div>

                    <div class="accountImgEditWrapper <?php if(!$customAccountImage){echo "hide";} ?>">
                        <p>Add a filter to image:</p>
                        <button class="imageFilterBtn" id="accountImgGreyscale">Greyscale</button>
                        <button class="imageFilterBtn" id="accountImgWarm">Warm</button>
                        <button class="imageFilterBtn" id="accountImgCool">Cool</button>
                    </div>

                 </div>
                    <div class="accountSupportWrapper">
                        <h2>Account Support:</h2>
                        <p>Have an issue with your purchase? Upload your invoice and our support team will be in contact with you as soon as possible.</p>
                        <div class="upload-btn-wrapper">
                            <button class="uploadBtn"><span class="icon-upload-cloud"></span> Upload PDF</button>
                            <input id="accountPdfUpload" type="file" name="myfile" accept="application/pdf" />
                        </div> 
                    </div> 
        </div>

    </div>

</body>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="js/script.js"></script>
</html>