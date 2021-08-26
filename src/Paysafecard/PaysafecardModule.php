<?php

namespace App\Paysafecard;

use App\Paysafecard\Actions\Admin\PaysafecardActiveIndexAction;
use App\Paysafecard\Actions\Admin\PaysafecardIndexAction as AdminPaysafecardIndexAction;
use App\Paysafecard\Actions\PaysafecardCancelAction;
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
    const TRANSLATIONS = [
        "fr_FR" => __DIR__ . "/trans/fr.php",
        "en_GB" => __DIR__ . "/trans/en.php",
    ];

    public function __construct(ContainerInterface $container, ThemeInterface $theme, RendererInterface $renderer, Router $router)
    {
        $renderer->addPath('paysafecard', $theme->getViewsPath() . '/Paysafecard');
        $router->group($container->get('clientarea.prefix') . '/paysafecard', 'paysafecard')
            ->get('', PaysafecardIndexAction::class, 'index')
            ->delete('/[i:id]/cancel', PaysafecardCancelAction::class, 'cancel')
            ->post('/submit', PaysafecardSubmitAction::class, 'submit');
        if ($container->has('admin.prefix')) {
            $renderer->addPath('paysafecard_admin', __DIR__ . '/Views');
            $router->group($container->get('admin.prefix') . '/paysafecard', 'paysafecard.admin')
                ->get('', AdminPaysafecardIndexAction::class, 'index')
                ->post('/[i:id]', AdminPaysafecardIndexAction::class, 'accept')
                ->delete('/[i:id]', AdminPaysafecardIndexAction::class, 'refuse');
        }
    }
}
