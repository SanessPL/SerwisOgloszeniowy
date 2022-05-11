<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "serwis_ogloszeniowy";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $conn_error = mysqli_connect_error();

    if (mysqli_connect_error()) {
        die("ERROR: Could not connect. " . $conn->connect_error);
    }

    define("MAX_DESCRIPTION_LENGTH", 200);
    define("OFFERS_PER_ROW", 4);
?>