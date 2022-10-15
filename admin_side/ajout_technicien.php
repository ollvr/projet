<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout technicien </title>

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


        .a_retour  { 
            text-align: center;
        }

        a{ 
            text-decoration: none;
            color:crimson;
            font-size: larger;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
    </style>
</head>
<body>
<h1>Ajout d'un technicien </h1>
    <form method="post">
        <label for="Nom">Nom technicien</label>
        <br>
        <br>
        <input type="text" name="nom" id="Nom" required>
        <br>
        <br>

        <label for="Nom">Specialite du technicien</label>
        <br>
        <br>

        <input type="text" name="sp" id="Sp" required>
        <br>
        <br>


        <label for="Email">Email </label>
        <br>
        <br>
        <input type="email" name="email" id="Email" required>
        <br>
        <br>
        <label for="Pass">Technicien mot de passe </label>
        <br>
        <br>
        <input type="password" name="pass" id="Pass">
        <br>
        <br>
        <button type="submit" name="inscri_tech"> Ajouter technicien </button>
    </form>
    <br>
    <br>

    <div class="a_retour">
        <a href="../admin_side/admin_account.php" target="_blanc"> retour a le menu </a>
    </div>
    
</body>
</html>

<?php 
if(isset($_POST["inscri_tech"]))
{ 

    $username = "root";
    $password = "root";
    $con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");


    
    $tech_nom = htmlspecialchars($_POST["nom"],ENT_COMPAT);
    $tech_sp = htmlspecialchars($_POST["sp"],ENT_COMPAT);
    $tech_email = htmlspecialchars($_POST["email"],ENT_COMPAT);
    $tech_pass = htmlspecialchars($_POST["pass"],ENT_COMPAT); 


    $tech_pass = password_hash($tech_pass, PASSWORD_DEFAULT);

    $insert_tech = $con->prepare("INSERT INTO technicien (tech_nom,specialite,email,mp) VALUES (:nom,:sp,:email,:mp) ");
    $insert_tech->bindParam("nom",$tech_nom,PDO::PARAM_STR);
    $insert_tech->bindParam("sp",$tech_sp,PDO::PARAM_STR);
    $insert_tech->bindParam("email",$tech_email,PDO::PARAM_STR);
    $insert_tech->bindParam("mp",$tech_pass,PDO::PARAM_STR);


    if(($tech_nom != "") && ($tech_sp != "") && ($tech_email != "") && ($tech_pass != ""))
    { 
        if($insert_tech->execute()){ 
            echo "<h3 style=color:green;text-align:center;margin-top:100px;>"  . "technicien  ajouter avec succes" . "</h3>";
            header("refresh:4,url=../admin_side/admin_account.php");
            exit;
        }
        else
        { 
            echo "<h3 style=color:red;text-align:center;margin-top:100px;>"  . "error" . "</h3>";
            header("refresh:4,url=../admin_side/admin_account.php");
            exit;
        }
    }
    else
    { 
        echo "<h3 style=color:red;text-align:center;margin-top:100px;>"  . "les champs ne doivent pas etre vide" . "</h3>";
        header("refresh:4,url=../admin_side/admin_account.php");
        exit;
    }

}











