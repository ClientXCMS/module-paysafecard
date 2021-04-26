<?php
namespace App\Paysafecard\Navigations\Items;

use App\Paysafecard\Database\PaysafecardTable;
use ClientX\Auth\User;
use ClientX\Navigation\NavigationItemInterface;
use ClientX\Renderer\RendererInterface;

class PaysafecardCustomerItem implements NavigationItemInterface
{


    /**
     * @var PaysafecardTable
     */
    private $table;


    /**
     * @var User
     */
    private $user;

    public function __construct(PaysafecardTable $table)
    {
        $this->table    = $table;
    }

    public function render(RendererInterface $renderer): string
    {
        $tickets = $this->table->findForUser($this->user->getId());
        return $renderer->render('@paysafecard_admin/customer_menu', compact('tickets'));
    }

    public function getPosition(): int
    {
        return 100;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }
}
