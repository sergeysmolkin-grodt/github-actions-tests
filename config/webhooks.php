<?php

return [
    'paypal_events' => [
        'created' => 'BILLING.SUBSCRIPTION.CREATED',
        'activated' => 'BILLING.SUBSCRIPTION.ACTIVATED',
        'cancelled' => 'BILLING.SUBSCRIPTION.CANCELLED',
        'suspended' => 'BILLING.SUBSCRIPTION.SUSPENDED',
        'payment_completed' => 'PAYMENT.SALE.COMPLETED',
        'payment_failed' => 'BILLING.SUBSCRIPTION.PAYMENT.FAILED'
    ],
];
