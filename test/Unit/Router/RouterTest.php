<?php

namespace PushyTest\Router;

use Pushy\Router\Router;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Pushy\Router\Router::__construct
     */
    public function testConstructCorrectInterface()
    {
        $router = new Router($this->getMock('\\Pushy\\Router\\RouteBuilder'));

        $this->assertInstanceOf('\\Pushy\\Router\\Routable', $router);
    }

    /**
     * @covers Pushy\Router\Router::__construct
     */
    public function testConstructCorrectInstance()
    {
        $router = new Router($this->getMock('\\Pushy\\Router\\RouteBuilder'));

        $this->assertInstanceOf('\\Pushy\\Router\\Router', $router);
    }

    /**
     * @covers Pushy\Router\Router::__construct
     * @covers Pushy\Router\Router::get
     * @covers Pushy\Router\Router::addRoute
     */
    public function testGet()
    {
        $router = new Router($this->getMock('\\Pushy\\Router\\RouteBuilder'));

        $this->assertNull($router->get('foo', '#/bar#', function() {
            return 'baz';
        }));
    }

    /**
     * @covers Pushy\Router\Router::__construct
     * @covers Pushy\Router\Router::post
     * @covers Pushy\Router\Router::addRoute
     */
    public function testPost()
    {
        $router = new Router($this->getMock('\\Pushy\\Router\\RouteBuilder'));

        $this->assertNull($router->post('foo', '#/bar#', function() {
            return 'baz';
        }));
    }

    /**
     * @covers Pushy\Router\Router::__construct
     * @covers Pushy\Router\Router::getRouteByRequest
     */
    public function testGetRouteByRequestNoRoutes()
    {
        $router = new Router($this->getMock('\\Pushy\\Router\\RouteBuilder'));

        $request = $this->getMock('\\Pushy\\Network\\Http\\RequestData');
        $request->expects($this->any())->method('getMethod')->will($this->returnValue('GET'));

        $this->setExpectedException('\\Pushy\\Router\\NoMatchingRouteException');

        $route = $router->getRouteByRequest($request);
    }

    /**
     * @covers Pushy\Router\Router::__construct
     * @covers Pushy\Router\Router::get
     * @covers Pushy\Router\Router::addRoute
     * @covers Pushy\Router\Router::getRouteByRequest
     */
    public function testGetRouteByRequestMatchesFirst()
    {
        $route1 = $this->getMock('\\Pushy\\Router\\AccessPoint');
        $route1->expects($this->any())
            ->method('doesRequestMatch')
            ->will($this->returnValue(true));
        $route1->expects($this->any())
            ->method('getCallback')
            ->will($this->returnValue(function() {
                return 'baz';
            }));

        $route2 = $this->getMock('\\Pushy\\Router\\AccessPoint');
        $route2->expects($this->any())
            ->method('doesRequestMatch')
            ->will($this->returnValue(false));

        $routeFactory = $this->getMock('\\Pushy\\Router\\RouteBuilder');
        $routeFactory->expects($this->at(0))
            ->method('build')
            ->will($this->returnValue($route1));
        $routeFactory->expects($this->at(1))
            ->method('build')
            ->will($this->returnValue($route2));

        $router = new Router($routeFactory);

        $this->assertNull($router->get('foo', '#/bar$#', function() {
            return 'baz';
        }));

        $this->assertNull($router->get('foo2', '#/bars$#', function() {
            return 'baz2';
        }));

        $request = $this->getMock('\\Pushy\\Network\\Http\\RequestData');
        $request->expects($this->any())
            ->method('getMethod')
            ->will($this->returnValue('GET'));

        $route = $router->getRouteByRequest($request);
        $callback = $route->getCallback();

        $this->assertInstanceOf('\\Pushy\\Router\\AccessPoint', $route);
        $this->assertSame('baz', $callback());
    }

    /**
     * @covers Pushy\Router\Router::__construct
     * @covers Pushy\Router\Router::get
     * @covers Pushy\Router\Router::addRoute
     * @covers Pushy\Router\Router::getRouteByRequest
     */
    public function testGetRouteByRequestMatchesLatter()
    {
        $route1 = $this->getMock('\\Pushy\\Router\\AccessPoint');
        $route1->expects($this->any())
            ->method('doesRequestMatch')
            ->will($this->returnValue(false));

        $route2 = $this->getMock('\\Pushy\\Router\\AccessPoint');
        $route2->expects($this->any())
            ->method('doesRequestMatch')
            ->will($this->returnValue(true));
        $route2->expects($this->any())
            ->method('getCallback')
            ->will($this->returnValue(function() {
                return 'baz2';
            }));

        $routeFactory = $this->getMock('\\Pushy\\Router\\RouteBuilder');
        $routeFactory->expects($this->at(0))
            ->method('build')
            ->will($this->returnValue($route1));
        $routeFactory->expects($this->at(1))
            ->method('build')
            ->will($this->returnValue($route2));

        $router = new Router($routeFactory);

        $this->assertNull($router->get('foo', '#/bar$#', function() {
            return 'baz';
        }));

        $this->assertNull($router->get('foo2', '#/bars$#', function() {
            return 'baz2';
        }));

        $request = $this->getMock('\\Pushy\\Network\\Http\\RequestData');
        $request->expects($this->any())
            ->method('getMethod')
            ->will($this->returnValue('GET'));

        $route = $router->getRouteByRequest($request);
        $callback = $route->getCallback();

        $this->assertInstanceOf('\\Pushy\\Router\\AccessPoint', $route);
        $this->assertSame('baz2', $callback());
    }

    /**
     * @covers Pushy\Router\Router::__construct
     * @covers Pushy\Router\Router::getRouteByRequest
     */
    public function testGetRouteByRequestNoMatchNotFoundRoute()
    {
        $notFoundRoute = $this->getMock('\\Pushy\\Router\\AccessPoint');
        $notFoundRoute->expects($this->any())
            ->method('doesRequestMatch')
            ->will($this->returnValue(false));
        $notFoundRoute->expects($this->any())
            ->method('getCallback')
            ->will($this->returnValue(function() {
                return '404';
            }));

        $routeFactory = $this->getMock('\\Pushy\\Router\\RouteBuilder');
        $routeFactory->expects($this->once())
            ->method('build')
            ->will($this->returnValue($notFoundRoute));

        $router = new Router($routeFactory);

        $this->assertNull($router->get('404', '#doesnotmatch#', function() {
            return '404';
        }));

        $request = $this->getMock('\\Pushy\\Network\\Http\\RequestData');
        $request->expects($this->any())
            ->method('getMethod')
            ->will($this->returnValue('GET'));

        $route = $router->getRouteByRequest($request);
        $callback = $route->getCallback();

        $this->assertInstanceOf('\\Pushy\\Router\\AccessPoint', $route);
        $this->assertSame('404', $callback());
    }

    /**
     * @covers Pushy\Router\Router::__construct
     * @covers Pushy\Router\Router::getRouteByRequest
     */
    public function testGetRouteByRequestNoMatchThrowsException()
    {
        $router = new Router($this->getMock('\\Pushy\\Router\\RouteBuilder'));

        $request = $this->getMock('\\Pushy\\Network\\Http\\RequestData');
        $request->expects($this->any())->method('getMethod')->will($this->returnValue('GET'));

        $this->setExpectedException('\\Pushy\\Router\\NoMatchingRouteException');

        $route = $router->getRouteByRequest($request);
    }
}
