<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection($connection);

$capsule->setAsGlobal();
$capsule->bootEloquent();

