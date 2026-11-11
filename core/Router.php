<?php

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

    public function direct(string $uri, string $method): string
    {
        if (array_key_exists($method, $this->routes)
            && array_key_exists($uri, $this->routes[$method])) {
            return $this->routes[$method][$uri];
        }

        throw new NotFoundException('No se ha definido una ruta para la uri solicitada');
    }

    public function redirect(string $path): void
    {
        header('Location: /' . ltrim($path, '/'));
    }
}
