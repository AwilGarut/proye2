<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Server Key
    |--------------------------------------------------------------------------
    |
    | This is the server key used to authenticate with Midtrans API.
    |
    */

    'server_key' => env('MIDTRANS_SERVER_KEY', ''),


    /*
    |--------------------------------------------------------------------------
    | Midtrans Client Key
    |--------------------------------------------------------------------------
    |
    | This is the client key used for frontend integration.
    |
    */

    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),


    /*
    |--------------------------------------------------------------------------
    | Midtrans Environment
    |--------------------------------------------------------------------------
    |
    | This value determines whether to use production or sandbox environment.
    | Set to true if you are using sandbox.
    |
    */

    'sandbox' => env('MIDTRANS_SANDBOX', true),
];