<?php

namespace App\Models\Constants;

class OrderStatus
{
        public const NEW = 'new';
        public const PAYMENT_PENDING = 'payment_pending';
        public const PAYMENT_FAILED = 'payment_failed';
        public const PAYED = 'payed';
        public const CANCELED = 'canceled';
}
