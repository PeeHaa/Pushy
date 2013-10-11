<?php

namespace PushyTest\Router;

use Pushy\Router\FrontController;

class FrontControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Pushy\Router\FrontController::__construct
     */
    public function testConstructCorrectInstance()
    {
        $frontcontroller = new FrontController(
            $this->getMock('\\Pushy\\Network\\Http\\RequestData'),
            $this->getMock('\\Pushy\\Network\\Http\\ResponseData'),
            $this->getMock('\\Pushy\\Router\\Routable')
        );

        $this->assertInstanceOf('\\Pushy\\Router\\FrontController', $frontcontroller);
    }

    /**
     * @covers Pushy\Router\FrontController::__construct
     * @covers Pushy\Router\FrontController::dispatch
     * @covers Pushy\Router\FrontController::setParameters
     */
    public function testDispatchWithoutParams()
    {
        $route = $this->getMock('\\Pushy\\Router\\AccessPoint');
        $route->expects($this->any())
            ->method('getCallback')
            ->will($this->returnValue(function($request) {
                return 'foo';
            }));
        $route->expects($this->any())
            ->method('getPath')
            ->will($this->returnValue('/foo/'));

        $router = $this->getMock('\\Pushy\\Router\\Routable');
        $router->expects($this->any())
            ->method('getRouteByRequest')
            ->will($this->returnValue($route));

        $request = $this->getMock('\\Pushy\\Network\\Http\\RequestData');
        $request->expects($this->any())
            ->method('setParameters')
            ->will($this->returnCallback(function ($params) {
                \PHPUnit_Framework_Assert::assertSame([], $params);
            }));

        $response = $this->getMock('\\Pushy\\Network\\Http\\ResponseData');
        $response->expects($this->any())
            ->method('setBody')
            ->will($this->returnCallback(function ($body) {
                \PHPUnit_Framework_Assert::assertSame('foo', $body);
            }));

        $frontcontroller = new FrontController(
            $request,
            $response,
            $router
        );

        $this->assertNull($frontcontroller->dispatch());
    }

    /**
     * @covers Pushy\Router\FrontController::__construct
     * @covers Pushy\Router\FrontController::dispatch
     * @covers Pushy\Router\FrontController::setParameters
     */
    public function testDispatchWithParams()
    {
        $route = $this->getMock('\\Pushy\\Router\\AccessPoint');
        $route->expects($this->any())
            ->method('getCallback')
            ->will($this->returnValue(function($request) {
                return 'foo';
            }));
        $route->expects($this->any())
            ->method('getPath')
            ->will($this->returnValue('/(foo)/'));

        $router = $this->getMock('\\Pushy\\Router\\Routable');
        $router->expects($this->any())
            ->method('getRouteByRequest')
            ->will($this->returnValue($route));

        $request = $this->getMock('\\Pushy\\Network\\Http\\RequestData');
        $request->expects($this->any())
            ->method('setParameters')
            ->will($this->returnCallback(function ($params) {
                \PHPUnit_Framework_Assert::assertSame(['foo'], $params);
            }));
        $request->expects($this->any())
            ->method('getPath')
            ->will($this->returnValue('/foo'));

        $response = $this->getMock('\\Pushy\\Network\\Http\\ResponseData');
        $response->expects($this->any())
            ->method('setBody')
            ->will($this->returnCallback(function ($body) {
                \PHPUnit_Framework_Assert::assertSame('foo', $body);
            }));

        $frontcontroller = new FrontController(
            $request,
            $response,
            $router
        );

        $this->assertNull($frontcontroller->dispatch());
    }
}
