<?php

namespace App\Routers;

use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\SignUpController;
use App\Controllers\UserController;
use App\Controllers\PostController;

class RouterConfiguration
{
    protected Router $router;
    protected array $routes = [[
        ['/', [HomeController::class, 'index']],
        ['/register', [SignUpController::class, 'signUp']],
        ['/login', [LoginController::class, 'login']],
        ['/posts', [PostController::class, 'showPost']],
        ['/posts/add', [PostController::class, 'addPost']],
        ['/posts/edit', [PostController::class, 'editPost']],
        ['/logout', [UserController::class, 'logout']
        ]],
        [
            ['/posts/submit', [PostController::class, 'submitPost']],
            ['/posts/update', [PostController::class, 'updatePost']],
            ['/posts/delete', [PostController::class, 'deletePost']],
            ['/users/register', [UserController::class, 'register']],
            ['/users/login', [UserController::class, 'login']],
            ['/comments', [PostController::class, 'postComments']]
        ]];

    public function __construct()
    {
        $this->router = new Router();
        $this->configureGetRoutes($this->routes[0]);
        $this->configurePostRoutes($this->routes[1]);
    }

    private function configureGetRoutes($routes)
    {
        foreach ($routes as $route) {
            $this->router->get($route[0], $route[1]);
        }
    }
    private function configurePostRoutes($routes)
    {
        foreach ($routes as $route) {
            $this->router->post($route[0], $route[1]);
        }
    }

    public function getRouter(): Router
    {
        return $this->router;
    }
}