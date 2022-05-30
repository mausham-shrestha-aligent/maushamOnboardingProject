<?php

declare(strict_types = 1);

namespace App\Config {

    use App\Routers\Router;
    use App\Exceptions\RouteNotFoundException;

    class App
    {
        private static DB $db;
        private array $request;

        public function __construct(protected Router $router, protected Config $config)
        {
            $this->request = [
                'uri' => $_SERVER['REQUEST_URI'],
                'method' => $_SERVER['REQUEST_METHOD']
            ];
            static::$db = new DB($config->db ?? []);
        }

        public static function db(): DB
        {
            return static::$db;
        }

        public function run()
        {
            try {
                echo $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
            } catch (RouteNotFoundException  $e) {
                http_response_code(404);

                echo View::make('error/404');
            }
        }
    }
}
