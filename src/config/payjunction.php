<?php

return [
    'host' => env('PJ_HOST', 'https://api.payjunctionlabs.com'), // defaults to sandbox host
    'app_key' => env('PJ_APP_KEY'), // needs the PJ app key, request with PJ support
    'username' => env('PJ_USERNAME', 'pj-ql-01'), // sandbox: https://developer.payjunction.com/hc/en-us
    'password' => env('PJ_PASSWORD', 'pj-ql-01p')
];
