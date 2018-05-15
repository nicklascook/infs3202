<?php
    session_start();
    require("db.php");

    $id = $_POST['itemId'];
    $searchQuery = "DELETE FROM items WHERE id=$id";
    $result = mysqli_query($mysqli, $searchQuery);


?>