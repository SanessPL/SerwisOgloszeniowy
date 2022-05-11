<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Zmiana hasła</title>
</head>
<body>
    <?php
    session_start();

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }

    $password = $confirm_password = "";
    $password_err = $confirm_password_err = "";

    function changePassword() {
        require_once "../config.php";

        global $password, $confirm_password;
        global $password_err, $confirm_password_err;

        if (empty($_POST["password"])) {
            $password_err = "Proszę wprowadzić nowe hasło.";
        } elseif (strlen($_POST["password"]) < 6) {
            $password_err = "Hasło musi mieć conajmniej 6 znaków.";
        } else {
            $password = trim($_POST["password"]);
        }

        if (empty($_POST["confirm_password"])) {
            $confirm_password_err = "Proszę potwierdzić nowe hasło.";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($password_err) && ($password != $confirm_password)) {
                $confirm_password_err = "Hasła nie są takie same.";
            }
        }

        if (empty($password_err) && empty($confirm_password_err)) {
            $sql = "UPDATE users SET password = ? WHERE id = ?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("si", $param_password, $param_id);

                $param_password = password_hash($password, PASSWORD_DEFAULT);
                $param_id = $_SESSION["id"];

                if ($stmt->execute()) {
                    header("location: index.php");
                    exit;
                } else {
                    echo("Coś poszło nie tak. Spróbuj ponownie później.");
                }
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        changePassword();
    }

    ?>

    <?php require_once "boostrap.php" ?>
    <?php require_once HOME_URL."navbar.php" ?>

    <div class="page">
        <div class="content center">
            <form action="" method="post">
                <div>
                    <input type="password" name="password" id="password" placeholder="Hasło">
                    <span class="error"><?php echo $password_err; ?></span>
                </div>
                <div>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Potwierdź hasło">
                    <span class="error"><?php echo $confirm_password_err; ?></span>
                </div>
                <div>
                    <input type="submit" value="Zmień hasło">
                </div>
            </form>
        </div>
    </div>


</body>
</html>