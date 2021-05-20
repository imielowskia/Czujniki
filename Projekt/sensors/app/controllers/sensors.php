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

    public function getCurrentInfluxParameter($nazwa_czujnika, $parametr)
    {
        return $this->model->getCurrentInfluxParameter($nazwa_czujnika, $parametr);
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

    public function editSensor()
    {
        $data = [
            'nazwa' => trim($_POST['edit_nazwa']),
            'opis' => trim($_POST['edit_opis']),
            'wspolrzedne' => trim($_POST['edit_wspolrzedne']),
            'wysokosc_npm' => trim($_POST['edit_wysokosc_npm']),
            'id_czujnik' => trim($_POST['edit_id_czujnik'])
        ];

        $this->model->editSensor($data);
    }
}
