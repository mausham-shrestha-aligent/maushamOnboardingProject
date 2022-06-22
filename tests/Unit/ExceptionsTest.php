<?php
namespace Tests\Unit;

use App\Exceptions\RouteNotFoundException;
use App\RouterConfigurations\Router;
use PHPUnit\Framework\TestCase;
use Tests\DataProviders\DataProvider;


class ExceptionsTest extends TestCase {
    private Router $router;
    protected function setUp(): void
    {
        parent::setUp();
        $this->router = new Router();
    }
    /**
     * @test
     * @dataProvider \Tests\DataProviders\DataProvider::routeNotFoundCases
     */
    public function it_throws_route_not_found_exception(
        string $requestUri,
        string $requestMethod
    ):void {
        $users = new class {
          public function delete(): bool
          {
              return true;
          }
        };
        $this->router->post('/users', [$users::class, 'store']);
        $this->router->get('/users', ['Users', 'index']);

        $this->expectException(RouteNotFoundException::class);
        $this->router->resolve($requestUri, $requestMethod);
    }

}