<?php
require_once("../src/init.php");

ini_set("xdebug.var_display_max_children", -1);
ini_set("xdebug.var_display_max_data", -1);
ini_set("xdebug.var_display_max_depth", -1);

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// $path = formatPath($request->getPathInfo());

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

$containerBuilder = include '../src/config/container.php';
$routes = include '../src/config/routes.php';

$request = $containerBuilder->get('request');

$session = $containerBuilder->get('session');
$session->start();

// $session->remove('user');
$user = $session->get('user', 0);
// var_dump($user);
// exit();

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

try {
    // the match method matches the route path and returns an array of
    // attributes that is in the Route object (route parameters) e.g.
    // ( _route, _controller, _method )
    // the route parameters are added as attributes to the request object
    // throws RNF Exception if unable to match
    $request->attributes->add($matcher->match($request->getPathInfo()));
    // var_dump($request->attributes->all());
    // exit();
    $controllerString = $request->attributes->get('_controller'); // controller name string
    $method = $request->attributes->get('_method'); // method name string

    if ($user === 0) {
        $controllerString = 'LoginController';
        $method = 'login';
    }

    // get the controller instance from the container and call the method
    $controller = $containerBuilder->get($controllerString);
    $response = call_user_func_array([$controller, $method], []);

} catch (ResourceNotFoundException $ex) { // catch RNF Exception
    // get errorController and call method notFound
    $controller = $containerBuilder->get('ErrorController');
    $method = 'notFound';
    $response = call_user_func_array([$controller, $method], []);
} catch (Exception $ex) {
    var_dump($ex);
    $response = new Response($ex, 500);
}
if (!isset($response) || !($response instanceof Response)) {
    exit('No Response object returned');
}

$response->prepare($request);
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
