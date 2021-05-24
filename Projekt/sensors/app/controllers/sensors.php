<?php

require_once '../app/core/database.php';

class Sensors extends Controller
{
    private $model;

    function __construct()
    {
        session_start();

        $this->model = $this->loadModel("sensorsModel");
    }

    public function index()
    {
        $this->loadView('sensors/index');
    }

    public function getInfluxParameter($nazwa_czujnika, $parametr)
    {
        return $this->model->getInfluxParameter($nazwa_czujnika, $parametr);
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
            'szerokosc' => trim($_POST['szerokosc']),
            'dlugosc' => trim($_POST['dlugosc']),
            'wysokosc_npm' => trim($_POST['wysokosc_npm'])
        ];

        $this->model->addSensor($data);
    }

    public function editSensor()
    {
        $data = [
            'nazwa' => trim($_POST['edit_nazwa']),
            'opis' => trim($_POST['edit_opis']),
            'szerokosc' => trim($_POST['edit_szerokosc']),
            'dlugosc' => trim($_POST['edit_dlugosc']),
            'wysokosc_npm' => trim($_POST['edit_wysokosc_npm']),
            'id_czujnik' => trim($_POST['edit_id_czujnik'])
        ];

        $this->model->editSensor($data);
    }

    public function printSensorsTable()
    {
        $this->model->printSensorsTable();
    }

    public function printDataTable()
    {
        $this->model->printDataTable();
    }

    // Funkcja eksperymentalna
    public function toMySQL($minutes, $id_czujnik, $nazwa_czujnika)
    {
        return $this->model->toMySQL($minutes, $id_czujnik, $nazwa_czujnika);
    }
}
