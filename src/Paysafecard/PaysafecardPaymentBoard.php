<?php

namespace App\Paysafecard;

use App\Paysafecard\Database\PaysafecardTable;
use App\Shop\Payment\AbstractPaymentBoard;

class PaysafecardPaymentBoard extends AbstractPaymentBoard
{


    protected string $entity = PaysafecardPaymentType::class;
    protected string $type = 'paysafecardmanual';
    private bool $remove = true;

    public function __construct(PaysafecardTable $table)
    {
        $this->table = $table;
    }

    protected function makeAbstractQuery(): \ClientX\Database\Query
    {
        return $this->table->makeQuery()
            ->select('COALESCE(SUM(value), 0) as total')
            ->where('state = :state')
            ->params(['state' => 'success']);
    }


    public function clearBoard(): bool
    {
        return $this->table->makeQuery()
                ->setCommand("DELETE")
                ->execute() != false;
    }
}