//EJEMPLO 1
const textoJson1 = '{"nombre":"Jason", "edad":22, "pais":"Ecuador"}';
const persona1 = JSON.parse(textoJson1);
document.getElementById("demoJson1").innerHTML = persona1.nombre + " tiene la edad de: " + persona1.edad + " años.";

//EJEMPLO 2
const persona2 = {nombre:"Jason", edad:22, pais:"Ecuador"};
const textoJson2 = JSON.stringify(persona2);
document.getElementById("demoJson2").innerHTML = textoJson2;

//EJEMPLO XMLHttpRequest
function loadDoc() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      document.getElementById("demo").innerHTML = this.responseText;
    }
    xhttp.open("GET", "ajax.txt");
    xhttp.send();
}
  
//EJEMPLO 3
const persona3 = {"nombre":"Mario", "edad":54, "auto":null};
document.getElementById("demoJson3").innerHTML = persona3.nombre + " tiene " + persona3.edad + " años. ";

//EJEMPLO 4
const myJSON4 = '{"nombre":"Mario", "edad":54, "auto":null}';
const persona4 = JSON.parse(myJSON4);
document.getElementById("demoJson4").innerHTML = persona4.nombre;

//EJEMPLO 5 
const myJSON5 = '{"nombre":"Mario", "edad":54, "auto":null}';
const persona5 = JSON.parse(myJSON5);
document.getElementById("demoJson5").innerHTML = persona5["nombre"];

//EJEMPLO 6
const myJSON6 = '{"nombre":"Mario", "edad":54, "auto":null}';
const persona6 = JSON.parse(myJSON6);

let texto = "";
for (const x in persona6) {
  texto += x + ", ";
}
document.getElementById("demoJson6").innerHTML = texto;

//EJEMPLO 7
const myJSON7 = '{"nombre":"Mario", "edad":54, "auto":null}';
const persona7 = JSON.parse(myJSON7);

let texto7 = "";
for (const x in persona7) {
  texto7 += persona7[x] + ", ";
}
document.getElementById("demoJson7").innerHTML = texto7;

//EJEMPLO 8
const arreglo1 = ["Ford", "BMW", "Fiat"];
document.getElementById("demoJson8").innerHTML = arreglo1;

//EJEMPLO 9
const myJSON9 = '["Ford", "BMW", "Fiat"]';
const myArray = JSON.parse(myJSON9);
document.getElementById("demoJson9").innerHTML = myArray[2];

//EJEMPLO 10
const myJSON10 = '{"nombre":"Mario", "edad":54, "auto":["Ford", "BMW", "Fiat"]}';
const objeto1 = JSON.parse(myJSON10);

document.getElementById("demoJson10").innerHTML = objeto1.auto[1];

//EJEMPLO 11
const myJSON11 = '{"nombre":"Mario", "edad":54, "auto":["Ford", "BMW", "Fiat"]}';
const objeto2 = JSON.parse(myJSON11);

let text = "";
for (let i in objeto2.auto) {
  text += objeto2.auto[i] + ", ";
}

document.getElementById("demoJson11").innerHTML = text;

//EJEMPLO 12
const myJSON12 = '{"nombre":"Mario", "edad":54, "auto":["Ford", "BMW", "Fiat"]}';
const objeto3 = JSON.parse(myJSON12);

let text12 = "";
for (let i = 0; i < objeto3.auto.length; i++) {
  text12 += objeto3.auto[i] + ", ";
}

document.getElementById("demoJson12").innerHTML = text12;
