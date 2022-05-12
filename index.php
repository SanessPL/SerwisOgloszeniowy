<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Serwis Ogłoszeniowy</title>
</head>
<body>
    <?php session_start(); ?>
    <?php include_once "./navbar.php" ?>
    
    <div class="page">
        <div class="content center">
            <?php
            require_once "./config.php";

            function getUser($id) {
                global $conn;

                $sql = "SELECT first_name, last_name FROM users WHERE id = $id";

                $res = mysqli_query($conn, $sql);

                if (mysqli_num_rows($res) == 0) {
                    return null;
                }

                $row = mysqli_fetch_array($res);

                return $row;
            }

            function displayOffers() {
                global $conn;
    
                $sql = "SELECT id, user_id, title, offer_description, created_at FROM offers";
                
                $res = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($res) == 0) {
                    echo("<div class=\"info\">");
                    echo("<div class=\"warn\">"."Nie ma jeszcze żadnych ogłoszeń!"."</div>");
                    echo("</div>");
    
                    return;
                }
    
                echo("<center>");
                while ($row = mysqli_fetch_array($res)) {
                    $description = $row["offer_description"];

                    if (strlen($description) > MAX_DESCRIPTION_LENGTH) {
                        $description = substr($description, 0, MAX_DESCRIPTION_LENGTH - 3) . '...';
                    }

                    $id = $row["id"];
                    $href = HOME_URL."offer.php?id=$id";

                    $author = getUser($row["user_id"]);

                    echo("<div class=\"offer\">");
                    echo("<a class=\"title\" href=\"$href\">".$row["title"]."</a>");
                    
                    if ($author) {
                        echo("<div class=\"author\">".$author["first_name"]." ".$author["last_name"]."</div>");
                    }

                    echo("<div class=\"description\">".$description."</div>");
                    echo("<div class=\"createdAt\">".$row["created_at"]."</div>");
                    echo("</div>");
                }
                echo("</center>");

                mysqli_close($conn);
            }
    
            displayOffers();
            ?>
        </div>
    </div>
    
    <?php include_once "./footer.php" ?>
</body>
</html>