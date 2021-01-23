<?php
namespace App\Paysafecard\Actions;

use App\Paysafecard\Database\PaysafecardTable;
use App\Paysafecard\Entity\Paysafecard;
use App\Paysafecard\Events\PaysafecardStoreEvent;
use App\Paysafecard\PaysafecardModule;
use ClientX\Actions\Action;
use ClientX\Renderer\RendererInterface;
use ClientX\Session\FlashService;
use ClientX\Validator;
use ClientX\Auth;
use ClientX\Event\EventManager;
use ClientX\Router;
use ClientX\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface;

class PaysafecardSubmitAction extends Action
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
     * @var EventManager
     */
    private $manager;

    /**
     * @param RendererInterface
     * @param PaysafecardTable
     * @param Auth
     * @param SessionInterface
     * @param Router
     */
    public function __construct(
        RendererInterface $renderer,
        PaysafecardTable $table,
        Auth $auth,
        Router $router,
        SessionInterface $session,
        EventManager $manager
    ) {
        $this->session = $session;
        $this->renderer = $renderer;
        $this->table    = $table;
        $this->auth     = $auth;
        $this->router   = $router;
        $this->manager  = $manager;
        $this->flash    = new FlashService($session);
    }
    /**
     * @param ServerRequestInterface
     *
     * Gére la soumission du formulaire d'ajout de pin paysafecard
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $params = $request->getParsedBody();
        $validator = $this->getValidator($params);
        if ($validator->isValid()) {
            $id = $this->table->insert([
                'code' => $params['code'],
                'value' => $params['value'],
                'account_id' => $this->getUser()->getId(),
            ]);
            $this->success('Pin sauvegardée ! En attente de confirmation...');
            $paysafecard = new Paysafecard();
            $paysafecard->setId($id);
            $paysafecard->setCode($params['code']);
            $paysafecard->setValue($params['value']);
            $paysafecard->setAccountId($this->getUser()->getId());
            $paysafecard->setStatus(0);
            $this->manager->trigger(new PaysafecardStoreEvent($paysafecard));
            return $this->redirectToRoute('paysafecard');
        }
        $errors = $validator->getErrors();
        $this->session->set(PaysafecardModule::PAYSAFECARD_KEY, $errors);
        return $this->redirectToRoute('paysafecard');
    }
    /**
     * @param array
     *
     * Gére la validation des données
     */
    private function getValidator(array $params):Validator
    {
        return (new Validator($params))
            ->notEmpty('code', 'value')
            ->length('code', 16, 16)
            ->numeric('code')
            ->unique('code', $this->table);
    }
}
