<?php

use Application\Services\Doctrine;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

use function DI\create;
use function DI\get;

return [
    Doctrine::class => create(Doctrine::class)
    ->constructor(get('db.connectionOptions')),
    'db.connectionOptions' => [
        "driver"        =>    "pdo_mysql",
        "host"          =>    "127.0.0.1",
        "user"          =>    "root",
        "password"      =>    "",
        "port"          =>    3306,
        "dbname"        =>    "doctrine",
        "unix_socket"   =>    "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock"
    ],
    Environment::class => function (){
        $loader = new FilesystemLoader(__DIR__ . "/../src/Application/Views");
        return new Environment($loader);
    }
];
