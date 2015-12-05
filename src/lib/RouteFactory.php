<?php

$pattern = ROOT . DS . 'src' . DS . 'models' . DS . '*.php';

$models = array();

foreach (glob($pattern) as $file)
{
    $class = basename($file, '.php');
    array_push($models, $class);
}

$klein = new \Klein\Klein();

foreach ($models as $model)
{
    $model = strtolower($model);
    $main_url = '/' . $model;
    $res_url =  '/' . $model . '/' . '[:name]';

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

$klein->dispatch();
