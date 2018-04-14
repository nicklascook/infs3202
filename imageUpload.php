<?php
    session_start();
    require("db.php");
        
if($_FILES['image']['name']){ // if file is uploaded:
    //if no errors:
    if(!$_FILES['image']['error']){

        $fileName = strtolower($_FILES['image']['name']); //rename file, lower case


        if($_FILES['image']['size'] > (4096000)){ // check that file is 4mb max
            echo "error:filesize";
        } else{ 
            
            $extension = "." . pathinfo($fileName, PATHINFO_EXTENSION); // Get the extension of the file
            // Check if the file exists:
            if (file_exists('./uploads/'. $fileName)){
                list($imageName) = explode($extension, $fileName); // Separate the name itself
                
                $count = 1; // start a count for the while loop
                while(file_exists('./uploads/'. $fileName)){ // While an image of that name exists:
                    $fileName = $imageName . $count . $extension; // Add 1 to the original image name:
                    $count ++;
                }
            }

            if($extension === ".png" || $extension === ".gif" || $extension === ".jpg" || $extension === ".jpeg"){ // check that it is an image
                
                move_uploaded_file($_FILES['image']['tmp_name'], './uploads/'.$fileName); // Move to web root in /uploads/
                if (!isset($_SESSION['uploadedImages'])){ // Set session variable for when posting form
                    $_SESSION['uploadedImages'] = [];
                }
                array_push($_SESSION['uploadedImages'], './uploads/'.$fileName); // add to session array
                echo './uploads/'.$fileName; // return the file location for jquery to display
            } else{
                echo "error:extension"; // return incorrect extension error
            }

        }

    }
}

    

?>