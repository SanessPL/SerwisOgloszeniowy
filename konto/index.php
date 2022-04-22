<!DOCTYPE html>
<html lang="en">
<head>
    <style>
    body{
        background-color:#1434A4 ;
    }
    *{
    margin:0;
    padding:0;
    }
    #strona{
        
    }
    #siteplace{
    position:relative;
    width:80%;
    background-color:#F0F0F0;
    margin:auto;
    top:100px;
    height:1000px;
    }
    #logo_ogloszenia{
        position:absolute;
        width:40%;
        top:-150px;
        left:50px;
    }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Użytkownika</title>
</head>


<body>
<div id="strona">
<img src="zdjecia/ogloszenia.png" alt = "Ogloszenia.pl" id="logo_ogloszenia">
<div id="siteplace">
    



    <?php
    session_start();

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }
    ?>

    <a href="logout.php">Wyloguj</a><br>
    <a href="offers.php">Dodaj Ogłoszenie</a><br>
    <a href="settings.php">Ustawienia Konta</a>
</div>
</div>
</body>
</html>