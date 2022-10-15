<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information </title>

    <style>
        body{ 
            background-color: black;
            font-size: larger;
        }


        h4{
          color:crimson;
          text-align: center;   
        }

        .titre{
            color:cadetblue;
        }

        p{
            color:white;
        }
        .container_flex
        { 
            width: 100%;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            margin-top: 140px;
            justify-content:space-between;
        }

        .child1
        { 
            width: 166px;
            height: 250px;
            color:red;
            border:1px solid rgb(29, 27, 27);

        }

        .child1:hover
        { 
            box-shadow: 0px 0px 9px white;
        }

        a{
            color:crimson;
            text-decoration: none;
        }


    </style>
</head>
<body>
<h4> Des informations sur les reusltats de notre travail </h4> 
    <div class="container_flex">
                                                          
        <div class="child1">
        <?
            $username =  $GLOBALS["user"]  = "root";
            $password = $GLOBALS["pass"] = "root";
            $con = $GLOBALS["connexion"] =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");

            date_default_timezone_set("Africa/Tunis");
            $date_today =  $GLOBALS["date_aujourdh'ui"] = date('Y-M-D');
            $req = $con->prepare("SELECT * FROM client");

            if($req->execute())
            { 
                echo "<p class='titre'>" . "nombre de client inscri ".   "</p>";
                echo "<p>" . $req->rowCount() .   "</p>";

            }


        ?>

        </div>

        <div class="child1">

            <?

                
            $req2 = $con->prepare("SELECT * FROM demande WHERE client = 0 ");
            if($req2->execute())
            { 
                echo "<p class='titre'>" . "nombre d'utilisateur qui ont envoye une demande ".  "</p>";
                echo "<p>" .  $req2->rowCount().  "</p>";
            }


            ?>

        </div>


        <div class="child1">

        <?

            $req3 = $con->prepare("SELECT * FROM demande WHERE client > 0 ");
            if($req3->execute())
            { 
                echo "<p class='titre'>" . "nombre de client qui ont envoye une demande ".  "</p>";
                echo "<p>" .  $req3->rowCount().  "</p>";
            }



        ?>
            

        </div>


       


        <div class="child1">

            <?

                $req6 = $con->prepare("SELECT * FROM demande WHERE datedemande = '$date_today' ");
                if($req6->execute())
                { 
                    echo "<p class='titre'>" . "nombre de demande envoyee aujourd'hui  ".  "</p>";
                    echo "<p>" .  $req6->rowCount().  "</p>";
                }


            ?>
            

        </div>


        <div class="child1">

            <?

                $req6 = $con->prepare("SELECT * FROM demande WHERE datedemande < '$date_today' ");
                if($req6->execute())
                { 
                    echo "<p class='titre'>" . "nombre de demande precedante  ".  "</p>";
                    echo "<p>" .  $req6->rowCount().  "</p>";
                }


            ?>


        </div>


      


        <div class="child1">

        <?

                $req5 = $con->prepare("SELECT * FROM technicien ");
                if($req5->execute())
                { 
                    echo "<p class='titre'>" . "nombre de technicien qu'on a dans la societe ".  "</p>";
                    echo "<p>" .  $req5->rowCount().  "</p>";
                }

        ?>

        </div>


        <div class="child1">

            <?

                    $req8 = $con->prepare("SELECT demande.id,demande.datedemande,demande_teh.idm , demande_teh.idtech FROM demande INNER JOIN demande_teh WHERE demande.id = demande_teh.idm AND demande.datedemande = '$date_today' AND demande_teh.idtech > 0;");
                    if($req8->execute())
                    { 
                        echo "<p class='titre'>" . "Nombre de technicien affecte a une demande aujourdh'ui ".  "</p>";
                        echo "<p>" . $req8->rowCount() . "</p>";
                       
                    }

            ?>

        </div>

    </div>
    
    <br>
    <br>
    <a href="../admin_side/admin_account.php">retour a le menu </a>
</body>
</html>