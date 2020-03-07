<?php

return [
    'algo' => env('JWT_ALGO'),
    'expiry' => env('JWT_EXPIRY'), // Expiry in seconds
    'secret' => env('JWT_SECRET')
];
