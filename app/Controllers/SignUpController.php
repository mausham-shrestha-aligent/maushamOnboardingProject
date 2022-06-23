<?php

namespace App\Controllers;

use App\Views\View;
/** Returns the signup page if not logged in */
class SignUpController
{
    public function signUp() : View {
        if(isLoggedIn()) {
            header('location: ' . 'http://localhost:8000');
        }
        return View::make('signup');
    }
}