<?


session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> liste de mes demandes</title>
    <style>
        body{ 
            background-color: black;
            font-size: larger;
        }
        h4{ 
            color:crimson;
        }

        .header_content{ 
            margin-right: 450px;

        }


        .first_line
        { 
            color:crimson;
        }

        .other{ 
            color:white;
        }

        .other a { 
            text-decoration: none;
            color:cadetblue;
        }

        a{ 
            text-decoration: none;
            color:crimson;
        }
      
    </style>
</head>
<body>
    <div class="header_content">
     <h4> Liste de demande </h4>   

     
    </div>

        
  
        <h3> Les demandes affecte a des technicien et qui n'ont pas recus encore un email  </h3>
        
        <?
               
                $username = "root";
                $password = "root";
                $con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");
                
                $ciphering = "AES-128-CTR";
            
                
                $iv_length = openssl_cipher_iv_length($ciphering);
                $options = 0;
                
            
                $encryption_iv = '1234567891011121';
                
                $encryption_key = "omarbouhawel123456";
                
            
                 
                $_SESSION["encryption_iv"] = $encryption_iv;
                $_SESSION["key"] = $encryption_key;
                $_SESSION["ciphering"] = $ciphering;
                $_SESSION["options"] = $options;
                


                $list_demande = $con->prepare("SELECT demande.id,demande.nom, demande.emailuser,demande.teluser, demande.ville, demande.adres, demande.tservice, demande.desci, demande.datedemande, demande_teh.idm , demande_teh.idtech,demande_teh.email_sended FROM demande INNER JOIN demande_teh WHERE demande.id = demande_teh.idm;");
                  

                
                if($list_demande->execute())
                {
                    $list_demande = $list_demande->fetchAll();
                    echo 
                    '
                    <table border="1">

                        <tr class="first_line">

                        <td > i </td>


                        <td> Nom du client  </td>

                        <td> Utilisateur email  </td>

                        <td> N°telephone </td>

                        <td> Ville  </td>

                        <td> adresse </td>

                        <td> service </td>

                        <td> description </td>

                        <td> date du demande </td>


                        <td> Envoyer un Email  </td>


                        </tr>
                    ';
                    for ($i=0; $i <count($list_demande) ; $i++)
                     { 
                        if($list_demande[$i]["email_sended"] == null)
                        {
                            echo '
                            <tr class="other">
                            <td> '. $i .'</td>
                            <td>  '. $list_demande[$i]["nom"].'</td>
                            <td> '.  $list_demande[$i]["emailuser"].' </td>
                            <td>  '.  $list_demande[$i]["teluser"].'</td>
                            <td> '.  $list_demande[$i]["ville"].' </td>
                            <td>  '.  $list_demande[$i]["adres"].' </td>
                            <td>  '.  $list_demande[$i]["tservice"].' </td>
                            <td>    '.  $list_demande[$i]["desci"].'</td>
                            <td>  '.  $list_demande[$i]["datedemande"].'</td>
                            
                            
                            <td> <a href="../admin_side/Email.php?id='.$encryption = openssl_encrypt($list_demande[$i]["id"], $ciphering,$encryption_key, $options, $encryption_iv).'"> envoyer email </a> </td>';
                        }
                       
                        
                    }

                    echo "</table>";
                }

                    
            ?>
            
        <br>
        <br>
        <a href="../admin_side/admin_account.php">retour a la menu </a>
</body>
</html>
</body>
</html>