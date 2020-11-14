<?php


namespace RServices\PayMix\Payments\PayPal;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use RServices\PayMix\Objects\PaymentResponseType;
use RServices\PayMix\Objects\TransactionData;
use RServices\PayMix\Payments\PaymentRepository;
use RServices\PayMix\Payments\PaymentRepositoryInterface;

class PayPalRepositoryInterface extends PaymentRepository
{
    private ApiContext $apiContext;

    public function __construct()
    {
        $type = config('paymix.paypal.sandbox') ? 'sandbox' : 'live';
        $this->apiContext = new ApiContext(new OAuthTokenCredential(config("paymix.paypal.$type.client_id"), config("paymix.paypal.$type.client_secret")));
        $this->apiContext->setConfig(config('paymix.paypal.config'));
        return $this;
    }

    public function createTransaction(TransactionData $transactionData)
    {
        ($pp_details = new Details())->setTax($transactionData->getTax())->setSubtotal($transactionData->getAmount());

        ($item1 = new Item())->setName($transactionData->getDescription())->setCurrency($transactionData->getCurrency())
            ->setQuantity($transactionData->getQuantity())->setTax($transactionData->getTax())->setPrice($transactionData->getAmount());

        ($itemList = new ItemList())->setItems(compact('item1'));

        ($pp_amount = new Amount())->setCurrency($transactionData->getCurrency())->setTotal($transactionData->getAmount())->setDetails($pp_details);

        ($pp_payer = new Payer())->setPaymentMethod(array_key_exists('payment_method', $transactionData->getPayload())
            ? $transactionData->getPayload()['payment_method'] : 'PAYPAL');

        $pp_transaction = new Transaction();
        $pp_transaction->setAmount($pp_amount)->setInvoiceNumber($transactionData->getIdentifier())
            ->setItemList($itemList)->setDescription($transactionData->getDescription());

        $pp_urls = new RedirectUrls();
        $pp_urls->setReturnUrl(route(config('paymix.paypal.redirect_urls.return_url')))->setCancelUrl(
            route(config('paymix.paypal.redirect_urls.cancel_url'))
        );

        $pp_payment = new Payment();
        $pp_payment->setIntent($transactionData->getIntent())->setPayer($pp_payer)->setRedirectUrls($pp_urls)->setTransactions(compact('pp_transaction'));

        $pp_payment->create($this->apiContext);

        $this->paymentUri = $pp_payment->getApprovalLink();
        $this->token = $pp_payment->getToken();;

        return $this;
    }

    public function isPaid($token = null, $paymentId = null, $PayerID = null)
    {
        if (!$token || !$paymentId || !$PayerID) return PaymentResponseType::INVALID_PAYMENT;

        $payment = \PayPal\Api\Payment::get($paymentId = request()->get('paymentId'), $this->apiContext);
        $execution = new \PayPal\Api\PaymentExecution();
        $execution->setPayerId($PayerID);
        $payment->execute($execution, $this->apiContext);

        $payment = \PayPal\Api\Payment::get($paymentId, $this->apiContext);
        return $payment->state == 'approved' ? PaymentResponseType::SUCCESSFULLY_PAID : PaymentResponseType::PAYMENT_ABORT;
    }

    /**
     * @return ApiContext
     */
    public function getApiContext(): ApiContext
    {
        return $this->apiContext;
    }

    public function handleRequest(Request $request)
    {
        if (!$request->get('paymentId'))
            return PaymentResponseType::INVALID_PAYMENT;
        $validator = Validator::make($request->all(), [
            'paymentId' => 'required',
            'token' => 'required',
            'PayerID' => 'required',
        ]);
        if ($validator->fails()) return PaymentResponseType::INVALID_PAYMENT;
        return $this->isPaid($request->get('token'), $request->get('paymentId'), $request->get('PayerID'));
    }
}
