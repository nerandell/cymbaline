<?php

class Route
{
    private static $_routes = array();

    static function addRoute($method, $path, $callback)
    {
        $route = array('method' => $method, 'path' => $path, 'callback' => $callback);
        array_push(self::$_routes, $route);
    }

    static function get_routes()
    {
        return self::$_routes;
    }
}