<?


session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes techniciens </title>
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
     <h4> Liste de mes techniciens </h4>   
    </div>
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


                $list_tech = $con->prepare("SELECT * FROM technicien");


                if($list_tech->execute())
                {
                    $list_tech = $list_tech->fetchAll();
                    echo 
                    '
                    <table border="1">

                        <tr class="first_line">


                        <td> Nom du client  </td>

                        <td> Specialite  </td>

                        <td> Email </td>

                       
                        <td> modifier un technicien </td>

                        </tr>
                    ';
                    for ($i=0; $i <count($list_tech) ; $i++)
                     { 
                        echo '
                        <tr class="other">
                        
                        <td>  '. $list_tech[$i]["tech_nom"].'</td>
                        <td> '.  $list_tech[$i]["specialite"].' </td>
                        <td>  '. $list_tech[$i]["email"].'</td>
                         
                         
                        <td> <a href="../admin_side/modif_tech.php?id='.$encryption = openssl_encrypt($list_tech[$i]["id"], $ciphering,$encryption_key, $options, $encryption_iv).'"> modifier technicien </a> </td>';
                        
                       
                        
                    }

                    echo "</table>";
                }


            ?>

        <br>
        <br>
        <a href="../admin_side/admin_account.php">retour a la menu </a>
</body>
</html>