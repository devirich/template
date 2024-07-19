<?php

use App\Database\DB;
use App\Http\Middleware\AppFunctions\AppFunctions;

require_once __DIR__ . './../app/Http/autoload.php';

// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: OPTIONS,GET,POST");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// $data = [];
// $app = new DB;
// $result = $app->getSQL('*', '');
// // echo '<pre>';
// // $func = new AppFunctions;
// // $func->debug($result);
// foreach ($result ?? [] as $row) :
//     $data[] = $row;
// endforeach;
// echo json_encode($data);
