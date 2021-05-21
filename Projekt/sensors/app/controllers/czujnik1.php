<?php

require_once '../app/core/database.php';

class Czujnik1 extends Controller
{
    private $model;

    function __construct()
    {
        session_start();

        $this->model = $this->loadModel("sensor");
    }

    public function index()
    {
        $this->loadView('czujnik1/index');
    }

    public function getCurrentInfluxParameter($nazwa_czujnika, $parametr)
    {
        return $this->model->getCurrentInfluxParameter($nazwa_czujnika, $parametr);
    }

}
