<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class AppointmentStatus extends Enum
{
    const Pending = 1;
    const Confirmed = 2;
    const Cancelled = 3;
    const Completed = 4;
}
