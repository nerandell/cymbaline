<?php

use PHPUnit_Framework_TestCase;

use Cymbaline\Route;

class CymbalineTest extends PHPUnit_Framework_TestCase
{

    function testAddCustomRoute()
    {
        Route::addRoute('get', '/test_routes', function($val) {
            return $val;
        });
        $this->assertEquals(sizeof(Route::getRoutes()), 1);
        $this->assertEquals(Route::getRoutes()[0]['path'], '/test_routes');
        $callback = Route::getRoutes()[0]['callback'];
        $this->assertEquals($callback(42), 42);
    }
}