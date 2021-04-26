<?php
namespace App\Paysafecard\Events;

class PaysafecardAcceptedEvent extends PaysafecardEvent {

    public $name = "paysafecard.accept";
}