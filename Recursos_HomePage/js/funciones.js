//animaciones
//** tren*/
function animateTrain() {
  let start = Date.now();
  let train = document.getElementById('train');

  let timer = setInterval(function () {
    let timePassed = Date.now() - start;
    train.style.left = timePassed / 5 + 'px';

    if (timePassed > 2000) clearInterval(timer);
  }, 20);
}

document.getElementById('train').onclick = animateTrain;

document.getElementById('retryButton').onclick = function () {
  let train = document.getElementById('train');
  train.style.left = '0px';
  animateTrain();
};
//eventos
//** Los eventos onmouseover y onmouseout*/
function pintar() {
  // Obtiene todos los elementos <a> en la página
  var links = document.getElementsByTagName('a');

  // Obtiene la referencia al elemento del cuadrado con el id 'cuadrado1'
  var cuadrado = document.getElementById('cuadrado1');

  // Itera sobre todos los enlaces <a>
  for (var i = 0; i < links.length; i++) {
    // Agrega un evento 'mouseover' a cada enlace
    links[i].addEventListener('mouseover', function () {
      // Obtiene el color del atributo 'data-color' del enlace actual
      var color = this.getAttribute('data-color');
      // Asigna el color al fondo del cuadrado
      cuadrado.style.backgroundColor = color;
    });

    // Agrega un evento 'mouseout' a cada enlace
    links[i].addEventListener('mouseout', function () {
      // Restaura el fondo del cuadrado a color negro (#000)
      cuadrado.style.backgroundColor = '#000';
    });
  }
}

//segundo ejemplo

function mDown(obj) {
  obj.style.backgroundColor = "#8DCACB";
  obj.innerHTML = "NRC: 10038"
}

function mUp(obj) {
  obj.style.backgroundColor = "#35DC27";
  obj.innerHTML = "Aplicaciones de Fundamentos WEB "
}


//nodos
const para = document.createElement("p");
const node = document.createTextNode("Parrafo de prueba añadido mediante nodo");
para.appendChild(node);
const element = document.getElementById("div1.1");
element.appendChild(para);

function myFunction1() {
  document.getElementById("p1.1").remove();
}
//colecciones

function mifuncolecc1() {
  const myCollection = document.getElementsByTagName("p");
  for (let i = 0; i < myCollection.length; i++) {
    myCollection[i].style.backgroundColor = "yellow";
  }
}

function mifuncolecc2() {
  const myCollection = document.getElementsByTagName("p");
  for (let i = 0; i < myCollection.length; i++) {
    myCollection[i].style.backgroundColor = "white";
  }
}

function mifuncolecc3() {
  const myCollection = document.getElementsByTagName("p");
  for (let i = 0; i < myCollection.length; i++) {
    myCollection[i].style.color = "blue";
  }
}

function mifuncolecc4() {
  const myCollection = document.getElementsByTagName("p");
  for (let i = 0; i < myCollection.length; i++) {
    myCollection[i].style.color = "black";
  }
}


