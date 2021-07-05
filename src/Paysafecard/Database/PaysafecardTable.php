<?php

namespace App\Paysafecard\Database;

use App\Paysafecard\Entity\Paysafecard;
use ClientX\Database\Query;
use ClientX\Database\Table;

class PaysafecardTable extends Table
{

    protected $entity = Paysafecard::class;
    protected $table = "paysafecards";
    protected $element = "pin";
    protected $order = "state DESC";

    public function create(Paysafecard $paysafecard)
    {
        return $this->insert([
            'pin' => $paysafecard->getPin(),
            'value' => $paysafecard->getValue(),
            'user_id' => $paysafecard->getUserId(),
            'state' => $paysafecard->getState()
        ]);
    }

    public function updateState(int $id, string $state)
    {
        return $this->update($id, compact('state'));
    }

    public function saveAdmin(Paysafecard $paysafecard)
    {
        return $this->update($paysafecard->getId(), [
            'admin_id' => $paysafecard->getAdminId(),
            'verified_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function countPending()
    {
        return $this->makeQuery()
            ->where('state = :state')
            ->params(['state' => Paysafecard::PENDING])
            ->count();
    }

    public function makeQueryForAdmin(?array $search = null, $order = "desc"): Query
    {
        $sql2 = 'CONCAT(u.firstname," ",u.lastname) as username';
		
        $where = "";
        if (isset($search['s'])) {
            $where .= "{$this->element} LIKE '%" . trim($search['s']) . "%'";
        }
        $query = parent::makeQuery();
        if (!empty($where)) {
            $query->where($where);
        }
		$query
        ->select($sql2, 'u.id as userId', 'p.*')
        ->join("users u", "u.id = p.user_id AND p.user_id IS NOT NULL");
        return $query;
    }
}
