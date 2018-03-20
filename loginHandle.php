<?php
    session_start();
    require("db.php");
    $username = $_POST['username'];
    // check if username is in database:
    $username_result = mysqli_query($mysqli, "SELECT * FROM users WHERE username='$username'");

    if ($username_result->num_rows == 0) { // 0 rows if it is not in the database

        $_SESSION['message'] = 'Username does not exist. Please create an account.';
        header("location: login.php");
    } else{
        $user = $username_result->fetch_assoc(); // Retrieve data from db
        if (password_verify($_POST["password"], $user['password'])){ // verify from encrypted password

            $_SESSION["username"] = $user["username"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["activated"] = $user["activated"];

            $_SESSION["loggedIn"] = true;

            header("location: index.php");

        } else{
            $_SESSION['message'] = 'Password entered is incorrect. Please try again.';
            header("location: login.php");
        }
    }

?>