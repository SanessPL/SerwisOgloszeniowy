<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php 
/** Do ogarniecia: system dodawania zdjęć, */
if(isset($_POST['add_offer']) && $_POST['add_offer'] == 1){
    print_r($_FILES);
    die;
    }
?> 
<body> 
<form action="#" method="post" enctype="multipart/form-data">
        <div>
            <input type="text" name="title" placeholder="Tytuł (50)">
        </div>
        <div>
            <input type="text" name="price" placeholder="Cena ">
        </div>
        <div>
            <input type="text" name="offer_description" placeholder="Opis ogłoszenia (255)">
        </div>
        <br>
        <div>
         Zdjęcie:  <input type="file" name="offer_photos"> 
        </div>
        <br><button type="submit" >Dodaj ogłoszenie </button>
        <input type="hidden" value="1" name="add_offer">
    </form>
</body>
</html>