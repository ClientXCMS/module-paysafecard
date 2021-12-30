<?php

namespace App\Paysafecard\Navigations\Items;

use App\Paysafecard\Database\PaysafecardTable;
use ClientX\Navigation\NavigationItemInterface;
use ClientX\Renderer\RendererInterface;

class PaysafecardWidget implements NavigationItemInterface
{

    /**
     * @var \App\Paysafecard\Database\PaysafecardTable
     */
    private PaysafecardTable $paysafecardTable;

    public function __construct(PaysafecardTable $paysafecardTable)
    {
        $this->paysafecardTable = $paysafecardTable;
    }

    public function render(RendererInterface $renderer): string
    {
        return $renderer->render('@paysafecard_admin/dashboard', ['count' =>  $this->paysafecardTable->countPending()]);
    }

    public function getPosition(): int
    {
        return 1;
    }
}