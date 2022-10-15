<?php

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer mon compte </title>

    <style>
          body{ 
            background-color: black;
        }

        #m{ 
            background: black;
            color: crimson;
            border-radius: 7px;
            border: 1px solid magenta;
            width: 134px;
            height: 30px;
        }

        h3{ 
            color: cadetblue;
        }
    </style>
</head>
<body>
<h3>Suppression du compte </h3>
<form  method="post" id="formsend">
<input type="email" name="ancien_email" placeholder="mettez votre email" required>
<br>
<br>
<input type="password" name="ancien_motpasse" placeholder="mettez votre  mot de passe" required>
<br>
<br>
<button type="submit" id="m" name="supp">Supprimer</button>
<a href=""></a>
</form>
</body>
</html>

<?



if(isset($_POST["supp"]))
{ 

   
    
    $username = "root";
    $password = "root";
    $con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");


    // ancien 
    $ancien_email = htmlspecialchars($_POST["ancien_email"],ENT_COMPAT) ;
    $ancien_password = htmlspecialchars($_POST["ancien_motpasse"],ENT_COMPAT) ;


    // nouveau 

    

    if(($ancien_email != "") && ($ancien_password != ""))
    { 
        $req =  $con->prepare("SELECT * FROM adminsit WHERE id = :ida");
        $req->bindParam("ida",$_SESSION["admin_id"],PDO::PARAM_INT);
        if($req->execute())
        {
            $req = $req->fetchObject();

            if(($req->email === $ancien_email)&&(password_verify($ancien_password,$req->motpasse)))
            {       
                    $req2 = $con->prepare(" DELETE FROM  adminsit  WHERE id = :idcc");
                    $req2->bindParam("idcc",$_SESSION["admin_id"],PDO::PARAM_INT);

                    if($req2->execute())
                    {
                        echo "<h3 style=color:green;text-align:center;margin-top:100px;>"  . "  supprimer avec succes" . "</h3>";
                        header("refresh:4,url=../client_side/main.php");
                        exit;
                    }
                    else
                    { 
                        echo "<h3 style=color:red;text-align:center;margin-top:100px;>"  . "il y'a un probleme quelque part" . "</h3>";
                        header("refresh:4,url=../admin_side/admin_account.php");
                        exit;
                    }
            }
            else 
            {
                echo "erreur les champs ne doivent pas etre vide ";
                header("refresh:4,url=../admin_side/admin_account.php");
                exit;
            }
        }
    }

    
}













?>