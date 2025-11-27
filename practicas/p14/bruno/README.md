# Colección de Bruno para Slim Framework v4 API

Esta colección contiene todas las requests para probar la API REST desarrollada con Slim Framework v4.

## 📋 Instrucciones de Uso

### 1. Instalar Bruno

Si aún no tienes Bruno instalado:
- Descarga desde: https://www.usebruno.com/
- O instala desde: `brew install --cask bruno` (macOS)

### 2. Abrir la Colección en Bruno

1. Abre Bruno
2. Haz clic en **"Open Collection"** o **"Abrir Colección"**
3. Navega a la carpeta: `practicas/p14/slim_v4/bruno`
4. Selecciona la carpeta `bruno` y ábrela

### 3. Seleccionar el Entorno

En Bruno, selecciona el entorno según cómo estés ejecutando el servidor:

- **Local** (XAMPP/Apache): `http://localhost/tecweb/practicas/p14/slim_v4`
- **Servidor-Integrado** (PHP built-in server): `http://localhost:8000`

Para cambiar el entorno, usa el selector de entornos en la parte superior de Bruno.

### 4. Probar las Requests

La colección incluye las siguientes requests organizadas por método HTTP:

#### GET Requests
- **Bienvenida**: `GET /` - Mensaje de bienvenida
- **Saludo Personalizado**: `GET /hola/{nombre}` - Saludo con parámetro en URL
- **API Info**: `GET /api/info` - Información del API en JSON

#### POST Requests
- **Prueba POST**: `POST /pruebapost` - Envía datos con form-urlencoded
- **Test JSON**: `POST /testjson` - Envía y recibe datos en formato JSON

## 🔧 Configuración del Servidor

### Opción 1: XAMPP/Apache
1. Asegúrate de que XAMPP esté corriendo
2. Usa el entorno **"Local"** en Bruno
3. Accede a: `http://localhost/tecweb/practicas/p14/slim_v4/`

### Opción 2: Servidor Integrado de PHP
1. Abre una terminal en el directorio `practicas/p14/`
2. Ejecuta: `php -S localhost:8000 -t slim_v4`
3. Usa el entorno **"Servidor-Integrado"** en Bruno
4. Accede a: `http://localhost:8000/`

## 📝 Notas

- Puedes modificar los valores en cada request antes de enviarla
- Los parámetros en las requests POST pueden editarse directamente en Bruno
- El entorno "Local" está configurado para XAMPP por defecto
- Si tu configuración de XAMPP es diferente, edita el archivo `environments/Local.bru`

## 🎯 Pruebas Rápidas

1. **GET /**: Debería retornar "¡Hola Mundo desde Slim Framework v4!"
2. **GET /hola/María**: Debería retornar "Hola, María! Bienvenido al servicio REST con Slim."
3. **GET /api/info**: Debería retornar un JSON con información del API
4. **POST /pruebapost**: Envía nombre y edad, debería retornar los datos recibidos
5. **POST /testjson**: Envía JSON con nombre, edad y correo, debería retornar JSON con timestamp

