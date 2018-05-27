<?php
    session_start();
    require("db.php");


   
    $username = $_SESSION['username'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    if ($_POST['condition'] === "new"){
        $newCondition = 1;
    } else{
        $newCondition = 0;
    }
    $postageType = $_POST['postagetype'];
    $brand = $_POST['brand'];
    $description = $_POST['description'];

    $pricetype = $_POST['pricetype'];
    if($pricetype === "bid"){
        $bidding = 1;
        $price = $_POST['bidprice'];
    } else{
        $bidding = 0;
        $price = $_POST['buyprice'];
    }

    $imageLocation = "";
     foreach( $_SESSION['uploadedImages'] as $imageName){
        $imageLocation = $imageLocation . "<;>" . $imageName;
    }

    unset($_SESSION['uploadedImages']);


    $sqlEntry = "INSERT INTO items (username, name, description, newCondition, brand, bidding, price, postageType, category, imageLocation) " 
            . "VALUES ('$username','$name','$description', '$newCondition', '$brand', '$bidding', '$price', '$postageType', '$category', '$imageLocation')";
        if ($mysqli->query($sqlEntry)){

            $_SESSION['message'] = "Item successfully posted!";
            header("Location: index.php");



        } else{
            $_SESSION['message'] = 'Something went wrong with posting the item! Please try again!';
            header("Location: index.php");
        }



?>