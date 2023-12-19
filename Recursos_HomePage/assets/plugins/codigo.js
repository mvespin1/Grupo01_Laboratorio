
function mostrarimg(){
document.getElementById('cont2').innerHTML='<img src="images/firefox.png">';
}

function grupo() {
    var demo = document.getElementById("grupo");
    demo.style.color = "green";
}

function myFunction() {
    var x = document.getElementsByClassName("example");
    x[0].innerHTML = "Hola Mundo";
}   

function addText() {
    var para = document.getElementsByName("demoPara");
    para[0].innerHTML="Texto cambiado!";
    para[1].innerHTML = "El grupo 03 "
      + "ha realizado esto con JavaScript";
}

function displayPhrase()
{
    document.getElementById("p1").innerHTML = "Este texto fue remplazado";
}

function formsfuncion() {
    var txt = document.getElementById(
      "idformulario1").id;

    document.getElementById(
      "forms1").innerHTML = txt;
}

//EJEMPLO 1 EVENT_LISTENER
document.getElementById("boton").addEventListener("click", cambioColor);

  function cambioColor() {
    var div = document.getElementById("division");
    div.style.backgroundColor = "skyblue";
  }

//EJEMPLO 2 EVENT_LISTENER
var x = document.getElementById("boton2");
x.addEventListener("mouseover", cambioColor1);
x.addEventListener("click", cambioColor2);
x.addEventListener("mouseout", cambioColor3);

function cambioColor1() {
  div = document.getElementById("division2");
  div.style.backgroundColor = "skyblue";
}

function cambioColor2() {
  div = document.getElementById("division2");
  div.style.backgroundColor = "red";
}

function cambioColor3() {
  div = document.getElementById("division2");
  div.style.backgroundColor = "orange";
}

//EJEMPLO 3 EVENT_LISTENER
window.addEventListener("click", cambiarTexto);

function cambiarTexto() {
  var text = document.getElementById("demo3").innerHTML = "Texto Cambiado";
}

//EJEMPLO 4 EVENT_LISTENER
let texto1 = 'HOLA A ';
let texto2 = 'TODOS';

document.getElementById("boton4").addEventListener("click", function() {
  unirTextos(texto1, texto2);
});

function unirTextos(a, b) {
  document.getElementById("demo4").innerHTML = a + b;
}

//EJEMPLO 5 EVENT_LISTENER
document.getElementById("divisionEj5_2").addEventListener("click", function() {
  alert("CIRCULO NEGRO");
}, false);

document.getElementById("divisionEj5_1").addEventListener("click", function() {
  alert("CIRCULO VERDE");
}, false);

document.getElementById("divisionEj5_4").addEventListener("click", function() {
  alert("CIRCULO NEGRO");
}, true);

document.getElementById("divisionEj5_3").addEventListener("click", function() {
  alert("CIRCULO VERDE");
}, true);

//EJEMPLO 6 EVENT_LISTENER
document.getElementById("division6").addEventListener("mouseover", cambioColor6);

  function cambioColor6() {
    div = document.getElementById("division6");
    div.style.backgroundColor = "skyblue";
  }

  function removerFuncionColor() {
    document.getElementById("division6").removeEventListener("mouseover", cambioColor6);
    div.style.backgroundColor = "greenyellow";

  }

//EJEMPLO 1 NAVEGATION NODE
var valorNodoHijo = document.getElementById("hijo1").firstChild.nodeValue;
document.getElementById("hijo2").innerHTML = valorNodoHijo;

//EJEMPLO 4 NAVEGATION NODE
document.getElementById("titulo").innerHTML = document.getElementById("parrafo").nodeName;

//EJEMPLO 5 NAVEGATION NODE
document.getElementById("parrafoEj4_1").innerHTML = document.getElementById("tituloEj4_1").nodeType;
document.getElementById("parrafoEj4_2").innerHTML = document.getElementById("tituloEj4_2").nodeType;
document.getElementById("parrafoEj4_3").innerHTML = document.getElementById("tituloEj4_3").nodeType;

//EJEMPLO 1 NODE_LISTS
const listaNodos = document.querySelectorAll("h7");

document.getElementById("demoListaNodos1").innerHTML = "El primer párrafo es: " + listaNodos[0].innerHTML;
document.getElementById("demoListaNodos2").innerHTML = "El segundo párrafo es: " + listaNodos[1].innerHTML;
document.getElementById("demoListaNodos3").innerHTML = "El tercer párrafo es: " + listaNodos[2].innerHTML;
document.getElementById("demoListaNodos4").innerHTML = "El cuarto párrafo es: " + listaNodos[3].innerHTML;
document.getElementById("demoListaNodos5").innerHTML = "El quinto párrafo es: " + listaNodos[4].innerHTML;

//EJEMPLO 2 NODE_LISTS
const listaNodosEj2 = document.querySelectorAll("h8");

document.getElementById("demoNodosEj2").innerHTML = "El documento contiene  " + listaNodosEj2.length + " párrafos.";

//EJEMPLO 3 NODE_LISTS
function cambioColorListaNodos() {
  const listaNodosEj3 = document.querySelectorAll("h9");
  for (let i = 0; i < listaNodosEj3.length; i++) {
    listaNodosEj3[i].style.color = "greenyellow";
  }
}

intro.style.backgroundColor = '#00FFFF';