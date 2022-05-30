<?php

use App\Config\App;
use App\Routers\RouterConfiguration;

require_once __DIR__ . '/../app/Helpers/session_helper.php';
require_once __DIR__ . '/../vendor/autoload.php';

(Dotenv\Dotenv::createImmutable(dirname(__DIR__)))->load();

const VIEW_PATH = __DIR__ . '/../app/Views';
const ROOT_PATH = __DIR__;

(new App( (new RouterConfiguration())->getRouter(), new \App\Config\Config($_ENV)))->run();
