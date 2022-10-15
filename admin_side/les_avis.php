<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les avis</title>
    <style>
        body{ 
            background-color: black;
        }
        p{ 
            font-size: large;
            color:whitesmoke;
        }
        h3{
            color:crimson;
            font-size: larger;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    
</body>
</html>
<?


$username = "root";
$password = "root";
$con =  new PDO("mysql:host=localhost;dbname=sit;charset=utf8;",$username,$password) or die("probleme de connexion");


$mes_avis = $con->prepare("SELECT * FROM reviews");
echo "<h3>" . "les avis " . "</h3>";
if($mes_avis->execute())
{ 
    $mes_avis = $mes_avis->fetchAll();

    for ($i=0; $i <count($mes_avis) ; $i++) 
    { 
        echo 
        '   
            <p>'.$mes_avis[$i]["messagee"].'</p>

        '  ;
    }
}










?>