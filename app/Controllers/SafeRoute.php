<?php

namespace App\Controllers;

use App\Models\Model;
use App\Models\Post;
use App\Views\View;

class PostController {

    protected Post $postModel;

    public function __construct()
    {
        if(!isset($_SESSION['user_id'])) {
            header('location: ' . 'http://localhost:8000/login');
        }
        $this->postModel = new Post();

    }

    public function showPost() {
        return View::make('posts/index');
    }


}