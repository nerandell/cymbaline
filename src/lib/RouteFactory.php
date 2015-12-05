<?php

$pattern = ROOT . DS . 'src' . DS . 'models' . DS . '*.php';

$models = array();

foreach (glob($pattern) as $file)
{
    $class = basename($file, '.php');
    array_push($models, $class);
}

$klein = new \Klein\Klein();

// This is where RESTful routes are mapped by Klein

foreach ($models as $model)
{
    $model_name = strtolower($model);
    $main_url = '/' . $model_name;
    $res_url =  '/' . $model_name . '/' . '[:name]';

    $klein->respond('get', $main_url, function($request){
        echo 'Getting All';
    });

    $klein->respond('get', $res_url, function($request){
        echo 'Getting ' . $request->name;
    });

    $klein->respond('post', $main_url, function($request){
        echo 'Post called';
    });

    $klein->respond('delete', $res_url, function($request){
        echo 'Deleting ' . $request->name;
    });
}

// This is where custom routes are mapped by Klein.
// User defined routes are given preference over
// RESTful routes defined by cymbaline

foreach (Route::get_routes() as $route)
{
    $klein->respond($route['method'], $route['path'], $route['callback']);
}

$klein->dispatch();
