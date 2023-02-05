<?php

namespace App\Paysafecard;

use App\Admin\Settings\SettingsInterface;
use ClientX\Renderer\RendererInterface;
use ClientX\Validator;

class PaysafecardSetting implements SettingsInterface
{

    public function name(): string
    {
        return "paysafecard";
    }

    public function title(): string
    {
        return "Paysafecard";
    }

    public function icon(): string
    {
        return 'fas fa-credit-card';
    }

    public function render(RendererInterface $renderer)
    {
        return $renderer->render('@paysafecard_admin/setting');
    }

    public function validate(array $params): Validator
    {
        return (new Validator($params))->numericOrZero('tax_paysafecardmanual')->between('tax_paysafecardmanual', -1, 99);
    }
}