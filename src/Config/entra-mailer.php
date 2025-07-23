<?php

return [
    'client_id' => env('ENTRA_CLIENT_ID'),
    'client_secret' => env('ENTRA_CLIENT_SECRET'),
    'tenant_id' => env('ENTRA_TENANT_ID'),
    'from_address' => env('ENTRA_FROM_ADDRESS'),
    'from_name' => env('ENTRA_FROM_NAME', 'Entra Mailer'),
];