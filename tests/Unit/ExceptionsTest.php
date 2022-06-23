<?php

namespace Tests\Unit;

use App\DatabaseConfiguration\App;
use App\Exceptions\AdminSearchUserException;
use App\Exceptions\CommentLimitException;
use App\Exceptions\RouteNotFoundException;
use App\Models\Post;
use App\Models\User;
use App\RouterConfigurations\Router;
use App\RouterConfigurations\RouterConfiguration;
use PHPUnit\Framework\TestCase;
use Tests\DataProviders\DataProvider;

/** ExceptionsTest doesn't include the test for exception which require front-end tool for testing */
class ExceptionsTest extends TestCase
{

    private BaseTest $baseTest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->baseTest = new BaseTest();
    }

    /**
     * @test
     * @dataProvider \Tests\DataProviders\DataProvider::routeNotFoundCases
     */
    public function it_throws_route_not_found_exception(
        string $requestUri,
        string $requestMethod
    ): void
    {
        $users = new class {
            public function delete(): bool
            {
                return true;
            }
        };
        $this->baseTest->getRouter()->post('/users', [$users::class, 'store']);
        $this->baseTest->getRouter()->get('/users', ['Users', 'index']);

        $this->expectException(RouteNotFoundException::class);
        $this->baseTest->getRouter()->resolve($requestUri, $requestMethod);
    }

    /** @test */
    public function it_throws_Admin_search_exception()
    {
        $this->expectException(AdminSearchUserException::class);
        $this->baseTest->getUserModel()->getSearchedUser('Random Text');
    }

    /** @test */
    public function it_throws_comment_limit_exception()
    {
        $userId = $this->baseTest->helperCreateFunction();
        $postId = $this->baseTest->helperPostCreateFunction($userId);
        $this->expectException(\Exception::class);
        try {
            $this->baseTest->getPostModel()->commentPost([
                "dawhfnasdjfnjasdnfjudsahgfuiadslfihasdfilsIAUHFDUASDFSADF;LAJSDknZDXMCnjxzhvcuhjhfiudhhfoasdhfiusdahfsadhf",// Passing more than character comment
                $userId,
                $postId
            ]);
        } catch (\Exception $e) {
            $this->baseTest->helperDeleteFunction();
            throw new \Exception($e);
        }
    }

    /** @test */
    public function it_throws_exception_when_identical_user_is_added()
    {
        $this->baseTest->helperCreateFunction();
        $this->expectException(\Exception::class);
        try {
            $this->baseTest->helperCreateFunction();
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }

    /** @test */
    public function it_throws_exception_if_email_field_is_empty_while_signup()
    {
        $this->expectException();
        try {
            $this->baseTest->getUserModel()->create("Test", "", "password", "");
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }

}