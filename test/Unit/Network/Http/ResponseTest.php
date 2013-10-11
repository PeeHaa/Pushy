<?php

namespace PushyTest\Network\Http;

use Pushy\Network\Http\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testConstructCorrectInterface()
    {
        $response = new Response();

        $this->assertInstanceOf('\\Pushy\\Network\\Http\\ResponseData', $response);
    }

    /**
     *
     */
    public function testConstructCorrectInstance()
    {
        $response = new Response();

        $this->assertInstanceOf('\\Pushy\\Network\\Http\\Response', $response);
    }

    /**
     * @covers Pushy\Network\Http\Response::setStatusCode
     */
    public function testSetStatusCode()
    {
        $response = new Response();

        $this->assertNull($response->setStatusCode('HTTP/1.1 404 Not Found'));
    }

    /**
     * @covers Pushy\Network\Http\Response::setStatusCode
     */
    public function testSetStatusCodeOverwritten()
    {
        $response = new Response();

        $this->assertNull($response->setStatusCode('HTTP/1.1 404 Not Found'));
        $this->assertNull($response->setStatusCode('HTTP/1.1 200 OK'));
    }

    /**
     * @covers Pushy\Network\Http\Response::addHeader
     */
    public function testAddHeaderNew()
    {
        $response = new Response();

        $this->assertNull($response->addHeader('foo', 'bar'));
    }

    /**
     * @covers Pushy\Network\Http\Response::addHeader
     */
    public function testAddHeaderMultiple()
    {
        $response = new Response();

        $this->assertNull($response->addHeader('foo', 'bar'));
        $this->assertNull($response->addHeader('foo', 'baz'));
    }

    /**
     * @covers Pushy\Network\Http\Response::setContentType
     */
    public function testSetContentType()
    {
        $response = new Response();

        $this->assertNull($response->setContentType('text/html'));
    }

    /**
     * @covers Pushy\Network\Http\Response::setContentType
     */
    public function testSetContentTypeOverwrite()
    {
        $response = new Response();

        $this->assertNull($response->setContentType('text/html'));
        $this->assertNull($response->setContentType('application/json'));
    }

    /**
     * @covers Pushy\Network\Http\Response::setContentLength
     */
    public function testSetContentLength()
    {
        $response = new Response();

        $this->assertNull($response->setContentLength(10));
    }

    /**
     * @covers Pushy\Network\Http\Response::setContentLength
     */
    public function testSetContentLengthOverwrite()
    {
        $response = new Response();

        $this->assertNull($response->setContentLength(10));
        $this->assertNull($response->setContentLength(20));
    }

    /**
     * @covers Pushy\Network\Http\Response::setLastModified
     */
    public function testSetLastModified()
    {
        $response = new Response();

        $this->assertNull($response->setLastModified('Sun, 08 Sep 2013 14:15:48'));
    }

    /**
     * @covers Pushy\Network\Http\Response::setLastModified
     */
    public function testSetLastModifiedOverwrite()
    {
        $response = new Response();

        $this->assertNull($response->setLastModified('Sun, 08 Sep 2013 14:15:48'));
        $this->assertNull($response->setLastModified('Sun, 08 Sep 2014 14:15:48'));
    }

    /**
     * @covers Pushy\Network\Http\Response::setBody
     */
    public function testSetBody()
    {
        $response = new Response();

        $this->assertNull($response->setBody('body'));
    }

    /**
     * @covers Pushy\Network\Http\Response::setBody
     */
    public function testSetBodyOverwrite()
    {
        $response = new Response();

        $this->assertNull($response->setBody('body'));
        $this->assertNull($response->setBody('overwritten'));
    }

    /**
     * @covers Pushy\Network\Http\Response::setContentType
     * @covers Pushy\Network\Http\Response::setBody
     * @covers Pushy\Network\Http\Response::renderHeaders
     * @covers Pushy\Network\Http\Response::render
     *
     * @runInSeparateProcess
     */
    public function testRenderDefaultStatusCode()
    {
        $response = new Response();

        $this->assertNull($response->addHeader('foo', 'bar'));
        $this->assertNull($response->setContentType('text/html'));
        $this->assertNull($response->setBody('body content'));

        $this->assertSame('body content', $response->render());

        $this->assertSame(200, http_response_code());
    }

    /**
     * @covers Pushy\Network\Http\Response::setStatusCode
     * @covers Pushy\Network\Http\Response::setContentType
     * @covers Pushy\Network\Http\Response::setBody
     * @covers Pushy\Network\Http\Response::renderHeaders
     * @covers Pushy\Network\Http\Response::render
     *
     * @runInSeparateProcess
     */
    public function testRenderCustomStatusCode()
    {
        $response = new Response();

        $this->assertNull($response->setStatusCode('HTTP/1.1 404 Not Found'));
        $this->assertNull($response->addHeader('foo', 'bar'));
        $this->assertNull($response->setContentType('text/html'));
        $this->assertNull($response->setBody('body content'));

        $this->assertSame('body content', $response->render());

        $this->assertSame(404, http_response_code());
    }

    /**
     * @covers Pushy\Network\Http\Response::setStatusCode
     * @covers Pushy\Network\Http\Response::setContentType
     * @covers Pushy\Network\Http\Response::setBody
     * @covers Pushy\Network\Http\Response::renderHeaders
     * @covers Pushy\Network\Http\Response::render
     *
     * @runInSeparateProcess
     */
    public function testRenderCustomStatusCodeOverwritten()
    {
        $response = new Response();

        $this->assertNull($response->setStatusCode('HTTP/1.1 404 Not Found'));
        $this->assertNull($response->setStatusCode('HTTP/1.1 418 I\'m a teapot'));
        $this->assertNull($response->addHeader('foo', 'bar'));
        $this->assertNull($response->setContentType('text/html'));
        $this->assertNull($response->setBody('body content'));

        $this->assertSame('body content', $response->render());

        $this->assertSame(418, http_response_code());
    }

    /**
     * @covers Pushy\Network\Http\Response::addHeader
     * @covers Pushy\Network\Http\Response::setContentType
     * @covers Pushy\Network\Http\Response::setBody
     * @covers Pushy\Network\Http\Response::renderHeaders
     * @covers Pushy\Network\Http\Response::render
     *
     * @runInSeparateProcess
     */
    public function testRenderBody()
    {
        $response = new Response();

        $this->assertNull($response->addHeader('foo', 'bar'));
        $this->assertNull($response->setContentType('text/html'));
        $this->assertNull($response->setBody('body content'));

        $this->assertSame('body content', $response->render());
    }

    /**
     * @covers Pushy\Network\Http\Response::addHeader
     * @covers Pushy\Network\Http\Response::setContentType
     * @covers Pushy\Network\Http\Response::setBody
     * @covers Pushy\Network\Http\Response::renderHeaders
     * @covers Pushy\Network\Http\Response::render
     *
     * @runInSeparateProcess
     */
    public function testRenderBodyOverwritten()
    {
        $response = new Response();

        $this->assertNull($response->addHeader('foo', 'bar'));
        $this->assertNull($response->setContentType('text/html'));
        $this->assertNull($response->setBody('body content'));
        $this->assertNull($response->setBody('overwritten content'));

        $this->assertSame('overwritten content', $response->render());
    }

    /**
     * @covers Pushy\Network\Http\Response::addHeader
     * @covers Pushy\Network\Http\Response::setContentType
     * @covers Pushy\Network\Http\Response::setBody
     * @covers Pushy\Network\Http\Response::renderHeaders
     * @covers Pushy\Network\Http\Response::render
     *
     * @runInSeparateProcess
     */
    public function testRenderContentType()
    {
        $response = new Response();

        $this->assertNull($response->addHeader('foo', 'bar'));
        $this->assertNull($response->setContentType('text/css'));
        $this->assertNull($response->setBody('body content'));

        $this->assertSame('body content', $response->render());

        $this->assertContains('Content-Type: text/css', xdebug_get_headers());
    }

    /**
     * @covers Pushy\Network\Http\Response::addHeader
     * @covers Pushy\Network\Http\Response::setContentType
     * @covers Pushy\Network\Http\Response::setBody
     * @covers Pushy\Network\Http\Response::renderHeaders
     * @covers Pushy\Network\Http\Response::render
     *
     * @runInSeparateProcess
     */
    public function testRenderContentTypeOverwritten()
    {
        $response = new Response();

        $this->assertNull($response->addHeader('foo', 'bar'));
        $this->assertNull($response->setContentType('text/css'));
        $this->assertNull($response->setContentType('text/html'));
        $this->assertNull($response->setBody('body content'));

        $this->assertSame('body content', $response->render());

        $this->assertContains('Content-Type: text/html', xdebug_get_headers());
    }

    /**
     * @covers Pushy\Network\Http\Response::addHeader
     * @covers Pushy\Network\Http\Response::setContentLength
     * @covers Pushy\Network\Http\Response::setBody
     * @covers Pushy\Network\Http\Response::renderHeaders
     * @covers Pushy\Network\Http\Response::render
     *
     * @runInSeparateProcess
     */
    public function testRenderContentLength()
    {
        $response = new Response();

        $this->assertNull($response->addHeader('foo', 'bar'));
        $this->assertNull($response->setContentLength(10));
        $this->assertNull($response->setBody('body content'));

        $this->assertSame('body content', $response->render());

        $this->assertContains('Content-Length: 10', xdebug_get_headers());
    }

    /**
     * @covers Pushy\Network\Http\Response::addHeader
     * @covers Pushy\Network\Http\Response::setContentLength
     * @covers Pushy\Network\Http\Response::setBody
     * @covers Pushy\Network\Http\Response::renderHeaders
     * @covers Pushy\Network\Http\Response::render
     *
     * @runInSeparateProcess
     */
    public function testRenderContentLengthOverwritten()
    {
        $response = new Response();

        $this->assertNull($response->addHeader('foo', 'bar'));
        $this->assertNull($response->setContentLength(10));
        $this->assertNull($response->setContentLength(20));
        $this->assertNull($response->setBody('body content'));

        $this->assertSame('body content', $response->render());

        $this->assertContains('Content-Length: 20', xdebug_get_headers());
    }

    /**
     * @covers Pushy\Network\Http\Response::addHeader
     * @covers Pushy\Network\Http\Response::setLastModified
     * @covers Pushy\Network\Http\Response::setBody
     * @covers Pushy\Network\Http\Response::renderHeaders
     * @covers Pushy\Network\Http\Response::render
     *
     * @runInSeparateProcess
     */
    public function testRenderLastModified()
    {
        $response = new Response();

        $this->assertNull($response->addHeader('foo', 'bar'));
        $this->assertNull($response->setLastModified('Sun, 08 Sep 2013 14:15:48'));
        $this->assertNull($response->setBody('body content'));

        $this->assertSame('body content', $response->render());

        $this->assertContains('Last-Modified: Sun, 08 Sep 2013 14:15:48', xdebug_get_headers());
    }

    /**
     * @covers Pushy\Network\Http\Response::addHeader
     * @covers Pushy\Network\Http\Response::setLastModified
     * @covers Pushy\Network\Http\Response::setBody
     * @covers Pushy\Network\Http\Response::renderHeaders
     * @covers Pushy\Network\Http\Response::render
     *
     * @runInSeparateProcess
     */
    public function testRenderLastModifiedOverwritten()
    {
        $response = new Response();

        $this->assertNull($response->addHeader('foo', 'bar'));
        $this->assertNull($response->setLastModified('Sun, 08 Sep 2013 14:15:48'));
        $this->assertNull($response->setLastModified('Sun, 08 Sep 2014 14:15:48'));
        $this->assertNull($response->setContentType('text/html'));
        $this->assertNull($response->setBody('body content'));

        $this->assertSame('body content', $response->render());

        $this->assertContains('Last-Modified: Sun, 08 Sep 2014 14:15:48', xdebug_get_headers());
    }

    /**
     * @covers Pushy\Network\Http\Response::addHeader
     * @covers Pushy\Network\Http\Response::setContentType
     * @covers Pushy\Network\Http\Response::setBody
     * @covers Pushy\Network\Http\Response::renderHeaders
     * @covers Pushy\Network\Http\Response::render
     *
     * @runInSeparateProcess
     */
    public function testRenderHeaders()
    {
        $response = new Response();

        $this->assertNull($response->addHeader('foo', 'bar'));
        $this->assertNull($response->addHeader('foo', 'baz'));
        $this->assertNull($response->setBody('body content'));

        $this->assertSame('body content', $response->render());

        $this->assertContains('foo: bar,baz', xdebug_get_headers());
    }
}
