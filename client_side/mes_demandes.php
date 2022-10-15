<?php

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes demandes</title>
    <style>
        h1{
            color:red;
        }
        .first_tr  { 
            color:crimson;
        }

        .other_tr{ 
            color:white;
        }


        table{ 
            overflow: auto;
        }

        table tr button{ 
            background: black;
            color:cadetblue;
            border:none;
        }

        tr a{ 
            
            background: black;
            color: cadetblue;
        }

       a{
        text-decoration: none;
        color:crimson;
       }
       .adiv{
            text-align: center;
            margin-top: 126px;
       }


      

    #monp{ 
       display: none;
    }

    </style>
</head>
<body>
   
</body>
</html>

<?php



$username = "root";
$password = "root";
$con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");

$req = $con->prepare("SELECT * FROM demande WHERE client = :cli");
$req->bindParam("cli",$_SESSION["client"],PDO::PARAM_INT);

$ciphering = "AES-128-CTR";
                
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;


$encryption_iv = '1234567891011121';

$encryption_key = "omarbouhawel123456";


 
$_SESSION["encryption_iv"] = $encryption_iv;
$_SESSION["key"] = $encryption_key;
$_SESSION["ciphering"] = $ciphering;
$_SESSION["options"] = $options;


echo '<table id="t" border=1 class="tab">';

echo 
'
    <tr class="first_tr">

    <td> description de problemes </td>
    <td> date de votre demandes </td>
    <td>  actions  </td>
    </tr>
';
if($req->execute()){ 
   echo $req->rowCount();
   $req = $req->fetchAll();
    for ($i=0; $i < count($req); $i++) 
    { 
        echo 
            '
                <tr class="other_tr">

                <td>'.$req[$i]['desci'].'</td>
                <td> '.$req[$i]['datedemande'].' </td>
                <td> 
                   
                     <a href="../client_side/modifier_demande.php?id='.$encryption = openssl_encrypt($req[$i]["id"], $ciphering,$encryption_key, $options, $encryption_iv).'"> modifier demande </a>
                     <br>
                     <a href="../client_side/demande_annuler.php?id='.$encryption = openssl_encrypt($req[$i]["id"], $ciphering,$encryption_key, $options, $encryption_iv).'"> annuler demande </a>
                   
                </td>
                </tr>
            ';
          
    }

   
    
}



?>


