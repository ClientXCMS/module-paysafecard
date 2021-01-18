<?php
namespace App\Paysafecard\Database;

use App\Paysafecard\Entity\Paysafecard;
use ClientX\Database\Table;

class PaysafecardTable extends Table
{

    protected $entity = Paysafecard::class;
    protected $table  = "paysafecards";
    protected $element = "code";

    public function findForUser(int $id)
    {
        return $this->makeQuery()->where('account_id = :id')->params(compact('id'));
    }
}
