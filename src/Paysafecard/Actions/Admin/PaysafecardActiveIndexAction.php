<?php
namespace App\Paysafecard\Actions\Admin;

use App\Account\User;
use App\Auth\Database\UserTable;
use App\Paysafecard\Database\PaysafecardTable;
use App\Paysafecard\Entity\Paysafecard;
use ClientX\Actions\RouterAwareAction;
use ClientX\Database\NoRecordException;
use ClientX\Renderer\RendererInterface;
use ClientX\Router;
use Psr\Http\Message\ServerRequestInterface;

class PaysafecardActiveIndexAction
{

    /**
     * @var PaysafecardTable
     */
    private $table;
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var UserTable
     */
    private $userTable;
    
    use RouterAwareAction;
    public function __construct(
        PaysafecardTable $table,
        RendererInterface $renderer,
        Router $router,
        UserTable $userTable
    ) {
        $this->table     = $table;
        $this->renderer  = $renderer;
        $this->router    = $router;
        $this->userTable = $userTable;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        if ($request->getMethod() === 'GET') {
            $this->renderer->addGlobal('moduleName', 'Paysafecard');
            $paysafecards = $this->table->makeQuery()
                    ->where('status = 0')
                    ->paginate(12, $request->getQueryParams()['p'] ?? 1);
            return $this->renderer->render("@paysafecard_admin/admin/index", compact('paysafecards'));
        } elseif ($request->getMethod() === 'DELETE') {
            $this->refuse($request);
        } elseif ($request->getMethod() === 'POST') {
            $this->accept($request);
        }
        return $this->redirect('paysafecard.admin.index');
    }

    private function refuse(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        try {
            /** @var Paysafecard */
            $paysafecard = $this->table->find($id);
            $this->table->updateStatus(2, $paysafecard->getId());
            $this->table->update($paysafecard->getId(), [
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } catch (NoRecordException $e) {
        }
    }

    private function accept(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        try {
            /** @var Paysafecard */
            $paysafecard = $this->table->find($id);
            /** @var User */
            $user = $this->userTable->find($paysafecard->getAccountId());
            $user->addFund($paysafecard->getValue());
            $this->userTable->update($user->getId(), [
                'wallet' => $user->getWallet()
            ]);
            $this->table->updateStatus(1, $paysafecard->getId());
        } catch (NoRecordException $e) {
        }
    }
}
