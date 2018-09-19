/*Objetos de las propiedades de los formularios*/

var pf = {
  entradas: document.querySelectorAll("input.validar"),
  valor: null,
  validarUsuario: false
}

/*El Objeto de los metodos del formulario */

var mf = {
  inicioFormulario: function () {
    for (var i = 0; i < pf.entradas.length; i++) {
      pf.entradas[i].addEventListener("focus", mf.enFoco);
      pf.entradas[i].addEventListener("blur", mf.fueraFoco);
      pf.entradas[i].addEventListener("change", mf.changeinput)
    }

  },
  enFoco: function (input) {
    pf.valor = input.target.value;

    if (pf.valor == "") {

      document.querySelector("#" + input.target.id).style.background = "rgba(255,255,0,.5)";
      document.querySelector("[for=" + input.target.id + "] .obligatorio").style.opacity = 1;
    }
document.querySelector("[for="+input.target.id+"]") .appendChild(document.createElement("div")).setAttribute("class","error") 
  },
  fueraFoco: function (input) {
    document.querySelector("#" + input.target.id).style.background = "white";
    document.querySelector("[for=" + input.target.id + "] .obligatorio").style.opacity = 0;
  },
  changeinput: function (input) {
    pf.valor = input.target.value;

    if (pf.valor != "") {

      switch (input.target.id) {
        case "nombre":
          if (pf.valor.length < 2 || pf.valor.length > 10) {
            document.querySelector("[for=" + input.target.id + "] .error").innerHTML = '<span style="color:red">* Error al Ingresar los datos:' + input.target.placeholder + '</span>';
            pf.validarUsuario = false;
          } else {
            document.querySelector("[for="+input.target.id+"] .error").parentNode.removeChild(document.querySelector("[for=" + input.target.id+"] .error"))

            pf.validarUsuario = true;
            break;
          }

      }
    }
  }

}
mf.inicioFormulario();