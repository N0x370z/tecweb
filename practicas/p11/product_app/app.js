// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };

// FUNCIÓN CALLBACK DE BOTÓN "Buscar"
function buscarID(e) {
    /**
     * Revisar la siguiente información para entender porqué usar event.preventDefault();
     * http://qbit.com.mx/blog/2013/01/07/la-diferencia-entre-return-false-preventdefault-y-stoppropagation-en-jquery/#:~:text=PreventDefault()%20se%20utiliza%20para,escuche%20a%20trav%C3%A9s%20del%20DOM
     * https://www.geeksforgeeks.org/when-to-use-preventdefault-vs-return-false-in-javascript/
     */
    e.preventDefault();

    // SE OBTIENE EL ID A BUSCAR
    var id = document.getElementById('search').value;

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n'+client.responseText);
            
            // SE OBTIENE EL OBJETO DE DATOS A PARTIR DE UN STRING JSON
            let productos = JSON.parse(client.responseText);    // similar a eval('('+client.responseText+')');
            
            // SE VERIFICA SI EL OBJETO JSON TIENE DATOS
            if(Object.keys(productos).length > 0) {
                // SE CREA UNA LISTA HTML CON LA DESCRIPCIÓN DEL PRODUCTO
                let descripcion = '';
                    descripcion += '<li>precio: '+productos.precio+'</li>';
                    descripcion += '<li>unidades: '+productos.unidades+'</li>';
                    descripcion += '<li>modelo: '+productos.modelo+'</li>';
                    descripcion += '<li>marca: '+productos.marca+'</li>';
                    descripcion += '<li>detalles: '+productos.detalles+'</li>';
                
                // SE CREA UNA PLANTILLA PARA CREAR LA(S) FILA(S) A INSERTAR EN EL DOCUMENTO HTML
                let template = '';
                    template += `
                        <tr>
                            <td>${productos.id}</td>
                            <td>${productos.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;

                // SE INSERTA LA PLANTILLA EN EL ELEMENTO CON ID "productos"
                document.getElementById("productos").innerHTML = template;
            }
        }
    };
    client.send("id="+id);
}

// BÚSQUEDA POR TEXTO PARCIAL (nombre, marca o detalles)
function buscarProducto(e) {
    e.preventDefault();

    var term = document.getElementById('search').value;
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n' + client.responseText);

            let productos = JSON.parse(client.responseText);
            // productos es un arreglo; limpiar tabla si vacío
            if (!Array.isArray(productos) || productos.length === 0) {
                document.getElementById('productos').innerHTML = '';
                return;
            }

            let rows = '';
            for (let i = 0; i < productos.length; i++) {
                const p = productos[i];
                let descripcion = '';
                descripcion += '<li>precio: ' + p.precio + '</li>';
                descripcion += '<li>unidades: ' + p.unidades + '</li>';
                descripcion += '<li>modelo: ' + p.modelo + '</li>';
                descripcion += '<li>marca: ' + p.marca + '</li>';
                descripcion += '<li>detalles: ' + p.detalles + '</li>';

                rows += `
                        <tr>
                            <td>${p.id}</td>
                            <td>${p.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;
            }
            document.getElementById('productos').innerHTML = rows;
        }
    };
    client.send('q=' + encodeURIComponent(term));
}

// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto"
function agregarProducto(e) {
    e.preventDefault();

    // SE OBTIENE DESDE EL FORMULARIO EL JSON A ENVIAR
    var productoJsonString = document.getElementById('description').value;
    
    // SE CONVIERTE EL JSON DE STRING A OBJETO
    let finalJSON;
    try {
        finalJSON = JSON.parse(productoJsonString);
    } catch (err) {
        window.alert('ERROR: JSON inválido. Verifica el formato.');
        return;
    }
    
    // SE AGREGA AL JSON EL NOMBRE DEL PRODUCTO
    finalJSON['nombre'] = document.getElementById('name').value;
    
    // ==================== VALIDACIONES SEGÚN LA PRÁCTICA ====================
    
    // 1. Validar NOMBRE (obligatorio, máximo 100 caracteres)
    if(!finalJSON.nombre || typeof finalJSON.nombre !== 'string' || finalJSON.nombre.trim() === '') {
        window.alert('ERROR: El nombre es obligatorio.');
        return;
    }
    if(finalJSON.nombre.trim().length > 100) {
        window.alert('ERROR: El nombre debe tener máximo 100 caracteres.');
        return;
    }
    
    // 2. Validar MARCA (obligatorio, máximo 25 caracteres)
    if(!finalJSON.marca || typeof finalJSON.marca !== 'string' || finalJSON.marca.trim() === '' || finalJSON.marca.trim() === 'NA') {
        window.alert('ERROR: La marca es obligatoria.');
        return;
    }
    if(finalJSON.marca.trim().length > 25) {
        window.alert('ERROR: La marca debe tener máximo 25 caracteres.');
        return;
    }
    
    // 3. Validar MODELO (obligatorio, máximo 25 caracteres)
    if(!finalJSON.modelo || typeof finalJSON.modelo !== 'string' || finalJSON.modelo.trim() === '' || finalJSON.modelo.trim() === 'XX-000') {
        window.alert('ERROR: El modelo es obligatorio.');
        return;
    }
    if(finalJSON.modelo.trim().length > 25) {
        window.alert('ERROR: El modelo debe tener máximo 25 caracteres.');
        return;
    }
    
    // 4. Validar PRECIO (obligatorio, debe ser mayor a 99.99)
    if(finalJSON.precio === undefined || isNaN(Number(finalJSON.precio))) {
        window.alert('ERROR: El precio debe ser un número válido.');
        return;
    }
    let precio = Number(finalJSON.precio);
    if(precio <= 99.99) {
        window.alert('ERROR: El precio debe ser mayor a 99.99');
        return;
    }
    
    // 5. Validar DETALLES (obligatorio, máximo 250 caracteres)
    if(!finalJSON.detalles || typeof finalJSON.detalles !== 'string' || finalJSON.detalles.trim() === '' || finalJSON.detalles.trim() === 'NA') {
        window.alert('ERROR: Los detalles son obligatorios.');
        return;
    }
    if(finalJSON.detalles.trim().length > 250) {
        window.alert('ERROR: Los detalles deben tener máximo 250 caracteres.');
        return;
    }
    
    // 6. Validar UNIDADES (obligatorio, debe ser entero >= 0)
    if(finalJSON.unidades === undefined || isNaN(Number(finalJSON.unidades))) {
        window.alert('ERROR: Las unidades deben ser un número válido.');
        return;
    }
    let unidades = Number(finalJSON.unidades);
    if(unidades < 0 || !Number.isInteger(unidades)) {
        window.alert('ERROR: Las unidades deben ser un número entero mayor o igual a 0.');
        return;
    }
    
    // 7. Validar IMAGEN (opcional, establecer default si no existe)
    if(!finalJSON.imagen || typeof finalJSON.imagen !== 'string' || finalJSON.imagen.trim() === '') {
        finalJSON.imagen = 'img/default.png';
    }
    
    // ==================== FIN DE VALIDACIONES ====================
    
    // SE OBTIENE EL STRING DEL JSON FINAL
    productoJsonString = JSON.stringify(finalJSON, null, 2);

    // SE CREA EL OBJETO DE CONEXIÓN ASÍNCRONA AL SERVIDOR
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        // SE VERIFICA SI LA RESPUESTA ESTÁ LISTA Y FUE SATISFACTORIA
        if (client.readyState == 4 && client.status == 200) {
            console.log(client.responseText);
            try {
                const resp = JSON.parse(client.responseText);
                if (resp && resp.message) {
                    window.alert(resp.message);
                    // Si fue exitoso (ok === true), limpiar el formulario
                    if(resp.ok === true) {
                        document.getElementById('name').value = '';
                        document.getElementById('description').value = JSON.stringify(baseJSON, null, 2);
                    }
                } else {
                    window.alert('Operación completada.');
                }
            } catch (err) {
                window.alert(client.responseText);
            }
        }
    };
    client.send(productoJsonString);
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;

    try{
        objetoAjax = new XMLHttpRequest();
    }catch(err1){
        /**
         * NOTA: Las siguientes formas de crear el objeto ya son obsoletas
         *       pero se comparten por motivos historico-académicos.
         */
        try{
            // IE7 y IE8
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(err2){
            try{
                // IE5 y IE6
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(err3){
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}