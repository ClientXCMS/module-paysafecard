<?php
namespace App\Paysafecard\Events;

class PaysafecardCancelledEvent extends PaysafecardEvent {

    public $name = "paysafecard.cancelled";
}