<?php

namespace App\Controllers;

use App\Views\View;
use JetBrains\PhpStorm\Pure;

class LoginController
{
    public function login() : View {
        if(isLoggedIn()) {
            header('location: '. 'http://localhost:8000');
        }
        return View::make('login');
    }
}