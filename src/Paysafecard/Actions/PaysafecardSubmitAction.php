<?php

namespace App\Paysafecard\Actions;

use App\Paysafecard\PaysafecardService;
use ClientX\Actions\Action;
use ClientX\Router;
use Psr\Http\Message\ServerRequestInterface;

class PaysafecardSubmitAction extends Action
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
        $params = $request->getParsedBody();
        $validator = $this->paysafecard->validate($params);
        if ($validator->isValid()) {
            return $this->paysafecard->save($params);
        }
        return $this->redirectToRoute('fund.index');
    }
}
