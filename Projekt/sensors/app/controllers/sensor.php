<?php

require_once '../app/core/database.php';

class Sensor extends Controller
{
    private $model;

    function __construct()
    {
        session_start();

        $this->model = $this->loadModel("sensorsModel");

        if (isset($_POST['nazwa_czujnika'])) {
            $_SESSION["nazwa_czujnika"] = trim($_POST['nazwa_czujnika']);
            $this->model->setCurrentSensor($_SESSION["nazwa_czujnika"]);
        } else if (isset($_SESSION["nazwa_czujnika"])) {
            $this->model->setCurrentSensor($_SESSION["nazwa_czujnika"]);
        }
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

    public function getSensorInfo($info)
    {
        return $this->model->getSensorInfo($info);
    }
}
