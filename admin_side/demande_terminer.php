<?
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>demande terminer</title>

    <style>
        body{ 
            background-color: black;
        }
    </style>
</head>
<body>
    <?


    
        $id = $_GET['id'];
        
        
        $decryption_iv =  $_SESSION["encryption_iv"];
        $ciphering =  $_SESSION["ciphering"] ;
        $options = $_SESSION["options"] ;
        
        $decryption_key =  $_SESSION["key"];

    
        $idm=openssl_decrypt ($id, $ciphering,
        $decryption_key, $options, $decryption_iv);


        
        
        $username = "root";
        $password = "root";
        $con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");
        
        $delete_from_demande = $con->prepare("DELETE FROM demande WHERE id = :id_demande");
        $delete_from_demande->bindParam("id_demande",$idm,PDO::PARAM_INT);


        $delete_from_demande_tech = $con->prepare("DELETE FROM demande_teh WHERE idm = :id_demande");
        $delete_from_demande_tech->bindParam("id_demande",$idm,PDO::PARAM_INT);


        if(($delete_from_demande->execute()) && ($delete_from_demande_tech->execute()))
        {
            echo "<h1 style='color:green;'>" . "demande est termine " . "</h1>";
            header("refresh:4,url=./affectation.php");
            exit;
        }   
        else
        {
            echo "<h1 style='color:red;'>" . "demande est termine " . "</h1>";
            header("refresh:4,url=./affectation.php");
            exit;
        }     
       


    ?>
    
</body>
</html>