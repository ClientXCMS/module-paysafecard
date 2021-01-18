<?php
namespace App\Paysafecard\Actions;

use App\Paysafecard\Database\PaysafecardTable;
use App\Paysafecard\PaysafecardModule;
use ClientX\Actions\Action;
use ClientX\Auth;
use ClientX\Renderer\RendererInterface;
use ClientX\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface;

class PaysafecardIndexAction extends Action
{

    /**
     * @var PaysafecardTable
     */
    private $table;

    /**
     * @var SessionInterface
     */
    private $session;
    
    /**
     * @param RendererInterface
     * @param PaysafecardTable
     * @param SessionInterface
     * @param Auth
     */
    public function __construct(
        RendererInterface $renderer,
        PaysafecardTable $table,
        SessionInterface $session,
        Auth $auth
    ) {
        $this->renderer = $renderer;
        $this->table    = $table;
        $this->session  = $session;
        $this->auth     = $auth;
    }
    /**
     * @param ServerRequestInterface
     */
    public function __invoke(ServerRequestInterface $request)
    {
        if ($request->getMethod() === 'GET') {
            $errors = $this->session->get(PaysafecardModule::PAYSAFECARD_KEY);
            $this->session->delete(PaysafecardModule::PAYSAFECARD_KEY);
            $paysafecards = $this->table->findForUser($this->getUser()->getId());
            $values = PaysafecardModule::VALUES;
            return $this->render("@paysafecard/index", compact('paysafecards', 'values', 'errors'));
        }
    }
}
