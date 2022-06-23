<?php

namespace Tests\Unit;

use App\DatabaseConfiguration\App;
use App\Models\Post;
use App\Models\User;
use App\RouterConfigurations\RouterConfiguration;
use PHPUnit\Framework\TestCase;

class PostModelTest extends TestCase
{
    private Post $postModel;
    private User $userModel;
    private string $sampleEmail;
    private array $sampleSubmitPostData;

    protected function setUp(): void
    {
        parent::setUp();
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
        $this->sampleEmail = 'sample@gmail.com';
    }

    /** @test */
    public function test_if_it_is_possible_to_get_posts()
    {
        $this->assertIsArray($this->postModel->getPosts());
    }

    public function test_if_submitPost_works()
    {
        $userId = $this->helperCreateFunction();
        /** Making sure that the exception is not thrown meaning the post has been inserted */
        $this->sampleSubmitPostData = [
            'user_id' => $userId,
            'title' => "Test Title",
            'body' => "Test body",
            'imageUrl' => "Test Url"
        ];
        $this->expectNotToPerformAssertions();
        $this->helperPostCreateFunction($this->sampleSubmitPostData);

        /** Deletes the user along with the post created in this function */
        $this->helperDeleteFunction();
    }

    /** This function first adds the new user and get the userID and create a post and then deletes it */
    public function test_if_post_can_be_deleted()
    {
        $userId = $this->helperCreateFunction();
        $this->sampleSubmitPostData = [
            'user_id' => $userId,
            'title' => "Test Title",
            'body' => "Test body",
            'imageUrl' => "Test Url"
        ];
        $this->helperPostCreateFunction($this->sampleSubmitPostData);
        $this->postModel->deletePostByUserId($userId);
    }

    public function test_if_post_can_be_edited()
    {

    }

    public function test_that_if_post_can_be_commented()
    {

    }

    public function test_that_if_getSinglePosts_works()
    {

    }

    public function test_that_if_getAllCommentsOrSingleComments_works()
    {

    }

    public function test_that_if_delete_comments_works()
    {

    }

//    public function test_that_if_approve_comments_works()
//    {
//
//    }
//
//    public function test_that_if_it_is_possible_to_get_deleted_post()
//    {
//
//    }
//
//    public function test_that_if_it_is_possible_to_get_deleted_comments()
//    {
//
//    }
//
    public function helperCreateFunction()
    {
        return $this->userModel->create('Unit Test User',
            $this->sampleEmail, '12345', '');
    }

    public function helperDeleteFunction()
    {
        $this->userModel->deleteUserByEmail($this->sampleEmail);
    }

    /**
     * @throws \Exception
     */
    public function helperPostCreateFunction($samplePostData)
    {
        $this->postModel->submitPost($samplePostData);
    }

}