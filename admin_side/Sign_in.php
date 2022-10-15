<?php 


session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin connexion </title>
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
       
    </style>
</head>
<body>
    <h1>Admin connexion </h1>
    <form method="POST">

        <label for="Email">Admin email </label>
        <br>
        <br>
        <input type="email" name="email" id="Email" required>
        <br>
        <br>
        <label for="Mp"> Admin mot de passe </label>
        <br>
        <br>
        <input type="password" name="pass" id="Mp">
        <br>
        <br>
        <button type="submit" name="connexion">connexion</button>
    </form>
</body>
</html>


<?php




if(isset($_POST["connexion"]))
{


$username = "root";
$password = "root";
$con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");

$admin_email = htmlspecialchars($_POST["email"],ENT_COMPAT);
$admin_pass = htmlspecialchars($_POST["pass"],ENT_COMPAT);

$admin_email = trim($admin_email);


$select_req = $con->prepare("SELECT * FROM adminsit WHERE email LIKE :email ");
$select_req->bindParam('email',$admin_email,PDO::PARAM_STR);

if(($admin_email != "") && ($admin_pass != ""))
{ 

   
    if($select_req->execute())
    { 
        var_dump($select_req);
       
        $select_req = $select_req->fetchObject();
        
        
        if(password_verify($admin_pass,$select_req->motpasse))
        {    
            echo "<h3 style=color:green;text-align:center;margin-top:100px;>"  . "connexion avec succes" . "</h3>";
            $_SESSION["admin_id"] = $select_req->id;
            header("refresh:4,url=../admin_side/admin_account.php");
            exit;
        }
        else
        { 
            echo "<h3 style=color:red;text-align:center;margin-top:100px;>"  . "erreur quelque part  " . "</h3>";
            header("refresh:4,url=../admin_side/Sign_in.php");
            exit;
        }
        

    }

}
else
{ 
 echo "<h3 style=color:red;text-align:center;margin-top:100px;>"  . "notez bien que les champs ne soient pas vide" . "</h3>";
 header("refresh:4,url=../admin_side/Sign_in.php");
 exit;
}

}













?>