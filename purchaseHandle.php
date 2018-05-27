<?php
    session_start();
    require("db.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';
    require('fpdf.php');

    $id = $_POST['itemId'];
    $username = $_SESSION['username'];
    
    $sqlQuery = "SELECT * FROM items WHERE id = $id";
    $result = mysqli_query($mysqli, $sqlQuery);
    if($result->num_rows > 0) {
        $result = $result->fetch_assoc();

        $seller = $result['username'];
        $name = $result['name'];
        $price = $result['price'];
        $postageType = $result['postageType'];
        $imageLocation = $result['imageLocation'];
        

        $sqlQuery = "INSERT INTO orders (id, username, seller, name, price, postageType, imageLocation, orderCompleted) 
        VALUES ($id, '$username', '$seller', '$name', $price, '$postageType', '$imageLocation', 0)";

        mysqli_query($mysqli, $sqlQuery) or die(mysqli_error($mysqli));

        $sqlQuery = "DELETE FROM items WHERE id = $id";

        mysqli_query($mysqli, $sqlQuery) or die(mysqli_error($mysqli));

         if($postageType == "postage"){
            $postageType = "Seller must post item within 7 days from " . date("d/m/y"); 
        } else if($postageType == "both"){
            $postageType = "Seller must post item within 7 days from " . date("d/m/y") . " OR if arranged, buyer must pick up item within 14 days of this date.";
        } else{
            $postageType = "Buyer must pick up item within 14 days of ". date("d/m/y");
        }

        list($arr, $imageLocation) = explode("<;>", $imageLocation);
        $invoiceNumber = rand(10000000, 99999999);

        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',15);
        // Move to the right
        $pdf->Cell(45);
        // Title
        $pdf->Cell(100,10,'MarketHub Pty. LTD.',1,0,'C');
        // Line break
        $pdf->Ln(20);

        $pdf->SetFont('Arial','',10);
        $pdf->Cell(5);
        $pdf->Cell(60,10,'Invoice number: ' . $invoiceNumber);
        $pdf->Cell(60,10,'Item Id: ' . $id);
        $pdf->Ln(10);
        $pdf->SetFont('Arial','',18);
        
        $pdf->Cell(65);
        $pdf->Cell(100,10,'INVOICE FOR ITEM:');
        $pdf->Ln(20);
        $pdf->Cell(50);
        $pdf->SetTextColor(100, 0,100);
        $pdf->MultiCell(130,10,$name, '');
        $pdf->Image($imageLocation,20,60,30);
        $pdf->SetTextColor(0, 0,0);
        $pdf->Ln(10);
        $pdf->Cell(50);
        $pdf->Cell(100,10,'Seller: ' . $seller, 'C');
        $pdf->Ln(10);
        $pdf->Cell(50);
        $pdf->Cell(100,10,'Buyer: ' . $username, 'C');
        $pdf->Ln(20);
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(50);
        $pdf->MultiCell(100,10,$postageType, 'C');
        $pdf->Ln(30);
        $pdf->Cell(80);
        $pdf->SetFont('Arial','',24);
        $pdf->Cell(100,10,'$' . $price);

        $pdf->Rect(10,30,190,195);

            
        
        $array = str_split($id);
        while(count($array) < 8){
            array_unshift($array, 0);
        }

        $barcodeCount = 0;
        $arrayCount = count($array);
        $barcodeStartX = 115 - ($arrayCount/2)*4;

        foreach($array as $value){
            $value = ($value/10)*2;
            // $pdf->Rect( (90 + $barcodeCount*4) , 200, $value, 20, 'F');
            $pdf->Rect( ($barcodeStartX + $barcodeCount*4) , 200, $value, 20, 'F');
            // 210 / 2  = 105, each barcode is 4 away from each other, so number of 105 - (barcodes/2)*4 centres it.

            $barcodeCount++;
        }

        $pdf->SetFont('Arial','',12);
        $pdf->Ln(90);
        $pdf->Cell(10);
        $pdf->Cell(100,10, "MarketHub Pty. LTD. Contact our support team at MarketHub.com if any issues arise.");
        $file = "./invoices/" . $invoiceNumber. ".pdf";
        $pdf->Output($file, 'F');   //save file
    
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'mailhub.eait.uq.edu.au';  // Specify main and backup SMTP servers
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 25;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('noreply@markethub.com', 'MarketHub');
            $mail->addAddress('nicklascook@hotmail.com', $username);     // Add a recipient
            $mail->addReplyTo('support@markethub.com', 'MarketHub Support');

            //Attachments
            $mail->addAttachment($file, 'invoice - ' . $invoiceNumber.'.pdf');         // Add invoice as attachment

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'MarketHub Purchase Succesful - ' . $invoiceNumber;
            $mail->Body    = '<h2>Your order is on its way, ' .$username. '!</h2><br><br><h3>Thank you for shopping on MarketHub! Your order has been marked as shipped. 
            We hope you enjoy your purchase.</h3>  <br><br><br> Your invoice for this purchase has been attached to this email. Please do not hesitate to contact
            our support team if any issues arise.';
            $mail->AltBody = 'Your order is on its way. An invoice for the purchase has been attached to this email.';

            $mail->send();
            echo 'Message has been sent';

            $_SESSION['message'] = "Item purchased! An invoice has been sent to your email.";


        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }








 
    
   

 

  
    

?>