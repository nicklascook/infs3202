<?php

    /* Take info from signup.php
        -> check if account already exists (email)
            - if it does then create error message and redirect to login
        -> if not, create a hash, send a confirmation email
    */
    session_start();
    require "db.php";
    // create session variables for other pages to access
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['username'] = $_POST['username'];



    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // takes password and encrypts it
    $hash = md5( rand(0,1000) ); // generates a number between 0-1000, runs md5 to create random hash string


    
    // Check if email already exists in the database
    $email_result = mysqli_query($mysqli, "SELECT * FROM users WHERE email='$email'");
    $username_result = mysqli_query($mysqli, "SELECT * FROM users WHERE username='$username'");
    // if there is more than 0 rows, then an email/username exists
    if ( $email_result->num_rows > 0 || $username_result->num_rows > 0) { // 
        $_SESSION['message'] = 'User with this email or username already exists!';
        header("location: signup.php");
    } 
    else{
        
        $sqlEntry = "INSERT INTO users (username, email, password, hash) " 
            . "VALUES ('$username','$email','$password', '$hash')";
        if ($mysqli->query($sqlEntry)){
            $_SESSION["activated"] = 0;
            $_SESSION["loggedIn"] = true;
            $_SESSION["message"] = "A confirmation link has been sent to your $email. Please confirm your account by clicking on the link included!";

            // Send verification email TODO later because of testing.

        } else{
            $_SESSION['message'] = 'Something went wrong with the signup! Please try again!';
            header("location: signup.php");
        }
        // return to main page
        header("Location: index.php");
    }

?>