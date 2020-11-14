<?php


namespace RServices\PayMix\Payments;


abstract class PaymentRepository implements PaymentRepositoryInterface
{

    protected $token, $paymentUri;

    /**
     * @return static
     */
    public static function instance()
    {
        return new static();
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    public function getPaymentUri()
    {
        return $this->paymentUri;
    }

}
