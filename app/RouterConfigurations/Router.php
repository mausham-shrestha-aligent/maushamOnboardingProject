<?php

declare(strict_types=1);

namespace App\RouterConfigurations;

use App\Interface\SafeRoute;
use App\Exceptions\RouteNotFoundException;

/**
 * INSPIRED FROM GIO
 */
class Router
{
    private array $routes = [];

    /**
     * It stores get and post route with 'get' and 'post' keys respectively which contains name of route
     * along with the classname and the method which needs to be triggered when the URL with related route name is called
     * To visualise:
     * $routes = [
     * 'get'=> [
     * 'route_name' => [ClassName, MethodInClass]
     * ],
     * 'post'=>[
     * 'route_name' => [ClassName, MethodInClass]
     * ]
     */
    public function register(string $requestMethod, string $route_name, array $action): self
    {
        $this->routes[$requestMethod][$route_name] = $action;
        return $this;
    }

    /** Puts the route name and action under get key in routes array */
    public function get(string $route_name, array $action): self
    {
        return $this->register('get', $route_name, $action);
    }

    /** Stores the route name and action under post key in routes array */
    public function post(string $route_name, array $action): self
    {
        return $this->register('post', $route_name, $action);
    }

    /**
     * @throws RouteNotFoundException
     * On calling this method, it calls the particular function from the controller
     */
    public function resolve(string $requestUri, string $requestMethod)
    {
        $route_name = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route_name] ?? null;
        if ($action == null) {
            throw new RouteNotFoundException("This is an invalid route");
        }
        $classObject = new $action[0]();
        $method = $action[1];
        /** Making sure post route is not accessed by users who are not logged in */
        $this->checkSafeRoute($classObject);
        return $classObject->$method();
    }

    /** Checking whether user is logged in or not */
    private function checkSafeRoute($controller)
    {
        if ($controller instanceof SafeRoute) {
            if (!isLoggedIn()) {
                header('location: ' . 'http://localhost:8000/login');
                die();
            }
        }
    }

    /**
     * @return array
     */
    public function routes(): array
    {
        return $this->routes;
    }


}