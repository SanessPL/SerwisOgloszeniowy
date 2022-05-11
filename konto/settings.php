<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Ustawienia</title>
</head>
<body>
    <?php
    session_start();
    
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }
    ?>

    <?php require_once "boostrap.php" ?>
    <?php require_once "../navbar.php" ?>

    <div class="page">
        <div class="content center">
            <a href="change_name.php">Zmień imię</a><br>
            <a href="change_password.php">Zmień hasło</a><br>
            <a href="logout.php">Wyloguj</a>
        </div>
    </div>
    
    <?php include_once HOME_URL."/footer.php" ?>
</body>
</html>