<?php

return [
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