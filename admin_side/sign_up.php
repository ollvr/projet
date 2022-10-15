<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <style>
        body {
            background-color: black;
            font-size: large;
        }

        h1{ 

            color:crimson;
            text-align: center;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }

        form button {
            background: black;
            color: crimson;
            border-radius: 7px;
            border: 1px solid magenta;
            width: 134px;
            height: 30px;
        }

        form label {
            color:cadetblue;
        }

        form input { 
            border: 1px solid magenta;
        }

        a{ 
            text-decoration: none;
            color:crimson;
        }
       
    </style>
</head>
<body>
    <h1>Admin a inscrire </h1>
    <form method="post">
        <label for="Nom">Nom admin</label>
        <br>
        <br>
        <input type="text" name="nom" id="Nom" required>
        <br>
        <br>
        <label for="Email">admin email</label>
        <br>
        <br>
        <input type="email" name="email" id="Email" required>
        <br>
        <br>
        <label for="Pass">Admin mot de passe </label>
        <br>
        <br>
        <input type="password" name="pass" id="Pass">
        <br>
        <br>
        <button type="submit" name="inscri_admin">inscri admin </button>
    </form>
        <br>
        <br>
    <a href="../admin_side/Sign_in.php" target="_blanc">j'ai deja un compte </a>
</body>
</html>


<?php 


if(isset($_POST["inscri_admin"]))
{

   
    $username = "root";
    $password = "root";
    $con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");


    $admin_nom = htmlspecialchars($_POST["nom"],ENT_COMPAT);
    $admin_email = htmlspecialchars($_POST["email"],ENT_COMPAT);
    $admin_pass = htmlspecialchars($_POST["pass"],ENT_COMPAT);

    $admin_pass = password_hash($admin_pass, PASSWORD_DEFAULT);
    
    $insert_admin = $con->prepare("INSERT INTO adminsit (nom,email,motpasse) VALUES(:nom,:email,:mp) ");
    $insert_admin->bindParam("nom",$admin_nom,PDO::PARAM_STR);
    $insert_admin->bindParam("email",$admin_email,PDO::PARAM_STR);
    $insert_admin->bindParam("mp",$admin_pass,PDO::PARAM_STR);


    if(($admin_nom != "") && ($admin_email != "") && ($admin_pass != ""))
    { 
        
        if($insert_admin->execute())
        { 
            echo "<h3 style=color:green;text-align:center;margin-top:100px;>"  . "admin inscri avec succes" . "</h3>";
        }
        else 
        { 
            echo "<h3 style=color:red;text-align:center;margin-top:100px;>"  . "erreur quelque part  " . "</h3>";
        }
    }
    else 
    { 
        echo "<h3 style=color:red;text-align:center;margin-top:100px;>"  . "notez bien que les champs ne soient pas vides " . "</h3>";
    }


}






?>