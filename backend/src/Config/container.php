<?php

use App\Controllers\HelloController;
use App\Modules\Database\Contracts\IDatabase;
use App\Modules\Database\Postgresql\PostgresDatabase;
use App\Modules\DI\Container;
use App\Modules\Logger\ConsoleLogger;

$c = new Container();
// $c->registrate(HelloController::class, fn ($sc) => new HelloController());

$c->registrate(IDatabase::class, fn ($sc) => new PostgresDatabase(new ConsoleLogger("DATABASE"), [
    "host" => $_ENV["DB_HOST"],
    "port" => $_ENV["DB_PORT"],
    "dbname" => $_ENV["DB_DBNAME"],
    "user" => $_ENV["DB_USER"],
    "password" => $_ENV["DB_PASSWORD"],
]));

