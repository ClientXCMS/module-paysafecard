<?php

use App\Paysafecard\Entity\Paysafecard;
use Phinx\Migration\AbstractMigration;

class CreatePaysafecardTable extends AbstractMigration
{
    public function change()
    {
        $this->table('paysafecards')
            ->addColumn('pin', 'string', ['limit' => 20])
            ->addColumn('value', 'integer')
            ->addColumn('user_id', 'integer')
            ->addColumn('state', 'string', ['default' => Paysafecard::PENDING])
            ->addColumn('admin_id', 'integer', ['null' => true])
            ->addColumn('verified_at', 'datetime', ['null' => true])
            ->addTimestamps()
            ->addForeignKey('user_id', 'users', ['id'], ['delete' => 'CASCADE'])
            ->addForeignKey('admin_id', 'admins', ['id'], ['delete' => 'CASCADE'])
            ->create();
    }
}
