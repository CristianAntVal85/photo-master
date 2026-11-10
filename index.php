<?php

require_once __DIR__ . '/core/bootstrap.php';

$routes = require __DIR__ . '/app/routes.php';
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$uri = trim(is_string($requestPath) ? $requestPath : '', '/');

if (!array_key_exists($uri, $routes)) {
    http_response_code(404);
    echo 'Página no encontrada';
    exit;
}

require $routes[$uri];
