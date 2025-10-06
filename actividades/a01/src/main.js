// Función original del proyecto
function getDatos() {
    var nombre = prompt("Nombre: ", "");
    var edad = prompt("Edad: ", 0);
    var div1 = document.getElementById('nombre');
    div1.innerHTML = '<h3> Nombre: ' + nombre + '</h3>';
    var div2 = document.getElementById('edad');
    div2.innerHTML = '<h3> Edad: ' + edad + '</h3>';
}

// ========== JS01 - Introducción a JavaScript ==========
// Ejemplo pág. 8: Hola Mundo
function ejemplo1() {
    console.log("Ejecutando ejemplo 1 - Hola Mundo");
    document.getElementById('resultado1').innerHTML = "Hola Mundo";
}

// ========== JS02 - Variables, Entradas y Operadores ==========
// Ejemplo pág. 6: Variables
function ejemplo2() {
    console.log("Ejecutando ejemplo 2 - Variables");
    var nombre = 'Juan';
    var edad = 10;
    var altura = 1.92;
    var casado = false;
    
    var resultado = nombre + '<br>' + edad + '<br>' + altura + '<br>' + casado;
    document.getElementById('resultado2').innerHTML = resultado;
}

// Ejemplo pág. 12: Entrada de datos por teclado
function ejemplo3() {
    console.log("Ejecutando ejemplo 3 - Entrada de datos");
    var nombre;
    var edad;
    nombre = prompt('Ingresa tu nombre:', '');
    edad = prompt('Ingresa tu edad:', '');
    
    var resultado = 'Hola ' + nombre + ' así que tienes ' + edad + ' años';
    document.getElementById('resultado3').innerHTML = resultado;
}
