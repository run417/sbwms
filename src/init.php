<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once('helpers.php');
define("WWW_ROOT", "/sbwms/public");
define("PUBLIC_PATH", getProjectPath() . '/public');
define("VIEWS", getProjectPath() . '/resources/views/');
define("COMMON_VIEWS", getProjectPath() . '/resources/views/common/');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$response = new Response();
$response->prepare($request);