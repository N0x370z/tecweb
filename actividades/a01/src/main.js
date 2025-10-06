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

// ========== JS03 - Estructuras de Condición ==========
// Ejemplo pág. 3: Estructura Secuencial
function ejemplo4() {
    console.log("Ejecutando ejemplo 4 - Estructura Secuencial");
    var valor1;
    var valor2;
    valor1 = prompt('Introducir primer número:', '');
    valor2 = prompt('Introducir segundo número', '');
    var suma = parseInt(valor1) + parseInt(valor2);
    var producto = parseInt(valor1) * parseInt(valor2);
    
    var resultado = 'La suma es ' + suma + '<br>El producto es ' + producto;
    document.getElementById('resultado4').innerHTML = resultado;
}

// Ejemplo pág. 8: Sentencia if
function ejemplo5() {
    console.log("Ejecutando ejemplo 5 - Sentencia if");
    var nombre;
    var nota;
    nombre = prompt('Ingresa tu nombre:', '');
    nota = prompt('Ingresa tu nota:', '');
    
    var resultado = '';
    if (nota >= 4) {
        resultado = nombre + ' esta aprobado con un ' + nota;
    } else {
        resultado = 'No se mostró mensaje (nota menor a 4)';
    }
    document.getElementById('resultado5').innerHTML = resultado;
}

// Ejemplo pág. 11: Sentencia if-else
function ejemplo6() {
    console.log("Ejecutando ejemplo 6 - Sentencia if-else");
    var num1, num2;
    num1 = prompt('Ingresa el primer número:', '');
    num2 = prompt('Ingresa el segundo número:', '');
    num1 = parseInt(num1);
    num2 = parseInt(num2);
    
    var resultado = '';
    if (num1 > num2) {
        resultado = 'el mayor es ' + num1;
    } else {
        resultado = 'el mayor es ' + num2;
    }
    document.getElementById('resultado6').innerHTML = resultado;
}

// Ejemplo pág. 15-16: Sentencia if-else anidadas
function ejemplo7() {
    console.log("Ejecutando ejemplo 7 - If-else anidadas");
    var nota1, nota2, nota3;
    nota1 = prompt('Ingresa 1ra. nota:', '');
    nota2 = prompt('Ingresa 2da. nota:', '');
    nota3 = prompt('Ingresa 3ra. nota:', '');
    
    nota1 = parseInt(nota1);
    nota2 = parseInt(nota2);
    nota3 = parseInt(nota3);
    var pro;
    pro = (nota1 + nota2 + nota3) / 3;
    
    var resultado = 'Promedio: ' + pro.toFixed(2) + ' - ';
    if (pro >= 7) {
        resultado += 'Aprobado';
    } else {
        if (pro >= 4) {
            resultado += 'Regular';
        } else {
            resultado += 'Reprobado';
        }
    }
    document.getElementById('resultado7').innerHTML = resultado;
}

// Ejemplo pág. 18: Sentencia switch
function ejemplo8() {
    console.log("Ejecutando ejemplo 8 - Switch");
    var valor;
    valor = prompt('Ingresar un valor comprendido entre 1 y 5:', '');
    valor = parseInt(valor);
    
    var resultado = '';
    switch (valor) {
        case 1: resultado = 'uno';
            break;
        case 2: resultado = 'dos';
            break;
        case 3: resultado = 'tres';
            break;
        case 4: resultado = 'cuatro';
            break;
        case 5: resultado = 'cinco';
            break;
        default: resultado = 'debe ingresar un valor comprendido entre 1 y 5.';
    }
    document.getElementById('resultado8').innerHTML = resultado;
}

// Ejemplo pág. 21: Switch con colores
function ejemplo9() {
    console.log("Ejecutando ejemplo 9 - Switch con colores");
    var col;
    col = prompt('Ingresa el color con que quieras pintar el fondo de la ventana (rojo, verde, azul)', '');
    
    switch (col) {
        case 'rojo': document.bgColor = '#ff0000';
            break;
        case 'verde': document.bgColor = '#00ff00';
            break;
        case 'azul': document.bgColor = '#0000ff';
            break;
    }
    document.getElementById('resultado9').innerHTML = 'Color de fondo cambiado a: ' + col;
}

// ========== JS04 - Estructuras de Repetición ==========
// Ejemplo pág. 5: Sentencia while
function ejemplo10() {
    console.log("Ejecutando ejemplo 10 - While");
    var x;
    x = 1;
    var resultado = '';
    while (x <= 100) {
        resultado += x + '<br>';
        x = x + 1;
    }
    document.getElementById('resultado10').innerHTML = resultado;
}

// Ejemplo pág. 6: Concepto de acumulador
function ejemplo11() {
    console.log("Ejecutando ejemplo 11 - Acumulador");
    var x = 1;
    var suma = 0;
    var valor;
    while (x <= 5) {
        valor = prompt('Ingresa el valor:', '');
        valor = parseInt(valor);
        suma = suma + valor;
        x = x + 1;
    }
    document.getElementById('resultado11').innerHTML = "La suma de los valores es " + suma;
}

// Ejemplo pág. 12: Sentencia do-while
function ejemplo12() {
    console.log("Ejecutando ejemplo 12 - Do-While");
    var valor;
    var resultado = '';
    do {
        valor = prompt('Ingresa un valor entre 0 y 999:', '');
        valor = parseInt(valor);
        resultado += 'El valor ' + valor + ' tiene ';
        if (valor < 10)
            resultado += '1 dígito';
        else
            if (valor < 100) {
                resultado += '2 dígitos';
            } else {
                resultado += '3 dígitos';
            }
        resultado += '<br>';
    } while (valor != 0);
    document.getElementById('resultado12').innerHTML = resultado;
}

// Ejemplo pág. 16: Sentencia for
function ejemplo13() {
    console.log("Ejecutando ejemplo 13 - For");
    var f;
    var resultado = '';
    for (f = 1; f <= 10; f++) {
        resultado += f + " ";
    }
    document.getElementById('resultado13').innerHTML = resultado;
}

// ========== JS05 - Funciones ==========
// Ejemplo pág. 6: Función simple
function ejemplo14() {
    console.log("Ejecutando ejemplo 14 - Función simple");
    
    function mostrarMensaje() {
        return "Cuidado<br>Ingresa tu documento correctamente<br>";
    }
    
    var resultado = '';
    resultado += mostrarMensaje();
    resultado += mostrarMensaje();
    resultado += mostrarMensaje();
    
    document.getElementById('resultado14').innerHTML = resultado;
}

// Ejemplo pág. 7: Función con parámetros
function ejemplo15() {
    console.log("Ejecutando ejemplo 15 - Función con parámetros");
    
    function mostrarMensajeParam() {
        var msg = "Cuidado<br>Ingresa tu documento correctamente<br>";
        return msg;
    }
    
    var resultado = mostrarMensajeParam() + mostrarMensajeParam() + mostrarMensajeParam();
    document.getElementById('resultado15').innerHTML = resultado;
}

// Ejemplo pág. 10: Función con datos de entrada
function ejemplo16() {
    console.log("Ejecutando ejemplo 16 - Función con datos de entrada");
    
    function mostrarRango(x1, x2) {
        var inicio;
        var resultado = '';
        for (inicio = x1; inicio <= x2; inicio++) {
            resultado += inicio + ' ';
        }
        return resultado;
    }
    
    var valor1, valor2;
    valor1 = prompt('Ingresa el valor inferior:', '');
    valor1 = parseInt(valor1);
    valor2 = prompt('Ingresa el valor superior:', '');
    valor2 = parseInt(valor2);
    
    var resultado = mostrarRango(valor1, valor2);
    document.getElementById('resultado16').innerHTML = resultado;
}

// Ejemplo pág. 13: Función con retorno
function ejemplo17() {
    console.log("Ejecutando ejemplo 17 - Función con retorno");
    
    function convertirCastellano(x) {
        if (x == 1)
            return "uno";
        else
            if (x == 2)
                return "dos";
            else
                if (x == 3)
                    return "tres";
                else
                    if (x == 4)
                        return "cuatro";
                    else
                        if (x == 5)
                            return "cinco";
                        else
                            return "valor incorrecto";
    }
    
    var valor = prompt("Ingresa un valor entre 1 y 5", "");
    valor = parseInt(valor);
    var r = convertirCastellano(valor);
    document.getElementById('resultado17').innerHTML = r;
}

// Ejemplo pág. 15: Función con switch
function ejemplo18() {
    console.log("Ejecutando ejemplo 18 - Función con switch");
    
    function convertirCastellano(x) {
        switch (x) {
            case 1: return "uno";
            case 2: return "dos";
            case 3: return "tres";
            case 4: return "cuatro";
            case 5: return "cinco";
            default: return "valor incorrecto";
        }
    }
    
    var valor = prompt("Ingresa un valor entre 1 y 5", "");
    valor = parseInt(valor);
    var r = convertirCastellano(valor);
    document.getElementById('resultado18').innerHTML = r;
}
