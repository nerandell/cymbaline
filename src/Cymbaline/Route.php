<?php

namespace Cymbaline;

class Route
{
    private static $_routes = array();

    static function addRoute($method, $path, $callback)
    {
        $route = array('method' => $method, 'path' => $path, 'callback' => $callback);
        array_push(self::$_routes, $route);
    }

    static function getRoutes()
    {
        return self::$_routes;
    }
}