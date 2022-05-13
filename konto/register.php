<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Rejestracja</title>
</head>
<body>
    <?php require_once "../navbar.php"; ?>
    <?php
    /**
     *   php code 
     * Register system that check is our login already taken in database and if not create new user when all assumptions are filled.
     * access:	private
     * author: 	Patryk Kurzątek
     */

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("Location: index.php");
        exit;
    }

    $username = $password = $confirm_password = $email = "";
    $username_err = $password_err = $confirm_password_err = $email_err = "";

    function register() {
        require_once "../config.php";

        global $username, $password, $confirm_password, $email;
        global $username_err, $password_err, $confirm_password_err, $email_err;

        if (empty(trim(@$_POST["username"]))) {
            $username_err = "Wprowadz nazwe uzytkownika.";
        } elseif (preg_match("/[^A-z0-9_]/", $_POST["username"])) {
            $username_err = "Nazwa użytkownika może zawierać tylko litery, cyfry i znak \"_\".";
        } else {
            $sql = "SELECT id FROM users WHERE username = ?";

            if($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $param_username);
            }

            $param_username = trim($_POST["username"]);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $username_err = "Ta nazwa uzytkownika jest juz zajeta.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo("cos sie wywalilo");
            }

            $stmt->close();
        }

        if (empty(trim(@$_POST["email"]))) {
            $email_err = "Wprowadz email.";
        } else {
            $sql = "SELECT id FROM users WHERE email = ?";

            if($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $param_email);
            }

            $param_email = trim($_POST["email"]);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $email_err = "Ten email jest już w użyciu.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo("cos sie wywalilo");
            }

            $stmt->close();
        }

        if (empty(trim(@$_POST["password"]))) {
            $password_err = "Proszę podać hasło.";
        } elseif (strlen(trim($_POST["password"])) < 6) {
            $password_err = "Hasło musi mieć conajmniej 6 znaków długości.";
        } else {
            $password = trim($_POST["password"]);
        }

        if (empty(trim(@$_POST["confirm_password"]))) {
            $confirm_password_err = "Potwierdź hasło.";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($password_err) && ($password != $confirm_password)) {
                $confirm_password_err = "Hasła się nie zgadzają.";
            }
        }

        if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
            $sql = "INSERT INTO users (username, email, first_name, last_name, password) VALUES (?, ?, ?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sssss", $param_username, $param_email, $param_firstname, $param_lastname, $param_password);

                $param_username = $username;
                $param_firstname = $_POST["firstname"];
                $param_lastname = $_POST["lastname"];
                $param_email = $email;
                $param_password = password_hash($password, PASSWORD_DEFAULT);

                if ($stmt->execute()) {
                    header("location: login.php");
                } else {
                    echo("cos sie wysypalo");
                }

                $stmt->close();
            }
        }
        
        $conn->close();

    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        register();
    }
    
    ?>

    <div class="page">
        <div class="content center">
            <form class="register" action="#" method="post">
                Masz już konto? <a href="./login">Zaloguj się</a><br>
                <span class="error"><?php echo($username_err) ?></span>
                <span class="error"><?php echo($email_err) ?></span>
                <span class="error"><?php echo($password_err) ?></span>
                <span class="error"><?php echo($confirm_password_err) ?></span>
                
                <input type="text" name="username" class="username" placeholder="Nazwa Użytkownika"><br>
                <input type="text" name="firstname" class="firstname" placeholder="Imię"><br>
                <input type="text" name="lastname" class="lastname" placeholder="Nazwisko"><br>
                <input type="email" name="email" class="email" placeholder="E-mail"><br>
                <input type="password" name="password" class="password" placeholder="Hasło"><br>
                <input type="password" name="confirm_password" class="confirm_password" placeholder="Potwierdź Hasło"><br>
                    
                <button type="submit">Zarejestruj się</button>
            </form>
        </div>
    </div>

    <?php include_once HOME_URL."/footer.php" ?>
</body>
</html>