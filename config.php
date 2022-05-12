<?php
    define("DB_SERVERNAME", "localhost");
    define("DB_USERNAME", "root");
    define("DB_PASSWORD", "");
    define("DB_DBNAME", "serwis_ogloszeniowy");

    $conn = mysqli_connect(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_DBNAME);

    if (mysqli_connect_error()) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    define("MAX_DESCRIPTION_LENGTH", 200);

    /**
     * Funkcja wyjmuje z bazy danych użytkownika o podanym ID
     * 
     * @param   int     $id     ID użytkownika
     * @return  object  obiekt zawierający dane użytkownika
     * @author  Patryk Kurzątek
     */
    function getUser($id) {
        global $conn;

        $sql = "SELECT id, username, first_name, last_name FROM users WHERE id = $id";

        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) == 0) {
            return null;
        }

        $row = mysqli_fetch_array($res);

        return $row;
    }
?>