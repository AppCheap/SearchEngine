<?php

namespace Appcheap\SearchEngine\App\Http;

use Appcheap\SearchEngine\App\Exception\HttpClientErrorFactory;
use Appcheap\SearchEngine\App\Exception\HttpClientError;

/**
 * Class WpHttpClient
 *
 * An HTTP client implementation using WordPress's wp_remote_request.
 */
class WpHttpClient implements HttpClientInterface
{
    /**
     * Send an HTTP request using wp_remote_request.
     *
     * @param string $method  The HTTP method (GET, POST, PUT, DELETE).
     * @param string $url     The URL to send the request to.
     * @param array  $options The options to send with the request.
     * @return mixed The response from the server.
     * @throws HttpClientError If there is an HTTP error.
     */
    private function sendRequest(string $method, string $url, array $options = [])
    {
        $args = array_merge([
            'method' => $method,
            'headers' => $options['headers'] ?? [],
            'body' => $options['body'] ?? null,
            'timeout' => 30,
        ], $options);

        $response = wp_remote_request($url, $args);

        if (is_wp_error($response)) {
            $code = $response->get_error_code();
            if (is_string($code)) {
                $code = 403;
            }
            throw new HttpClientError((int)$code, $response->get_error_message());
        }

        return $response;
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
    public function post(string $url, $data, array $headers = [])
    {
        return $this->sendRequest('POST', $url, [
            'headers' => $headers,
            'body' => is_string($data) ? $data : json_encode($data)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function put(string $url, array $data, array $headers = [])
    {
        return $this->sendRequest('PUT', $url, [
            'headers' => $headers,
            'body' => json_encode($data)
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
