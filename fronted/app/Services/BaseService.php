<?php
namespace App\Services;

use CodeIgniter\HTTP\CURLRequest;
use Config\Services;

class BaseService {
    /**
    * @var CURLRequest
    */
    protected $httpClient;

    /**
    * @var string
    */
    protected $baseUrl;

    public function __construct() {
        $this->baseUrl = env('API_URL', 'http://localhost:3000/api/');

        $this->httpClient = Services::curlrequest();
    }

    public function getHeaders() : array
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        if(session()->has('jwt_token')) {
            $headers['Authorization'] = session()->get('jwt_token');
        }

        return $headers;
    }

    public function sendRequest(string $method, string $endpoint, array $data = [])
    {
        $options = [
            'headers' => $this->getHeaders(),
            'http_errors' => false
        ];

        $method = strtoupper($method);
        if($method === 'GET') {
            $options['query'] = $data;
        } else {
            $options['json'] = $data;
        }

        try {
            $response = $this->httpClient->request($method, $this->baseUrl . $endpoint, $options);

            $body = json_decode($response->getBody(), true);

            return [
                'status' => $response->getStatusCode(),
                'data' => $body
            ];

        } catch(\Exception $e) {
            return [
                'status' => 500,
                'data' => ['error' => $e->getMessage()]
            ];
        }
    }
}