<?php
$db_host = "haarlemfestival.mysql.database.azure.com";
$db_name = "development";
$db_username = "haarlemfestivaluser";
$db_password = "D4LL84w9f7Cb99z4Pz";

// Uncomment lines below, to use local database.
$debugMode = false;
if ($debugMode) {
    $db_host = "mysql";
    $db_name = "developmentdb";
    $db_username = "developer";
    $db_password = "secret123";
}

$allowed_api_address = "172.23.0.1";

$tomtom_api_key = "hhPEr4bmakfOBlVfPEsMhZWHNlmGt40L";
