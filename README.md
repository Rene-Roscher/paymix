# Simplified Payments of many Providers | Laravel Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rene-roscher/paymix.svg?style=flat-square)](https://packagist.org/packages/rene-roscher/paymix)
[![Quality Score](https://img.shields.io/scrutinizer/g/rene-roscher/paymix.svg?style=flat-square)](https://scrutinizer-ci.com/g/rene-roscher/paymix)
[![Total Downloads](https://img.shields.io/packagist/dt/rene-roscher/paymix.svg?style=flat-square)](https://packagist.org/packages/rene-roscher/paymix)

## Installation

You can install the package via composer:

```bash
composer require rene-roscher/paymix
```

## Usage

``` php

php artisan vendor:publish --provider="RServices\PayMix\PaymixServiceProvider"

```
``` php
// Create Payment
use

$repo = \RServices\PayMix\PayMix::create('PAYPAL')->getRepository();
or
$repo = \paymix('PAYPAL');

/** @return PaymentRepositoryInterface */
$repo->createTransaction(\RServices\PayMix\Objects\TransactionData::make(14.99, 'Movie XY', \Illuminate\Support\Str::random(6)));
// redirect user to payment provider
$repo->getPaymentUri();
```

``` php
// Callback
/** @return string|PaymentResponseType */
$state = \RServices\PayMix\PayMix::create()->getRepository()->handleRequest(\request());

if ($state == \RServices\PayMix\Objects\PaymentResponseType::SUCCESSFULLY_PAID)
    return 'successfully paid the movie xy';

```

## Configuration

``` php
[
    'paypal' => [
        'live' => [
            'client_id' => env('PAYMIX_PAYPAL_CLIENT_ID'),
            'client_secret' => env('PAYMIX_PAYPAL_CLIENT_SECRET'),
        ],
        'sandbox' => [
            'client_id' => env('PAYMIX_SANDBOX_PAYPAL_CLIENT_ID'),
            'client_secret' => env('PAYMIX_SANDBOX_PAYPAL_CLIENT_SECRET'),
        ],
        'config' => [
            'mode' => 'sandbox',
            'log.LogEnabled' => TRUE,
            'log.FileName' => storage_path('paypal.log'),
            'log.LogLevel' => 'FINE',
            'validation.level' => 'log',
            'cache.enabled' => TRUE,
            'cache.FileName' => storage_path('paypal-cache.log'),
        ],
        'redirect_urls' => [
			// Named-Route
            'return_url' => 'payment.paid.successfully',
            'cancel_url' => 'payment.paid.failured',
        ]
    ],
];
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.