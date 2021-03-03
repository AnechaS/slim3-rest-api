<?php

namespace Tests\Integration;

use Tests\Integration\BaseTestCase;

class SampleTest extends BaseTestCase {
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function testGetHome() {
        $response = $this->runApp('GET', '/');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    }

    public function testNotfound() {
        $response = $this->runApp('GET', '/hello');
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    }
}