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
    $res_url =  '/' . $model_name . '/' . '[:id]';
    $controllerName = $model . 'Controller';

    require_once(ROOT . DS . 'src' . DS . 'models' . DS . $model . '.php');
    require_once(ROOT . DS. 'src' . DS . 'controllers' . DS . $controllerName . '.php');

    $controller = new $controllerName();

    if ($model::$get_all_enabled) {
        $klein->respond('get', $main_url, function ($request) use ($controller) {
            $controller->getAll();
        });
    }

    if ($model::$get_enabled){
        $klein->respond('get', $res_url, function ($request) use ($controller) {
            $controller->get($request->id);
        });
    }

    if ($model::$create_enabled){
        $klein->respond('post', $main_url, function ($request) use ($controller) {
            $controller->create();
        });
    }

    if ($model::$delete_enabled){
        $klein->respond('delete', $res_url, function ($request) use ($controller) {
            $controller->delete($request->id);
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
