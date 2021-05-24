<?php

require_once '../app/core/database.php';

class HomePage extends Controller
{
    private $model;

    function __construct()
    {
        session_start();

        $this->model = $this->loadModel("sensorsModel");
    }

    public function index()
    {
        $this->loadView('homepage/index');
    }

    public function printSensorsList()
    {
        $this->model->printSensorsList();
    }
}
