<?php

session_start();

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Controllers\AuthController;
use App\Controllers\PatientController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$authController = new AuthController();
$patientController = new PatientController();

$routes = [
    'GET' => [
        '/' => fn() => isset($_SESSION['user_id']) ? $patientController->index() : $authController->loginForm(),
        '/login' => fn() => $authController->loginForm(),
        '/logout' => fn() => $authController->logout(),
        '/patients' => fn() => $patientController->index(),
        '/patients/create' => fn() => $patientController->create(),
        '/patients/edit' => fn() => $patientController->edit(),
        '/patients/delete' => fn() => $patientController->delete(),
    ],
    'POST' => [
        '/login' => fn() => $authController->login(),
        '/patients/store' => fn() => $patientController->store(),
        '/patients/update' => fn() => $patientController->update(),
    ],
];

if (isset($routes[$method][$uri])) {
    $routes[$method][$uri]();
} else {
    http_response_code(404);
    echo 'Ruta no encontrada';
}
