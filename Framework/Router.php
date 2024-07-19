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

    public function route($uri)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // Check for _method input
        if ($requestMethod === 'POST' && isset($_POST['_method'])) {
            // Override the request method with the value of _method
            $requestMethod = strtoupper($_POST['_method']);
        }

        $uriSegments = explode('/', trim($uri, '/'));
        $uriSegementsCounts = count($uriSegments);

        foreach ($this->routes as $route) {

            $routeSegements = explode('/', trim($route['uri'], '/'));
            $routeSegementsCount = count($routeSegements);

            $match = true;

            if ($uriSegementsCounts === $routeSegementsCount && strtoupper($route['method']) === $requestMethod) {
                $params = [];
                $match = true;

                for ($i = 0; $i < $uriSegementsCounts; $i++) {
                    if ($routeSegements[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegements[$i])) {
                        $match = false;
                        break;
                    }

                    if (preg_match('/\{(.+?)\}/', $routeSegements[$i], $matches)) {
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }



                if ($match) {
                    $controller = 'App\\controllers\\' . $route['controller'];
                    $controllerMethod = $route['controllerMethod'];

                    // now instanciate the class and call the method
                    $controllerIns = new $controller();
                    $controllerIns->$controllerMethod($params);
                    return;
                }
            }
        }

        ErrorController::notFoundError();
    }
}
