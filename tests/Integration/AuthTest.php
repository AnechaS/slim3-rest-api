<?php

namespace Tests\Integration;

use Tests\Integration\BaseTestCase;
use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use App\Models\User;

class AuthTest extends BaseTestCase {
    static public function setUpBeforeClass (): void {
        $phinx = new PhinxApplication();
        $phinx->setAutoExit(false);
        $phinx->run(new StringInput('migrate -e test'), new NullOutput());
        $phinx->run(new StringInput('seed:run -s UserSeeder -e test'), new NullOutput());
    }

    static public function tearDownAfterClass(): void {
        User::truncate();
    }

    public function testLogin() {
        $response = $this->runApp('POST', '/auth/login', [
            'email' => 'root@email.com',
            'password' => 'xxxxxx'
        ]);

        $data = json_decode($response->getBody(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertEquals($data['email'], 'root@email.com');
        $this->assertNull($data['password']);
    }

    public function testRegister() {
        $response = $this->runApp('POST', '/auth/register', [
            'name' => 'test',
            'email' => 'test@email.com',
            'password' => '123456'
        ]);

        $data = json_decode($response->getBody(), true);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        $this->assertEquals($data['name'], 'test');
        $this->assertEquals($data['email'], 'test@email.com');
        $this->assertNull($data['password']);
    }
}