/*Objetos de las propiedades de los formularios*/

var pf = {
entradas: document.querySelectorAll("input.validar"),
valor: null
}

/*El Objeto de los metodos del formulario */

var mf = {
inicioFormulario: function(){
   for(var i=0; i< pf.entradas.length; i++){
    pf.entradas[i].addEventListener("focus",mf.enFoco);
    pf.entradas[i].addEventListener("blur",mf.fueraFoco)
   }
  
},
enFoco: function(input){
  pf.valor = input.target.value;
 
  if (pf.valor == ""){

    document.querySelector("#"+input.target.id).style.background = "rgba(255,255,0,.5)";
    document.querySelector("[for="+input.target.id+"] .obligatorio").style.opacity =1;
  }

},
fueraFoco: function (input){
  document.querySelector("#"+input.target.id).style.background = "white";
  
  document.querySelector("[for="+input.target.id+"] .obligatorio").style.opacity = 0;
}

}
mf.inicioFormulario();