<?php
echo "PHP funciona: " . phpversion() . "\n";
echo "Archivo actual: " . __FILE__ . "\n";
echo "Directorio: " . __DIR__ . "\n";

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "✅ vendor/autoload.php EXISTE\n";
    require __DIR__ . '/vendor/autoload.php';
    
    if (class_exists('Slim\Factory\AppFactory')) {
        echo "✅ Slim Framework INSTALADO correctamente\n";
    } else {
        echo "❌ Slim Framework NO encontrado\n";
    }
} else {
    echo "❌ vendor/autoload.php NO EXISTE - Ejecuta: composer install\n";
}
?>
