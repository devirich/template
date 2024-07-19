<?php
//test pages
$router->get("/test", function () {
    require "views/test.php";
});
//authority
$router->get("/", function () {
    require "views/login.php";
});
$router->get("/login", function () {
    require "views/login.php";
});
$router->get("/logout", function () {
    require "views/logout.php";
});
//get pages
$router->get("/home", function () {
    require "views/home.php";
});
