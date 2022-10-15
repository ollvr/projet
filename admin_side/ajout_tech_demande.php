<?

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ajouter tech demande</title>
    <style>
        body
        { 
            background-color: black;
        }
        h3{ 
            color:crimson;
        }

        h4{
           color: #843241
        }

        form{ 
            margin-top: 85px;
        }

        .detail{
            margin-top:-60px;
        }
         .detail h5{
            color:aliceblue;
         }

         form button {
            background: black;
            color: crimson;
            border-radius: 7px;
            border: 1px solid magenta;
            width: 134px;
            height: 30px;
         }

         #t{ 
            width: 175px;
            border: 1px solid magenta;
            border-radius: 5px;
         }
    </style>
</head>
<body>
    
<h3>detail du demande : </h3>
<form method="POST">
        
       
    <div class="detail">
        <?

            $id = $_GET['id'];
 
           
           $decryption_iv =  $_SESSION["encryption_iv"];
           $ciphering =  $_SESSION["ciphering"] ;
            $options = $_SESSION["options"] ;
           
           $decryption_key =  $_SESSION["key"];
           
           
            $f=openssl_decrypt ($id, $ciphering,
                   $decryption_key, $options, $decryption_iv);
           
           
          

            
            $username = "root";
            $password = "root";
           $con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");

            $req_demande = $con->prepare("SELECT * FROM  demande WHERE id = :demande_id");

            $req_tech = $con->prepare("SELECT * FROM technicien ");

            $req_demande->bindParam("demande_id",$f);

            
            if ($req_demande->execute())
            { 
                $req_demande = $req_demande->fetchAll();

                for ($i=0; $i <count($req_demande) ; $i++) 
                { 
                    
                    echo '
                     <h4> Nom du client   </h4>
                     <h5> '. $req_demande[$i]["nom"] .' </h5>
                     <h4> Email du client   </h4>
                     <h5> '. $req_demande[$i]["emailuser"] .' </h5>
                     <h4> Ou le client Habite  </h4>
                     <h5> '. $req_demande[$i]["ville"] .' </h5>
                     <h4> Adresse du client   </h4>
                     <h5> '. $req_demande[$i]["adres"] .' </h5>
                     <h4> Le Tyepe de service   </h4>
                     <h5> '. $req_demande[$i]["tservice"] .' </h5>
                     <h4> Le probleme   </h4>
                     <h5> '. $req_demande[$i]["desci"] .' </h5>
                    ';

                }

                if($req_tech->execute())
                { 
                    $req_tech = $req_tech->fetchAll();
                    echo "<select name='tech' id='t'>";
                    echo  "<option value=''>" . "choisir un technicien" . "</option>";

                    for ($j=0; $j <count($req_tech) ; $j++) 
                    { 
                        echo 
                        '
                            <option value='.$req_tech[$j]["id"].'> '.$req_tech[$j]["tech_nom"].' </option>
            
                        ';
                    }
                   


                    echo "</select>";
                }
                
            }

            
        ?>
    </div>
    <br>
    <br>
    <button type="submit" name="affect">Affect</button>
   
</form>
   

</body>
</html>


<?


if(isset($_POST["affect"]))
{ 
    
    $username = "root";
    $password = "root";
    $con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");
    $tech_id = $_POST["tech"];
    


    $id = $_GET['id'];
 
           
           $decryption_iv =  $_SESSION["encryption_iv"];
           $ciphering =  $_SESSION["ciphering"] ;
            $options = $_SESSION["options"] ;
           $decryption_key =  $_SESSION["key"];
    
           $idm=openssl_decrypt ($id, $ciphering,
                   $decryption_key, $options, $decryption_iv);
           


    
    
    $test = $con->prepare("SELECT * FROM demande_teh WHERE idm = :demande");
    $test->bindParam("demande",$idm,PDO::PARAM_INT);

    $test2 = $con->prepare("SELECT idtech FROM demande_teh");
   
    

        if($test2->execute())
        { 
        
            

                $test2 = $test2->fetchAll();
                $stop = false ;
                var_dump($test2);

                for ($k=0; $k <count($test2) ; $k++) { 
                        if($tech_id == $test2[$k]["idtech"])
                        {
                                $stop = true;
                                break;
                        }
                }

                if($stop)
                { 
                    echo "<h1 style='color:red;'>" .  "ce technicien est occupe par une demande" . "<h1>";
                    header("refresh:2,url=../admin_side/affectation.php");
                    exit;
                }

               
                else 
                { 
                        $tech_insert = $con->prepare("INSERT INTO demande_teh (idm,idtech) VALUES (:demandeid,:tech)");
        
                        $tech_insert->bindParam("demandeid",$idm,PDO::PARAM_INT);
                        $tech_insert->bindParam("tech",$tech_id,PDO::PARAM_INT);
        
                        if($tech_id != "")
                        {
                            if($tech_insert->execute())
                            { 
                                echo "<h1 style=color:green>" . "Technicien effectuez a cette demande  ". "</h1>";
                                header("refresh:2,url=../admin_side/affectation.php");
                                exit;
                                
                                
                            }
                            else 
                            {
                                echo "<h1 style=color:red>" . " error ". "</h1>";
                                header("refresh:2,url=../admin_side/affectation.php");
                                exit;
                                
                            }
                        }
                        else 
                        { 
                            echo "<h1 style=color:red>" . " choisisez un technicien ". "</h1>";
                            header("refresh:2,url=../admin_side/affectation.php");
                            exit;
                                
                        }
                    
                }
                


            




          
        
        }
    

}