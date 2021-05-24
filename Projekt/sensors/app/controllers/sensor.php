<?php

require_once '../app/core/database.php';

class Sensor extends Controller
{
    private $model;

    function __construct()
    {
        session_start();

        $this->model = $this->loadModel("sensorsModel");

        $currentSensor = trim($_POST['nazwa_czujnika']);
        $this->model->setCurrentSensor($currentSensor);
    }

    public function index()
    {
        $this->loadView('sensor/index');
    }

    public function getCurrentInfluxParameter($parametr)
    {
        return $this->model->getCurrentInfluxParameter($parametr);
    }

    public function getCurrentSensor()
    {
        return $this->model->getCurrentSensor();
    }
}
