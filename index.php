<?php

use dwes\app\exceptions\NotFoundException;
use dwes\core\App;
use dwes\core\Request;

require_once __DIR__ . '/core/bootstrap.php';

try {
    App::get('router')->direct(Request::uri(), Request::method());
} catch (NotFoundException $notFoundException) {
    http_response_code(404);
    echo $notFoundException->getMessage();
}
