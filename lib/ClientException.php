<?php

namespace QvaPay;

use Exception;

/**
 * ClientException Class.
 *
 * @category Class
 *
 * @author   Omar Villafuerte
 *
 * @link     https://ovillafuerte94.is-a.dev
 */
class ClientException extends Exception
{
    /**
     * The HTTP body of the server response either as Json or string.
     *
     * @var \stdClass|string|null
     */
    protected $responseBody;

    /**
     * The HTTP header of the server response.
     *
     * @var string[]|null
     */
    protected $responseHeaders;

    /**
     * The deserialized response object.
     *
     * @var \stdClass|string|null
     */
    protected $responseObject;

    /**
     * Constructor.
     *
     * @param string                $message         Error message
     * @param int                   $code            HTTP status code
     * @param string[]|null         $responseHeaders HTTP response header
     * @param \stdClass|string|null $responseBody    HTTP decoded body of the server response either as \stdClass or string
     */
    public function __construct(string $message = '', int $code = 0, $responseHeaders = [], $responseBody = null)
    {
        parent::__construct($message, $code);
        $this->setResponseHeaders($responseHeaders);
        $this->setResponseBody($responseBody);
    }

    /**
     * Get the HTTP body of the server response either as Json or string.
     *
     * @return \stdClass|string|null
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * Set the HTTP body of the server response either as Json or string.
     *
     * @param \stdClass|string|null $responseBody The HTTP body of the server response either as Json or string.
     *
     * @return self
     */
    public function setResponseBody($responseBody)
    {
        $this->responseBody = $responseBody;

        return $this;
    }

    /**
     * Get the HTTP header of the server response.
     *
     * @return string[]|null
     */
    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }

    /**
     * Set the HTTP header of the server response.
     *
     * @param string[]|null $responseHeaders The HTTP header of the server response.
     *
     * @return self
     */
    public function setResponseHeaders($responseHeaders)
    {
        $this->responseHeaders = $responseHeaders;

        return $this;
    }

    /**
     * Get the deserialized response object.
     *
     * @return \stdClass|string|null
     */
    public function getResponseObject()
    {
        return $this->responseObject;
    }

    /**
     * Set the deserialized response object.
     *
     * @param \stdClass|string|null $responseObject The deserialized response object
     *
     * @return self
     */
    public function setResponseObject($responseObject)
    {
        $this->responseObject = $responseObject;

        return $this;
    }
}
