<?php

namespace App\Paysafecard\Entity;

use ClientX\Entity\Timestamp;
use DateTime;

class Paysafecard
{


    private int $id;
    private int $value;
    private string $pin;
    private ?int $adminId;
    private int $userId;
    private string $state = self::PENDING;
    private ?string $lastState;
    private ?\DateTime $verifiedAt = null;

    const PENDING = "Pending";
    const ACCEPTED = "Accepted";
    const REFUSED = "Refused";
    const CANCELLED = "Cancelled";

    use Timestamp;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value)
    {
        $this->value = $value;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;

        return $this;
    }

    public function getPin()
    {
        return $this->pin;
    }

    public function setPin(string $pin)
    {
        $this->pin = $pin;

        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }


    public function setState($state)
    {
        if ($this->state) {
            $this->lastState = $this->state;
        }
        $this->state = $state;

        return $this;
    }


    public function getLastState(): ?string
    {
        return $this->lastState;
    }

    public function giveback($taxe)
    {
        if (is_null($taxe)) {
            return $this->value;
        }
        return $this->value - (($taxe * $this->value) / 100);
    }


    public function getAdminId(): ?int
    {
        return $this->adminId;
    }

    public function setAdminId($adminId)
    {
        $this->adminId = $adminId;

        return $this;
    }

    public function getVerifiedAt(): ?\DateTime
    {
        return $this->verifiedAt;
    }

    public function setVerifiedAt($verifiedAt)
    {
        if ($verifiedAt != null) {
            $this->verifiedAt = new DateTime($verifiedAt);
        }

        return $this;
    }
}
