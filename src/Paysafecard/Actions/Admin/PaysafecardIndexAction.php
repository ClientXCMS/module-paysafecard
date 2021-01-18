<?php
namespace App\Paysafecard\Actions\Admin;

use App\Paysafecard\Database\PaysafecardTable;
use ClientX\Renderer\RendererInterface;
use ClientX\Router;
use Psr\Http\Message\ServerRequestInterface;

class PaysafecardIndexAction
{

    /**
     * @var PaysafecardTable
     */
    private $table;
    /**
     * @var RendererInterface
     */
    private $renderer;
    
    public function __construct(
        PaysafecardTable $table,
        RendererInterface $renderer,
        Router $router
    ) {
        $this->table     = $table;
        $this->renderer  = $renderer;
        $this->router    = $router;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        if ($request->getMethod() === 'GET') {
            $this->renderer->addGlobal('moduleName', 'Paysafecard');
            $paysafecards = $this->table->makeQuery()->paginate(12, $request->getQueryParams()['p'] ?? 1);
            return $this->renderer->render("@paysafecard_admin/admin/all", compact('paysafecards'));
        }
    }
}
