<?php

namespace Qvapay;

use GuzzleHttp\Client as HttpClient;

class Client
{
    /**
     * Application ID.
     *
     * @var string
     */
    protected $app_id;

    /**
     * Application secret key.
     *
     * @var string
     */
    protected $app_secret;

    /**
     * Api version.
     *
     * @var string
     */
    protected $version = 'v1';

    /**
     * Api URL.
     *
     * @var string
     */
    protected $api_url = 'https://qvapay.com/api/';

    /**
     * Http Client.
     *
     * @var GuzzleHttp\Client
     */
    protected $http_client;

    /**
     * Construct.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        /* Get your app credentials at: https://qvapay.com/apps/create */
        $this->app_id = $config['app_id'];
        $this->app_secret = $config['app_secret'];

        if (\array_key_exists('version', $config) && \is_numeric($config['version'])) {
            $this->version = 'v'.$config['version'];
        }

        /* prepare http client */
        $this->http_client = new HttpClient([
            'base_uri' => $this->api_url.$this->version.'/',
        ]);
    }

    /**
     * Get application information.
     *
     * @return mixed
     */
    public function info()
    {
        return $this->request('info');
    }

    /**
     * Create payment invoice.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create_invoice(array $data)
    {
        return $this->request('create_invoice', $data);
    }

    /**
     * Gets transactions list, paginated by 50 items per request.
     *
     * @param int $page
     *
     * @return mixed
     */
    public function transactions(int $page = 1)
    {
        return $this->request('transactions', [
            'page' => $page,
        ]);
    }

    /**
     * Get Transaction by UUID.
     *
     * @param string $uuid
     *
     * @return mixed
     */
    public function get_transaction($uuid)
    {
        return $this->request('transaction/'.$uuid);
    }

    /**
     * Get your balance.
     *
     * @return mixed
     */
    public function balance()
    {
        return $this->request('balance');
    }

    /**
     * Request to Qvapay Api.
     *
     * @param string $path
     * @param array  $data
     *
     * @return mixed
     */
    private function request($path, array $data = [], $method = 'GET')
    {
        /**
         * Prepare options.
         */
        $options = [
            'query' => ($method == 'GET') ? \array_merge($data, [
                'app_id' => $this->app_id,
                'app_secret' => $this->app_secret,
            ]) : [
                'app_id' => $this->app_id,
                'app_secret' => $this->app_secret,
            ],
        ];

        /**
         * Method is POST.
         */
        if ($method == 'POST') {
            $options['form_params'] = $data;
        }

        $response = $this->http_client->request($method, $path, $options);

        if ($response->getStatusCode() != 200) {
            return $response->getBody()->getContents();
        } else {
            return \json_decode($response->getBody()->getContents());
        }
    }
}
