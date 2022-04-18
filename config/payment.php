<?php

return [
    'methods' => explode(',', env('PAYMENT_METHODS', 'cash')),
];
