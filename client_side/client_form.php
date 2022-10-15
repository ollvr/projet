<?php

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> demande utilisateur  </title>
    <link rel="stylesheet" href="./css/client_form.css">
</head>
<body>
    <main class="main_form">
        <div class="form_container">
            <h3> Cher client remplissez ce formulaire pour envoyer votre demande </h1>
            <form method="post">
                <table>
                    <tr>
                        <td>
                            <label for="Nom">Nom</label>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="text" name="nom" id="Nom" placeholder="mettez votre nom complet" required>
                        </td>
                    </tr>


                    <tr>
                        <td>
                            <label for="Email">Email</label>
                        </td>
                    </tr>

                

                    <tr>
                        <td>
                            <input type="email" name="email" id="Email" placeholder="mettez votre email (c'est pas obligatoire )">
                        </td>
                    </tr>


                    <tr>
                        <td>
                            <label for="Phone">N°Telephone</label>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="text" name="phone" id="Phone" placeholder="mettez votre numero telephone" required>
                        </td>
                    </tr>


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

            <div class="a_conatiner">
                <a href="./main.php">retour a la page principale </a>
            </div>
        </div>
        <p id="error"></p>

      
    </main>
    <script src="./js/input_validation.js"></script>
</body>
</html>



<?php 



    if(isset($_POST["envoyer"]))

    { 


        
        $username = "root";
        $password = "root";

        $con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");

        $nom = htmlspecialchars($_POST["nom"],ENT_COMPAT);
        $email = htmlspecialchars($_POST["email"],ENT_COMPAT);
        $phone = htmlspecialchars($_POST["phone"],ENT_COMPAT);
        $ville = htmlspecialchars($_POST["ville"],ENT_COMPAT);
        $adres = htmlspecialchars($_POST["adressee"],ENT_COMPAT);
        $tservice = htmlspecialchars($_POST["ser"],ENT_COMPAT);
        $description = htmlspecialchars($_POST["desci"],ENT_COMPAT);

        $date = date("y-m-d");
        
        $plus_week = strtotime("+1 week");

        $week = date("y-m-d",$plus_week);
            
         

        $check_req = $con->prepare(" SELECT * FROM client WHERE email = :mail OR numrotel = :tel ;");
        $check_req->bindParam("mail",$email,PDO::PARAM_STR);
        $check_req->bindParam("tel",$phone,PDO::PARAM_INT);

        if($check_req->execute())
        {
            if($check_req->rowCount()>0)
            {
                echo "<h3 style=color:red;text-align:center;margin-top:100px;>"  . "vous etez deja un client essayer de faire une connexion a votre compte " . "</h3>";
                
            }

            else 
            {
                
                $check_simple_utilisateur = $con->prepare("SELECT * FROM `demande` WHERE emailuser = :email OR teluser = :phone AND client = 0;");
                $check_simple_utilisateur->bindParam("email",$email,PDO::PARAM_STR);
                $check_simple_utilisateur->bindParam("phone",$phone,PDO::PARAM_INT);
                if($check_simple_utilisateur->execute())
                { 
                        if($check_simple_utilisateur->rowCount()>0)
                        {
                           $check_simple_utilisateur = $check_simple_utilisateur->fetchObject();
                            
                            if(strcmp($date,$check_simple_utilisateur->daterponse)== -1)
                            {
                                echo "<h3 style=color:red>" . "vous avez deja envoyee une demande , attendez notre reponse dans une semaine ". "</h3>";
                            }
                            else 
                            { 
                                $update_user_demande  =  $con->prepare("UPDATE demande SET nom = :nom , ville = :ville , adres = :adres , tservice = :tservice , desci = :desci , datedemande = :datedemande , daterponse = :daterep WHERE emailuser = :emailuser OR teluser = :teluser ;");
                                $update_user_demande->bindParam("nom",$nom,PDO::PARAM_STR);
                                $update_user_demande->bindParam("emailuser",$email,PDO::PARAM_STR);
                                $update_user_demande->bindParam("teluser",$phone,PDO::PARAM_INT);
                                $update_user_demande->bindParam("ville",$ville,PDO::PARAM_STR);
                                $update_user_demande->bindParam("adres",$adres,PDO::PARAM_STR);
                                $update_user_demande->bindParam("tservice",$tservice,PDO::PARAM_STR);
                                $update_user_demande->bindParam("desci",$description,PDO::PARAM_STR);
                                $update_user_demande->bindParam("datedemande",$date,PDO::PARAM_STR);
                                $update_user_demande->bindParam("daterep",$week,PDO::PARAM_STR);

                                if($update_user_demande->execute())
                                { 
                                    echo "<h1 style=color:green>" . "  demande envoyer avec succes , attendez de nous une reponse sur votre email ". "</h1>";
                                    header("refresh:4,url=./main.php");
                                }
                                else
                                {
                                    echo "<h1 style=color:red>" . "erreur dans la requete ". "</h1>";
                                    header("refresh:4,url=./main.php");
                                }
                            }
                        }
                        else
                        {
                            $nv_user = $con->prepare("INSERT INTO demande (nom,emailuser,teluser,ville,adres,tservice,desci,client,datedemande,daterponse) VALUES (:nom,:emailuser,:teluser,:ville,:adres,:tservice,:desci,0,:datedemande,:daterep)");
                            $nv_user->bindParam("nom",$nom,PDO::PARAM_STR);
                            $nv_user->bindParam("emailuser",$email,PDO::PARAM_STR);
                            $nv_user->bindParam("teluser",$phone,PDO::PARAM_INT);
                            $nv_user->bindParam("ville",$ville,PDO::PARAM_STR);
                            $nv_user->bindParam("adres",$adres,PDO::PARAM_STR);
                            $nv_user->bindParam("tservice",$tservice,PDO::PARAM_STR);
                            $nv_user->bindParam("desci",$description,PDO::PARAM_STR);
                            $nv_user->bindParam("datedemande",$date,PDO::PARAM_STR);
                            $nv_user->bindParam("daterep",$week,PDO::PARAM_STR);

                            if(($nom != "")&&($email != "")&&($phone != "")&&($ville != "")&&($adres != "")&&($tservice != "")&&($description != ""))
                            { 
                                if($nv_user->execute())
                                { 
                                    echo "<h1 style=color:green>" . "demande envoyer avec succes , attendez de nous une reponse sur votre email ". "</h1>";
                                    header("refresh:4,url=./main.php");
                                    exit;
                                }
                                else 
                                { 
                                    echo "<h1 style=color:red>" . "erreur ". "</h1>";
                                    header("refresh:4,url=./main.php");
                                    exit;
                                }
                            } 
                            else 
                            { 
                                echo "<h1 style=color:red>" . "verifier que les champs ne soint pas vides ". "</h1>";
                                header("refresh:4,url=./main.php");
                                exit;
                            }

                        }
                }
                
            }
            


        }


    }



?>