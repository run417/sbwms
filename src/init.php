<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once('helpers.php');
define("WWW_ROOT", "/sbwms/public");
define("VIEWS", projectRoot() . '/src/views/');
define("COMMON_VIEWS", projectRoot() . '/src/views/common/');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use sbwms\PDOAdapter;

$request = Request::createFromGlobals();
$response = new Response();
$response->prepare($request);

// creates database connections
$pdo = require_once 'database_connection.php';
$pdoAdapter = new PDOAdapter($pdo);
