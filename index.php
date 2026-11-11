<?php

require_once __DIR__ . '/core/bootstrap.php';

try {
    require App::get('router')->direct(Request::uri(), Request::method());
} catch (NotFoundException $notFoundException) {
    http_response_code(404);
    echo $notFoundException->getMessage();
}
