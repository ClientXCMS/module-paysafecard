<?php

namespace App\Paysafecard\Actions;

use App\Paysafecard\Database\PaysafecardTable;
use App\Paysafecard\PaysafecardService;
use ClientX\Actions\Action;
use ClientX\Auth;
use ClientX\Renderer\RendererInterface;
use ClientX\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface;

class PaysafecardIndexAction extends Action
{
    private PaysafecardTable $table;
    public function __construct(
        RendererInterface $renderer,
        PaysafecardTable $table,
        Auth $auth,
        SessionInterface $session
    ) {
        $this->renderer = $renderer;
        $this->auth = $auth;
        $this->table    = $table;
        $this->session = $session;
    }
    public function __invoke(ServerRequestInterface $request)
    {
        $errors = $this->session->get(PaysafecardService::SESSION_KEY);
        $errors = $this->session->delete(PaysafecardService::SESSION_KEY);
        $paysafecards = $this->table->findForUser($this->getUserId());
        $values = PaysafecardService::VALUES;
        return $this->render("@paysafecard/index", compact('paysafecards', 'values', 'errors'));
    }
}
