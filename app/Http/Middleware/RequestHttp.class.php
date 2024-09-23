<?php

namespace App\Http\Middleware\RequestHttp;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

require_once __DIR__ . './../../../lib/guzzle/autoload.php';

class RequestClient
{
    private $client;
    private $header = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json; charset=utf-8'
    ];

    public function __construct($baseUri)
    {
        $this->client = new Client([
            'base_uri' => $baseUri
        ]);
    }

    public function get($uri)
    {
        try {
            $response = $this->client->request('GET', $uri, [
                'headers' => $this->header,
                'timeout' => 10
            ]);
            return $this->handleResponse($response);
        } catch (RequestException $e) {
            echo $e->getMessage();
        }
    }

    public function post($uri, $data = [])
    {
        try {
            $response = $this->client->request('POST', $uri, [
                'headers' => $this->header,
                'json' => $data
            ]);
            return $this->handleResponse($response);
        } catch (RequestException $e) {
            echo $e->getMessage();
        }
    }

    public function put($uri, $data = [])
    {
        try {
            $response = $this->client->request('PUT', $uri, [
                'headers' => $this->header,
                'json' => $data
            ]);
            return $this->handleResponse($response);
        } catch (RequestException $e) {
            echo $e->getMessage();
        }
    }

    public function delete($uri)
    {
        try {
            $response = $this->client->request('DELETE', $uri, [
                'headers' => $this->header
            ]);
            return $this->handleResponse($response);
        } catch (RequestException $e) {
            echo $e->getMessage();
        }
    }

    private function handleResponse($response)
    {
        $stCode = $response->getStatusCode();
        $body = $response->getBody();
        $bodyArr = json_decode($body, true);
        return [
            'status_code' => $stCode,
            'body' => $bodyArr
        ];
    }
}
