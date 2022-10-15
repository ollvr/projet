
    var myform = document.getElementById("formsend");
    var dataform = new FormData(myform)

   
    function envoi ()
        
    { 
        

        var myrequest= new XMLHttpRequest()
        myrequest.onreadystatechange=function()
        { 

            if((this.readyState==4)&&(this.status==200))
            { 
                console.log(this.responseText);
            }

        }

        myrequest.open(
            "POST",
            "http://localhost/projet/client_side/mes_params.php",
            true
        )
        myrequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        myrequest.send("name=sami");
    }

    envoi();