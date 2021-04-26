<?php
namespace App\Paysafecard;

use ClientX\Payment\PaymentTypeInterface;

class PaysafecardPaymentType implements PaymentTypeInterface
{

    public function getName(): string
    {
        return "paysafecardmanual";
    }
    public function getTitle(): ?string
    {
        return "Paysafecard";
    }

    public function getManager(): string
    {
        return '';
    }

    public function getLogPath(): string
    {
        return "paysafecard.admin.index";
    }

    public function getIcon():string
    {
        return "fa fa-credit-card";
    }

    public function canPayWith(): bool
    {
        return false;
    }
}
