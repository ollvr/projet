<?


session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traiter demande </title>
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

        
  
        <h3> Titre : Apropos de demande </h3>
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
                
                
                
                $list_demande = $con->prepare("SELECT * FROM demande");

               

                if($list_demande->execute())
                {
                    $list_demande = $list_demande->fetchAll();
                    echo 
                    '
                    <table border="1">

                        <tr class="first_line">

                        <td > N°demande </td>


                        <td> Nom du client  </td>

                        <td> Utilisateur email  </td>

                        <td> N°telephone </td>

                        <td> Ville  </td>

                        <td> adresse </td>

                        <td> service </td>

                        <td> description </td>

                        <td> date du demande </td>


                        <td> Affecter a un technicien  </td>
                        <td> supprimer une demande  </td>


                        </tr>
                    ';
                    for ($i=0; $i <count($list_demande) ; $i++)
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
                         
                         
                          <td> <a href="../admin_side/ajout_tech_demande.php?id='.$encryption = openssl_encrypt($list_demande[$i]["id"], $ciphering,$encryption_key, $options, $encryption_iv).'"> affecter a un technicien </a> </td>'.'
                          <td> <a href="../admin_side/supp_demande.php?id='.$encryption = openssl_encrypt($list_demande[$i]["id"], $ciphering,$encryption_key, $options, $encryption_iv).'"> supprimer demande  </a> </td>';
                       
                        
                    }

                    echo "</table>";
                }


            ?>

        

        <br>
        <br>
        <h4> les demandes qui sont regler par un technicien   </h4>  

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



        $req = $con->prepare("SELECT demande.nom , demande.emailuser , demande.teluser , demande.ville , demande.adres , demande.tservice,demande.desci,demande.datedemande,demande_teh.idm , technicien.tech_nom,demande_teh.diagnostic,demande_teh.email_sended FROM demande INNER JOIN technicien,demande_teh WHERE demande.id = demande_teh.idm AND demande_teh.idtech = technicien.id;");

        if($req->execute())
        {   
            $req = $req->fetchAll();
            echo "<table border=1>";
            echo 
            '   <tr class="first_line">
                 <td> nom du client </td>
                 <td> email client </td> 
                 <td> N°telephone </td> 
                 <td> ville </td> 
                 <td> adresse </td> 
                 <td> type de service </td> 
                 <td> description </td> 
                 <td> date de demande </td> 
                 <td> technicien nom </td> 
                 <td> son diagnostic </td> 
                 <td>  tache terminer  </td>
                
                </tr>
            ';
            for ($i=0; $i <count($req) ; $i++)
            { 
                if(($req[$i]["diagnostic"] != null) &&($req[$i]["email_sended"] != null))
                {
                    echo 
                    '
                        <tr class="other">

                        <td> '.$req[$i]["nom"].' </td>
                        <td>  '.$req[$i]["emailuser"].' </td> 
                        <td> '.$req[$i]["teluser"].' </td> 
                        <td> '.$req[$i]["ville"].' </td> 
                        <td> '.$req[$i]["adres"].' </td> 
                        <td> '.$req[$i]["tservice"].' </td> 
                        <td> '.$req[$i]["desci"].' </td> 
                        <td> '.$req[$i]["datedemande"].' </td> 
                        <td> '.$req[$i]["tech_nom"].' </td> 
                        <td> '.$req[$i]["diagnostic"].' </td> 
                        <td> <a href="../admin_side/demande_terminer.php?id='.$encryption = openssl_encrypt($req[$i]["idm"], $ciphering,$encryption_key, $options, $encryption_iv).'"> oui? </a> </td>
                    

                        <tr>
                    ';
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