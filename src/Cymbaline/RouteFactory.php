<?php

namespace Cymbaline;

use Cymbaline\Route;

class RouteFactory
{
    private $_router;
    private $_models;

    function __construct($router, $models)
    {
        $this->_router = $router;
        $this->_models = $models;
    }

    function setRoutes()
    {
        $this->addRoutesForModels();
        $this->addCustomRoutes();
        $this->_router->dispatch();
    }


    // This is where RESTful routes are mapped by Klein

    private function addRoutesForModels()
    {
        foreach ($this->_models as $model) {
            $modelName = strtolower($model);
            $mainUrl = '/' . $modelName;
            $resourceUrl = '/' . $modelName . '/' . '[:id]';
            $controllerName = $model . 'Controller';

            $controller = new $controllerName();

            if ($model::$get_all_enabled) {
                $this->_router->respond('get', $mainUrl, function ($request) use ($controller) {
                    $controller->getAll();
                });
            }

            if ($model::$get_enabled) {
                $this->_router->respond('get', $resourceUrl, function ($request) use ($controller) {
                    $controller->get($request->id);
                });
            }

            if ($model::$create_enabled) {
                $this->_router->respond('post', $mainUrl, function ($request) use ($controller) {
                    $postParams = json_decode(file_get_contents('php://input'));
                    $controller->create($postParams);
                });
            }

            if ($model::$delete_enabled) {
                $this->_router->respond('delete', $resourceUrl, function ($request) use ($controller) {
                    $controller->delete($request->id);
                });
            }

            if ($model::$update_enabled) {
                $this->_router->respond('put', $resourceUrl, function ($request) use ($controller) {
                    $postParams = json_decode(file_get_contents('php://input'));
                    $controller->update($request->id, $postParams);
                });
            }
        }
    }

    // This is where custom routes are mapped by Klein.
    // User defined routes are given preference over
    // RESTful routes defined by Cymbaline
    private function addCustomRoutes()
    {
        foreach (Route::getRoutes() as $route) {
            $this->_router->respond($route['method'], $route['path'], $route['callback']);
        }
    }

}
