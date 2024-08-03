<?php

namespace Appcheap\SearchEngine\App\Http;

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
     * @param string $method The HTTP method (GET, POST, PUT, DELETE).
     * @param string $url The URL to send the request to.
     * @param array $options The options to send with the request.
     * @return mixed The response from the server.
     * @throws \Exception If there is an error.
     */
    private function sendRequest(string $method, string $url, array $options = [])
    {
        $args = array_merge([
            'method' => $method,
            'headers' => $options['headers'] ?? [],
            'body' => $options['body'] ?? null,
        ], $options);

        $response = wp_remote_request($url, $args);

        if (is_wp_error($response)) {
            throw new \Exception("WordPress HTTP error: " . $response->get_error_message());
        }

        return json_decode(wp_remote_retrieve_body($response), true);
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
            'body' => json_encode($data)
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