<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

/**
 * Todo use Eloquent
 */
final class CreateUsersTable extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('users');
        $table
            ->addColumn('name', 'string', ['limit' => 40])
            ->addColumn('email', 'string', ['limit' => 40])
            ->addColumn('password', 'string', ['limit' => 225])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['email'], ['unique' => true])
            ->create();
    }
}