<? 

session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile administrateur </title>
    <link rel="stylesheet" href="../admin_side/admin_side_css/style.css">

    <style>
    body {
        font-size: larger;
        background-color: #e2dce2;
    }

    header {
        margin-top: 15px;
    }

    header h4 {
        text-align: center;
        color: #1d36a9;
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    }

    main {
        text-align: center;
        margin-top: 25px;
    }

    div a {
        text-align: center;
    }

    a {
        text-decoration: none;
        color: #ed4814;
    }
    </style>
</head>

<body>


    <header>
        <h4> profil administrateur </h4>
    </header>


    <main>

    <div class="shadow-lg p-3 mb-3 bg-body rounded"> <a href="../admin_side/affectation.php"
                target="_blanc"> Traiter mes demandes  </a></div>

    <div class="shadow-lg p-3 mb-3 bg-body rounded"> <a href="../admin_side/mes_demandes.php" target="_blanck">
                Envoyer les emails </a></div>

     
      

        <div class="shadow-lg p-3 mb-3 bg-body rounded"> <a href="../admin_side/ajout_technicien.php" target="_blanc">
                ajouter un techniciens a la societe </a></div>

        <div class="shadow-lg p-3 mb-3 bg-body rounded"> <a href="../admin_side/mes_technisiens.php" target="_blanc">
                Liste de mes techniciens </a></div>

        <div class="shadow-lg p-3 mb-3 bg-body rounded"> <a href="../admin_side/info.php" target="_blanc"> Info </a>
        </div>

        <div class="shadow-lg p-3 mb-3 bg-body rounded"> <a href="../admin_side/les_avis.php" target="_blanc"> Les avis  </a>
        </div>
       

        <div class="shadow-lg p-3 mb-3 bg-body rounded"> <a href="../admin_side/modif_mes_param.php"
                target="_blanc">Modifier les paramtere de mon compte </a></div>

        <div class="shadow-lg p-3 mb-3 bg-body rounded"> <a href="../admin_side/supprimer_compte.php" target="_blanc">
                Supprimer compte </a></div>


    </main>
</body>

</html>