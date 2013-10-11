<?php

namespace PushyTest\Router;

use Pushy\Router\RouteFactory;

class RouteFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testConstructCorrectInterface()
    {
        $routeFactory = new RouteFactory();

        $this->assertInstanceOf('\\Pushy\\Router\\RouteBuilder', $routeFactory);
    }

    /**
     *
     */
    public function testConstructCorrectInstance()
    {
        $routeFactory = new RouteFactory();

        $this->assertInstanceOf('\\Pushy\\Router\\RouteFactory', $routeFactory);
    }

    /**
     * @covers Pushy\Router\RouteFactory::build
     */
    public function testBuild()
    {
        $routeFactory = new RouteFactory();

        $route = $routeFactory->build('foo', '#/bar#', 'get', function() {
            return 'baz';
        });

        $this->assertInstanceOf('\\Pushy\\Router\\AccessPoint', $route);
        $this->assertInstanceOf('\\Pushy\\Router\\Route', $route);
    }
}
