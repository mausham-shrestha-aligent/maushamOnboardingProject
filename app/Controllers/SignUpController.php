<?php

namespace App\Controllers;

use App\Views\View;

class SignUpController
{
    public function signUp() : View {
        return View::make('signup');
    }
}