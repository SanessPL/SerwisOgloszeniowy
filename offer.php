<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Ogłoszenie <?php echo($_GET["id"]); ?></title>
</head>
<body>
    <?php include_once "navbar.php"; ?>
    <div class="page center">
        <?php
        if (!isset($_GET["id"]) || (empty($_GET["id"]) && $_GET["id"] != 0)) {
            header("location: index.php");
            exit;
        }

        require_once "config.php";

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

        function displayOffer() {
            global $conn;

            $id = $_GET["id"];

            $sql = "SELECT user_id, title, offer_description, created_at FROM offers WHERE id = $id";
            
            $res = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($res) == 0) {
                echo("<div class=\"info\">");
                echo("<div class=\"error\">"."To ogłoszenie nie istnieje lub zostało usunięte."."</div>");
                echo("<a href=\"".HOME_URL."\">Wróć</a>");
                echo("</div>");

                return;
            }

            echo("<div class=\"offer big\">");

            while ($row = mysqli_fetch_array($res)) {
                $author = getUser($row["user_id"]);
                
                echo("<div class=\"title\">".$row["title"]."</div>");
                    
                if ($author) {
                    echo("<div class=\"author\">".$author["first_name"]." ".$author["last_name"]."</div>");
                }

                echo("<div class=\"description\">".$row["offer_description"]."</div>");
                echo("<div class=\"createdAt\">".$row["created_at"]."</div>");
            }

            echo("</div>");            
        }

        displayOffer();
        ?>
    </div>
    <?php include_once "./footer.php" ?>
</body>
</html>