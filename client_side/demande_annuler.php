<?


session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anuulation</title>
    <style>
        body{
            background-color: black;
        }
    </style>
</head>
<body>
<?
$username = "root";
$password = "root";
$con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");

$id = $_GET['id'];
 
$decryption_iv =  $_SESSION["encryption_iv"];
$ciphering =  $_SESSION["ciphering"] ;
 $options = $_SESSION["options"] ;
$decryption_key =  $_SESSION["key"];

$ids=openssl_decrypt ($id, $ciphering,
$decryption_key, $options, $decryption_iv);



$supp_client_demande = $con->prepare("DELETE FROM demande WHERE id = :ids ");
$supp_demande_def = $con->prepare("DELETE FROM demande_teh WHERE idm = :ids ");

$supp_client_demande->bindParam("ids",$ids,PDO::PARAM_INT);
$supp_demande_def->bindParam("ids",$ids,PDO::PARAM_INT);

if(($supp_client_demande->execute()) && ($supp_demande_def->execute()))
{ 
echo "<h3 style=color:green;text-align:center;margin-top:100px;>"  . "votre demande est supprimer avec succes" . "</h3>";
header("refresh:4,url=../client_side/mon_profil.php");
exit;
}
else
{ 
echo "<h3 style=color:red;text-align:center;margin-top:100px;>"  . "erreur quelque part  " . "</h3>";
header("refresh:4,url=../client_side/mon_profil.php");
exit;
}

?>


</body>
</html>