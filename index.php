<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\App;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

define('VIEW_PATH', __DIR__ . '/views/');
define('UPLOADS_PATH', __DIR__ . '/uploads/');
$_REQUEST['url'] = "http://localhost:8000/public/assets/";

$application = new App();

?>