<?
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> les rapports </title>
    <style>

        body
        { 
            background-color: black;
            font-size: large;
        }


        h3{ 
            color:crimson;
        }

     .big_flex
     {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: space-between;
     }

     .child_flex
     {
        width: 300px;
        height: 600px;
        color:red;
        border:1px solid magenta;
        border-radius: 8px;
        color:cadetblue;
        
     }

     #di{
        background: black;
        border: 2px solid magenta;
        color:white;
     }

     button{ 
        background:#83ff00;
     }

    </style>
</head>
<body>
   
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



            $req = $con->prepare("SELECT technicien.tech_nom , demande.nom , demande.ville , demande.adres , demande.desci , demande_teh.idm FROM demande INNER JOIN technicien,demande_teh WHERE demande.id = demande_teh.idm AND demande_teh.idtech = technicien.id;");

        
            if($req->execute())
            {
                echo '<div class="big_flex">';

                $req = $req->fetchAll();
                for ($i=0; $i <count($req) ; $i++) 
                { 
                    echo 
                    '
                        <div class="child_flex">
                        <form method="post">
                        <h3>  A propos de mon demande </h3>

                        <p> je suis le technicien  '.$req[$i]["tech_nom"].' <p>
                        <p> recu la demande de client  '.$req[$i]["nom"].' </p>
                        <p> qui habite a'. "    " . $req[$i]["ville"] .' </p>
                        <p>  selon l" adresse '.$req[$i]["adres"].'</p>
                        <p> qui a comme probleme '.$req[$i]["desci"].'</p>
                        mon diagnostic: 
                        <input type="hidden" name="demandei" value='.$encryption = openssl_encrypt($req[$i]["idm"], $ciphering,$encryption_key, $options, $encryption_iv).'>
                        <textarea name="diag" id="di" cols="30" rows="10">

                        </textarea>
                        <br>


                        <button type="submit" name="send">  envoyer le rapport  </button>

                        </form>


                        </div>
                    ';
                }

                echo "</div>";
               
            }



    ?>

   
</body>
</html>

<?

if(isset($_POST["send"]))
{
    $id = $_POST["demandei"];

    $analyse = $_POST["diag"];
    $analyse = trim($analyse);

    $decryption_iv =  $_SESSION["encryption_iv"];
    $ciphering =  $_SESSION["ciphering"] ;
     $options = $_SESSION["options"] ;
    
    $decryption_key =  $_SESSION["key"];
    
    
    $idm=openssl_decrypt ($id, $ciphering,
            $decryption_key, $options, $decryption_iv);

   

    $username = "root";
    $password = "root";
    $con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");

    $insert_dignostic = $con->prepare("UPDATE demande_teh SET diagnostic = :digo WHERE idm = :id");
    $insert_dignostic->bindParam("digo",$analyse,PDO::PARAM_STR);
    $insert_dignostic->bindParam("id",$idm,PDO::PARAM_INT);

    if($analyse != "")
    {
        if($insert_dignostic->execute())
        { 
            echo "<footer>";
            echo "<h4 style='color:green'>" . "votre diagnostic est enregistre avec succes" . "</h4>";
            echo "</footer>";
            header("refresh:4,url=./mes_rapports.php");
        }
        else
        { 
            echo "<footer>";
            echo "<h4 style='color:red'>" . "il ya une erreur dans la requete , verifier votre base et votre requete" . "</h4>";
            echo "</footer>";
            header("refresh:4,url=./mes_rapports.php");
           
        }

    } 
    else
    { 
        echo "<footer>";
        echo "<h4 style='color:red'>" . " ecrivez votre digonestic, si tu n'as aucun conclusion ecrire j'ai pas une diagonestic pour cette problem " . "</h4>";
        echo "</footer>";
        header("refresh:4,url=./mes_rapports.php");
        
    }

}



?>