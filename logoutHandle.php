<?php
    session_start();
    session_unset();
    session_destroy(); 
    // session_start();
    // $_SESSION["message"] = "Logout Successful.";
    header("location: index.php");

?>
