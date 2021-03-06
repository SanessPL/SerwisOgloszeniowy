<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Dodaj Ogłoszenie</title>
</head>
<body>
    <?php 
    function addOffer() {
        require_once "../config.php";
        session_start();

        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("location: login.php");
            exit;
        }

        $title = $_POST['title'];
        $id = $_SESSION["id"];
        $description = $_POST['offer_description'];
        $zapytanie = "INSERT INTO offers (title, user_id, offer_description) VALUES ('$title','$id','$description')";
        $wynik = mysqli_query($conn, $zapytanie);
        if ($wynik) {
            header("location: thanks_for_offer.php");
            exit;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        addOffer();
    }

    ?>

    <?php require_once "boostrap.php" ?>
    <?php require_once HOME_URL."navbar.php" ?>

    <div class="page">
        <div class="content center">
            <form class="addOffer" action="" method="post">
                <input type="text" name="title" placeholder="Tytuł"><br>
                <textarea name="offer_description" placeholder="Opis ogłoszenia"></textarea><br>
                <button type="submit" >Dodaj ogłoszenie </button>
            </form>
        </div>
    </div>

    <?php include_once HOME_URL."/footer.php" ?>
</body>
</html>