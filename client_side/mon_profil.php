<?

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon profil </title>
    <link rel="stylesheet" href="./css/mon_profil.css">
</head>
<body>

        <header>
            <h4> Cette partie des tes paramtere </h4>
        </header>


    <aside>

        <ul>
            <li>
                <form method="POST">
                    <button name="demandelist"> Votre demandes </button>
                </form>
            </li>

            <li>
                <form method="POST">
                    <button name="mesparametere"> Modifier vos parametere personnelles </button>
                </form>
            </li>




            <li>
                <form method="POST">
                    <button name="supprimercompte"> Supprimer votre compte definitvment </button>
                </form>
            </li>




            <li>
                <form method="POST">
                    <button name="deconnecter"> Se deconnecter </button>
                </form>
            </li>

            <a href="../client_side/mon_profil.php"></a>
      
        </ul>
    </aside>

    <main>
        <?
            
            if(isset($_POST["demandelist"])){ 
                include '../client_side/mes_demandes.php';
            }

            if(isset($_POST["mesparametere"])){ 
                include '../client_side/mes_parametere.php';
            }

            


            if(isset($_POST["supprimercompte"])){ 
                include '../client_side/supprimer_compte.php';
            }


            if(isset($_POST["supprimercompte_definitive"]))
            { 
                include '../client_side/supprimercompte_definitive.php';
            }


            if(isset($_POST["deconnecter"])){ 
                echo "<h1 style=color:red;>" . " se deconnecter   " . "</h1>";
            }


            if(isset($_POST["modif"]))
            { 
                $username = "root";
                $password = "root";
                $con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");


                echo  $_SESSION["client"];
                // ancien 
                $ancien_email = htmlspecialchars($_POST["ancien_email"],ENT_COMPAT) ;
                $ancien_password = htmlspecialchars($_POST["ancien_motpasse"],ENT_COMPAT) ;


                // nouveau 

                $nouveau_email = htmlspecialchars($_POST["nouveau_email"],ENT_COMPAT) ;
                $nouveau_password = htmlspecialchars($_POST["nouveau_motpasse"],ENT_COMPAT) ;
                $nouveau_password = password_hash($nouveau_password, PASSWORD_DEFAULT);
                

                if(($ancien_email != $nouveau_email) && ($ancien_password != $nouveau_password))
                { 
                    $req =  $con->prepare("SELECT * FROM client WHERE id = :idc");
                    $req->bindParam("idc",$_SESSION["client"],PDO::PARAM_INT);

                   
                    if($req->execute())
                    {
                        $req = $req->fetchObject();

                        if(($req->email === $ancien_email)&&(password_verify($ancien_password,$req->passworde)))
                        {       
                                $req2 = $con->prepare("UPDATE client SET email = :mail ,passworde = :pass WHERE id = :idcc");
                                $req2->bindParam("mail",$nouveau_email,PDO::PARAM_STR);
                                $req2->bindParam("pass",$nouveau_password,PDO::PARAM_STR);
                                $req2->bindParam("idcc",$_SESSION["client"],PDO::PARAM_INT);

                                $req_update_demande = $con->prepare("UPDATE demande SET emailuser = :email WHERE client = :idc");
                                $req_update_demande->bindParam("email",$nouveau_email,PDO::PARAM_STR);
                                $req_update_demande->bindParam("idc",$_SESSION["client"],PDO::PARAM_INT);


                                if(($req2->execute()) && ($req_update_demande->execute()))
                                {
                                    echo "<h3 style=color:green;text-align:center;margin-top:100px;>"  . "modifier avec succes" . "</h3>";
                                    header("refresh:4,url=../client_side/main.php");
                                    exit;
                                }
                                else
                                { 
                                    echo "<h3 style=color:red;text-align:center;margin-top:100px;>"  . "il y'a un probleme quelque part" . "</h3>";
                                    header("refresh:4,url=../client_side/mon_profil.php");
                                    exit;
                                }
                        }
                        else 
                        {
                            echo "erreur verifier l'anciem mot de passe et l'ancien email";
                            header("refresh:4,url=../client_side/mon_profil.php");
                            exit;
                        }
                    }
                }


            }


           
            if(isset($_POST["supp"]))
            { 
                
                $username = "root";
                $password = "root";
                $con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");

                $supprime_request = $con->prepare("DELETE FROM client WHERE id = :ids");
                $supprime_request->bindParam("ids",$_SESSION["client"],PDO::PARAM_STR);
                if($supprime_request->execute())
                { 
                    echo "<h3 style=color:green;>"  . "supprimer avec succes" . "</h3>";
                    header("refresh:2,url=../client_side/main.php");
                    exit;
                }
                else
                { 
                    echo "<h3 style=color:red;>"  . "il y'a un probleme " . "</h3>";
                    header("refresh:2,url=../client_side/main.php");
                    exit;
                }

            }

                if(isset($_POST["deconnecter"]))
                { 
                    header("refresh:2,url=../client_side/main.php");
                    exit;
                }


           
        ?>
    </main>
</body>
</html>