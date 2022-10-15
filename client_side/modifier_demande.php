<?


session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>modification des demandes </title>

    <style>


        body 
        {
            background-color: black;
            font-size: large;
        }

    #container form #type_de_service
    { 
        background: white;
        border: 2px solid darkmagenta;
    }

    #container form #Desc
    { 
        border: 2px solid darkmagenta;
    }
   

    #container form button{ 
        
            background: black;
            color: crimson;
            border-radius: 7px;
            border: 1px solid magenta;
            width: 134px;
            height: 30px;
      
    }

    #container form label {
            color:cadetblue;
        }

    #container form input{ 
       
            border: 1px solid magenta;
        
    }
    #container form h3 { 
        text-decoration: underline;
        text-align: center;
        color:crimson
    }


    .retour{ 
        text-align: center;
    }

    .retour a {
        color:crimson;
    }
    

    </style>
</head>
<body>
<div id="container">

<form method="POST" id="inscrireform">
    <h3> Modifier la demande </h3>
    <label>Ville</label>
    <br>
    <br>
    <input type="text" name="ville" id="Ville" placeholder="mettez votre ville" required>
    <br>
    <br>

    <label>Adresse</label>
    <br>
    <br>
    <input type="text" name="adressee" id="Adresse" placeholder="mettez votre adresse" required>
    <br>
    <br>
    <label>service</label>
    <br>
    <br>
    <select id="type_de_service" name="ser">
    
    <option value="">choisir une categorie </option>
    <option value="tout probleme material et logiciel">probleme material et logiciel </option>
    <option value=" suppression de virus "> suppression de virus </option>
    <option value="administration du reseau ">administration du reseau </option>
    <option value=" installation de windows "> installation de windows </option>
    <option value=" autre "> autre </option>

    </select>
    <br>
    <br>
    <label>description</label>
    <br>
    <br>
    <textarea class="form-control w-50" id="Desc" name="desci" rows="3" required>

    </textarea> 
    <br>
    <br>
    <button type="submit" id="inscrire" name="envoyer">modifier</button>
</form>

    
    <div class="retour">
    <a href="../client_side/mon_profil.php">retourne a mon profil </a>
    </div>
   

</div>
</body>
</html>
<?

if(isset($_POST["envoyer"]))
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
           




$ville = htmlspecialchars($_POST["ville"],ENT_COMPAT);
$adres = htmlspecialchars($_POST["adressee"],ENT_COMPAT);
$tservice = htmlspecialchars($_POST["ser"],ENT_COMPAT);
$descriptiond = htmlspecialchars($_POST["desci"],ENT_COMPAT);


$update_client_demande = $con->prepare("UPDATE demande SET ville = :vill ,adres = :adress , tservice = :tservice , desci = :descriptionne WHERE id = :idm ");
$update_client_demande->bindParam("vill",$ville,PDO::PARAM_STR);
$update_client_demande->bindParam("adress",$adres,PDO::PARAM_STR);
$update_client_demande->bindParam("tservice",$tservice,PDO::PARAM_STR);
$update_client_demande->bindParam("descriptionne",$descriptiond,PDO::PARAM_STR);
$update_client_demande->bindParam("idm",$idm,PDO::PARAM_INT);
                
 if(($ville != "") &&($adres != "") && ($tservice != "") &&($descriptiond != ""))
    {
        if($update_client_demande->execute())
        {
            echo "<h3 style=color:green;text-align:center;margin-top:100px;>"  . "modifier avec succes" . "</h3>";
            header("refresh:3,url=../client_side/mon_profil.php");
            exit;
        }
            else
            {
        
                echo "<h3 style=color:red;text-align:center;margin-top:100px;>"  . "il y'a un probleme quelque part" . "</h3>";
                header("refresh:3,url=../client_side/mon_profil.php");
                exit;
            }
                        
    } else 
        { 
            echo "<h3 style=color:red;text-align:center;margin-top:100px;>"  . "notez bien que les champs rempli ne soit pas vide " . "</h3>";
            header("refresh:3,url=../client_side/mon_profil.php");
            exit;
        }   
              

}



?>