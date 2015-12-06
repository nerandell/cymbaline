<?php

define('ROOT', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))));
define('DS', '/');

require_once('BaseModel.php');
require_once('Controller.php');

# TODO : There HAS to be a better way to do this

function include_for_pattern($pattern)
{
    $pattern = ROOT . DS . 'app' . DS . $pattern . DS . '*.php';
    foreach (glob($pattern) as $file)
    {
        require_once($file);
    }
}

include_for_pattern('models');
include_for_pattern('controllers');

require_once(ROOT . DS . 'app' . DS . 'config' . DS . 'database.php');
require_once('DatabaseHandler.php');
require_once('Route.php');
require_once(ROOT . DS . 'app' . DS . 'routes.php');
require_once('RouteFactory.php');
