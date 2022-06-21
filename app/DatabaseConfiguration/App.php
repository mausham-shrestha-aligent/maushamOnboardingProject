<?php

declare(strict_types=1);

namespace App\DatabaseConfiguration {

    use App\RouterConfigurations\Router;
    use App\Exceptions\RouteNotFoundException;
    use App\Views\View;

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
                $params = [
                    'error' => $e->getMessage()
                ];
                echo View::make('exceptionsViews/routeError', $params);
            }
        }
    }
}
