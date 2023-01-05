<?php

return [
    'apiKey' => env('ADYEN_API_KEY', null),
    'username' => env('ADYEN_USERNAME', null),
    'password' => env('ADYEN_PASSWORD', null),
    'bpLemUser' => env('BALANCE_ACCOUNT_LEM_USER', null),
    'bpLemPassword' => env('BALANCE_ACCOUNT_LEM_PASSWORD', null),
    'bpBalanceUser' => env('BALANCE_ACCOUNT_BP_USER', null),
    'bpBalancePassword' => env('BALANCE_ACCOUNT_BP_PASSWORD', null),
    'bpPspUser' => env('BALANCE_ACCOUNT_PSP_USER', null),
    'bpPspPassword' => env('BALANCE_ACCOUNT_PSP_PASSWORD', null)
];
