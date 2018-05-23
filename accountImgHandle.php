<?php

    session_start();
    require("db.php");
    require 'vendor/autoload.php';

    use JBZoo\Image\Image;
    use JBZoo\Image\Filter;
    use JBZoo\Image\Exception;


    if($_GET['function'] === "upload"){
        $fileName = strtolower($_FILES['image']['name']); //rename file, lower case
    
        if($_FILES['image']['size'] > (4096000)){ // check that file is 4mb max
                echo "error:filesize";
        } else{ 
            $extension = "." . pathinfo($fileName, PATHINFO_EXTENSION); // Get the extension of the file
            // MAKE SURE NO OTHER IMAGE OF THE SAME NAME EXISTS
            if (file_exists('./uploads/'. $fileName)){
                list($imageName) = explode($extension, $fileName); // Separate the name itself
                
                $count = 1; // start a count for the while loop
                while(file_exists('./uploads/'. $fileName)){ // While an image of that name exists:
                    $fileName = $imageName . $count . $extension; // Add 1 to the original image name:
                    $count ++;
                }
            }
             if($extension === ".png" || $extension === ".gif" || $extension === ".jpg" || $extension === ".jpeg"){ // check that it is an image
                move_uploaded_file($_FILES['image']['tmp_name'],'./uploads/'.$fileName); // Move to web root in /uploads/
                $username = $_SESSION['username'];
                $sqlQuery = "UPDATE users SET accountImage ='$fileName' WHERE username = '$username'";
                mysqli_query($mysqli, $sqlQuery) or die(mysqli_error($mysqli));
    
    
             }
    
        }
    } else if ($_GET['function'] == "greyscale"){
        $imgPath = "./uploads/" . $_GET['imgPath'];

        $img = (new Image($imgPath))
                ->addFilter('grayscale') 
                ->saveAs($imgPath);
    } else if ($_GET['function'] == "warm"){
        $imgPath = "./uploads/" . $_GET['imgPath'];

        $img = (new Image($imgPath))
                ->addFilter('colorize', '#FF0000', .5) 
                ->saveAs($imgPath);
    } else if ($_GET['function'] == "cool"){
        $imgPath = "./uploads/" . $_GET['imgPath'];

        $img = (new Image($imgPath))
                ->addFilter('colorize', '#0000FF', .5) 
                ->saveAs($imgPath);
    }



?>