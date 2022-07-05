<?php

namespace Tests\Unit;

use App\DatabaseConfiguration\App;
use App\Models\Post;
use App\Models\User;
use App\RouterConfigurations\RouterConfiguration;
use PHPUnit\Framework\TestCase;

/** PostModelTest doesn't include the test for those test which require front-end tool for testing */
class PostModelTest extends TestCase
{
    private BaseTest $baseTest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->baseTest = new BaseTest();

    }

    /** @test */
    public function test_if_it_is_possible_to_get_posts()
    {
        $this->assertIsArray($this->baseTest->getPostModel()->getPosts());
    }

    public function test_if_submitPost_works()
    {
        $userId = $this->baseTest->helperCreateFunction('postmodeltest4@test.com');
        /** Making sure that the exception is not thrown meaning the post has been inserted */
        $this->expectNotToPerformAssertions();
        $this->baseTest->helperPostCreateFunction($userId);

        /** Deletes the user along with the post created in this function */
        $this->baseTest->helperDeleteFunction('postmodeltest4@test.com');
    }


}