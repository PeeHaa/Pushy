<?php
/**
 * Front controller
 *
 * PHP version 5.4
 *
 * @category   Pushy
 * @package    Router
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Pushy\Router;

use Pushy\Network\Http\RequestData;
use Pushy\Network\Http\ResponseData;

/**
 * Front controller
 *
 * @category   Pushy
 * @package    Router
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class FrontController
{
    /**
     * @var \Pushy\Network\Http\RequestData Instance of the request
     */
    private $request;

    /**
     * @var \Pushy\Network\Http\ResponseData Instance of the response
     */
    private $response;

    /**
     * @var \Pushy\Router\Routable Request router
     */
    private $router;

    /**
     * Creates instance
     *
     * @param \Pushy\Network\Http\RequestData  $request Instance of the request
     * @param \Pushy\Network\Http\ResponseData $request Instance of the response
     * @param \Pushy\Router\Routable           $router  Request router
     */
    public function __construct(RequestData $request, ResponseData $response, Routable $router)
    {
        $this->request  = $request;
        $this->response = $response;
        $this->router   = $router;
    }

    /**
     * Dispatches the request
     */
    public function dispatch()
    {
        $route = $this->router->getRouteByRequest($this->request);

        $this->setParameters($route);

        $callback = $route->getCallback();
        $this->response->setBody($callback($this->request));
    }

    /**
     * Gets the parameters from the URL path
     *
     * @param \Pushy\Router\AccessPoint $route The current matching route
     *
     * @return array The parameters from the URL path
     */
    private function setParameters(AccessPoint $route)
    {
        preg_match($route->getPath(), $this->request->getPath(), $matches);

        $this->request->setParameters(array_slice($matches, 1));
    }
}
