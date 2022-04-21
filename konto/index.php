<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Użytkownika</title>
</head>
<body>
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
</body>
</html>