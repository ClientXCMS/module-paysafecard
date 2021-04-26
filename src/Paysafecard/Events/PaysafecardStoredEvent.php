<?php
namespace App\Paysafecard\Events;

class PaysafecardStoredEvent extends PaysafecardEvent {

    public $name = "paysafecard.stored";
}