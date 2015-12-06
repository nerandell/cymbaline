<?php

require_once(ROOT . DS . 'app' . DS . 'lib' . DS . 'BaseModel.php');
require_once(ROOT . DS . 'app' . DS . 'lib' . DS . 'Controller.php');

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
require_once(ROOT . DS . 'app' . DS . 'lib' . DS . 'DatabaseHandler.php');
require_once(ROOT . DS . 'app' . DS . 'lib' . DS . 'Route.php');
require_once(ROOT . DS . 'app' . DS . 'routes.php');
require_once(ROOT . DS . 'app' . DS . 'lib' . DS . 'LayoutFactory.php');
require_once(ROOT . DS . 'app' . DS . 'lib' . DS . 'RouteFactory.php');

