<?php


namespace RServices\PayMix;


use RServices\PayMix\Payments\PaymentRepositoryInterface;
use RServices\PayMix\Payments\PayPal\PayPalRepositoryInterface;

class PayMix
{

    /**
     * @param string $method
     * @return static
     */
    public static function create($method = 'paypal')
    {
        return new static($method);
    }

    const PAYMENTS = ['paypal'];

    private $method;
    private PaymentRepositoryInterface $repository;

    public function __construct($method)
    {
        if (!in_array(strtolower($method), self::PAYMENTS))
            throw new \LogicException("$method is not yet implemented");
        $this->method = $method;
        $this->selectMethod();
    }

    function selectMethod()
    {
        switch ($this->method) {
            case "paypal":
                $this->repository = new PayPalRepositoryInterface();
                break;
        }
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method): void
    {
        $this->method = $method;
    }

    /**
     * @return PaymentRepositoryInterface
     */
    public function getRepository(): PaymentRepositoryInterface
    {
        return $this->repository;
    }

    /**
     * @param PaymentRepositoryInterface $repository
     */
    public function setRepository(PaymentRepositoryInterface $repository): void
    {
        $this->repository = $repository;
    }

}
