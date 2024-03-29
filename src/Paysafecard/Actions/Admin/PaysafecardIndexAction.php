<?php

namespace App\Paysafecard\Actions\Admin;

use App\Paysafecard\Database\PaysafecardTable;
use App\Paysafecard\PaysafecardService;
use ClientX\Actions\Action;
use ClientX\Renderer\RendererInterface;
use ClientX\Router;
use Psr\Http\Message\ServerRequestInterface;

class PaysafecardIndexAction extends Action
{

    private PaysafecardTable $table;
    private PaysafecardService $paysafecards;

    public function __construct(
        PaysafecardTable $table,
        RendererInterface $renderer,
        Router $router,
        PaysafecardService $paysafecards

    )
    {
        $this->table = $table;
        $this->renderer = $renderer;
        $this->router = $router;
        $this->paysafecards = $paysafecards;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        if ($request->getMethod() === 'GET') {
            $this->renderer->addGlobal('moduleName', 'Paysafecard');
            $values = PaysafecardService::VALUES;
            $params = $request->getQueryParams();
            if (array_key_exists('pId', $params) && array_key_exists('new', $params) && is_int((int)$params['new']) && is_int((int)$params['pId'])) {
                $this->paysafecards->change($params['pId'], $params['new']);
            }
            $paysafecards = $this->table->makeQueryForAdmin([])->paginate(12, $request->getQueryParams()['p'] ?? 1);
            return $this->render("@paysafecard_admin/index", compact('paysafecards', 'values'));
        } elseif ($request->getMethod() === 'DELETE') {
            return $this->paysafecards->refuse($request->getAttribute('id'));
        } elseif ($request->getMethod() === 'POST') {
            return $this->paysafecards->accept($request->getAttribute('id'));
        }
    }
}