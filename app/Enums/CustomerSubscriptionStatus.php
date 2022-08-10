<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CustomerSubscriptionStatus extends Enum
{
    const Pending = 1;
    const Paid = 2;
    const Ended = 3;
}
