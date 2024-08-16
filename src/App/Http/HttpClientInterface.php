<?php

namespace Appcheap\SearchEngine\App\Http;

interface HttpClientInterface
{
    /**
     * Send a GET request to the specified URL.
     *
     * @param string $url
     * @param array $headers
     * @return mixed
     */
    public function get(string $url, array $headers = []);

    /**
     * Send a POST request to the specified URL.
     *
     * @param string $url
     * @param mixed $data
     * @param array $headers
     * @return mixed
     */
    public function post(string $url, mixed $data, array $headers = []);

    /**
     * Send a PUT request to the specified URL.
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return mixed
     */
    public function put(string $url, array $data, array $headers = []);

    /**
     * Send a DELETE request to the specified URL.
     *
     * @param string $url
     * @param array $headers
     * @return mixed
     */
    public function delete(string $url, array $headers = []);
}
