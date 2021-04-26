<?php
namespace App\Paysafecard\Navigations\Items;

use App\Paysafecard\Database\PaysafecardTable;
use ClientX\Navigation\NavigationItemInterface;
use ClientX\Renderer\RendererInterface;

class PaysafecardAdminItem implements NavigationItemInterface
{
    private PaysafecardTable $paysafecard;

    public function __construct(PaysafecardTable $paysafecard)
    {
        $this->paysafecard = $paysafecard;
    }
    public function render(RendererInterface $renderer): string
    {
        $count = $this->paysafecard->countPending();
        return $renderer->render('@paysafecard_admin/menu', compact('count'));
    }

    public function getPosition(): int
    {
        return 50;
    }
}
