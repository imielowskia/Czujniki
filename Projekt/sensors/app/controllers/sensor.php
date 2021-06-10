<?php

require_once '../app/core/database.php';

class Sensor extends Controller
{
    private $model;

    function __construct()
    {
        session_start();

        $this->model = $this->loadModel("sensorsModel");

        if (isset($_POST['sensorName'])) {
            $_SESSION["sensorName"] = trim($_POST['sensorName']);
            $this->model->setCurrentSensorName($_SESSION["sensorName"]);
        } else if (isset($_SESSION["sensorName"])) {
            $this->model->setCurrentSensorName($_SESSION["sensorName"]);
        }
    }

    public function index()
    {
        $this->loadView('sensor/index');
    }

    public function getCurrentInfluxParameter($parameter)
    {
        return $this->model->getCurrentInfluxParameter($parameter);
    }

    public function getCurrentSensorName()
    {
        return $this->model->getCurrentSensorName();
    }

    public function getSensorInfo($info)
    {
        return $this->model->getSensorInfo($info);
    }

    public function jsonCurrentDay($parameter)
    {
        return $this->model->jsonCurrentDay($parameter);
    }
    
    public function getWeeklyAvgValues($parameter, $dayOrNight)
    {
        return $this->model->getWeeklyAvgValues($parameter, $dayOrNight);
    }
}
