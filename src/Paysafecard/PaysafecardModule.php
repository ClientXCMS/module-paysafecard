<?php
namespace App\Paysafecard;

use App\Paysafecard\Actions\Admin\PaysafecardActiveIndexAction;
use App\Paysafecard\Actions\Admin\PaysafecardIndexAction as AdminPaysafecardIndexAction;
use App\Paysafecard\Actions\PaysafecardIndexAction;
use App\Paysafecard\Actions\PaysafecardSubmitAction;
use ClientX\Module;
use ClientX\Renderer\RendererInterface;
use ClientX\Router;
use ClientX\Theme\ThemeInterface;
use Psr\Container\ContainerInterface;

class PaysafecardModule extends Module
{

    const MIGRATIONS = __DIR__ . "/db/migrations";
    const DEFINITIONS = __DIR__ . '/config.php';
    const PAYSAFECARD_KEY = 'errors_paysafecard';
    const VALUES = [
        10   => "10€ (Vous donne 10 EUROS)",
        25   => "25€ (Vous donne 25 EUROS)",
        50   => "50€ (Vous donne 50 EUROS)",
        100  => "100€ (Vous donne 100 EUROS)",
    ];

    public function __construct(ContainerInterface $container, ThemeInterface $theme)
    {
        $container->get(RendererInterface::class)->addPath('paysafecard', $theme->getViewsPath() . '/Paysafecard');
        $container->get(RendererInterface::class)->addPath('paysafecard_admin', __DIR__ . '/Views');
        /** @var Router */
        $router = $container->get(Router::class);
        $prefix = $container->get('clientarea.prefix');
        $router->get($prefix . '/paysafecard', PaysafecardIndexAction::class, 'paysafecard');
        $router->post($prefix . '/paysafecard/submit', PaysafecardSubmitAction::class, 'paysafecard.submit');
        unset($prefix);
        if ($container->has('admin.prefix')) {
            $prefix = $container->get('admin.prefix');
        }
        $router->get($prefix . '/paysafecard', PaysafecardActiveIndexAction::class, 'paysafecard.admin.index');
        $router->get($prefix . '/paysafecards/all', AdminPaysafecardIndexAction::class, 'paysafecard.admin.all');
        $PPrefix = 'paysafecard.admin';
        $router->post($prefix . '/paysafecard/{id:\d+}', PaysafecardActiveIndexAction::class, $PPrefix .'.accept');
        $router->delete($prefix . '/paysafecard/{id:\d+}', PaysafecardActiveIndexAction::class, $PPrefix .'.refuse');
    }
}
