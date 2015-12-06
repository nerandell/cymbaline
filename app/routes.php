<?php

/*
 * This is where you add your own custom routes
 */

Route::addRoute('get', '/test', function($request) {
    echo "Test route";
});
