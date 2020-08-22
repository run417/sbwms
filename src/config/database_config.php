<?php

$hostname = "localhost";
$database = "sbwms_db";
$user = "sbwms_user"; # root
$pass = "secret";
$port = 5432; // default postgres port
// $charset = "utf8mb4";

$herokuDatabase = getenv('DATABASE_URL');
if ($herokuDatabase) {
    $url = parse_url($herokuDatabase);
    $user = $url['user'];
    $pass = $url['pass'];
    $hostname = $url['host'];
    $port = $url['port'];
    $database = ltrim($url['path'], '/');
}

// $dsn = "mysql:host=$hostname;dbname=$database;charset=$charset";
$dsn = "pgsql:host=$hostname;port=$port;dbname=$database";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

// this file is included in the container so it can build the pdo object