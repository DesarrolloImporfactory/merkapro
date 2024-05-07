<?php
include ('db.php');
$info = [
    'DB_HOST' => DB_HOST,
    'DB_USER' => DB_USER,
    'DB_PASS' => DB_PASS,
    'DB_NAME' => DB_NAME
];

$json_info = json_encode($info, JSON_PRETTY_PRINT);
print ($json_info);
