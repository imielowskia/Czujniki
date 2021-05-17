<?php

require_once '../app/core/database.php';

class Sensors extends Controller
{
    private $model;

    function __construct()
    {
        session_start();

        $this->model = $this->loadModel("sensor");
    }

    public function index()
    {
        $this->loadView('sensors/index');
    }

    public function deleteSensor()
    {
        $id_czujnik = trim($_POST['id_czujnik']);

        $this->model->deleteSensor($id_czujnik);
    }

    public function addSensor()
    {
        $data = [
            'nazwa' => trim($_POST['nazwa']),
            'opis' => trim($_POST['opis']),
            'wspolrzedne' => trim($_POST['wspolrzedne']),
            'wysokosc_npm' => trim($_POST['wysokosc_npm'])
        ];

        $this->model->addSensor($data);
    }

    public function printSensorsTable()
    {
        $this->model->printSensorsTable();
    }
}
