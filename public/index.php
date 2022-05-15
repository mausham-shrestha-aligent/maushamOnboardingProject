<?php

use App\Config\App;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\SignUpController;
use App\Controllers\UserController;
use App\Routers\Router;

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
    ->post('/users/register', [UserController::class, 'register'])
    ->post('/users/login', [UserController::class, 'login']);

(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new \App\Config\Config($_ENV)
))->run();