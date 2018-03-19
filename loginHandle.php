<?php
    session_start();
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    if ($_REQUEST['username'] == 'admin' && $_REQUEST['password'] == 'admin'){
        $_SESSION['username'] = "admin";
        $_SESSION['password'] = "admin";
        header("Location: index.php");
    } else{
        header("Location: login.php");
    }

?>