<?php 
    session_start();
    require("db.php");
    // Make sure an account is logged in:
    if(!isset($_SESSION['loggedIn'])){
        echo 0;
        exit();
    }
    $username = $_SESSION['username'];
    // Get the bookmarks from the user
    $searchQuery = "SELECT bookmarks FROM users WHERE username='$username'";
    $result = mysqli_query($mysqli, $searchQuery);

    if($result->num_rows == 0){
        echo 0;
        exit();
    } else{
        $result = $result->fetch_assoc();
        $bookmarks = $result['bookmarks'];
        $newId = $_POST['id'];

        $bookmarks = explode("-", $bookmarks);
        if(!in_array($newId, $bookmarks, true)){

            array_push($bookmarks, $newId);

            $bookmarkString = implode("-", $bookmarks);
        

            $sqlEntry = "UPDATE users SET bookmarks = '$bookmarkString' WHERE username = '$username'";
                if ($mysqli->query($sqlEntry)){
                    echo 1;
                } else{
                    echo 0;
                }
        }

    }
    // extract the ids from it

    // check to see if id is present 

    // else add it in


?>