<?php
$request = $_SERVER['REQUEST_URI'];
error_reporting(E_ERROR | E_PARSE);

require_once '../Router.php';
$router = new Router();
$router->route($request);
