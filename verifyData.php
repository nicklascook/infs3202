<?php
    session_start();
    require("db.php");


    if(isset($_POST['email'])){
        $email = $_POST['email'];
        $searchQuery = "SELECT * FROM users WHERE email='$email'";

    } else if(isset($_POST['username'])){
        $username = $_POST['username'];
        $searchQuery = "SELECT * FROM `users` WHERE username='$username'";
    } 

    
    $result = mysqli_query($mysqli,$searchQuery);

    if($result->num_rows == 0){
        echo false;
    }else{
        echo true;
    }

?>