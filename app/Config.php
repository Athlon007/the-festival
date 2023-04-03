<?php
$db_host = "haarlemfestival.mysql.database.azure.com";
$db_name = "development";
$db_username = "haarlemfestivaluser";
$db_password = "D4LL84w9f7Cb99z4Pz";

// Set to false, if you don't want to use local database.
$debugMode = true;
if ($debugMode) {
    $db_host = "mysql";
    $db_name = "developmentdb";
    $db_username = "developer";
    $db_password = "secret123";
}

$allowed_api_address = "172.23.0.1";
