<?php

require_once '../app/core/database.php';

class HomePage extends Controller
{
    private $model;

    function __construct()
    {
        session_start();

        $this->model = $this->loadModel("sensor");
    }

    public function index()
    {
        $this->loadView('homepage/index');
    }
}
