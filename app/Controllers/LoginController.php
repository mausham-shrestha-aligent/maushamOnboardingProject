<?php

namespace App\Controllers;

use App\Views\View;
use JetBrains\PhpStorm\Pure;

class LoginController
{
    public function login() : View {
        return View::make('login');
    }
}