<?php

namespace Bit8;

use Bit8\Api\ApiAbstract;
use Bit8\Api\Factory;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;


/**
 * Class Client
 * @package Bit8
 */
class Client implements ApiClientInterface
{

    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * Default Http Client
     * @var ClientInterface
     */
    public static $httpDefaultClient = \GuzzleHttp\Client::class;

    /**
     * default url API
     * @var null|string
     */
    protected $baseUri = 'http://localhost/';

    const API_REQUEST_TIMEOUT = 2.0;


    /**
     * Client constructor.
     * @param null $baseUri
     * @param ClientInterface|null $httpClient
     */
    public function __construct($baseUri = null, ClientInterface $httpClient = null)
    {

        if ($baseUri !== null)
            $this->baseUri = $baseUri;


        if ($httpClient instanceof ClientInterface) {
            $this->setHttpClient($httpClient);

        } else {
            $this->setHttpClient(new static::$httpDefaultClient(['base_uri' => $this->baseUri, 'timeout'  => static::API_REQUEST_TIMEOUT]));

        }


    }

    /**
     *
     * @param $type
     * @return ApiAbstract
     */
    public function api($type)
    {
        return Factory::create($type, $this);
    }

    /**
     * @return ClientInterface
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param ClientInterface $httpClient
     * @return $this
     */
    public function setHttpClient(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    /**
     *
     * @return $this
     */

    public function authenticate()
    {

        return $this;
    }


    /**
     * @return string
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * @param string $baseUri
     */
    public function setBaseUri($baseUri)
    {
        $this->baseUri = $baseUri;
    }


    /**
     * Путь до файла схемы
     * @param $resourceSchemaName
     * @return string
     */
    public function schemaPath($resourceSchemaName)
    {
        return __DIR__ . '/schemas/' . $resourceSchemaName;
    }


    /**
     * Send a GET request.
     * @param $path
     * @return ResponseInterface
     */
    public final function get($path)
    {
        return $this->getHttpClient()->request('GET', $path);

    }


    /**
     * Send a POST request.
     * @param $path
     * @param null $body
     * @return ResponseInterface
     */
    public function post($path, $body = null)
    {
        return $this->getHttpClient()->request('GET', $path, ['body' => $body]);
    }

    /**
     * Send a PATH request.
     * @param $path
     * @param null $body
     * @return ResponseInterface
     */
    public function patch($path, $body = null)
    {
        return $this->getHttpClient()->request($path, 'PATCH', ['body' => $body]);
    }

    /**
     * Send a DELETE request.
     * @param $path
     * @param null $body
     * @return ResponseInterface
     */
    public function delete($path, $body = null)
    {
        return $this->getHttpClient()->request($path, 'DELETE', ['body' => $body]);
    }

    /**
     * Send a PUT request.
     * @param $path
     * @param $body
     * @return ResponseInterface
     */
    public function put($path, $body)
    {
        return $this->getHttpClient()->request($path, 'PUT', ['body' => $body]);
    }


}