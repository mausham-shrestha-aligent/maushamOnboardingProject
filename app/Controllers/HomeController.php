<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Config\DB;
use App\Models\Model;
use App\Models\Post;
use App\Views\View;

/** Return ths index page when user types localhost:8000 on URL */
class HomeController extends Model {
    public function index() : View {

        $postModel = new Post();

        return View::make('index', $postModel->getPosts());
    }
}