<?php

use Phinx\Migration\AbstractMigration;

class CreatePaysafecardTable extends AbstractMigration
{
    public function change()
    {
        $this->table('paysafecards')
            ->addColumn('code', 'string', ['limit' => 16])
            ->addColumn('value', 'integer')
            ->addColumn('account_id', 'integer')
            ->addColumn('status', 'integer', ['default' => 0])
            ->addTimestamps()
            ->addForeignKey('account_id', 'users', ['id'], ['delete' => 'CASCADE'])
            ->create();
    }
}
