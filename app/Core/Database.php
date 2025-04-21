<?php

namespace App\Core;

use Illuminate\Database\Capsule\Manager as DB;

class Database
{
    public function __construct()
    {
        $db = new DB();
        $db->addConnection($this->connectionParams());
        // Set the event dispatcher used by Eloquent models... (optional)
        $db->setAsGlobal();
        $db->bootEloquent();
    }

    private function connectionParams(): array
    {
        return [
            'driver' => $_ENV['DB_DRIVER'],
            'host' => $_ENV['DB_HOST'],
            'database' => $_ENV['DB_NAME'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'port' => $_ENV['DB_PORT'],
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ];
    }
}
