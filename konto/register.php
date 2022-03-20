<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
</head>
<body>
    <?php
        require_once "../config.php";

        $username = $password = $confirm_password = $email = "";
        $username_err = $password_err = $confirm_password_err = $email_err = "";

        if (empty(trim(@$_POST["username"]))) {
            $username_err = "Wprowadz nazwe uzytkownika.";
        } elseif (!preg_match('//', trim(@$_POST["username"]))) {
            
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
        } elseif (!preg_match('//', trim(@$_POST["username"]))) {
            
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
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sss", $param_username, $param_email, $param_password);

                $param_username = $username;
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
    ?>

    <form action="#" method="post">
        <div>
            <input type="text" name="username" placeholder="Nazwa Użytkownika">
            <span class="error"><?php echo($username_err) ?></span>
        </div>
        <div>
            <input type="email" name="email" placeholder="E-mail">
            <span class="error"><?php echo($email_err) ?></span>
        </div>
        <div>
            <input type="password" name="password" placeholder="Hasło">
            <span class="error"><?php echo($password_err) ?></span>
        </div>
        <div>
            <input type="password" name="confirm_password" placeholder="Potwierdź Hasło">
            <span class="error"><?php echo($confirm_password_err) ?></span>
        </div>
        <button type="submit">Zarejestruj się</button>
    </form>
</body>
</html>