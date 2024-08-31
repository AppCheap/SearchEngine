<?php

use PHPUnit\Framework\TestCase;
use Appcheap\SearchEngine\App\Http\WpHttpClient;
use Brain\Monkey;
use Brain\Monkey\Functions;

class WpHttpClientTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        Monkey\setUp();
    }

    protected function tearDown()
    {
        Monkey\tearDown();
        parent::tearDown();
    }

    public function testGetRequest()
    {
        Functions\when('wp_remote_request')->justReturn([
            'body' => json_encode(['success' => true]),
        ]);

        Functions\when('wp_remote_retrieve_body')->alias(function ($response) {
            return $response['body'];
        });

        $client = new WpHttpClient();
        $response = $client->get('https://api.example.com/test');

        $this->assertEquals(['success' => true], $response);
    }

    public function testPostRequest()
    {
        Functions\when('wp_remote_request')->justReturn([
            'body' => json_encode(['success' => true]),
        ]);

        Functions\when('wp_remote_retrieve_body')->alias(function ($response) {
            return $response['body'];
        });

        $client = new WpHttpClient();
        $response = $client->post('https://api.example.com/test', ['data' => 'value']);

        $this->assertEquals(['success' => true], $response);
    }

    public function testPutRequest()
    {
        Functions\when('wp_remote_request')->justReturn([
            'body' => json_encode(['success' => true]),
        ]);

        Functions\when('wp_remote_retrieve_body')->alias(function ($response) {
            return $response['body'];
        });

        $client = new WpHttpClient();
        $response = $client->put('https://api.example.com/test', ['data' => 'value']);

        $this->assertEquals(['success' => true], $response);
    }

    public function testDeleteRequest()
    {
        Functions\when('wp_remote_request')->justReturn([
            'body' => json_encode(['success' => true]),
        ]);

        Functions\when('wp_remote_retrieve_body')->alias(function ($response) {
            return $response['body'];
        });

        $client = new WpHttpClient();
        $response = $client->delete('https://api.example.com/test');

        $this->assertEquals(['success' => true], $response);
    }

    public function testWpError()
    {
        $mockError = Mockery::mock('WP_Error');
        $mockError->shouldReceive('get_error_message')->andReturn('Error occurred');

        Functions\when('wp_remote_request')->justReturn($mockError);
        Functions\when('is_wp_error')->justReturn(true);

        $client = new WpHttpClient();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('WordPress HTTP error: Error occurred');

        $client->get('https://api.example.com/test');
    }
}
