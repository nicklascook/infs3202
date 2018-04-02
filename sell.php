<?php
    session_start();
    require("db.php");


    if(isset($_SESSION['loggedIn']) != 1 || $_SESSION['loggedIn'] === 0){
        header("Location: login.php");
    } elseif($_SESSION['activated'] == 0){
        header("Location: activation.php");
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
<body class="sellItemBody">
    <!-- Top Navigation Header -->
    <nav class="nav">
        <div class="logoContainer">
           <a href="index.php"> <h1>MarketHub<span class="icon-shopping-cart"></span></h1></a>
      

        </div>
        <div class="loginContainer">
            <?php
                echo "<a href='account.php'><span class='icon-user'></span>".$_SESSION['username'] . "</a>";

            ?>

            
        </div>
    </nav>


        <form action="newItemHandle.php" method="POST">
            <div class="sellInputBlock sellInputBlock-top">
                <div class="sellInputContent">
                <section>
                    <h2>Name:</h2>
                    <h3>Use words people are likely to search for when looking for your item.</h3>
                    <input type="text" name="name" id="itemNameInput" placeholder="Name of your item" maxlength="60" required>
                    <div class="nameInputIndicator">
                        <div class="bar">
                            <div class="barFill"></div>
                        </div>
                        <p class="nameInputIndicatorText">Too short</p>
                        <p class="nameInputIndicatorDetail">Include details such as brand, colour, size, condition.</p>
                    </div>
                    <hr>
                </section>    

                <section>
                    <h2>Photos:</h2>
                    <!-- <input type="file" name="photo" size="25" /> -->

                    <div class="imageDropContainer">
                        <div class="imageDropText">Drag and Drop Images Here
                            <span class="icon-camera"></span>
                        </div>
                    </div>

                    <h3>Uploaded:</h3>

                    <div class="imageDropPreviewContainer">
                    </div>


                </section>

                <section class="detailsSection">
                    <h2>Details:</h2>
                    <div class="detailsSelectWrap">
                        <p>Condition*:</p>
                            <select name="condition" id="" required>
                                <option value="new">New</option>
                                <option value="used">Used</option>
                            </select>
                        <br>
                        <p>Postage Type*:</p>
                            <select name="postagetype" id="" required>
                                <option value="postage">Postage</option>
                                <option value="localpickup">Local Pickup</option>
                                <option value="both">Both</option>
                            </select>
                        <br>
                        <p>Brand:</p>
                            <input type="text" name="brand" id="" placeholder="Brand" maxlength="15">

                    </div>

                    <p class="descriptionLabel">Description*:</p>
                    <p class="descriptionLabel">Describe the item, including any unique features or flaws.</p>
                    <textarea name="description" id="" cols="30" rows="10" maxlength="600"></textarea>
                        
                        
                </section>


                </div>
            </div>

            <div class="sellInputBlock">
                <div class="sellInputContent">
                    <section>
                        <h2>Pricing:</h2>
                    <div class="pricingBlockContainer">
                        <div class="pricingBlock">
                            <h3><span class="icon-auction"></span> Bidding Starting Price</h3>
                            <input type="radio" name="pricetype" value="bid" id="bidRadio">
                            <span><label><span class="icon-dollar-sign"></span></label><input type="number" name="bidprice" id="bidPrice" placeholder="Price"></span>
                            <h4>Users can bid on this item, starting from the price defined. This item is up for 7 days, upon which the final bidder is awarded the opportunity to purchase.</h4>

                        </div>
                        <div class="pricingBlock">
                            <h3><span class="icon-shopping-cart2"></span> Standard Selling Price</h3>
                            <input type="radio" name="pricetype" value="buy" id="buyRadio">
                            <span><label><span class="icon-dollar-sign"></span></label><input type="number" name="buyprice" id="buyPrice" placeholder="Price"></span>
                            <h4>Buyers can purchase this item immediately at this price. The item is available until it is sold unless cancelled by you.</h4>

                        </div>

                    </div>
                    </section>
                </div>
            </div>
            <div class="sellInputBlock">
                <div class="sellInputContent">
                    <section>
                        <button value="submit" type="submit" class="btn submitSellBtn">Submit</button>
                    </section>
                </div>
            </div>
        </form>



</body>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="js/script.js"></script>
</html>