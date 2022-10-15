<? 

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require './vendor/autoload.php';



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


$req = $con->prepare("SELECT demande.nom,demande.emailuser,demande.teluser,demande.ville,demande.adres,demande.desci,demande.datedemande,demande_teh.idtech FROM demande , demande_teh WHERE demande_teh.idm = :idd AND demande.id = :idd;");
$req->bindParam("idd",$f);

$req2 = $con->prepare("SELECT email FROM adminsit;");



if(($req->execute()) && ($req2->execute()))
{
    $req = $req->fetchAll();

    $req2 = $req2->fetchObject();

   if(count($req)>1)
   {
        echo "  Ce client est affecte a plusieurs technicien !" . "<br>";
   }


    $user_name = $req[0]["nom"];
    $email_user = $req[0]["emailuser"];
    $user_phone = $req[0]["teluser"];
    $user_town = $req[0]["ville"];
    $user_addr = $req[0]["adres"];
    $user_desci = $req[0]["desci"];
    $date_demande = $req[0]["datedemande"];


    $tech_id = $req[0]["idtech"];

    $admin_email = $req2->email;

      
     
     

  $msg = 
  '
        Salut '.$user_name.'<br>
        vous avez envoyer une demande le '.$date_demande.'<br>
        par rapport le sujet '.$user_desci.'<br>
        confirmation :
        votre numero telephone : '.$user_phone.'
        vous habite dans :'.$user_town.' avec ladresse : '.$user_addr.'<br>
        
        sil vous plait s"il ya un changament de vos cordonnes :
        <br>
        modifier votre demandes dans les paramtres de votre compte 
        <br>
        ou bien si vous n"avez pas un compte contactez nous sur numero telephone 50222320
        <br>
        on va vous appeller sur le numero telephone que vous avez specifier 
        dans la demande 

   
  ';


   try 
   {
      $mail = new PHPMailer();



     

      $mail->isSMTP();

     
      $mail->SMTPDebug = SMTP::DEBUG_SERVER;

     
      $mail->Host = 'smtp.gmail.com';
      
      
      $mail->Port = 465;

      $mail->SMTPSecure = 'ssl';

      $mail->SMTPKeepAlive = true;

      
      $mail->SMTPAuth = true;

      
      $mail->Username = 'omarobouhawelo15@gmail.com';

      
      $mail->Password = 'foyxsdqvocbzbyxn';

     
      $mail->setFrom("$admin_email",'SIT');

      
      $mail->addReplyTo("$admin_email", 'SIT');

     
      $mail->addAddress("$email_user");
      $mail->addCC("$email_user");

    
      $mail->Subject = 'SIT: Email de confirmation de demande ';

      $mail->Body = "$msg";

      $mail->isHTML(true);

     
      if ($mail->send()) 
      {

            echo "<h1 style='color:green'>" . "email envoyee !". "</h1>";

            $req2 = $con->prepare("UPDATE demande_teh SET email_sended = 'oui' WHERE idm = :id_demande");
            $req2->bindParam("id_demande",$f);

            if($req2->execute())
            { 
                 echo  "ce mail est enregistrer a ce client ";
                 header("refresh:4,url=../admin_side/mes_demandes.php");
                 exit;
            }
      } 

      else 
      {
         echo "<h1 style='color:red'>" . 'erreur !' . "</h1>";
         
         header("refresh:4,url=../admin_side/mes_demandes.php");
         exit;

      }

   } 
   
   catch (\Throwable $th) 
   {
      echo 'Mailer Error: ' . $mail->ErrorInfo;
      
      header("refresh:4,url=../admin_side/mes_demandes.php");
      exit;
   }
       
 
   
}



