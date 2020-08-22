<?php

$hostname = "localhost";
$database = "sbwms_db";
$user = "sbwms_user"; # root
$pass = "secret";
// $charset = "utf8mb4";

// $dsn = "mysql:host=$hostname;dbname=$database;charset=$charset";
$dsn = "pgsql:host=$hostname;dbname=$database";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

// this file is included in the container so it can build the pdo object