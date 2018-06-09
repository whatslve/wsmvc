<?php
//общие настройки
ini_set('display_errors',1);
error_reporting(E_ALL);
//Константы

//подключение файлов системы
require_once('../vendor/autoload.php');

$kernel = new app\engine\Kernel(__DIR__);
$kernel->launch();

