<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
</head>
<body>
    <?php
    /**
    *   php code 
    * Login system in code that check is password and login correct.
    * access:	private
    * author: 	Patryk Kurzątek
    */
        session_start();

        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            header("location: index.php");
            exit;
        }

        require_once "../config.php";

        $username = $password = '';
        $username_err = $password_err = '';

        if (empty(trim(@$_POST["username"]))) {
            $username_err = "Wprowadź nazwę użytkownika";
        } elseif (false) {}
        
        else {
            $sql = "SELECT id FROM users WHERE username = ?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $param_username);
            }

            $param_username = trim($_POST["username"]);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $username = $param_username;
                } else {
                    $password_err = "Nazwa użytkownika lub hasło są nieprawidłowe.";
                }
            } else {
                echo("cos sie wysypalo");
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

        if (empty($username_err) && empty($password_err)) {
            $sql = "SELECT id, username, password FROM users WHERE username = ?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $param_username);
            }

            $param_username = $username;

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
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


    ?>

    <form action="" method="post">
        <?php 
        if (!empty($login_err)) {
            echo '<span class="error">' . $login_err . '</span>';
        }
        ?>
        <div>
            <input type="text" name="username" placeholder="Nazwa Użytkownika">
            <span class="error"><?php echo($username_err) ?></span>
        </div>
        <div>
            <input type="password" name="password" placeholder="Hasło">
            <span class="error"><?php echo($password_err) ?></span>
        </div>
        <button type="submit">Zaloguj się</button>
    </form>
</body>
</html>