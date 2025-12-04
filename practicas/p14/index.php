<?php
/**
 * API REST con Slim Framework v4
 * Práctica 14 - Desarrollo de Aplicaciones Web
 * 
 * Este servicio implementa diferentes métodos HTTP (GET, POST)
 * para demostrar el funcionamiento de una API REST básica
 */

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
require __DIR__ . '/vendor/autoload.php';

// Crear la aplicación Slim
$app = AppFactory::create();

// Configurar automáticamente el basePath según el servidor
$basePath = '';
if (isset($_SERVER['SCRIPT_NAME'])) {
    $scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    if ($scriptDir !== '' && $scriptDir !== '/') {
        $basePath = $scriptDir;
    }
}
$app->setBasePath($basePath);

// Habilitar el manejo de errores
$app->addErrorMiddleware(true, true, true);

/**
 * RUTA 1: GET /
 * Método HTTP: GET
 * Descripción: Ruta raíz que retorna un mensaje de bienvenida
 * URL de prueba: http://localhost:8000/
 */
$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("¡Hola Mundo desde Slim Framework v4!");
    return $response;
});

/**
 * RUTA 2: GET /hola/{nombre}
 * Método HTTP: GET
 * Descripción: Recibe un parámetro en la URL y retorna un saludo personalizado
 * Parámetros de ruta: {nombre} - El nombre de la persona a saludar
 * URL de prueba: http://localhost:8000/hola/Juan
 */
$app->get('/hola/{nombre}', function (Request $request, Response $response, $args) {
    $nombre = $args['nombre'];
    $response->getBody()->write("Hola, $nombre! Bienvenido al servicio REST con Slim.");
    return $response;
});

/**
 * RUTA 3: POST /pruebapost
 * Método HTTP: POST
 * Descripción: Recibe datos mediante POST y los procesa
 * Parámetros POST esperados: nombre, edad (enviados desde formulario o POSTMAN)
 * URL de prueba: http://localhost:8000/pruebapost
 */
$app->post('/pruebapost', function (Request $request, Response $response, $args) {
    // Obtener datos del POST
    $datos = $request->getParsedBody();
    
    $nombre = isset($datos['nombre']) ? $datos['nombre'] : 'Desconocido';
    $edad = isset($datos['edad']) ? $datos['edad'] : 'No especificada';
    
    $mensaje = "Datos recibidos por POST:\n";
    $mensaje .= "Nombre: $nombre\n";
    $mensaje .= "Edad: $edad años";
    
    $response->getBody()->write($mensaje);
    return $response;
});

/**
 * RUTA 4: POST /testjson
 * Método HTTP: POST
 * Descripción: Recibe datos por POST y retorna una respuesta en formato JSON
 * Parámetros POST esperados: nombre, edad, correo
 * URL de prueba: http://localhost:8000/testjson
 */
$app->post('/testjson', function (Request $request, Response $response, $args) {
    // Obtener datos del POST
    $datos = $request->getParsedBody();
    
    // Construir respuesta JSON
    $respuesta = [
        'status' => 'success',
        'mensaje' => 'Datos procesados correctamente',
        'datos_recibidos' => [
            'nombre' => isset($datos['nombre']) ? $datos['nombre'] : null,
            'edad' => isset($datos['edad']) ? $datos['edad'] : null,
            'correo' => isset($datos['correo']) ? $datos['correo'] : null
        ],
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    // Convertir array a JSON y escribir en el response
    $payload = json_encode($respuesta, JSON_PRETTY_PRINT);
    $response->getBody()->write($payload);
    
    // Establecer el header para indicar que es JSON
    return $response->withHeader('Content-Type', 'application/json');
});

/**
 * RUTA EXTRA: GET /api/info
 * Método HTTP: GET
 * Descripción: Retorna información sobre el API en formato JSON
 */
$app->get('/api/info', function (Request $request, Response $response, $args) {
    $info = [
        'nombre' => 'API REST con Slim Framework',
        'version' => '1.0',
        'endpoints' => [
            'GET /' => 'Mensaje de bienvenida',
            'GET /hola/{nombre}' => 'Saludo personalizado',
            'POST /pruebapost' => 'Prueba de método POST',
            'POST /testjson' => 'Respuesta en formato JSON'
        ]
    ];
    
    $payload = json_encode($info, JSON_PRETTY_PRINT);
    $response->getBody()->write($payload);
    
    return $response->withHeader('Content-Type', 'application/json');
});

// Ejecutar la aplicación
$app->run();