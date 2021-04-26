<?php

namespace App\Paysafecard\Actions;

use App\Paysafecard\PaysafecardService;
use ClientX\Actions\Action;
use ClientX\Router;
use Psr\Http\Message\ServerRequestInterface;

class PaysafecardCancelAction extends Action
{
    private PaysafecardService $paysafecard;
    public function __construct(
        PaysafecardService $paysafecard,
        Router $router
    ) {
        $this->paysafecard = $paysafecard;
        $this->router = $router;
    }
    public function __invoke(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        return $this->paysafecard->cancel($id);
    }
}
