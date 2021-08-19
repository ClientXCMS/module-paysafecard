<?php

namespace App\Paysafecard;

use App\Account\User;
use App\Admin\Database\SettingTable;
use App\Admin\DatabaseAdminAuth;
use App\Auth\Database\UserTable;
use App\Paysafecard\Database\PaysafecardTable;
use App\Paysafecard\Entity\Paysafecard;
use App\Paysafecard\Events\PaysafecardAcceptedEvent;
use App\Paysafecard\Events\PaysafecardCancelledEvent;
use App\Paysafecard\Events\PaysafecardRefusedEvent;
use App\Paysafecard\Events\PaysafecardStoredEvent;
use App\Paysafecard\Events\PaysafecardUpdatedEvent;
use ClientX\Actions\Traits\AuthTrait;
use ClientX\Actions\Traits\EventTrait;
use ClientX\Actions\Traits\FlashTrait;
use ClientX\Actions\Traits\RouterTrait;
use ClientX\Actions\Traits\TranslaterTrait;
use ClientX\Auth;
use ClientX\Database\NoRecordException;
use ClientX\Event\EventManager;
use ClientX\Router;
use ClientX\Session\FlashService;
use ClientX\Session\SessionInterface;
use ClientX\Translator\Translater;
use ClientX\Validator;
use GuzzleHttp\Psr7\Response;

class PaysafecardService
{

    private PaysafecardTable $paysafecard;
    private SessionInterface $session;
    private UserTable $user;
    private DatabaseAdminAuth $adminAuth;
    use EventTrait;
    use FlashTrait;
    use TranslaterTrait;
    use RouterTrait;
    use AuthTrait;

    const SESSION_KEY = "_paysafecard_errors";
    const VALUES = [10 => 10, 25 => 25, 50 => 50, 100 => 100];

    public function __construct(
        PaysafecardTable $paysafecard,
        UserTable $user,
        EventManager $event,
        SessionInterface $session,
        Router $router,
        Translater $translater,
        Auth $auth,
        DatabaseAdminAuth $adminAuth,
        SettingTable $table
    )
    {
        $this->paysafecard = $paysafecard;
        $this->user = $user;
        $this->adminAuth = $adminAuth;
        $this->flash = new FlashService($session);
        $this->session = $session;
        $this->translater = $translater;
        $this->auth = $auth;
        $this->router = $router;
        $this->event = $event;
        $this->tax = $table->findSetting("tax_paysafecardmanual", 0);
    }

    public function setState(Paysafecard $paysafecard)
    {
        $this->trigger(new PaysafecardUpdatedEvent($paysafecard));
        if ($paysafecard->getState() === Paysafecard::REFUSED) {
            $this->trigger(new PaysafecardRefusedEvent($paysafecard));
        }
        if ($paysafecard->getState() === Paysafecard::ACCEPTED) {
            $this->trigger(new PaysafecardAcceptedEvent($paysafecard));
        }

        if ($paysafecard->getState() === Paysafecard::CANCELLED) {
            $this->trigger(new PaysafecardCancelledEvent($paysafecard));
        }
        $this->paysafecard->updateState($paysafecard->getId(), $paysafecard->getState());
    }

    public function save(array $params)
    {
        $paysafecard = new Paysafecard();
        $paysafecard->setPin($params['pin'])
            ->setValue($params['value'])
            ->setUserId($this->getUserId());
        $id = $this->paysafecard->create($paysafecard);
        $paysafecard->setId($id);
        $this->trigger(new PaysafecardStoredEvent($paysafecard));
        $this->success($this->trans("paysafecard.success"), ['%wallet%' => $paysafecard->giveback($this->getTax())]);
        return $this->redirectToRoute('paysafecard.index');

    }

    public function accept(int $id)
    {

        /** @var Paysafecard */
        $paysafecard = $this->paysafecard->find($id);
        $paysafecard->setState(Paysafecard::ACCEPTED);
        $this->setState($paysafecard);
        $this->success($this->trans("paysafecard.accept"));
        try {
            /** @var User */
            $user = $this->user->find($paysafecard->getUserId());
            $user->addFund($paysafecard->giveback($this->getTax()));
            $paysafecard->setAdminId($this->adminAuth->getUser()->getId());
            $paysafecard->setVerifiedAt('now');
            $this->paysafecard->saveAdmin($paysafecard);
        } catch (NoRecordException $e) {
        }
        return $this->redirectToRoute('admin.paysafecard.index');
    }

    public function refuse(int $id)
    {

        /** @var Paysafecard */
        $paysafecard = $this->paysafecard->find($id);
        $paysafecard->setState(Paysafecard::REFUSED);
        $this->setState($paysafecard);
        $this->success($this->trans("paysafecard.refuse"));
        $paysafecard->setAdminId($this->adminAuth->getUser()->getId());
        $paysafecard->setVerifiedAt('now');
        $this->paysafecard->saveAdmin($paysafecard);
        return $this->redirectToRoute('admin.paysafecard.index');
    }

    public function cancel(int $id)
    {
        /** @var Paysafecard */
        $paysafecard = $this->paysafecard->find($id);
        $paysafecard->setState(Paysafecard::CANCELLED);
        if ($paysafecard->getUserId() != $this->getUserId() && $this->adminAuth->getUser() === null) {
            return new Response(404);
        }
        $this->setState($paysafecard);
        $this->success($this->trans("paysafecard.cancel"));
        if ($this->adminAuth->getUser() === null) {
            return $this->redirectToRoute('paysafecard.index');
        }
        return $this->redirectToRoute('admin.paysafecard.index');
    }

    public function validate(array $params)
    {
        $validator = (new Validator($params))
            ->notEmpty('pin', 'value')
            ->length('pin', 16, 16)
            ->numeric('pin')
            ->unique('pin', $this->paysafecard);
        if ($validator->isValid() == false) {
            $this->session->set(self::SESSION_KEY, $validator->getErrors());
        }
        return $validator;
    }

    private function getTax(): int
    {
        return $this->tax;
    }
}