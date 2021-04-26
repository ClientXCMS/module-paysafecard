<?php
namespace App\Paysafecard\Navigations\Items;

use ClientX\Auth\User;
use ClientX\Navigation\NavigationItemInterface;
use ClientX\Renderer\RendererInterface;

class PaysafecardMainItem implements NavigationItemInterface
{
    public function render(RendererInterface $renderer):string
    {
        return $renderer->render("@paysafecard/menu_main");
    }

    public function getPosition():int
    {
        return 80;
    }
}
