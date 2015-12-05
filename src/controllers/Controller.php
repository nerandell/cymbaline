<?php

class Controller
{
    protected $_model;
    protected $_view;
    protected $_command;

    function __construct()
    {
        $this->_initializeModel();
    }

    function getAll()
    {
        $result = call_user_func(array($this->_model, 'all'));
        echo $result;
    }

    function get($id)
    {
        $result = call_user_func(array($this->_model, 'find'), $id);
        echo $result;
    }

    function delete($id)
    {
        $result = call_user_func(array($this->_model, 'find'), $id);
        $result->delete();
    }

    function create()
    {
        $item = new $this->_model();
        $item->save();
    }

    private function _initializeModel()
    {
        $class = get_class($this);
        $model = substr($class, 0, -10);
        $this->_model = $model;
    }
}