<?php

namespace Appcheap\SearchEngine\App\Http;


use Appcheap\SearchEngine\App\Exception\HttpClientErrorFactory;
use Appcheap\SearchEngine\App\Exception\HttpClientError;

/**
 * Class CurlHttpClient
 *
 * An HTTP client implementation using cURL.
 */
class CurlHttpClient implements HttpClientInterface
{
    private $curlInit;
    private $curlSetopt;
    private $curlExec;
    private $curlError;
    private $curlClose;
    private $curlGetinfo;

    public function __construct(
        callable $curlInit = null,
        callable $curlSetopt = null,
        callable $curlExec = null,
        callable $curlError = null,
        callable $curlClose = null,
        callable $curlGetinfo = null
    ) {
        $this->curlInit = $curlInit ?: 'curl_init';
        $this->curlSetopt = $curlSetopt ?: 'curl_setopt';
        $this->curlExec = $curlExec ?: 'curl_exec';
        $this->curlError = $curlError ?: 'curl_error';
        $this->curlClose = $curlClose ?: 'curl_close';
        $this->curlGetinfo = $curlGetinfo ?: 'curl_getinfo';
    }

    /**
     * Send an HTTP request using cURL.
     *
     * @param string $method The HTTP method (GET, POST, PUT, DELETE).
     * @param string $url The URL to send the request to.
     * @param array $data The data to send with the request.
     * @param array $headers The headers to send with the request.
     * @return mixed The response from the server.
     * @throws HttpClientError If there is a cURL error.
     */
    private function sendRequest(string $method, string $url, array $data = [], array $headers = [])
    {
        $ch = call_user_func($this->curlInit);

        switch (strtoupper($method)) {
            case 'GET':
                if (!empty($data)) {
                    $url .= '?' . http_build_query($data);
                }
                break;
            case 'POST':
                call_user_func($this->curlSetopt, $ch, CURLOPT_POST, true);
                call_user_func($this->curlSetopt, $ch, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case 'PUT':
                call_user_func($this->curlSetopt, $ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                call_user_func($this->curlSetopt, $ch, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case 'DELETE':
                call_user_func($this->curlSetopt, $ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }

        call_user_func($this->curlSetopt, $ch, CURLOPT_URL, $url);
        call_user_func($this->curlSetopt, $ch, CURLOPT_RETURNTRANSFER, true);
        call_user_func($this->curlSetopt, $ch, CURLOPT_HTTPHEADER, array_merge(['Content-Type: application/json'], $headers));

        $response = call_user_func($this->curlExec, $ch);
        $error = call_user_func($this->curlError, $ch);
        $statusCode = call_user_func($this->curlGetinfo, $ch, CURLINFO_HTTP_CODE);

        call_user_func($this->curlClose, $ch);

        if ($error) {
            throw HttpClientErrorFactory::createException($statusCode,  $error);
        }

        return json_decode($response, true);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $url, array $headers = [])
    {
        return $this->sendRequest('GET', $url, [], $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function post(string $url, array $data, array $headers = [])
    {
        return $this->sendRequest('POST', $url, $data, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function put(string $url, array $data, array $headers = [])
    {
        return $this->sendRequest('PUT', $url, $data, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $url, array $headers = [])
    {
        return $this->sendRequest('DELETE', $url, [], $headers);
    }
}
