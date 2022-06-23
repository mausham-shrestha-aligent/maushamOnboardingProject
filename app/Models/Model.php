<?php

namespace  App\Models;

use App\DatabaseConfiguration\App;
use JetBrains\PhpStorm\Pure;

abstract class Model {
    public \App\DatabaseConfiguration\DB $db;

    #[Pure] public function __construct()
    {
        $this->db = App::db();
    }
}