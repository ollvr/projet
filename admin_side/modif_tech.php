<?


session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes parameteres </title>
    <style>

        body{ 
            background-color: black;
        }
        h3{ 
            color: cadetblue;
        }

        .hide{ 
            position:absolute; top:-1px; left:-1px; width:1px; height:1px; 
        }
        #m{ 
            background: black;
            color: crimson;
            border-radius: 7px;
            border: 1px solid magenta;
            width: 134px;
            height: 30px;
        }
    </style>
</head>
<body>
    <h3>
        Modifier les Parametres d'un technicien : 
    </h3>

    
  
    <form  method="post" id="formsend">
        <input type="email" name="ancien_email" placeholder="mettez votre ancien email" required>
        <br>
        <br>
        <input type="password" name="ancien_motpasse" placeholder="mettez votre ancien mot de passe" required>
        <br>
        <br>
        <input type="text" name="nouveau_spe" placeholder="mettez votre nouveau specialite" required>
        <br>
        <br>
        <input type="email" name="nouveau_email" placeholder="mettez votre nouveau email"  required>
        <br>
        <br>
        <input type="password" name="nouveau_motpasse" placeholder="mettez votre nouveau mot de passe " required>
        <br>
        <br>
        <button type="submit" id="m" name="modif_tech">Modifier</button>
    </form>

    	
</body>
</html>

<?

            
       
    
 

    if(isset($_POST["modif_tech"]))

    {
       
        $username = "root";
        $password = "root";
        $con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");


    
        $id = $_GET['id'];
 
      
        $decryption_iv =  $_SESSION["encryption_iv"];
        $ciphering =  $_SESSION["ciphering"] ;
         $options = $_SESSION["options"] ;
    
        $decryption_key =  $_SESSION["key"];
        
      
        $idm=openssl_decrypt ($id, $ciphering,
                $decryption_key, $options, $decryption_iv);
        
       

         

        $ancien_email = htmlspecialchars($_POST["ancien_email"],ENT_COMPAT) ;
        $ancien_password = htmlspecialchars($_POST["ancien_motpasse"],ENT_COMPAT) ;


        // nouveau 

        $nouveau_email = htmlspecialchars($_POST["nouveau_email"],ENT_COMPAT) ;

        $nouveau_spe = htmlspecialchars($_POST["nouveau_spe"],ENT_COMPAT) ;

        $nouveau_password = htmlspecialchars($_POST["nouveau_motpasse"],ENT_COMPAT) ;
        $nouveau_password = password_hash($nouveau_password, PASSWORD_DEFAULT);
        
  

        
        if(($ancien_email != $nouveau_email) && ($ancien_password != $nouveau_password))
        { 
            $req =  $con->prepare("SELECT * FROM technicien WHERE id = :idt");
            $req->bindParam("idt",$idm,PDO::PARAM_INT);
            if($req->execute())
            {
                $req = $req->fetchObject();
                
                
                
                if(($req->email == $ancien_email)&&(password_verify($ancien_password,$req->mp)))
                {       
                       
                        $req2 = $con->prepare("UPDATE technicien SET specialite = :spe ,email = :mail , mp = :pass WHERE id = :idt");
                        $req2->bindParam("spe",$nouveau_spe,PDO::PARAM_STR);
                        $req2->bindParam("mail",$nouveau_email,PDO::PARAM_STR);
                        $req2->bindParam("pass",$nouveau_password,PDO::PARAM_STR);
                        
                        
                        $req2->bindParam("idt",$idm,PDO::PARAM_INT);
                        

                        if($req2->execute())
                        {
                            echo "<h3 style=color:green;text-align:center;margin-top:100px;>"  . "modifier avec succes" . "</h3>";
                            header("refresh:2,url=./admin_account.php");
                            exit;
                            
                        }
                        else
                        { 
                            echo "<h3 style=color:red;text-align:center;margin-top:100px;>"  . "il y'a un probleme quelque part" . "</h3>";
                            header("refresh:2,url=./admin_account.php");
                            exit;
                        }
                }
                else 
                {
                    echo "erreur verifier l'anciem mot de passe et l'ancien email";
                    header("refresh:2,url=./admin_account.php");
                    exit;
                    
                }
                
            }
           
        }
        
        


    }

   











?>