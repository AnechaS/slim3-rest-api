<?php

namespace Tests\Integration;

use Tests\Integration\BaseTestCase;
use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use App\Models\User;
use Firebase\JWT\JWT;

class UserTest extends BaseTestCase {
    private static $authToken = '';

    public static function setUpBeforeClass (): void {
        $phinx = new PhinxApplication();
        $phinx->setAutoExit(false);
        $phinx->run(new StringInput('migrate -e test'), new NullOutput());

        $user = User::create([
            'email' => 'root@email.com',
            'password' => 'xxxxxx',
            'name' => 'root'
        ]);

        self::$authToken = JWT::encode(['id' => $user->id], getenv("JWT_SECRET"));
    }

    static public function tearDownAfterClass(): void {
        User::truncate();
    }

    public function testGetUsers() {
        $response = $this->runApp('GET', '/users', null, self::$authToken);

        $data = json_decode($response->getBody(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));
    }
}