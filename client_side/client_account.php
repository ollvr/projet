<?php

session_start();

?>

<?php
include './ourclient_form.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>compte client </title>
    <style>
        .visit{ 
            text-align: center;
        }

        .visit a { 
            color:crimson;
            text-decoration: none;
            font-size: large;
        }
    </style>
</head>
<body>
    <div class="visit">
        <a href="../client_side/mon_profil.php"> visiter ton profil </a>
    </div>
    
</body>
</html>