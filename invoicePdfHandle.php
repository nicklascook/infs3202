<?php
    session_start();
    require("db.php");
    include 'vendor/autoload.php';

    $parser = new \Smalot\PdfParser\Parser();
    $pdf    = $parser->parseFile($_FILES['pdf']['tmp_name']);
    
    $text = $pdf->getText();

    preg_match_all('/Item Id: ([\d]+)/',$text,$matches);
    $itemId = $matches[1][0];

    $arr = explode('INVOICE FOR ITEM:', $text);
    $arr = explode('Seller:', $arr[1]);
    $itemName = $arr[0];

    $returnArray = array($itemName, $itemId);
    echo json_encode($returnArray);

?>