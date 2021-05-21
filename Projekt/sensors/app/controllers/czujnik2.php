<?php

require_once '../app/core/database.php';

class Czujnik2 extends Controller
{
    private $model;

    function __construct()
    {
        session_start();

        $this->model = $this->loadModel("sensor");
    }

    public function index()
    {
        $this->loadView('czujnik2/index');
    }

    public function getCurrentInfluxParameter($nazwa_czujnika, $parametr)
    {
        return $this->model->getCurrentInfluxParameter($nazwa_czujnika, $parametr);
    }

}
