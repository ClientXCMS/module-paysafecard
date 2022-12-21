<?php

namespace App\Paysafecard;

use App\Paysafecard\Actions\Admin\PaysafecardIndexAction as AdminPaysafecardIndexAction;
use App\Paysafecard\Actions\PaysafecardCancelAction;
use App\Paysafecard\Actions\PaysafecardSubmitAction;
use ClientX\Module;
use ClientX\ModuleCache;
use App\Fund\FundModule;
use ClientX\Renderer\RendererInterface;
use ClientX\Router;
use ClientX\Session\FlashService;
use ClientX\Session\SessionInterface;

use ClientX\Helpers\Str;
use ClientX\Theme\ThemeInterface;
use Psr\Container\ContainerInterface;

use function ClientX\request;

class PaysafecardModule extends Module
{

    const MIGRATIONS = __DIR__ . "/db/migrations";
    const DEFINITIONS = __DIR__ . '/config.php';

    public function __construct(ContainerInterface $container, ThemeInterface $theme, RendererInterface $renderer, Router $router)
    {
        $renderer->addPath('paysafecard', $theme->getViewsPath() . '/Paysafecard');
        $router->group($container->get('clientarea.prefix') . '/paysafecard', 'paysafecard')
            ->delete('/[i:id]/cancel', PaysafecardCancelAction::class, 'cancel')
            ->post('/submit', PaysafecardSubmitAction::class, 'submit');
        if ($container->has('admin.prefix')) {
            $renderer->addPath('paysafecard_admin', __DIR__ . '/Views');
            $router->group($container->get('admin.prefix') . '/paysafecard', 'paysafecard.admin')
                ->get('', AdminPaysafecardIndexAction::class, 'index')
                ->post('/[i:id]', AdminPaysafecardIndexAction::class, 'accept')
                ->delete('/[i:id]', AdminPaysafecardIndexAction::class, 'refuse');
        }
        $modules = (new ModuleCache())->getModulesEnabled();
        if (!in_array(FundModule::class, $modules)) {
            $session = $container->get(SessionInterface::class);
            if (Str::startsWith(request()->getUri()->getPath(), '/admin')) {
                (new FlashService($session))->error('The Paysafecard Module require the Fund Module to work');
            }
        }
    }
}
