<?php
require_once("../src/init.php");
function show_view($path, $request) {
    extract($request->query->all(), EXTR_SKIP);
    ob_start();
    require($path);
    return ob_get_clean();
}

ini_set("xdebug.var_display_max_children", -1);
ini_set("xdebug.var_display_max_data", -1);
ini_set("xdebug.var_display_max_depth", -1);

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

$request = Request::createFromGlobals();
$response = new Response();
$response->headers->set('X-SENT-BY', 'symfony');
$response->prepare($request);

$routes = new RouteCollection();
$routes->add('/', new Route('/'));
$routes->add('booking', new Route('/booking'));
$routes->add('newbooking', new Route('/booking/new'));

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);
$attributes = $matcher->match($request->getPathInfo());




exit(var_dump($attributes));


// $map = [
//     '/' => VIEWS . 'dashboard.php',
//     '/booking' => VIEWS . '/booking/listBooking.view.php',
//     '/booking/new' => VIEWS . '/booking/createBooking.view.php',
// ];
$path = $request->getPathInfo();

// try {
//     extract($attributes, EXTR_SKIP);
//     show_view();
// }


// if (isset($map[$path])) {
//     $html = show_view($map[$path], $request);
//     $response->setContent($html);
// } else {
//     $response->setStatusCode(404);
//     $response->setContent("404 Not Found");
// }

$response->send();

// $customer = "Customer";

// $html = show_view(
//     VIEWS . '/dashboard.php', 
//     ['customer' => $request]
// );
// ini_set("xdebug.var_display_max_data", -1);
// echo($html);




// require_once(VIEWS . '/customer/listCustomer.view.php');
?>
