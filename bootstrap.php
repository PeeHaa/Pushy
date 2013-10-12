<?php
/**
 * This bootstraps the Pushy application
 *
 * PHP version 5.4
 *
 * @category   Pushy
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    0.0.1
 */
namespace Pushy;

use Pushy\Core\Autoloader;
use Pushy\Storage\ImmutableArray;
use Pushy\Http\RequestData;
use Pushy\Http\Request;
use Pushy\Http\Response;
use Pushy\Router\RouteFactory;
use Pushy\Router\Router;
use Pushy\Router\FrontController;

/**
 * Bootstrap the Commentar library
 */
require_once __DIR__ . '/src/Pushy/bootstrap.php';

/**
 * Start the session
 */
session_start();

/**
 * Setup autoloader for the demo
 */
$autoloader = new Autoloader(__NAMESPACE__, dirname(__DIR__));
$autoloader->register();

/**
 * Load the environment
 */
require_once __DIR__ . '/init.deployment.php';

/**
 * Prevent rendering of pages when on CLI
 */
if(php_sapi_name() === 'cli') {
    return;
}

/**
 * Setup the request object
 */
$request = new Request(
    new ImmutableArray($_GET),
    new ImmutableArray($_POST),
    new ImmutableArray($_SERVER),
    new ImmutableArray($_FILES)
);

/**
 * Setup the response object
 */
$response = new Response();

/**
 * Setup the router
 */
$routeFactory = new RouteFactory();
$router       = new Router($routeFactory);

$router->get('frontpage', '#^/?$#', function(RequestData $request) {
    $response->setBody('Pushy!');
});

/**
 * Run the app
 */
$frontcontroller = new FrontController($request, $response, $router);
$frontcontroller->dispatch();

/**
 * Render the content
 */
echo $response->render();
