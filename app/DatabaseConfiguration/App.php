<?php

declare(strict_types=1);

namespace App\DatabaseConfiguration {

    use App\RouterConfigurations\Router;
    use App\Exceptions\RouteNotFoundException;
    use App\Views\View;

    class App
    {
        private static DB $db;

        /**
         * Creates the instance of the DB class and passes config which is being passed from index.php
         * @param Router $router
         * @param Config $config
         */
        public function __construct(protected Router $router, protected Config $config)
        {
            static::$db = new DB($config->db ?? []);
        }

        /**
         * returns the DB instance
         * @return DB
         */
        public static function db(): DB
        {
            return static::$db;
        }

        /**
         * @return void
         */
        public function run()
        {
            try {
                echo $this->router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));
            } catch (RouteNotFoundException  $e) {
                $params = [
                    'error' => $e->getMessage()
                ];
                echo View::make('exceptionsViews/routeError', $params);
            }
        }
    }
}
