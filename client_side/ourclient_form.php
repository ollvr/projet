<?php

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> notre client demande</title>
    <link rel="stylesheet" href="./css/client_form.css">
<style>
 body{ 
    background-color: #0a0e1b;
}
h3{ 
    color: crimson;
    text-align: center;
}

form td label { 
    color: #019984de;
    font-size: large;
}

form td button{ 
    border: none;
    color: indigo;
    background: scroll;
    margin-top: 17px;
}

form td input { 
    width: 299px;
    height: 19px;
    border: none;
    border-radius: 3px;
    margin-bottom: 11px;
    color: black;
    
}


#type_de_service{ 
 
    margin-bottom: 11px;
}


.a_conatiner{ 
    text-align: center;
}


.a_conatiner a { 
    color:crimson;
    font-size:large;
    text-decoration: none;
}
</style>
</head>
<body>

<main class="main_form">
        <div class="form_container">
            <h3> Cher client remplissez ce formulaire pour envoyer votre demande </h1>
            <form method="post">
                <table>
                  
                    <tr>
                        <td>
                            <label for="Adresse">ville</label>
                        </td>
                    </tr>

                    <tr>
                        <td>
                        <input type="text" name="ville" id="Ville" placeholder="mettez votre ville" required>
                        </td>
                    </tr>


                    <tr>
                        <td>
                            <label for="Adresse">Adresse</label>
                        </td>
                    </tr>

                    <tr>
                        <td>
                        <input type="text" name="adressee" id="Adresse" placeholder="mettez votre adresse" required>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label for="type_de_service">Choisisez le type de service </label>
                        </td>
                    </tr>


                    <tr>
                        <td>
                        <select id="type_de_service" name="ser">
            
                                    <option value="">choisir une categorie </option>
                                    <option value="tout probleme material et logiciel">probleme material et logiciel </option>
                                    <option value=" suppression de virus "> suppression de virus </option>
                                    <option value="administration du reseau ">administration du reseau </option>
                                    <option value=" installation de windows "> installation de windows </option>
                                    <option value=" autre "> autre </option>

                        </select>
                        </td>
                    </tr>


                    <tr>
                        <td>
                            <label for="Desc">Description du probleme </label>    
                        </td>
                    </tr>


                    <tr>
                        <td>
                            <textarea class="form-control w-50" id="Desc" name="desci" rows="3" required>

                            </textarea> 
                        </td>
                    </tr>

                    <tr>
                        <td>
                        <button type="submit" id="envoi" name="envoyer">Envoyer demande</button> <button type="reset">Annuler</button> 
                        </td>
                    </tr>

                </table>
            </form>

         
        </div>
        <p id="error"></p>

       
       
    </main>

</body>
</html>

<?


if(isset($_POST["envoyer"]))

{ 

    
    $username = "root";
    $password = "root";
    $con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");

    
    $req_client_info = $con->prepare("SELECT nomcomplet , email , numrotel FROM client WHERE id = :idc");
    $req_client_info->bindParam("idc",$_SESSION["client"],PDO::PARAM_INT);

    $req_client_info->execute();

    $req_client_info = $req_client_info->fetchObject();

    
    
    $nom = $req_client_info->nomcomplet;

    $email = $req_client_info->email;

    $phone = $req_client_info->numrotel;

    $ville = htmlspecialchars($_POST["ville"],ENT_COMPAT);
    $adres = htmlspecialchars($_POST["adressee"],ENT_COMPAT);
    $tservice = htmlspecialchars($_POST["ser"],ENT_COMPAT);
    $description = htmlspecialchars($_POST["desci"],ENT_COMPAT);

    $date = date("y-m-d");

    $plus_week = strtotime("+1 week");

    $week = date("y-m-d",$plus_week);

   
    

    $req_v = $con-> prepare("SELECT * FROM demande WHERE client = :id_client AND client > 0");
    $req_v->bindParam("id_client",$_SESSION["client"],PDO::PARAM_INT);

    if($req_v->execute())
    { 

        if($req_v->rowCount()>0)
        { 
                $req_v = $req_v->fetchObject();
                if(strcmp($date,$req_v->daterponse)== -1)
                {
                 echo "<h3 style=color:red>" . "cette client a deja envoyee une demande , tu sera une reponse le plus proche possible ". "</h3>";
                 header("refresh:3,url=./client_account.php");
                 exit;
                }
                else
                { 
                    $update_cli_demande  =  $con->prepare("UPDATE demande SET nom = :nom , ville = :ville , adres = :adres , tservice = :tservice , desci = :desci , datedemande = :datedemande , daterponse = :daterep WHERE emailuser = :emailuser OR teluser = :teluser ;");
                    $update_cli_demande->bindParam("nom",$nom,PDO::PARAM_STR);
                    $update_cli_demande->bindParam("emailuser",$email,PDO::PARAM_STR);
                    $update_cli_demande->bindParam("teluser",$phone,PDO::PARAM_INT);
                    $update_cli_demande->bindParam("ville",$ville,PDO::PARAM_STR);
                    $update_cli_demande->bindParam("adres",$adres,PDO::PARAM_STR);
                    $update_cli_demande->bindParam("tservice",$tservice,PDO::PARAM_STR);
                    $update_cli_demande->bindParam("desci",$description,PDO::PARAM_STR);
                    $update_cli_demande->bindParam("datedemande",$date,PDO::PARAM_STR);
                    $update_cli_demande->bindParam("daterep",$week,PDO::PARAM_STR);
                    
                    if(($nom != "")&&($email != "")&&($phone != "")&&($ville != "")&&($adres != "")&&($tservice != "")&&($description != ""))
                    {
                        if($update_cli_demande->execute())
                        { 
                            echo "<h1 style=color:green>" . "  demande client envoyer avec succes , attendez de nous une reponse sur votre email ". "</h1>";
                            header("refresh:3,url=./client_account.php");
                            exit;
                        }
                        else
                        {
                            echo "<h1 style=color:red>" . "erreur dans la requete ". "</h1>";
                            header("refresh:3,url=./ourclient_form.php");
                            exit;
                        }
                    }
                }
        }
        else 
        {
            $nv_cli = $con->prepare("INSERT INTO demande (nom,emailuser,teluser,ville,adres,tservice,desci,client,datedemande,daterponse) VALUES (:nom,:emailuser,:teluser,:ville,:adres,:tservice,:desci,:idcli,:datedemande,:daterep)");
            $nv_cli->bindParam("nom",$nom,PDO::PARAM_STR);
            $nv_cli->bindParam("emailuser",$email,PDO::PARAM_STR);
            $nv_cli->bindParam("teluser",$phone,PDO::PARAM_INT);
            $nv_cli->bindParam("ville",$ville,PDO::PARAM_STR);
            $nv_cli->bindParam("adres",$adres,PDO::PARAM_STR);
            $nv_cli->bindParam("tservice",$tservice,PDO::PARAM_STR);
            $nv_cli->bindParam("desci",$description,PDO::PARAM_STR);
            $nv_cli->bindParam("idcli",$_SESSION["client"],PDO::PARAM_INT);
            $nv_cli->bindParam("datedemande",$date,PDO::PARAM_STR);
            $nv_cli->bindParam("daterep",$week,PDO::PARAM_STR);

            if(($nom != "")&&($email != "")&&($phone != "")&&($ville != "")&&($adres != "")&&($tservice != "")&&($description != ""))
            { 
                if($nv_cli->execute())
                { 
                    echo "<h1 style=color:green>" . " demande envoyer avec succes , attendez de nous une reponse sur votre email ". "</h1>";
                    header("refresh:3,url=./client_account.php");
                    exit;
                }
                else 
                { 
                    echo "<h1 style=color:red>" . "erreur ". "</h1>";
                    header("refresh:3,url=./ourclient_form.php");
                    exit;
                }
            } 
            else 
            { 
                echo "<h1 style=color:red>" . "verifier que les champs ne soint pas vides ". "</h1>";
                header("refresh:3,url=./ourclient_form.php");
                exit;
            }
        }


    }

}



?>