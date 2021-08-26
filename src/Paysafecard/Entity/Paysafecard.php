<?php

namespace App\Paysafecard\Entity;

use App\Shop\Entity\Orderable;
use App\Shop\Entity\Recurring;
use ClientX\Entity\Timestamp;
use ClientX\Entity\Username;
use DateTime;

class Paysafecard implements Orderable
{


    private int $id;
    private int $value;
    private string $pin;
    private ?int $adminId;
    private int $userId;

    private ?int $transactionId = null;
    private string $state = self::PENDING;
    private ?string $lastState;
    private ?\DateTime $verifiedAt = null;

    use Username;

    const PENDING = "Pending";
    const ACCEPTED = "Accepted";
    const REFUSED = "Refused";
    const CANCELLED = "Cancelled";
    /**
     * @var int|mixed|null
     */
    public ?int $tax = null;

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

    public function getTransactionId(): ?int
    {
        return $this->transactionId;
    }

    public function setTransactionId(?int $transactionId = null): void
    {
        $this->transactionId = $transactionId;
    }

    public function getName(): ?string
    {
        return "Paysafecard Transfert to wallet";
    }

    public function getDescription(): ?string
    {
        return null;
    }

    public function getPrice(string $recurring = Recurring::MONTHLY, bool $setup = false, array $options = [])
    {
        if ($setup) {
            return 0;
        }
        return $this->giveback($this->tax);
    }

    public function inStock(): bool
    {
        return true;
    }

    public function getRecurring(): Recurring
    {
        return Recurring::onetime();
    }

    public function getPaymentType(): string
    {
        return 'onetime';
    }

    public function hasAutoterminate(): bool
    {
        return false;
    }

    public function canRecurring(): bool
    {
        return false;
    }

    public function getAutoTerminateAt(): ?DateTime
    {
        return null;
    }

    public function getExpireAt(): ?DateTime
    {
        return null;
    }

    public function getTable(): string
    {
        return "paysafecards";
    }

    public function getType(): string
    {
        return "paysafecards";
    }
}
