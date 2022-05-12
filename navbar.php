<!DOCTYPE html>
<html lang="en">
<body>
    <?php if (session_status() == PHP_SESSION_NONE) session_start() ?>
    <?php require_once "./boostrap.php"?>
    <nav class="menu">
        <a class="item logo" href="<?php echo HOME_URL ?>"><img src="<?php echo HOME_URL."/img/logo.png"; ?>" alt="ogloszenia"></a>
        <a class="item profile" href="<?php
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false) echo(HOME_URL."konto/login.php");
        else echo(HOME_URL."konto/");
        ?>">
            <div class="name"><?php 
            if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false) echo("Zaloguj");
            else echo($_SESSION["first_name"]." ".$_SESSION["last_name"]);
            ?></div>
        </a>
    
        <?php
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
            echo "<a href=\"".HOME_URL."konto/offers.php\" class=\"item addOffer\">Dodaj ogłoszenie</a>";
        }
        ?>

        <form action="<?php echo HOME_URL ?>search.php" class="item search">
            <input type="text" name="s" placeholder="Wyszukaj" class="toSearch" value="<?php if (isset($searchValue)) echo $searchValue ?>"> 
            <button type="submit">Szukaj</button>
        </form>
    </nav>
</body>
</html>