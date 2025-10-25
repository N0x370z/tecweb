// JSON BASE A MOSTRAR EN FORMULARIO
let baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

// Función de inicialización
function init() {
    let JsonString = JSON.stringify(baseJSON, null, 2);
    $('#description').val(JsonString);
    listarProductos();
}

// Función para listar todos los productos
function listarProductos() {
    $.ajax({
        url: './backend/product-list.php',
        type: 'GET',
        success: function(response) {
            let productos = JSON.parse(response);
            
            if(Object.keys(productos).length > 0) {
                let template = '';
                
                productos.forEach(producto => {
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td>${producto.marca}</td>
                            <td>${producto.modelo}</td>
                            <td>${producto.precio}</td>
                            <td>${producto.unidades}</td>
                            <td>${producto.detalles}</td>
                            <td>
                                <button class="product-edit btn btn-warning btn-sm">
                                    Editar
                                </button>
                            </td>
                            <td>
                                <button class="product-delete btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                });
                
                $('#products').html(template);
            }
        }
    });
}

// Búsqueda en tiempo real (al teclear)
$('#search').keyup(function() {
    let search = $(this).val();
    
    if(search) {
        $.ajax({
            url: './backend/product-search.php',
            type: 'GET',
            data: { search: search },
            success: function(response) {
                let productos = JSON.parse(response);
                let template = '';
                let template_bar = '';
                
                productos.forEach(producto => {
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td>${producto.marca}</td>
                            <td>${producto.modelo}</td>
                            <td>${producto.precio}</td>
                            <td>${producto.unidades}</td>
                            <td>${producto.detalles}</td>
                            <td>
                                <button class="product-edit btn btn-warning btn-sm">
                                    Editar
                                </button>
                            </td>
                            <td>
                                <button class="product-delete btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                    
                    template_bar += `<li>${producto.nombre}</li>`;
                });
                
                $('#product-result').removeClass('d-none');
                $('#container').html(template_bar);
                $('#products').html(template);
            }
        });
    } else {
        $('#product-result').addClass('d-none');
        listarProductos();
    }
});

// Prevenir submit del formulario de búsqueda
$('.form-inline').submit(function(e) {
    e.preventDefault();
});

// Agregar o Editar producto
$('#product-form').submit(function(e) {
    e.preventDefault();
    
    let productoJsonString = $('#description').val();
    let finalJSON = JSON.parse(productoJsonString);
    finalJSON['nombre'] = $('#name').val();
    
    let productId = $('#productId').val();
    let url = './backend/product-add.php';
    
    // Si hay un ID, es una edición
    if(productId) {
        finalJSON['id'] = productId;
        url = './backend/product-edit.php';
    }
    
    productoJsonString = JSON.stringify(finalJSON, null, 2);
    
    $.ajax({
        url: url,
        type: 'POST',
        contentType: 'application/json;charset=UTF-8',
        data: productoJsonString,
        success: function(response) {
            let respuesta = JSON.parse(response);
            let template_bar = `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;
            
            $('#product-result').removeClass('d-none');
            $('#container').html(template_bar);
            
            listarProductos();
            $('#product-form').trigger('reset');
            $('#description').val(JSON.stringify(baseJSON, null, 2));
            $('#productId').val('');
            $('#product-form button[type="submit"]').text('Agregar Producto');
        }
    });
});

// Eliminar producto
$(document).on('click', '.product-delete', function() {
    if(confirm('¿De verdad deseas eliminar el Producto?')) {
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('productId');
        
        $.ajax({
            url: './backend/product-delete.php',
            type: 'GET',
            data: { id: id },
            success: function(response) {
                let respuesta = JSON.parse(response);
                let template_bar = `
                    <li style="list-style: none;">status: ${respuesta.status}</li>
                    <li style="list-style: none;">message: ${respuesta.message}</li>
                `;
                
                $('#product-result').removeClass('d-none');
                $('#container').html(template_bar);
                
                listarProductos();
            }
        });
    }
});

// Editar producto (cargar datos en el formulario)
$(document).on('click', '.product-edit', function() {
    let element = $(this)[0].parentElement.parentElement;
    let id = $(element).attr('productId');
    
    $.ajax({
        url: './backend/product-single.php',
        type: 'GET',
        data: { id: id },
        success: function(response) {
            let producto = JSON.parse(response);
            
            // Crear el objeto JSON sin el nombre y el id
            let editJSON = {
                "precio": parseFloat(producto.precio),
                "unidades": parseInt(producto.unidades),
                "modelo": producto.modelo,
                "marca": producto.marca,
                "detalles": producto.detalles,
                "imagen": producto.imagen
            };
            
            $('#name').val(producto.nombre);
            $('#description').val(JSON.stringify(editJSON, null, 2));
            $('#productId').val(producto.id);
            
            // Cambiar el botón a modo edición
            $('#product-form button[type="submit"]').text('Actualizar Producto');
        }
    });
});

// Inicializar cuando el documento esté listo
$(document).ready(function() {
    init();
});