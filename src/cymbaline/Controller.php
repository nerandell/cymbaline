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
        echo $result;
    }

    function create($params)
    {
        $item = new $this->_model();
        foreach($params as $key=>$value)
        {
            $item->$key = $value;
        }
        $item->save();
        return $item;
    }

    function update($id, $params)
    {
        $item = $result = call_user_func(array($this->_model, 'find'), $id);
        $values = array();

        foreach($params as $key=>$value){
            $values[$key] = $value;
        }
        $item->update($values);
    }

    protected function renderView($view, $args)
    {
        global $twig;
        echo $twig->render($view, $args);
    }

    private function _initializeModel()
    {
        $class = get_class($this);
        $model = substr($class, 0, -10);
        $this->_model = $model;
    }
}