<?php

$pattern = ROOT . DS . 'app' . DS . 'models' . DS . '*.php';

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
    $modelName = strtolower($model);
    $mainUrl = '/' . $modelName;
    $resourceUrl =  '/' . $modelName . '/' . '[:id]';
    $controllerName = $model . 'Controller';

    $controller = new $controllerName();

    if ($model::$get_all_enabled) {
        $klein->respond('get', $mainUrl, function ($request) use ($controller) {
            $controller->getAll();
        });
    }

    if ($model::$get_enabled){
        $klein->respond('get', $resourceUrl, function ($request) use ($controller) {
            $controller->get($request->id);
        });
    }

    if ($model::$create_enabled){
        $klein->respond('post', $mainUrl, function ($request) use ($controller) {
            $postParams = json_decode(file_get_contents('php://input'));
            $controller->create($postParams);
        });
    }

    if ($model::$delete_enabled){
        $klein->respond('delete', $resourceUrl, function ($request) use ($controller) {
            $controller->delete($request->id);
        });
    }

    if ($model::$update_enabled) {
        $klein->respond('put', $resourceUrl, function ($request) use ($controller) {
            $postParams = json_decode(file_get_contents('php://input'));
            $controller->update($request->id, $postParams);
        });
    }
}

// This is where custom routes are mapped by Klein.
// User defined routes are given preference over
// RESTful routes defined by Cymbaline

foreach (Route::getRoutes() as $route)
{
    $klein->respond($route['method'], $route['path'], $route['callback']);
}

$klein->dispatch();
