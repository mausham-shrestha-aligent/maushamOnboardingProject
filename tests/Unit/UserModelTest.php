<?php

namespace Tests\Unit;

use App\DatabaseConfiguration\App;
use App\Models\User;
use App\RouterConfigurations\RouterConfiguration;
use PHPUnit\Framework\TestCase;

/** UserModelTest doesn't include the test for those test which require front-end tool for testing */
class UserModelTest extends TestCase
{
    private BaseTest $baseTest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->baseTest = new BaseTest();
    }
    /**
     * @test
     * This covers up create user and find user by email
     */
    public function test_that_if_create_user_works()
    {
        $this->baseTest->helperCreateFunction("usermodeltest@email.com");
        $this->assertSame(true, $this->baseTest->getUserModel()->findUserByEmail("usermodeltest@email.com"));
        $this->baseTest->helperDeleteFunction("usermodeltest@email.com");
    }

    public function test_that_if_check_password_works()
    {
        $this->baseTest->helperCreateFunction("usermodeltest@email.com");
        $this->assertSame(7, count($this->baseTest->getUserModel()->checkPassword("usermodeltest@email.com", '12345')));
        $this->baseTest->helperDeleteFunction("usermodeltest@email.com");
    }
}