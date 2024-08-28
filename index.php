<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Http\Middleware\HomeControllers\Routing;

require 'app/Http/Middleware/HomeControllers.class.php';

$path = "/template";
$router = new Routing($path);
include('routes/web.php');
include('routes/console.php');
include('routes/api.php');
$router->run();
