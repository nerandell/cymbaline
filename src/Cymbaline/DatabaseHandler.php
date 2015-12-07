<?php

namespace Cymbaline;

use Illuminate\Database\Capsule\Manager as Capsule;

class DatabaseHelper
{
    static function setUp()
    {
        global $connection;
        $capsule = new Capsule;
        $capsule->addConnection($connection);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}

