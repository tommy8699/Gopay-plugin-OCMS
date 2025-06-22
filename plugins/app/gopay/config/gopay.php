<?php

return [
    'goid' => env('GOPAY_GOID', '1234567890'),
    'clientId' => env('GOPAY_CLIENT_ID', 'my-client-id'),
    'clientSecret' => env('GOPAY_CLIENT_SECRET', 'my-client-secret'),
    'isProduction' => env('GOPAY_IS_PRODUCTION', false),
    'returnUrl' => env('APP_URL') . '/thank-you',
    'notifyUrl' => env('APP_URL') . '/api/payment/callback',
];
