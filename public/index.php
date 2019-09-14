<?php
require_once("../src/init.php");

ini_set("xdebug.var_display_max_children", -1);
ini_set("xdebug.var_display_max_data", -1);
ini_set("xdebug.var_display_max_depth", -1);

$response->headers->set('X-Sent-By', 'symfony http-foundation');

$path = formatPath($request->getPathInfo());

$map = [
    '/login' => 'login',
    '/' => 'dashboard',
    '/dashboard' => 'dashboard',
    '/booking' => 'booking/list',
    '/booking/new' => 'booking/new',
    '/customer' => 'customer/list',
    '/customer/new' => 'customer/new',
    '/customer/edit' => 'customer/edit',
    '/customer/view' => 'customer/view',
    '/employee' => 'employee/list',
    '/employee/new' => 'employee/new',
    '/employee/edit' => 'employee/edit',
    '/employee/view' => 'employee/view',
    '/system' => 'system/user/list',
    '/system/user' => 'system/user/list',
    '/system/user/new' => 'system/user/new',

    '/service/type' => 'service/type/list',
    '/service/type/new' => 'service/type/new',
    '/service/type/new' => 'service/type/edit',

    '/test' => 'test/test.database'
];

if (isset($map[$path])) {
    ob_start();
    include_once sprintf(projectRoot().'/src/handlers/%s.php', $map[$path]);
    $response->setContent(ob_get_clean());
} else {
    $response->setStatusCode(404);
    ob_start();
    include_once projectRoot() . '/src/handlers/404.php';
    $response->setContent(ob_get_clean());
}

$response->send();
