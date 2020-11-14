<?php


namespace RServices\PayMix\Payments;


use Illuminate\Http\Request;
use RServices\PayMix\Objects\TransactionData;

interface PaymentRepositoryInterface
{

    public static function instance();

    /**
     * @param TransactionData $transactionData
     * @return self
     */
    public function createTransaction(TransactionData $transactionData);

    /**
     * @param null $token
     * @param null $paymentId
     * @param null $PayerID
     * @return mixed|string
     */
    public function isPaid($token = null, $paymentId = null, $PayerID = null);

    public function getPaymentUri();

    public function getToken();

    public function handleRequest(Request $request);

}
