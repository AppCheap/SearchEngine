<?php

use PHPUnit\Framework\TestCase;
use Appcheap\SearchEngine\App\Http\CurlHttpClient;
use Appcheap\SearchEngine\App\Http\HttpClientInterface;

class CurlHttpClientTest extends TestCase
{
    public function testGetRequest()
    {
        $client = new CurlHttpClient(
            function() { return 'mock'; }, // curl_init
            function($ch, $option, $value) {}, // curl_setopt
            function($ch) { return json_encode(['success' => true]); }, // curl_exec
            function($ch) { return ''; }, // curl_error
            function($ch) {} // curl_close
        );

        $response = $client->get('https://api.example.com/test');

        $this->assertEquals(['success' => true], $response);
    }

    public function testPostRequest()
    {
        $client = new CurlHttpClient(
            function() { return 'mock'; }, // curl_init
            function($ch, $option, $value) {}, // curl_setopt
            function($ch) { return json_encode(['success' => true]); }, // curl_exec
            function($ch) { return ''; }, // curl_error
            function($ch) {} // curl_close
        );

        $response = $client->post('https://api.example.com/test', ['data' => 'value']);

        $this->assertEquals(['success' => true], $response);
    }

    public function testPutRequest()
    {
        $client = new CurlHttpClient(
            function() { return 'mock'; }, // curl_init
            function($ch, $option, $value) {}, // curl_setopt
            function($ch) { return json_encode(['success' => true]); }, // curl_exec
            function($ch) { return ''; }, // curl_error
            function($ch) {} // curl_close
        );

        $response = $client->put('https://api.example.com/test', ['data' => 'value']);

        $this->assertEquals(['success' => true], $response);
    }

    public function testDeleteRequest()
    {
        $client = new CurlHttpClient(
            function() { return 'mock'; }, // curl_init
            function($ch, $option, $value) {}, // curl_setopt
            function($ch) { return json_encode(['success' => true]); }, // curl_exec
            function($ch) { return ''; }, // curl_error
            function($ch) {} // curl_close
        );

        $response = $client->delete('https://api.example.com/test');

        $this->assertEquals(['success' => true], $response);
    }

    public function testCurlError()
    {
        $client = new CurlHttpClient(
            function() { return 'mock'; }, // curl_init
            function($ch, $option, $value) {}, // curl_setopt
            function($ch) { return false; }, // curl_exec
            function($ch) { return 'Error occurred'; }, // curl_error
            function($ch) {} // curl_close
        );

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Curl error: Error occurred');

        $client->get('https://api.example.com/test');
    }
}
