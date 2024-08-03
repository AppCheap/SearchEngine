<?php

namespace Appcheap\SearchEngine\App\Http;

/**
 * Class GuzzleHttpClient
 *
 * An HTTP client implementation using Guzzle.
 */
class GuzzleHttpClient implements HttpClientInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * GuzzleHttpClient constructor.
     * 
     * @param array $config The configuration for the Guzzle client.
     */
    public function __construct($config)
    {
        $this->client = $config['client'];
    }

    /**
     * Send an HTTP request using Guzzle.
     *
     * @param string $method The HTTP method (GET, POST, PUT, DELETE).
     * @param string $url The URL to send the request to.
     * @param array $options The options to send with the request.
     * @return mixed The response from the server.
     * @throws \Exception If there is a Guzzle error.
     */
    private function sendRequest(string $method, string $url, array $options = [])
    {
        try {
            $response = $this->client->request($method, $url, $options);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new \Exception("Guzzle error: " . $e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $url, array $headers = [])
    {
        return $this->sendRequest('GET', $url, ['headers' => $headers]);
    }

    /**
     * {@inheritdoc}
     */
    public function post(string $url, array $data, array $headers = [])
    {
        return $this->sendRequest('POST', $url, [
            'headers' => $headers,
            'json' => $data
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function put(string $url, array $data, array $headers = [])
    {
        return $this->sendRequest('PUT', $url, [
            'headers' => $headers,
            'json' => $data
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $url, array $headers = [])
    {
        return $this->sendRequest('DELETE', $url, ['headers' => $headers]);
    }
}