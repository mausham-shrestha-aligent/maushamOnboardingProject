<?php

namespace App\RouterConfigurations;

use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\SignUpController;
use App\Controllers\UserController;
use App\Controllers\PostController;
use App\Models\User;

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
        ['/logout', [UserController::class, 'logout']],
        ['/admin', [UserController::class, 'admin']],
        ['/singlepost', [PostController::class, 'getSinglePosts']],
        ['/delete-user-admin', [UserController::class, 'deleteUserByAdmin']],
        ['/comments',[PostController::class,'getAllCommentsOrUserSpecificComments']]],
        [
            ['/posts/submit', [PostController::class, 'submitPost']],
            ['/posts/update', [PostController::class, 'updatePost']],
            ['/posts/delete', [PostController::class, 'deletePost']],
            ['/users/register', [UserController::class, 'register']],
            ['/users/login', [UserController::class, 'login']],
            ['/comments', [PostController::class, 'postComments']],
            ['/admin', [UserController::class, 'adminPost']],
            ['/admin-comments-delete', [PostController::class, 'adminCommentsDelete']],
            ['/admin-comments-approve', [PostController::class, 'adminCommentsApprove']],
            ['/register-user-admin', [UserController::class, 'registerUserByAdmin']],
            ['/users/register/updateUser', [UserController::class, 'updateUserByAdmin']],
            ['/delete-user-admin', [UserController::class, 'deleteUserByAdmin']]
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