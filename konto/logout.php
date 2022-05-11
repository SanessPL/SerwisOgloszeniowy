<?php
    /**
    * Code that end session and logout user
    * access:	private
    * author: 	Patryk Kurzątek
    */
    session_start();

    $_SESSION = [];

    header("location: login.php");
    exit;
?>