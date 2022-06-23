<?php

namespace Tests\Unit;

use App\DatabaseConfiguration\App;
use App\Models\User;
use App\RouterConfigurations\RouterConfiguration;
use PHPUnit\Framework\TestCase;

class UserModelTest extends TestCase
{
    private User $userModel;
    private String $sampleEmail;

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
        $this->sampleEmail = 'unit4@test.com';
        (new App((new RouterConfiguration())->getRouter(), new \App\DatabaseConfiguration\Config($env)));
        $this->userModel = new User();
    }

    /**
     * @test
     * This covers up create user and find user by email
     */
    public function test_that_if_create_user_works()
    {
        $this->helperCreateFunction();
        $this->assertSame(true, $this->userModel->findUserByEmail('unit1@test.com'));
        echo "I am run";
        /** Removing the random user email from database **/
        $this->helperDeleteFunction();
    }

    public function test_that_if_check_password_works()
    {
        $this->helperCreateFunction();
        $this->assertSame(7, count($this->userModel->checkPassword($this->sampleEmail, '12345')));
        $this->helperDeleteFunction();
    }

    public function helperCreateFunction()
    {
        $this->userModel->create('Unit Test User',
            $this->sampleEmail, '12345', '');
    }

    public function helperDeleteFunction()
    {
        $this->userModel->deleteUserByEmail($this->sampleEmail);
    }
}