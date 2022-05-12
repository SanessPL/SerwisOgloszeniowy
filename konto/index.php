<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Panel Użytkownika</title>
</head>
<body>
    <?php if (session_status() == PHP_SESSION_NONE) session_start() ?>
    <?php
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }
    ?>
    <?php include_once "boostrap.php"; ?>
    <?php include_once HOME_URL."navbar.php"; ?>

    <div class="page">
        <div class="content center">
            <?php
                echo("<div class=\"header\">".$_SESSION["first_name"]." ".$_SESSION["last_name"]." (".$_SESSION["username"].")"."</div>");
            ?>
            <a href="settings.php">Ustawienia Konta</a><br>
            <a href="logout.php">Wyloguj</a><br>
        </div>
    </div>    
    <?php include_once HOME_URL."/footer.php" ?>
</body>
</html>