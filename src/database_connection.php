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

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $ex) {
    // throw new PDOException($ex->getMessage(), (int)$ex->getCode());
    $message = $ex->getMessage();
}
return $pdo;