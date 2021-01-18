<?php
namespace App\Paysafecard\Entity;

use ClientX\Entity\Timestamp;

class Paysafecard
{

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $code;

    /**
     * @var int
     */
    private $value;

    /**
     * @var int
     */
    private $accountId;

    /**
     * @var int
     */
    private $status;
    
    use Timestamp;
    
    public function getId():int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getCode():string
    {
        return $this->code;
    }

    public function setCode(string $code)
    {
        $this->code = $code;
    }
    
    public function getValue():int
    {
        return $this->value;
    }

    public function setValue(int $value)
    {
        $this->value = $value;
    }

    public function getAccountId():int
    {
        return $this->accountId;
    }
    public function setAccountId(int $accountId)
    {
        $this->accountId = $accountId;
    }

    public function getStatus():int
    {
        return $this->status;
    }

    public function setStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }
}
