<?php

namespace  App\Models;

use App\Config\App;
use JetBrains\PhpStorm\Pure;

abstract class Model {
    public \App\Config\DB $db;

    public function __construct()
    {
        $this->db = App::db();
    }
}