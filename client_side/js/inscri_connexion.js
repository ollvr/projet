var inscri_button = document.getElementById("inscri")  // s'inscrire from navbar link 
var conexion = document.getElementById("connexion")

var nav = document.getElementById("nav");
var main_content = document.getElementById("main_content");
var div_aside = document.getElementById("div_aside");


var w = document.querySelector("body")
console.log(w.offsetWidth)
var logo = document.getElementById("logo")


var m = document.getElementById("container")
var c = document.getElementById("closee")

var m2 =  document.getElementById("container2")
var c2 = document.getElementById("closee2")
var button_already = document.getElementById("account")


var menu = document.getElementById("menu");
var navitem = document.getElementById("el")
var menu_container = document.getElementById("menucontainer")

var show = false

menu.addEventListener("click",()=>
{ 
    show = !show;
    if(show)
    {
       
        navitem.style.cssText += "visibility:visible;flex-direction:column;gap:0px;"
        
        
    }
    else {
        navitem.style.cssText += "visibility:hidden;"
    }
   
})




var container1_diplayed = 0 
function visible () 
{ 
    nav.style.cssText += "opacity:1"
    main_content.style.cssText += "opacity:1"
    div_aside.style.cssText += "opacity:1"
}



function invisible(){ 
    nav.style.cssText += "opacity:0.1"
    main_content.style.cssText += "opacity:0.1"
    div_aside.style.cssText += "opacity:0.1"
}



function display_model( ) 
{ 
    m.style.cssText="visibility:visible";
}


function invisible_model1()
{
    m.style.cssText = "opacity:0.1"
    m.style.cssText="visibility:hidden";
}


function display_model2(){
    m2.style.cssText="visibility:visible";
}


inscri_button.addEventListener("click",()=>
{   display_model()
    invisible()
    container1_diplayed = 1
})


c.addEventListener("click",()=>
{   
    m.style.cssText+="opacity:0.1";
    setTimeout(()=>{ 
       
         m.style.cssText="visibility:hidden";
         visible()
    },1000)
   
    
})



button_already.addEventListener("click",()=>
{ 
    invisible_model1()
    setTimeout(display_model2,800)
    
})


c2.addEventListener("click",()=>
{   
    m2.style.cssText+="opacity:0.1";
    setTimeout(()=>{ 
       
         m2.style.cssText="visibility:hidden";
         visible()
    },1000)
   
    
})


conexion.addEventListener("click",()=>
{ 
    invisible()
    display_model2()
})





// inscrire validation 

const nom = document.getElementById("nom")
const phone = document.getElementById("phone")
const pass = document.getElementById("pass")
const cpass = document.getElementById("cpass")
const inscri = document.getElementById("inscrire")


function check(nom,phone,password,cpass)
{ 
return (nom=="")||(phone=="")||(password=="")||(cpass=="")
}


function phone_number_validation(numero_tel){ 
    var express=/^[0-9]{8}$/
     return express.test(numero_tel)
}


inscri.addEventListener("click",(e)=>{ 
    var err = document.getElementById("error")
    
    if(check(nom.value,phone.value,pass.value,cpass.value))
    {
        

        err.innerText = "notez bien que les champs nom , numero telephone , password ,confirm passwoed ne doivent pas etre vide"
        err.style.cssText = "color:red";
        e.preventDefault()
       
    }

    
    else if(!phone_number_validation(phone.value)){ 
        err.innerText = "notez bien que le numero telephone doit etre 8 chiffres et non vide"
        err.style.cssText = "color:red";
        e.preventDefault()
    }
   
    else if(pass.value != cpass.value){ 
        err.innerText = "la confirmation de mot de passe est incorrecte"
        err.style.cssText = "color:red";
        e.preventDefault()
    }

   
   
})



