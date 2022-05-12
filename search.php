<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Wyszukiwanie</title>
</head>
<body>
    <?php $searchValue = $_GET["s"]; ?>
    
    <?php
    include_once "config.php";

    /**
     * Funkcja wyszukuje ogłoszenia z bazy danych po zadanym stringu;
     * 
     * @param  string  $str  Wyszukiwany string
     * @return array   tablica zawierające znalezionymi ogłoszeniami
     * @author Patryk Kurzątek
     */
    function szukaj($str) {
        global $conn;

        if (empty($str)) {
            return null;
        }

        $sql = "SELECT id, user_id, title, offer_description, created_at FROM offers WHERE title LIKE '%$str%' OR offer_description LIKE '%$str%'";

        $res = mysqli_query($conn, $sql);

        $rows = [];

        while ($row = mysqli_fetch_array($res)) {
           array_push($rows, $row);
        }

        return $rows;
    }

    function wyswietl() {
        $offers = szukaj($_GET["s"]);

        if ($offers == null) {
            echo("<div class=\"warn\">Nie znaleziono ogłoszeń.</div>");
            return;
        }

        foreach ($offers as $offer) {
            $description = $offer["offer_description"];

            if (strlen($description) > MAX_DESCRIPTION_LENGTH) {
                $description = substr($description, 0, MAX_DESCRIPTION_LENGTH - 3) . '...';
            }
            
            $id = $offer["id"];
            $href = HOME_URL."offer.php?id=$id";

            $author = getUser($offer["user_id"]);

            echo("<div class=\"offer\">");
            echo("<a class=\"title\" href=\"$href\">".$offer["title"]."</a>");
            
            if ($author) {
                echo("<div class=\"author\">"."by: ".$author["first_name"]." ".$author["last_name"]." (".$author["username"].") "."</div>");
            }

            echo("<div class=\"description\">".$description."</div>");
            echo("<div class=\"createdAt\">".$offer["created_at"]."</div>");
            echo("</div>");
        }
    }
    ?>

    <?php include_once "boostrap.php"; ?>
    <?php include_once HOME_URL."navbar.php"; ?>

    <div class="page">
        <div class="content center">
            <?php wyswietl() ?>
        </div>
    </div>

    <?php include_once "./footer.php" ?>
</body>
</html>