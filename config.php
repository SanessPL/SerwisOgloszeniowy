<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "serwis_ogloszeniowy";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("ERROR: Could not connect. " . $conn->connect_error);
    }
?>