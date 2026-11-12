<?php

use dwes\app\utils\MyLog;
use dwes\core\App;
use dwes\core\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$config = require_once __DIR__ . '/../app/config.php';
App::bind('config', $config);

$router = Router::load(__DIR__ . '/../app/routes.php');
App::bind('router', $router);

$logger = MyLog::load(__DIR__ . '/../logs/curso.log');
App::bind('logger', $logger);
