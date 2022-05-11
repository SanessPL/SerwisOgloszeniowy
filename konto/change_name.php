<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Zmiana imienia</title>
</head>
<body>
    <?php
    session_start();

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }
    
    $first_name = $last_name = "";
    $first_name_err = $last_name_err = "";
    
    function changeName() {
        require_once "../config.php";
        
        global $first_name, $last_name;
        global $first_name_err, $last_name_err;

        if (empty(trim(@$_POST["first_name"]))) {
            $first_name_err = 'Proszę wprowadzić nowe imię.';
        } else {
            $sql = "SELECT first_name FROM users WHERE id = ?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $param_id);
            }

            $param_id = $_SESSION["id"];

            if ($stmt->execute()) {
                $stmt->bind_result($name);

                if ($stmt->num_rows == 1) {
                    if ($name === $_POST["first_name"]) {
                        $first_name_err = 'Podane imię znajduje się już w bazie.';
                    } else {
                        $first_name = trim($_POST["first_name"]);
                    }
                } else {
                    $first_name = trim($_POST["first_name"]);
                }

                $stmt->close();
            }
        }

        if (empty(trim(@$_POST["last_name"]))) {
            $first_name_err = 'Proszę wprowadzić nowe nazwisko.';
        } else {
            $sql = "SELECT last_name FROM users WHERE id = ?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $param_id);
            }

            $param_id = $_SESSION["id"];

            if ($stmt->execute()) {
                $stmt->bind_result($name);

                if ($stmt->num_rows == 1) {
                    if ($name === $_POST["last_name"]) {
                        $last_name_err = 'Podane nazwisko znajduje się już w bazie.';
                    } else {
                        $last_name = trim($_POST["last_name"]);
                    }
                } else {
                    $last_name = trim($_POST["last_name"]);
                }

                $stmt->close();
            }
        }

        if (empty($first_name_err) && empty($last_name_err)) {
            $sql = "UPDATE users SET first_name = ?, last_name = ? WHERE id = ?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sss", $param_first_name, $param_last_name, $param_id);
            }

            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_id = $_SESSION["id"];

            if ($stmt->execute()) {
                header("location: settings.php");
            } else {
                echo("Coś poszło nie tak.");
            }

            $stmt->close();
        }

    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        changeName();
    }

    ?>

    <?php require_once "boostrap.php" ?>
    <?php require_once HOME_URL."navbar.php" ?>

    <div class="page">
        <div class="content center">
            <span class="error"><?php echo($first_name_err) ?></span>
            <span class="error"><?php echo($last_name_err) ?></span>
            <form action="#" method="post">
                <input type="text" name="first_name" placeholder="Imię"><br>
                <input type="text" name="last_name" placeholder="Nazwisko"><br>
                <input type="submit" value="Zmień dane">
            </form>
        </div>
    </div>
</body>
</html>