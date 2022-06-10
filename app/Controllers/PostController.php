<?php

namespace App\Controllers;

use App\Models\Post;
use App\Views\View;

class PostController implements SafeRoute
{
    protected Post $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
    }

    public function showPost(): View
    {
        $posts = $this->postModel->getPosts();

        return View::make('posts/index', $posts);
    }

    public function addPost()
    {
        return View::make('posts/add');
    }

    public function submitPost()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'user_id' => getUserId(),
            'title' => trim($_POST['title']),
            'body' => trim($_POST['body']),
            'imageUrl'=> trim($_POST['imageUrl'])
        ];
        $this->postModel->submitPost($data);
    }

    public function editPost(): View
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        return $this->postModel->editPost(intval(explode('?', $_SERVER['REQUEST_URI'])[1]));
    }

    /**
     * @throws \Exception
     */
    public function updatePost()
    {
        $this->postModel->updatePost($_REQUEST['post']);
    }

    /**
     * @throws \Exception
     */
    public function deletePost()
    {
        $postId = (int)$_REQUEST['post'];
        $this->postModel->deletePost($postId);
    }

    public function postComments()
    {
        $postId = (int)$_REQUEST['postId'];
        $userId = (int)getUserId();
        $comment = $_REQUEST['comment'];
        $this->postModel->commentPost([$comment, $userId, $postId]);
    }
    public function getSinglePosts() {
        return View::make('posts/singlePost');
    }

}