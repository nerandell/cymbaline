<?php

namespace Cymbaline;

use Illuminate\Database\Capsule\Manager as Capsule;

class DatabaseHandler
{
    static function setUp()
    {
        require_once(ROOT . DS . 'app' . DS . 'config' . DS . 'database.php');
        $capsule = new Capsule;
        $capsule->addConnection($connection);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}

