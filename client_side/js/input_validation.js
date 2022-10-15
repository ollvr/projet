var nom = document.getElementById("Nom")

var phone = document.getElementById("Phone")

var adresse = document.getElementById("Adresse")

var service_type  = document.getElementById("type_de_service")
var ville = document.getElementById("Ville")

var desc = document.getElementById("Desc")

var button_envoi = document.getElementById("envoi")


function check_vide(nom,phone,adresse,service_type,desc,ville){ 
    return (nom=="")||(phone=="")||(adresse=="")||(service_type=="")||(desc=="")||(ville=="")
}

function phone_number_validation(numero_tel){ 
   var express=/^[0-9]{8}$/
    return express.test(numero_tel)
}

button_envoi.addEventListener("click",(e)=>
{ 
    var err = document.getElementById("error")
    
    if(check_vide(nom.value,phone.value,adresse.value,service_type.value,desc.value,ville.value))
    {
        err.innerText = "notez bien que les champs nom , numero telephone , adresse  ,ville, service , description ne doivent pas etre vide"
        err.style.cssText = "color:red";
    }

    
    else if(!phone_number_validation(phone.value)){ 
        err.innerText = "notez bien que le numero telephone doit etre 8 chiffres et non vide"
        err.style.cssText = "color:red";
    }
   
    

   
})
