<?php


namespace RServices\PayMix\Objects;


class TransactionData
{

    public static function make($amount, $description, $identifier, $payload = [])
    {
        return new static($amount, $description, $identifier, $payload);
    }

    private $description, $currency = 'EUR', $tax = 0, $amount, $identifier, $intent = 'sale', $payload, $quantity = 1;

    /**
     * TransactionData constructor.
     * @param $amount
     * @param $description
     * @param $identifier
     * @param $payload
     */
    public function __construct($amount, $description, $identifier, $payload = [])
    {
        $this->description = $description;
        $this->amount = $amount;
        $this->identifier = $identifier;
        $this->payload = $payload;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getTax(): int
    {
        return $this->tax;
    }

    /**
     * @param int $tax
     */
    public function setTax(int $tax): void
    {
        $this->tax = $tax;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param mixed $identifier
     */
    public function setIdentifier($identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getIntent(): string
    {
        return $this->intent;
    }

    /**
     * @param string $intent
     */
    public function setIntent(string $intent): void
    {
        $this->intent = $intent;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param mixed $payload
     */
    public function setPayload($payload): void
    {
        $this->payload = $payload;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

}
