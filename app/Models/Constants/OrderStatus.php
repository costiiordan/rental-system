<?php

namespace App\Models\Constants;

class OrderStatus
{
        public const WAITING_PICKUP = 'waiting_pickup';
        public const PAYMENT_PENDING = 'payment_pending';
        public const PAYMENT_FAILED = 'payment_failed';
        public const COMPLETED = 'completed';
        public const CANCELED = 'canceled';
}
