<?php

$hostname = "localhost";
$database = "sbwms_db";
$user = "root";
$pass = "";
$charset = "utf8mb4";

$dsn = "mysql:host=$hostname;dbname=$database;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

// this file is include in the container so it can build the pdo object