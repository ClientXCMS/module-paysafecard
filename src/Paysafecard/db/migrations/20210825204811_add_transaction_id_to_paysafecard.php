<?php

use Phinx\Migration\AbstractMigration;

class AddTransactionIdToPaysafecard extends AbstractMigration
{
    public function change()
    {
        $this->table("paysafecards")
            ->addColumn("transaction_id", "integer", ["null" => true])
            ->save();

    }
}