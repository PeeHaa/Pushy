<?php
/**
 * Interface for routers
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

/**
 * Interface for routers
 *
 * @category   Pushy
 * @package    Router
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Routable
{
    /**
     * Adds a GET route to the list
     *
     * @param string   $name     The name of the route
     * @param string   $path     The path of the route (regex pattern)
     * @param callable $callback The callback of the route
     */
    public function get($name, $path, callable $callback);

    /**
     * Adds a POST route to the list
     *
     * @param string   $name     The name of the route
     * @param string   $path     The path of the route (regex pattern)
     * @param callable $callback The callback of the route
     */
    public function post($name, $path, callable $callback);

    /**
     * Gets the route based on the current request
     *
     * When no route matches it tries to load the 404 route. When that also is not defined it will throw up.
     *
     * @param \Pushy\Newtork\Http\RequestData $request The request object
     *
     * @return \Pushy\Router\AccessPoint              The matching route
     * @throws \Pushy\Router\NoMatchingRouteException When no route matches and no 404 route exists
     */
    public function getRouteByRequest(RequestData $request);
}
