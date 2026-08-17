<?php

namespace App\Modules\Database\Contracts;

use PDO;

interface IDatabase {
    public function transaction(callable $fn);
    public function getConnection(): PDO;
}