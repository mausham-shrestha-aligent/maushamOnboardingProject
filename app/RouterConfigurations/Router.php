<?php

declare(strict_types=1);

namespace App\RouterConfigurations;

use App\Controllers\SafeRoute;

class Router
{
    private array $routes;

    public function register(string $requestMethod, string $route, callable|array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }

    public function get(string $route, callable|array $action): self
    {
        return $this->register('get', $route, $action);
    }

    public function post(string $route, callable|array $action): self
    {
        return $this->register('post', $route, $action);
    }

    public function resolve(string $requestUri, string $requestMethod)
    {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;

        if (!$action) {
            echo "There is no action";
        }

        if (is_callable($action)) {
            return call_user_func($action);
        }
        if (is_array($action)) {
            [$class, $method] = $action;

            if (class_exists($class)) {
                $class = new $class();
                $this->checkSafeRoute($class);
                if (method_exists($class, $method)) {
                    return call_user_func_array([$class, $method], []);
                }
            }
        }

    }

    private function checkSafeRoute($controller)
    {
        if ($controller instanceof SafeRoute) {
            if (!isLoggedIn()) {
                header('location: ' . 'http://localhost:8000/login');
                die();
            }
        }
    }

    public function routes(): array
    {
        return $this->routes;
    }


}