<?php

namespace App\Controllers;

use App\Views\View;

class SignUpController
{
    public function signUp() : View {
        if(isLoggedIn()) {
            header('location: ' . 'http://localhost:8000');
        }
        return View::make('signup');
    }
}