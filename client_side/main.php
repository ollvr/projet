<?php 

session_start();
$_SESSION["client"] = 0;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIT</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/responsive/mainrespo.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
</head>
<body>
    <div class="menu_container" id="menucontainer">
        <img src="../images/menu.png"  class="menu" id="menu">
    </div>
    
    <nav class="headernav" id="nav">
        <ul id="el"> 
        <li class="nava"> 
            <a href="#"> <img src="../images/logo.png" width="60px" height="50px" id="logo"></a>  
        </li>
        <li id="service"> <a href="../client_side/service_commerciale.php" target="_blanck"> Service commerciale </a>  </li>
        <li> <a href="./Contactez_nous.php">contactez nous </a> </li>
        <li> <a href="#" id="inscri"> s'inscrire </button> </li>
        <li> <a  id="connexion"> connexion </button> </li>
        </ul>
    </nav>

    <main id="main_content">
        <article>
            <p id="titre"> 
                Tu as des problemes de maintenances informatiques &#129300;
              
            </p>

            <p>
            <br>
                <br>
                tu cherches le bon service et la bonne qualite de travail 
                <br>
                <br>
                alors voues etes dans la bonne place
                <br>
                <br>
            </p>

            <p>
                nous travaillons sur ces services de  maintenace : 
                <br>
                <br>
                   1 - tout probleme material et logiciel 
                   <br>
                   <br>
                   2-suppression de virus 
                   <br>
                   <br>
                    3 -administration du reseau 
                    <br>
                    <br>
                    4- installation de windows 
            </p>
            <a href="./plusinfo.php" target="_blanck">cliquez ici pour lire plus d'information sur nous</a>
            <br>
            <hr/>
            <h4 style="color:white; font-size:large">
                allez envoyer votre demande en cliquant sur le button ci dessous
                <br>
                 &#11015
            </h4>
            <div id="div_demande_a_button">
            <a href="./client_form.php" id="">envoyer une demande </a>
            </div>
            
        </article>
       
    </main>
   

    <div id="container">

        <form method="POST" id="inscrireform">
            <p class="close" id="closee">X</p>
            <h3> S'inscrire maintenant  </h3>
            <input type="text" name="user_name" id="nom" placeholder="mettez votre nom complet ... " required>
            <br>
            <br>
            <input type="email" name="user_email" id="email" placeholder="mettez votre email ... " required>
            <br>
            <br>
            <input type="text" name="user_phone" id="phone" placeholder="mettez votre numero telephone ... " required>
            <br>
            <br>
            <input type="password" name="user_password" id="pass" placeholder="mettez mot de passe  ... " required>
            <br>
            <br>
            <input type="password" name="confirm_password"  id="cpass" placeholder="confirmer mot de passe ... " required>
            <br>
            <br>
            <button type="submit" id="inscrire" name="inscri">s'inscrire</button> <a id="account"> j'ai deja un compte </a>
        </form>

            <p id="error"></p>
    </div>

    
   <div id="containermessagemodal">
        <p id="messagemodal"></p>
   </div>


    <div id="container2">

        <form method="POST">
        <p class="close" id="closee2">X</p>
        <h3> Se connecter  </h3>
        <input type="text" name="user_email" placeholder="mettez votre email  ... ">
        <br>
        <br>
        <input type="password" name="user_password" placeholder="mettez mot de passe  ... ">
        <br>
        <br>
        <button type="submit" name="connexion">connexion </button>
        </form>

    </div>



    
    <aside class="right_div" id="div_aside">
        <h1 style="color:red">SIT est toujours pour votre service </h1>
        <div class="content">
            <img src="../images/main_image.jpg">
        </div>
        <form method="POST">
            <label style="color:red">Que vous voulez dire pour nous </label>
            <br>
            <br>
            <textarea cols="50" rows="4" name="user_message">
               
            </textarea>
            <br>
            <button type="submit" name="ton_message">envoyer</button>
        </form>
    </aside>


   
   
   <script src="./js/inscri_connexion.js"></script>
</body>
</html>



<?php

        // inscription 
        if(isset($_POST["inscri"]))
        {
            

            $username = "root";
            $password = "root";
            $con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");
        
            $nom = htmlspecialchars($_POST["user_name"],ENT_COMPAT);
            $email = htmlspecialchars($_POST["user_email"],ENT_COMPAT);
            $phone = htmlspecialchars($_POST["user_phone"],ENT_COMPAT);
            $pass = htmlspecialchars($_POST["user_password"],ENT_COMPAT);
            $pass = password_hash($pass, PASSWORD_DEFAULT);
           
            $insert_req = $con->prepare(" INSERT INTO client (nomcomplet , email , numrotel, passworde) VALUES (:nom,:email,:phone,:pass)");
            $insert_req->bindParam("nom",$nom,PDO::PARAM_STR);
            $insert_req->bindParam("email",$email,PDO::PARAM_STR);
            $insert_req->bindParam("phone",$phone,PDO::PARAM_INT);
            $insert_req->bindParam("pass",$pass,PDO::PARAM_STR);
           
            
           
            if(($nom != "")&&($email !="")&&($phone != "")&&($pass != ""))
            {
                $insert_req->execute();
                                
                         echo "
                        <script>     
                            document.body.style.cssText =  'opacity : 0.3'
                            var container  = document.getElementById('containermessagemodal')
                            messagemodal =  document.getElementById('containermessagemodal')
                            container.style.cssText += 'visibility:visible'
                            messagemodal.innerText += 'bien tu es inscri '
                            messagemodal.style.cssText += 'text-align:center;color:crimson;font-size:large;line-height:88px;'

                            setTimeout(()=>{ 

                                container.style.cssText += 'visibility:hidden'
                                document.body.style.cssText =  'opacity : 1'
                                
                        },2000)
                        
                        </script>";
                    
                   
                    
                }
            
              
        }
        
    ?>


<?php 
// connexion 

if(isset($_POST['connexion']))
{ 
    
    $username = "root";
    $password = "root";
    $con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");
    
    $email = htmlspecialchars($_POST["user_email"],ENT_COMPAT);
    $pass = htmlspecialchars($_POST["user_password"],ENT_COMPAT);

    $email = trim($email);

    $select_req = $con->prepare("SELECT * FROM client WHERE email LIKE '%$email%'");
   
    
    if($select_req->execute())
    { 
       
        $select_req = $select_req->fetchObject();
        
        
        if(password_verify($pass,$select_req->passworde))
        {    
            $_SESSION["client"] = $select_req->id;
            header("refresh:2,url=../client_side/client_account.php");
            exit;
        }
        

    }

    
}



?>


<?


// envoi des avis 

if(isset($_POST["ton_message"]))
{

$username = "root";
$password = "root";
$con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");


$user_message = trim(htmlspecialchars($_POST["user_message"],ENT_COMPAT));

$check_number = $con->prepare("SELECT * FROM  reviews ");
if($check_number->execute())
{ 
    if($check_number->rowCount()<5)
    { 
        if($user_message != "")
        {
            $req_avis =  $con->prepare("INSERT INTO reviews (messagee) VALUES (:messagee) ");
            $req_avis->bindParam("messagee",$user_message,PDO::PARAM_STR);

            if($req_avis->execute())
            {
                echo '<h4 style="color:green;">' . "merci pour votre avis " . '</h4>';
                header("refresh:4,url=../client_side/main.php");
            }

        }
        else
        { 
            echo '<h4 style="color:red;">' . " ecrivez queleque chose !  " . '</h4>';
            header("refresh:4,url=../client_side/main.php");
        }
    }
    else
    { 
        file_put_contents('avis.txt', $user_message);
        $delete_old_messages = $con->prepare("DELETE FROM reviews");
        if($delete_old_messages->execute())
        { 
            echo '<h4 style="color:green;">' . "merci pour votre avis " . '</h4>'; 
            header("refresh:4,url=../client_side/main.php"); 
        }
    }
}





}


?>