<?php

namespace UtariaV1;

class Controller
{

    public $DB = null;

    public $d = array();

    public $newView;

    public function __construct($DB)
    {
        $this->DB = $DB;
    }

    public function getData()
    {
        return $this->d;
    }

    public function getView($view)
    {
        return is_null($this->newView) ? $view : $this->newView;
    }

    public function set($d)
    {
        if (is_array($d) && !empty($d))
            $d = (object)$d;

        $this->d = $d;
    }


    protected function changeView($newView)
    {
        $this->newView = $newView;
    }

}
