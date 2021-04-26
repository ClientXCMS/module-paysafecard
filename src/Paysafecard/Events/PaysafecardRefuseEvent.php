<?php
namespace App\Paysafecard\Events;

class PaysafecardRefuseEvent extends PaysafecardEvent {

    public $name = "paysafecard.refuse";
}