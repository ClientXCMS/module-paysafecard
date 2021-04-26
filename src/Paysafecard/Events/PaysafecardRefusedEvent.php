<?php
namespace App\Paysafecard\Events;

class PaysafecardRefusedEvent extends PaysafecardEvent {

    public $name = "paysafecard.refused";
}