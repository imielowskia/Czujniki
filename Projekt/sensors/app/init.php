<?php

require_once 'core/app.php';
require_once 'core/controller.php';
require_once 'core/database.php';
require_once 'core/influxdb/vendor/autoload.php';

// Update root path
define('ROOT_PATH', 'http://' . $_SERVER['HTTP_HOST'] . '/sensors/public/');
define('CSS_PATH', ROOT_PATH . 'css/');
define('IMG_PATH', ROOT_PATH . 'img/');
define('JS_PATH', ROOT_PATH . 'js/');
