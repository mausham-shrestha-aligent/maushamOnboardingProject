<?php
namespace Tests\Unit;
use App\DatabaseConfiguration\App;
use App\Models\Post;
use App\Models\User;
use App\RouterConfigurations\Router;
use App\RouterConfigurations\RouterConfiguration;

class BaseTest
{
    private Router $router;
    private User $userModel;
    private Post $postModel;
    private string $sampleEmail;

    public function __construct()
    {
        $env = [
            'DB_HOST' => 'db',
            'DB_USER' => 'root',
            'DB_PASS' => 'root',
            'DB_DATABASE' => 'my_db',
            'DB_DRIVER' => 'mysql'
        ];

        (new App((new RouterConfiguration())->getRouter(), new \App\DatabaseConfiguration\Config($env)));
        $this->postModel = new Post();
        $this->userModel = new User();
        $this->router = new Router();
        $this->sampleEmail = "sample15@sample.com";
    }

    /** Helps to create new user */
    public function helperCreateFunction($userEmail)
    {
        return $this->userModel->create('Unit Test User',
            $userEmail, '12345', '');
    }

    /** Helps to delete user */
    public function helperDeleteFunction($email)
    {
        $this->userModel->deleteUserByEmail($email);
    }

    /** Helps to create a new post */
    public function helperPostCreateFunction($userId)
    {
        $sampleSubmitPostData = [
            'user_id' => $userId,
            'title' => "Test Title",
            'body' => "Test body",
            'imageUrl' => "Test Url"
        ];
        return $this->postModel->submitPost($sampleSubmitPostData);
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * @return User
     */
    public function getUserModel(): User
    {
        return $this->userModel;
    }

    /**
     * @return Post
     */
    public function getPostModel(): Post
    {
        return $this->postModel;
    }

}