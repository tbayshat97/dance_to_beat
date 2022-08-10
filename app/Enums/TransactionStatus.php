<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TransactionStatus extends Enum
{
    const Pending = 1;
    const Success = 2;
    const Failed = 3;
}
