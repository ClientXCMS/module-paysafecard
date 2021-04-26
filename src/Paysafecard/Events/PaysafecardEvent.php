<?php
namespace App\Paysafecard\Events;

use App\Paysafecard\Entity\Paysafecard;
use ClientX\Event\Event;

abstract class PaysafecardEvent extends Event {

    public function __construct(Paysafecard $paysafecard)
    {
        $this->setTarget($paysafecard);
    }
    public function getTarget(): Paysafecard
    {
        return parent::getTarget();
    }

}