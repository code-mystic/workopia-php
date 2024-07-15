<?php

namespace Framework;

use App\controllers\ErrorController;

class Router
{
    protected $routes = [];

    private function registerRoute($method, $uri, $action)
    {
        list($controller, $controllerMethod) = explode('@', $action);

        $this->routes[] = [
            'uri' => $uri,
            'method' => $method,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod
        ];
    }

    public function get($uri, $controller)
    {
        $this->registerRoute('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        $this->registerRoute('POST', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        $this->registerRoute('PUT', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        $this->registerRoute('DELETE', $uri, $controller);
    }

    private function error($httpcode = '404')
    {
        http_response_code($httpcode);
        loadView('error/404');
        exit;
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === $method) {
                // require basePath('App/' . $route['controller']);
                $controller = 'App\\controllers\\' . $route['controller'];
                $controllerMethod = $route['controllerMethod'];

                // now instanciate the class and call the method
                $controllerIns = new $controller();
                $controllerIns->$controllerMethod();
                return;
            }
        }

        ErrorController::notFoundError();
    }
}
