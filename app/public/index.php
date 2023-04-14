<?php
$request = $_SERVER['REQUEST_URI'];
error_reporting(E_ERROR | E_PARSE);
require(__DIR__ . "/../services/Logger.php");

// Remove the 'path' from GET parameters,
// unless the URL contains "path" as a parameter
if (strpos($request, 'path') === false && isset($_GET['path'])) {
    unset($_GET['path']);
}

require_once '../Router.php';
$router = new Router();
$router->route($request);
