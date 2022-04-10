<?php
namespace App\Paysafecard\Navigations\Items;

use App\Auth\DatabaseUserAuth;
use App\Auth\User;
use App\Paysafecard\Database\PaysafecardTable;
use App\Paysafecard\PaysafecardService;
use ClientX\Navigation\NavigationItemInterface;
use ClientX\Renderer\RendererInterface;
use ClientX\Session\SessionInterface;

class PaysafecardFundItem implements NavigationItemInterface
{
    private PaysafecardTable $table;
    private SessionInterface $session;
    private DatabaseUserAuth $auth;
    public function __construct(
        PaysafecardTable $table,
        DatabaseUserAuth $auth,
        SessionInterface $session
    )
    {
        $this->auth = $auth;
        $this->table = $table;
        $this->session = $session;
    }
    public function render(RendererInterface $renderer):string
    {
        
        $errors = $this->session->get(PaysafecardService::SESSION_KEY);
        $this->session->delete(PaysafecardService::SESSION_KEY);
        $paysafecards = $this->table->findForUser($this->auth->getUser()->getId());
        $values = PaysafecardService::VALUES;
        return $renderer->render("@paysafecard/index", compact('values', 'paysafecards', 'errors'));
    }

    public function getPosition():int
    {
        return 80;
    }
}
