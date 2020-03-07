<?php

return [
    'secret' => env('JWT_SECRET'),
    'expiry' => env('JWT_EXPIRY') // Expiry in seconds
];
