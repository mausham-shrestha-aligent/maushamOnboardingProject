<?php

namespace App\Controllers;

use App\Views\View;
use JetBrains\PhpStorm\Pure;

/** Returns the logging page if the user is not logged in otherwise direct them towards homepage */
class LoginController
{
    public function login(): View
    {
        if (isLoggedIn()) {
            header('location: ' . 'http://localhost:8000');
        }
        return View::make('login');
    }
}