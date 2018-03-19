<?php
session_start();

if (isset($_SESSION['errorMessage'])){
    
    echo $_SESSION['errorMessage'];
} else{
    echo "An error has occured!";
}


?>