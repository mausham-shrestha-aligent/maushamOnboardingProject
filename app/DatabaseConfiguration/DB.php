<?php

declare(strict_types=1);

namespace App\DatabaseConfiguration;

use PDO;

/**
 * @mixin PDO
 */
class DB
{
    private PDO $pdo;

    /** This is where magic happens
     * Making connecting to the MYSQL database using PDO class
     */
    public function __construct(array $config)
    {
        $defaultOptions = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        
        /** Catching the PDO Exception when there is some kind of issue in connecting to the database */
        try {
            $this->pdo = new PDO(
                $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['database'],
                $config['user'],
                $config['pass'],
                $config['options'] ?? $defaultOptions
            );
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * Another magic happens here
     * When method is called on db then this method is called
     * Example: db->prepare('SQL STATEMENT') -> calls prepare method on PDO object and passes SQL STATEMENT as argument
     */
    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }
}
