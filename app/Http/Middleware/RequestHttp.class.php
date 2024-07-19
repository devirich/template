<?php

namespace App\Http\Middleware\RequestHttp;

require_once __DIR__ . './../../../lib/autoload.php';

class RequestClient
{
    public $options = [
        //'base_uri' => '',
        'timeout' => 3.0,
        /* 'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ] */
    ];

    public function setDefault($options)
    {
        $this->options = $options;
    }

    public function get($url, $headers = [], $body = [])
    {
        $client = new \GuzzleHttp\Client($this->options);
        $response = $client->request('GET', $url, [
            'headers' => $headers,
            'query' => $body
        ]);
        $body = $response->getBody();
        $result = $body->getContents($body);
        $res = json_decode($result);
        return $res;
    }

    public function post($url, $headers = [], $body = [])
    {
        $client = new \GuzzleHttp\Client($this->options);
        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'json' => $body,
            'debug' => true
        ]);
        $body = $response->getBody();
        $result = $body->getContents($body);
        $res = json_decode($result);
        return $res;
    }

    public function put($url, $headers = [], $body = [])
    {
        $client = new \GuzzleHttp\Client($this->options);
        $response = $client->request('PUT', $url, [
            'headers' => $headers,
            'body' => $body
        ]);
        return $response;
    }

    public function delete($url, $headers = [])
    {
        $client = new \GuzzleHttp\Client($this->options);
        $response = $client->request('DELETE', $url, [
            'headers' => $headers,
        ]);
        return $response;
    }
}
