<?php

namespace App\Controllers;

use App\Views\View;
use JetBrains\PhpStorm\Pure;

class SignUpController
{
    #[Pure] public function signUp() : View {
        return View::make('signup');
    }
}