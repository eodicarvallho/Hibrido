<?php

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->get('/', 'ClienteController@echo');
    $r->get('/clientes', 'ClienteController@getClientes');
    $r->post('/clientes/addcliente', 'ClienteController@addCliente');
    $r->post('/cliente/{id}', 'ClienteController@editCliente');
    $r->delete('/cliente/{id}', 'ClienteController@removeCliente');
    $r->get('/cliente/{id}', 'ClienteController@getCliente');
    $r->get('/mock/', 'ClienteController@getMock');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);


$routeInfo = $dispatcher->dispatch($httpMethod, $uri);


switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
       	
       	$controller = explode('@', $handler);
       	$class = $controller[0];
       	$method = $controller[1];

       	$classname = "App\Controllers\\".$class;
       	$data = $classname::$method($vars);
       	echo(json_encode($data));
        break;
}
