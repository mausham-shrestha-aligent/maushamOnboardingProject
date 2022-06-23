<?php
namespace Tests\Unit;

use App\Exceptions\RouteNotFoundException;
use App\RouterConfigurations\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;
    protected function setUp(): void
    {
        parent::setUp();
        $this->router = new Router();
    }
    /** @test */
    public function test_to_check_if_registering_routes_work(): void
    {
        //Given that we have a router object
        $this->router = new Router();
        //When we call a register method
        $this->router->register('get', '/users', ['Users', 'index']);

        $expected = [
            'get' => [
                '/users' => ['Users', 'index']
            ]
        ];
        $this->assertSame($expected, $this->router->routes());
    }

    public function test_to_check_if_it_register_a_get_route():void {
        $this->router = new Router();
        $this->router->get('/users', ['Users', 'store']);
        $expected = [
            'get' => [
                '/users' => ['Users', 'store']
            ]
        ];
        $this->assertSame($expected, $this->router->routes());
    }

    public function test_checking_if_register_a_post_route_works():void {
        $this->router = new Router();
        $this->router->post('/users', ['Users', 'store']);
        $expected = [
            'post' => [
                '/users'=> ['Users', 'store']
            ]
        ];
        $this->assertSame($expected, $this->router->routes());
    }
    public function test_that_there_are_no_routes_when_router_is_created(): void {
        $this->assertEmpty((new Router())->routes());
    }

    public function test_that_it_resolves_route_from_a_closure(): void {
        $this->router->get('/users',fn()=>[1,2,3,4,5]);
        $this->assertSame([1,2,3,4,5], $this->router->resolve('/users', 'get'));
    }

    /**
     * @throws RouteNotFoundException
     */
    public function test_that_it_resolves_route(): void {
        $users = new class(){
            public function index():array {
                return [1,2,3];
            }
        };
        $this->router->get('/users', [$users::class, 'index']);
        $this->assertSame(
            [1,2,3],
            $this->router->resolve('/users', 'get')
        );
    }
}