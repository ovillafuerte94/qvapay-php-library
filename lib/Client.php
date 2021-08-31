<?php

namespace Qvapay;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

/**
 * Client Class
 *
 * @category Class
 * @package  QvaPay
 * @author   Omar Villafuerte
 * @link    https://ovillafuerte94.is-a.dev
 */
class Client
{
    /**
     * Application ID
     *
     * @var string
     */
    protected $app_id;

    /**
     * Application secret key
     *
     * @var string
     */
    protected $app_secret;

    /**
     * Api version
     *
     * @var string
     */
    protected $version = 'v1';

    /**
     * Api URL
     *
     * @var string
     */
    protected $api_url = "https://qvapay.com/api/";

    /**
     * Http Client
     *
     * @var GuzzleHttp\Client
     */
    protected $http_client;

    /**
     * Construct
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (empty($config['app_id'])) {
            throw new \InvalidArgumentException('The app_id parameter is required');
        }else {
            $this->app_id = $config['app_id'];
        }

        if (empty($config['app_secret'])) {
            throw new \InvalidArgumentException('The app_secret parameter is required');
        }else {
            $this->app_secret = $config['app_secret'];
        }

        if (array_key_exists('version', $config) && is_numeric($config['version'])) {
            $this->version = "v" . $config['version'];
        }

        /* prepare http client */
        $this->http_client = new GuzzleClient([
            'base_uri' => $this->api_url . $this->version . "/",
        ]);
    }

    /**
     * Get application information
     *
     * @return mixed
     */
    public function info()
    {
        return $this->request("info");
    }

    /**
     * Create payment invoice
     *
     * @param array     $data
     * @return mixed
     */
    public function create_invoice(array $data)
    {
        if (!array_key_exists('amount', $data)) {
            throw new \InvalidArgumentException('The amount parameter is required');
        }

        if (!is_numeric($data['amount'])) {
            throw new \InvalidArgumentException('The amount parameter not valid');
        }

        if (array_key_exists('description', $data) && strlen($data['description']) > 300) {
            throw new \InvalidArgumentException('The description parameter cannot contain more than 300 characters');
        }

        return $this->request("create_invoice", $data);
    }

    /**
     * Gets transactions list, paginated by 50 items per request
     *
     * @param int     $page   Page number
     * @return mixed
     */
    public function transactions(int $page = 1)
    {
        return $this->request("transactions", [
            'page' => $page,
        ]);
    }

    /**
     * Get Transaction by UUID
     *
     * @param string $uuid  Universal Unique Identifier
     * @return mixed
     */
    public function get_transaction($uuid)
    {
        /* verify uuid */
        if (preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $uuid) !== 1) {
            throw new \InvalidArgumentException('The parameter uuid not valid');
        }

        return $this->request("transaction/" . $uuid);
    }

    /**
     * Get your balance
     *
     * @return mixed
     */
    public function balance()
    {
        return $this->request("balance");
    }

    /**
     * Request to Qvapay api endpoint
     *
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */
    public function request($endpoint, array $data = [])
    {
        try {
            $request = $this->http_client->request('GET', $endpoint, [
                'query' => array_merge($data, [
                    'app_id' => $this->app_id,
                    'app_secret' => $this->app_secret,
                ])
            ]);
        } catch (RequestException $e) {
            throw new ClientException(
                "[{$e->getCode()}] {$e->getMessage()}",
                (int) $e->getCode(),
                $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                $e->getResponse() ? (string) $e->getResponse()->getBody() : null
            );
        }

        if ($request->getStatusCode() != 200) {
            throw new ClientException(
                sprintf(
                    '[%d] Error connecting to (%s)',
                    $request->getStatusCode(),
                    (string) $request->getUri()
                ),
                $request->getStatusCode(),
                $request->getHeaders(),
                (string) $request->getBody()
            );
        } else {
            $response = $request->getBody()->getContents();
            if (isJson($response)) {
                return json_decode($response);
            }else{
                return $response;
            }
        }
    }
}
