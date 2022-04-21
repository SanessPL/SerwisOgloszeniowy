<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php 
    require_once "../config.php";
    session_start();

        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("location: login.php");
            exit;
        }

    if(isset($_POST['add_offer']) && $_POST['add_offer'] == 1){
       $title = $_POST['title'];
       $id = $_SESSION["id"];
       var_dump($id);
       $description = $_POST['offer_description'];
       $zapytanie = "INSERT INTO offers (title, user_id , offer_description) VALUES ('$title','$id','$description')";
       $wynik = mysqli_query($conn, $zapytanie);
       if ($wynik) {
	    	echo("Prawidłowo dodano ogłoszenie");	
	   }
    }
?> 
<body> 
<form action="#" method="post" enctype="multipart/form-data">
        <div>
            <input type="text" name="title" placeholder="Tytuł (50)">
        </div>
        <div>
            <input type="text" name="offer_description" placeholder="Opis ogłoszenia (255)">
        </div>
        <br><button type="submit" >Dodaj ogłoszenie </button>
        <input type="hidden" value="1" name="add_offer">
    </form>
</body>
</html>