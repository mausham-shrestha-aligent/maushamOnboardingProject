<?php

namespace App\RouterConfigurations;

use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\SignUpController;
use App\Controllers\UserController;
use App\Controllers\PostController;
use App\Models\User;

/**
 * INSPIRED FROM GIO ('_')
 */
class RouterConfiguration
{
    protected Router $router;
    /**
     * @var array|\array[][]
     * Constructing routes array with two array element
     * First array-> Contains route definition for GET Request
     * Second array-> Contains route definition for POST Request
     */
    protected array $routes = [
        [
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
            ['/comments', [PostController::class, 'getAllCommentsOrUserSpecificComments']]
        ],
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
        ]
    ];

    public function __construct()
    {
        //constructing the Router object
        $this->router = new Router();
        $this->configureGetRoutes($this->routes[0]); // Configuring the get routes
        $this->configurePostRoutes($this->routes[1]); // Configuring the post routes
    }

    private function configureGetRoutes($routes)
    {
        // Breaking down the GET routes array for all the route definition
        foreach ($routes as $route) {
            //Breaking the each route definition into "Name of route" and "array which contains the class name and the method to execute"
            $this->router->get($route[0], $route[1]);
        }
    }

    private function configurePostRoutes($routes)
    {
        // Breaking down the POST routes array for all the route definition
        foreach ($routes as $route) {
            //Breaking each route definition into "Name of route" and "array which contains the class name and the method to execute"
            $this->router->post($route[0], $route[1]);
        }
    }

    public function getRouter(): Router
    {
        return $this->router;
    }
}