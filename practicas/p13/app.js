// VARIABLES GLOBALES
let editMode = false;
let validationState = {
    nombre: false,
    marca: false,
    modelo: false,
    precio: false,
    unidades: false,
    detalles: true, // opcional
    imagen: true    // opcional
};

// FUNCIÓN DE INICIALIZACIÓN
$(document).ready(function() {
    listarProductos();
    setupValidations();
});

// CONFIGURAR VALIDACIONES EN TIEMPO REAL
function setupValidations() {
    // VALIDACIÓN NOMBRE - Con verificación en BD
    $('#nombre').on('blur', function() {
        validateNombre(true);
    });

    $('#nombre').on('input', function() {
        if ($(this).val().length > 0) {
            validateNombre(false);
        }
    });

    // VALIDACIÓN MARCA
    $('#marca').on('blur', function() {
        validateMarca();
    });

    // VALIDACIÓN MODELO
    $('#modelo').on('blur', function() {
        validateModelo();
    });

    // VALIDACIÓN PRECIO
    $('#precio').on('blur', function() {
        validatePrecio();
    });

    // VALIDACIÓN UNIDADES
    $('#unidades').on('blur', function() {
        validateUnidades();
    });

    // VALIDACIÓN DETALLES
    $('#detalles').on('blur', function() {
        validateDetalles();
    });

    // VALIDACIÓN IMAGEN
    $('#imagen').on('blur', function() {
        validateImagen();
    });
}

// VALIDACIÓN DE NOMBRE (CON VERIFICACIÓN EN BD)
function validateNombre(checkDB = true) {
    const nombre = $('#nombre').val().trim();
    const statusDiv = $('#status-nombre');
    const input = $('#nombre');
    
    // Limpiar estado previo
    statusDiv.removeClass('success error warning').html('');
    input.removeClass('is-valid is-invalid');
    
    // Validar campo vacío
    if (nombre === '') {
        statusDiv.addClass('error').html('⚠️ El nombre es obligatorio');
        input.addClass('is-invalid');
        validationState.nombre = false;
        return false;
    }
    
    // Validar longitud (mínimo 3 caracteres)
    if (nombre.length < 3) {
        statusDiv.addClass('error').html('⚠️ El nombre debe tener al menos 3 caracteres');
        input.addClass('is-invalid');
        validationState.nombre = false;
        return false;
    }
    
    // Validar longitud máxima (100 caracteres)
    if (nombre.length > 100) {
        statusDiv.addClass('error').html('⚠️ El nombre no debe exceder 100 caracteres');
        input.addClass('is-invalid');
        validationState.nombre = false;
        return false;
    }
    
    // Verificar en BD si está activada la opción
    if (checkDB) {
        statusDiv.addClass('warning').html('🔍 Verificando disponibilidad...');
        
        $.ajax({
            url: './backend/product-check-name.php',
            type: 'GET',
            data: { 
                nombre: nombre,
                id: $('#productId').val() || '' // Enviar ID en modo edición
            },
            success: function(response) {
                const result = JSON.parse(response);
                
                if (result.exists) {
                    statusDiv.removeClass('warning').addClass('error')
                           .html('❌ Este nombre ya existe en la base de datos');
                    input.addClass('is-invalid');
                    validationState.nombre = false;
                } else {
                    statusDiv.removeClass('warning').addClass('success')
                           .html('✓ Nombre disponible');
                    input.addClass('is-valid');
                    validationState.nombre = true;
                }
            },
            error: function() {
                statusDiv.removeClass('warning').addClass('error')
                       .html('⚠️ Error al verificar el nombre');
                input.addClass('is-invalid');
                validationState.nombre = false;
            }
        });
    } else {
        // Validación básica sin verificar BD
        statusDiv.addClass('success').html('✓ Formato válido');
        input.addClass('is-valid');
        validationState.nombre = true;
    }
    
    return true;
}

// VALIDACIÓN DE MARCA
function validateMarca() {
    const marca = $('#marca').val().trim();
    const statusDiv = $('#status-marca');
    const input = $('#marca');
    
    statusDiv.removeClass('success error').html('');
    input.removeClass('is-valid is-invalid');
    
    if (marca === '') {
        statusDiv.addClass('error').html('⚠️ La marca es obligatoria');
        input.addClass('is-invalid');
        validationState.marca = false;
        return false;
    }
    
    if (marca.length < 2) {
        statusDiv.addClass('error').html('⚠️ La marca debe tener al menos 2 caracteres');
        input.addClass('is-invalid');
        validationState.marca = false;
        return false;
    }
    
    if (marca.length > 50) {
        statusDiv.addClass('error').html('⚠️ La marca no debe exceder 50 caracteres');
        input.addClass('is-invalid');
        validationState.marca = false;
        return false;
    }
    
    statusDiv.addClass('success').html('✓ Marca válida');
    input.addClass('is-valid');
    validationState.marca = true;
    return true;
}

// VALIDACIÓN DE MODELO
function validateModelo() {
    const modelo = $('#modelo').val().trim();
    const statusDiv = $('#status-modelo');
    const input = $('#modelo');
    
    statusDiv.removeClass('success error').html('');
    input.removeClass('is-valid is-invalid');
    
    if (modelo === '') {
        statusDiv.addClass('error').html('⚠️ El modelo es obligatorio');
        input.addClass('is-invalid');
        validationState.modelo = false;
        return false;
    }
    
    // Validar formato alfanumérico con guiones
    const modeloRegex = /^[a-zA-Z0-9\-]+$/;
    if (!modeloRegex.test(modelo)) {
        statusDiv.addClass('error').html('⚠️ El modelo solo puede contener letras, números y guiones');
        input.addClass('is-invalid');
        validationState.modelo = false;
        return false;
    }
    
    if (modelo.length > 25) {
        statusDiv.addClass('error').html('⚠️ El modelo no debe exceder 25 caracteres');
        input.addClass('is-invalid');
        validationState.modelo = false;
        return false;
    }
    
    statusDiv.addClass('success').html('✓ Modelo válido');
    input.addClass('is-valid');
    validationState.modelo = true;
    return true;
}

// VALIDACIÓN DE PRECIO
function validatePrecio() {
    const precio = $('#precio').val();
    const statusDiv = $('#status-precio');
    const input = $('#precio');
    
    statusDiv.removeClass('success error').html('');
    input.removeClass('is-valid is-invalid');
    
    if (precio === '' || precio === null) {
        statusDiv.addClass('error').html('⚠️ El precio es obligatorio');
        input.addClass('is-invalid');
        validationState.precio = false;
        return false;
    }
    
    const precioNum = parseFloat(precio);
    
    if (isNaN(precioNum)) {
        statusDiv.addClass('error').html('⚠️ El precio debe ser un número válido');
        input.addClass('is-invalid');
        validationState.precio = false;
        return false;
    }
    
    if (precioNum <= 0) {
        statusDiv.addClass('error').html('⚠️ El precio debe ser mayor a 0');
        input.addClass('is-invalid');
        validationState.precio = false;
        return false;
    }
    
    if (precioNum > 99999999.99) {
        statusDiv.addClass('error').html('⚠️ El precio es demasiado alto');
        input.addClass('is-invalid');
        validationState.precio = false;
        return false;
    }
    
    statusDiv.addClass('success').html('✓ Precio válido');
    input.addClass('is-valid');
    validationState.precio = true;
    return true;
}

// VALIDACIÓN DE UNIDADES
function validateUnidades() {
    const unidades = $('#unidades').val();
    const statusDiv = $('#status-unidades');
    const input = $('#unidades');
    
    statusDiv.removeClass('success error').html('');
    input.removeClass('is-valid is-invalid');
    
    if (unidades === '' || unidades === null) {
        statusDiv.addClass('error').html('⚠️ Las unidades son obligatorias');
        input.addClass('is-invalid');
        validationState.unidades = false;
        return false;
    }
    
    const unidadesNum = parseInt(unidades);
    
    if (isNaN(unidadesNum) || !Number.isInteger(unidadesNum)) {
        statusDiv.addClass('error').html('⚠️ Las unidades deben ser un número entero');
        input.addClass('is-invalid');
        validationState.unidades = false;
        return false;
    }
    
    if (unidadesNum < 0) {
        statusDiv.addClass('error').html('⚠️ Las unidades no pueden ser negativas');
        input.addClass('is-invalid');
        validationState.unidades = false;
        return false;
    }
    
    if (unidadesNum > 99999) {
        statusDiv.addClass('error').html('⚠️ El número de unidades es demasiado alto');
        input.addClass('is-invalid');
        validationState.unidades = false;
        return false;
    }
    
    statusDiv.addClass('success').html('✓ Unidades válidas');
    input.addClass('is-valid');
    validationState.unidades = true;
    return true;
}

// VALIDACIÓN DE DETALLES (OPCIONAL)
function validateDetalles() {
    const detalles = $('#detalles').val().trim();
    const statusDiv = $('#status-detalles');
    const input = $('#detalles');
    
    statusDiv.removeClass('success error').html('');
    input.removeClass('is-valid is-invalid');
    
    if (detalles.length > 250) {
        statusDiv.addClass('error').html('⚠️ Los detalles no deben exceder 250 caracteres');
        input.addClass('is-invalid');
        validationState.detalles = false;
        return false;
    }
    
    if (detalles.length > 0) {
        statusDiv.addClass('success').html(`✓ ${detalles.length}/250 caracteres`);
        input.addClass('is-valid');
    }
    
    validationState.detalles = true;
    return true;
}

// VALIDACIÓN DE IMAGEN (OPCIONAL)
function validateImagen() {
    const imagen = $('#imagen').val().trim();
    const statusDiv = $('#status-imagen');
    const input = $('#imagen');
    
    statusDiv.removeClass('success error').html('');
    input.removeClass('is-valid is-invalid');
    
    if (imagen.length > 0) {
        statusDiv.addClass('success').html('✓ Ruta de imagen válida');
        input.addClass('is-valid');
    }
    
    validationState.imagen = true;
    return true;
}

// VALIDAR TODOS LOS CAMPOS ANTES DE ENVIAR
function validateAllFields() {
    let isValid = true;
    
    // Validar campos obligatorios
    if (!validateNombre(false)) isValid = false;
    if (!validateMarca()) isValid = false;
    if (!validateModelo()) isValid = false;
    if (!validatePrecio()) isValid = false;
    if (!validateUnidades()) isValid = false;
    if (!validateDetalles()) isValid = false;
    if (!validateImagen()) isValid = false;
    
    return isValid && validationState.nombre && validationState.marca && 
           validationState.modelo && validationState.precio && validationState.unidades;
}

// ENVIAR FORMULARIO
$('#product-form').on('submit', function(e) {
    e.preventDefault();
    
    // Mostrar barra de estado global
    const globalStatus = $('#global-status');
    globalStatus.removeClass('alert-success alert-danger').addClass('show');
    
    // Validar todos los campos
    if (!validateAllFields()) {
        globalStatus.addClass('alert-danger')
                   .html('<strong>Error:</strong> Por favor, corrige los campos marcados en rojo antes de continuar.');
        return false;
    }
    
    // Verificar disponibilidad del nombre en BD antes de enviar
    const nombre = $('#nombre').val().trim();
    const productId = $('#productId').val();
    
    $.ajax({
        url: './backend/product-check-name.php',
        type: 'GET',
        data: { 
            nombre: nombre,
            id: productId || ''
        },
        success: function(response) {
            const result = JSON.parse(response);
            
            if (result.exists && !editMode) {
                globalStatus.addClass('alert-danger')
                           .html('<strong>Error:</strong> Ya existe un producto con ese nombre.');
                $('#status-nombre').removeClass('success').addClass('error')
                                  .html('❌ Este nombre ya existe en la base de datos');
                $('#nombre').addClass('is-invalid').removeClass('is-valid');
                return false;
            }
            
            // Si todo está bien, proceder a guardar
            saveProduct();
        }
    });
});

// GUARDAR PRODUCTO
function saveProduct() {
    const globalStatus = $('#global-status');
    globalStatus.html('<strong>Guardando...</strong> Por favor espera.').addClass('alert-info');
    
    const productData = {
        nombre: $('#nombre').val().trim(),
        marca: $('#marca').val().trim(),
        modelo: $('#modelo').val().trim(),
        precio: parseFloat($('#precio').val()),
        unidades: parseInt($('#unidades').val()),
        detalles: $('#detalles').val().trim() || 'Sin detalles',
        imagen: $('#imagen').val().trim() || 'img/default.png'
    };
    
    const productId = $('#productId').val();
    let url = './backend/product-add.php';
    
    if (editMode && productId) {
        productData.id = productId;
        url = './backend/product-edit.php';
    }
    
    $.ajax({
        url: url,
        type: 'POST',
        contentType: 'application/json;charset=UTF-8',
        data: JSON.stringify(productData),
        success: function(response) {
            const result = JSON.parse(response);
            
            globalStatus.removeClass('alert-info alert-danger');
            
            if (result.status === 'success') {
                globalStatus.addClass('alert-success')
                           .html(`<strong>¡Éxito!</strong> ${result.message}`);
                
                // Limpiar formulario
                resetForm();
                
                // Recargar lista de productos
                listarProductos();
                
                // Ocultar mensaje después de 3 segundos
                setTimeout(() => {
                    globalStatus.removeClass('show');
                }, 3000);
            } else {
                globalStatus.addClass('alert-danger')
                           .html(`<strong>Error:</strong> ${result.message}`);
            }
        },
        error: function() {
            globalStatus.removeClass('alert-info').addClass('alert-danger')
                       .html('<strong>Error:</strong> No se pudo conectar con el servidor.');
        }
    });
}

// LISTAR PRODUCTOS
function listarProductos() {
    $.ajax({
        url: './backend/product-list.php',
        type: 'GET',
        success: function(response) {
            const productos = JSON.parse(response);
            let template = '';
            
            if (productos.length === 0) {
                template = '<tr><td colspan="8" class="text-center">No hay productos registrados</td></tr>';
            } else {
                productos.forEach(producto => {
                    template += `
                        <tr>
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td>${producto.marca}</td>
                            <td>${producto.modelo}</td>
                            <td>$${parseFloat(producto.precio).toFixed(2)}</td>
                            <td>${producto.unidades}</td>
                            <td><small>${producto.detalles.substring(0, 30)}${producto.detalles.length > 30 ? '...' : ''}</small></td>
                            <td>
                                <button class="btn btn-warning btn-sm btn-edit" data-id="${producto.id}">
                                    Editar
                                </button>
                                <button class="btn btn-danger btn-sm btn-delete" data-id="${producto.id}">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }
            
            $('#products-table').html(template);
        }
    });
}

// BUSCAR PRODUCTOS
$('#search-form').on('submit', function(e) {
    e.preventDefault();
    const search = $('#search').val().trim();
    
    if (search === '') {
        $('#search-results').addClass('d-none');
        listarProductos();
        return;
    }
    
    $.ajax({
        url: './backend/product-search.php',
        type: 'GET',
        data: { search: search },
        success: function(response) {
            const productos = JSON.parse(response);
            
            if (productos.length > 0) {
                let searchList = '';
                productos.forEach(p => {
                    searchList += `<li>${p.nombre} - ${p.marca} (${p.modelo})</li>`;
                });
                $('#search-container').html(searchList);
                $('#search-results').removeClass('d-none');
                
                // Actualizar tabla con resultados
                listarProductosEnTabla(productos);
            } else {
                $('#search-container').html('<li>No se encontraron resultados</li>');
                $('#search-results').removeClass('d-none');
            }
        }
    });
});

// Búsqueda en tiempo real
$('#search').on('input', function() {
    if ($(this).val() === '') {
        $('#search-results').addClass('d-none');
        listarProductos();
    }
});

// MOSTRAR PRODUCTOS EN TABLA (USADO EN BÚSQUEDA)
function listarProductosEnTabla(productos) {
    let template = '';
    
    productos.forEach(producto => {
        template += `
            <tr>
                <td>${producto.id}</td>
                <td>${producto.nombre}</td>
                <td>${producto.marca}</td>
                <td>${producto.modelo}</td>
                <td>$${parseFloat(producto.precio).toFixed(2)}</td>
                <td>${producto.unidades}</td>
                <td><small>${producto.detalles.substring(0, 30)}${producto.detalles.length > 30 ? '...' : ''}</small></td>
                <td>
                    <button class="btn btn-warning btn-sm btn-edit" data-id="${producto.id}">
                        Editar
                    </button>
                    <button class="btn btn-danger btn-sm btn-delete" data-id="${producto.id}">
                        Eliminar
                    </button>
                </td>
            </tr>
        `;
    });
    
    $('#products-table').html(template);
}

// EDITAR PRODUCTO
$(document).on('click', '.btn-edit', function() {
    const id = $(this).data('id');
    
    $.ajax({
        url: './backend/product-single.php',
        type: 'GET',
        data: { id: id },
        success: function(response) {
            const producto = JSON.parse(response);
            
            // Cargar datos en formulario
            $('#nombre').val(producto.nombre);
            $('#marca').val(producto.marca);
            $('#modelo').val(producto.modelo);
            $('#precio').val(producto.precio);
            $('#unidades').val(producto.unidades);
            $('#detalles').val(producto.detalles);
            $('#imagen').val(producto.imagen);
            $('#productId').val(producto.id);
            
            // Cambiar a modo edición
            editMode = true;
            $('#btn-text').text('Actualizar Producto');
            $('#btn-cancel').show();
            
            // Scroll al formulario
            $('html, body').animate({
                scrollTop: $('#product-form').offset().top - 100
            }, 500);
        }
    });
});

// CANCELAR EDICIÓN
$('#btn-cancel').on('click', function() {
    resetForm();
});

// ELIMINAR PRODUCTO
$(document).on('click', '.btn-delete', function() {
    if (!confirm('¿Estás seguro de que deseas eliminar este producto?')) {
        return;
    }
    
    const id = $(this).data('id');
    
    $.ajax({
        url: './backend/product-delete.php',
        type: 'GET',
        data: { id: id },
        success: function(response) {
            const result = JSON.parse(response);
            const globalStatus = $('#global-status');
            
            if (result.status === 'success') {
                globalStatus.removeClass('alert-danger').addClass('alert-success show')
                           .html(`<strong>¡Éxito!</strong> ${result.message}`);
                
                listarProductos();
                
                setTimeout(() => {
                    globalStatus.removeClass('show');
                }, 3000);
            } else {
                globalStatus.removeClass('alert-success').addClass('alert-danger show')
                           .html(`<strong>Error:</strong> ${result.message}`);
            }
        }
    });
});

// RESETEAR FORMULARIO
function resetForm() {
    $('#product-form')[0].reset();
    $('#productId').val('');
    $('#imagen').val('img/default.png');
    
    // Limpiar estados de validación
    $('.form-control').removeClass('is-valid is-invalid');
    $('.status-bar').removeClass('success error warning').html('');
    
    // Resetear estado de validación
    validationState = {
        nombre: false,
        marca: false,
        modelo: false,
        precio: false,
        unidades: false,
        detalles: true,
        imagen: true
    };
    
    // Volver a modo agregar
    editMode = false;
    $('#btn-text').text('Agregar Producto');
    $('#btn-cancel').hide();
}