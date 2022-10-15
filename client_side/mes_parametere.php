<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes parameteres </title>
    <style>

        h3{ 
            color: cadetblue;
        }

        .hide{ 
            position:absolute; top:-1px; left:-1px; width:1px; height:1px; 
        }
        #m{ 
            background: black;
            color: crimson;
            border-radius: 7px;
            border: 1px solid magenta;
            width: 134px;
            height: 30px;
        }
    </style>
</head>
<body>
    <h3>
        vous pouvez changer vos paramteres du compte : 
    </h3>

    
  
    <form  method="post" id="formsend">
        <input type="email" name="ancien_email" placeholder="mettez votre ancien email" required>
        <br>
        <br>
        <input type="password" name="ancien_motpasse" placeholder="mettez votre ancien mot de passe" required>
        <br>
        <br>
        <input type="email" name="nouveau_email" placeholder="mettez votre nouveau email"  required>
        <br>
        <br>
        <input type="password" name="nouveau_motpasse" placeholder="mettez votre nouveau mot de passe " required>
        <br>
        <br>
        <button type="submit" id="m" name="modif">Modifier</button>
    </form>

    	
</body>
</html>

