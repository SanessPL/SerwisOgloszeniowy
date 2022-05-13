<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Logowanie</title>
</head>
<body>
    <?php
    /**
     * Login system.
    * 
    * @access	private
    * @author 	Patryk Kurzątek
    */
    if (!isset($_SESSION)) {
        session_start();
    }

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("Location: index.php");
        exit;
    }

    $username = $password = "";
    $username_err = $password_err = $login_err = "";

    function login() {
        require_once("../config.php");

        global $username, $password;
        global $username_err, $password_err, $login_err;


        if (empty(trim(@$_POST["username"]))) {
            $username_err = "Proszę podać nazwę użytkownika.";
        } elseif (preg_match("/[^A-z0-9_]/", $_POST["username"])) {
            $username_err = "Nazwa użytkownika może zawierać tylko litery, cyfry i znak \"_\".";
        }
        else {
            $sql = "SELECT id FROM users WHERE username = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                $stmt->bind_param("s", $param_username);
            }

            $param_username = trim($_POST["username"]);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if ($stmt->num_rows == 1) {
                    $username = $param_username;
                } else {
                    $login_err = "Nazwa użytkownika lub hasło są nieprawidłowe.";
                }
            } else {
                echo("Coś poszło nie tak.");
            }

            mysqli_stmt_close($stmt);
        }

        if (empty(trim(@$_POST["password"]))) {
            $password_err = "Wprowadź hasło.";
        } elseif (strlen(trim($_POST["password"])) < 6) {
            $password_err = "Hasło musi mieć conajmniej 6 znaków długości.";
        } else {
            $password = trim($_POST["password"]);
        }

        if (empty($username_err) && empty($password_err)) {
            $sql = "SELECT id, username, first_name, last_name, password FROM users WHERE username = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                $stmt->bind_param("s", $param_username);
            }

            $param_username = $username;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if ($stmt->num_rows == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $first_name, $last_name, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["first_name"] = $first_name;
                            $_SESSION["last_name"] = $last_name;
                            $_SESSION["username"] = $username;

                            header("location: index.php");
                        } else {
                            $login_err = "Nieprawidłowa nazwa użytkownika lub hasło.";
                        }
                    }
                } else {
                    $login_err = "Nieprawidłowa nazwa użytkownika lub hasło.";
                }
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        login();
    }
    
    ?>

    <?php include_once "boostrap.php"; ?>
    <?php include_once HOME_URL."navbar.php"; ?>
    <div class="page">
        <div class="content center">
            <form class="login" action="" method="post">
                Nie posiadasz konta? <a href="./register">Zarejestruj się</a><br>
                <span class="error"><?php if (!empty($login_err)) echo($login_err."<br>") ?></span>
                <span class="error"><?php if (!empty($username_err)) echo($username_err."<br>") ?></span>
                <span class="error"><?php if (!empty($password_err)) echo($password_err."<br>") ?></span>

                <input class="username" type="text" name="username" placeholder="Nazwa Użytkownika" value="<?php echo($username) ?>"><br>
                <input class="password" type="password" name="password" placeholder="Hasło"><br>
                <button type="submit">Zaloguj się</button>
            </form>
        </div>
    </div>
    <?php include_once HOME_URL."/footer.php" ?>
</body>
</html>