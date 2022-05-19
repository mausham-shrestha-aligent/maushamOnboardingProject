<?php

use App\Config\App;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\SignUpController;
use App\Controllers\UserController;
use App\Controllers\PostController;
use App\Routers\Router;

require_once __DIR__ . '/../app/Helpers/session_helper.php';
require_once __DIR__ . '/../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

const VIEW_PATH = __DIR__ . '/../app/Views';
const ROOT_PATH = __DIR__;

$router = new Router();

$router
    ->get('/', [HomeController::class, 'index'])
    ->get('/register', [SignUpController::class, 'signUp'])
    ->get('/login', [LoginController::class, 'login'])
    ->get('/posts' ,[PostController::class, 'showPost'])
    ->get('/posts/add', [PostController::class, 'addPost'])
    ->post('/posts/submit', [PostController::class, 'submitPost'])
    ->get('/posts/edit', [PostController::class,'editPost'])
    ->post('/posts/update',[PostController::class,'updatePost'])
    ->post('/posts/delete',[PostController::class,'deletePost'])
    ->get('/logout', [UserController::class, 'logout'])
    ->post('/users/register', [UserController::class, 'register'])
    ->post('/users/login', [UserController::class, 'login'])
    ->post('/comments', [PostController::class, 'postComments']);


(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new \App\Config\Config($_ENV)
))->run();