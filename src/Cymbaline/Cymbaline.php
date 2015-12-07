<?php

namespace Cymbaline;

define('ROOT', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))));
define('DS', '/');

require_once(ROOT . DS . 'app' . DS . 'config' . DS . 'database.php');
require_once(ROOT . DS . 'app' . DS . 'routes.php');

use Cymbaline\RouteFactory;
use Cymbaline\DatabaseHelper;
use Klein\Klein;

class Cymbaline
{
    private static function include_for_pattern($pattern)
    {
        $pattern = ROOT . DS . 'app' . DS . $pattern . DS . '*.php';
        foreach (glob($pattern) as $file)
        {
            require_once($file);
        }
    }

    private static function getModels($pattern)
    {
        $models = array();

        foreach (glob($pattern) as $file) {
            $class = basename($file, '.php');
            if ($class != 'Model') {
                array_push($models, $class);
            }
        }

        return $models;
    }

    public static function setRoutes()
    {
        $pattern = ROOT . DS . 'app' . DS . 'models' . DS . '*.php';
        $klein = new \Klein\Klein();
        $models = self::getModels($pattern);
        $routeFactory = new RouteFactory($klein, $models);
        $routeFactory->setRoutes();
    }

    static function initialize()
    {
        DatabaseHelper::setUp();
        self::include_for_pattern('models');
        self::include_for_pattern('controllers');
        self::setRoutes();
    }
}