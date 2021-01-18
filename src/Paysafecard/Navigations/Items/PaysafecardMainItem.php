<?php
namespace App\Paysafecard\Navigations\Items;

use ClientX\Auth\User;
use ClientX\Navigation\NavigationItemInterface;
use ClientX\Renderer\RendererInterface;

class PaysafecardMainItem implements NavigationItemInterface
{
    
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }
    public function render(User $user = null):string
    {
        return $this->renderer->render("@paysafecard/menu_main");
    }

    public function getPosition():int
    {
        return 80;
    }
}
