<?php

$pattern = ROOT . DS . 'src' . DS . 'models' . DS . '*.php';

$models = array();

foreach (glob($pattern) as $file)
{
    $class = basename($file, '.php');
    if ($class != 'Model'){
        array_push($models, $class);
    }
}

$klein = new \Klein\Klein();

// This is where RESTful routes are mapped by Klein

foreach ($models as $model)
{
    $model_name = strtolower($model);
    $main_url = '/' . $model_name;
    $res_url =  '/' . $model_name . '/' . '[:name]';

    require_once(ROOT . DS . 'src' . DS . 'models' . DS . $model . '.php');

    if ($model::$get_all_enabled) {
        $klein->respond('get', $main_url, function ($request) {
            echo 'Getting All';
        });
    }

    if ($model::$get_enabled){
        $klein->respond('get', $res_url, function ($request) {
            echo 'Getting ' . $request->name;
        });
    }

    if ($model::$create_enabled){
        $klein->respond('post', $main_url, function ($request) {
            echo 'Post called';
        });
    }

    if ($model::$delete_enabled){
        $klein->respond('delete', $res_url, function ($request) {
            echo 'Deleting ' . $request->name;
        });
    }
}

// This is where custom routes are mapped by Klein.
// User defined routes are given preference over
// RESTful routes defined by cymbaline

foreach (Route::get_routes() as $route)
{
    $klein->respond($route['method'], $route['path'], $route['callback']);
}

$klein->dispatch();
