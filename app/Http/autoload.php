<?php

require_once __DIR__ . './../Database/Database.class.php';
require __DIR__ . '/Middleware/_regisController.php';

foreach ($middlewares as $middleware) {
    require __DIR__ . '/Middleware/' . $middleware;
}
