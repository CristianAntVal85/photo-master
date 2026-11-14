<?php

namespace dwes\core;

use dwes\app\exceptions\AppException;
use dwes\app\exceptions\NotFoundException;

class Router
{
    private $routes;

    private function __construct()
    {
        $this->routes = [
            'GET' => [],
            'POST' => [],
        ];
    }

    /**
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function get(string $uri, string $controller): void
    {
        $this->routes['GET'][$uri] = $controller;
    }

    /**
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function post(string $uri, string $controller): void
    {
        $this->routes['POST'][$uri] = $controller;
    }

    /**
     * @param string $file
     * @return Router
     */
    public static function load(string $file): Router
    {
        $router = new self();
        require $file;

        return $router;
    }

    /**
     * @param string $uri
     * @param string $method
     * @return void
     * @throws NotFoundException
     * @throws AppException
     */
    public function direct(string $uri, string $method): void
    {
        if (!isset($this->routes[$method]) || !array_key_exists($uri, $this->routes[$method])) {
            throw new NotFoundException("No se ha definido una ruta para la uri solicitada");
        }

        // Extraemos el nombre del controlador (nombre de la clase) del nombre del
        // action (nombre del método a llamar) y los pasamos a 2 variables
        list($controller, $action) = explode('@', $this->routes[$method][$uri]);

        // Se encarga de crear un objeto de la clase controller y llama al action adecuado
        $this->callAction($controller, $action);
    }

    /**
     * @param string $controller
     * @param string $action
     * @return void
     * @throws NotFoundException
     * @throws AppException
     */
    private function callAction(string $controller, string $action): void
    {
        $controller = App::get('config')['project']['namespace'] . '\\app\\controllers\\' . $controller;

        $objController = new $controller();

        if (!method_exists($objController, $action)) {
            throw new NotFoundException("El controlador $controller no responde al action $action");
        }

        $objController->$action();
    }

    public function redirect(string $path): void
    {
        header('Location: /' . ltrim($path, '/'));
    }
}
