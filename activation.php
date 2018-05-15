<?php
    session_start();
    require "db.php";
    require_once 'vendor/autoload.php';

    function sendVerificationEmail(){
            // Create the Transport
            $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
                    ->setUsername('cooknicklas@gmail.com')
                    ->setPassword('seveneleven123')
                    ->setStreamOptions(array(
                     'ssl' => array(
                     'allow_self_signed' => true, 
                     'verify_peer' => false)));

            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);

            $to = $_SESSION['email'];
            $subject = "Account Verification - MarketHub.com";
            $message = "
            Hello " . $_SESSION['username'] . ",
            
            Thanks for signing up to MarketHub!
            
            Please click the link below to verify your account, if this does not work, please paste the link in your address bar.
            http://localhost/infs3202/activation.php?email=" . $_SESSION['email'] . "&hash=" . $_SESSION['hash'];

            // Create a message
            $message = (new Swift_Message($subject))
            ->setFrom(['cooknicklas@gmail.com' => 'MarketHub Team'])
            ->setTo([$to => $_SESSION['username']])
            ->setBody($message)
            ;

            // Send the message
            $result = $mailer->send($message);

    }

?>
<html>
    <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MarketHub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway" rel="stylesheet">
    
    
</head>
<body>
    <!-- Top Navigation Header -->
    <nav class="nav">
        <div class="logoContainer">
           <a href="index.php"> <h1>MarketHub<span class="icon-shopping-cart"></span></h1></a>
      

        </div>
        <div class="loginContainer">
            <?php
                if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']){
                    echo "<a href='account.php'><span class='icon-user'></span>".$_SESSION['username'] . "</a>";
                } else{
                    echo "<a href='signup.php' >Sign Up</a>
                    /
                    <a href='login.php' >Login</a>";

                }
            ?>
            
        </div>
    </nav>

    <?php
        if ( isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['hash']) && !empty($_GET['hash'])){
                $email = $_GET['email'];
                $hash = $_GET['hash'];

                $result = mysqli_query($mysqli, "SELECT * FROM users WHERE email='$email' AND hash='$hash' AND activated='0'");


                if($result->num_rows == 0){
                    echo "<p class='activationText' style=''>Your account has <strong>already been activated</strong> or the URL is invalid. (No account found with matching email and/or hash)</p>";
                } else {
                    
                    $sqlEntry = "UPDATE users SET activated='1' WHERE email='$email'";
                    if ($mysqli->query($sqlEntry)){
                        $_SESSION["activated"] = 1;
                        echo "<p class='activationText'>Your account has been activated. <br> <a href='index.php>Go Home</a>'</p>";
                    }
                }

            } elseif(isset($_GET['sendVerify']) && $_GET['sendVerify'] && isset($_SESSION["activated"]) && !$_SESSION["activated"]){
                sendVerificationEmail();
                echo "<p class='activationText' style=''>A confirmation link has been sent to <span>".$_SESSION['email'].".</span> Please confirm your account by clicking on the link included!</p>";
            }
            elseif(isset($_SESSION["activated"]) && !$_SESSION["activated"]){
                echo "<p class='activationText' style=''>Your account is not activated <a href='activation.php?sendVerify=true'><button class='btn btn-resend'>Resend Email</button></a></p>";
            }
            else{
                echo "<p class='activationText' style=''>Your account has <strong>already been activated</strong> or the URL is invalid.</p>";
            }

    ?>



</body>

</html>
