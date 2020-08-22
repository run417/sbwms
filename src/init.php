<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once('helpers.php');
// if DATABASE_URL is set it means that we are using heroku to host
// and because of the the mess made with .htaccess files at project start
// the following check and change must be made todo: straighten up .htaccess files
$prefix = (getenv('DATABASE_URL') ? '/public' : '/sbwms/public');
define("WWW_ROOT", $prefix);
define("VIEWS", projectRoot() . '/src/views/');
define("COMMON_VIEWS", projectRoot() . '/src/views/common/');

// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;

use sbwms\Model\PDOAdapter;

// $request = Request::createFromGlobals();
// $response = new Response();
// $response->prepare($request);

// creates database connections
// $pdo = require_once 'database_connection.php';
// $pdoAdapter = new PDOAdapter($pdo);
