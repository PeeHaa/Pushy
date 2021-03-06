<?php
/**
 * HTTP response object
 *
 * PHP version 5.4
 *
 * @category   Pushy
 * @package    Network
 * @package    Http
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace Pushy\Network\Http;

/**
 * HTTP response object
 *
 * @category   Pushy
 * @package    Network
 * @package    Http
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Response implements ResponseData
{
    /**
     * @var string The status code header
     */
    private $statusCode = 'HTTP/1.1 200 OK';

    /**
     * @var array The headers to be send
     */
    private $headers = [];

    /**
     * @var string The response body
     */
    private $body;

    /**
     * Sets the status code of the response
     *
     * @param string $statusCode The status code of the response
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * Adds a header
     *
     * @param string $key   The key of the header
     * @param string $value The value of the header
     */
    public function addHeader($key, $value)
    {
        if (!array_key_exists($key, $this->headers)) {
            $this->headers[$key] = [];
        }

        $this->headers[$key][] = $value;
    }

    /**
     * Sets the response content type
     *
     * @param string $contentType The content type
     */
    public function setContentType($contentType)
    {
        $this->headers['Content-Type'] = $contentType;
    }

    /**
     * Sets the content length
     *
     * @param int $contentLength The content length
     */
    public function setContentLength($contentLength)
    {
        $this->headers['Content-Length'] = $contentLength;
    }

    /**
     * Sets the last modified header
     *
     * @param string $timestamp The timestamp the resource is last modified at
     */
    public function setLastModified($timestamp)
    {
        $this->headers['Last-Modified'] = $timestamp;
    }

    /**
     * Adds body to the response
     *
     * @param string $content The body content
     */
    public function setBody($content)
    {
        $this->body = $content;
    }

    /**
     * Renders the response
     *
     * @return string The body of the response
     */
    public function render()
    {
        $this->renderHeaders();

        return $this->body;
    }

    /**
     * Renders the HTTP headers
     */
    private function renderHeaders()
    {
        header($this->statusCode);

        foreach ($this->headers as $key => $headersOrValue) {
            if (!is_array($headersOrValue)) {
                $value = $headersOrValue;
            } elseif (count($headersOrValue) === 1) {
                $value = $headersOrValue[0];
            } else {
                $value = implode(',', $headersOrValue);
            }

            header($key . ': ' . $value);
        }
    }
}
