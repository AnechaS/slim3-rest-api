<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                "name" => 'root',
                "email" => "root@email.com",
                "password" => password_hash('xxxxxx', PASSWORD_DEFAULT),
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            ],
        ];

        $users = $this->table("users");
        $users
            ->insert($data)
            ->save();
    }
}
