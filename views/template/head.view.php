<?php
session_start();
ob_start();


require_once __DIR__ . './../../app/Http/autoload.php';

$uri = '/template/';

// if (!isset($_SESSION['users']['id_user'])) {
//     header('Location: ' . $uri);
// }
