<?php
    session_start();
    require("db.php");



    $name = $_POST['name'];
    $condition = $_POST['condition'];
    $postagetype = $_POST['postagetype'];
    $brand = $_POST['brand'];
    $description = $_POST['description'];
    $pricetype = $_POST['pricetype'];

    if($pricetype === "bid"){
        $price = $_POST['bidprice'];
    } else{
        $price = $_POST['buyprice'];
    }



    function photoUpload(){
        
            if($_FILES['photo']['name']){ // if file is uploaded:
                //if no errors:
                if(!$_FILES['photo']['error']){
    
                    $fileName = strtolower($_FILES['photo']['name']); //rename file, lower case
    
    
                    if($_FILES['photo']['size'] > (2048000)){ // check that file is 2mb max
                        echo "uh oh";
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
                            
                            move_uploaded_file($_FILES['photo']['tmp_name'], './uploads/'.$fileName);
                        } else{
                            // what if it aint an image
                        }
    
                    }
    
                }
            }

     } 

?>